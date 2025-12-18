<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Before filter callback
     * Se ejecuta antes de cada acción del controlador
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Permitir acceso a buscarUsuarios para usuarios autenticados
        // No se agrega a unauthenticatedActions porque debe requerir login
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Este método valida que solo usuarios con rol de administrador (rol=1)
         * puedan acceder al listado completo de usuarios del sistema.
         * Si el acceso es denegado, redirige automáticamente según el rol.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        // Obtener filtro de estado desde URL (por defecto: activo)
        $filtroEstado = $this->request->getQuery('estado', 'activo');
        
        $query = $this->Users->find()
            ->contain(['Titular']); // Cargar relación con titulares
        
        // Aplicar filtro por estado
        if ($filtroEstado === 'todos') {
            // Mostrar todos los usuarios (activos e inactivos)
            // No agregar condición WHERE
        } elseif ($filtroEstado === 'inactivo') {
            // Solo usuarios inactivos (desactivados)
            $query->where(['Users.estado' => 'inactivo']);
        } else {
            // Solo usuarios activos (por defecto)
            $query->where(['Users.estado' => 'activo']);
        }

        // Filtro de búsqueda por término (username o DNI)
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'OR' => [
                    'Users.username LIKE' => '%' . $termino . '%',
                    'Users.dni LIKE' => '%' . $termino . '%'
                ]
            ]);
        }
        
        $users = $this->paginate($query);

        // Definir los roles para la vista
        $roles = [
            1 => 'Administrador',
            2 => 'Docente',
            3 => 'Estudiante'
        ];

        $this->set(compact('users', 'roles', 'filtroEstado'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método puedeEditar() del trait ControlAccesoRoles.
         * Permite que un usuario visualice su propio perfil, o que un administrador
         * pueda ver cualquier perfil. Si el usuario intenta ver un perfil ajeno
         * sin ser administrador, se le redirige a su propio perfil.
         */
        $user = $this->Users->get($id, contain: ['Titular']);
        
        // DEBUG: Verificar si se está cargando el titular
        if ($user->titular_id) {
            $this->log("User ID: {$user->id}, Titular ID: {$user->titular_id}, Has Titular: " . (!empty($user->titular) ? 'YES' : 'NO'), 'debug');
            if (!empty($user->titular)) {
                $this->log("Titular Nombre: {$user->titular->nombre_completo}", 'debug');
            } else {
                $this->log("ERROR: Titular no está cargado aunque titular_id = {$user->titular_id}", 'error');
            }
        }
        
        $usuarioActual = $this->obtenerUsuarioActual();
        
        // Verificar si el usuario puede ver este perfil
        if (!$this->puedeEditar((int)$id)) {
            $this->Flash->error(__('Solo puede visualizar su propio perfil.'));
            return $this->redirect(['action' => 'view', $usuarioActual->id]);
        }
        
        $this->set(compact('user'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     if ($this->request->is('ajax')) {
         *         $this->set('error_message', 'No tienes permisos para realizar esta acción');
         *         $this->viewBuilder()->setLayout('ajax');
         *         return;
         *     }
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden crear nuevos usuarios en el sistema.
         * Maneja tanto solicitudes normales como AJAX de manera unificada.
         * 
         * Vinculación automática con Titulares:
         * - Si el DNI existe en titulares → vincula automáticamente
         * - Si el DNI NO existe → crea titular mínimo (DNI + nombres extraídos de username)
         * - Valida que el titular no esté ya vinculado a otro usuario (UNIQUE constraint)
         */
        if ($redirect = $this->requiereAdministrador()) {
            // Manejar respuesta AJAX si es necesario
            if ($this->request->is('ajax')) {
                $this->set('error_message', 'No tienes permisos para realizar esta acción');
                $this->viewBuilder()->setLayout('ajax');
                return;
            }
            return $redirect;
        }
        
        $titularesTable = $this->fetchTable('Titulares');
        $user = $this->Users->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // DEBUG: Ver qué datos llegan
            $this->log('Datos recibidos en add(): ' . json_encode($data), 'debug');
            
            // Procesar vinculación con titular SIEMPRE que tenga DNI y nombre_completo
            if (!empty($data['dni']) && !empty($data['nombre_completo'])) {
                $dni = trim($data['dni']);
                $nombreCompleto = trim($data['nombre_completo']);
                
                $this->log("Procesando titular: DNI={$dni}, Nombre={$nombreCompleto}", 'debug');
                
                // Buscar titular existente por DNI
                $titular = $titularesTable->buscarPorDni($dni);
                
                if ($titular) {
                    $this->log("Titular existente encontrado: ID={$titular->id}", 'debug');
                    
                    // Verificar que el titular no esté ya vinculado a otro usuario
                    if ($titularesTable->tieneUsuarioVinculado($titular->id)) {
                        $this->Flash->error(__('Este DNI ya está vinculado a otro usuario del sistema.'));
                        $this->set(compact('user'));
                        return;
                    }
                    
                    // Vincular usuario con titular existente
                    $data['titular_id'] = $titular->id;
                    $this->log("Usuario vinculado a titular existente ID={$titular->id}", 'debug');
                } else {
                    $this->log("Titular no existe, creando nuevo...", 'debug');
                    
                    // Crear titular automáticamente
                    $nuevoTitular = $titularesTable->buscarOCrear($dni, $nombreCompleto);
                    if ($nuevoTitular) {
                        $data['titular_id'] = $nuevoTitular->id;
                        $this->log("Nuevo titular creado con ID={$nuevoTitular->id}", 'debug');
                    } else {
                        $this->log("ERROR: No se pudo crear el titular", 'error');
                        $this->Flash->error(__('No se pudo crear el registro de titular.'));
                        $this->set(compact('user'));
                        return;
                    }
                }
            } else {
                $this->log("ADVERTENCIA: DNI o nombre_completo vacío. No se vinculará titular.", 'warning');
            }
            
            $this->log("Guardando usuario con titular_id=" . ($data['titular_id'] ?? 'NULL'), 'debug');
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario guardado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
            $errors = $user->getErrors();
            $this->log('Error al guardar usuario: ' . json_encode($errors), 'error');
            $this->Flash->error(__('No se pudo guardar el usuario. Por favor, verifique los datos e inténtelo nuevamente.'));
        }
        
        $this->set(compact('user'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     if ($this->request->is('ajax')) {
         *         $this->set('error_message', 'No tienes permisos para realizar esta acción');
         *         $this->viewBuilder()->setLayout('ajax');
         *         return;
         *     }
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método puedeEditar() del trait ControlAccesoRoles.
         * Permite que un usuario edite su propio perfil, o que un administrador
         * pueda editar cualquier perfil. Esto mejora la flexibilidad permitiendo
         * que los usuarios gestionen su propia información.
         * 
         * Restricción de DNI:
         * - Si el usuario tiene titular_id vinculado, solo admin puede cambiar DNI
         * - Estudiantes no pueden cambiar DNI si ya está vinculado (protección de identidad)
         */
        $titularesTable = $this->fetchTable('Titulares');
        $user = $this->Users->get($id, contain: ['Titular']);
        $usuarioActual = $this->obtenerUsuarioActual();
        $esAdmin = $usuarioActual->rol == 1;
        
        // Verificar si el usuario puede editar este perfil
        if (!$this->puedeEditar((int)$id)) {
            if ($this->request->is('ajax')) {
                $this->set('error_message', 'Solo puede editar su propio perfil');
                $this->viewBuilder()->setLayout('ajax');
                return;
            }
            $this->Flash->error(__('Solo puede editar su propio perfil.'));
            return $this->redirect(['action' => 'edit', $usuarioActual->id]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Si la contraseña está vacía, removerla para no sobrescribir la existente
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            // Separar datos que pertenecen a Titulares
            $nombreCompleto = $data['nombre_completo'] ?? null;
            unset($data['nombre_completo']); // Remover de datos de Users
            
            // Proteger edición de DNI si el usuario tiene titular vinculado
            if (!$esAdmin && $user->titular_id && isset($data['dni']) && $data['dni'] != $user->dni) {
                $this->Flash->error(__('No puede cambiar el DNI porque está vinculado a un titular. Contacte al administrador.'));
                unset($data['dni']); // Remover cambio de DNI
            }
            
            // Actualizar vinculación con titular si cambian DNI o nombre_completo
            if (!empty($data['dni']) && !empty($nombreCompleto)) {
                $nuevoDni = trim($data['dni']);
                $nuevoNombre = trim($nombreCompleto);
                
                // Solo procesar si el DNI cambió o si no tiene titular
                if ($data['dni'] != $user->dni || !$user->titular_id) {
                    // Buscar si existe titular con el nuevo DNI
                    $titular = $titularesTable->buscarPorDni($nuevoDni);
                    
                    if ($titular) {
                        // Verificar que no esté vinculado a otro usuario
                        if ($titularesTable->tieneUsuarioVinculado($titular->id) && $titular->id != $user->titular_id) {
                            $this->Flash->error(__('El DNI {0} ya está vinculado a otro usuario.', [$nuevoDni]));
                            $this->set(compact('user', 'esAdmin'));
                            return;
                        }
                        $data['titular_id'] = $titular->id;
                        // Actualizar nombre en titular existente
                        $titular->nombre_completo = $nuevoNombre;
                        $titularesTable->save($titular);
                    } else {
                        // Crear nuevo titular
                        $nuevoTitular = $titularesTable->buscarOCrear($nuevoDni, $nuevoNombre);
                        if ($nuevoTitular) {
                            $data['titular_id'] = $nuevoTitular->id;
                        }
                    }
                } elseif ($user->titular_id && isset($user->titular) && $user->titular && $nombreCompleto != $user->titular->nombre_completo) {
                    // Si solo cambió el nombre, actualizar titular existente
                    $titular = $titularesTable->get($user->titular_id);
                    $titular->nombre_completo = $nuevoNombre;
                    $titularesTable->save($titular);
                }
            }
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el usuario. Por favor, inténtelo nuevamente.'));
        }
        
        // Recargar usuario con su relación a Titular para la vista
        $user = $this->Users->get($user->id, contain: ['Titular']);
        
        $this->set(compact('user', 'esAdmin'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $roles = [1, 2, 3];
         * if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     $this->Flash->error(__('No tienes permiso para acceder a esta página'));
         *     return $this->redirect(['controller' => 'Users', 'action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar usuarios del sistema.
         * Esto elimina la validación redundante y centraliza la lógica de autorización.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        
        // Proteger al administrador principal (ID 1)
        if ($user->id == 1) {
            $this->Flash->error(__('No se puede desactivar el administrador principal del sistema.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // Soft delete: cambiar estado a 'inactivo' en lugar de eliminar
        $user->estado = 'inactivo';
        
        if ($this->Users->save($user)) {
            $this->Flash->success(__('Usuario desactivado correctamente. Puede reactivarlo desde el filtro de inactivos.'));
        } else {
            $this->Flash->error(__('No se pudo desactivar el usuario. Por favor, inténtelo nuevamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->viewBuilder()->setLayout('login'); // Usar el layout 'login'
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->find()->where(['username' => $data['username']])->first();

            if (!$user) {
                $this->Flash->error('El usuario no existe');
            } elseif ($user && !$result->isValid()) {
                $this->Flash->error('Contraseña incorrecta');
            }
        }

        if ($result->isValid()) {
            $user = $this->request->getAttribute('identity');
            if (isset($user) && ($user->get('estado') === 'inactivo' || $user->get('estado') === 'deshabilitado')) {
                $this->Authentication->logout();
                $this->Flash->error(__('Su usuario está inactivo o deshabilitado. Por favor, comuníquese con un administrador.'));
                return $this->redirect(['action' => 'login']);
            }
            // Redirigir al home (dashboard de bienvenida)
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
            $result = $this->Authentication->getResult(); // Ensure $result is defined
    }
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success('You have been logged out');
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Reactivar usuario inactivo
     * Cambia el estado de 'inactivo' a 'activo'
     * 
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function reactivar($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post', 'put']);
        $user = $this->Users->get($id);
        
        // Verificar que el usuario esté inactivo
        if ($user->estado === 'inactivo') {
            $user->estado = 'activo';
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario reactivado correctamente. Ahora puede iniciar sesión.'));
            } else {
                $this->Flash->error(__('No se pudo reactivar el usuario. Por favor, inténtelo nuevamente.'));
            }
        } else {
            $this->Flash->warning(__('El usuario ya está activo en el sistema.'));
        }
        
        // Redirigir a lista de inactivos para verificar
        return $this->redirect(['action' => 'index', '?' => ['estado' => 'inactivo']]);
    }

    /**
     * Buscar usuarios por username o DNI (AJAX)
     * Método para búsqueda dinámica en tiempo real
     * Búsqueda case-insensitive (sin distinción mayúsculas/minúsculas)
     * 
     * @return \Cake\Http\Response JSON con resultados
     */
    public function buscarUsuarios()
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setLayout('ajax');
        
        $termino = $this->request->getQuery('termino');
        $resultados = [];
        
        if (!empty($termino) && strlen($termino) >= 2) { // Mínimo 2 caracteres
            $resultados = $this->Users->find()
                ->select(['id', 'username', 'dni', 'rol', 'estado', 'created'])
                ->where([
                    'OR' => [
                        'Users.username LIKE' => '%' . $termino . '%',
                        'Users.dni LIKE' => '%' . $termino . '%'
                    ]
                ])
                ->order(['Users.username' => 'ASC'])
                ->limit(15)
                ->toArray();
        }
        
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($resultados, JSON_UNESCAPED_UNICODE));
        
        return $this->response;
    }

    /**
     * Buscar alumnos por DNI ÚNICAMENTE (AJAX)
     * Búsqueda solo por DNI, mínimo 4 caracteres, máximo 3 resultados
     * 
     * @return \Cake\Http\Response JSON con resultados
     */
    public function buscarAlumnos()
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setLayout('ajax');
        
        $dni = $this->request->getQuery('dni');
        $resultados = [];
        
        if (!empty($dni) && strlen($dni) >= 4) {
            // Buscar usuarios estudiantes con titular vinculado - SOLO POR DNI
            $resultados = $this->Users->find()
                ->contain(['Titulares']) // Cargar datos del titular
                ->select([
                    'Users.id',
                    'Users.username',
                    'Users.dni',
                    'Users.titular_id',
                    'Titulares.id',
                    'Titulares.dni',
                    'Titulares.nombre_completo'
                ])
                ->where([
                    'Users.rol' => 3, // 3 = Estudiante
                    'Users.estado' => 'activo',
                    'Users.titular_id IS NOT' => null, // Solo usuarios con titular
                    'Titulares.dni LIKE' => $dni . '%' // SOLO DNI que EMPIECE con el término
                ])
                ->order(['Titulares.dni' => 'ASC'])
                ->limit(3) // MÁXIMO 3 RESULTADOS
                ->toArray();
        }
        
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($resultados, JSON_UNESCAPED_UNICODE));
        
        return $this->response;
    }
}

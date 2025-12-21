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
        
        $query = $this->Users->find();
        
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
        $user = $this->Users->get($id);
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
        
        $user = $this->Users->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario guardado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
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
         */
        $user = $this->Users->get($id);
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
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuario actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el usuario. Por favor, inténtelo nuevamente.'));
        }
        
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
}

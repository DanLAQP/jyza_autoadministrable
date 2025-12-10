<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Inscripciones Controller
 *
 * @property \App\Model\Table\InscripcionesTable $Inscripciones
 */
class InscripcionesController extends AppController
{
    /**
     * beforeFilter method
     * 
     * Configuración específica de acceso para InscripcionesController.
     * 
     * Roles y permisos:
     * - Estudiantes (role_id = 3): Pueden add (solicitar), view (solo propias), misInscripciones
     * - Docentes (role_id = 2): Pueden index, view, aprobar, rechazar
     * - Admins (role_id = 1): Acceso total
     * 
     * @param \Cake\Event\EventInterface $event El evento beforeFilter
     * @return void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Authentication->getIdentity();
        
        if ($user && $user->rol == 3) {
            // Estudiantes: solo pueden add, view y misInscripciones
            $allowedActions = ['add', 'view', 'misInscripciones'];
            
            if (!in_array($this->request->getParam('action'), $allowedActions)) {
                $this->Flash->error(__('No tienes permiso para acceder a esta sección.'));
                return $this->redirect(['action' => 'misInscripciones']);
            }
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        /**
         * Listado de inscripciones para administradores y docentes.
         * 
         * El control de acceso se maneja en beforeFilter(), por lo que
         * este método solo es accesible para admin y docentes.
         * Los estudiantes son redirigidos automáticamente a misInscripciones().
         */
        
        $query = $this->Inscripciones->find()
            ->contain(['Users', 'Cursos']);
        
        // Filtrar por estado si se proporciona
        $estado = $this->request->getQuery('estado');
        if ($estado && in_array($estado, ['pendiente', 'aprobada', 'rechazada'])) {
            $query = $query->where(['Inscripciones.estado' => $estado]);
        }
        
        // Ordenar por más recientes primero
        $query = $query->orderBy(['Inscripciones.created' => 'DESC']);
        
        $inscripciones = $this->paginate($query);

        $this->set(compact('inscripciones'));
    }

    /**
     * View method
     *
     * @param string|null $id Inscripcione id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        /**
         * Nueva implementación con control de acceso:
         * Permite que administradores y docentes vean cualquier inscripción.
         * Los estudiantes solo pueden ver sus propias inscripciones.
         * Esto protege la privacidad de los datos de inscripción.
         */
        $inscripcione = $this->Inscripciones->get($id, contain: ['Users', 'Cursos']);
        $usuarioActual = $this->obtenerUsuarioActual();
        
        // Verificar permisos: admin/docente pueden ver todo, estudiante solo lo suyo
        if (!$this->esAdministrador() && !$this->esDocente()) {
            if ($inscripcione->usuario_id != $usuarioActual->id) {
                $this->Flash->error(__('No tiene permiso para visualizar esta inscripción.'));
                return $this->redirect(['controller' => 'Cursos', 'action' => 'student']);
            }
        }
        
        $this->set(compact('inscripcione'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inscripcione = $this->Inscripciones->newEmptyEntity();
        $usuarioActual = $this->getRequest()->getAttribute('identity');
        $cursoId = $this->request->getQuery('curso_id');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $esEstudiante = ($usuarioActual->rol == 3);
            
            if ($esEstudiante) {
                /**
                 * Flujo para estudiantes: Solicitud con validaciones estrictas.
                 * 
                 * Cambios implementados:
                 * 1. Forzar valores seguros (no pueden manipular usuario_id, estado, etc.)
                 * 2. Validar que el curso exista antes de crear la inscripción
                 * 3. Verificar duplicados de cualquier estado
                 */
                
                // Forzar valores seguros
                $data['usuario_id'] = $usuarioActual->id;
                $data['progreso'] = 0;
                $data['estado'] = 'pendiente';
                
                // Validar que el curso exista
                $cursoIdValue = $cursoId ?? $data['curso_id'] ?? null;
                if (!$cursoIdValue) {
                    $this->Flash->error(__('Debe seleccionar un curso.'));
                    $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
                    $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
                    $this->set(compact('inscripcione', 'users', 'cursos', 'cursoId', 'usuarioActual'));
                    return;
                }
                
                $curso = $this->Inscripciones->Cursos->find()
                    ->where(['id' => $cursoIdValue])
                    ->first();
                
                if (!$curso) {
                    $this->Flash->error(__('El curso seleccionado no existe.'));
                    return $this->redirect(['controller' => 'Cursos', 'action' => 'student']);
                }
                
                $data['curso_id'] = $cursoIdValue;
                
                // Verificar inscripción duplicada (cualquier estado)
                $solicitudExistente = $this->Inscripciones->find()
                    ->where([
                        'usuario_id' => $usuarioActual->id,
                        'curso_id' => $cursoIdValue
                    ])
                    ->first();
                
                if ($solicitudExistente) {
                    if ($solicitudExistente->estado == 'aprobada') {
                        $this->Flash->error(__('Ya estás inscrito en este curso.'));
                    } elseif ($solicitudExistente->estado == 'pendiente') {
                        $this->Flash->error(__('Ya tienes una solicitud pendiente para este curso.'));
                    } else {
                        $this->Flash->error(__('Tu solicitud anterior fue rechazada. Contacta al administrador para más información.'));
                    }
                    return $this->redirect(['controller' => 'Cursos', 'action' => 'view', $cursoIdValue]);
                }
                
            } else {
                /**
                 * Flujo para admin/docente: Creación directa con validaciones.
                 * 
                 * Cambios implementados:
                 * 1. Validar existencia de usuario y curso
                 * 2. Verificar duplicados antes de crear
                 * 3. Validar rango de progreso (0-100)
                 */
                
                // Validar que usuario y curso existan
                if (empty($data['usuario_id']) || empty($data['curso_id'])) {
                    $this->Flash->error(__('Debe seleccionar usuario y curso.'));
                    $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
                    $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
                    $this->set(compact('inscripcione', 'users', 'cursos', 'cursoId', 'usuarioActual'));
                    return;
                }
                
                $usuarioExiste = $this->Inscripciones->Users->exists(['id' => $data['usuario_id']]);
                $cursoExiste = $this->Inscripciones->Cursos->exists(['id' => $data['curso_id']]);
                
                if (!$usuarioExiste || !$cursoExiste) {
                    $this->Flash->error(__('Usuario o curso inválido.'));
                    $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
                    $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
                    $this->set(compact('inscripcione', 'users', 'cursos', 'cursoId', 'usuarioActual'));
                    return;
                }
                
                // Verificar duplicados
                $inscripcionExistente = $this->Inscripciones->find()
                    ->where([
                        'usuario_id' => $data['usuario_id'],
                        'curso_id' => $data['curso_id']
                    ])
                    ->first();
                
                if ($inscripcionExistente) {
                    $this->Flash->error(__('Ya existe una inscripción para este usuario en este curso.'));
                    $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
                    $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
                    $this->set(compact('inscripcione', 'users', 'cursos', 'cursoId', 'usuarioActual'));
                    return;
                }
                
                // Validar progreso
                if (isset($data['progreso'])) {
                    $data['progreso'] = max(0, min(100, (int)$data['progreso']));
                }
            }
            
            // Guardar la inscripción
            $inscripcione = $this->Inscripciones->patchEntity($inscripcione, $data);
            
            if ($this->Inscripciones->save($inscripcione)) {
                if ($esEstudiante) {
                    $this->Flash->success(__('¡Tu solicitud de inscripción ha sido enviada! Espera la aprobación del administrador.'));
                    return $this->redirect(['action' => 'misInscripciones']);
                } else {
                    $this->Flash->success(__('Inscripción creada exitosamente.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('No se pudo completar la solicitud de inscripción. Por favor, intenta nuevamente.'));
        }
        
        // Pre-llenar datos si viene del curso
        if ($cursoId && $usuarioActual) {
            $inscripcione->curso_id = $cursoId;
            $inscripcione->usuario_id = $usuarioActual->id;
            $inscripcione->progreso = 0;
            $inscripcione->estado = 'pendiente';
        }
        
        $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
        $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
        $this->set(compact('inscripcione', 'users', 'cursos', 'cursoId', 'usuarioActual'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inscripcione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        /**
         * Nueva implementación con control de acceso:
         * Utiliza el método requiereAdministradorODocente() del trait ControlAccesoRoles.
         * Solo los administradores y docentes pueden modificar inscripciones existentes.
         * Esto incluye cambiar estados, progreso y demás campos de la inscripción.
         */
        if ($redirect = $this->requiereAdministradorODocente()) {
            return $redirect;
        }
        
        $inscripcione = $this->Inscripciones->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscripcione = $this->Inscripciones->patchEntity($inscripcione, $this->request->getData());
            if ($this->Inscripciones->save($inscripcione)) {
                $this->Flash->success(__('The inscripcione has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscripcione could not be saved. Please, try again.'));
        }
        $users = $this->Inscripciones->Users->find('list', limit: 200)->all();
        $cursos = $this->Inscripciones->Cursos->find('list', limit: 200)->all();
        $this->set(compact('inscripcione', 'users', 'cursos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inscripcione id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /**
         * Nueva implementación con control de acceso:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar inscripciones del sistema.
         * Esta es una acción crítica que requiere los máximos privilegios.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $inscripcione = $this->Inscripciones->get($id);
        if ($this->Inscripciones->delete($inscripcione)) {
            $this->Flash->success(__('The inscripcione has been deleted.'));
        } else {
            $this->Flash->error(__('The inscripcione could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Aprobar solicitud de inscripción
     *
     * @param string|null $id ID de la inscripción
     * @return \Cake\Http\Response
     */
    public function aprobar($id = null)
    {
        /**
         * Método mejorado con validaciones completas:
         * 
         * 1. Valida que la inscripción exista
         * 2. Verifica que esté en estado 'pendiente' antes de aprobar
         * 3. Inicializa el progreso en 0%
         * 4. Proporciona feedback detallado con nombres de usuario y curso
         * 5. Control de acceso mediante trait ControlAccesoRoles
         */
        if ($redirect = $this->requiereAdministradorODocente()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post']);
        
        try {
            $inscripcione = $this->Inscripciones->get($id, contain: ['Users', 'Cursos']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('La inscripción no existe.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // Validar que esté en estado pendiente
        if ($inscripcione->estado !== 'pendiente') {
            $estadoActual = ucfirst($inscripcione->estado);
            $this->Flash->warning(__('Esta inscripción ya fue procesada. Estado actual: {0}', $estadoActual));
            return $this->redirect(['action' => 'view', $id]);
        }
        
        $inscripcione->estado = 'aprobada';
        $inscripcione->progreso = 0; // Iniciar en 0%
        
        if ($this->Inscripciones->save($inscripcione)) {
            $nombreEstudiante = $inscripcione->user->nombre;
            $nombreCurso = $inscripcione->curso->titulo;
            $this->Flash->success(__('Inscripción aprobada. {0} ahora puede acceder al curso "{1}".', $nombreEstudiante, $nombreCurso));
        } else {
            $this->Flash->error(__('No se pudo aprobar la inscripción. Por favor, intenta nuevamente.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Rechazar solicitud de inscripción
     *
     * @param string|null $id ID de la inscripción
     * @return \Cake\Http\Response
     */
    public function rechazar($id = null)
    {
        /**
         * Nueva implementación con control de acceso:
         * Utiliza el método requiereAdministradorODocente() del trait ControlAccesoRoles.
         * Solo los administradores y docentes pueden rechazar solicitudes de inscripción.
         * Esto garantiza un control adecuado sobre quién puede denegar accesos a cursos.
         */
        if ($redirect = $this->requiereAdministradorODocente()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post']);
        
        try {
            $inscripcione = $this->Inscripciones->get($id, contain: ['Users', 'Cursos']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('La inscripción no existe.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // Validar que esté en estado pendiente
        if ($inscripcione->estado !== 'pendiente') {
            $estadoActual = ucfirst($inscripcione->estado);
            $this->Flash->warning(__('Esta inscripción ya fue procesada. Estado actual: {0}', $estadoActual));
            return $this->redirect(['action' => 'view', $id]);
        }
        
        $inscripcione->estado = 'rechazada';
        
        if ($this->Inscripciones->save($inscripcione)) {
            $nombreEstudiante = $inscripcione->user->nombre;
            $nombreCurso = $inscripcione->curso->titulo;
            $this->Flash->success(__('Inscripción de {0} al curso "{1}" ha sido rechazada.', $nombreEstudiante, $nombreCurso));
        } else {
            $this->Flash->error(__('No se pudo rechazar la inscripción. Por favor, intenta nuevamente.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Mis Inscripciones - Vista para estudiantes
     * 
     * Método específico para que estudiantes vean únicamente sus propias
     * inscripciones con información relevante de su progreso académico.
     * 
     * Características:
     * - Muestra solo inscripciones del usuario actual
     * - Incluye estadísticas personales (total, aprobadas, pendientes, progreso)
     * - Permite filtrar por estado
     * - Acceso exclusivo para estudiantes (admin/docente redirigen a index)
     * 
     * @return \Cake\Http\Response|null|void
     */
    public function misInscripciones()
    {
        $usuarioActual = $this->obtenerUsuarioActual();
        
        // Admin y docentes deben usar index()
        if ($this->esAdministrador() || $this->esDocente()) {
            return $this->redirect(['action' => 'index']);
        }
        
        $query = $this->Inscripciones->find()
            ->where(['Inscripciones.usuario_id' => $usuarioActual->id])
            ->contain(['Cursos' => ['Modulos']])
            ->orderBy(['Inscripciones.created' => 'DESC']);
        
        // Filtrar por estado si se solicita
        $estado = $this->request->getQuery('estado');
        if ($estado && in_array($estado, ['pendiente', 'aprobada', 'rechazada'])) {
            $query->where(['Inscripciones.estado' => $estado]);
        }
        
        $inscripciones = $this->paginate($query);
        
        // Calcular estadísticas del estudiante
        $estadisticas = [
            'total' => $this->Inscripciones->find()
                ->where(['usuario_id' => $usuarioActual->id])
                ->count(),
            'aprobadas' => $this->Inscripciones->find()
                ->where(['usuario_id' => $usuarioActual->id, 'estado' => 'aprobada'])
                ->count(),
            'pendientes' => $this->Inscripciones->find()
                ->where(['usuario_id' => $usuarioActual->id, 'estado' => 'pendiente'])
                ->count(),
            'rechazadas' => $this->Inscripciones->find()
                ->where(['usuario_id' => $usuarioActual->id, 'estado' => 'rechazada'])
                ->count()
        ];
        
        // Calcular progreso promedio solo de cursos aprobados
        $progresoPromedio = $this->Inscripciones->find()
            ->where(['usuario_id' => $usuarioActual->id, 'estado' => 'aprobada'])
            ->select(['promedio' => $query->func()->avg('progreso')])
            ->first();
        
        $estadisticas['progreso_promedio'] = $progresoPromedio ? round($progresoPromedio->promedio, 2) : 0;
        
        $this->set(compact('inscripciones', 'estadisticas', 'estado'));
    }
}

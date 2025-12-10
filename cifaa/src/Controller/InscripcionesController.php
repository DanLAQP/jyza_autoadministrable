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
     * CORRECIÓN CRÍTICA: Control de acceso estricto por rol.
     * 
     * Este método sobrescribe el beforeFilter de AppController
     * para establecer permisos específicos del módulo de inscripciones.
     * 
     * Permisos por rol:
     * - Admin (role_id = 1): Acceso total sin restricciones
     * - Docente (role_id = 2): index, view, aprobar, rechazar, edit
     * - Estudiante (role_id = 3): SOLO view (propias) y misInscripciones
     * 
     * IMPORTANTE: Los estudiantes NO pueden:
     * - Acceder a add() (deben solicitar desde la vista del curso)
     * - Acceder a index() (ver todas las inscripciones)
     * - Aprobar o rechazar inscripciones
     * - Editar o eliminar inscripciones
     * 
     * @param \Cake\Event\EventInterface $event El evento beforeFilter
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Authentication->getIdentity();
        
        if (!$user) {
            return null; // Usuario no autenticado, dejar que Authentication maneje
        }
        
        $action = $this->request->getParam('action');
        
        // PERMISOS POR ROL
        
        if ($user->rol == 3) {
            // ESTUDIANTES: Solo pueden ver sus propias inscripciones
            $accionesPermitidasEstudiante = ['view', 'misInscripciones'];
            
            if (!in_array($action, $accionesPermitidasEstudiante)) {
                $this->Flash->error(__('No tienes permiso para acceder a esta sección. Las solicitudes de inscripción se realizan desde la vista del curso.'));
                return $this->redirect(['controller' => 'Cursos', 'action' => 'student']);
            }
        } 
        elseif ($user->rol == 2) {
            // DOCENTES: Pueden gestionar inscripciones pero no eliminar
            $accionesPermitidasDocente = ['index', 'view', 'aprobar', 'rechazar', 'edit'];
            
            if (!in_array($action, $accionesPermitidasDocente)) {
                $this->Flash->error(__('No tienes permiso para realizar esta acción.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        // Admin (rol = 1): Sin restricciones adicionales
        
        return null;
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
    /**
     * Add method
     * 
     * CAMBIO IMPORTANTE: Este método ahora es SOLO para Admin y Docente.
     * Los estudiantes solicitan inscripción desde la vista del curso (CursosController::solicitar).
     * 
     * Proceso:
     * 1. Valida que usuario y curso existan
     * 2. Verifica que no haya inscripción duplicada
     * 3. Valida rango de progreso (0-100)
     * 4. Crea la inscripción en el estado especificado
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        /**
         * Verificación de permisos: Solo admin y docente pueden crear inscripciones directamente.
         * Los estudiantes usan el flujo de solicitud desde el curso (beforeFilter ya los bloqueó).
         */
        if ($redirect = $this->requiereAdministradorODocente()) {
            return $redirect;
        }
        
        $inscripcione = $this->Inscripciones->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Validar que usuario y curso existan
            if (empty($data['usuario_id']) || empty($data['curso_id'])) {
                $this->Flash->error(__('Debe seleccionar usuario y curso.'));
                
                $users = $this->Inscripciones->Users->find('list', [
                    'conditions' => ['rol' => 3],
                    'limit' => 200
                ])->all();
                $cursos = $this->Inscripciones->Cursos->find('list', ['limit' => 200])->all();
                $this->set(compact('inscripcione', 'users', 'cursos'));
                return;
            }
            
            $usuarioExiste = $this->Inscripciones->Users->exists(['id' => $data['usuario_id']]);
            $cursoExiste = $this->Inscripciones->Cursos->exists(['id' => $data['curso_id']]);
            
            if (!$usuarioExiste || !$cursoExiste) {
                $this->Flash->error(__('Usuario o curso inválido.'));
                
                $users = $this->Inscripciones->Users->find('list', [
                    'conditions' => ['rol' => 3],
                    'limit' => 200
                ])->all();
                $cursos = $this->Inscripciones->Cursos->find('list', ['limit' => 200])->all();
                $this->set(compact('inscripcione', 'users', 'cursos'));
                return;
            }
            
            // Verificar inscripción duplicada
            $inscripcionExistente = $this->Inscripciones->find()
                ->where([
                    'usuario_id' => $data['usuario_id'],
                    'curso_id' => $data['curso_id']
                ])
                ->first();
            
            if ($inscripcionExistente) {
                $this->Flash->error(__('Ya existe una inscripción para este usuario en este curso.'));
                
                $users = $this->Inscripciones->Users->find('list', [
                    'conditions' => ['rol' => 3],
                    'limit' => 200
                ])->all();
                $cursos = $this->Inscripciones->Cursos->find('list', ['limit' => 200])->all();
                $this->set(compact('inscripcione', 'users', 'cursos'));
                return;
            }
            
            // Validar progreso (0-100)
            if (isset($data['progreso'])) {
                $data['progreso'] = max(0, min(100, (int)$data['progreso']));
            } else {
                $data['progreso'] = 0;
            }
            
            // Guardar la inscripción
            $inscripcione = $this->Inscripciones->patchEntity($inscripcione, $data);
            
            if ($this->Inscripciones->save($inscripcione)) {
                $this->Flash->success(__('Inscripción creada exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('No se pudo completar la inscripción. Por favor, intenta nuevamente.'));
        }
        
        // Preparar datos para el formulario (solo estudiantes activos)
        $users = $this->Inscripciones->Users->find('list', [
            'conditions' => ['rol' => 3],
            'limit' => 200
        ])->all();
        $cursos = $this->Inscripciones->Cursos->find('list', ['limit' => 200])->all();
        
        $this->set(compact('inscripcione', 'users', 'cursos'));
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

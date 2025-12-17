<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Modulos Controller
 *
 * @property \App\Model\Table\ModulosTable $Modulos
 */
class ModulosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Modulos->find()
            ->contain(['Cursos']);
        
        // Filtrar por curso si se proporciona el parámetro
        $cursoId = $this->request->getQuery('curso_id');
        if ($cursoId) {
            $query->where(['Modulos.curso_id' => $cursoId]);
            
            // Obtener datos del curso para mostrar en la vista
            $curso = $this->Modulos->Cursos->get($cursoId);
            $this->set('curso', $curso);
        }
        
        $modulos = $this->paginate($query);

        $this->set(compact('modulos', 'cursoId'));
    }

    /**
     * View method
     *
     * @param string|null $id Modulo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modulo = $this->Modulos->get($id, contain: ['Cursos', 'Lecciones']);
        
        // Verificar inscripción al curso
        $inscrito = $this->verificarInscripcion($modulo->curso_id);
        
        if (!$inscrito) {
            // Obtener usuario actual
            $usuario = $this->getRequest()->getAttribute('identity');
            $tieneSolicitud = false;
            
            // Verificar si ya existe una solicitud pendiente o rechazada
            if ($usuario) {
                $inscripcionesTable = $this->fetchTable('Inscripciones');
                $solicitud = $inscripcionesTable->find()
                    ->where([
                        'usuario_id' => $usuario->id,
                        'curso_id' => $modulo->curso_id,
                        'estado !=' => 'aprobada'
                    ])
                    ->first();
                
                $tieneSolicitud = !empty($solicitud);
            }
            
            // Pasar datos para mostrar modal
            $this->set([
                'modulo' => $modulo,
                'curso' => $modulo->curso,
                'noInscrito' => true,
                'tieneSolicitud' => $tieneSolicitud,
                'cursoId' => $modulo->curso_id
            ]);
            return;
        }
        
        $this->set(compact('modulo'));
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
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para crear módulos.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden crear módulos dentro de los cursos.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $modulo = $this->Modulos->newEmptyEntity();
        if ($this->request->is('post')) {
            $modulo = $this->Modulos->patchEntity($modulo, $this->request->getData());
            if ($this->Modulos->save($modulo)) {
                $this->Flash->success(__('The modulo has been saved.'));
                
                // Redirigir a la vista del curso para continuar editando
                $cursoId = $this->request->getQuery('curso_id');
                if (!$cursoId && $modulo->curso_id) {
                    $cursoId = $modulo->curso_id;
                }
                
                if ($cursoId) {
                    return $this->redirect([
                        'controller' => 'Cursos',
                        'action' => 'view',
                        $cursoId,
                        '?' => ['tab' => 'contenido']
                    ]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modulo could not be saved. Please, try again.'));
        }
        $cursos = $this->Modulos->Cursos->find('list')->all();
        
        // Pre-seleccionar el curso si viene como parámetro
        $cursoId = $this->request->getQuery('curso_id');
        if ($cursoId) {
            $modulo->curso_id = $cursoId;
            
            // Obtener módulos existentes del curso
            $modulosExistentes = $this->Modulos->find()
                ->where(['curso_id' => $cursoId])
                ->order(['posicion' => 'ASC'])
                ->all();
            
            // Sugerir siguiente posición
            $siguientePosicion = $modulosExistentes->count() + 1;
            $modulo->posicion = $siguientePosicion;
            
            $this->set(compact('modulosExistentes', 'siguientePosicion'));
        }
        
        $this->set(compact('modulo', 'cursos', 'cursoId'));
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
     * @param string|null $id Modulo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para editar módulos.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden editar módulos existentes.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $modulo = $this->Modulos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modulo = $this->Modulos->patchEntity($modulo, $this->request->getData());
            if ($this->Modulos->save($modulo)) {
                $this->Flash->success(__('The modulo has been saved.'));

                // Redirigir al curso con la pestaña de contenido
                return $this->redirect([
                    'controller' => 'Cursos',
                    'action' => 'view',
                    $modulo->curso_id,
                    '?' => ['tab' => 'contenido']
                ]);
            }
            $this->Flash->error(__('The modulo could not be saved. Please, try again.'));
        }
        $cursos = $this->Modulos->Cursos->find('list')->all();
        $this->set(compact('modulo', 'cursos'));
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
     * @param string|null $id Modulo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para eliminar módulos.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar módulos del sistema.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $modulo = $this->Modulos->get($id);
        $cursoId = $modulo->curso_id;
        
        // NOTA: Modulos no tiene campo estado, aplicar eliminación física
        // Si se desea soft delete, agregar campo 'estado' a la tabla modulos
        if ($this->Modulos->delete($modulo)) {
            $this->Flash->success(__('Módulo eliminado correctamente.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el módulo. Verifique las dependencias.'));
        }

        // Redirigir al curso con la pestaña de contenido
        return $this->redirect([
            'controller' => 'Cursos',
            'action' => 'view',
            $cursoId,
            '?' => ['tab' => 'contenido']
        ]);
    }
}

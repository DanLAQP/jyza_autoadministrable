<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Lecciones Controller
 *
 * @property \App\Model\Table\LeccionesTable $Lecciones
 */
class LeccionesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Lecciones->find()
            ->contain(['Modulos' => ['Cursos']]);
        
        // Filtrar por curso si se proporciona el parámetro
        $cursoId = $this->request->getQuery('curso_id');
        if ($cursoId) {
            $query->matching('Modulos', function ($q) use ($cursoId) {
                return $q->where(['Modulos.curso_id' => $cursoId]);
            });
            
            // Obtener datos del curso para mostrar en la vista
            $curso = $this->fetchTable('Cursos')->get($cursoId);
            $this->set('curso', $curso);
        }
        
        $lecciones = $this->paginate($query);

        $this->set(compact('lecciones', 'cursoId'));
    }

    /**
     * View method
     *
     * @param string|null $id Leccion id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // Cargar lección con todas las relaciones necesarias para vista tipo Domestika
        $leccion = $this->Lecciones->get($id, [
            'contain' => [
                'Modulos' => [
                    'Cursos',
                    'Lecciones' => [
                        'sort' => ['Lecciones.posicion' => 'ASC']
                    ]
                ],
                'ContenidosLeccion' => [
                    'sort' => ['ContenidosLeccion.posicion' => 'ASC']
                ]
            ]
        ]);
        
        // Verificar inscripción
        $inscrito = $this->verificarInscripcionLeccion($id);
        
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
                        'curso_id' => $leccion->modulo->curso_id,
                        'estado !=' => 'aprobada'
                    ])
                    ->first();
                
                $tieneSolicitud = !empty($solicitud);
            }
            
            // Pasar datos para mostrar modal
            $this->set([
                'leccion' => $leccion,
                'modulo' => $leccion->modulo,
                'curso' => $leccion->modulo->curso,
                'noInscrito' => true,
                'tieneSolicitud' => $tieneSolicitud,
                'cursoId' => $leccion->modulo->curso_id
            ]);
            return;
        }
        
        $this->set(compact('leccion'));
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
         *     $this->Flash->error(__('No tienes permisos para crear lecciones.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden crear lecciones dentro de los módulos.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $leccione = $this->Lecciones->newEmptyEntity();
        $moduloId = $this->request->getQuery('modulo_id');
        
        if ($this->request->is('post')) {
            $leccione = $this->Lecciones->patchEntity($leccione, $this->request->getData());
            if ($this->Lecciones->save($leccione)) {
                $this->Flash->success(__('The leccione has been saved.'));

                // Obtener curso_id del request o a través del módulo
                $cursoId = $this->request->getQuery('curso_id');
                
                if (!$cursoId && $leccione->modulo_id) {
                     try {
                         $modulo = $this->Lecciones->Modulos->get($leccione->modulo_id);
                         $cursoId = $modulo->curso_id;
                     } catch (\Exception $e) {
                         // Fallback si no se encuentra módulo
                     }
                }

                if ($cursoId) {
                    return $this->redirect(['controller' => 'Cursos', 'action' => 'view', $cursoId]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leccione could not be saved. Please, try again.'));
        }
        
        if ($moduloId) {
            $leccione->modulo_id = $moduloId;
            
            // Obtener lecciones existentes del módulo
            $leccionesExistentes = $this->Lecciones->find()
                ->where(['modulo_id' => $moduloId])
                ->order(['posicion' => 'ASC'])
                ->all();
            
            // Sugerir siguiente posición
            $siguientePosicion = $leccionesExistentes->count() + 1;
            $leccione->posicion = $siguientePosicion;
            
            $this->set(compact('leccionesExistentes', 'siguientePosicion'));
        }
        
        // Filtrar módulos por curso si viene el parámetro
        $cursoId = $this->request->getQuery('curso_id');
        $modulos = $this->Lecciones->Modulos->find('list', limit: 200);
        
        if ($cursoId) {
            $modulos->where(['Modulos.curso_id' => $cursoId]);
        }
        
        $modulos = $modulos->all();
        $this->set(compact('leccione', 'modulos', 'moduloId', 'cursoId'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Leccione id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para editar lecciones.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden editar lecciones existentes.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $leccione = $this->Lecciones->get($id, contain: []);
        $moduloId = $this->request->getQuery('modulo_id');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $leccione = $this->Lecciones->patchEntity($leccione, $this->request->getData());
            if ($this->Lecciones->save($leccione)) {
                $this->Flash->success(__('The leccione has been saved.'));

                if ($moduloId) {
                    return $this->redirect(['controller' => 'Modulos', 'action' => 'view', $moduloId]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The leccione could not be saved. Please, try again.'));
        }
        
        $modulos = $this->Lecciones->Modulos->find('list', limit: 200)->all();
        $this->set(compact('leccione', 'modulos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Leccione id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para eliminar lecciones.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar lecciones del sistema.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $leccione = $this->Lecciones->get($id);
        if ($this->Lecciones->delete($leccione)) {
            $this->Flash->success(__('The leccione has been deleted.'));
        } else {
            $this->Flash->error(__('The leccione could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Obtener lecciones por módulo (AJAX)
     *
     * @return \Cake\Http\Response|null JSON response
     */
    public function obtenerPorModulo()
    {
        $this->request->allowMethod(['get', 'post']);
        $this->autoRender = false;
        
        $moduloId = $this->request->getQuery('modulo_id');
        
        $lecciones = [];
        if ($moduloId) {
            $leccionesExistentes = $this->Lecciones->find()
                ->where(['modulo_id' => $moduloId])
                ->order(['posicion' => 'ASC'])
                ->all();
            
            foreach ($leccionesExistentes as $leccion) {
                $lecciones[] = [
                    'id' => $leccion->id,
                    'titulo' => $leccion->titulo,
                    'tipo' => $leccion->tipo_contenido,
                    'posicion' => $leccion->posicion
                ];
            }
        }
        
        $response = $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'lecciones' => $lecciones,
                'siguientePosicion' => count($lecciones) + 1
            ]));
        
        return $response;
    }
}

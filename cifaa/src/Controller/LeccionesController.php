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
            ->contain(['Modulos']);
        $lecciones = $this->paginate($query);

        $this->set(compact('lecciones'));
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
        // Only administrators (rol 1) can create lessons
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para crear lecciones.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $leccione = $this->Lecciones->newEmptyEntity();
        $moduloId = $this->request->getQuery('modulo_id');
        
        if ($this->request->is('post')) {
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
        
        if ($moduloId) {
            $leccione->modulo_id = $moduloId;
        }
        
        $modulos = $this->Lecciones->Modulos->find('list', limit: 200)->all();
        $this->set(compact('leccione', 'modulos'));
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
        // Only administrators (rol 1) can edit lessons
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para editar lecciones.'));
            return $this->redirect(['action' => 'index']);
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
        // Only administrators (rol 1) can delete lessons
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para eliminar lecciones.'));
            return $this->redirect(['action' => 'index']);
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
}

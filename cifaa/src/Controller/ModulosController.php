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
        $modulos = $this->paginate($query);

        $this->set(compact('modulos'));
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
        // Solo administradores (rol 1) pueden crear módulos
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para crear módulos.'));
            return $this->redirect(['action' => 'index']);
        }
        $modulo = $this->Modulos->newEmptyEntity();
        if ($this->request->is('post')) {
            $modulo = $this->Modulos->patchEntity($modulo, $this->request->getData());
            if ($this->Modulos->save($modulo)) {
                $this->Flash->success(__('The modulo has been saved.'));
                
                // Si vino de un curso, redirigir al curso
                $cursoId = $this->request->getQuery('curso_id');
                if ($cursoId) {
                    return $this->redirect(['controller' => 'Cursos', 'action' => 'view', $cursoId]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modulo could not be saved. Please, try again.'));
        }
        $cursos = $this->Modulos->Cursos->find('list', limit: 200)->all();
        
        // Pre-seleccionar el curso si viene como parámetro
        $cursoId = $this->request->getQuery('curso_id');
        if ($cursoId) {
            $modulo->curso_id = $cursoId;
        }
        
        $this->set(compact('modulo', 'cursos'));
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
        // Solo administradores (rol 1) pueden editar módulos
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para editar módulos.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $modulo = $this->Modulos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modulo = $this->Modulos->patchEntity($modulo, $this->request->getData());
            if ($this->Modulos->save($modulo)) {
                $this->Flash->success(__('The modulo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modulo could not be saved. Please, try again.'));
        }
        $cursos = $this->Modulos->Cursos->find('list', limit: 200)->all();
        $this->set(compact('modulo', 'cursos'));
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
        // Only administrators (rol 1) can delete modules
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para eliminar módulos.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $modulo = $this->Modulos->get($id);
        if ($this->Modulos->delete($modulo)) {
            $this->Flash->success(__('The modulo has been deleted.'));
        } else {
            $this->Flash->error(__('The modulo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RegistrosTratamientos Controller
 *
 * @property \App\Model\Table\RegistrosTratamientosTable $RegistrosTratamientos
 */
class RegistrosTratamientosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->RegistrosTratamientos->find()
            ->contain(['Pacientes', 'Tratamientos']);
        $registrosTratamientos = $this->paginate($query);

        $this->set(compact('registrosTratamientos'));
    }

    /**
     * View method
     *
     * @param string|null $id Registros Tratamiento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registrosTratamientos = $this->RegistrosTratamientos->get($id, contain: ['Pacientes', 'Tratamientos']);
        $this->set(compact('registrosTratamientos'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $registrosTratamientos = $this->RegistrosTratamientos->newEmptyEntity();
        if ($this->request->is('post')) {
            $registrosTratamientos = $this->RegistrosTratamientos->patchEntity($registrosTratamientos, $this->request->getData());
            if ($this->RegistrosTratamientos->save($registrosTratamientos)) {
                $this->Flash->success(__('The registros tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registros tratamiento could not be saved. Please, try again.'));
        }
        $pacientes = $this->RegistrosTratamientos->Pacientes->find('list')->all();
        $tratamientos = $this->RegistrosTratamientos->Tratamientos->find('list')->all();
        
        $this->set(compact('registrosTratamientos', 'pacientes', 'tratamientos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Registros Tratamiento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $registrosTratamientos = $this->RegistrosTratamientos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $registrosTratamientos = $this->RegistrosTratamientos->patchEntity($registrosTratamientos, $this->request->getData());
            if ($this->RegistrosTratamientos->save($registrosTratamientos)) {
                $this->Flash->success(__('The registros tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The registros tratamiento could not be saved. Please, try again.'));
        }
        $pacientes = $this->RegistrosTratamientos->Pacientes->find('list', limit: 200)->all();
        $tratamientos = $this->RegistrosTratamientos->Tratamientos->find('list', limit: 200)->all();
        $this->set(compact('registrosTratamientos', 'pacientes', 'tratamientos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Registros Tratamiento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $registrosTratamientos = $this->RegistrosTratamientos->get($id);
        if ($this->RegistrosTratamientos->delete($registrosTratamientos)) {
            $this->Flash->success(__('The registros tratamiento has been deleted.'));
        } else {
            $this->Flash->error(__('The registros tratamiento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

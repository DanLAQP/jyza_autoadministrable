<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EnfermedadesActuales Controller
 *
 * @property \App\Model\Table\EnfermedadesActualesTable $EnfermedadesActuales
 */
class EnfermedadesActualesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->EnfermedadesActuales->find()
            ->contain(['Pacientes']);
        $enfermedadesActuales = $this->paginate($query);

        $this->set(compact('enfermedadesActuales'));
    }

    /**
     * View method
     *
     * @param string|null $id Enfermedades Actuale id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enfermedadesActuale = $this->EnfermedadesActuales->get($id, contain: ['Pacientes']);
        $this->set(compact('enfermedadesActuale'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enfermedadesActuales = $this->EnfermedadesActuales->newEmptyEntity();
        if ($this->request->is('post')) {
            $enfermedadesActuale = $this->EnfermedadesActuales->patchEntity($enfermedadesActuales, $this->request->getData());
            if ($this->EnfermedadesActuales->save($enfermedadesActuales)) {
                $this->Flash->success(__('The enfermedades actuale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enfermedades actuale could not be saved. Please, try again.'));
        }
        $pacientes = $this->EnfermedadesActuales->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('enfermedadesActuale', 'pacientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Enfermedades Actuale id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $enfermedadesActuales = $this->EnfermedadesActuales->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enfermedadesActuale = $this->EnfermedadesActuales->patchEntity($enfermedadesActuales, $this->request->getData());
            if ($this->EnfermedadesActuales->save($enfermedadesActuales)) {
                $this->Flash->success(__('The enfermedades actuale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enfermedades actuale could not be saved. Please, try again.'));
        }
        $pacientes = $this->EnfermedadesActuales->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('enfermedadesActuale', 'pacientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Enfermedades Actuale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enfermedadesActuales = $this->EnfermedadesActuales->get($id);
        if ($this->EnfermedadesActuales->delete($enfermedadesActuales)) {
            $this->Flash->success(__('The enfermedades actuale has been deleted.'));
        } else {
            $this->Flash->error(__('The enfermedades actuale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

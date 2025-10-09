<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContactosEmergencia Controller
 *
 * @property \App\Model\Table\ContactosEmergenciaTable $ContactosEmergencia
 */
class ContactosEmergenciaController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ContactosEmergencia->find()
            ->contain(['Pacientes']);
        $contactosEmergencia = $this->paginate($query);

        $this->set(compact('contactosEmergencia'));
    }

    /**
     * View method
     *
     * @param string|null $id Contactos Emergencium id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contactosEmergencium = $this->ContactosEmergencia->get($id, contain: ['Pacientes']);
        $this->set(compact('contactosEmergencium'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contactosEmergencium = $this->ContactosEmergencia->newEmptyEntity();
        if ($this->request->is('post')) {
            $contactosEmergencium = $this->ContactosEmergencia->patchEntity($contactosEmergencium, $this->request->getData());
            if ($this->ContactosEmergencia->save($contactosEmergencium)) {
                $this->Flash->success(__('The contactos emergencium has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contactos emergencium could not be saved. Please, try again.'));
        }
        $pacientes = $this->ContactosEmergencia->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('contactosEmergencium', 'pacientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contactos Emergencium id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contactosEmergencium = $this->ContactosEmergencia->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contactosEmergencium = $this->ContactosEmergencia->patchEntity($contactosEmergencium, $this->request->getData());
            if ($this->ContactosEmergencia->save($contactosEmergencium)) {
                $this->Flash->success(__('The contactos emergencium has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contactos emergencium could not be saved. Please, try again.'));
        }
        $pacientes = $this->ContactosEmergencia->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('contactosEmergencium', 'pacientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contactos Emergencium id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contactosEmergencium = $this->ContactosEmergencia->get($id);
        if ($this->ContactosEmergencia->delete($contactosEmergencium)) {
            $this->Flash->success(__('The contactos emergencium has been deleted.'));
        } else {
            $this->Flash->error(__('The contactos emergencium could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

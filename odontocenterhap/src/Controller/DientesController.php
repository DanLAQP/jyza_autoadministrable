<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Dientes Controller
 *
 * @property \App\Model\Table\DientesTable $Dientes
 */
class DientesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Dientes->find();
        $dientes = $this->paginate($query);

        $this->set(compact('dientes'));
    }

    /**
     * View method
     *
     * @param string|null $id Diente id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $diente = $this->Dientes->get($id, contain: ['Odontograma']);
        $this->set(compact('diente'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $diente = $this->Dientes->newEmptyEntity();
        if ($this->request->is('post')) {
            $diente = $this->Dientes->patchEntity($diente, $this->request->getData());
            if ($this->Dientes->save($diente)) {
                $this->Flash->success(__('The diente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The diente could not be saved. Please, try again.'));
        }
        $this->set(compact('diente'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Diente id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $diente = $this->Dientes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $diente = $this->Dientes->patchEntity($diente, $this->request->getData());
            if ($this->Dientes->save($diente)) {
                $this->Flash->success(__('The diente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The diente could not be saved. Please, try again.'));
        }
        $this->set(compact('diente'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Diente id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $diente = $this->Dientes->get($id);
        if ($this->Dientes->delete($diente)) {
            $this->Flash->success(__('The diente has been deleted.'));
        } else {
            $this->Flash->error(__('The diente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

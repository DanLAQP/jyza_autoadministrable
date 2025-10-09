<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OdontogramaDientes Controller
 *
 * @property \App\Model\Table\OdontogramaDientesTable $OdontogramaDientes
 */
class OdontogramaDientesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OdontogramaDientes->find()
            ->contain(['Odontograma', 'Dientes']);
        $odontogramaDientes = $this->paginate($query);

        $this->set(compact('odontogramaDientes'));
    }

    /**
     * View method
     *
     * @param string|null $id Odontograma Diente id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $odontogramaDiente = $this->OdontogramaDientes->get($id, contain: ['Odontograma', 'Dientes']);
        $this->set(compact('odontogramaDiente'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $odontogramaDiente = $this->OdontogramaDientes->newEmptyEntity();
        if ($this->request->is('post')) {
            $odontogramaDiente = $this->OdontogramaDientes->patchEntity($odontogramaDiente, $this->request->getData());
            if ($this->OdontogramaDientes->save($odontogramaDiente)) {
                $this->Flash->success(__('The odontograma diente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The odontograma diente could not be saved. Please, try again.'));
        }
        $odontograma = $this->OdontogramaDientes->Odontograma->find('list')->all();
        $dientes = $this->OdontogramaDientes->Dientes->find('list')->all();
        $this->set(compact('odontogramaDiente', 'odontograma', 'dientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Odontograma Diente id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $odontogramaDiente = $this->OdontogramaDientes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $odontogramaDiente = $this->OdontogramaDientes->patchEntity($odontogramaDiente, $this->request->getData());
            if ($this->OdontogramaDientes->save($odontogramaDiente)) {
                $this->Flash->success(__('The odontograma diente has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The odontograma diente could not be saved. Please, try again.'));
        }
        $odontograma = $this->OdontogramaDientes->Odontograma->find('list')->all();
        $dientes = $this->OdontogramaDientes->Dientes->find('list')->all();
        $this->set(compact('odontogramaDiente', 'odontograma', 'dientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Odontograma Diente id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $odontogramaDiente = $this->OdontogramaDientes->get($id);
        if ($this->OdontogramaDientes->delete($odontogramaDiente)) {
            $this->Flash->success(__('The odontograma diente has been deleted.'));
        } else {
            $this->Flash->error(__('The odontograma diente could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

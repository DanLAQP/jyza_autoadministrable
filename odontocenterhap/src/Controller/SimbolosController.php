<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Simbolos Controller
 *
 * @property \App\Model\Table\SimbolosTable $Simbolos
 */
class SimbolosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Simbolos->find();
        $simbolos = $this->paginate($query);

        $this->set(compact('simbolos'));
    }

    /**
     * View method
     *
     * @param string|null $id Simbolo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $simbolo = $this->Simbolos->get($id, contain: ['Odontograma']);
        $this->set(compact('simbolo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $simbolo = $this->Simbolos->newEmptyEntity();
        if ($this->request->is('post')) {
            $simbolo = $this->Simbolos->patchEntity($simbolo, $this->request->getData());
            if ($this->Simbolos->save($simbolo)) {
                $this->Flash->success(__('The simbolo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The simbolo could not be saved. Please, try again.'));
        }
        $odontograma = $this->Simbolos->Odontograma->find('list', limit: 200)->all();
        $this->set(compact('simbolo', 'odontograma'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Simbolo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $simbolo = $this->Simbolos->get($id, contain: ['Odontograma']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $simbolo = $this->Simbolos->patchEntity($simbolo, $this->request->getData());
            if ($this->Simbolos->save($simbolo)) {
                $this->Flash->success(__('The simbolo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The simbolo could not be saved. Please, try again.'));
        }
        $odontograma = $this->Simbolos->Odontograma->find('list', limit: 200)->all();
        $this->set(compact('simbolo', 'odontograma'));
    }
}

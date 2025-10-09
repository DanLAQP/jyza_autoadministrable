<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OdontogramaSimbolos Controller
 *
 * @property \App\Model\Table\OdontogramaSimbolosTable $OdontogramaSimbolos
 */
class OdontogramaSimbolosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OdontogramaSimbolos->find()
            ->contain(['Odontograma', 'Simbolos']);
        $odontogramaSimbolos = $this->paginate($query);

        $this->set(compact('odontogramaSimbolos'));
    }

    /**
     * View method
     *
     * @param string|null $id Odontograma Simbolo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $odontogramaSimbolo = $this->OdontogramaSimbolos->get($id, contain: ['Odontograma', 'Simbolos']);
        $this->set(compact('odontogramaSimbolo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $odontogramaSimbolo = $this->OdontogramaSimbolos->newEmptyEntity();
        if ($this->request->is('post')) {
            $odontogramaSimbolo = $this->OdontogramaSimbolos->patchEntity($odontogramaSimbolo, $this->request->getData());
            if ($this->OdontogramaSimbolos->save($odontogramaSimbolo)) {
                $this->Flash->success(__('The odontograma simbolo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The odontograma simbolo could not be saved. Please, try again.'));
        }
        $odontograma = $this->OdontogramaSimbolos->Odontograma->find('list')->all();
        $simbolos = $this->OdontogramaSimbolos->Simbolos->find('list')->all();
        $this->set(compact('odontogramaSimbolo', 'odontograma', 'simbolos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Odontograma Simbolo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $odontogramaSimbolo = $this->OdontogramaSimbolos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $odontogramaSimbolo = $this->OdontogramaSimbolos->patchEntity($odontogramaSimbolo, $this->request->getData());
            if ($this->OdontogramaSimbolos->save($odontogramaSimbolo)) {
                $this->Flash->success(__('The odontograma simbolo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The odontograma simbolo could not be saved. Please, try again.'));
        }
        $odontograma = $this->OdontogramaSimbolos->Odontograma->find('list')->all();
        $simbolos = $this->OdontogramaSimbolos->Simbolos->find('list')->all();
        $this->set(compact('odontogramaSimbolo', 'odontograma', 'simbolos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Odontograma Simbolo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $odontogramaSimbolo = $this->OdontogramaSimbolos->get($id);
        if ($this->OdontogramaSimbolos->delete($odontogramaSimbolo)) {
            $this->Flash->success(__('The odontograma simbolo has been deleted.'));
        } else {
            $this->Flash->error(__('The odontograma simbolo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AntecedentesOdontologicos Controller
 *
 * @property \App\Model\Table\AntecedentesOdontologicosTable $AntecedentesOdontologicos
 */
class AntecedentesOdontologicosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AntecedentesOdontologicos->find()
            ->contain(['Pacientes']);
        $antecedentesOdontologicos = $this->paginate($query);

        $this->set(compact('antecedentesOdontologicos'));
    }

    /**
     * View method
     *
     * @param string|null $id Antecedentes Odontologico id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $antecedentesOdontologico = $this->AntecedentesOdontologicos->get($id, contain: ['Pacientes']);
        $this->set(compact('antecedentesOdontologico'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $antecedentesOdontologico = $this->AntecedentesOdontologicos->newEmptyEntity();
        if ($this->request->is('post')) {
            $antecedentesOdontologico = $this->AntecedentesOdontologicos->patchEntity($antecedentesOdontologico, $this->request->getData());
            if ($this->AntecedentesOdontologicos->save($antecedentesOdontologico)) {
                $this->Flash->success(__('The antecedentes odontologico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The antecedentes odontologico could not be saved. Please, try again.'));
        }
        $pacientes = $this->AntecedentesOdontologicos->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('antecedentesOdontologico', 'pacientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Antecedentes Odontologico id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $antecedentesOdontologico = $this->AntecedentesOdontologicos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $antecedentesOdontologico = $this->AntecedentesOdontologicos->patchEntity($antecedentesOdontologico, $this->request->getData());
            if ($this->AntecedentesOdontologicos->save($antecedentesOdontologico)) {
                $this->Flash->success(__('The antecedentes odontologico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The antecedentes odontologico could not be saved. Please, try again.'));
        }
        $pacientes = $this->AntecedentesOdontologicos->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('antecedentesOdontologico', 'pacientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Antecedentes Odontologico id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $antecedentesOdontologico = $this->AntecedentesOdontologicos->get($id);
        if ($this->AntecedentesOdontologicos->delete($antecedentesOdontologico)) {
            $this->Flash->success(__('The antecedentes odontologico has been deleted.'));
        } else {
            $this->Flash->error(__('The antecedentes odontologico could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

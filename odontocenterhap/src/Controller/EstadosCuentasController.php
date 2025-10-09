<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * EstadosCuentas Controller
 *
 * @property \App\Model\Table\EstadosCuentasTable $EstadosCuentas
 */
class EstadosCuentasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->EstadosCuentas->find()
            ->contain(['Pacientes']);
        $estadosCuentas = $this->paginate($query);

        $this->set(compact('estadosCuentas'));
    }

    /**
     * View method
     *
     * @param string|null $id Estados Cuenta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estadosCuenta = $this->EstadosCuentas->get($id, contain: ['Pacientes']);
        $this->set(compact('estadosCuenta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estadosCuenta = $this->EstadosCuentas->newEmptyEntity();
        if ($this->request->is('post')) {
            $estadosCuenta = $this->EstadosCuentas->patchEntity($estadosCuenta, $this->request->getData());
            if ($this->EstadosCuentas->save($estadosCuenta)) {
                $this->Flash->success(__('The estados cuenta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estados cuenta could not be saved. Please, try again.'));
        }
        $pacientes = $this->EstadosCuentas->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('estadosCuenta', 'pacientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estados Cuenta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estadosCuenta = $this->EstadosCuentas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estadosCuenta = $this->EstadosCuentas->patchEntity($estadosCuenta, $this->request->getData());
            if ($this->EstadosCuentas->save($estadosCuenta)) {
                $this->Flash->success(__('The estados cuenta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estados cuenta could not be saved. Please, try again.'));
        }
        $pacientes = $this->EstadosCuentas->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('estadosCuenta', 'pacientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Estados Cuenta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estadosCuenta = $this->EstadosCuentas->get($id);
        if ($this->EstadosCuentas->delete($estadosCuenta)) {
            $this->Flash->success(__('The estados cuenta has been deleted.'));
        } else {
            $this->Flash->error(__('The estados cuenta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

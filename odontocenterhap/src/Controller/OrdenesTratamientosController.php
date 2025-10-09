<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrdenesTratamientos Controller
 *
 * @property \App\Model\Table\OrdenesTratamientosTable $OrdenesTratamientos
 */
class OrdenesTratamientosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OrdenesTratamientos->find()
            ->contain(['Ordenes', 'Tratamientos']);
        $ordenesTratamientos = $this->paginate($query);

        $this->set(compact('ordenesTratamientos'));
    }

    /**
     * View method
     *
     * @param string|null $id Ordenes Tratamiento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordenesTratamiento = $this->OrdenesTratamientos->get($id, contain: ['Ordenes', 'Tratamientos']);
        $this->set(compact('ordenesTratamiento'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ordenesTratamiento = $this->OrdenesTratamientos->newEmptyEntity();
        if ($this->request->is('post')) {
            $ordenesTratamiento = $this->OrdenesTratamientos->patchEntity($ordenesTratamiento, $this->request->getData());
            if ($this->OrdenesTratamientos->save($ordenesTratamiento)) {
                $this->Flash->success(__('The ordenes tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordenes tratamiento could not be saved. Please, try again.'));
        }
        $ordenes = $this->OrdenesTratamientos->Ordenes->find('list', limit: 200)->all();
        $tratamientos = $this->OrdenesTratamientos->Tratamientos->find('list', limit: 200)->all();
        $this->set(compact('ordenesTratamiento', 'ordenes', 'tratamientos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ordenes Tratamiento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ordenesTratamiento = $this->OrdenesTratamientos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordenesTratamiento = $this->OrdenesTratamientos->patchEntity($ordenesTratamiento, $this->request->getData());
            if ($this->OrdenesTratamientos->save($ordenesTratamiento)) {
                $this->Flash->success(__('The ordenes tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordenes tratamiento could not be saved. Please, try again.'));
        }
        $ordenes = $this->OrdenesTratamientos->Ordenes->find('list', limit: 200)->all();
        $tratamientos = $this->OrdenesTratamientos->Tratamientos->find('list', limit: 200)->all();
        $this->set(compact('ordenesTratamiento', 'ordenes', 'tratamientos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ordenes Tratamiento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordenesTratamiento = $this->OrdenesTratamientos->get($id);
        if ($this->OrdenesTratamientos->delete($ordenesTratamiento)) {
            $this->Flash->success(__('The ordenes tratamiento has been deleted.'));
        } else {
            $this->Flash->error(__('The ordenes tratamiento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

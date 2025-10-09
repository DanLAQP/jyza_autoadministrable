<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ConsultasTratamientos Controller
 *
 * @property \App\Model\Table\ConsultasTratamientosTable $ConsultasTratamientos
 */
class ConsultasTratamientosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ConsultasTratamientos->find()
            ->contain(['RegistrosConsultas', 'Tratamientos']);
        $consultasTratamientos = $this->paginate($query);

        $this->set(compact('consultasTratamientos'));
    }

    /**
     * View method
     *
     * @param string|null $id Consultas Tratamiento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consultasTratamiento = $this->ConsultasTratamientos->get($id, contain: ['RegistrosConsultas', 'Tratamientos']);
        $this->set(compact('consultasTratamiento'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consultasTratamiento = $this->ConsultasTratamientos->newEmptyEntity();
        if ($this->request->is('post')) {
            $consultasTratamiento = $this->ConsultasTratamientos->patchEntity($consultasTratamiento, $this->request->getData());
            if ($this->ConsultasTratamientos->save($consultasTratamiento)) {
                $this->Flash->success(__('The consultas tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consultas tratamiento could not be saved. Please, try again.'));
        }
        $registrosConsultas = $this->ConsultasTratamientos->RegistrosConsultas->find('list', limit: 200)->all();
        $tratamientos = $this->ConsultasTratamientos->Tratamientos->find('list', limit: 200)->all();
        $this->set(compact('consultasTratamiento', 'registrosConsultas', 'tratamientos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consultas Tratamiento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consultasTratamiento = $this->ConsultasTratamientos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consultasTratamiento = $this->ConsultasTratamientos->patchEntity($consultasTratamiento, $this->request->getData());
            if ($this->ConsultasTratamientos->save($consultasTratamiento)) {
                $this->Flash->success(__('The consultas tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consultas tratamiento could not be saved. Please, try again.'));
        }
        $registrosConsultas = $this->ConsultasTratamientos->RegistrosConsultas->find('list', limit: 200)->all();
        $tratamientos = $this->ConsultasTratamientos->Tratamientos->find('list', limit: 200)->all();
        $this->set(compact('consultasTratamiento', 'registrosConsultas', 'tratamientos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consultas Tratamiento id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consultasTratamiento = $this->ConsultasTratamientos->get($id);
        if ($this->ConsultasTratamientos->delete($consultasTratamiento)) {
            $this->Flash->success(__('The consultas tratamiento has been deleted.'));
        } else {
            $this->Flash->error(__('The consultas tratamiento could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

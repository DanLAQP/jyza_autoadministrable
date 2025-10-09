<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AntecedentesMedicos Controller
 *
 * @property \App\Model\Table\AntecedentesMedicosTable $AntecedentesMedicos
 */
class AntecedentesMedicosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AntecedentesMedicos->find()
            ->contain(['Pacientes']);
        $antecedentesMedicos = $this->paginate($query);

        $this->set(compact('antecedentesMedicos'));
    }

    /**
     * View method
     *
     * @param string|null $id Antecedentes Medico id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $antecedentesMedico = $this->AntecedentesMedicos->get($id, contain: ['Pacientes']);
        $this->set(compact('antecedentesMedico'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $antecedentesMedico = $this->AntecedentesMedicos->newEmptyEntity();
        if ($this->request->is('post')) {
            $antecedentesMedico = $this->AntecedentesMedicos->patchEntity($antecedentesMedico, $this->request->getData());
            if ($this->AntecedentesMedicos->save($antecedentesMedico)) {
                $this->Flash->success(__('The antecedentes medico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The antecedentes medico could not be saved. Please, try again.'));
        }
        $pacientes = $this->AntecedentesMedicos->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('antecedentesMedico', 'pacientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Antecedentes Medico id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $antecedentesMedico = $this->AntecedentesMedicos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $antecedentesMedico = $this->AntecedentesMedicos->patchEntity($antecedentesMedico, $this->request->getData());
            if ($this->AntecedentesMedicos->save($antecedentesMedico)) {
                $this->Flash->success(__('The antecedentes medico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The antecedentes medico could not be saved. Please, try again.'));
        }
        $pacientes = $this->AntecedentesMedicos->Pacientes->find('list', limit: 200)->all();
        $this->set(compact('antecedentesMedico', 'pacientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Antecedentes Medico id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
}

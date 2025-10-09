<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Egresos Controller
 *
 * @property \App\Model\Table\EgresosTable $Egresos
 */
class EgresosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $query = $this->Egresos->find();
        $egresos = $this->paginate($query);

        $this->set(compact('egresos'));
    }

    /**
     * View method
     *
     * @param string|null $id Egreso id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $egreso = $this->Egresos->get($id, contain: []);
        $this->set(compact('egreso'));
                // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $egreso = $this->Egresos->newEmptyEntity();
        if ($this->request->is('post')) {
            $egreso = $this->Egresos->patchEntity($egreso, $this->request->getData());
            if ($this->Egresos->save($egreso)) {
                $this->Flash->success(__('The egreso has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The egreso could not be saved. Please, try again.'));
        }
        $this->set(compact('egreso'));
                // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Egreso id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $egreso = $this->Egresos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $egreso = $this->Egresos->patchEntity($egreso, $this->request->getData());
            if ($this->Egresos->save($egreso)) {
                $this->Flash->success(__('The egreso has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The egreso could not be saved. Please, try again.'));
        }
        $this->set(compact('egreso'));
                // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }
}

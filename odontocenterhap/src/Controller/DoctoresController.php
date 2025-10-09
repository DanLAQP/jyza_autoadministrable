<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Doctores Controller
 *
 * @property \App\Model\Table\DoctoresTable $Doctores
 */
class DoctoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Doctores->find();
        $doctores = $this->paginate($query);

        $searchTerm = $this->request->getQuery('search');

        if (!empty($searchTerm)) {
            $query->where([
                'OR' => [
                    'LOWER(Doctores.nombre) LIKE' => '%' . strtolower($searchTerm) . '%',
                    'LOWER(Doctores.apellido) LIKE' => '%' . strtolower($searchTerm) . '%',
                ]
            ]);
        }

        $doctores = $this->paginate($query);

        $this->set(compact('doctores'));
    }

    /**
     * View method
     *
     * @param string|null $id Doctore id.
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
        $doctore = $this->Doctores->get($id, contain: []);
        $this->set(compact('doctore'));
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
        $doctore = $this->Doctores->newEmptyEntity();
        if ($this->request->is('post')) {
            $doctore = $this->Doctores->patchEntity($doctore, $this->request->getData());
            if ($this->Doctores->save($doctore)) {
                $this->Flash->success(__('The doctore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctore could not be saved. Please, try again.'));
        }
        $this->set(compact('doctore'));
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
     * @param string|null $id Doctore id.
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
        $doctore = $this->Doctores->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $doctore = $this->Doctores->patchEntity($doctore, $this->request->getData());
            if ($this->Doctores->save($doctore)) {
                $this->Flash->success(__('The doctore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The doctore could not be saved. Please, try again.'));
        }
        $this->set(compact('doctore'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Doctore id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $doctore = $this->Doctores->get($id);
        if ($this->Doctores->delete($doctore)) {
            $this->Flash->success(__('The doctore has been deleted.'));
        } else {
            $this->Flash->error(__('The doctore could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

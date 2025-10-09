<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tratamientos Controller
 *
 * @property \App\Model\Table\TratamientosTable $Tratamientos
 */
class TratamientosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $query = $this->Tratamientos->find()
            ->order(['Tratamientos.id' => 'DESC']); // Orden descendente por el campo `id`

        $tratamientos = $this->paginate($query);

        $this->set(compact('tratamientos'));
    }


    public function view($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $tratamiento = $this->Tratamientos->get($id, contain: ['RegistrosTratamientos']);
        $this->set(compact('tratamiento'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    public function add()
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $tratamiento = $this->Tratamientos->newEmptyEntity();
        if ($this->request->is('post')) {
            $tratamiento = $this->Tratamientos->patchEntity($tratamiento, $this->request->getData());
            if ($this->Tratamientos->save($tratamiento)) {
                $this->Flash->success(__('The tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento could not be saved. Please, try again.'));
        }
        $this->set(compact('tratamiento'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    public function edit($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $tratamiento = $this->Tratamientos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tratamiento = $this->Tratamientos->patchEntity($tratamiento, $this->request->getData());
            if ($this->Tratamientos->save($tratamiento)) {
                $this->Flash->success(__('The tratamiento has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tratamiento could not be saved. Please, try again.'));
        }
        $this->set(compact('tratamiento'));
         // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }
}

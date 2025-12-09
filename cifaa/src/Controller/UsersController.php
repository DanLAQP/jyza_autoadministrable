<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $rol = $this->request->getAttribute('identity')->get('rol');
        if ($rol != 1) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rol = $this->request->getAttribute('identity')->get('rol');
        if ($rol != 1) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
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
        $rol = $this->request->getAttribute('identity')->get('rol');
        if ($rol != 1) {
            if ($this->request->is('ajax')) {
                $this->set('error_message', 'No tienes permisos para realizar esta acción');
                $this->viewBuilder()->setLayout('ajax');
                return;
            }
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rol = $this->request->getAttribute('identity')->get('rol');
        if ($rol != 1) {
            if ($this->request->is('ajax')) {
                $this->set('error_message', 'No tienes permisos para realizar esta acción');
                $this->viewBuilder()->setLayout('ajax');
                return;
            }
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer()); 
        }
        $rol = $this->request->getAttribute('identity')->get('rol');
        if ($rol != 1) {
            $this->Flash->error(__('No tienes permiso para acceder a esta página'));
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->viewBuilder()->setLayout('login'); // Usar el layout 'login'
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->find()->where(['username' => $data['username']])->first();

            if (!$user) {
                $this->Flash->error('El usuario no existe');
            } elseif ($user && !$result->isValid()) {
                $this->Flash->error('Contraseña incorrecta');
            }
        }

        if ($result->isValid()) {
            $user = $this->request->getAttribute('identity');
            if (isset($user) && ($user->get('estado') === 'inactivo' || $user->get('estado') === 'deshabilitado')) {
                $this->Authentication->logout();
                $this->Flash->error(__('Su usuario está inactivo o deshabilitado. Por favor, comuníquese con un administrador.'));
                return $this->redirect(['action' => 'login']);
            }
            // Redirigir al home (dashboard de bienvenida)
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
            $result = $this->Authentication->getResult(); // Ensure $result is defined
    }
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success('You have been logged out');
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}

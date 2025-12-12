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
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Este método valida que solo usuarios con rol de administrador (rol=1)
         * puedan acceder al listado completo de usuarios del sistema.
         * Si el acceso es denegado, redirige automáticamente según el rol.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $query = $this->Users->find();

        // Filtro por DNI
        $dni = $this->request->getQuery('dni');
        if (!empty($dni)) {
            $query->where(['Users.dni LIKE' => '%' . $dni . '%']);
        }
        
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
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método puedeEditar() del trait ControlAccesoRoles.
         * Permite que un usuario visualice su propio perfil, o que un administrador
         * pueda ver cualquier perfil. Si el usuario intenta ver un perfil ajeno
         * sin ser administrador, se le redirige a su propio perfil.
         */
        $user = $this->Users->get($id, contain: []);
        $usuarioActual = $this->obtenerUsuarioActual();
        
        // Verificar si el usuario puede ver este perfil
        if (!$this->puedeEditar((int)$id)) {
            $this->Flash->error(__('Solo puede visualizar su propio perfil.'));
            return $this->redirect(['action' => 'view', $usuarioActual->id]);
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
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     if ($this->request->is('ajax')) {
         *         $this->set('error_message', 'No tienes permisos para realizar esta acción');
         *         $this->viewBuilder()->setLayout('ajax');
         *         return;
         *     }
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden crear nuevos usuarios en el sistema.
         * Maneja tanto solicitudes normales como AJAX de manera unificada.
         */
        if ($redirect = $this->requiereAdministrador()) {
            // Manejar respuesta AJAX si es necesario
            if ($this->request->is('ajax')) {
                $this->set('error_message', 'No tienes permisos para realizar esta acción');
                $this->viewBuilder()->setLayout('ajax');
                return;
            }
            return $redirect;
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
        /**
         * Versión anterior (comentada para referencia):
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     if ($this->request->is('ajax')) {
         *         $this->set('error_message', 'No tienes permisos para realizar esta acción');
         *         $this->viewBuilder()->setLayout('ajax');
         *         return;
         *     }
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * 
         * Nueva implementación:
         * Utiliza el método puedeEditar() del trait ControlAccesoRoles.
         * Permite que un usuario edite su propio perfil, o que un administrador
         * pueda editar cualquier perfil. Esto mejora la flexibilidad permitiendo
         * que los usuarios gestionen su propia información.
         */
        $user = $this->Users->get($id, contain: []);
        $usuarioActual = $this->obtenerUsuarioActual();
        
        // Verificar si el usuario puede editar este perfil
        if (!$this->puedeEditar((int)$id)) {
            if ($this->request->is('ajax')) {
                $this->set('error_message', 'Solo puede editar su propio perfil');
                $this->viewBuilder()->setLayout('ajax');
                return;
            }
            $this->Flash->error(__('Solo puede editar su propio perfil.'));
            return $this->redirect(['action' => 'edit', $usuarioActual->id]);
        }
        
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
        /**
         * Versión anterior (comentada para referencia):
         * $roles = [1, 2, 3];
         * if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
         *     $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
         *     return $this->redirect($this->referer()); 
         * }
         * $rol = $this->request->getAttribute('identity')->get('rol');
         * if ($rol != 1) {
         *     $this->Flash->error(__('No tienes permiso para acceder a esta página'));
         *     return $this->redirect(['controller' => 'Users', 'action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar usuarios del sistema.
         * Esto elimina la validación redundante y centraliza la lógica de autorización.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
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

<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Cursos Controller
 *
 * @property \App\Model\Table\CursosTable $Cursos
 */
class CursosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Cursos->find()
            ->contain(['Users']);
        $cursos = $this->paginate($query);

        $this->set(compact('cursos'));
    }

    /**
     * View method
     *
     * @param string|null $id Curso id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $curso = $this->Cursos->get($id, contain: ['Users', 'Inscripciones', 'Modulos']);
        $this->set(compact('curso'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // Solo administradores (rol 1) pueden crear cursos
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para crear cursos.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $curso = $this->Cursos->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Manejar la subida de la miniatura
            if (!empty($data['miniatura']) && $data['miniatura']->getSize() > 0) {
                $miniatura = $data['miniatura'];
                $uploadPath = WWW_ROOT . 'uploads' . DS . 'cursos' . DS;
                
                // Crear directorio si no existe
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Generar nombre único para la imagen
                $ext = pathinfo($miniatura->getClientFilename(), PATHINFO_EXTENSION);
                $fileName = time() . '_' . uniqid() . '.' . $ext;
                $filePath = $uploadPath . $fileName;
                
                // Validar tipo de archivo
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (in_array($miniatura->getClientMediaType(), $allowedMimes)) {
                    $miniatura->moveTo($filePath);
                    $data['miniatura'] = 'uploads/cursos/' . $fileName;
                } else {
                    $this->Flash->error(__('El archivo de imagen no es válido. Formatos permitidos: JPG, PNG, GIF, WebP.'));
                    $users = $this->Cursos->Users->find('list', limit: 200)->all();
                    $this->set(compact('curso', 'users'));
                    return;
                }
            } else {
                unset($data['miniatura']);
            }
            
            $curso = $this->Cursos->patchEntity($curso, $data);
            if ($this->Cursos->save($curso)) {
                $this->Flash->success(__('The curso has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The curso could not be saved. Please, try again.'));
        }
        $users = $this->Cursos->Users->find('list', limit: 200)->all();
        $this->set(compact('curso', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Curso id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Solo administradores (rol 1) pueden editar cursos
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para editar cursos.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $curso = $this->Cursos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Manejar la subida de la miniatura
            if (!empty($data['miniatura']) && $data['miniatura']->getSize() > 0) {
                $miniatura = $data['miniatura'];
                $uploadPath = WWW_ROOT . 'uploads' . DS . 'cursos' . DS;
                
                // Crear directorio si no existe
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Eliminar miniatura anterior si existe
                if (!empty($curso->miniatura)) {
                    $oldFile = WWW_ROOT . $curso->miniatura;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                
                // Generar nombre único para la imagen
                $ext = pathinfo($miniatura->getClientFilename(), PATHINFO_EXTENSION);
                $fileName = time() . '_' . uniqid() . '.' . $ext;
                $filePath = $uploadPath . $fileName;
                
                // Validar tipo de archivo
                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (in_array($miniatura->getClientMediaType(), $allowedMimes)) {
                    $miniatura->moveTo($filePath);
                    $data['miniatura'] = 'uploads/cursos/' . $fileName;
                } else {
                    $this->Flash->error(__('El archivo de imagen no es válido. Formatos permitidos: JPG, PNG, GIF, WebP.'));
                    $users = $this->Cursos->Users->find('list', limit: 200)->all();
                    $this->set(compact('curso', 'users'));
                    return;
                }
            } else {
                unset($data['miniatura']);
            }
            
            $curso = $this->Cursos->patchEntity($curso, $data);
            if ($this->Cursos->save($curso)) {
                $this->Flash->success(__('The curso has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The curso could not be saved. Please, try again.'));
        }
        $users = $this->Cursos->Users->find('list', limit: 200)->all();
        $this->set(compact('curso', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Curso id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // Solo administradores (rol 1) pueden eliminar cursos
        $usuario = $this->getRequest()->getAttribute('identity');
        if (!$usuario || $usuario->rol != 1) {
            $this->Flash->error(__('No tienes permisos para eliminar cursos.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $curso = $this->Cursos->get($id);
        if ($this->Cursos->delete($curso)) {
            $this->Flash->success(__('The curso has been deleted.'));
        } else {
            $this->Flash->error(__('The curso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

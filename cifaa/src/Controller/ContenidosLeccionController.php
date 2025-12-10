<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContenidosLeccion Controller
 *
 * @property \App\Model\Table\ContenidosLeccionTable $ContenidosLeccion
 */
class ContenidosLeccionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ContenidosLeccion->find()
            ->contain(['Lecciones']);
        $contenidosLeccion = $this->paginate($query);

        $this->set(compact('contenidosLeccion'));
    }

    /**
     * View method
     *
     * @param string|null $id Contenidos Leccion id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contenidosLeccion = $this->ContenidosLeccion->get($id, contain: ['Lecciones' => ['Modulos' => ['Cursos']]]);
        
        // Verificar inscripción al curso
        $inscrito = $this->verificarInscripcionLeccion($contenidosLeccion->leccion_id);
        
        if (!$inscrito) {
            // Obtener usuario actual
            $usuario = $this->getRequest()->getAttribute('identity');
            $tieneSolicitud = false;
            
            // Verificar si ya existe una solicitud pendiente o rechazada
            if ($usuario) {
                $inscripcionesTable = $this->fetchTable('Inscripciones');
                $solicitud = $inscripcionesTable->find()
                    ->where([
                        'usuario_id' => $usuario->id,
                        'curso_id' => $contenidosLeccion->leccion->modulo->curso_id,
                        'estado !=' => 'aprobada'
                    ])
                    ->first();
                
                $tieneSolicitud = !empty($solicitud);
            }
            
            // Pasar datos para mostrar modal
            $this->set([
                'contenidosLeccion' => $contenidosLeccion,
                'leccion' => $contenidosLeccion->leccion,
                'modulo' => $contenidosLeccion->leccion->modulo,
                'curso' => $contenidosLeccion->leccion->modulo->curso,
                'noInscrito' => true,
                'tieneSolicitud' => $tieneSolicitud,
                'cursoId' => $contenidosLeccion->leccion->modulo->curso_id
            ]);
            return;
        }
        
        $this->set(compact('contenidosLeccion'));
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
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para crear contenido.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden crear contenido para las lecciones.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $contenidosLeccion = $this->ContenidosLeccion->newEmptyEntity();
        $leccionId = $this->request->getQuery('leccion_id');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Manejo de subida de archivo
            if ($this->request->getUploadedFile('archivo')) {
                $file = $this->request->getUploadedFile('archivo');
                
                // Validar tipo de archivo
                $allowedMimes = [
                    'application/pdf' => '.pdf',
                    'application/msword' => '.doc',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
                    'application/vnd.ms-excel' => '.xls',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
                    'image/jpeg' => '.jpg',
                    'image/png' => '.png',
                    'image/gif' => '.gif',
                    'image/webp' => '.webp',
                    'video/mp4' => '.mp4',
                    'video/webm' => '.webm',
                ];
                
                $clientMediaType = $file->getClientMediaType();
                
                if (isset($allowedMimes[$clientMediaType])) {
                    // Crear directorio si no existe
                    $uploadDir = WWW_ROOT . 'uploads' . DS . 'contenidos_leccion';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    // Generar nombre único
                    $filename = time() . '_' . uniqid() . $allowedMimes[$clientMediaType];
                    $filePath = $uploadDir . DS . $filename;
                    
                    // Guardar archivo
                    $file->moveTo($filePath);
                    $data['archivo'] = 'uploads/contenidos_leccion/' . $filename;
                } else {
                    $this->Flash->error(__('Tipo de archivo no permitido.'));
                    $lecciones = $this->ContenidosLeccion->Lecciones->find('list', limit: 200)->all();
                    $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId'));
                    return;
                }
            }
            
            $contenidosLeccion = $this->ContenidosLeccion->patchEntity($contenidosLeccion, $data);
            if ($this->ContenidosLeccion->save($contenidosLeccion)) {
                $this->Flash->success(__('El contenido ha sido guardado.'));

                if ($leccionId) {
                    return $this->redirect(['controller' => 'Lecciones', 'action' => 'view', $leccionId]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El contenido no pudo ser guardado. Por favor, intenta nuevamente.'));
        }
        
        if ($leccionId) {
            $contenidosLeccion->leccion_id = $leccionId;
        }
        
        $lecciones = $this->ContenidosLeccion->Lecciones->find('list', limit: 200)->all();
        $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contenidos Leccion id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para editar contenido.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden editar contenido existente de lecciones.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $contenidosLeccion = $this->ContenidosLeccion->get($id, contain: []);
        $leccionId = $this->request->getQuery('leccion_id');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Manejo de subida de archivo
            if ($this->request->getUploadedFile('archivo')) {
                $file = $this->request->getUploadedFile('archivo');
                
                // Validar tipo de archivo
                $allowedMimes = [
                    'application/pdf' => '.pdf',
                    'application/msword' => '.doc',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
                    'application/vnd.ms-excel' => '.xls',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
                    'image/jpeg' => '.jpg',
                    'image/png' => '.png',
                    'image/gif' => '.gif',
                    'image/webp' => '.webp',
                    'video/mp4' => '.mp4',
                    'video/webm' => '.webm',
                ];
                
                $clientMediaType = $file->getClientMediaType();
                
                if (isset($allowedMimes[$clientMediaType])) {
                    // Eliminar archivo anterior si existe
                    if ($contenidosLeccion->archivo) {
                        $oldFile = WWW_ROOT . $contenidosLeccion->archivo;
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    
                    // Crear directorio si no existe
                    $uploadDir = WWW_ROOT . 'uploads' . DS . 'contenidos_leccion';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    // Generar nombre único
                    $filename = time() . '_' . uniqid() . $allowedMimes[$clientMediaType];
                    $filePath = $uploadDir . DS . $filename;
                    
                    // Guardar archivo
                    $file->moveTo($filePath);
                    $data['archivo'] = 'uploads/contenidos_leccion/' . $filename;
                } else {
                    $this->Flash->error(__('Tipo de archivo no permitido.'));
                    $lecciones = $this->ContenidosLeccion->Lecciones->find('list', limit: 200)->all();
                    $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId'));
                    return;
                }
            }
            
            $contenidosLeccion = $this->ContenidosLeccion->patchEntity($contenidosLeccion, $data);
            if ($this->ContenidosLeccion->save($contenidosLeccion)) {
                $this->Flash->success(__('El contenido ha sido guardado.'));

                if ($leccionId) {
                    return $this->redirect(['controller' => 'Lecciones', 'action' => 'view', $leccionId]);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El contenido no pudo ser guardado. Por favor, intenta nuevamente.'));
        }
        
        $lecciones = $this->ContenidosLeccion->Lecciones->find('list', limit: 200)->all();
        $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contenidos Leccion id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para eliminar contenido.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar contenido de lecciones.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $contenidosLeccion = $this->ContenidosLeccion->get($id);
        if ($this->ContenidosLeccion->delete($contenidosLeccion)) {
            $this->Flash->success(__('The contenidos leccion has been deleted.'));
        } else {
            $this->Flash->error(__('The contenidos leccion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

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
            ->contain(['Lecciones' => ['Modulos' => ['Cursos']]]);
        
        // Filtrar por curso si se proporciona el parámetro
        $cursoId = $this->request->getQuery('curso_id');
        if ($cursoId) {
            $query->matching('Lecciones.Modulos', function ($q) use ($cursoId) {
                return $q->where(['Modulos.curso_id' => $cursoId]);
            });
            
            // Obtener datos del curso para mostrar en la vista
            $curso = $this->fetchTable('Cursos')->get($cursoId);
            $this->set('curso', $curso);
        }
        
        $contenidosLeccion = $this->paginate($query);

        $this->set(compact('contenidosLeccion', 'cursoId'));
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
        
        // Obtener usuario actual
        $usuario = $this->getRequest()->getAttribute('identity');
        
        // ADMIN puede ver todo sin restricciones
        if ($usuario && $usuario->rol == 1) {
            $this->set(compact('contenidosLeccion'));
            return;
        }
        
        // Para otros roles, verificar inscripción al curso
        $inscrito = $this->verificarInscripcionLeccion($contenidosLeccion->leccion_id);
        
        if (!$inscrito) {
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

                // Obtener leccion_id para redirigir a la lección
                $leccionId = $contenidosLeccion->leccion_id;
                
                if ($leccionId) {
                    try {
                        $leccion = $this->ContenidosLeccion->Lecciones->get($leccionId);
                        return $this->redirect(['controller' => 'Lecciones', 'action' => 'view', $leccionId]);
                    } catch (\Exception $e) { }
                }
                
                // Fallback: redirigir al index
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El contenido no pudo ser guardado. Por favor, intenta nuevamente.'));
        }
        
        if ($leccionId) {
            $contenidosLeccion->leccion_id = $leccionId;
            
            // Obtener contenidos existentes de la lección
            $contenidosExistentes = $this->ContenidosLeccion->find()
                ->where(['leccion_id' => $leccionId])
                ->order(['posicion' => 'ASC'])
                ->all();
            
            // Sugerir siguiente posición
            $siguientePosicion = $contenidosExistentes->count() + 1;
            $contenidosLeccion->posicion = $siguientePosicion;
            
            $this->set(compact('contenidosExistentes', 'siguientePosicion'));
        }
        
        // Filtrar lecciones por curso si viene el parámetro
        $cursoId = $this->request->getQuery('curso_id');
        $leccionesQuery = $this->ContenidosLeccion->Lecciones->find('list', limit: 200);
        
        if ($cursoId) {
            $leccionesQuery->innerJoinWith('Modulos', function ($q) use ($cursoId) {
                return $q->where(['Modulos.curso_id' => $cursoId]);
            });
        }
        
        $lecciones = $leccionesQuery->all();
        $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId', 'cursoId'));
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
            
            // Manejo de subida de archivo (opcional, solo si se proporciona)
            $uploadedFile = $this->request->getUploadedFile('archivo');
            
            if ($uploadedFile && $uploadedFile->getSize() > 0) {
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
                
                $clientMediaType = $uploadedFile->getClientMediaType();
                
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
                    $uploadedFile->moveTo($filePath);
                    $data['archivo'] = 'uploads/contenidos_leccion/' . $filename;
                } else {
                    // Tipo de archivo no permitido
                    $contenidosLeccion->setErrors(['archivo' => ['El tipo de archivo no es permitido. Formatos soportados: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, WEBP, MP4, WEBM']]);
                    $lecciones = $this->ContenidosLeccion->Lecciones->find('list', limit: 200)->all();
                    $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId'));
                    
                    // Si es AJAX, retornar HTML con errores
                    $isAjax = $this->request->is('ajax') || 
                              $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
                    if ($isAjax) {
                        $this->viewBuilder()->setLayout('ajax');
                    }
                    return;
                }
            } else {
                // Si no se proporciona archivo, no lo actualizar
                unset($data['archivo']);
            }
            
            $contenidosLeccion = $this->ContenidosLeccion->patchEntity($contenidosLeccion, $data);
            if ($this->ContenidosLeccion->save($contenidosLeccion)) {
                $this->Flash->success(__('El contenido ha sido guardado.'));

                // Detectar AJAX
                $isAjax = $this->request->is('ajax') || 
                          $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' ||
                          $this->request->getQuery('_ajax') === '1' ||
                          $this->request->getData('_ajax') === '1';

                // Si es AJAX, retornar JSON con redirect
                if ($isAjax) {
                    $leccionId = $contenidosLeccion->leccion_id;
                    return $this->response->withType('application/json')->withStringBody(
                        json_encode([
                            'success' => true, 
                            'message' => 'El contenido ha sido guardado.',
                            'redirect' => $this->Url->build(['controller' => 'Lecciones', 'action' => 'view', $leccionId])
                        ])
                    );
                }

                // Obtener curso_id del request o redirigir a la lección
                $leccionId = $contenidosLeccion->leccion_id;
                return $this->redirect(['controller' => 'Lecciones', 'action' => 'view', $leccionId]);
            }
            
            // Si falla, en AJAX mostrar la vista con errores (no JSON)
            // Esto permite que el modal muestre los errores en el formulario
        }
        
        $lecciones = $this->ContenidosLeccion->Lecciones->find('list', limit: 200)->all();
        $this->set(compact('contenidosLeccion', 'lecciones', 'leccionId'));
        // Usar un layout diferenciado para solicitudes normales o AJAX
        // Detectar AJAX por: X-Requested-With header, _ajax parameter, o método POST/PUT
        $isAjax = $this->request->is('ajax') || 
                  $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' ||
                  $this->request->getQuery('_ajax') === '1' ||
                  $this->request->getData('_ajax') === '1';
        
        if ($isAjax) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
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
        
        // ContenidosLeccion: eliminación física
        if ($this->ContenidosLeccion->delete($contenidosLeccion)) {
            $this->Flash->success(__('Contenido de lección eliminado correctamente.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el contenido. Verifique las dependencias.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Obtener contenidos por lección (AJAX)
     *
     * @return \Cake\Http\Response|null JSON response
     */
    public function obtenerPorLeccion()
    {
        $this->request->allowMethod(['get', 'post']);
        $this->autoRender = false;
        
        $leccionId = $this->request->getQuery('leccion_id');
        
        $contenidos = [];
        if ($leccionId) {
            $contenidosExistentes = $this->ContenidosLeccion->find()
                ->where(['leccion_id' => $leccionId])
                ->order(['posicion' => 'ASC'])
                ->all();
            
            foreach ($contenidosExistentes as $contenido) {
                $contenidos[] = [
                    'id' => $contenido->id,
                    'tipo' => $contenido->tipo,
                    'archivo' => $contenido->archivo,
                    'posicion' => $contenido->posicion
                ];
            }
        }
        
        $response = $this->response->withType('application/json')
            ->withStringBody(json_encode([
                'contenidos' => $contenidos,
                'siguientePosicion' => count($contenidos) + 1
            ]));
        
        return $response;
    }
}

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
        // Cargar curso con todas las relaciones necesarias para vista tipo Domestika
        $curso = $this->Cursos->get($id, [
            'contain' => [
                'Users',
                'Modulos' => [
                    'sort' => ['Modulos.posicion' => 'ASC'],
                    'Lecciones' => [
                        'sort' => ['Lecciones.posicion' => 'ASC'],
                        'ContenidosLeccion'
                    ]
                ],
                'Inscripciones' => ['Users']
            ]
        ]);

        // Obtener usuario actual
        $identity = $this->request->getAttribute('identity');
        $estaAprobado = false;
        $estaPendiente = false;
        $estaRechazado = false;
        $progresoUsuario = 0;

        // Verificar estado de inscripción del usuario actual
        if ($identity) {
            foreach ($curso->inscripciones as $insc) {
                if ($insc->usuario_id == $identity->id) {
                    if ($insc->estado === 'aprobada') {
                        $estaAprobado = true;
                        $progresoUsuario = $insc->progreso;
                    } elseif ($insc->estado === 'pendiente') {
                        $estaPendiente = true;
                    } elseif ($insc->estado === 'rechazada') {
                        $estaRechazado = true;
                    }
                    break;
                }
            }
        }

        // Calcular estadísticas del curso
        $totalLecciones = 0;
        foreach ($curso->modulos as $m) {
            $totalLecciones += count($m->lecciones);
        }
        $totalEstudiantes = count($curso->inscripciones);

        $this->set(compact(
            'curso',
            'estaAprobado',
            'estaPendiente',
            'estaRechazado',
            'progresoUsuario',
            'totalLecciones',
            'totalEstudiantes'
        ));
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
         * if (!$usuario || $usuario->get('rol') != 1) {
         *     $this->Flash->error('No tienes permisos para crear cursos.');
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden crear nuevos cursos en el sistema.
         * Esto centraliza la validación de permisos y mantiene consistencia
         * con los demás controladores.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
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
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para editar cursos.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden editar cursos existentes.
         * Esto incluye modificación de contenido, miniatura y demás propiedades.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
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
        /**
         * Versión anterior (comentada para referencia):
         * $usuario = $this->getRequest()->getAttribute('identity');
         * if (!$usuario || $usuario->rol != 1) {
         *     $this->Flash->error(__('No tienes permisos para eliminar cursos.'));
         *     return $this->redirect(['action' => 'index']);
         * }
         * 
         * Nueva implementación:
         * Utiliza el método requiereAdministrador() del trait ControlAccesoRoles.
         * Solo los administradores pueden eliminar cursos del sistema.
         * Esta es una acción crítica que afecta a múltiples entidades relacionadas.
         */
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
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

    /**
     * Solicitar method
     * 
     * NUEVA FUNCIONALIDAD: Solicitud de inscripción con 1 click (solo para estudiantes).
     * 
     * Proceso optimizado para estudiantes:
     * 1. Valida que el usuario esté autenticado y sea estudiante
     * 2. Verifica que el curso exista
     * 3. Verifica que no tenga inscripción previa (cualquier estado)
     * 4. Crea automáticamente la inscripción en estado 'pendiente'
     * 5. Redirige al dashboard de mis inscripciones
     * 
     * Diferencias con el método add():
     * - No muestra formulario, acción directa
     * - Solo para estudiantes (admin/docente usan add())
     * - Siempre crea en estado 'pendiente'
     * - Validación más estricta de duplicados
     * 
     * @param string|null $id Curso id.
     * @return \Cake\Http\Response|null Redirects
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function solicitar($id = null)
    {
        // Solo estudiantes pueden solicitar inscripción así
        $usuarioActual = $this->request->getAttribute('identity');
        
        if (!$usuarioActual) {
            $this->Flash->error(__('Debes iniciar sesión para solicitar inscripción.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
        if ($usuarioActual->rol != 3) {
            $this->Flash->error(__('Solo los estudiantes pueden solicitar inscripción. Los administradores y docentes deben usar el módulo de inscripciones.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // Validar que el curso exista
        try {
            $curso = $this->Cursos->get($id);
        } catch (\Exception $e) {
            $this->Flash->error(__('El curso seleccionado no existe.'));
            return $this->redirect(['action' => 'student']);
        }
        
        // Cargar el modelo de Inscripciones
        $inscripcionesTable = $this->fetchTable('Inscripciones');
        
        // Verificar si ya existe una inscripción (cualquier estado)
        $inscripcionExistente = $inscripcionesTable->find()
            ->where([
                'usuario_id' => $usuarioActual->id,
                'curso_id' => $id
            ])
            ->first();
        
        if ($inscripcionExistente) {
            if ($inscripcionExistente->estado === 'aprobada') {
                $this->Flash->warning(__('Ya estás inscrito en este curso.'));
            } elseif ($inscripcionExistente->estado === 'pendiente') {
                $this->Flash->warning(__('Ya tienes una solicitud pendiente para este curso.'));
            } else { // rechazada
                $this->Flash->error(__('Tu solicitud anterior fue rechazada. Contacta al administrador para más información.'));
            }
            return $this->redirect(['controller' => 'Inscripciones', 'action' => 'misInscripciones']);
        }
        
        // Crear nueva inscripción
        $inscripcion = $inscripcionesTable->newEntity([
            'usuario_id' => $usuarioActual->id,
            'curso_id' => $id,
            'progreso' => 0,
            'estado' => 'pendiente'
        ]);
        
        if ($inscripcionesTable->save($inscripcion)) {
            $this->Flash->success(__('¡Tu solicitud de inscripción al curso "{0}" ha sido enviada! Espera la aprobación del administrador.', $curso->titulo));
            return $this->redirect(['controller' => 'Inscripciones', 'action' => 'misInscripciones']);
        } else {
            $this->Flash->error(__('No se pudo completar la solicitud. Por favor, intenta nuevamente.'));
            return $this->redirect(['action' => 'view', $id]);
        }
    }
}

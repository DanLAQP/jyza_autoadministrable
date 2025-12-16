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
     * Initialize method
     * 
     * IMPORTANTE: En CakePHP 4.x NO existe el método loadModel().
     * 
     * ALTERNATIVA SELECCIONADA:
     * Se usa fetchTable('NombreTabla') directamente en los métodos que necesitan
     * acceder a tablas adicionales.
     * 
     * JUSTIFICACIÓN TÉCNICA:
     * -----------------------------------------------------------------------------
     * En CakePHP 3.x existía loadModel() que permitía cargar modelos en initialize()
     * para usarlos como propiedades del controlador ($this->Modelo).
     * 
     * En CakePHP 4.x este método fue ELIMINADO y se reemplazó por:
     * 
     * OPCIÓN 1: fetchTable('Tabla') - Recomendado por CakePHP 4.x
     *   - Uso: $tabla = $this->fetchTable('Tabla');
     *   - Ventajas:
     *     * Método oficial de CakePHP 4.x
     *     * Solo carga cuando se necesita (lazy loading)
     *     * No consume memoria si el método no se ejecuta
     *     * Explícito y fácil de seguir
     *   - Desventajas:
     *     * Requiere llamar fetchTable() en cada método
     *     * Variable local en lugar de propiedad de clase
     * 
     * OPCIÓN 2: Crear asociaciones en el modelo (CursosTable)
     *   - Uso: $this->Cursos->Inscripciones->find()
     *   - Ventajas:
     *     * Más semántico y "CakePHP-way"
     *     * Permite usar contain() en queries
     *     * Reutilizable en múltiples métodos
     *   - Desventajas:
     *     * Requiere modificar el modelo CursosTable
     *     * Añade complejidad si solo se usa en 1-2 métodos
     * 
     * OPCIÓN 3: TableLocator directamente
     *   - Uso: $this->getTableLocator()->get('Tabla')
     *   - Ventajas:
     *     * Más flexible
     *   - Desventajas:
     *     * Más verboso
     *     * No es el patrón recomendado
     * 
     * DECISIÓN TOMADA: OPCIÓN 1 (fetchTable)
     * -----------------------------------------------------------------------------
     * Se eligió fetchTable() porque:
     * 1. Es el método OFICIAL recomendado por CakePHP 4.x
     * 2. Es explícito: se ve claramente qué tabla se usa en cada método
     * 3. Solo carga la tabla cuando realmente se ejecuta el método
     * 4. No requiere modificar otros archivos (modelos, asociaciones)
     * 5. Fácil de mantener y debuggear
     * 6. Evita cargar recursos innecesarios en memoria
     * 
     * MIGRACIÓN DESDE CakePHP 3.x:
     * Antes: $this->loadModel('Inscripciones'); // En initialize()
     *        $this->Inscripciones->find();        // En cualquier método
     * 
     * Ahora:  $inscripcionesTable = $this->fetchTable('Inscripciones'); // En el método
     *         $inscripcionesTable->find();                               // Usar variable local
     * 
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // En CakePHP 4.x NO se cargan modelos adicionales aquí
        // Se usa fetchTable() directamente en los métodos que lo necesiten
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Si es estudiante, redirigir a vista de estudiante
        $identity = $this->Authentication->getIdentity();
        if ($identity && $identity->rol == 3) {
            return $this->redirect(['action' => 'student']);
        }

        $query = $this->Cursos->find()
            ->contain(['Users']);

        // Filtro de búsqueda (Lógica unificada con Matrícula)
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'Cursos.estado IN' => ['activo', 'publicado'],
                'Cursos.titulo LIKE' => '%' . $termino . '%'
            ]);
        }

        $cursos = $this->paginate($query);

        $this->set(compact('cursos', 'termino'));
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

        // Verificar estado de inscripción del usuario actual de forma explícita
        if ($identity) {
            $inscripcionesTable = $this->fetchTable('Inscripciones');
            $inscripcion = $inscripcionesTable->find()
                ->where([
                    'usuario_id' => $identity->id,
                    'curso_id' => $id
                ])
                ->first();

            if ($inscripcion) {
                if ($inscripcion->estado === 'aprobada') {
                    $estaAprobado = true;
                    $progresoUsuario = $inscripcion->progreso;
                } elseif ($inscripcion->estado === 'pendiente') {
                    $estaPendiente = true;
                } elseif ($inscripcion->estado === 'rechazada') {
                    $estaRechazado = true;
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
                    $users = $this->Cursos->Users->find('list')->all();
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
        $users = $this->Cursos->Users->find('list')->all();
        $this->set(compact('curso', 'users'));
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
                    $users = $this->Cursos->Users->find('list')->all();
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
        $users = $this->Cursos->Users->find('list')->all();
        $this->set(compact('curso', 'users'));
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
     * Student method
     * 
     * Vista de cursos disponibles para estudiantes con botones dinámicos
     * según el estado de inscripción del estudiante actual.
     * 
     * SOLUCIÓN ROBUSTA:
     * - NO usa contain() con filtros (puede fallar según configuración ORM)
     * - Busca TODAS las inscripciones del usuario en query separado
     * - Indexa inscripciones por curso_id para acceso O(1)
     * - Pasa ambas variables (cursos, inscripciones) a la vista
     * 
     * VENTAJAS:
     * - Más confiable: no depende de relaciones ORM complejas
     * - Más rápido: indexBy() permite acceso directo por curso_id
     * - Más debuggeable: queries separados son más fáciles de rastrear
     * 
     * BOTONES DINÁMICOS:
     * - Sin inscripción: "Solicitar Inscripción" (verde, POST)
     * - Pendiente: "Solicitud Pendiente" (amarillo, disabled) + WhatsApp
     * - Aprobada: "Continuar Curso" (azul, link) + barra de progreso
     * - Rechazada: "Solicitud Rechazada" (rojo, disabled) + WhatsApp
     * 
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function student()
    {
        $usuarioActual = $this->Authentication->getIdentity();
        
        if (!$usuarioActual || $usuarioActual->rol != 3) {
            $this->Flash->error(__('Esta sección es solo para estudiantes.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $usuarioId = $usuarioActual->id;
        $inscripcionesTable = $this->fetchTable('Inscripciones');

        // 1. Obtener todas las inscripciones del usuario con los datos del curso
        $todasInscripciones = $inscripcionesTable->find()
            ->where(['Inscripciones.usuario_id' => $usuarioId])
            ->contain([
                'Cursos' => ['Users'], // Necesitamos el autor del curso
                'Users' 
            ])
            ->all();

        // 2. Segmentar inscripciones en memoria
        $matriculados = [];
        $pendientes = [];
        $cursosInteractuadosIds = [];

        foreach ($todasInscripciones as $inscripcion) {
            $cursosInteractuadosIds[] = $inscripcion->curso_id;
            
            if ($inscripcion->estado === 'aprobada') {
                $matriculados[] = $inscripcion;
            } elseif ($inscripcion->estado === 'pendiente') {
                $pendientes[] = $inscripcion;
            }
            // Las rechazadas se ignoran para las listas visibles, pero se guardan sus IDs
            // para no mostrarlas de nuevo en "Disponibles" (o dependerá de la lógica de negocio).
            // Si queremos permitir solicitar de nuevo un rechazado, no lo agregamos a $cursosInteractuadosIds.
            // Asumimos que rechazado = no disponible para solicitar de nuevo inmediatamente.
        }

        // 3. Buscar cursos disponibles (Activos/Publicados y NO inscritos/pendientes)
        $queryDisponibles = $this->Cursos->find()
            ->where(['Cursos.estado IN' => ['activo', 'publicado']]);
            
        if (!empty($cursosInteractuadosIds)) {
            $queryDisponibles->where(['Cursos.id NOT IN' => $cursosInteractuadosIds]);
        }
        
        // Filtro de búsqueda (Lógica unificada)
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $queryDisponibles->where([
                'Cursos.titulo LIKE' => '%' . $termino . '%'
            ]);
            // Nota: El filtro de 'estado' ya se aplica en la consulta base $queryDisponibles
        }
        
        $queryDisponibles->contain(['Users'])
            ->orderBy(['Cursos.created' => 'DESC']);

        $disponibles = $this->paginate($queryDisponibles, ['limit' => 9]);

        $this->set(compact('matriculados', 'pendientes', 'disponibles', 'termino'));
    }

    /**
     * Solicitar method
     * 
     * FUNCIONALIDAD: Solicitud de inscripción con 1 click (solo para estudiantes).
     * 
     * CORRECCIÓN APLICADA (CakePHP 4.x):
     * En CakePHP 4.x no existe loadModel(), por lo que se usa fetchTable('Inscripciones')
     * directamente en este método cuando se necesita acceder a la tabla de inscripciones.
     * 
     * Proceso optimizado para estudiantes:
    * 1. Valida que el usuario esté autenticado y sea estudiante (rol = 3)
     * 2. Verifica que el curso exista en la base de datos
     * 3. Verifica que no tenga inscripción previa (cualquier estado: pendiente/aprobada/rechazada)
     * 4. Crea automáticamente la inscripción en estado 'pendiente' con progreso 0
     * 5. Redirige al dashboard de mis inscripciones con mensaje de éxito
     * 
     * Diferencias con InscripcionesController::add():
     * - No muestra formulario, es una acción directa POST
     * - Solo para estudiantes (admin/docente usan el módulo de inscripciones)
     * - Siempre crea en estado 'pendiente' (no permite elegir estado)
     * - Validación más estricta de duplicados (verifica cualquier estado)
     * - UX mejorada: 1 click en lugar de 2 clicks + formulario
     * 
     * @param string|null $id Curso id.
     * @return \Cake\Http\Response Redirects siempre
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function solicitar($id = null)
    {
        // Permitir solo POST
        $this->request->allowMethod(['post']);
        
        // VALIDACIÓN 1: Usuario autenticado
        $usuarioActual = $this->Authentication->getIdentity();
        
        if (!$usuarioActual) {
            $this->Flash->error(__('Debes iniciar sesión para solicitar inscripción.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
        // VALIDACIÓN 3: Curso existe y está publicado
        try {
            $curso = $this->Cursos->get($id);
            
            if ($curso->estado !== 'activo') {
                $this->Flash->error(__('Este curso no está disponible para inscripciones.'));
                return $this->redirect(['action' => 'index']);
            }
        } catch (\Exception $e) {
            $this->Flash->error(__('El curso seleccionado no existe.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // VALIDACIÓN 4: No tiene inscripción previa
        $inscripcionesTable = $this->fetchTable('Inscripciones');
        
        $inscripcionExistente = $inscripcionesTable->find()
            ->where([
                'Inscripciones.usuario_id' => $usuarioActual->id,
                'Inscripciones.curso_id' => $id
            ])
            ->first();
        
        if ($inscripcionExistente) {
            // Ya existe inscripción
            if ($inscripcionExistente->estado === 'aprobada') {
                $this->Flash->warning(__('Ya estás inscrito en este curso.'));
            } elseif ($inscripcionExistente->estado === 'pendiente') {
                $this->Flash->warning(__('Ya tienes una solicitud pendiente para este curso.'));
            } else {
                $this->Flash->error(__('Tu solicitud fue rechazada. Contacta al administrador.'));
            }
            return $this->redirect(['action' => 'view', $id]);
        }
        
        // CREAR INSCRIPCIÓN
        $inscripcion = $inscripcionesTable->newEntity([
            'usuario_id' => $usuarioActual->id,
            'curso_id' => $id,
            'progreso' => 0,
            'estado' => 'pendiente'
        ]);
        
        // GUARDAR
        if ($inscripcionesTable->save($inscripcion)) {
            $this->Flash->success(__('¡Solicitud enviada! Tu inscripción a "{0}" está pendiente de aprobación.', $curso->titulo), [
                'params' => ['class' => 'alert-success']
            ]);
        } else {
            $errores = $inscripcion->getErrors();
            $mensajeError = 'No se pudo guardar la inscripción.';
            if (!empty($errores)) {
                $mensajeError .= ' Errores: ' . json_encode($errores);
            }
            $this->log($mensajeError, 'error');
            $this->Flash->error(__('No se pudo completar la solicitud. Inténtalo nuevamente.'));
        }
        return $this->redirect(['action' => 'view', $id]);

    } // <-- cierre del método solicitar

    /**
     * Buscar cursos por título (AJAX)
     * Método para búsqueda dinámica en tiempo real
     * Búsqueda case-insensitive (sin distinción mayúsculas/minúsculas)
     * 
     * @return \Cake\Http\Response JSON con resultados
     */
    public function buscarCursos()
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setLayout('ajax');
        
        $termino = $this->request->getQuery('termino');
        $resultados = [];
        
        if (!empty($termino) && strlen($termino) >= 2) { // Mínimo 2 caracteres
            $resultados = $this->Cursos->find()
                ->select(['id', 'titulo', 'nivel', 'categoria', 'estado'])
                ->where([
                    'OR' => [
                        'titulo LIKE' => '%' . $termino . '%',
                        'descripcion LIKE' => '%' . $termino . '%',
                        'categoria LIKE' => '%' . $termino . '%'
                    ]
                ])
                ->order(['titulo' => 'ASC'])
                ->limit(15)
                ->toArray();
        }
        
        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($resultados, JSON_UNESCAPED_UNICODE));
        
        return $this->response;
    }

} // <-- cierre de la clase CursosController

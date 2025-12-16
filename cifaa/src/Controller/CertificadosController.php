<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenDate;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Certificados Controller
 *
 * @property \App\Model\Table\CertificadosTable $Certificados
 */
class CertificadosController extends AppController
{
    /**
     * beforeFilter method
     * Allow public access to verification action
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir acceso público a la verificación de certificados
        $this->Authentication->addUnauthenticatedActions(['verificar']);
    }

    /**
     * Index method (Admin only)
     * Lists all certificates and allows managing them.
     */
    public function index()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $query = $this->Certificados->find()
            ->contain(['Titulares', 'Cursos'])
            ->order(['Certificados.created' => 'DESC']);
            
        // Filtro de búsqueda
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'OR' => [
                    'Certificados.nombre_completo LIKE' => '%' . $termino . '%',
                    'Certificados.dni LIKE' => '%' . $termino . '%',
                    'Titulares.nombre_completo LIKE' => '%' . $termino . '%'
                ]
            ]);
        }
            
        $certificados = $this->paginate($query);

        $this->set(compact('certificados', 'termino'));
    }

    /**
     * Generar method (Admin only)
     * Genera un certificado personalizado sin restricciones.
     * Permite ingreso manual de todos los datos.
     */
    public function generar()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $certificado = $this->Certificados->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // DEBUG: Log TODOS los datos recibidos
            $this->log("========== DATOS RECIBIDOS DEL FORMULARIO ==========", 'debug');
            $this->log("DNI: " . ($data['dni'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Nombre Completo: " . ($data['nombre_completo'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Nombre Curso: " . ($data['nombre_curso'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Curso ID: " . ($data['curso_id'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Horas: " . ($data['horas'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Módulos: " . (isset($data['modulo_tema']) ? count($data['modulo_tema']) : '0'), 'debug');
            $this->log("===================================================", 'debug');
            
            // PASO CRÍTICO: Gestionar titular (buscar o crear)
            $titularId = $this->gestionarTitular($data);
            
            $this->log(">>> Titular ID obtenido: " . ($titularId ?? 'NULL'), 'debug');
            
            if (!$titularId) {
                $this->Flash->error(__('Error al procesar datos del titular. Verifique DNI y nombre completo.'));
                $this->log("ERROR: gestionarTitular retornó NULL", 'error');
                // Recargar formulario con datos
                goto cargarFormulario;
            }
            
            // Procesar módulos desde el formulario dinámico
            $modulosArray = [];
            if (!empty($data['modulo_tema']) && is_array($data['modulo_tema'])) {
                $numeroRomano = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                foreach ($data['modulo_tema'] as $index => $tema) {
                    if (!empty($tema)) {
                        $modulosArray[] = [
                            'numero' => $numeroRomano[$index] ?? ($index + 1),
                            'tema' => $tema
                        ];
                    }
                }
            }
            
            // Generar código único
            $codigo = 'CER-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 10));
            
            // Formatear fechas si vienen del datepicker
            $fechaInicio = null;
            $fechaFin = null;
            
            if (!empty($data['fecha_inicio'])) {
                if ($data['fecha_inicio'] instanceof \Cake\I18n\FrozenDate) {
                    $fechaInicio = $data['fecha_inicio']->format('d \d\e F \d\e Y');
                } elseif (is_string($data['fecha_inicio'])) {
                    try {
                        $date = new \DateTime($data['fecha_inicio']);
                        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                                  'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                        $fechaInicio = $date->format('d') . ' de ' . $meses[(int)$date->format('m') - 1] . ' de ' . $date->format('Y');
                    } catch (\Exception $e) {
                        $fechaInicio = $data['fecha_inicio'];
                    }
                }
            }
            
            if (!empty($data['fecha_fin'])) {
                if ($data['fecha_fin'] instanceof \Cake\I18n\FrozenDate) {
                    $fechaFin = $data['fecha_fin']->format('d \d\e F \d\e Y');
                } elseif (is_string($data['fecha_fin'])) {
                    try {
                        $date = new \DateTime($data['fecha_fin']);
                        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                                  'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                        $fechaFin = $date->format('d') . ' de ' . $meses[(int)$date->format('m') - 1] . ' de ' . $date->format('Y');
                    } catch (\Exception $e) {
                        $fechaFin = $data['fecha_fin'];
                    }
                }
            }
            
            // Preparar datos del certificado (NUEVA ARQUITECTURA: usa titular_id)
            $certificadoData = [
                'titular_id' => $titularId,  // ← NUEVO: titular en lugar de user
                'curso_id' => !empty($data['curso_id']) ? $data['curso_id'] : null,
                'dni' => trim($data['dni'] ?? ''),  // ← Guardar DNI también en certificados
                'nombre_completo' => trim($data['nombre_completo'] ?? ''),
                'nombre_curso' => trim($data['nombre_curso'] ?? ''),
                'horas' => (int)($data['horas'] ?? 0),
                'nota_final' => !empty($data['nota_final']) ? $data['nota_final'] : null,
                'duracion_meses' => !empty($data['duracion_meses']) ? (int)$data['duracion_meses'] : null,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'modulos' => !empty($modulosArray) ? json_encode($modulosArray, JSON_UNESCAPED_UNICODE) : null,
                'fecha_emision' => date('Y-m-d'),
                'codigo' => $codigo,
                'estado' => 'activo'
            ];
            
            // Aplicar datos al entity
            $certificado = $this->Certificados->patchEntity($certificado, $certificadoData);
            
            // Debug: Log data being saved
            $this->log("====== GUARDANDO CERTIFICADO CON TITULARES ======", 'debug');
            $this->log("Titular ID: {$titularId}", 'debug');
            $this->log("Codigo: {$codigo}", 'debug');
            $this->log("Nombre: {$certificado->nombre_completo}", 'debug');
            $this->log("Curso: {$certificado->nombre_curso}", 'debug');
            $this->log("================================================", 'debug');
            
            if ($this->Certificados->save($certificado)) {
                $this->log("Certificado generado exitosamente. ID: {$certificado->id}, Codigo: {$codigo}, Titular ID: {$titularId}", 'info');
                $this->Flash->success(__('Certificado generado exitosamente. Código: {0}', $codigo));
                
                return $this->redirect(['action' => 'index']);
            } else {
                $errors = $certificado->getErrors();
                $this->log("ERROR al guardar certificado. Errores: " . json_encode($errors), 'error');
                $this->Flash->error(__('Error al guardar el certificado. Revise los datos ingresados.'));
            }
        }
        
        cargarFormulario:
        // Cargar listas para los dropdowns del formulario
        // NOTA: Ya no se carga lista de users, ahora se ingresa DNI del titular directamente
        $cursos = $this->Certificados->Cursos->find('list', [
            'keyField' => 'id',
            'valueField' => 'titulo'
        ])->order(['titulo' => 'ASC'])
          ->all();

        $esDiplomado = false;
        $this->set(compact('certificado', 'cursos', 'esDiplomado'));
    }

    /**
     * Generar Diplomado method
     * Método idéntico a generar() pero cambia el título de "CERTIFICADO" a "DIPLOMADO" en el PDF
     */
    public function generarDiplomado()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $certificado = $this->Certificados->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // DEBUG: Log TODOS los datos recibidos
            $this->log("========== DATOS RECIBIDOS DEL FORMULARIO (DIPLOMADO) ==========", 'debug');
            $this->log("DNI: " . ($data['dni'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Nombre Completo: " . ($data['nombre_completo'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Nombre Curso: " . ($data['nombre_curso'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Curso ID: " . ($data['curso_id'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Horas: " . ($data['horas'] ?? 'NO ENVIADO'), 'debug');
            $this->log("Módulos: " . (isset($data['modulo_tema']) ? count($data['modulo_tema']) : '0'), 'debug');
            $this->log("===================================================================", 'debug');
            
            // Procesar módulos desde el formulario dinámico
            $modulosArray = [];
            if (!empty($data['modulo_tema']) && is_array($data['modulo_tema'])) {
                $numeroRomano = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                foreach ($data['modulo_tema'] as $index => $tema) {
                    if (!empty($tema)) {
                        $modulosArray[] = [
                            'numero' => $numeroRomano[$index] ?? ($index + 1),
                            'tema' => $tema
                        ];
                    }
                }
            }
            
            // Generar código único (DIP en lugar de CER)
            $codigo = 'DIP-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 10));
            
            // Formatear fechas si vienen del datepicker
            $fechaInicio = null;
            $fechaFin = null;
            
            if (!empty($data['fecha_inicio'])) {
                if ($data['fecha_inicio'] instanceof \Cake\I18n\FrozenDate) {
                    $fechaInicio = $data['fecha_inicio']->format('d \d\e F \d\e Y');
                } elseif (is_string($data['fecha_inicio'])) {
                    try {
                        $date = new \DateTime($data['fecha_inicio']);
                        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                                  'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                        $fechaInicio = $date->format('d') . ' de ' . $meses[(int)$date->format('m') - 1] . ' de ' . $date->format('Y');
                    } catch (\Exception $e) {
                        $fechaInicio = $data['fecha_inicio'];
                    }
                }
            }
            
            if (!empty($data['fecha_fin'])) {
                if ($data['fecha_fin'] instanceof \Cake\I18n\FrozenDate) {
                    $fechaFin = $data['fecha_fin']->format('d \d\e F \d\e Y');
                } elseif (is_string($data['fecha_fin'])) {
                    try {
                        $date = new \DateTime($data['fecha_fin']);
                        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 
                                  'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                        $fechaFin = $date->format('d') . ' de ' . $meses[(int)$date->format('m') - 1] . ' de ' . $date->format('Y');
                    } catch (\Exception $e) {
                        $fechaFin = $data['fecha_fin'];
                    }
                }
            }
            
            // PASO CRÍTICO: Gestionar titular (buscar o crear)
            $titularId = $this->gestionarTitular($data);
            
            $this->log(">>> Titular ID obtenido (Diplomado): " . ($titularId ?? 'NULL'), 'debug');
            
            if (!$titularId) {
                $this->Flash->error(__('Error al procesar datos del titular. Verifique DNI y nombre completo.'));
                $this->log("ERROR: gestionarTitular retornó NULL (Diplomado)", 'error');
                goto cargarFormulario;
            }
            
            // Preparar datos del diplomado (NUEVA ARQUITECTURA: usa titular_id)
            $certificadoData = [
                'titular_id' => $titularId,  // ← NUEVO: titular en lugar de user
                'curso_id' => !empty($data['curso_id']) ? $data['curso_id'] : null,
                'dni' => trim($data['dni'] ?? ''),  // ← Guardar DNI también en certificados
                'nombre_completo' => trim($data['nombre_completo'] ?? ''),
                'nombre_curso' => trim($data['nombre_curso'] ?? ''),
                'horas' => (int)($data['horas'] ?? 0),
                'nota_final' => !empty($data['nota_final']) ? $data['nota_final'] : null,
                'duracion_meses' => !empty($data['duracion_meses']) ? (int)$data['duracion_meses'] : null,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'modulos' => !empty($modulosArray) ? json_encode($modulosArray, JSON_UNESCAPED_UNICODE) : null,
                'fecha_emision' => date('Y-m-d'),
                'codigo' => $codigo,
                'estado' => 'activo'
            ];
            
            $certificado = $this->Certificados->patchEntity($certificado, $certificadoData);
            
            // Debug: Log data being saved
            $this->log("====== GUARDANDO DIPLOMADO CON TITULARES ======", 'debug');
            $this->log("Titular ID: {$titularId}", 'debug');
            $this->log("Codigo: {$codigo}", 'debug');
            $this->log("Nombre: {$certificado->nombre_completo}", 'debug');
            $this->log("Curso: {$certificado->nombre_curso}", 'debug');
            $this->log("================================================", 'debug');
            
            if ($this->Certificados->save($certificado)) {
                $this->log("Diplomado generado exitosamente. ID: {$certificado->id}, Codigo: {$codigo}, Titular ID: {$titularId}", 'info');
                $this->Flash->success(__('Diplomado generado exitosamente. Código: {0}', $codigo));
                return $this->redirect(['action' => 'diplomados']);
            } else {
                $errors = $certificado->getErrors();
                $this->log("ERROR al guardar diplomado. Errores: " . json_encode($errors), 'error');
                $this->Flash->error(__('Error al guardar el diplomado. Revise los datos ingresados.'));
            }
        }
        
        cargarFormulario:
        
        // Cargar listas para los dropdowns del formulario
        // NOTA: Ya no se carga lista de users, ahora se ingresa DNI del titular directamente
        $cursos = $this->Certificados->Cursos->find('list', [
            'keyField' => 'id',
            'valueField' => 'titulo'
        ])->order(['titulo' => 'ASC'])
          ->all();

        $esDiplomado = true; // Variable para mostrar "DIPLOMADO" en lugar de "CERTIFICADO"
        $this->set(compact('certificado', 'cursos', 'esDiplomado'));
        $this->render('generar'); // Usa la misma vista que generar
    }

    /**
     * Mis Certificados (Student only)
     * Shows certificates belonging to the current user.
     * 
     * Nueva arquitectura con Titulares:
     * - Busca certificados por titular_id en lugar de user_id
     * - Si el usuario no tiene titular vinculado, muestra mensaje
     * - Hereda certificados emitidos ANTES de crear la cuenta
     */
    public function misCertificados()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // Obtener titular_id del usuario
        $this->loadModel('Users');
        $usuarioCompleto = $this->Users->get($user->id, ['contain' => ['Titulares']]);
        
        if (!$usuarioCompleto->titular_id) {
            $this->Flash->warning(__('No tiene un titular vinculado. Contacte al administrador para vincular su DNI.'));
            $this->set('certificados', []);
            $this->set('termino', null);
            return;
        }

        $query = $this->Certificados->find()
            ->contain(['Cursos', 'Titulares'])
            ->where(['Certificados.titular_id' => $usuarioCompleto->titular_id])
            ->order(['Certificados.created' => 'DESC']);

        // Filtro de búsqueda
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'OR' => [
                    'Cursos.titulo LIKE' => '%' . $termino . '%',
                    'Certificados.codigo LIKE' => '%' . $termino . '%',
                    'Certificados.nombre_curso LIKE' => '%' . $termino . '%'
                ]
            ]);
        }

        $certificados = $this->paginate($query);

        $this->set(compact('certificados', 'termino'));
        $this->log("Usuario {$user->username} (titular_id: {$usuarioCompleto->titular_id}) accedió a sus certificados", 'info');
    }

    /**
     * Diplomados method
     * Lista únicamente los diplomados (certificados con código DIP-)
     * Reutiliza el mismo template del index para mantener consistencia visual
     */
    public function diplomados()
    {
        // Filtrar solo diplomados por el prefijo del código
        $query = $this->Certificados->find()
            ->contain(['Titulares', 'Cursos'])
            ->where(['Certificados.codigo LIKE' => 'DIP-%'])
            ->order(['Certificados.created' => 'DESC']);

        // Filtro por estado (activo/anulado/todos)
        $filtroEstado = $this->request->getQuery('estado', 'activo');
        if ($filtroEstado !== 'todos') {
            $query->where(['Certificados.estado' => $filtroEstado]);
        }

        // Filtro de búsqueda
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'OR' => [
                    'Certificados.codigo LIKE' => '%' . $termino . '%',
                    'Certificados.nombre_completo LIKE' => '%' . $termino . '%',
                    'Certificados.dni LIKE' => '%' . $termino . '%',
                    'Certificados.nombre_curso LIKE' => '%' . $termino . '%',
                    'Titulares.nombre_completo LIKE' => '%' . $termino . '%',
                    'Cursos.titulo LIKE' => '%' . $termino . '%'
                ]
            ]);
        }

        $certificados = $this->paginate($query);

        // Pasar variables al template (reutiliza el template index)
        $this->set(compact('certificados', 'filtroEstado', 'termino'));
        $this->set('esDiplomado', true); // Variable para personalizar títulos en la vista
        $this->viewBuilder()->setTemplate('index'); // Usa el mismo template del index
    }

    /**
     * Descargar PDF
     * Descarga el certificado existente o lo genera si no existe.
     * 
     * Flujo:
     * 1. Buscar certificado por ID en base de datos
     * 2. Verificar permisos del usuario
     * 3. Si existe archivo PDF guardado, enviarlo directamente
     * 4. Si no existe, generar nuevo PDF y guardarlo
     * 5. Actualizar registro en BD con ruta del archivo
     * 6. Enviar PDF para descarga al navegador
     */
    public function descargar($id = null)
    {
        // PASO 1: Buscar certificado por ID con datos relacionados
        try {
            $certificado = $this->Certificados->get($id, [
                'contain' => ['Titulares', 'Cursos']
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Certificado no encontrado.'));
            $this->log("Error al buscar certificado ID: {$id}. Error: " . $e->getMessage(), 'error');
            return $this->redirect(['action' => 'index']);
        }

        // PASO 2: Verificar permisos de acceso
        $user = $this->Authentication->getIdentity();
        
        // Permitir: Administradores (rol=1) o el usuario dueño del certificado
        if (!$user || ($user->rol != 1 && $user->id != $certificado->user_id)) {
            $this->Flash->error(__('No tiene permiso para descargar este certificado.'));
            $this->log("Acceso denegado al certificado ID: {$id}. Usuario: " . ($user ? $user->id : 'no autenticado'), 'warning');
            return $this->redirect(['action' => 'misCertificados']);
        }

        // PASO 3: Verificar si el archivo PDF ya existe en el servidor
        if (!empty($certificado->archivo_pdf)) {
            $rutaCompleta = WWW_ROOT . $certificado->archivo_pdf;
            
            if (file_exists($rutaCompleta)) {
                // CASO A: Archivo existe, enviarlo directamente sin regenerar
                $this->log("Descargando certificado existente. ID: {$id}, Archivo: {$certificado->archivo_pdf}", 'info');
                
                return $this->response->withFile($rutaCompleta, [
                    'download' => true,
                    'name' => basename($certificado->archivo_pdf)
                ]);
            } else {
                // Archivo registrado en BD pero no existe físicamente
                $this->log("Archivo perdido. ID: {$id}, Ruta registrada: {$certificado->archivo_pdf}. Regenerando...", 'warning');
            }
        }

        // PASO 4: Generar nuevo PDF (primera vez o archivo perdido)
        $this->log("Generando nuevo PDF para certificado ID: {$id}", 'info');
        
        // PASO 4.1: Convertir imágenes a Base64 para embeber en PDF
        $logoPath = WWW_ROOT . 'img' . DS . 'logoCifa.png';
        $firmaPath = WWW_ROOT . 'img' . DS . 'firma.png';

        $logoBase64 = null;
        $firmaBase64 = null;

        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        } else {
            $this->log("Logo no encontrado en: {$logoPath}", 'warning');
        }

        if (file_exists($firmaPath)) {
            $firmaData = file_get_contents($firmaPath);
            $firmaBase64 = 'data:image/png;base64,' . base64_encode($firmaData);
        } else {
            $this->log("Firma no encontrada en: {$firmaPath}", 'warning');
        }

        // PASO 4.2: Configurar DomPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');
        
        $dompdf = new Dompdf($options);
        
        // PASO 4.3: Generar URL de verificación dinámica
        $baseUrl = $this->request->getUri()->getScheme() . '://' . 
                   $this->request->getUri()->getHost();
        
        // Agregar puerto solo si no es estándar (80 para HTTP, 443 para HTTPS)
        $port = $this->request->getUri()->getPort();
        if ($port && $port != 80 && $port != 443) {
            $baseUrl .= ':' . $port;
        }
        
        // Agregar webroot (subdirectorio si existe)
        $baseUrl .= $this->request->getAttribute('webroot');
        
        // URL completa de verificación
        $verificarUrl = $baseUrl . 'certificados/verificar/' . $certificado->codigo;
        
        $this->log("URL de verificación generada: {$verificarUrl}", 'debug');
        
        // PASO 4.4: Determinar si es CERTIFICADO o DIPLOMADO según el código
        $esDiplomado = strpos($certificado->codigo, 'DIP-') === 0;
        
        // PASO 4.5: Renderizar HTML del certificado/diplomado
        $html = $this->viewBuilder()
            ->setClassName('Cake\View\View')
            ->setTemplatePath('Certificados/pdf')
            ->setTemplate('certificado')
            ->setLayout('ajax')
            ->setOption('serialize', ['certificado', 'logoBase64', 'firmaBase64', 'verificarUrl', 'esDiplomado'])
            ->setVar('certificado', $certificado)
            ->setVar('logoBase64', $logoBase64)
            ->setVar('firmaBase64', $firmaBase64)
            ->setVar('verificarUrl', $verificarUrl)
            ->setVar('esDiplomado', $esDiplomado)
            ->build()
            ->render();

        // PASO 4.6: Generar PDF en memoria
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $pdfOutput = $dompdf->output();

        // PASO 5: Guardar PDF en el servidor para uso futuro
        $tipoDoc = $esDiplomado ? 'diplomado' : 'certificado';
        $filename = $tipoDoc . '_' . $certificado->codigo . '.pdf';
        $dirPath = WWW_ROOT . 'uploads' . DS . 'certificados';
        
        // Crear directorio si no existe
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
            $this->log("Directorio de certificados creado: {$dirPath}", 'info');
        }
        
        $rutaCompleta = $dirPath . DS . $filename;
        $rutaRelativa = 'uploads' . DS . 'certificados' . DS . $filename;
        
        // Guardar archivo físico
        $bytesEscritos = file_put_contents($rutaCompleta, $pdfOutput);
        
        if ($bytesEscritos !== false) {
            $this->log("PDF guardado correctamente. ID: {$id}, Ruta: {$rutaCompleta}, Tamaño: {$bytesEscritos} bytes", 'info');
            
            // PASO 6: Actualizar registro en BD con la ruta del archivo
            $certificado->archivo_pdf = $rutaRelativa;
            if ($this->Certificados->save($certificado)) {
                $this->log("Registro actualizado en BD. ID: {$id}, archivo_pdf: {$rutaRelativa}", 'info');
            } else {
                $this->log("Error al actualizar registro en BD. ID: {$id}", 'error');
            }
        } else {
            $this->log("Error al guardar archivo PDF. ID: {$id}, Ruta: {$rutaCompleta}", 'error');
        }

        // PASO 7: Enviar PDF al navegador para descarga
        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withStringBody($pdfOutput);
    }

    /**
     * Delete method (Admin only)
     */
    /**
     * Anular method (Admin only)
     * Marca el certificado como 'anulado' sin borrarlo de la base de datos
     * Un certificado anulado queda como inválido pero permanece en el registro
     */
    public function anular($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $this->request->allowMethod(['post']);
        $certificado = $this->Certificados->get($id);
        
        $codigoOriginal = $certificado->codigo;
        $esDiplomado = strpos($codigoOriginal, 'DIP-') === 0;
        
        // Anular: cambiar estado a 'anulado'
        $certificado->estado = 'anulado';
        
        if ($this->Certificados->save($certificado)) {
            $tipo = $esDiplomado ? 'Diplomado' : 'Certificado';
            $this->Flash->success(__("{$tipo} {0} anulado correctamente. El certificado quedará marcado como inválido.", $codigoOriginal));
            $this->log("Certificado {$codigoOriginal} anulado por admin", 'info');
        } else {
            $this->Flash->error(__('No se pudo anular el certificado.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }
    
    /**
     * Restaurar method (Admin only)
     * Restaura un certificado previamente anulado, cambiando su estado a 'activo'
     * Esto reactiva el certificado haciéndolo válido nuevamente
     */
    public function restaurar($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $this->request->allowMethod(['post']);
        $certificado = $this->Certificados->get($id);
        
        $codigoOriginal = $certificado->codigo;
        $esDiplomado = strpos($codigoOriginal, 'DIP-') === 0;
        
        // Restaurar: cambiar estado de 'anulado' a 'activo'
        $certificado->estado = 'activo';
        
        if ($this->Certificados->save($certificado)) {
            $tipo = $esDiplomado ? 'Diplomado' : 'Certificado';
            $this->Flash->success(__("{$tipo} {0} restaurado correctamente. El certificado vuelve a ser válido.", $codigoOriginal));
            $this->log("Certificado {$codigoOriginal} restaurado por admin", 'info');
        } else {
            $this->Flash->error(__('No se pudo restaurar el certificado.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }

    /**
     * Verificar method (Public - No authentication required)
     * Verifica la autenticidad de un certificado mediante su código.
     * Accesible públicamente para validación externa.
     */
    public function verificar($codigo = null)
    {
        // Esta acción debe ser pública
        $this->viewBuilder()->setLayout('default');
        
        $certificado = null;
        $mensaje = null;
        $tipo = null; // 'success', 'error', 'warning'
        
        // Si viene código por URL o por POST
        if ($this->request->is('post')) {
            $codigo = $this->request->getData('codigo');
        }
        
        if (!empty($codigo)) {
            $codigo = strtoupper(trim($codigo));
            
            try {
                // Nueva arquitectura: cargar Titulares en lugar de Users
                $certificado = $this->Certificados->find()
                    ->where(['codigo' => $codigo])
                    ->contain(['Titulares', 'Cursos'])
                    ->first();
                
                if ($certificado) {
                    // Detectar si es certificado o diplomado
                    $esDiplomado = strpos($certificado->codigo, 'DIP-') === 0;
                    $tipoDoc = $esDiplomado ? 'Diplomado' : 'Certificado';
                    
                    if ($certificado->estado === 'activo') {
                        $mensaje = $tipoDoc . ' válido y activo';
                        $tipo = 'success';
                        $this->log("Verificación exitosa del {$tipoDoc}: {$codigo} (Titular: {$certificado->titular->dni})", 'info');
                    } else {
                        $mensaje = 'Este ' . strtolower($tipoDoc) . ' ha sido anulado';
                        $tipo = 'warning';
                        $this->log("Intento de verificación de {$tipoDoc} anulado: {$codigo}", 'warning');
                    }
                } else {
                    $mensaje = 'Código no encontrado (verifique CER-XXXX o DIP-XXXX)';
                    $tipo = 'error';
                    $this->log("Intento de verificación con código inválido: {$codigo}", 'warning');
                }
            } catch (\Exception $e) {
                $mensaje = 'Error al verificar el certificado';
                $tipo = 'error';
                $this->log("Error en verificación: " . $e->getMessage(), 'error');
            }
        }
        
        $this->set(compact('certificado', 'codigo', 'mensaje', 'tipo'));
    }

    /**
     * Método auxiliar: Gestionar titular (buscar o crear)
     * 
     * Este método implementa la nueva arquitectura de titulares:
     * - Busca un titular por DNI
     * - Si existe, lo reutiliza
     * - Si no existe, crea un nuevo titular
     * 
     * @param array $data Datos del formulario
     * @return int|null ID del titular o null si hay error
     */
    private function gestionarTitular(array $data): ?int
    {
        // Validar datos mínimos requeridos
        $dni = trim($data['dni'] ?? '');
        $nombreCompleto = trim($data['nombre_completo'] ?? '');
        
        $this->log(">>> gestionarTitular INICIADO", 'debug');
        $this->log(">>> DNI recibido: '$dni'", 'debug');
        $this->log(">>> Nombre Completo recibido: '$nombreCompleto'", 'debug');
        
        if (empty($dni)) {
            $this->log("Error: DNI vacío en gestionarTitular", 'error');
            return null;
        }
        
        // Obtener o cargar TitularesTable
        $titularesTable = $this->fetchTable('Titulares');
        
        // 1. Buscar titular existente por DNI
        $titular = $titularesTable->buscarPorDni($dni);
        
        // 2. Si existe, retornar su ID
        if ($titular) {
            $this->log("Titular encontrado por DNI {$dni}. ID: {$titular->id}, Nombre: {$titular->nombre_completo}", 'debug');
            return $titular->id;
        }
        
        // 3. Si no existe, validar que tengamos nombre completo
        if (empty($nombreCompleto)) {
            $this->log("Error: Titular no existe y falta nombre completo para crear. DNI: {$dni}", 'error');
            return null;
        }
        
        // 4. Crear nuevo titular usando buscarOCrear
        $nuevoTitular = $titularesTable->buscarOCrear($dni, $nombreCompleto);
        
        if ($nuevoTitular) {
            $this->log("Nuevo titular creado. ID: {$nuevoTitular->id}, DNI: {$dni}, Nombre: {$nombreCompleto}", 'info');
            return $nuevoTitular->id;
        }
        
        // 5. Error al guardar
        $this->log("Error al crear titular. DNI: {$dni}", 'error');
        return null;
    }
}

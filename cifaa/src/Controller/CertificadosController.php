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
            ->contain(['Users', 'Cursos'])
            ->order(['Certificados.created' => 'DESC']);
            
        $certificados = $this->paginate($query);

        $this->set(compact('certificados'));
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
            
            // DEBUG: Ver todos los datos recibidos
            $this->log("====== DATOS RECIBIDOS DEL FORMULARIO ======", 'debug');
            $this->log("nombre_completo: " . ($data['nombre_completo'] ?? 'NO ENVIADO'), 'debug');
            $this->log("nombre_curso: " . ($data['nombre_curso'] ?? 'NO ENVIADO'), 'debug');
            $this->log("horas: " . ($data['horas'] ?? 'NO ENVIADO'), 'debug');
            $this->log("nota_final: " . ($data['nota_final'] ?? 'NO ENVIADO'), 'debug');
            $this->log("duracion_meses: " . ($data['duracion_meses'] ?? 'NO ENVIADO'), 'debug');
            $this->log("fecha_inicio: " . ($data['fecha_inicio'] ?? 'NO ENVIADO'), 'debug');
            $this->log("fecha_fin: " . ($data['fecha_fin'] ?? 'NO ENVIADO'), 'debug');
            $this->log("modulo_tema: " . json_encode($data['modulo_tema'] ?? []), 'debug');
            $this->log("============================================", 'debug');
            
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
                    // Convertir formato YYYY-MM-DD a texto español
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
                    // Convertir formato YYYY-MM-DD a texto español
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
            
            // Preparar datos del certificado
            $certificadoData = [
                'user_id' => !empty($data['user_id']) ? $data['user_id'] : null,
                'curso_id' => !empty($data['curso_id']) ? $data['curso_id'] : null,
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
            $this->log("====== GUARDANDO EN BD ======", 'debug');
            $this->log("Datos preparados: " . json_encode($certificadoData, JSON_UNESCAPED_UNICODE), 'debug');
            $this->log("Entity nombre_completo: " . ($certificado->nombre_completo ?? 'NULL'), 'debug');
            $this->log("Entity nombre_curso: " . ($certificado->nombre_curso ?? 'NULL'), 'debug');
            $this->log("Entity horas: " . ($certificado->horas ?? 'NULL'), 'debug');
            $this->log("Entity nota_final: " . ($certificado->nota_final ?? 'NULL'), 'debug');
            $this->log("Entity duracion_meses: " . ($certificado->duracion_meses ?? 'NULL'), 'debug');
            $this->log("============================", 'debug');
            
            if ($this->Certificados->save($certificado)) {
                $this->log("Certificado generado exitosamente. ID: {$certificado->id}, Codigo: {$codigo}, Nombre: {$certificado->nombre_completo}, Curso: {$certificado->nombre_curso}", 'info');
                $this->Flash->success(__('Certificado generado exitosamente. Código: {0}', $codigo));
                
                return $this->redirect(['action' => 'index']);
            } else {
                // Log de errores de validación
                $errors = $certificado->getErrors();
                $this->log("ERROR al guardar certificado. Errores: " . json_encode($errors), 'error');
                $this->Flash->error(__('Error al guardar el certificado. Revise los datos ingresados.'));
                
                // Mostrar errores específicos en el log
                foreach ($errors as $field => $error) {
                    $this->log("Campo '{$field}': " . json_encode($error), 'error');
                }
            }
        }
        
        // Cargar listas para los dropdowns del formulario
        $users = $this->Certificados->Users->find('list', [
            'keyField' => 'id',
            'valueField' => function ($user) {
                return $user->username . ' (DNI: ' . ($user->dni ?? 'N/A') . ')';
            }
        ])->where(['rol' => 3]) // Solo estudiantes
          ->order(['username' => 'ASC'])
          ->all();
          
        $cursos = $this->Certificados->Cursos->find('list', [
            'keyField' => 'id',
            'valueField' => 'titulo'
        ])->order(['titulo' => 'ASC'])
          ->all();

        $this->set(compact('certificado', 'users', 'cursos'));
    }

    /**
     * Mis Certificados (Student only)
     * Shows certificates belonging to the current user.
     */
    public function misCertificados()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $query = $this->Certificados->find()
            ->contain(['Cursos'])
            ->where(['Certificados.user_id' => $user->id])
            ->order(['Certificados.created' => 'DESC']);

        $certificados = $this->paginate($query);

        $this->set(compact('certificados'));
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
                'contain' => ['Users', 'Cursos']
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
        
        // PASO 4.4: Renderizar HTML del certificado
        $html = $this->viewBuilder()
            ->setClassName('Cake\View\View')
            ->setTemplatePath('Certificados/pdf')
            ->setTemplate('certificado')
            ->setLayout('ajax')
            ->setOption('serialize', ['certificado', 'logoBase64', 'firmaBase64', 'verificarUrl'])
            ->setVar('certificado', $certificado)
            ->setVar('logoBase64', $logoBase64)
            ->setVar('firmaBase64', $firmaBase64)
            ->setVar('verificarUrl', $verificarUrl)
            ->build()
            ->render();

        // PASO 4.5: Generar PDF en memoria
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $pdfOutput = $dompdf->output();

        // PASO 5: Guardar PDF en el servidor para uso futuro
        $filename = 'certificado_' . $certificado->codigo . '.pdf';
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
    public function delete($id = null)
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $this->request->allowMethod(['post', 'delete']);
        $certificado = $this->Certificados->get($id);
        if ($this->Certificados->delete($certificado)) {
            $this->Flash->success(__('El certificado ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el certificado.'));
        }

        return $this->redirect(['action' => 'index']);
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
                $certificado = $this->Certificados->find()
                    ->where(['codigo' => $codigo])
                    ->contain(['Users', 'Cursos'])
                    ->first();
                
                if ($certificado) {
                    if ($certificado->estado === 'activo') {
                        $mensaje = 'Certificado válido y activo';
                        $tipo = 'success';
                        $this->log("Verificación exitosa del certificado: {$codigo}", 'info');
                    } else {
                        $mensaje = 'Este certificado ha sido anulado';
                        $tipo = 'warning';
                        $this->log("Intento de verificación de certificado anulado: {$codigo}", 'warning');
                    }
                } else {
                    $mensaje = 'Código de certificado no encontrado';
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
}

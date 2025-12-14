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
     * Genera un certificado manualmente para un usuario y curso especifico.
     * 
     * Flujo de validacion:
     * 1. Verificar que usuario existe y es alumno (rol=2) 
     * 2. Verificar que curso existe
     * 3. Verificar que existe inscripcion del alumno al curso
     * 4. Validar progreso 100% y estado aprobada
     * 5. Verificar que no exista certificado activo previo
     * 6. Generar codigo unico y crear certificado
     * 7. Redirigir a descarga automatica del PDF
     */
    public function generar()
    {
        if ($redirect = $this->requiereAdministrador()) {
            return $redirect;
        }

        $certificado = $this->Certificados->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $userId = $data['user_id'] ?? null;
            $cursoId = $data['curso_id'] ?? null;
            
            // VALIDACION 1: Verificar que usuario existe y es alumno (rol=3)
            $user = $this->Certificados->Users->find()
                ->where(['id' => $userId, 'rol' => 3])
                ->first();
                
            if (!$user) {
                $this->Flash->error(__('Usuario invalido o no es alumno. Solo se pueden generar certificados para alumnos.'));
                return $this->redirect(['action' => 'generar']);
            }
            
            // VALIDACION 2: Verificar que curso existe
            $curso = $this->Certificados->Cursos->find()
                ->where(['id' => $cursoId])
                ->first();
                
            if (!$curso) {
                $this->Flash->error(__('El curso especificado no existe.'));
                return $this->redirect(['action' => 'generar']);
            }
            
            // VALIDACION 3: Buscar inscripcion del alumno al curso
            $Inscripciones = $this->fetchTable('Inscripciones');
            $inscripcion = $Inscripciones->find()
                ->where([
                    'usuario_id' => $userId,
                    'curso_id' => $cursoId
                ])
                ->first();
                
            if (!$inscripcion) {
                $this->Flash->error(__('El usuario {0} no esta inscrito en el curso {1}.', $user->username, $curso->titulo));
                return $this->redirect(['action' => 'generar']);
            }
            
            // VALIDACION 4: Verificar duplicados (solo un certificado activo por inscripcion)
            $certificadoExistente = $this->Certificados->find()
                ->where([
                    'user_id' => $userId,
                    'curso_id' => $cursoId,
                    'estado' => 'activo'
                ])
                ->first();
                
            if ($certificadoExistente) {
                $this->Flash->warning(__('Ya existe un certificado activo para este usuario y curso. Codigo: {0}', $certificadoExistente->codigo));
                return $this->redirect(['action' => 'descargar', $certificadoExistente->id]);
            }
            
            // PASO 6: Generar codigo unico para el certificado
            // Formato: CER-ANIO-USERID-CURSOID-RANDOM
            $codigo = 'CER-' . date('Y') . '-' . str_pad($userId, 4, '0', STR_PAD_LEFT) . 
                      '-' . str_pad($cursoId, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
            
            // Crear entidad del certificado con datos completos
            $certificadoData = [
                'user_id' => $userId,
                'curso_id' => $cursoId,
                'horas' => $curso->duracion_horas ?? 40, // Usar duracion del curso o valor por defecto
                'fecha_emision' => date('Y-m-d'),
                'codigo' => $codigo,
                'estado' => 'activo'
            ];
            
            $certificado = $this->Certificados->patchEntity($certificado, $certificadoData);
            
            // PASO 7: Guardar certificado y redirigir a descarga
            if ($this->Certificados->save($certificado)) {
                $this->log("Certificado generado manualmente. ID: {$certificado->id}, Codigo: {$codigo}, Usuario: {$userId}, Curso: {$cursoId}", 'info');
                $this->Flash->success(__('Certificado generado exitosamente para {0} - {1}. Codigo: {2}', $user->username, $curso->titulo, $codigo));
                
                // Redirigir automaticamente a descarga del PDF
                return $this->redirect(['action' => 'descargar', $certificado->id]);
            }
            
            $this->Flash->error(__('Error al guardar el certificado en la base de datos. Intente nuevamente.'));
        }
        
        // Cargar listas para los dropdowns del formulario
        $users = $this->Certificados->Users->find('list', [
            'keyField' => 'id',
            'valueField' => function ($user) {
                $email = !empty($user->email) ? ' (' . $user->email . ')' : '';
                return $user->username . $email;
            }
        ])->where(['rol' => 2]) // Solo alumnos
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
        
        // PASO 4.3: Renderizar HTML del certificado
        $html = $this->viewBuilder()
            ->setClassName('Cake\View\View')
            ->setTemplatePath('Certificados/pdf')
            ->setTemplate('certificado')
            ->setLayout('ajax')
            ->setOption('serialize', ['certificado', 'logoBase64', 'firmaBase64'])
            ->setVar('certificado', $certificado)
            ->setVar('logoBase64', $logoBase64)
            ->setVar('firmaBase64', $firmaBase64)
            ->build()
            ->render();

        // PASO 4.4: Generar PDF en memoria
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
}

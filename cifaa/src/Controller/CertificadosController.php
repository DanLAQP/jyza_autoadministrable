<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Routing\Router;

/**
 * Certificados Controller
 *
 * @property \App\Model\Table\CertificadosTable $Certificados
 */
class CertificadosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $identity = $this->getRequest()->getAttribute('identity');
        $query = $this->Certificados->find()
            ->contain(['Users', 'Cursos']);

        // Los estudiantes (rol 3) solo ven sus propios certificados
        if ($identity && $identity->rol == 3) {
            $query->where(['Certificados.usuario_id' => $identity->id]);
        }

        // Búsqueda por término
        $termino = $this->request->getQuery('termino');
        if (!empty($termino)) {
            $query->where([
                'OR' => [
                    'Certificados.codigo LIKE' => "%$termino%",
                    'Certificados.nombre_titular LIKE' => "%$termino%",
                    'Certificados.dni_titular LIKE' => "%$termino%",
                    'Certificados.nombre_curso_manual LIKE' => "%$termino%",
                    'Users.username LIKE' => "%$termino%",
                    'Cursos.titulo LIKE' => "%$termino%",
                ]
            ]);
        }

        // Filtro por tipo
        $tipo = $this->request->getQuery('tipo');
        if (!empty($tipo) && in_array($tipo, ['certificado', 'diplomado'])) {
            $query->where(['Certificados.tipo' => $tipo]);
        }

        // Ordenar por ID descendente por defecto
        $query->order(['Certificados.id' => 'DESC']);

        $certificados = $this->paginate($query);

        $this->set(compact('certificados', 'identity'));
    }

    /**
     * View method
     *
     * @param string|null $id Certificado id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $identity = $this->getRequest()->getAttribute('identity');
        
        // Los estudiantes no pueden acceder a view, solo descargar
        if ($identity && $identity->rol == 3) {
            $this->Flash->error(__('No tienes permiso para acceder a esta sección.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $certificado = $this->Certificados->get($id, contain: ['Users', 'Cursos', 'CertificadoModulos']);
        $this->set(compact('certificado'));
    }

    /**
     * Export PDF method
     *
     * @param string|null $id Certificado id.
     * @return \Cake\Http\Response
     */
    public function exportPdf($id = null)
    {
        $logoUrl = Router::url('/img/logoCifa.png', true);
        $firmaUrl = Router::url('/img/firma.png', true);
        $certificado = $this->Certificados->get($id, contain: ['Users', 'Cursos', 'CertificadoModulos']);

        // Renderizar la vista HTML como contenido para el PDF
        $this->viewBuilder()->enableAutoLayout(false);
        $this->set(compact('certificado', 'logoUrl', 'firmaUrl'));
        $html = $this->render('export_pdf');

        // Configurar DomPDF para el PDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Configurar tamaño de papel
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Descargar el archivo PDF
        $dompdf->stream("Certificado_{$certificado->codigo}.pdf", ['Attachment' => 1]);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $identity = $this->getRequest()->getAttribute('identity');
        
        // Los estudiantes no pueden crear certificados
        if ($identity && $identity->rol == 3) {
            $this->Flash->error(__('No tienes permiso para crear certificados.'));
            return $this->redirect(['action' => 'index']);
        }
        $certificado = $this->Certificados->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Generar código único si no se proporciona
            if (empty($data['codigo'])) {
                $data['codigo'] = $this->generarCodigoUnico();
            }
            
            // Capturar módulos antes de guardar (pueden venir de checkboxes o textarea)
            $modulosIds = [];
            $modulosManual = [];
            
            // Si vienen módulos seleccionados (de checkboxes automáticos)
            if (!empty($data['modulos_ids'])) {
                // Puede venir como JSON string o como array
                if (is_string($data['modulos_ids'])) {
                    $decoded = json_decode($data['modulos_ids'], true);
                    $modulosIds = is_array($decoded) ? $decoded : [];
                } else {
                    $modulosIds = is_array($data['modulos_ids']) ? $data['modulos_ids'] : [];
                }
            }
            
            // Si vienen módulos manuales (del textarea)
            if (!empty($data['modulos'])) {
                // Si es un string con saltos de línea, convertir a array
                $modulosManual = is_array($data['modulos']) ? $data['modulos'] : explode("\n", $data['modulos']);
                $modulosManual = array_filter(array_map('trim', $modulosManual)); // Limpiar espacios en blanco
            }
            
            // No guardar estos campos en la tabla certificados, solo en certificado_modulos
            unset($data['modulos_ids']);
            unset($data['modulos']);
            
            $certificado = $this->Certificados->patchEntity($certificado, $data);
            
            if ($this->Certificados->save($certificado)) {
                // Ahora guardar los módulos en certificado_modulos
                $this->guardarModulosCertificado($certificado->id, $modulosIds, $modulosManual);
                
                $this->Flash->success(__('El certificado ha sido guardado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El certificado no pudo ser guardado. Por favor, intenta de nuevo.'));
        }
        
        $users = $this->Certificados->Users->find('list', limit: 200)->all();
        $cursos = $this->Certificados->Cursos->find('list', limit: 200)->all();
        
        $this->set(compact('certificado', 'users', 'cursos'));
    }
    
    /**
     * Guardar módulos asociados a un certificado
     *
     * @param int $certificadoId ID del certificado
     * @param array $modulosIds IDs de módulos del curso seleccionado
     * @param array $modulosManual Nombres de módulos ingresados manualmente
     * @return void
     */
    private function guardarModulosCertificado(int $certificadoId, array $modulosIds, array $modulosManual): void
    {
        $certificadoModulosTable = $this->fetchTable('CertificadoModulos');
        
        $posicion = 1;
        
        // Guardar módulos seleccionados del curso (IDs)
        foreach ($modulosIds as $moduloId) {
            $modulo = $this->fetchTable('Modulos')->get($moduloId);
            
            $certificadoModulo = $certificadoModulosTable->newEmptyEntity();
            $certificadoModulo->certificado_id = $certificadoId;
            $certificadoModulo->titulo = $modulo->titulo ?? $modulo->nombre;
            $certificadoModulo->descripcion = $modulo->descripcion ?? '';
            $certificadoModulo->horas = $modulo->horas ?? null;
            $certificadoModulo->posicion = $posicion;
            
            $certificadoModulosTable->save($certificadoModulo);
            $posicion++;
        }
        
        // Guardar módulos ingresados manualmente (pueden ser nuevos o existentes con ID)
        foreach ($modulosManual as $moduloData) {
            // Verificar si es un array con estructura {id?, titulo} o un string simple
            if (is_array($moduloData)) {
                $titulo = $moduloData['titulo'] ?? '';
                $moduloId = $moduloData['id'] ?? null;
            } else {
                $titulo = $moduloData;
                $moduloId = null;
            }
            
            if (empty($titulo)) {
                continue; // Saltar módulos sin título
            }
            
            $certificadoModulo = $certificadoModulosTable->newEmptyEntity();
            $certificadoModulo->certificado_id = $certificadoId;
            $certificadoModulo->titulo = $titulo;
            $certificadoModulo->descripcion = '';
            $certificadoModulo->horas = null;
            $certificadoModulo->posicion = $posicion;
            
            $certificadoModulosTable->save($certificadoModulo);
            $posicion++;
        }
    }
    
    /**
     * Generar código único para el certificado
     * Formato: CERT-YYYYMMDD-XXXX (XXXX es un número aleatorio)
     *
     * @return string
     */
    private function generarCodigoUnico(): string
    {
        $fecha = date('Ymd');
        $aleatorio = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return 'CERT-' . $fecha . '-' . $aleatorio;
    }
    
    /**
     * Obtener módulos de un curso vía AJAX
     *
     * @param int|null $cursoId ID del curso
     * @return \Cake\Http\Response
     */
    public function obtenerModulos($cursoId = null)
    {
        $this->request->allowMethod(['get', 'post']);
        
        if ($cursoId) {
            $modulos = $this->fetchTable('Modulos')->find()
                ->where(['curso_id' => $cursoId])
                ->all();
            
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($modulos->toArray()));
        }
        
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([]));
    }
    
    /**
     * Imprimir/PDF de un certificado
     *
     * @param string|null $id Certificado id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimir($id = null)
    {
        $certificado = $this->Certificados->get($id, contain: ['Users', 'Cursos', 'CertificadoModulos']);
        
        // Cargar módulos del curso si existe
        $modulosCurso = [];
        if ($certificado->curso && $certificado->curso->id) {
            $modulosCurso = $this->fetchTable('Modulos')->find()
                ->where(['curso_id' => $certificado->curso->id])
                ->toArray();
        }
        
        $this->set(compact('certificado', 'modulosCurso'));
        $this->viewBuilder()->setOption('serialize', false);
    }

    /**
     * Edit method
     *
     * @param string|null $id Certificado id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $identity = $this->getRequest()->getAttribute('identity');
        
        // Los estudiantes no pueden editar certificados
        if ($identity && $identity->rol == 3) {
            $this->Flash->error(__('No tienes permiso para editar certificados.'));
            return $this->redirect(['action' => 'index']);
        }
        
        // Cargar certificado con sus módulos relacionados
        $certificado = $this->Certificados->get($id, contain: ['CertificadoModulos']);
        
        // Preparar datos de módulos existentes para la vista (con IDs)
        $modulosExistentes = [];
        $modulosManualesData = []; // Array con id y titulo
        if (!empty($certificado->certificado_modulos)) {
            foreach ($certificado->certificado_modulos as $modulo) {
                $modulosExistentes[] = $modulo->titulo;
                $modulosManualesData[] = [
                    'id' => $modulo->id,
                    'titulo' => $modulo->titulo
                ];
            }
        }
        
        // Establecer el campo 'modulos' en la entidad para pre-llenar el textarea
        if (!empty($modulosExistentes)) {
            $certificado->modulos = implode("\n", $modulosExistentes);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Capturar módulos antes de guardar (pueden venir de checkboxes o textarea)
            $modulosIds = [];
            $modulosManual = [];
            
            // Si vienen módulos seleccionados (de checkboxes automáticos)
            if (!empty($data['modulos_ids'])) {
                if (is_string($data['modulos_ids'])) {
                    $decoded = json_decode($data['modulos_ids'], true);
                    $modulosIds = is_array($decoded) ? $decoded : [];
                } else {
                    $modulosIds = is_array($data['modulos_ids']) ? $data['modulos_ids'] : [];
                }
            }
            
            // Si vienen módulos manuales (ahora como JSON con IDs para edición)
            if (!empty($data['modulos'])) {
                if (is_string($data['modulos'])) {
                    $decodedModulos = json_decode($data['modulos'], true);
                    if (is_array($decodedModulos)) {
                        // Es un JSON con estructura {id?, titulo}
                        $modulosManual = $decodedModulos;
                    } else {
                        // Es texto simple con saltos de línea (compatibilidad)
                        $modulosManual = explode("\n", $data['modulos']);
                        $modulosManual = array_filter(array_map('trim', $modulosManual));
                    }
                } else {
                    $modulosManual = is_array($data['modulos']) ? $data['modulos'] : [];
                }
            }
            
            // No guardar estos campos en la tabla certificados, solo en certificado_modulos
            unset($data['modulos_ids']);
            unset($data['modulos']);
            
            $certificado = $this->Certificados->patchEntity($certificado, $data);
            if ($this->Certificados->save($certificado)) {
                // Eliminar módulos antiguos y guardar los nuevos
                $certificadoModulosTable = $this->fetchTable('CertificadoModulos');
                $certificadoModulosTable->deleteAll(['certificado_id' => $certificado->id]);
                
                // Guardar los módulos actualizados
                $this->guardarModulosCertificado($certificado->id, $modulosIds, $modulosManual);
                
                $this->Flash->success(__('El certificado ha sido actualizado exitosamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El certificado no pudo ser guardado. Por favor, intenta de nuevo.'));
        }
        $users = $this->Certificados->Users->find('list', limit: 200)->all();
        $cursos = $this->Certificados->Cursos->find('list', limit: 200)->all();
        
        $this->set(compact('certificado', 'users', 'cursos', 'modulosExistentes', 'modulosManualesData'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Certificado id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $identity = $this->getRequest()->getAttribute('identity');
        
        // Los estudiantes no pueden eliminar certificados
        if ($identity && $identity->rol == 3) {
            $this->Flash->error(__('No tienes permiso para eliminar certificados.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $certificado = $this->Certificados->get($id);
        if ($this->Certificados->delete($certificado)) {
            $this->Flash->success(__('The certificado has been deleted.'));
        } else {
            $this->Flash->error(__('The certificado could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

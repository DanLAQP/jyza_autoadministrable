<?php

declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

/**
 * Pacientes Controller
 *
 * @property \App\Model\Table\PacientesTable $Pacientes
 */
class PacientesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */


    public function exportPacientePdf($id = null)
    {
        $logoUrl = Router::url('/img/logoClinica.png', true);
        $paciente = $this->Pacientes->get($id, contain: [
            'RegistrosTratamientos' => ['Tratamientos'],
            'AntecedentesMedicos',
            'AntecedentesOdontologicos',
            'ContactosEmergencia',
            'EnfermedadesActuales',
            'Pacientes1',
            'Citas', // Cargamos las citas
            'Odontograma', // Cargamos los odontogramas asociados
            'ArchivosPacientes', // Cargamos los archivos del paciente
            'Presupuestos' => [
                'PresupuestosTratamientos' => ['Tratamientos'] // Incluimos los tratamientos dentro de PresupuestosTratamientos
            ],
            'RegistrosConsultas' => [
                'Doctores',
                'ConsultasTratamientos' => ['Tratamientos'],
                'sort' => ['RegistrosConsultas.created' => 'DESC']
            ],
        ]);

        // Renderizar la vista HTML como contenido para el PDF
        $this->viewBuilder()->enableAutoLayout(false);
        $this->set(compact('paciente', 'logoUrl'));
        $html = $this->render('historia_clinica');

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
        $dompdf->stream("Paciente_Detalle_{$id}.pdf", ['Attachment' => 1]);
    }

    public function index()
    {
        $searchTerm = $this->request->getQuery('search');

        $query = $this->Pacientes->find(
            'all',
            contain: ['Pacientes1']
        )->order(['Pacientes.id' => 'DESC']);

        if (!empty($searchTerm)) {
            $query->where([
                'OR' => [
                    'LOWER(Pacientes1.nombre) LIKE' => '%' . strtolower($searchTerm) . '%',
                    'LOWER(Pacientes1.apellido) LIKE' => '%' . strtolower($searchTerm) . '%',
                    'Pacientes.dni LIKE' => '%' . $searchTerm . '%'
                ]
            ]);
        }

        $pacientes = $this->paginate($query);

        $this->set(compact('pacientes', 'searchTerm'));
    }


    public function view($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        // Obtenemos al paciente y cargamos sus relaciones
        $paciente = $this->Pacientes->get(
            $id,
            contain: [
                'RegistrosTratamientos' => ['Tratamientos'],
                'AntecedentesMedicos',
                'AntecedentesOdontologicos',
                'ContactosEmergencia',
                'EnfermedadesActuales',
                'Pacientes1',
                'Citas', // Cargamos las citas
                'Odontograma', // Cargamos los odontogramas asociados
                'ArchivosPacientes', // Cargamos los archivos del paciente
                'Presupuestos' => [
                    'PresupuestosTratamientos' => ['Tratamientos'] // Incluimos los tratamientos dentro de PresupuestosTratamientos
                ],
                'RegistrosConsultas' => [
                    'Doctores',
                    'ConsultasTratamientos' => ['Tratamientos'],
                    'sort' => ['RegistrosConsultas.created' => 'DESC']
                ],
            ]
        );

        // Calcular los montos totales para cada registro de consulta
        foreach ($paciente->registros_consultas as $registro) {
            $totalCosto = 0;

            // Sumar los montos de los tratamientos
            foreach ($registro->consultas_tratamientos as $tratamiento) {
                $totalCosto += $tratamiento->monto_doctor + $tratamiento->monto_materiales + $tratamiento->monto_clinica;
            }

            // Guardamos el total para cada consulta
            $registro->_total_costo = $totalCosto;
        }

        // Carga el modelo de Doctores manualmente
        $doctoresTable = TableRegistry::getTableLocator()->get('Doctores');
        $doctores = $doctoresTable->find()
            ->select(['id', 'nombre', 'apellido'])
            ->all()
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'nombre_completo' => $doctor->nombre . ' ' . $doctor->apellido
                ];
            })
            ->combine('id', 'nombre_completo')
            ->toArray();

        // Si no se encuentra el paciente, mostramos un mensaje de error
        if (!$paciente) {
            $this->Flash->error(__('Paciente no encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        // Pasamos los datos del paciente y doctores a la vista
        $this->set(compact('paciente', 'doctores'));

        // Configuramos el layout dependiendo del tipo de solicitud
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }


    public function add($paciente_id = null)
    {
        $roles = [1, 2, 3, 4];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $paciente = $this->Pacientes->newEmptyEntity();
        if ($paciente_id) {
            // Asigna el paciente_id al nuevo paciente
            $paciente->paciente_id = $paciente_id;
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Función para verificar si un registro tiene al menos un campo lleno
            function tieneDatos($registro)
            {
                return !empty(array_filter($registro, function ($valor) {
                    return $valor !== null && $valor !== '';
                }));
            }

            // Manejo de antecedentes médicos
            $antecedentesMedicosData = [];
            if (!empty($data['antecedentes_medicos'])) {
                foreach ($data['antecedentes_medicos'] as $antecedente) {
                    if (tieneDatos($antecedente)) {
                        $antecedentesMedicosData[] = $antecedente;
                    }
                }
            }
            unset($data['antecedentes_medicos']);

            // Manejo de antecedentes odontológicos
            $antecedentesOdontologicosData = [];
            if (!empty($data['antecedentes_odontologicos'])) {
                foreach ($data['antecedentes_odontologicos'] as $antecedente) {
                    if (tieneDatos($antecedente)) {
                        $antecedentesOdontologicosData[] = $antecedente;
                    }
                }
            }
            unset($data['antecedentes_odontologicos']);

            // Manejo de contactos de emergencia
            $contactosEmergenciaData = [];
            if (!empty($data['contactos_emergencia'])) {
                foreach ($data['contactos_emergencia'] as $contacto) {
                    if (tieneDatos($contacto)) {
                        $contactosEmergenciaData[] = $contacto;
                    }
                }
            }
            unset($data['contactos_emergencia']);

            // Manejo de enfermedades actuales
            $enfermedadesActualesData = [];
            if (!empty($data['enfermedades_actuales'])) {
                foreach ($data['enfermedades_actuales'] as $enfermedad) {
                    if (tieneDatos($enfermedad)) {
                        $enfermedadesActualesData[] = $enfermedad;
                    }
                }
            }
            unset($data['enfermedades_actuales']);

            // Crear la entidad de paciente con los datos base
            $paciente = $this->Pacientes->patchEntity($paciente, $data, [
                'associated' => ['AntecedentesMedicos', 'AntecedentesOdontologicos', 'ContactosEmergencia', 'EnfermedadesActuales']
            ]);

            if ($paciente->getErrors()) {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'errors' => $paciente->getErrors(),
                        ]));
                }
                $this->Flash->error(__('Por favor corrija los errores antes de continuar.'));
            } elseif ($this->Pacientes->save($paciente)) {
                if (!empty($antecedentesMedicosData)) {
                    $this->guardarDatosAsociados('AntecedentesMedicos', $antecedentesMedicosData, 'paciente_id', $paciente->id);
                }

                if (!empty($antecedentesOdontologicosData)) {
                    $this->guardarDatosAsociados('AntecedentesOdontologicos', $antecedentesOdontologicosData, 'paciente_id', $paciente->id);
                }

                if (!empty($contactosEmergenciaData)) {
                    $this->guardarDatosAsociados('ContactosEmergencia', $contactosEmergenciaData, 'paciente_id', $paciente->id);
                }

                if (!empty($enfermedadesActualesData)) {
                    $this->guardarDatosAsociados('EnfermedadesActuales', $enfermedadesActualesData, 'paciente_id', $paciente->id);
                }

                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => true,
                            'message' => __('El paciente y sus datos han sido guardados correctamente.'),
                        ]));
                }

                $this->Flash->success(__('El paciente y sus datos han sido guardados correctamente.'));
                return $this->redirect(['action' => 'view', $paciente->id]);
            } else {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'message' => __('No se pudo guardar el paciente. Inténtalo nuevamente.'),
                        ]));
                }
                $this->Flash->error(__('No se pudo guardar el paciente. Por favor, intenta nuevamente.'));
            }
        }

        // Preparar datos para las vistas
        $this->set(compact('paciente'));

        // Usar un layout diferenciado para solicitudes normales o AJAX
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    public function edit($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $paciente = $this->Pacientes->get($id, contain: [
            'RegistrosTratamientos' => ['Tratamientos'],
            'AntecedentesMedicos',
            'AntecedentesOdontologicos',
            'ContactosEmergencia',
            'EnfermedadesActuales',
        ]);

        $tratamientosData = $this->Pacientes->RegistrosTratamientos->Tratamientos->find()
            ->select(['id', 'nombre', 'descripcion', 'costo'])
            ->toArray();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['paciente_id'] = $id;

            // Separar datos relacionados
            $antecedentesMedicosData = $data['antecedentes_medicos'] ?? [];
            unset($data['antecedentes_medicos']);
            $antecedentesOdontologicosData = $data['antecedentes_odontologicos'] ?? [];
            unset($data['antecedentes_odontologicos']);
            $contactosEmergenciaData = $data['contactos_emergencia'] ?? [];
            unset($data['contactos_emergencia']);
            $enfermedadesActualesData = $data['enfermedades_actuales'] ?? [];
            unset($data['enfermedades_actuales']);
            $registrosTratamientosData = $data['registros_tratamientos'] ?? [];
            unset($data['registros_tratamientos']);

            // Transacción para manejo de errores en cascada
            $connection = $this->Pacientes->getConnection();
            $connection->begin();

            try {
                // Actualizar datos del paciente principal
                $paciente = $this->Pacientes->patchEntity($paciente, $data);
                if (!$this->Pacientes->save($paciente)) {
                    throw new \Exception('No se pudo guardar el paciente.');
                }

                // Guardar datos relacionados
                $this->guardarDatosAsociados('AntecedentesMedicos', $antecedentesMedicosData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('AntecedentesOdontologicos', $antecedentesOdontologicosData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('ContactosEmergencia', $contactosEmergenciaData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('EnfermedadesActuales', $enfermedadesActualesData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('RegistrosTratamientos', $registrosTratamientosData, 'paciente_id', $paciente->id);

                $connection->commit();
                $this->Flash->success(__('El paciente y sus datos relacionados han sido actualizados.'));
                return $this->redirect(['controller' => 'Pacientes1', 'action' => 'view', $id]);
            } catch (\Exception $e) {
                $connection->rollback();
                $this->Flash->error(__('Ocurrió un error: ' . $e->getMessage()));
            }
        }

        $tratamientos = $this->Pacientes->RegistrosTratamientos->Tratamientos->find('list', keyField: 'id', valueField: 'nombre')->toArray();
        $this->set(compact('paciente', 'tratamientos', 'tratamientosData'));
    }

    private function guardarDatosAsociados($tabla, $datos, $foreignKey, $pacienteId)
    {
        foreach ($datos as $registroData) {
            if (!empty($registroData['id'])) {
                // Actualizar registro existente
                $registro = $this->Pacientes->{$tabla}->get($registroData['id']);
                $registro = $this->Pacientes->{$tabla}->patchEntity($registro, $registroData);
            } else {
                // Crear nuevo registro
                $registro = $this->Pacientes->{$tabla}->newEntity($registroData);
                $registro->{$foreignKey} = $pacienteId;
            }

            // Guardar registro y manejar errores
            if (!$this->Pacientes->{$tabla}->save($registro)) {
                throw new \Exception('No se pudo guardar un registro en ' . $tabla . '.');
            }
        }
    }
}

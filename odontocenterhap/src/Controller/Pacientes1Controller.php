<?php

declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

/**
 * Pacientes1 Controller
 *
 * @property \App\Model\Table\Pacientes1Table $Pacientes1
 */
class Pacientes1Controller extends AppController
{
    public function exportPacientePdf($id = null)
    {
        $logoUrl = Router::url('/img/logoClinica.png', true);
        $pacientes1 = $this->Pacientes1->get($id, contain: [
            'Pacientes' => [
                'RegistrosTratamientos' => ['Tratamientos'],
                'AntecedentesMedicos',
                'AntecedentesOdontologicos',
                'ContactosEmergencia',
                'EnfermedadesActuales',
                'Citas', // Cargamos las citas
                
            ],
            'Presupuestos' => [
                'PresupuestosTratamientos' => ['Tratamientos'] // Incluimos los tratamientos dentro de PresupuestosTratamientos
            ],
            'RegistrosConsultas' => [
                'Doctores',
                'ConsultasTratamientos' => ['Tratamientos'],
                'sort' => ['RegistrosConsultas.created' => 'DESC']
            ],
            'Odontograma',
            'ArchivosPacientes', // Cargamos los archivos del paciente
        ]);

        // Renderizar la vista HTML como contenido para el PDF
        $this->viewBuilder()->enableAutoLayout(false);
        $this->set(compact('pacientes1', 'logoUrl'));
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
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $searchTerm = $this->request->getQuery('search');
        $query = $this->Pacientes1->find()
            ->contain(['Pacientes'])
            ->order(['Pacientes1.id' => 'DESC']);
        if (!empty($searchTerm)) {
            $query->where([
                'OR' => [
                    'LOWER(Pacientes1.nombre) LIKE' => '%' . strtolower($searchTerm) . '%',
                    'LOWER(Pacientes1.apellido) LIKE' => '%' . strtolower($searchTerm) . '%',
                    'Pacientes.dni LIKE' => '%' . $searchTerm . '%'
                ]
            ]);
        }
        $pacientes1 = $this->paginate($query);

        $this->set(compact('pacientes1'));
    }

    /**
     * View method
     *
     * @param string|null $id Pacientes1 id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
            public function view($id = null)
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $pacientes1 = $this->Pacientes1->get($id, contain: [
            'Pacientes' => [
                'RegistrosTratamientos' => ['Tratamientos'],
                'AntecedentesMedicos',
                'AntecedentesOdontologicos',
                'ContactosEmergencia',
                'EnfermedadesActuales',
                'Citas', // Cargamos las citas
                'Odontograma', // Cargamos los odontogramas asociados
                'Ordenes' => [
                    'Doctores',
                    'OrdenesTratamientos' => ['Tratamientos'],
                    'sort' => ['Ordenes.created' => 'DESC']
                ],
            ],
            'Presupuestos' => [
                'PresupuestosTratamientos' => ['Tratamientos'] // Incluimos los tratamientos dentro de PresupuestosTratamientos
            ],
            'RegistrosConsultas' => [
                'Doctores',
                'ConsultasTratamientos' => ['Tratamientos'],
                'sort' => ['RegistrosConsultas.created' => 'DESC']
            ],
            'ArchivosPacientes', // Cargamos los archivos del paciente
        ]);
        // Calcular los montos totales para cada registro de consulta
        if (!empty($pacientes1->registros_consultas)) {
            foreach ($pacientes1->registros_consultas as $registro) {
                $totalCosto = 0;

                foreach ($registro->consultas_tratamientos as $tratamiento) {
                    $totalCosto += $tratamiento->monto_doctor + $tratamiento->monto_materiales + $tratamiento->monto_clinica;
                }

                $registro->_total_costo = $totalCosto;
            }
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
        if (!$pacientes1) {
            $this->Flash->error(__('Paciente no encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        // Pasamos los datos del paciente y doctores a la vista
        $this->set(compact('pacientes1', 'doctores'));

        // Configuramos el layout dependiendo del tipo de solicitud
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
        $roles = [1, 2, 3, 4];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $pacientes1 = $this->Pacientes1->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Función para verificar si un registro tiene al menos un campo lleno
            function tieneDatos($registro)
            {
                return !empty(array_filter($registro, function ($valor) {
                    return $valor !== null && $valor !== '';
                }));
            }

            // Función para arrays múltiples (como arrays de registros)
            function tieneDatosAsociados($registros)
            {
                return !empty(array_filter($registros, function ($registro) {
                    return !empty(array_filter($registro, function ($valor) {
                        return $valor !== null && $valor !== '';
                    }));
                }));
            }

            // Verificamos si hay datos suficientes para crear un pacientes1
            $hayDatosPaciente = tieneDatos($data);
            $hayDatosAntecedentesMedicos = isset($data['antecedentes_medicos']) && tieneDatosAsociados($data['antecedentes_medicos']);
            $hayDatosAntecedentesOdontologicos = isset($data['antecedentes_odontologicos']) && tieneDatosAsociados($data['antecedentes_odontologicos']);
            $hayDatosContactos = isset($data['contactos_emergencia']) && tieneDatosAsociados($data['contactos_emergencia']);
            $hayDatosEnfermedades = isset($data['enfermedades_actuales']) && tieneDatosAsociados($data['enfermedades_actuales']);

            $crearPaciente = $hayDatosPaciente || $hayDatosAntecedentesMedicos || $hayDatosAntecedentesOdontologicos || $hayDatosContactos || $hayDatosEnfermedades;

            if (!$crearPaciente) {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'message' => 'Debes ingresar algún dato en el paciente o en los antecedentes para poder guardar.',
                        ]));
                }

                $this->Flash->error(__('Debes ingresar algún dato en el paciente o en los antecedentes para poder guardar.'));
                return $this->redirect($this->referer());
            }

            // Ahora sí, extraemos los datos asociados y continuamos como antes:
            $antecedentesMedicosData = [];
            if (!empty($data['antecedentes_medicos'])) {
                foreach ($data['antecedentes_medicos'] as $antecedente) {
                    if (tieneDatos($antecedente)) {
                        $antecedentesMedicosData[] = $antecedente;
                    }
                }
            }
            unset($data['antecedentes_medicos']);

            $antecedentesOdontologicosData = [];
            if (!empty($data['antecedentes_odontologicos'])) {
                foreach ($data['antecedentes_odontologicos'] as $antecedente) {
                    if (tieneDatos($antecedente)) {
                        $antecedentesOdontologicosData[] = $antecedente;
                    }
                }
            }
            unset($data['antecedentes_odontologicos']);

            $contactosEmergenciaData = [];
            if (!empty($data['contactos_emergencia'])) {
                foreach ($data['contactos_emergencia'] as $contacto) {
                    if (tieneDatos($contacto)) {
                        $contactosEmergenciaData[] = $contacto;
                    }
                }
            }
            unset($data['contactos_emergencia']);

            $enfermedadesActualesData = [];
            if (!empty($data['enfermedades_actuales'])) {
                foreach ($data['enfermedades_actuales'] as $enfermedad) {
                    if (tieneDatos($enfermedad)) {
                        $enfermedadesActualesData[] = $enfermedad;
                    }
                }
            }
            unset($data['enfermedades_actuales']);

            // Continuar con patchEntity y save() como ya tenías
            $pacientes1 = $this->Pacientes1->patchEntity($pacientes1, $data, [
                'associated' => [
                    'Pacientes' => [
                        'associated' => [
                            'AntecedentesMedicos',
                            'AntecedentesOdontologicos',
                            'ContactosEmergencia',
                            'EnfermedadesActuales'
                        ]
                    ]
                ]
            ]);

            if ($pacientes1->getErrors()) {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => false,
                            'errors' => $pacientes1->getErrors(),
                        ]));
                }
                $this->Flash->error(__('Por favor corrija los errores antes de continuar.'));
            } elseif ($this->Pacientes1->save($pacientes1)) {
                if (!empty($antecedentesMedicosData)) {
                    $this->guardarDatosAsociados('AntecedentesMedicos', $antecedentesMedicosData, 'pacientes1_id', $pacientes1->id);
                }

                if (!empty($antecedentesOdontologicosData)) {
                    $this->guardarDatosAsociados('AntecedentesOdontologicos', $antecedentesOdontologicosData, 'pacientes1_id', $pacientes1->id);
                }

                if (!empty($contactosEmergenciaData)) {
                    $this->guardarDatosAsociados('ContactosEmergencia', $contactosEmergenciaData, 'pacientes1_id', $pacientes1->id);
                }

                if (!empty($enfermedadesActualesData)) {
                    $this->guardarDatosAsociados('EnfermedadesActuales', $enfermedadesActualesData, 'pacientes1_id', $pacientes1->id);
                }

                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode([
                            'success' => true,
                            'message' => __('El paciente y sus datos han sido guardados correctamente.'),
                        ]));
                }

                $this->Flash->success(__('El paciente y sus datos han sido guardados correctamente.'));
                return $this->redirect(['action' => 'view', $pacientes1->id]);
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
        $this->set(compact('pacientes1'));

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
     * @param string|null $id Pacientes1 id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($pacienteId = null)
    {
        $rolesPermitidos = [1, 2, 3];
        $rolUsuario = $this->request->getAttribute('identity')->rol;

        if (!in_array($rolUsuario, $rolesPermitidos)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }

        // Cargar paciente con relaciones necesarias y también pacientes1
        $pacientes1 = $this->Pacientes1->get($pacienteId, 
            contain : [
                'Pacientes' => [
                    'AntecedentesMedicos',
                    'AntecedentesOdontologicos',
                    'ContactosEmergencia',
                    'EnfermedadesActuales',
                    'RegistrosTratamientos' => [
                        'Tratamientos'
                    ]
                ],
            ]
        );

        // Para cargar lista de tratamientos disponibles
        $tratamientosData = $this->Pacientes1->Pacientes->RegistrosTratamientos->Tratamientos->find()
            ->select(['id', 'nombre', 'descripcion', 'costo'])
            ->toArray();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Extraer datos de Pacientes1 y demás datos relacionados
            $pacientes1Data = $data['pacientes1'] ?? [];
            unset($data['pacientes1']);

            // Extraemos datos de las tablas relacionadas que dependen del paciente
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

            $connection = $this->Pacientes1->getConnection();
            $connection->begin();

            try {
                // Actualizar paciente principal con relaciones
                $paciente = $this->Pacientes1->patchEntity($pacientes1, $data, [
                    'associated' => [
                    'Pacientes' => [
                        'AntecedentesMedicos',
                        'AntecedentesOdontologicos',
                        'ContactosEmergencia',
                        'EnfermedadesActuales',
                        'RegistrosTratamientos',
                    ]
                ]
            ]);

                // Actualizar datos del paciente principal
                if (!$this->Pacientes1->save($paciente)) {
                    throw new \Exception('No se pudo guardar el paciente.');
                }

                // Guardar registros de antecedentes y tratamientos manualmente porque pueden necesitar lógica especial
                $this->guardarDatosAsociados('AntecedentesMedicos', $antecedentesMedicosData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('AntecedentesOdontologicos', $antecedentesOdontologicosData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('ContactosEmergencia', $contactosEmergenciaData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('EnfermedadesActuales', $enfermedadesActualesData, 'paciente_id', $paciente->id);
                $this->guardarDatosAsociados('RegistrosTratamientos', $registrosTratamientosData, 'paciente_id', $paciente->id);


                $connection->commit();
                $this->Flash->success(__('El paciente y sus datos relacionados han sido actualizados.'));
                return $this->redirect(['controller' => 'Pacientes1', 'action' => 'view', $paciente->id]);
            } catch (\Exception $e) {
                $connection->rollback();
                $this->Flash->error(__('Ocurrió un error: ' . $e->getMessage()));
            }
        }

        // Para select, autocomplete, etc.
        $tratamientos = $this->Pacientes1->Pacientes->RegistrosTratamientos->Tratamientos
            ->find('list', keyField: 'id', valueField: 'nombre')
            ->toArray();

        $this->set(compact('pacientes1', 'tratamientos', 'tratamientosData'));
    }

    private function guardarDatosAsociados($tabla, $datos, $foreignKey, $pacientes1Id)
    {
        // Buscar el paciente relacionado a partir de pacientes1.id
        $paciente = $this->Pacientes1->Pacientes->find()
            ->where(['paciente_id' => $pacientes1Id])
            ->first();

        if (!$paciente) {
            throw new \Exception('No se encontró un registro en pacientes para pacientes1_id: ' . $pacientes1Id);
        }

        foreach ($datos as $registroData) {
            if (!empty($registroData['id'])) {
                // Actualizar registro existente
                $registro = $this->Pacientes1->Pacientes->{$tabla}->get($registroData['id']);
                $registro = $this->Pacientes1->Pacientes->{$tabla}->patchEntity($registro, $registroData);
            } else {
                // Crear nuevo registro
                $registro = $this->Pacientes1->Pacientes->{$tabla}->newEntity($registroData);
                $registro->{$foreignKey} = $paciente->id; // Ahora usamos el ID de la tabla pacientes
            }

            // Guardar registro y manejar errores
            if (!$this->Pacientes1->Pacientes->{$tabla}->save($registro)) {
                throw new \Exception('No se pudo guardar un registro en ' . $tabla . '.');
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Pacientes1 id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pacientes1 = $this->Pacientes1->get($id);
        if ($this->Pacientes1->delete($pacientes1)) {
            $this->Flash->success(__('The pacientes1 has been deleted.'));
        } else {
            $this->Flash->error(__('The pacientes1 could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // busqueda en otras tablas
    public function buscarPaciente()
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('json');

        $query = $this->request->getQuery('q');

        if (!$query) {
            return $this->response->withStringBody(json_encode([]));
        }

        $resultados = $this->Pacientes1->find()
            ->innerJoinWith('Pacientes') // <- esto asegura que tenga datos en la tabla Pacientes
            ->where([
                'OR' => [
                    'Pacientes1.nombre LIKE' => '%' . $query . '%',
                    'Pacientes1.apellido LIKE' => '%' . $query . '%',
                ]
            ])
            ->select(['Pacientes1.id', 'Pacientes1.nombre', 'Pacientes1.apellido'])
            ->limit(10)
            ->toArray();

        $pacientes = array_map(fn($paciente) => [
            'id' => $paciente->id,
            'nombre' => $paciente->nombre . ' ' . $paciente->apellido,
        ], $resultados);

        return $this->response->withStringBody(json_encode($pacientes));
    }
}

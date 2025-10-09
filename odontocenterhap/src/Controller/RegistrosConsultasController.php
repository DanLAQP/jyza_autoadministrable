<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\RegistrosConsulta;
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Routing\Router;

/**
 * RegistrosConsultas Controller
 *
 * @property \App\Model\Table\RegistrosConsultasTable $RegistrosConsultas
 */
class RegistrosConsultasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function exportPdf($id = null)
    {
        $logoUrl = Router::url('/img/logoClinica.png', true);
        $registros = $this->RegistrosConsultas->get(
            $id,
            contain: [
                'Pacientes1' => ['Pacientes'],
                'Doctores',
                'ConsultasTratamientos' => ['Tratamientos']
            ],
        );

        // Calcular totales
        $totalMontoDoctor = 0;
        $totalMontoMateriales = 0;
        $totalMontoClinica = 0;
        $totalCosto = 0;

        foreach ($registros->consultas_tratamientos as $tratamiento) {
            $totalMontoDoctor += $tratamiento->monto_doctor;
            $totalMontoMateriales += $tratamiento->monto_materiales;
            $totalMontoClinica += $tratamiento->monto_clinica;
            $totalCosto += $tratamiento->costo;
        }
        
        // Obtener apellido del paciente1
        $apellidoPaciente = $registros->pacientes1->apellido ?? 'sin_apellido';
        // Limpiar para nombre de archivo (sin espacios ni caracteres raros)
        $apellidoPaciente = preg_replace('/[^A-Za-z0-9_\-]/', '_', $apellidoPaciente);
        // Obtener nombre del paciente1
        $nombrePaciente = $registros->pacientes1->nombre ?? 'sin_nombre';
        // Limpiar para nombre de archivo (sin espacios ni caracteres raros)
        $nombrePaciente = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nombrePaciente);
        //fecha actual
        $fechaActual = date('Y-m-d');

        // Pasar variables a la vista
        $this->set(compact(
            'registros',
            'logoUrl',
            'totalMontoDoctor',
            'totalMontoMateriales',
            'totalMontoClinica',
            'totalCosto'
        ));

        $this->viewBuilder()->enableAutoLayout(false);
        $html = $this->render('export_pdf');
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();


        $dompdf->stream("{$apellidoPaciente}_{$nombrePaciente}_{$fechaActual}.pdf", ['Attachment' => 1]);
    }

    public function index()
    {
        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('Acceso no autorizado'));
            return $this->redirect($this->referer());
        }

        // Obtener parámetros de búsqueda
        $searchTerm = $this->request->getQuery('search', '');
        $startDate = $this->request->getQuery('start_date', date('Y-m-01')) . ' 00:00:00';
        $endDate = $this->request->getQuery('end_date', date('Y-m-d')) . ' 23:59:59';

        // Obtener la fecha y hora actual
        $now = date('Y-m-d H:i:s');

        // Validar que las fechas no sean futuras
        $errors = [];
        if ($startDate > $now) {
            $errors[] = __('La fecha de inicio no puede estar en el futuro.');
            $startDate = date('Y-m-01') . ' 00:00:00'; // Reajustar al inicio del mes actual
        }

        if ($endDate > $now) {
            $errors[] = __('La fecha de fin no puede estar en el futuro.');
            $endDate = date('Y-m-d') . ' 23:59:59'; // Reajustar al día actual
        }

        // Mostrar errores si hay validaciones fallidas
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->Flash->error($error);
            }
        }

        // Construir consulta base
        $query = $this->RegistrosConsultas->find()
            ->contain(['Pacientes1' => ['Pacientes'], 'Doctores', 'ConsultasTratamientos' => ['Tratamientos']])
            ->where([
                'RegistrosConsultas.created >=' => $startDate,
                'RegistrosConsultas.created <=' => $endDate,
            ])
            ->order(['RegistrosConsultas.id' => 'DESC']);


        // Filtro por términos de búsqueda
        if (!empty($searchTerm)) {
            $lowerSearchTerm = strtolower($searchTerm);
            $query->where([
                'OR' => [
                    'LOWER(Pacientes1.nombre) LIKE' => '%' . $lowerSearchTerm . '%',
                    'LOWER(Doctores.nombre) LIKE' => '%' . $lowerSearchTerm . '%',
                    'LOWER(Doctores.apellido) LIKE' => '%' . $lowerSearchTerm . '%',
                ],
            ]);
        }

        // Paginación
        $registros = $this->paginate($query);

        // Calcular los montos totales después de la paginación
        foreach ($registros as $registroConsulta) {
            $totalMontoDoctor = 0;
            $totalMontoMateriales = 0;
            $totalMontoClinica = 0;
            $totalCosto = 0;

            foreach ($registroConsulta->consultas_tratamientos as $tratamiento) {
                $totalMontoDoctor += $tratamiento->monto_doctor;
                $totalMontoMateriales += $tratamiento->monto_materiales;
                $totalMontoClinica += $tratamiento->monto_clinica;
                $totalCosto += ($tratamiento->costo * $tratamiento->cantidad);
            }

            // Agregar los montos totales a la consulta
            $registroConsulta->_total_monto_doctor = $totalMontoDoctor;
            $registroConsulta->_total_monto_materiales = $totalMontoMateriales;
            $registroConsulta->_total_monto_clinica = $totalMontoClinica;
            $registroConsulta->_total_costo = $totalCosto;
        }

        $this->set(compact('registros', 'searchTerm', 'startDate', 'endDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Registros Consulta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $registro = $this->RegistrosConsultas->get($id, contain: ['Pacientes1' => ['Pacientes'], 'Doctores', 'ConsultasTratamientos' => ['Tratamientos']]);
        $this->set(compact('registro'));

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
    public function add($paciente_id = null)
    {
        $usuario = $this->Authentication->getIdentity();

        if (!$usuario) {
            $this->Flash->error(__('Debes iniciar sesión.'));
            return $this->redirect(['controller' => 'Usuarios', 'action' => 'login']);
        }

        $roles = [1, 2, 3];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }
        $registros = $this->RegistrosConsultas->newEmptyEntity();

        $doctorId = null;

        // Si el usuario es un doctor (rol = 3) y tiene un doctor_id, asignarlo automáticamente
        if ($usuario->rol == 3 && !empty($usuario->doctor_id)) {
            $doctorId = $usuario->doctor_id;
        }

        $pacienteSeleccionado = null; // Variable para el paciente seleccionado

        // Prellenar datos si el paciente_id fue pasado como parámetro en la URL
    if ($paciente_id) {
        $registros->paciente_id = $paciente_id;
        $pacienteSeleccionado = $this->RegistrosConsultas->Pacientes1->find()
            ->where(['id' => $paciente_id])
            ->first();
    }

        if ($this->request->is('post')) {
            $data = $this->request->getData();


            if ($doctorId) {
                $data['doctor_id'] = $doctorId;
            }

            $registros = $this->RegistrosConsultas->patchEntity($registros, $data);

            if ($this->RegistrosConsultas->save($registros)) {
                $registroId = $registros->id;
                // Guardar tratamientos en la tabla intermedia
                if (!empty($data['tratamientos'])) {
                    $consultasTratamientosTable = $this->fetchTable('ConsultasTratamientos');
                    foreach ($data['tratamientos'] as $t) {
                        $consultaTratamiento = $consultasTratamientosTable->newEmptyEntity();
                        $consultaTratamiento->registro_id = $registroId;
                        $consultaTratamiento->tratamiento_id = $t['tratamiento_id'] ?? null;
                        $consultaTratamiento->costo = $t['costo'];
                        $consultaTratamiento->monto_doctor = $t['monto_doctor'];
                        $consultaTratamiento->monto_clinica = $t['monto_clinica'];
                        $consultaTratamiento->monto_materiales = $t['monto_materiales'];
                        $consultaTratamiento->cantidad = $t['cantidad'];
                        $consultasTratamientosTable->save($consultaTratamiento);
                    }
                }

                $this->Flash->success(__('La consulta ha sido guardada.'));

                if ($paciente_id) {
                    return $this->redirect(['controller' => 'Pacientes1', 'action' => 'view', $paciente_id, '#' => 'consultas']);
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar la consulta. Inténtelo de nuevo.'));
        }

        $pacientes = $this->RegistrosConsultas->Pacientes1->find('list');
        $doctores = $this->RegistrosConsultas->Doctores->find('list');
        $tratamientos = $this->fetchTable('Tratamientos')->find()
            ->select(['id', 'nombre', 'costo'])
            ->toArray();
        $this->set(compact('registros', 'pacientes', 'doctores', 'tratamientos', 'doctorId', 'pacienteSeleccionado'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Registros Consulta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }

        $registroConsulta = $this->RegistrosConsultas->get($id,contain: [
            'ConsultasTratamientos',
            'Pacientes1' => [
                'Pacientes',
            ],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $registroConsulta = $this->RegistrosConsultas->patchEntity($registroConsulta, $data);

            if ($this->RegistrosConsultas->save($registroConsulta)) {
                // Obtener la tabla de la relación intermedia
                $consultasTratamientosTable = $this->fetchTable('ConsultasTratamientos');

                // Obtener los tratamientos previos
                $tratamientosPrevios = [];
                foreach ($registroConsulta->consultas_tratamientos as $t) {
                    $tratamientosPrevios[$t->id] = $t;
                }

                if (!empty($data['tratamientos'])) {
                    foreach ($data['tratamientos'] as $t) {
                        $consultaTratamientoId = $t['id'] ?? null; // Verificar si ya tiene un ID

                        if ($consultaTratamientoId && isset($tratamientosPrevios[$consultaTratamientoId])) {
                            // Si el tratamiento ya existe, actualizamos sus valores
                            $consultaTratamiento = $tratamientosPrevios[$consultaTratamientoId];
                            $consultaTratamiento->tratamiento_id = $t['tratamiento_id'] ?? null;
                            $consultaTratamiento->costo = $t['costo'];
                            $consultaTratamiento->monto_doctor = $t['monto_doctor'];
                            $consultaTratamiento->monto_clinica = $t['monto_clinica'];
                            $consultaTratamiento->monto_materiales = $t['monto_materiales'];
                            $consultaTratamiento->cantidad = $t['cantidad'];
                            $consultasTratamientosTable->save($consultaTratamiento);
                            $tratamientosProcesados[] = $consultaTratamientoId;
                        } else {
                            // Si no tiene ID, es un nuevo tratamiento
                            $consultaTratamiento = $consultasTratamientosTable->newEmptyEntity();
                            $consultaTratamiento->registro_id = $id;
                            $consultaTratamiento->tratamiento_id = $t['tratamiento_id'] ?? null;
                            $consultaTratamiento->costo = $t['costo'];
                            $consultaTratamiento->monto_doctor = $t['monto_doctor'];
                            $consultaTratamiento->monto_clinica = $t['monto_clinica'];
                            $consultaTratamiento->monto_materiales = $t['monto_materiales'];
                            $consultaTratamiento->cantidad = $t['cantidad'];
                            $consultasTratamientosTable->save($consultaTratamiento);
                        }
                    }
                }

                $this->Flash->success(__('El registro de consulta ha sido actualizado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el registro de consulta. Inténtelo de nuevo.'));
        }

$pacientes = $this->RegistrosConsultas->Pacientes1->find('list', 
    keyField : 'id',
    valueField : function ($row) {
        return $row['nombre'] . ' ' . $row['apellido'];
    }
)->toArray();

$this->set(compact('pacientes'));

        $doctores = $this->RegistrosConsultas->Doctores->find('list');
        $tratamientos = $this->fetchTable('Tratamientos')->find()
            ->select(['id', 'nombre', 'costo'])
            ->toArray();

        $this->set(compact('registroConsulta', 'pacientes', 'doctores', 'tratamientos'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
        } else {
            $this->viewBuilder()->setLayout('default');
        }
    }

    public function toggleState($id = null)
    {
        // Asegurarse de que el registro exista
        $registro = $this->RegistrosConsultas->get($id);

        // Cambiar el estado de 'A' a 'I' o viceversa
        $registro->estado = ($registro->estado === 'A') ? 'I' : 'A';

        // Guardar el cambio
        if ($this->RegistrosConsultas->save($registro)) {
            $this->Flash->success(__('Estado actualizado correctamente.'));
        } else {
            $this->Flash->error(__('No se pudo actualizar el estado.'));
        }

        // Redirigir de nuevo a la página de la lista
        return $this->redirect(['action' => 'index']);
    }
}

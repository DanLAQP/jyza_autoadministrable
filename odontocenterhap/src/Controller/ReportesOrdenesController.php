<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportesOrdenesController extends AppController
{
    public function index()
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }

        $doctoresTable = $this->fetchTable('Doctores');
        $pacientesTable = $this->fetchTable('Pacientes1');
        $tratamientosTable = $this->fetchTable('Tratamientos');

        $doctores = $doctoresTable->find('list', keyField: 'id', valueField: 'nombre')->toArray();
        $pacientes = $pacientesTable->find('list', keyField: 'id', valueField: 'nombre')->toArray();
        $tratamientos = $tratamientosTable->find('list', keyField: 'id', valueField: 'nombre')->toArray();

        // Obtener parámetros del formulario
        $doctorId = $this->request->getQuery('doctor_id', '');
        $pacienteId = $this->request->getQuery('paciente_id', '');
        $startDate = $this->request->getQuery('start_date', '');
        $endDate = $this->request->getQuery('end_date', '');
        $estado = $this->request->getQuery('estado', '');
        $tipoPago = $this->request->getQuery('tipo_pago', '');
        $tratamientoId = $this->request->getQuery('tratamiento_id', '');

        // Construcción de la consulta
        $query = $this->ReportesOrdenes->find()
            ->contain(['Pacientes', 'Doctores']);

        // Aplicar filtros de fechas (usando fecha_creacion de la vista)
        if (!empty($startDate) && !empty($endDate)) {
            try {
                $fechaInicio = new \DateTime($startDate, new \DateTimeZone('America/Lima'));
                $fechaFin = new \DateTime($endDate, new \DateTimeZone('America/Lima'));
                $fechaFin->modify('+1 day -1 second');

                $query->where([
                    'ReportesOrdenes.fecha_creacion >=' => $fechaInicio->format('Y-m-d H:i:s'),
                    'ReportesOrdenes.fecha_creacion <=' => $fechaFin->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                $this->Flash->error('Formato de fechas inválido.');
                return $this->redirect($this->referer());
            }
        }

        // Filtro por Doctor
        if (!empty($doctorId)) {
            $query->where(['ReportesOrdenes.doctor_id' => $doctorId]);
        }

        // Filtro por Paciente
        if (!empty($pacienteId)) {
            $query->where(['ReportesOrdenes.paciente_id' => $pacienteId]);
        }

        // Filtro por Estado
        if (!empty($estado)) {
            $query->where(['ReportesOrdenes.estado' => $estado]);
        }

        // Filtro por Tipo de Pago
        if (!empty($tipoPago)) {
            if ($tipoPago === 'completo') {
                $query->where(['ReportesOrdenes.saldo_pendiente' => 0]);
            } elseif ($tipoPago === 'parcial') {
                $query->where(['ReportesOrdenes.saldo_pendiente >' => 0]);
            }
        }

        // Filtro por Tratamiento
        if (!empty($tratamientoId)) {
            $ordenesConTratamiento = TableRegistry::getTableLocator()->get('OrdenesTratamientos')
                ->find()
                ->select(['orden_id'])
                ->where(['tratamiento_id' => $tratamientoId]);

            $query->where(['ReportesOrdenes.orden_id IN' => $ordenesConTratamiento]);
        }

        $reportes = $this->paginate($query, [
            'order' => ['fecha_creacion' => 'DESC'],
            'limit' => 50
        ]);

        // Opciones para los selects
        $opcionesEstado = [
            '' => 'Todos',
            'pendiente' => 'Pendiente',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];

        $this->set(compact(
            'reportes', 
            'doctorId', 
            'pacienteId', 
            'startDate', 
            'endDate', 
            'estado',
            'tipoPago',
            'tratamientoId',
            'doctores', 
            'pacientes', 
            'tratamientos',
            'opcionesEstado'
        ));
    }

    public function exportarPdf()
    {
        $doctorId = $this->request->getQuery('doctor_id', '');
        $pacienteId = $this->request->getQuery('paciente_id', '');
        $startDate = $this->request->getQuery('start_date', '');
        $endDate = $this->request->getQuery('end_date', '');
        $estado = $this->request->getQuery('estado', '');
        $tipoPago = $this->request->getQuery('tipo_pago', '');
        $tratamientoId = $this->request->getQuery('tratamiento_id', '');

        // Validar fechas
        if (empty($startDate) || empty($endDate)) {
            $this->Flash->error('Por favor, ingrese ambas fechas: Fecha de Inicio y Fecha Fin.');
            return $this->redirect(['action' => 'index']);
        }

        if ($startDate > $endDate) {
            $this->Flash->error('La Fecha de Inicio no puede ser mayor que la Fecha Fin.');
            return $this->redirect(['action' => 'index']);
        }

        // Ajustar fecha fin para incluir todo el día
        try {
            $fechaInicio = new \DateTime($startDate, new \DateTimeZone('America/Lima'));
            $fechaFin = new \DateTime($endDate, new \DateTimeZone('America/Lima'));
            $fechaFin->modify('+1 day -1 second');
        } catch (\Exception $e) {
            $this->Flash->error('Formato de fechas inválido.');
            return $this->redirect(['action' => 'index']);
        }

        // Construir consulta
        $query = $this->ReportesOrdenes->find()
            ->contain(['Pacientes', 'Doctores','OrdenesTratamientos.Tratamientos'])
            ->where([
                'fecha_creacion >=' => $fechaInicio->format('Y-m-d H:i:s'),
                'fecha_creacion <=' => $fechaFin->format('Y-m-d H:i:s'),
            ]);

        if (!empty($doctorId)) {
            $query->where(['ReportesOrdenes.doctor_id' => $doctorId]);
        }

        if (!empty($pacienteId)) {
            $query->where(['ReportesOrdenes.paciente_id' => $pacienteId]);
        }

        if (!empty($estado)) {
            $query->where(['ReportesOrdenes.estado' => $estado]);
        }


        if (!empty($tratamientoId)) {
            $ordenesConTratamiento = TableRegistry::getTableLocator()->get('OrdenesTratamientos')
                ->find()
                ->select(['orden_id'])
                ->where(['tratamiento_id' => $tratamientoId]);

            $query->where(['orden_id IN' => $ordenesConTratamiento]);
        }

        $reportes = $query->order(['fecha_creacion' => 'DESC'])->toArray();

        // Calcular totales
        $totalOrdenes = count($reportes);
        $totalMonto = array_sum(array_column($reportes, 'total_orden'));
        $totalSaldo = array_sum(array_column($reportes, 'saldo_pendiente'));

$resumenDoctores = [];
foreach ($reportes as $reporte) {
    $doctor = $reporte->nombre_doctor ?? 'Sin doctor';
    if (!isset($resumenDoctores[$doctor])) {
        $resumenDoctores[$doctor] = [
            'cantidad' => 0, // Agregado para contar órdenes
            'pago_doctor' => 0,
            'restante_clinica' => 0,
            'total' => 0,
            'porcentaje' => $reporte->porcentaje_doctor ?? 0
        ];
    }
    $resumenDoctores[$doctor]['cantidad']++;
    $resumenDoctores[$doctor]['pago_doctor'] += $reporte->pago_doctor;
    $resumenDoctores[$doctor]['restante_clinica'] += $reporte->restante_clinica;
    $resumenDoctores[$doctor]['total'] += $reporte->total_orden;
}

// Resumen por tratamiento (versión corregida)
$resumenTratamientos = [];
$ordenesIds = array_column($reportes, 'orden_id');

if (!empty($ordenesIds)) {
    $ordenesTratamientos = TableRegistry::getTableLocator()->get('OrdenesTratamientos')
        ->find()
        ->contain(['Tratamientos'])
        ->where(['orden_id IN' => $ordenesIds]);

    foreach ($ordenesTratamientos as $ot) {
        // Usar el nombre del tratamiento desde la relación
        $nombreTratamiento = $ot->tratamiento->nombre ?? 'Sin tratamiento';
        
        if (!isset($resumenTratamientos[$nombreTratamiento])) {
            $resumenTratamientos[$nombreTratamiento] = [
                'cantidad' => 0,
                'total' => 0
            ];
        }
        $resumenTratamientos[$nombreTratamiento]['cantidad'] += $ot->cantidad;
        $resumenTratamientos[$nombreTratamiento]['total'] += $ot->subtotal;
    }
}

        // Renderizar PDF
        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact(
            'reportes', 
            'startDate', 
            'endDate', 
            'totalOrdenes',
            'totalMonto',
            'totalSaldo',
            'resumenDoctores',
            'resumenTratamientos'
        ));
        $html = $this->render('export_pdf')->getBody()->__toString();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $this->response
            ->withType('application/pdf')
            ->withStringBody($dompdf->output());
    }
}
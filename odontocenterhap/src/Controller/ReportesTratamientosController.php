<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportesTratamientosController extends AppController
{
    public function index()
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('No tienes permisos para acceder a esta sección'));
            return $this->redirect($this->referer());
        }

        $doctoresTable = $this->fetchTable('Doctores');
        $pacientesTable = $this->fetchTable('Pacientes');
        $registrosTabla = $this->fetchTable('RegistrosConsultas');
        $tratamientosTabla = $this->fetchTable('Tratamientos');

        $doctores = $doctoresTable->find(
            'list',
            keyField: 'id',
            valueField: 'nombre'
        )->toArray();
        $pacientes = $pacientesTable->find('list', keyField: 'id', valueField: 'nombre')->toArray();
        $registroConsulta = $registrosTabla->find('list', keyField: 'id', valueField: 'tipo_pago')->toArray();
        $tratamientos = $tratamientosTabla->find('list', keyField: 'id', valueField: 'nombre')->toArray();

        // Obtener parámetros del formulario
        $doctorId = $this->request->getQuery('doctor_id', '');
        $pacienteId = $this->request->getQuery('paciente_id', '');
        $startDate = $this->request->getQuery('start_date', '');
        $endDate = $this->request->getQuery('end_date', '');
        $tipoPago = $this->request->getQuery('tipo_pago', '');
        $trantamientoNombre = $this->request->getQuery('tratamiento_id', '');
        
        if (empty($startDate) || empty($endDate)) {
            $hoy = new \DateTime('now', new \DateTimeZone('America/Lima'));
            $startDate = $hoy->format('Y-m-d'); // Inicio del día
            $endDate = $hoy->format('Y-m-d');   // Fin del mismo día
        }

        // Construcción de la consulta
        $query = $this->ReportesTratamientos->find();

        // Aplicar filtros de fechas
        if (!empty($startDate) && !empty($endDate)) {
            try {
                $fechaInicio = new \DateTime($startDate, new \DateTimeZone('America/Lima'));
                $fechaFin = new \DateTime($endDate, new \DateTimeZone('America/Lima'));
                $fechaFin->modify('+1 day -1 second');

                $query->where([
                    'fecha_modificacion >=' => $fechaInicio->format('Y-m-d H:i:s'),
                    'fecha_modificacion <=' => $fechaFin->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                $this->Flash->error('Formato de fechas inválido.');
                return $this->redirect($this->referer());
            }
        }

        // Filtro por Doctor
        if (!empty($doctorId)) {
            $query->where(['doctor_id' => $doctorId]);
        }

        // Filtro por Paciente
        if (!empty($pacienteId)) {
            $query->where(['paciente_id' => $pacienteId]);
        }

        // Filtro por Tipo de Pago
        if (!empty($tipoPago)) {
            $query->where(['tipo_pago' => $tipoPago]);
        }

        if (!empty($trantamientoNombre)) {
            $query->where(['tratamiento_id' => $trantamientoNombre]);
        }

        $reportes = $this->paginate($query);

        // Opciones de tipo de pago
        $opcionesPago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia',
            'tarjeta' => 'Tarjeta'
        ];

        $this->set(compact('reportes', 'doctorId', 'pacienteId', 'startDate', 'endDate', 'doctores', 'pacientes', 'tipoPago', 'opcionesPago', 'tratamientos'));
    }

    public function exportarPdf()
    {
        $doctorId = $this->request->getQuery('doctor_id', '');
        $pacienteId = $this->request->getQuery('paciente_id', '');
        $startDate = $this->request->getQuery('start_date', '');
        $endDate = $this->request->getQuery('end_date', '');
        $tipoPago = $this->request->getQuery('tipo_pago', '');
        $trantamientoNombre = $this->request->getQuery('tratamiento_id', '');

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
            $fechaFin->modify('+1 day -1 second'); // Incluir todo el día final
        } catch (\Exception $e) {
            $this->Flash->error('Formato de fechas inválido.');
            return $this->redirect(['action' => 'index']);
        }

        // Construir consulta
        $query = $this->ReportesTratamientos->find()
            ->where([
                'fecha_modificacion >=' => $fechaInicio->format('Y-m-d H:i:s'),
                'fecha_modificacion <=' => $fechaFin->format('Y-m-d H:i:s'),
            ]);

        if (!empty($doctorId)) {
            $query->where(['doctor_id' => $doctorId]);
        }

        if (!empty($pacienteId)) {
            $query->where(['paciente_id' => $pacienteId]);
        }

        if (!empty($tipoPago)) {
            $query->where(['tipo_pago' => $tipoPago]);
        }

        if (!empty($trantamientoNombre)) {
            $query->where(['tratamiento_id' => $trantamientoNombre]);
        }

        $reportes = $query->toArray();

        // Resumen por doctor
        $resumenDoctores = [];
        foreach ($reportes as $reporte) {
            $doctor = $reporte->nombre_doctor;
            if (!isset($resumenDoctores[$doctor])) {
                $resumenDoctores[$doctor] = [
                    'monto_doctor' => 0,
                    'monto_clinica' => 0,
                    'monto_materiales' => 0,
                    'total' => 0,
                ];
            }
            $resumenDoctores[$doctor]['monto_doctor'] += $reporte->monto_doctor;
            $resumenDoctores[$doctor]['monto_clinica'] += $reporte->monto_clinica;
            $resumenDoctores[$doctor]['monto_materiales'] += $reporte->monto_materiales;
            $resumenDoctores[$doctor]['total'] += (
                $reporte->monto_doctor + $reporte->monto_clinica + $reporte->monto_materiales
            );
        }

        // Resumen por tratamiento
        $resumenTratamientos = [];
        foreach ($reportes as $reporte) {
            $tratamiento = $reporte->nombre_tratamiento;
            if (!isset($resumenTratamientos[$tratamiento])) {
                $resumenTratamientos[$tratamiento] = [
                    'cantidad' => 0,
                    'total' => 0,
                ];
            }
            $resumenTratamientos[$tratamiento]['cantidad'] += $reporte->cantidad;
            $resumenTratamientos[$tratamiento]['total'] += (
                $reporte->monto_doctor + $reporte->monto_clinica + $reporte->monto_materiales
            );
        }

        // Renderizar PDF
        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact('reportes', 'startDate', 'endDate', 'resumenDoctores', 'resumenTratamientos'));
        $html = $this->render('export_pdf')->getBody()->__toString();

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->withType('application/pdf')
            ->withStringBody($dompdf->output());
    }
}

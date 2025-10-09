<?php

declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\ORM\TableRegistry;

class ReportesPacientesController extends AppController
{
    public function index()
    {
        $roles = [1, 2];
        if (!in_array($this->request->getAttribute('identity')->rol, $roles)) {
            $this->Flash->error(__('Acceso no autorizado'));
            return $this->redirect($this->referer());
        }

        $pacientesTable = $this->fetchTable('Pacientes');
        $tratamientosTable = $this->fetchTable('Tratamientos');

        $pacientes = $pacientesTable->find(
            'list',
            keyField: 'id',
            valueField: 'nombre'
        )->toArray();
        $tratamientos = $tratamientosTable->find(
            'list',
            keyField: 'id',
            valueField: 'nombre'
        )->toArray();

        // Obtener parámetros de filtro
        $pacienteId = $this->request->getQuery('paciente_id');
        $tratamientoId = $this->request->getQuery('tratamiento_id');
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');

        // Construcción de la consulta
        $query = $this->ReportesPacientes->find();

        // Aplicar filtros de fechas
        if (!empty($startDate) && !empty($endDate)) {
            try {
                $fechaInicio = new \DateTime($startDate, new \DateTimeZone('America/Lima'));
                $fechaFin = new \DateTime($endDate, new \DateTimeZone('America/Lima'));
                $fechaFin->modify('+1 day -1 second');

                $query->where([
                    'modified >=' => $fechaInicio->format('Y-m-d H:i:s'),
                    'modified <=' => $fechaFin->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                $this->Flash->error('Formato de fechas inválido.');
                return $this->redirect($this->referer());
            }
        }

        // Filtro por Paciente
        if (!empty($pacienteId)) {
            $query->where(['paciente_id' => $pacienteId]);
        }

        // Filtro por Tratamiento
        if (!empty($tratamientoId)) {
            $query->where(['tratamiento_id' => $tratamientoId]);
        }

        $reportes = $this->paginate($query);

        $this->set(compact('reportes', 'pacientes', 'tratamientos', 'pacienteId', 'tratamientoId', 'startDate', 'endDate'));
    }

    public function exportarPdf()
    {
        // Obtener parámetros
        $pacienteId = $this->request->getQuery('paciente_id');
        $tratamientoId = $this->request->getQuery('tratamiento_id');
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');

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
        $query = $this->ReportesPacientes->find()
            ->where([
                'modified >=' => $fechaInicio->format('Y-m-d H:i:s'),
                'modified <=' => $fechaFin->format('Y-m-d H:i:s'),
            ]);

        if (!empty($pacienteId)) {
            $query->where(['paciente_id' => $pacienteId]);
        }

        if (!empty($tratamientoId)) {
            $query->where(['tratamiento_id' => $tratamientoId]);
        }

        $reportes = $query->toArray();

        $total = 0;
        foreach ($reportes as $reporte) {
            $total += $reporte->tratamiento_costo;
        }

        // Renderizar PDF
        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact('reportes', 'startDate', 'endDate'));
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

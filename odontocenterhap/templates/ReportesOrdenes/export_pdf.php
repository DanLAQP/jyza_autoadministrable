<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Órdenes</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 0;
            padding: 15px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            margin-bottom: 20px;
        }
        th, td { 
            border: 1px solid black; 
            padding: 6px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .total-row { 
            font-weight: bold; 
            background-color: #e6e6e6; 
        }
        .header-info {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .section-title {
            margin-top: 25px;
            margin-bottom: 10px;
            color: #333;
            font-size: 14px;
        }
        .completo { color: green; }
        .parcial { color: orange; }
    </style>
</head>
<body>
    <h2>Reporte de Órdenes</h2>
    <div class="header-info">
        <p><strong>Período:</strong> <?= h($startDate) ?> al <?= h($endDate) ?></p>
        <p><strong>Total Órdenes:</strong> <?= $totalOrdenes ?></p>
        <p><strong>Monto Total:</strong> S/. <?= number_format($totalMonto, 2) ?></p>
        <p><strong>Saldo Pendiente:</strong> S/. <?= number_format($totalSaldo, 2) ?></p>
    </div>
    
    <!-- Tabla de Detalle de Órdenes -->
    <h3 class="section-title">Detalle de Órdenes</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID Orden</th>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Total</th>
                <th>Saldo</th>
                <th>Estado</th>
                <th>Pago Doctor</th>
                <th>Clínica</th>
                <th>Laboratorio</th>
                <th>Materiales</th>
                <th>Tratamientos</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $counter = 1;
                $sumTotal = 0;
                $sumSaldo = 0;
                $sumDoctor = 0;
                $sumClinica = 0;
                $sumLaboratorio = 0;
                $sumMateriales = 0;
            ?>
            <?php foreach ($reportes as $reporte): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= h($reporte->orden_id) ?></td>
                    <td><?= $reporte->fecha_creacion->format('d/m/Y H:i') ?></td>
                    <td><?= h($reporte->nombre_completo_paciente ?? 'N/A') ?></td>
                    <td><?= h($reporte->nombre_doctor ?? 'N/A') ?></td>
                    <td>S/. <?= number_format($reporte->total_orden, 2) ?></td>
                    <td>S/. <?= number_format($reporte->saldo_pendiente, 2) ?></td>
                    <td><?= ucfirst(h($reporte->estado)) ?></td>
                    <td>S/. <?= number_format($reporte->pago_doctor, 2) ?></td>
                    <td>S/. <?= number_format($reporte->restante_clinica, 2) ?></td>
                    <td>S/. <?= number_format($reporte->monto_laboratorio, 2) ?></td>
                    <td>S/. <?= number_format($reporte->monto_materiales, 2) ?></td>
                    <td><?= $this->Text->truncate(h($reporte->detalle_tratamientos ?? ''), 50) ?></td>
                </tr>
                <?php 
                    $sumTotal += $reporte->total_orden;
                    $sumSaldo += $reporte->saldo_pendiente;
                    $sumDoctor += $reporte->pago_doctor;
                    $sumClinica += $reporte->restante_clinica;
                    $sumLaboratorio += $reporte->monto_laboratorio;
                    $sumMateriales += $reporte->monto_materiales;
                ?>
            <?php endforeach; ?>
            <!-- Fila de totales -->
            <tr class="total-row">
                <td colspan="5">TOTALES:</td>
                <td>S/. <?= number_format($sumTotal, 2) ?></td>
                <td>S/. <?= number_format($sumSaldo, 2) ?></td>
                <td></td>
                <td>S/. <?= number_format($sumDoctor, 2) ?></td>
                <td>S/. <?= number_format($sumClinica, 2) ?></td>
                <td>S/. <?= number_format($sumLaboratorio, 2) ?></td>
                <td>S/. <?= number_format($sumMateriales, 2) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Resumen por Doctor -->
    <h3 class="section-title">Resumen por Doctor</h3>
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Cantidad Órdenes</th>
                <th>Total Órdenes</th>
                <th>Pago Doctor</th>
                <th>% Comisión</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumenDoctores as $nombreDoctor => $datos): ?>
                <tr>
                    <td><?= h($nombreDoctor) ?></td>
                    <td><?= $datos['cantidad'] ?></td>
                    <td>S/. <?= number_format($datos['total'], 2) ?></td>
                    <td>S/. <?= number_format($datos['pago_doctor'], 2) ?></td>
                    <td><?= number_format($datos['porcentaje'], 2) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    

    <!-- Resumen por Tratamiento -->
    <h3 class="section-title">Resumen por Tratamiento</h3>
    <table>
        <thead>
            <tr>
                <th>Tratamiento</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumenTratamientos as $nombreTratamiento => $datos): ?>
                <tr>
                    <td><?= h($nombreTratamiento) ?></td>
                    <td><?= $datos['cantidad'] ?></td>
                    <td>S/. <?= number_format($datos['total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
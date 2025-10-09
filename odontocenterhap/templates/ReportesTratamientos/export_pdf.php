<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Consultas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e6e6e6; }
    </style>
</head>
<body>
    <h2>Reporte de Consultas</h2>
    <p>Desde: <?= h($startDate) ?> Hasta: <?= h($endDate) ?></p>
    
    <!-- Tabla de Detalle de Consultas -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Paciente</th>
                <th>Doctor</th>
                <th>Tratamiento</th>
                <th>Cantidad</th>
                <th>Tipo de Pago</th>
                <th>Observaciones</th>
                <th>Monto Doctor</th>
                <th>Monto Clínica</th>
                <th>Monto Materiales</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $counter = 1;
                $sumDoctor = 0;
                $sumClinica = 0;
                $sumMateriales = 0;
                $sumTotal = 0;
            ?>
            <?php foreach ($reportes as $reporte): ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= h($reporte->nombre_paciente) ?></td>
                    <td><?= h($reporte->nombre_doctor) ?></td>
                    <td><?= h($reporte->nombre_tratamiento) ?></td>
                    <td><?= h($reporte->cantidad) ?></td>
                    <td><?= h($reporte->tipo_pago) ?></td>
                    <td><?= h($reporte->observaciones) ?></td>
                    <td>S/. <?= number_format((float)$reporte->monto_doctor, 2) ?></td>
                    <td>S/. <?= number_format((float)$reporte->monto_clinica, 2) ?></td>
                    <td>S/. <?= number_format((float)$reporte->monto_materiales, 2) ?></td>
                    <td>S/. <?= number_format((float)($reporte->monto_doctor + $reporte->monto_clinica + $reporte->monto_materiales), 2) ?></td>
                    <td><?= h($reporte->estado) ?></td>
                </tr>
                <?php 
                if ($reporte->estado === 'A') {
                    $sumDoctor += $reporte->monto_doctor;
                    $sumClinica += $reporte->monto_clinica;
                    $sumMateriales += $reporte->monto_materiales;
                    $sumTotal += ($reporte->monto_doctor + $reporte->monto_clinica + $reporte->monto_materiales);
                    }
                ?>
            <?php endforeach; ?>
            <!-- Fila de totales -->
            <tr class="total-row">
                <td colspan="7" style="text-align: left;">TOTALES:</td>
                <td>S/. <?= number_format($sumDoctor, 2) ?></td>
                <td>S/. <?= number_format($sumClinica, 2) ?></td>
                <td>S/. <?= number_format($sumMateriales, 2) ?></td>
                <td>S/. <?= number_format($sumTotal, 2) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Resumen -->
    <h3>Resumen por Doctor</h3>
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Monto Doctor</th>
                <th>Monto Clínica</th>
                <th>Monto Materiales</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumenDoctores as $doctor => $datos): ?>
                <tr>
                    <td><?= h($doctor) ?></td>
                    <td>S/. <?= number_format($datos['monto_doctor'], 2) ?></td>
                    <td>S/. <?= number_format($datos['monto_clinica'], 2) ?></td>
                    <td>S/. <?= number_format($datos['monto_materiales'], 2) ?></td>
                    <td>S/. <?= number_format($datos['total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>    

    <h3>Resumen por Tratamiento</h3>
<table>
    <thead>
        <tr>
            <th>Tratamiento</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resumenTratamientos as $tratamiento => $datos): ?>
            <tr>
                <td><?= h($tratamiento) ?></td>
                <td><?= h($datos['cantidad']) ?></td>
                <td>S/. <?= number_format($datos['total'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
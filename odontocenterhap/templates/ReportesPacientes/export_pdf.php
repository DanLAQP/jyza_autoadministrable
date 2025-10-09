<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Presupuesto</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e6e6e6; }
    </style>
</head>
<body>
    <h2>Reporte de Presupuesto</h2>
    <p>Desde: <?= h($startDate) ?> Hasta: <?= h($endDate) ?></p>

    <?php 
    $sumTotal = 0;
    $tratamientosAgrupados = [];

    // Recorrer los reportes para calcular totales y agrupar tratamientos
    foreach ($reportes as $reporte) {
        $tratamiento = $reporte->tratamiento_nombre;

        // Inicializar tratamiento si no está en el array
        if (!isset($tratamientosAgrupados[$tratamiento])) {
            $tratamientosAgrupados[$tratamiento] = [
                'nombre' => $tratamiento,
                'cantidad' => 0,
                'costo_unitario' => $reporte->tratamiento_costo,
                'total' => 0
            ];
        }

        // Sumar cantidad y total generado por tratamiento
        $tratamientosAgrupados[$tratamiento]['cantidad'] += $reporte->cantidad;
        $tratamientosAgrupados[$tratamiento]['total'] += $reporte->cantidad * $reporte->tratamiento_costo;
        $sumTotal += $reporte->cantidad * $reporte->tratamiento_costo;
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Paciente</th>
                <th>DNI</th>
                <th>Tratamiento</th>
                <th>Cantidad</th>
                <th>Fecha Presupuesto</th>
                <th>Costo Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportes as $reporte): ?>
            <tr>
                <td><?= h($reporte->paciente_nombre . ' ' . $reporte->paciente_apellido) ?></td>
                <td><?= h($reporte->paciente_dni) ?></td>
                <td><?= h($reporte->tratamiento_nombre) ?></td>
                <td><?= h($reporte->cantidad) ?></td>
                <td><?= $reporte->modified->format('d/m/Y') ?></td>
                <td>S/ <?= number_format($reporte->tratamiento_costo, 2) ?></td>
                <td>S/ <?= number_format($reporte->cantidad * $reporte->tratamiento_costo, 2) ?></td>
            </tr>
            <?php endforeach; ?>

            <tr class="total-row">
                <td colspan="5"></td>
                <td><strong>Total General:</strong></td>
                <td>S/ <?= number_format($sumTotal, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Resumen de Tratamientos -->
    <h3>Resumen de Tratamientos</h3>
    <table>
        <thead>
            <tr>
                <th>Tratamiento</th>
                <th>Cantidad Total</th>
                <th>Total Generado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tratamientosAgrupados as $tratamiento): ?>
            <tr>
                <td><?= h($tratamiento['nombre']) ?></td>
                <td><?= h($tratamiento['cantidad']) ?> unidades</td>
                <td>S/ <?= number_format($tratamiento['total'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer" style="margin-top: 30px;">
        <p>Nota: Los montos mostrados no incluyen IGV (18%)</p>
        <p>Generado el: <?= date('d/m/Y H:i') ?></p>
    </div>
</body>
</html>
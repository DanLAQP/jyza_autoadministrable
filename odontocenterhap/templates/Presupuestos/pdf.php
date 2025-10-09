<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Presupuesto #<?= $presupuesto->id ?></h2>
    <p><strong>Paciente:</strong> <?= h($presupuesto->paciente->nombre . ' ' . $presupuesto->paciente->apellido) ?></p>
    <p><strong>Dirección:</strong> <?= h($presupuesto->paciente->direccion) ?></p>
    <p><strong>Fecha:</strong> <?= $presupuesto->created->format('d/m/Y') ?></p>

    <table>
        <thead>
            <tr>
                <th>Tratamiento</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($presupuesto->presupuestos_tratamientos as $tratamiento) : ?>
                <tr>
                    <td><?= h($tratamiento->tratamiento->nombre) ?></td>
                    <td><?= $tratamiento->cantidad ?></td>
                    <td><?= number_format($tratamiento->tratamiento->costo, 2) ?></td>
                    <td><?= number_format($tratamiento->total, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Subtotal:</td>
                <td><?= number_format($presupuesto->subtotal, 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="total">IGV (18%):</td>
                <td><?= number_format($presupuesto->subtotal * 0.18, 2) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="total">Total:</td>
                <td><?= number_format($presupuesto->total, 2) ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
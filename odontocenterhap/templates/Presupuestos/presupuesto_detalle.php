<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }

        /* Encabezado centrado */
        .header {
            text-align: center; 
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
            margin-bottom: 10px;
        }

        .hed-cotizacion {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 0 auto;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hed-cotizacion h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #2F5081;
        }

        .hed-cotizacion p {
            margin: 5px 0;
            font-size: 14px;
            color: #111111;
        }

        /* Información General */
        .info {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .info p {
            margin: 5px 8px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #8FCED3;
            color: #ffffff;
            text-align: left;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tfoot tr {
            font-weight: bold;
        }

        table tfoot td {
            text-align: left;
        }

        .total-row td {
            background-color: #8FCED3;
            color: #ffffff;
            font-weight: bold;
        }

        /* Nota */
        .footer-note {
            font-size: 12px;
            color: #555;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <?= $this->Html->image($logoUrl, ['alt' => 'Logo', 'style' => 'width: 180px;']) ?>
            <div class="hed-cotizacion">
                <h1>Consultorio Odontocenter Hap</h1>
                <p>Jr. Munive 125 - distrito de San Juan bautista - huamanga - Ayacucho</p>
                 <!-- <p>Correo electrónico: yuwer_eg@hotmail.com</p> -->
                <p>Nro de Contacto: 941 700 453 - 973 933 884</p>
            </div>
        </div>

        <!-- Información del Presupuesto -->
        <div class="info">
            <p><strong>Fecha:</strong> 
                <?= $presupuesto->created ? $presupuesto->created->format('d/m/Y') : __('No disponible') ?>
            </p>
            <p><strong>Nombres y Apellidos:</strong> 
                <?= !empty($presupuesto->pacientes1) 
                    ? h(($presupuesto->pacientes1->nombre ?? '') . ' ' . ($presupuesto->pacientes1->apellido ?? '')) 
                    : __('No asignado') ?>
            </p>
            <p><strong>Dirección:</strong> 
                <?= !empty($presupuesto->pacientes1->paciente->direccion) 
                    ? h($presupuesto->pacientes1->paciente->direccion) 
                    : __('No disponible') ?>
            </p>
            <p><strong>DNI:</strong> 
                    <?= !empty($presupuesto->pacientes1->paciente->dni) 
                        ? h($presupuesto->pacientes1->paciente->dni) 
                        : __('No disponible') ?>
            </p>
        </div>

        <?php
        // Inicializar subtotal
        $subtotal = 0;

        // Calcular el subtotal sumando los totales de los tratamientos
        foreach ($presupuesto->presupuestos_tratamientos as $tratamiento) {
            $subtotal += $tratamiento->total;
        }
        ?>

        <!-- Tabla de Tratamientos -->
        <h3>Detalles de la Cotización</h3>
        <table>
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Tratamiento</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($presupuesto->presupuestos_tratamientos as $tratamiento): ?>
                    <tr>
                        <td><?= $tratamiento->cantidad ?></td>
                        <td><?= h($tratamiento->tratamiento->nombre) ?></td>
                        <td><?= number_format($tratamiento->precio_unitario, 2) ?></td>
                        <td><?= number_format($tratamiento->total, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total</td>
                    <td><?= number_format($subtotal, 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Nota -->
        <p class="footer-note">*Los precios incluyen IGV.</p>
    </div>
</body>
</html>

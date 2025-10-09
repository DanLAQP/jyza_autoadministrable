<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 15px;
            font-size: 12px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .receipt-section {
            display: inline-block;
            text-align: center;
            padding: 10px;
        }

        /* Company info section con logo */
        .company-info-section {
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            display: table;
            width: 100%;
        }

        .logo-area {
            display: table-cell;
            width: 200px;
            vertical-align: middle;
            text-align: left;
        }

        .logo-area img {
            width: 120px;
            height: auto;
        }

        .company-details-area {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 0 0 8px 0;
        }

        .company-details {
            font-size: 11px;
            color: #333;
            margin: 2px 0;
            line-height: 1.3;
        }

        .receipt-box {
            background-color: #ffffff;
            border: 2px solid rgb(122, 131, 141);
            border-left: 10px solid #4a90e2;
            border-radius: 10px;
            padding: 12px 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .receipt-title {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            margin: 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .receipt-title1 {
            font-size: 15px;
            font-weight: 700;
            color: #4a90e2;
            margin: 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .receipt-number {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-top: 8px;
        }


        /* Información del cliente */
        .client-info {
            padding: 15px 20px;
            display: table;
            width: 100%;
            border-bottom: 1px solid #ddd;
        }

        .client-left, .client-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .client-right {
            padding-left: 80px;
            align-items: center;
            text-align:center;
        }

        .info-row {
            margin: 6px 0;
            font-size: 11px;
        }
        .info-row1 {
            margin: 40px 0;
        }

        .info-label {
            /* font-weight: bold; */
            /* display: inline-block; */
            width: 100px;
        }

        /* Tabla de tratamientos */
        .treatments-section {
            padding: 0 20px 15px 20px;
        }

        .treatments-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .treatments-table th {
            background-color: #4a90e2;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #333;
            font-size: 12px;
        }

        .treatments-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            font-size: 11px;
        }

        .treatments-table .description {
            text-align: left;
        }

        .treatments-table .amount {
            text-align: right;
        }

        .treatments-table tfoot td {
            background-color: #e0e0e0;
            font-weight: bold;
            border: 1px solid #333;
            align-items:right;
            text-align: right;
        }

        .treatments-table .final-total td {
            background-color: #4a90e2;
            color: white;
            align-items:right;
            text-align: right;
        }

       
    </style>
</head>
<body>
    <div class="container">
        
       
        <!-- Company Info Section con logo -->
        <div class="company-info-section">
            <div class="logo-area">
                <?= $this->Html->image($logoUrl, ['alt' => 'Logo', 'style' => 'width: 120px; height: auto;']) ?>
            </div>
            <div class="company-details-area">
                <h2 class="company-name">Consultorio Odontocenter Hap</h2>
                <p class="company-details">Jr. Munive 125 - distrito de San Juan bautista - huamanga - Ayacucho</p>
                <p class="company-details">Número de contacto: 941 700 453 - 973 933 884</p>
                <!--<p class="company-details">Correo electrónico: yuwer_eg@hotmail.com</p> -->
            </div>
        </div>
        

        <!-- Información del cliente -->
        <div class="client-info">
            <div class="client-left">
                <div class="info-row1"></div>
                
                <div class="info-row">
                    <span class="info-label">Cliente:</span>
                    <span><?= h($registros->pacientes1->nombre . ' ' . $registros->pacientes1->apellido) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Documento:</span>
                    <span><?= h($registros->pacientes1->paciente->dni) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Doctor:</span>
                    <span><?= h($registros->doctore->nombre. ' ' . $registros->doctore->apellido) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Moneda:</span>
                    <span>SOLES</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipo de Pago:</span>
                    <span>EFECTIVO</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Emisión:</span>
                    <span><?= date('d/m/Y H:i') ?></span>
                </div>
            </div>
            <div class="client-right">
                <div class="receipt-box">
                    <!--<div class="receipt-title">RUC 20607602051</div>  -->
                    <div class="receipt-title1">RECIBO INTERNO</div>
                    <div class="receipt-number"># <?= $registros->id ?></div>
                </div>
                <!-- <div class="info-row">
                    <span class="info-label">Fecha Consulta:</span>
                    <span><?= $registros->created->format('d/m/Y H:i') ?></span>
                </div> -->
            </div>
        </div>

        <!-- Tabla de tratamientos -->
        <div class="treatments-section">
            <table class="treatments-table">
                <thead>
                    <tr>
                        <th>Cant</th>
                        <th>Descripción</th>
                        <th>Subtotal</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $valorVenta = 0;
                        $totalIGV = 0;
                    ?>
                    <?php foreach ($registros->consultas_tratamientos as $tratamiento): ?>
                        <?php 
                            // Calcular el subtotal (costo - IGV)
                            $subtotal = ($tratamiento->costo * $tratamiento->cantidad) - (($tratamiento->costo * $tratamiento->cantidad) * 0.18);
                            $valorVenta += $subtotal;
                            $totalIGV += ($tratamiento->costo * $tratamiento->cantidad) * 0.18;
                        ?>
                        <tr>
                            <td><?= h($tratamiento->cantidad) ?></td>
                            <td class="description"><?= h($tratamiento->tratamiento->nombre) ?></td>
                            <td class="amount"><?= $this->Number->currency($subtotal) ?></td>
                            <td class="amount"><?= $this->Number->currency($tratamiento->costo * $tratamiento->cantidad) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Valor de Venta:</strong></td>
                        <td ><strong><?= $this->Number->currency($valorVenta) ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Total IGV:</strong></td>
                        <td><strong><?= $this->Number->currency($totalIGV) ?></strong></td>
                    </tr>
                    <tr class="final-total">
                        <td colspan="3"><strong>Total Precio de Venta:</strong></td>
                        <td ><strong><?= $this->Number->currency($valorVenta + $totalIGV) ?></strong></td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
</body>
</html>
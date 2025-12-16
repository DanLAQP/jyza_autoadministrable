<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            width: 297mm; 
            height: 210mm; 
            margin: 0; 
            padding: 0; 
            font-family: 'Times New Roman', serif; 
            color: #000; 
            background: #000;
        }
        
        .page1, .page2 { 
            position: relative; 
            width: 297mm; 
            height: 210mm; 
            page-break-after: always;
            background: #000;
        }
        .page2 { page-break-after: auto; }
        
        .certificate { 
            position: absolute; 
            top: 12mm; 
            left: 12mm; 
            width: 273mm; 
            height: 186mm; 
            background: #e8e8e8;
        }
        
        /* Borde exterior dorado */
        .border-outer {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 2.5px solid #D4AF37;
        }
        
        /* Borde interior dorado */
        .border-inner {
            position: absolute;
            top: 2.5mm;
            left: 2.5mm;
            right: 2.5mm;
            bottom: 2.5mm;
            border: 1.5px solid #D4AF37;
            background: #f5f5f0;
            padding: 0;
        }
        
        /* Decoraciones en esquinas negras */
        .corner {
            position: absolute;
            width: 18mm;
            height: 18mm;
            background: #000;
            z-index: 10;
        }
        .corner-tl { top: 0; left: 0; border-radius: 0 0 100% 0; }
        .corner-tr { top: 0; right: 0; border-radius: 0 0 0 100%; }
        .corner-bl { bottom: 0; left: 0; border-radius: 0 100% 0 0; }
        .corner-br { bottom: 0; right: 0; border-radius: 100% 0 0 0; }
        
        /* Contenido página 1 */
        .content {
            position: relative;
            padding: 12mm 20mm;
            text-align: center;
            z-index: 5;
        }
        
        /* Logo CIFAA */
        .logo { 
            width: 45mm; 
            height: auto; 
            margin: 0 auto 3mm;
            display: block;
        }
        
        /* Título CERTIFICADO */
        .title {
            font-size: 52pt;
            font-weight: bold;
            color: #000;
            letter-spacing: 6px;
            margin: 5mm 0 6mm 0;
            font-family: 'Georgia', serif;
            text-transform: uppercase;
        }
        
        /* Código de verificación en esquina superior derecha */
        .codigo-section {
            position: absolute;
            top: 18mm;
            right: 22mm;
            text-align: center;
            z-index: 15;
        }
        
        .codigo-box {
            border: 1px solid #000;
            padding: 2mm 4mm;
            background: #fff;
            font-size: 7pt;
            font-weight: normal;
            font-family: Arial, sans-serif;
            line-height: 1.3;
        }
        
        /* OTORGADO A */
        .otorgado {
            font-size: 11pt;
            margin: 6mm 0 3mm 0;
            font-weight: normal;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        /* Nombre del estudiante */
        .nombre {
            font-size: 22pt;
            font-weight: bold;
            color: #000;
            margin: 4mm 0 6mm 0;
            text-transform: uppercase;
            border-bottom: 2.5px solid #000;
            display: inline-block;
            padding: 1mm 25mm;
        }
        
        /* Título del curso */
        .curso-nombre {
            font-size: 18pt;
            font-weight: bold;
            color: #000;
            margin: 6mm 0 5mm 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }
        
        /* Contenedor de firma y texto lado a lado */
        .firma-texto-container {
            display: table;
            width: 100%;
            margin: 8mm 0 5mm 0;
            border-collapse: collapse;
        }
        
        /* Firma y sello - 30% */
        .firma-section {
            display: table-cell;
            width: 30%;
            text-align: center;
            vertical-align: top;
            padding: 0 8mm 0 0;
        }
        
        .firma-box {
            border: 1.5px solid #000;
            padding: 4mm 3mm;
            background: #fff;
            min-height: 28mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            line-height: 1.3;
        }
        
        .firma {
            max-width: 100%;
            height: auto;
            max-height: 12mm;
        }
        
        .firma-nombre {
            font-size: 8pt;
            font-weight: bold;
            margin-top: 2mm;
        }
        
        .firma-cargo {
            font-size: 7pt;
            margin-top: 1mm;
        }
        
        /* Texto del cuerpo - 70% */
        .texto {
            display: table-cell;
            width: 70%;
            font-size: 10pt;
            line-height: 1.6;
            text-align: justify;
            vertical-align: top;
            padding: 2mm 0 0 8mm;
        }
        
        .texto strong {
            font-weight: bold;
        }
        
        /* Código de verificación visible */
        .codigo {
            font-size: 7pt;
            color: #333;
            text-align: center;
            margin-top: 2mm;
        }
        
        /* Marca de agua sutil */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-20deg);
            font-size: 100pt;
            color: rgba(0, 0, 0, 0.02);
            font-weight: bold;
            z-index: 1;
            pointer-events: none;
            letter-spacing: 10px;
        }
        
        /* ===== PÁGINA 2 - MÓDULOS ===== */
        .page2 .content {
            padding: 15mm 20mm;
        }
        
        .modulos-title {
            font-size: 20pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8mm;
            text-transform: uppercase;
            color: #000;
            border-bottom: 2px solid #000;
            padding-bottom: 3mm;
        }
        
        .page2 .logo {
            width: 35mm;
            margin-bottom: 5mm;
        }
        
        /* Tabla de módulos estilo imagen */
        .modulos-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5mm auto;
            font-family: Arial, sans-serif;
        }
        
        .modulos-table thead {
            background: #1a1a1a;
            color: #fff;
        }
        
        .modulos-table th {
            padding: 3mm 4mm;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
        }
        
        .modulos-table td {
            padding: 3mm 4mm;
            font-size: 9pt;
            border: 1px solid #666;
            text-align: center;
            vertical-align: middle;
            background: #fff;
        }
        
        .modulos-table td:first-child {
            font-weight: bold;
            width: 20%;
            background: #f5f5f0;
        }
        
        .modulos-table td:last-child {
            text-align: left;
            width: 80%;
        }
        
        /* Footer página 2 */
        .page2-footer {
            text-align: center;
            margin-top: 8mm;
            font-size: 8pt;
            color: #333;
        }
        
        .page2-footer .codigo-box {
            display: inline-block;
            margin-top: 3mm;
        }
    </style>
</head>
<body>

<!-- PÁGINA 1: CERTIFICADO PRINCIPAL -->
<div class="page1">
<div class="certificate">
    <div class="border-outer">
        <!-- Decoraciones en esquinas -->
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>
        
        <div class="border-inner">
            <!-- Marca de agua -->
            <div class="watermark">CIFAA</div>
            
            <div class="content">
                <!-- Logo CIFAA -->
                <?php if (!empty($logoBase64)): ?>
                    <img src="<?= $logoBase64 ?>" alt="Logo CIFAA" class="logo">
                <?php endif; ?>
                
                <!-- Código de verificación -->
                <div class="codigo-section">
                    <div class="codigo-box">Código: <?= h($certificado->codigo) ?></div>
                </div>
                
                <!-- Título principal -->
                <div class="title"><?= $esDiplomado ? 'DIPLOMADO' : 'CERTIFICADO' ?></div>
                
                <!-- OTORGADO A -->
                <div class="otorgado">OTORGADO A:</div>
                
                <!-- Nombre del estudiante -->
                <div class="nombre"><?= strtoupper(h($certificado->nombre_completo ?: $certificado->user->username)) ?></div>
                
                <!-- Nombre del curso -->
                <div class="curso-nombre"><?= strtoupper(h($certificado->nombre_curso ?: $certificado->curso->titulo)) ?></div>
                
                <!-- Firma y Texto lado a lado -->
                <div class="firma-texto-container">
                    <!-- Firma y sello - 30% -->
                    <div class="firma-section">
                        <div class="firma-box">
                            <?php if (!empty($firmaBase64)): ?>
                                <img src="<?= $firmaBase64 ?>" alt="Firma" class="firma">
                                <div class="firma-nombre">Dirección Académica</div>
                                <div class="firma-cargo">Centro Integral de Formación y Asesoría Académica - CIFAA</div>
                            <?php else: ?>
                                <div>Firma y sello del<br>gerente</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Texto del cuerpo - 70% -->
                    <div class="texto">
                        Habiendo completado y aprobado satisfactoriamente todas las evaluaciones, 
                        trabajos y proyectos requeridos durante el período comprendido entre el 
                        <strong><?= !empty($certificado->fecha_inicio) ? h($certificado->fecha_inicio) : '30 de agosto de 2025' ?></strong> y el 
                        <strong><?php 
                        if (!empty($certificado->fecha_fin)) {
                            echo h($certificado->fecha_fin);
                        } else {
                            echo h($certificado->fecha_emision->format('d')) . ' de ' . 
                                 h($certificado->fecha_emision->format('F')) . ' de ' . 
                                 h($certificado->fecha_emision->format('Y'));
                        }
                        ?></strong>, 
                        con un total de <strong><?= h($certificado->horas) ?> horas lectivas</strong><?php if (!empty($certificado->nota_final)): ?> 
                        y una nota final de <strong><?= h($certificado->nota_final) ?></strong><?php endif; ?>, 
                        en el <strong>Centro Integral de Formación y Asesoría Académica – CIFAA</strong>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- PÁGINA 2: MÓDULOS (solo si existen) -->
<?php 
$modulos = !empty($certificado->modulos) ? json_decode($certificado->modulos, true) : [];
if (!empty($modulos) && is_array($modulos)): 
?>
<div class="page2">
<div class="certificate">
    <div class="border-outer">
        <!-- Decoraciones en esquinas -->
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>
        
        <div class="border-inner">
            <!-- Marca de agua -->
            <div class="watermark">CIFAA</div>
            
            <div class="content">
                <!-- Logo CIFAA -->
                <?php if (!empty($logoBase64)): ?>
                    <img src="<?= $logoBase64 ?>" alt="Logo CIFAA" class="logo">
                <?php endif; ?>
                
                <!-- Título -->
                <div class="modulos-title">
                    CERTIFICADO EN <?= strtoupper(h($certificado->nombre_curso ?: $certificado->curso->titulo)) ?>
                </div>
                
                <!-- Subtítulo -->
                <div style="text-align: center; font-size: 10pt; margin-bottom: 5mm; font-weight: bold;">
                    Centro Integral de Formación y Asesoría Académica<br>CIFAA
                </div>
                
                <!-- Tabla de módulos -->
                <table class="modulos-table">
                    <thead>
                        <tr>
                            <th>MÓDULOS</th>
                            <th>TEMAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modulos as $modulo): ?>
                        <tr>
                            <td><?= h($modulo['numero'] ?? '') ?></td>
                            <td><?= h($modulo['tema'] ?? '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <!-- Footer con información adicional -->
                <div class="page2-footer">
                    <?php if (!empty($certificado->duracion_meses) || !empty($certificado->nota_final)): ?>
                    <div style="margin-bottom: 3mm; font-size: 9pt;">
                        <strong>CÓDIGO DEL CERTIFICADO: <?= h($certificado->codigo) ?></strong>
                        <?php if (!empty($certificado->duracion_meses)): ?>
                        &nbsp;&nbsp;|&nbsp;&nbsp; <strong>DURACIÓN:</strong> <?= h($certificado->duracion_meses) ?> <?= $certificado->duracion_meses == 1 ? 'MES' : 'MESES' ?>
                        <?php endif; ?>
                        <br>
                        <strong>HORAS LECTIVAS: <?= h($certificado->horas) ?></strong>
                        <?php if (!empty($certificado->nota_final)): ?>
                        &nbsp;&nbsp;|&nbsp;&nbsp; <strong>NOTA FINAL:</strong> <?= h($certificado->nota_final) ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div style="margin-top: 5mm;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?= urlencode($verificarUrl ?? 'http://localhost/certificados/verificar/' . $certificado->codigo) ?>" 
                             alt="QR Verificación" style="width: 20mm; height: 20mm;">
                    </div>
                    
                    <div style="margin-top: 2mm; font-size: 7pt; color: #666;">
                        <strong>+51 901 562 110</strong> &nbsp;&nbsp;&nbsp;&nbsp; 
                        Centro Integral de Formación y Asesoría Académica - CIFAA
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php endif; ?>

</body>
</html>

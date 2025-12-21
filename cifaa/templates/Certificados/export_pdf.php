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
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            width: 273mm; 
            height: 180mm; 
            /* background: #e8e8e8; */
        }
        
        /* Borde exterior dorado */
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 5mm;
            right: 5mm;
            bottom: 8mm;
            /* border: 1.5px solid #ffcc00; */
            box-sizing: border-box;
            z-index: 120;
            background: #f5f5f0;

        }
        
        /* Borde interior dorado */
        .border-inner {
            position: absolute;
            top: 1mm;
            left: 1mm;
            right: 1mm;
            bottom: 17mm;
            border: 2.5px solid #ffcc00;
            padding: 0;
            box-sizing: border-box;
            z-index: 12;
        }
        .border-inner1 {
            position: absolute;
            top: 0mm;
            left: 0mm;
            right: 0mm;
            bottom: 16mm;
            border: 1px solid #ffcc00;
            padding: 0;
            box-sizing: border-box;
            z-index: 12;
        }
        
        
        /* Decoraciones en esquinas negras */
        .corner {
            position: absolute;
            width: 15mm;
            height: 15mm;
            background: #000;
            z-index: 1;
            /* display:none; */
        }
        .corner-tl { top: -2.5mm; left: -2.5mm; border-radius: 0 0 100% 0; }
        .corner-tr { top: -2.5mm; right: -2.5mm; border-radius: 0 0 0 100%; }
        .corner-bl { bottom: 13mm; left: -2.5mm; border-radius: 0 100% 0 0; }
        .corner-br { bottom: 13mm; right: -2.5mm; border-radius: 100% 0 0 0; }
        
        /* Contenido página 1 */
        .content {
            position: relative;
            padding: 8mm 20mm;
            text-align: center;
            z-index: 5;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* Logo CIFAA */
        .logo { 
            width: 40mm; 
            height: auto; 
            margin: 0 auto 2mm;
            display: block;
        }
        
        /* Título CERTIFICADO */
        .title {
            font-size: 48pt;
            font-weight: bold;
            color: #000;
            letter-spacing: 6px;
            margin: 2mm 0 4mm 0;
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
            margin: 3mm 0 2mm 0;
            font-weight: normal;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        /* Nombre del estudiante */
        .nombre {
            font-size: 20pt;
            font-weight: bold;
            color: #000;
            margin: 2mm 0 4mm 0;
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
            margin: 4mm 0 3mm 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }
        
        /* Contenedor de firma y texto lado a lado */
        .firma-texto-container {
            width: 100%;
            margin: 4mm 0 2mm 0;
            /* text-align: center; */
        }
        
        .firma-texto-container::after {
            content: "";
            display: table;
            clear: both;
        }
        
        /* Firma y sello - izquierda */
        .firma-section {
            float: left;
            width: 30%;
            text-align: left;
            padding-right: 8mm;
        }
        
        .firma-img {
            width: 60mm;
            height: auto;
        }
        .firma {
            font-size: 9pt;
            /* margin-top: 2mm; */

        }
        .firma-text {
            border-top: 1px dotted #000;
            font-weight: 700;
            /* padding-top: 8px; */
            text-align: center;
        }
        
        /* Texto del cuerpo - derecha */
        .texto {
            float: left;
            width: 70%;
            font-size: 14pt;
            line-height: 1.7;
            text-align: justify;
            padding-left: 4mm;
            padding-top: 2mm;
        }
        
        .texto strong {
            font-weight: bold;
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
            /* padding: 15mm 20mm; */
            background: #f5f5f0;
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
        
        .qr-code {
            width: 20mm;
            height: 20mm;
            margin: 3mm auto;
        }
        
        .contact-footer {
            margin-top: 2mm;
            font-size: 7pt;
            color: #666;
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
        
        <div class="border-inner1"> 
            <div class="border-inner">
                
                <!-- Marca de agua -->
                <div class="watermark">CIFAA</div>
                
                <div class="content">
                    <!-- Logo CIFAA -->
                    <?php if (!empty($logoUrl)): ?>
                        <img src="<?= $logoUrl ?>" alt="Logo CIFAA" class="logo">
                    <?php endif; ?>
                    
                    <!-- Código de verificación -->
                    <div class="codigo-section">
                        <div class="codigo-box">Código: <?= h($certificado->codigo) ?></div>
                    </div>
                    
                    <!-- Título principal -->
                    <div class="title"><?= $certificado->tipo === 'diplomado' ? 'DIPLOMADO' : 'CERTIFICADO' ?></div>                
                    <!-- OTORGADO A -->
                    <div class="otorgado">OTORGADO A:</div>
                    
                    <!-- Nombre del estudiante -->
                    <div class="nombre">
                        <?php if ($certificado->user): ?>
                            <?= strtoupper(h($certificado->user->nombres)) ?>
                        <?php else: ?>
                            <?= strtoupper(h($certificado->nombre_titular)) ?>
                        <?php endif; ?>
                    </div>
                    
                    <div style="font-size: 10pt; margin: 3mm 0;">
                        Por haber concluido satisfactoriamente el curso:
                    </div>
                    
                    <!-- Nombre del curso -->
                    <div class="curso-nombre">
                        <?php if ($certificado->curso): ?>
                            <?= strtoupper(h($certificado->curso->titulo)) ?>
                        <?php elseif ($certificado->nombre_curso_manual): ?>
                            <?= strtoupper(h($certificado->nombre_curso_manual)) ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Firma y Texto lado a lado -->
                    <div class="firma-texto-container">
                        <!-- Firma y sello - izquierda -->
                        <div class="firma-section" style="text-align: center;">
                            <img src="<?= h($firmaUrl) ?>"
                                alt="Firma del gerente"
                                class="firma-img"
                                style="display: block; margin: 0 auto 2px;">

                            <div class="firma-text" style="border-top: 1px dotted #000; padding-top: 4px;">
                                <span style="
                                    display: block;
                                    font-size: 8pt;
                                    font-weight: 600;
                                    line-height: 1;
                                    text-transform: uppercase;
                                    max-width: 50mm;
                                    margin: 0 auto;
                                ">
                                    <?= h($certificado->nombre_gerente) ?>
                                </span>

                                <span style="
                                    display: block;
                                    font-size: 8pt;
                                    font-weight: 600;
                                    line-height: 1;
                                    text-transform: uppercase;
                                "> 
                                    CENTRO INTEGRAL DE FORMACIÓN Y ASESORÍA ACADÉMICA
                                </span>
                            </div>
                        </div>


                        
                        <!-- Texto del cuerpo - derecha -->
                        <div class="texto">
                            Habiendo completado y aprobado satisfactoriamente todas las evaluaciones, 
                            trabajos y proyectos requeridos durante el período comprendido entre el 
                            
                                <?= $certificado->fecha_inicio->i18nFormat("dd 'de' MMMM 'de' yyyy", 'es_PE') ?>
                            
                            y el 
                            
                                <?= $certificado->fecha_fin->i18nFormat("dd 'de' MMMM 'de' yyyy", 'es_PE') ?>
                            
                            con un total de 
                            <?= !empty($certificado->horas_lectivas) ? (int)$certificado->horas_lectivas : '240' ?> horas lectivas, 
                            en el <strong>Centro Integral de Formación y Asesoría Académica – CIFAA</strong>.
                        </div>


                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- PÁGINA 2: MÓDULOS -->
<div class="page2">
<div class="certificate">
    
        <!-- Decoraciones en esquinas -->
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>
        
       
            <!-- Marca de agua -->
            <div class="watermark">CIFAA</div>
            
            <div class="content">
                <!-- Logo CIFAA -->
                <?php if (!empty($logoUrl)): ?>
                    <img src="<?= $logoUrl ?>" alt="Logo CIFAA" class="logo">
                <?php endif; ?>
                
                <!-- Título -->
                <div class="modulos-title">
                    <?php if ($certificado->tipo === 'diplomado'): ?>
                        DIPLOMADO EN <?= strtoupper(h($certificado->curso ? $certificado->curso->titulo : $certificado->nombre_curso_manual)) ?>
                    <?php else: ?>
                        CERTIFICADO EN <?= strtoupper(h($certificado->curso ? $certificado->curso->titulo : $certificado->nombre_curso_manual)) ?>
                    <?php endif; ?>
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
                        <?php if (!empty($certificado->certificado_modulos)): ?>
                            <?php foreach ($certificado->certificado_modulos as $index => $modulo): ?>
                                <tr>
                                    <td><?= h($index + 1) ?></td>
                                    <td><?= h($modulo->titulo) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No hay módulos asociados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <!-- Footer con información adicional -->
                <div class="page2-footer">
                    <div style="margin-bottom: 3mm; font-size: 9pt; text-align: left; padding: 0 20mm;">
                        <strong>CÓDIGO DEL CERTIFICADO:</strong> <?= h($certificado->codigo) ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>DURACIÓN:</strong> <?= !empty($certificado->duracion_meses) ? h($certificado->duracion_meses) . ' MESES' : 'N/A' ?>
                        <br>
                        <strong>NOTA FINAL:</strong> <?= !empty($certificado->nota_final) ? h($certificado->nota_final) : 'N/A' ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>HORAS LECTIVAS:</strong> <?= !empty($certificado->horas_lectivas) ? h($certificado->horas_lectivas) : 'N/A' ?>
                    </div>
                    
                    <div style="margin-top: 5mm;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?= urlencode('http://localhost/cifaa/cifaa/verificar-certificado?codigo=' . $certificado->codigo) ?>" 
                             alt="QR Verificación" class="qr-code">
                    </div>
                    
                    <div class="contact-footer">
                        <strong>+51 901 562 110</strong> &nbsp;&nbsp;&nbsp;&nbsp; 
                        Centro Integral de Formación y Asesoría Académica - CIFAA
                    </div>
                </div>
            </div>
        
    
</div>
</div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        @page {
            margin: 15mm;
            size: A4 landscape;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .certificate-border {
            border: 10px solid #17a2b8;
            padding: 30px;
            text-align: center;
            page-break-after: avoid;
        }
        .logo-header {
            margin-bottom: 15px;
        }
        .logo-header img {
            width: 120px;
            height: auto;
        }
        .institution-name {
            font-size: 12px;
            color: #17a2b8;
            font-weight: bold;
            margin-top: 5px;
        }
        h1 {
            font-size: 32px;
            color: #17a2b8;
            margin: 12px 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 15px;
            color: #555;
            margin-bottom: 15px;
            font-style: italic;
        }
        .student-name {
            font-weight: bold;
            font-size: 24px;
            color: #000;
            text-transform: uppercase;
            margin: 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #17a2b8;
            display: inline-block;
        }
        .content {
            font-size: 14px;
            line-height: 1.5;
            margin: 15px 0;
        }
        .course-title {
            font-weight: bold;
            font-size: 16px;
            color: #17a2b8;
            margin: 8px 0;
        }
        .hours {
            font-weight: bold;
        }
        .location-date {
            font-size: 14px;
            margin: 15px 0;
            font-style: italic;
        }
        .signature-section {
            margin-top: 25px;
        }
        .signature-img {
            width: auto;
            height: 50px;
        }
        .signature-line {
            width: 280px;
            border-top: 1px solid #333;
            margin: 5px auto;
            padding-top: 5px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 13px;
            margin-top: 3px;
        }
        .signature-title {
            font-size: 11px;
            color: #666;
            margin-top: 2px;
        }
        .verification-code {
            font-size: 9px;
            margin-top: 15px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="certificate-border">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td align="center">
                    <div class="logo-header">
                        <?php 
                        $logoPath = WWW_ROOT . 'img' . DS . 'logoCifa.png';
                        if (file_exists($logoPath)): 
                        ?>
                            <img src="<?= $logoPath ?>" alt="Logo CIFAA">
                        <?php endif; ?>
                        <div class="institution-name">CENTRO INTEGRAL DE FORMACIÓN Y ASESORÍA ACADÉMICA - CIFAA</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <h1>Certificado de Participación</h1>
                    <p class="subtitle">Otorgado a:</p>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="student-name"><?= strtoupper(h($certificado->user->username)) ?></div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="content">
                        Por haber completado satisfactoriamente el curso:
                        <div class="course-title">"<?= h($certificado->curso->titulo) ?>"</div>
                        Con una duración de <span class="hours"><?= h($certificado->horas) ?> horas académicas</span>.<br>
                        Para que conste y sea reconocido, como aprobado.
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="location-date">
                        Arequipa, <?= h($certificado->fecha_emision->format('d')) ?> de <?= h($certificado->fecha_emision->format('F')) ?> del <?= h($certificado->fecha_emision->format('Y')) ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="signature-section">
                        <?php 
                        $firmaPath = WWW_ROOT . 'img' . DS . 'firma.png';
                        if (file_exists($firmaPath)): 
                        ?>
                            <img src="<?= $firmaPath ?>" class="signature-img" alt="Firma">
                        <?php endif; ?>
                        <div class="signature-line">
                            <div class="signature-name">Dirección Académica</div>
                            <div class="signature-title">Centro Integral de Formación y Asesoría Académica - CIFAA</div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="verification-code">Código de Verificación: <?= h($certificado->codigo) ?></div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

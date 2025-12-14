<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado</title>
    <style>
        @page { margin: 0; size: A4 landscape; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { width: 297mm; height: 210mm; margin: 0; padding: 0; font-family: Arial, sans-serif; color: #333; overflow: hidden; }
        .certificate { position: absolute; top: 0; left: 0; width: 297mm; height: 210mm; border: 8mm solid #17a2b8; }
        .border-inner { position: absolute; top: 8mm; left: 8mm; right: 8mm; bottom: 8mm; border: 2mm solid #ffa500; padding: 12mm; }
        .content { text-align: center; }
        .logo { width: 30mm; height: auto; margin-bottom: 2mm; }
        .subtitle { font-size: 8pt; color: #17a2b8; font-weight: bold; margin-bottom: 2mm; text-transform: uppercase; }
        .title { font-size: 26pt; font-weight: bold; color: #17a2b8; margin: 2mm 0; text-transform: uppercase; letter-spacing: 2px; }
        .otorgado { font-size: 10pt; color: #666; font-style: italic; margin: 4mm 0 2mm 0; }
        .nombre { font-size: 22pt; font-weight: bold; color: #000; margin: 4mm 0; text-transform: uppercase; border-bottom: 2px solid #17a2b8; display: inline-block; padding: 1mm 12mm; }
        .texto { font-size: 10pt; line-height: 1.5; margin: 4mm 15mm; }
        .curso-nombre { font-weight: bold; color: #17a2b8; }
        .fecha { font-size: 9pt; margin: 4mm 0; font-style: italic; color: #555; }
        .footer { margin-top: 6mm; }
        .firma { width: 35mm; height: auto; margin: 2mm auto; display: block; }
        .firma-nombre { font-size: 9pt; font-weight: bold; margin-top: 1mm; }
        .firma-cargo { font-size: 8pt; color: #666; margin-top: 0.5mm; }
        .codigo { font-size: 7pt; color: #999; margin-top: 4mm; }
    </style>
</head>
<body>
<div class="certificate">
<div class="border-inner">
<div class="content">
<?php if (!empty($logoBase64)): ?><img src="<?= $logoBase64 ?>" alt="Logo CIFAA" class="logo"><?php endif; ?>
<div class="subtitle">Centro Integral de Formación y Asesoría Académica - CIFAA</div>
<div class="title">Certificado de Participación</div>
<div class="otorgado">Otorgado a:</div>
<div class="nombre"><?= strtoupper(h($certificado->user->username)) ?></div>
<div class="texto">Por haber completado satisfactoriamente el curso <span class="curso-nombre">"<?= h($certificado->curso->titulo) ?>"</span> con una duración de <strong><?= h($certificado->horas) ?> horas académicas</strong>. Para que conste y sea reconocido, como aprobado.</div>
<div class="fecha">Arequipa, <?= h($certificado->fecha_emision->format('d')) ?> de <?= h($certificado->fecha_emision->format('F')) ?> del <?= h($certificado->fecha_emision->format('Y')) ?></div>
<div class="footer">
<?php if (!empty($firmaBase64)): ?><img src="<?= $firmaBase64 ?>" alt="Firma" class="firma"><?php endif; ?>
<div class="firma-nombre">Dirección Académica</div>
<div class="firma-cargo">Centro Integral de Formación y Asesoría Académica - CIFAA</div>
</div>
<div class="codigo">Código de Verificación: <?= h($certificado->codigo) ?></div>
</div>
</div>
</div>
</body>
</html>

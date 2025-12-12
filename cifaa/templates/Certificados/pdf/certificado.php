<!DOCTYPE html>
<html>
<head>
    <title>Certificado</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            text-align: center;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 50px;
            border: 20px solid #17a2b8; /* Borde estilo CIFA */
        }
        .container {
            padding: 40px;
        }
        .logo {
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 200px;
        }
        h1 {
            font-size: 48px;
            color: #17a2b8;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 18px;
            color: #555;
            margin-bottom: 50px;
        }
        .content {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 60px;
        }
        .highlight {
            font-weight: bold;
            font-size: 28px;
            color: #000;
            border-bottom: 1px solid #999;
            padding: 0 10px;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }
        .signature {
            border-top: 1px solid #333;
            width: 300px;
            margin: 0 auto;
            padding-top: 10px;
        }
        .signature-img {
            max-height: 100px;
            margin-bottom: -15px; /* Overlap with line slightly */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <!-- Ensure images exist in webroot/img/ -->
            <img src="<?= WWW_ROOT ?>img/logoCifa.png" alt="Logo CIFA">
        </div>

        <h1>Certificado de Finalización</h1>
        <p class="subtitle">Este documento certifica que</p>

        <div class="content">
            <span class="highlight"><?= h($certificado->user->username) ?></span><br><br>
            
            ha completado satisfactoriamente el curso de <br><br>
            
            <span class="highlight"><?= h($certificado->curso->titulo) ?></span><br><br>
            
            con una duración de <strong><?= h($certificado->horas) ?> horas académicas</strong>.<br><br>
            
            Dado el <?= h($certificado->fecha_emision->format('d/m/Y')) ?>.
        </div>

        <div class="footer">
            <div style="text-align: center;">
                <?php if (file_exists(WWW_ROOT . 'img/firma.png')): ?>
                    <img src="<?= WWW_ROOT ?>img/firma.png" class="signature-img" alt="Firma"><br>
                <?php endif; ?>
                <div class="signature">
                    <strong>Firma Autorizada</strong><br>
                    Director Académico
                </div>
            </div>
        </div>
        
        <div style="font-size: 10px; margin-top: 50px; color: #999;">
            Código de Verificación: <?= h($certificado->codigo) ?>
        </div>
    </div>
</body>
</html>

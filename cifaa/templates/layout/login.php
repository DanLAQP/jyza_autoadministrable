<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('Iniciar Sesión') ?></title>
    <!-- Bootstrap 5 -->
    <link rel="icon" type="image/png" href="iconoCifa.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color:  #2b2f36;
        }
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 100vh;
        }
        .login-left {
            background-color: #23272b;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50%;
        }
        .login-left img {
            max-width: 60%;
        }
        .login-right {
            width: 50%;
            background-color: #343a40;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Panel Izquierdo con Logo -->
        <div class="login-left">
            <img src="<?= $this->Url->image('LogoLogin.png') ?>" alt="Logo Clínica">
        </div>

        <!-- Panel Derecho con Formulario -->
        <div class="login-right">
            <?= $this->fetch('content') ?>
        </div>
    </div>
</body>
</html>

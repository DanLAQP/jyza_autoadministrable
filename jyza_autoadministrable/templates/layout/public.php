<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verificar Certificado | SemzoDerm</title>
  <?= $this->Html->meta('icon', 'iconoSemzo.png', ['type' => 'icon']) ?>
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= $this->Url->assetUrl('plugins/fontawesome-free/css/all.min.css') ?>">
  
  <!-- Bootstrap 5 -->
  <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css?v=' . time()) ?>
  
  <!-- Custom CSS -->
  <?= $this->Html->css('domestika-style') ?>
  <?= $this->fetch('css') ?>
  
  <style>
    :root {
      --primary-color: #4a90e2;
      --primary-dark: #357abd;
      --dark-bg: #1a1f28;
      --card-bg: #242933;
      --border-color: #3a4352;
      --text-primary: #ffffff;
      --text-secondary: #b8c5d0;
    }

    body {
      background: linear-gradient(135deg, #1a1f28 0%, #242933 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    
    /* Navbar Mejorado */
    .navbar-custom {
      background: rgba(26, 31, 40, 0.98);
      backdrop-filter: blur(10px);
      border-bottom: 2px solid var(--primary-color);
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
      padding: 0.75rem 0;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      font-weight: 600;
      color: var(--text-primary) !important;
      font-size: 1.35rem;
      transition: all 0.3s ease;
      padding: 0.5rem 0;
    }

    .navbar-brand:hover {
      color: var(--primary-color) !important;
      transform: translateX(3px);
    }

    .navbar-brand i {
      color: var(--primary-color);
      font-size: 1.5rem;
      transition: all 0.3s ease;
    }

    .navbar-brand:hover i {
      transform: rotate(15deg);
    }

    .navbar-text {
      color: var(--text-secondary) !important;
      font-size: 0.95rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      padding-left: 1.5rem;
      border-left: 2px solid var(--border-color);
    }

    .navbar-text i {
      margin-right: 0.5rem;
      color: var(--primary-color);
    }

    /* Main Content */
    main {
      flex: 1;
      margin-top: 0;
      margin-bottom: 0;
    }

    /* Footer Mejorado */
    footer {
      background: rgba(26, 31, 40, 0.98);
      backdrop-filter: blur(10px);
      border-top: 2px solid var(--border-color);
      box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.3);
      padding: 1.5rem 0;
      margin-top: auto;
    }

    footer p {
      color: var(--text-secondary);
      margin: 0;
      font-size: 0.875rem;
      line-height: 1.6;
    }

    footer .footer-brand {
      color: var(--primary-color);
      font-weight: 600;
    }

    footer .footer-divider {
      display: inline-block;
      margin: 0 0.5rem;
      color: var(--border-color);
    }

    /* Flash Messages */
    .flash-message {
      animation: slideInDown 0.5s ease-out;
    }

    @keyframes slideInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .navbar-text {
        display: none;
      }

      .navbar-brand {
        font-size: 1.2rem;
      }

      .navbar-brand i {
        font-size: 1.3rem;
      }

      footer p {
        font-size: 0.8rem;
      }
    }

    @media (max-width: 576px) {
      .navbar-custom {
        padding: 0.5rem 0;
      }

      footer {
        padding: 1rem 0;
      }

      .footer-divider {
        display: block;
        margin: 0.25rem 0;
      }
    }

    /* Animaciones suaves */
    * {
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-custom navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid px-4">
      <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">
        <i class="fas fa-certificate me-2"></i>
        SemzoDerm
      </a>
      <span class="navbar-text d-none d-md-flex">
        <i class="fas fa-shield-check"></i>
        Verificación de Certificados
      </span>
    </div>
  </nav>

  <!-- Contenido Principal -->
  <main>
    <div class="flash-message">
      <?= $this->Flash->render() ?>
    </div>
    <?= $this->fetch('content') ?>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <p>
            &copy; <?= date('Y') ?> 
            <span class="footer-brand">Ginecologia</span>
            <span class="footer-divider">•</span>
            Ginecologia Jyza 
            <span class="footer-divider">•</span> RUC: 20611567783
            
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js?v=' . time()) ?>
  <?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js?v=' . time()) ?>
  <?= $this->fetch('script') ?>
</body>
</html>
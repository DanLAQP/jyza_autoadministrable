<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Odontocenter HAP | <?= $this->fetch('title') ?></title>
  <?= $this->Html->meta('icon', 'dientito.png', ['type' => 'icon']) ?>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="<?= $this->Url->assetUrl('plugins/fontawesome-free/css/all.min.css') ?>">

<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?= $this->Url->assetUrl('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">

<!-- Theme style -->
<link rel="stylesheet" href="<?= $this->Url->assetUrl('dist/css/adminlte.min.css') ?>">


<!-- Carga general de jquery, bootstap -->

<?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js?v=' . time()) ?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js?v=' . time()) ?>
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css?v=' . time()) ?>
<!-- CakePHP custom CSS -->
<?= $this->fetch('css') ?>

  
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Dropdown Usuario -->
    <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="userDropdownToggle" role="button">
            <i class="fas fa-user"></i> <?= !empty($usuario['username']) ? $usuario['username'] : 'Usuario' ?>
        </a>
        <!-- Contenedor del menú flotante con solo la opción de Salir -->
        <div id="userDropdownBlock" class="dropdown-menu dropdown-menu-end text-white bg-dark shadow"
             style="display: none; font-size: 0.01rem;">
            <div class="dropdown-divider bg-secondary"></div>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" 
               class="dropdown-item text-ligth" style="font-size: 0.85rem;">
                <i class="fas fa-sign-out-alt" style="font-size: 0.95rem;"></i> Salir
            </a>
        </div>
    </li>
</ul>



</nav>

<!-- Script para manejar el dropdown manualmente -->
<!-- Script para manejar el dropdown manualmente -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userDropdownToggle = document.getElementById("userDropdownToggle");
        const userDropdownBlock = document.getElementById("userDropdownBlock");

        userDropdownToggle.addEventListener("click", function (event) {
            event.preventDefault();
            userDropdownBlock.style.display = (userDropdownBlock.style.display === "none") ? "block" : "none";
        });

        // Cierra el menú al hacer clic fuera de él
        document.addEventListener("click", function (event) {
            if (!userDropdownBlock.contains(event.target) && !userDropdownToggle.contains(event.target)) {
                userDropdownBlock.style.display = "none";
            }
        });
    });
</script>



  <!-- /.navbar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'home']) ?>" class="brand-link">
    <img src="<?= $this->Url->image('iconoSD.png') ?>" alt="SpazioDentale Logo" class="brand-image img-circle elevation-3" style="opacity: .8; max-height: 40px;">
    <p class=" font-weight-light nav-icon" style="margin-left: 8px; display: inline-block;">Odontocenter HAP</p>
</a>




    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Custom Navigation Items -->
            
                <?php if (in_array($usuario->rol, [1, 2, 3, 4])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Pacientes1', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Pacientes</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Tratamientos', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-stethoscope nav-icon"></i>
                        <p>Tratamientos</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build('/citas-diarias') ?>" class="nav-link">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <p>Citas del Día</p>
                    </a>
                </li>
                
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'horariosDoctores', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <p>horarios</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Campañas', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-file-invoice-dollar nav-icon"></i>
                        <p>Campañas</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Citas', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <p>Citas</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Presupuestos', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-file-invoice-dollar nav-icon"></i>
                        <p>Presupuestos</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'registrosConsultas', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-notes-medical nav-icon"></i>
                        <p>Consultas</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Ordenes', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-notes-medical nav-icon"></i>
                        <p>Ordenes</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Odontograma', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-tooth nav-icon"></i>
                        <p>Odontograma</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2, 3])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'ArchivosPacientes', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-cloud-upload-alt nav-icon"></i>
                        <p>Subida de imágenes</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Doctores', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-user-md nav-icon"></i>
                        <p>Doctores</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Egresos', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-money-bill-wave nav-icon"></i>
                        <p>Egresos</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'ReportesPacientes', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <p>Reportes Presupuestos</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'ReportesTratamientos', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>Reportes Consultas</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'ReportesOrdenes', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>Reportes Ordenes</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Citas', 'action' => 'reportecitas']) ?>" class="nav-link">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Reporte de Citas</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1, 2])): ?>
                <!-- para el inventario -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Inventarios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Productos', 'action' => 'index']) ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Categorias', 'action' => 'index']) ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categorías</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Proveedores', 'action' => 'index']) ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Transacciones', 'action' => 'index']) ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transacciones</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php if (in_array($usuario->rol, [1])): ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="nav-link">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $this->fetch('title') ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?= $this->fetch('breadcrumb') ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    <!-- /.content-header -->

    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= $this->fetch('content') ?>
    </div>
</section>
<!-- /.content -->
 <!-- Estilos CSS adicionales -->
<style>
    .table{
        border-radius: 10px;
    }
    .table th, .table td {
        white-space: nowrap;
    }
    
    thead th a {
        color: white !important;
        text-decoration: none;
    }

    .actions .skiti {
        visibility: visible !important;
        font-size: 16px;
        padding: 5px;
        color: #fff;
       
        
    }

    /* Estilo para la columna de acciones */
    .table .actions {
        position: sticky;
        right: 0;
        background-color: #343a40;;
        color: white !important;
        text-align: center;
        z-index: 10;
    } 
    .custom-hover:hover {
        background-color: #6c757d !important;
        color: white !important;
        cursor:pointer;
    }
</style>
<!-- aqui plantillas de modales -->
<!-- Modal Pequeño -->
<div class="modal fade" id="modalSm" tabindex="-1" role="dialog" aria-labelledby="modalLabelSm" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalLabelLg">
                <img src="<?= $this->Url->image('iconoSD.png') ?>" alt="Logo Clínica" style="max-height: 50px;">
            </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContentSm"></div> <!-- Contenedor para contenido dinámico -->
            </div>
            </div>
        </div>
        </div>

        <!-- Modal Mediano -->
        <div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="modalLabelMd" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalLabelLg">
                <img src="<?= $this->Url->image('iconoSD.png') ?>" alt="Logo Clínica" style="max-height: 50px;">
            </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContentMd"></div> <!-- Contenedor para contenido dinámico -->
            </div>
            </div>
        </div>
        </div>

        <!-- Modal Grande -->
        <div class="modal fade" id="modalLg" tabindex="-1" role="dialog" aria-labelledby="modalLabelLg" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalLabelLg">
                <img src="<?= $this->Url->image('iconoSD.png') ?>" alt="Logo Clínica" style="max-height: 50px;">
            </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContentLg"></div> <!-- Contenedor para contenido dinámico -->
            </div>
            </div>
        </div>
        </div>

        <!-- Modal Extra Grande -->
        <div class="modal fade" id="modalXl" tabindex="-1" role="dialog" aria-labelledby="modalLabelXl" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelLg">
                    <img src="<?= $this->Url->image('iconoSD.png') ?>" alt="Logo Clínica" style="max-height: 50px;">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContentXl"></div> <!-- Contenedor para contenido dinámico -->
            </div>
            </div>
        </div>
        </div>
        <script>
        $(document).ready(function() {
    // Modal pequeño
    $('.openModalSm').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(response) {
                $('#modalContentSm').html(response);
                $('#modalSm').modal('show');
            },
            error: function() {
                alert('Error al cargar el contenido para el modal pequeño.');
            }
        });
    });

    // Modal mediano
    $('.openModalMd').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(response) {
                $('#modalContentMd').html(response);
                $('#modalMd').modal('show');
            },
            error: function() {
                alert('Error al cargar el contenido para el modal mediano.');
            }
        });
    });

    // Modal grande (openModal)
    $('.openModal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(response) {
                $('#modalContentLg').html(response);
                $('#modalLg').modal('show');
                initializePacienteSearch(); // Inicializar el buscador
            },
            error: function() {
                alert('Error al cargar el contenido para el modal grande.');
            }
        });
    });



    // Modal extra grande
    $('.openModalXl').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(response) {
                $('#modalContentXl').html(response);
                $('#modalXl').modal('show');
            },
            error: function() {
                alert('Error al cargar el contenido para el modal extra grande.');
            }
        });
    });
});


    </script>
 <script>
    // Inicializa el buscador de pacientes
    function initializePacienteSearch() {
        const basePath = "<?= $this->Url->build('/', ['fullBase' => true]) ?>"; // URL base completa
        const searchInput = document.getElementById('searchPaciente');
        const searchButton = document.getElementById('searchButton');
        const resultsContainer = document.getElementById('pacienteResults');
        const pacienteIdField = document.getElementById('pacienteId');
        const submitButton = document.getElementById('submitButton');

        // Verificar que los elementos del buscador existan
        if (!searchInput || !searchButton || !resultsContainer || !pacienteIdField) {
            return;
        }

        // Manejar el botón "Buscar"
        searchButton.addEventListener('click', function () {
            const query = searchInput.value.trim();
            if (query.length < 2) {
                resultsContainer.innerHTML = '<div class="list-group-item text-danger">Por favor, ingrese al menos 2 caracteres.</div>';
                return;
            }

            // Realizar la solicitud AJAX para buscar pacientes
            fetch(`${basePath}pacientes1/buscarPaciente?q=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    resultsContainer.innerHTML = ''; // Limpiar resultados previos

                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div class="list-group-item">No se encontraron resultados</div>';
                        return;
                    }

                    // Mostrar resultados
                    data.forEach(paciente => {
                        const item = document.createElement('div');
                        item.className = 'list-group-item list-group-item-action bg-dark text-white border-light custom-hover';
                        item.textContent = paciente.nombre;
                        item.dataset.id = paciente.id; // Guardar ID en data-id

                        // Evento para seleccionar un paciente
                        item.addEventListener('click', function () {
                            searchInput.value = paciente.nombre; // Mostrar nombre seleccionado
                            pacienteIdField.value = paciente.id; // Guardar ID seleccionado
                            resultsContainer.innerHTML = ''; // Limpiar resultados

                            // Validar formulario inmediatamente después de seleccionar un paciente
                            validateForm();
                        });

                        resultsContainer.appendChild(item);
                    });
                })
                .catch(error => {
                    
                    resultsContainer.innerHTML = '<div class="list-group-item text-danger">Error al buscar pacientes</div>';
                });
        });
    }

    // ✅ Mover `validateForm()` al ámbito global
    function validateForm() {
        const pacienteIdField = document.getElementById('pacienteId');
        const submitButton = document.getElementById('submitButton');

        if (!pacienteIdField || !submitButton) {
            
            return;
        }

        submitButton.disabled = pacienteIdField.value.trim() === '';
        
    }

    // Inicializa la validación del formulario
    function initializeFormValidation() {
        const pacienteIdField = document.getElementById('pacienteId');

        // Escuchar cambios en el campo de pacienteId
        pacienteIdField.addEventListener('input', validateForm);

        // Validar el formulario al cargar la página o modal
        validateForm();
    }

    // Inicializar las funcionalidades al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        initializePacienteSearch();
        initializeFormValidation();
    });

    // Reutilizar la inicialización para modales cargados dinámicamente
    $(document).on('shown.bs.modal', '#modalLg', function () {
        initializePacienteSearch();
        initializeFormValidation();
    });

    // Asegurar que la validación también se ejecute tras AJAX
    $(document).on('ajaxComplete', function () {
        console.log("AJAX detectado, reinicializando validación y búsqueda.");
        initializePacienteSearch();
        initializeFormValidation();
    });
</script>




  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong >Dan_L_AQP 2025</strong>
    Historia Clinica
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= $this->Url->assetUrl('plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap -->
<script src="<?= $this->Url->assetUrl('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= $this->Url->assetUrl('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= $this->Url->assetUrl('dist/js/adminlte.js') ?>"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= $this->Url->assetUrl('plugins/jquery-mousewheel/jquery.mousewheel.js') ?>"></script>
<script src="<?= $this->Url->assetUrl('plugins/raphael/raphael.min.js') ?>"></script>
<script src="<?= $this->Url->assetUrl('plugins/jquery-mapael/jquery.mapael.min.js') ?>"></script>
<script src="<?= $this->Url->assetUrl('plugins/jquery-mapael/maps/usa_states.min.js') ?>"></script>
<!-- ChartJS -->
<script src="<?= $this->Url->assetUrl('plugins/chart.js/Chart.min.js') ?>"></script>

<!-- Additional Scripts -->

<!-- Demo Scripts (optional) -->
<script src="<?= $this->Url->assetUrl('dist/js/demo.js') ?>"></script>
<?php if ($this->fetch('title') === 'Dashboard') : ?>
    <script src="<?= $this->Url->assetUrl('dist/js/pages/dashboard2.js') ?>"></script>
<?php endif; ?>



</body>
</html>
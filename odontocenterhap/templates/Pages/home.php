<?php $this->assign('title', 'Página principal'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tratamientos</title>
    <!-- Cargar Bootstrap -->
    
</head>
<body class="bg-dark text-white">
    <div class="container mt-4">
        <div class="row">
            <!-- Cumpleaños Hoy Card -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        🎉 Cumpleaños Hoy
                    </div>
                    <div class="card-body">
                        <?php if (!empty($cumpleanosHoy) && !$cumpleanosHoy->isEmpty()): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($cumpleanosHoy as $paciente): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= h($paciente->pacientes1->nombre) ?> <?= h($paciente->pacientes1->apellido) ?>
                                        <?php if (!empty($paciente->pacientes1->telefono_celular)): ?>
                                            <?php 
    $telefono_celular = $paciente->pacientes1->telefono_celular ?? '';
    $telefono = preg_replace('/[^0-9]/', '', $telefono_celular);
    $telefono = strpos($telefono, '51') === 0 ? substr($telefono, 2) : $telefono;
?>
                                            <a href="https://wa.me/51<?= $telefono ?>?text=Hola%20<?= urlencode($paciente->nombre ?? '') ?>,%20la%20cl%C3%ADnica%20dental%20Hap%20te%20desea%20un%20feliz%20cumplea%C3%B1os." 
   class="btn btn-success btn-sm"
   target="_blank" rel="noopener noreferrer">
   <i class="fab fa-whatsapp"></i> Felicitar
</a>
                                        <?php else: ?>
                                            <span class="btn btn-secondary btn-sm">
                                                <i class="fas fa-exclamation-circle"></i> Sin número
                                            </span>
                                        <?php endif; ?>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-center">No hay cumpleaños hoy</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recordatorio de Profilaxis Card -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        🦷 Recordatorio de Profilaxis
                    </div>
                    <div class="card-body">
                        <?php if (!empty($profilaxisPendientes) && !$profilaxisPendientes->isEmpty()): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($profilaxisPendientes as $paciente): 
                                    $antecedentes = $paciente->_matchingData['AntecedentesOdontologicos'];
                                    $fechaProxima = $antecedentes->fecha_ultima_profilaxis->addMonths(6);
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= h($paciente->nombre) ?> <?= h($paciente->apellido) ?>
                                        <span class="fecha-recordatorio">
                                            Última profilaxis: <?= $antecedentes->fecha_ultima_profilaxis->format('d/m/Y') ?>
                                        </span>
                                        <span class="fecha-proxima">
                                            Vence: <?= $fechaProxima->format('d/m/Y') ?>
                                        </span>
                                        <?php if (!empty($paciente->pacientes1->telefono_celular)): ?>
                                        <?php 
                                        $telefono = preg_replace('/[^0-9]/', '', $paciente->pacientes1->telefono_celular);
                                        $telefono = strpos($telefono, '51') === 0 ? substr($telefono, 2) : $telefono;
                                    ?>
                                            <a href="https://wa.me/51<?= $telefono ?>?text=Hola%20<?= urlencode($paciente->nombre ?? '') ?>,%20la%20cl%C3%ADnica%20dental%20Spaziodentale%20le%20recuerda%20que%20ya%20pasaron%206%20meses%20desde%20su%20%C3%BAltima%20profilaxis,%20le%20recomendamos%20visitarnos."
   class="btn btn-success btn-sm" target="_blank">
   <i class="fab fa-whatsapp"></i> Recordar
</a>
                                        <?php else: ?>
                                            <span class="btn btn-secondary btn-sm">
                                                <i class="fas fa-exclamation-circle"></i> Sin número
                                            </span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-center">No hay recordatorios activos</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <!-- Citas del Día Card -->
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        📅 Citas del Día
                    </div>
                    <div class="card-body text-center">
                        <h1><?= $citasDelDia ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Citas de los Últimos 7 Días -->
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        📈 Citas Asistidas en los Últimos 7 Días
                    </div>
                    <div class="card-body">
                        <canvas id="graficoCitasDia" width="400" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Estados de Citas -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        📊 Citas por estado de los Últimos 7 Días
                    </div>
                    <div class="card-body">
                        <canvas id="graficoEstados" width="400" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        🦷 Tratamientos Más Realizados (Últimos 7 Días)
                    </div>
                    <div class="card-body">
                        <canvas id="graficoTratamientos" width="400" height="250"></canvas>
                    </div>
                </div>
            </div>
            <!-- Gráfico de Doctores con más consultas -->
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">
                        👨‍⚕️ Doctores con más consultas (Últimos 7 Días)
                    </div>
                    <div class="card-body">
                        <canvas id="graficoDoctores" width="400" height="250"></canvas>
                    </div>
                </div>
            </div>            
        </div>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos del gráfico de citas del día
    var dias = <?= json_encode($dias) ?>;
    var citadosData = <?= json_encode($datosEstado['finalizado'] ?? []) ?>;

    var ctx = document.getElementById('graficoCitasDia').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dias,
            datasets: [{
                label: 'Citas del Día',
                data: citadosData,
                fill: false,
                borderColor: 'rgba(54, 162, 235, 1)', 
                tension: 0.1,
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: 'white',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // ==========================
    // Gráfico de barras de estado de las citas (dinámico con colores)
    // ==========================
    var estados = <?= json_encode(array_keys($datosEstado)) ?>;
    var datosEstado = <?= json_encode($datosEstado) ?>;

    // Paleta de colores (11 colores, se repiten si hay más estados)
    var colores = [
        '#36A2EB', // Azul
        '#4BC0C0', // Verde agua
        '#FF6384', // Rojo rosado
        '#FF9F40', // Naranja
        '#9966FF', // Morado
        '#FFCD56', // Amarillo
        '#2ECC71', // Verde esmeralda
        '#E74C3C', // Rojo intenso
        '#3498DB', // Azul claro
        '#F39C12', // Naranja oscuro
        '#8E44AD'  // Púrpura oscuro
    ];

    var datasetsEstados = estados.map(function(estado, index) {
        var color = colores[index % colores.length]; // ciclo colores si hay más estados
        return {
            label: estado,
            data: datosEstado[estado],
            backgroundColor: color + "B3", // mismo color con opacidad
            borderColor: color,
            borderWidth: 1
        };
    });

    var ctx2 = document.getElementById('graficoEstados').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: dias,
            datasets: datasetsEstados
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

        var tratamientos = <?= json_encode(array_keys($tratamientosMasRealizados ?? [])) ?>;
    var cantidades = <?= json_encode(array_values($tratamientosMasRealizados ?? [])) ?>;

    var ctx3 = document.getElementById('graficoTratamientos').getContext('2d');
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: tratamientos,
            datasets: [{
                label: 'Cantidad de Tratamientos',
                data: cantidades,
                backgroundColor: 'rgba(37, 185, 45, 0.7)',
                borderColor: 'rgba(37, 185, 45, 0.7)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    suggestedMin: 0,
                    ticks: { 
                        stepSize: 1, 
                        precision: 0 
                    } 
                }
            }
        }
    });
    var doctores = <?= json_encode(array_keys($doctoresArray ?? [])) ?>;
    var consultas = <?= json_encode(array_values($doctoresArray ?? [])) ?>;

    var ctx4 = document.getElementById('graficoDoctores').getContext('2d');
    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: doctores,
            datasets: [{
                label: 'Cantidad de Consultas',
                data: consultas,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    suggestedMin: 0,
                    ticks: { 
                        stepSize: 1, 
                        precision: 0 
                    } 
                }
            }
        }
    });
    </script>
</body>
</html>

<?php $this->assign('title', 'Página principal'); ?>



<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container py-5">
    <div class="row">
        <!-- Gráfico de Certificados -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Certificados Emitidos</h5>
                    <canvas id="certificadosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Diplomados -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Diplomados Emitidos</h5>
                    <canvas id="diplomadosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Usuarios Registrados -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Usuarios Registrados</h5>
                    <canvas id="usuariosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Usuarios Inscritos -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Usuarios Inscritos a Cursos</h5>
                    <canvas id="usuariosInscritosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Inscripciones Pendientes -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Inscripciones Pendientes</h5>
                    <canvas id="inscripcionesPendientesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Curso con más inscripciones -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Curso con Más Inscripciones</h5>
                    <p class="text-center">
                        <strong><?= h($topCurso->titulo) ?></strong> con <?= h($topCurso->total_inscripciones) ?> inscripciones.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Datos dinámicos para los gráficos
    const certificadosData = [<?= $certificadosCount ?>];
    const diplomadosData = [<?= $diplomadosCount ?>];
    const usuariosData = [<?= $usuariosCount ?>];
    const usuariosInscritosData = [<?= $usuariosInscritosCount ?>];
    const inscripcionesPendientesData = [<?= $inscripcionesPendientesCount ?>];

    // Configuración de gráficos
    const config = (label, data, color) => ({
        type: 'bar',
        data: {
            labels: ['Total'],
            datasets: [{
                label: label,
                data: data,
                backgroundColor: color,
                borderColor: color,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: label
                }
            }
        }
    });

    // Inicializar gráficos
    new Chart(document.getElementById('certificadosChart'), config('Certificados Emitidos', certificadosData, 'rgba(75, 192, 192, 0.7)'));
    new Chart(document.getElementById('diplomadosChart'), config('Diplomados Emitidos', diplomadosData, 'rgba(255, 99, 132, 0.7)'));
    new Chart(document.getElementById('usuariosChart'), config('Usuarios Registrados', usuariosData, 'rgba(255, 159, 64, 0.7)'));
    new Chart(document.getElementById('usuariosInscritosChart'), config('Usuarios Inscritos a Cursos', usuariosInscritosData, 'rgba(54, 162, 235, 0.7)'));
    new Chart(document.getElementById('inscripcionesPendientesChart'), config('Inscripciones Pendientes', inscripcionesPendientesData, 'rgba(153, 102, 255, 0.7)'));
</script>

<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inscripcione> $inscripciones
 * @var array $estadisticas
 */
?>
<div class="container mt-4 mb-4">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-info">
                <i class="fas fa-graduation-cap"></i> Mis Inscripciones
            </h2>
            <p class="text-muted">Gestiona tus inscripciones a cursos y revisa tu progreso</p>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total</h6>
                            <h2 class="card-title mb-0"><?= $estadisticas['total'] ?></h2>
                        </div>
                        <i class="fas fa-list-ol fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Aprobadas</h6>
                            <h2 class="card-title mb-0"><?= $estadisticas['aprobadas'] ?></h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Pendientes</h6>
                            <h2 class="card-title mb-0"><?= $estadisticas['pendientes'] ?></h2>
                        </div>
                        <i class="fas fa-hourglass-half fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Progreso Promedio</h6>
                            <h2 class="card-title mb-0"><?= number_format($estadisticas['progreso_promedio'], 1) ?>%</h2>
                        </div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón para nueva inscripción -->
    <div class="row mb-3">
        <div class="col-12">
            <?= $this->Html->link(
                '<i class="fas fa-plus-circle"></i> Solicitar Nueva Inscripción',
                ['controller' => 'Cursos', 'action' => 'student'],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Filtros por estado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group" role="group">
                <?= $this->Html->link(
                    '<i class="fas fa-list"></i> Todas',
                    ['action' => 'misInscripciones'],
                    ['class' => 'btn btn-outline-secondary' . (!$estado ? ' active' : ''), 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-hourglass-half"></i> Pendientes',
                    ['action' => 'misInscripciones', '?' => ['estado' => 'pendiente']],
                    ['class' => 'btn btn-outline-warning' . ($estado === 'pendiente' ? ' active' : ''), 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-check-circle"></i> Aprobadas',
                    ['action' => 'misInscripciones', '?' => ['estado' => 'aprobada']],
                    ['class' => 'btn btn-outline-success' . ($estado === 'aprobada' ? ' active' : ''), 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-times-circle"></i> Rechazadas',
                    ['action' => 'misInscripciones', '?' => ['estado' => 'rechazada']],
                    ['class' => 'btn btn-outline-danger' . ($estado === 'rechazada' ? ' active' : ''), 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- Lista de inscripciones -->
    <?php if (empty($inscripciones->toArray())): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>No tienes inscripciones <?= $estado ? 'en estado "' . ucfirst($estado) . '"' : '' ?></h4>
                    <p>Explora los cursos disponibles y solicita tu inscripción.</p>
                    <?= $this->Html->link(
                        '<i class="fas fa-search"></i> Ver Cursos Disponibles',
                        ['controller' => 'Cursos', 'action' => 'student'],
                        ['class' => 'btn btn-primary mt-2', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($inscripciones as $inscripcione): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 curso-card">
                        <!-- Indicador de estado en la parte superior -->
                        <div class="card-header estado-<?= h($inscripcione->estado) ?>">
                            <?php
                            $estadoBadge = '';
                            $estadoIcon = '';
                            switch ($inscripcione->estado) {
                                case 'aprobada':
                                    $estadoBadge = 'success';
                                    $estadoIcon = 'check-circle';
                                    $estadoTexto = 'Aprobada';
                                    break;
                                case 'pendiente':
                                    $estadoBadge = 'warning';
                                    $estadoIcon = 'hourglass-half';
                                    $estadoTexto = 'Pendiente';
                                    break;
                                case 'rechazada':
                                    $estadoBadge = 'danger';
                                    $estadoIcon = 'times-circle';
                                    $estadoTexto = 'Rechazada';
                                    break;
                            }
                            ?>
                            <span class="badge bg-<?= $estadoBadge ?>">
                                <i class="fas fa-<?= $estadoIcon ?>"></i> <?= $estadoTexto ?>
                            </span>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title text-info">
                                <i class="fas fa-book"></i> 
                                <?= h($inscripcione->curso->titulo) ?>
                            </h5>
                            
                            <!-- Información del curso -->
                            <p class="card-text small text-muted mb-2">
                                <i class="fas fa-calendar-alt"></i> 
                                Inscrito: <?= $inscripcione->created->format('d/m/Y') ?>
                            </p>

                            <?php if ($inscripcione->estado === 'aprobada'): ?>
                                <!-- Barra de progreso solo para aprobadas -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small"><strong>Progreso</strong></span>
                                        <span class="small text-info"><strong><?= $inscripcione->progreso ?>%</strong></span>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-info progress-bar-striped <?= $inscripcione->progreso < 100 ? 'progress-bar-animated' : '' ?>" 
                                             role="progressbar" 
                                             style="width: <?= $inscripcione->progreso ?>%"
                                             aria-valuenow="<?= $inscripcione->progreso ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            <?= $inscripcione->progreso ?>%
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de módulos -->
                                <?php if (!empty($inscripcione->curso->modulos)): ?>
                                    <p class="card-text small">
                                        <i class="fas fa-layer-group"></i> 
                                        <?= count($inscripcione->curso->modulos) ?> 
                                        <?= count($inscripcione->curso->modulos) === 1 ? 'módulo' : 'módulos' ?>
                                    </p>
                                <?php endif; ?>
                            <?php elseif ($inscripcione->estado === 'pendiente'): ?>
                                <div class="alert alert-warning small mb-0">
                                    <i class="fas fa-clock"></i> 
                                    Tu solicitud está siendo revisada. Te notificaremos cuando sea procesada.
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger small mb-0">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Esta solicitud fue rechazada. Contacta al administrador para más información.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer bg-transparent">
                            <?php if ($inscripcione->estado === 'aprobada'): ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-play-circle"></i> Continuar Curso',
                                    ['controller' => 'Cursos', 'action' => 'view', $inscripcione->curso->id],
                                    ['class' => 'btn btn-primary btn-sm w-100', 'escape' => false]
                                ) ?>
                            <?php else: ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i> Ver Detalles',
                                    ['action' => 'view', $inscripcione->id],
                                    ['class' => 'btn btn-outline-info btn-sm w-100', 'escape' => false]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Paginación de inscripciones">
                    <ul class="pagination justify-content-center">
                        <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                    </ul>
                </nav>
                <p class="text-center text-muted small">
                    <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} de {{count}} inscripciones') ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.curso-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid #dee2e6;
}

.curso-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.card-header {
    padding: 0.75rem 1.25rem;
    text-align: center;
    font-weight: 600;
}

.estado-aprobada {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
}

.estado-pendiente {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
}

.estado-rechazada {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
}

.progress {
    background-color: #e9ecef;
    border-radius: 0.25rem;
}

.card-footer {
    border-top: 1px solid rgba(0,0,0,.125);
}

.opacity-50 {
    opacity: 0.5;
}

.btn-group .btn.active {
    font-weight: bold;
    box-shadow: inset 0 3px 5px rgba(0,0,0,0.125);
}
</style>

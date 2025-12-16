<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 */
?>
<div class="container mt-4 mb-4">
    <div class="card border-0 shadow-sm">
        <!-- Header -->
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">
                <i class="fas fa-file-invoice"></i> Detalles de la Inscripción
            </h4>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="row">
                <!-- Estudiante -->
                <div class="col-md-6 mb-4">
                    <div class="info-group">
                        <label class="text-muted small text-uppercase">Estudiante</label>
                        <p class="h5 mb-0">
                            <?= $inscripcione->hasValue('user') ? 
                                $this->Html->link($inscripcione->user->username, ['controller' => 'Users', 'action' => 'view', $inscripcione->user->id], ['class' => 'text-info']) 
                                : '<span class="text-muted">-</span>' ?>
                        </p>
                    </div>
                </div>

                <!-- Curso -->
                <div class="col-md-6 mb-4">
                    <div class="info-group">
                        <label class="text-muted small text-uppercase">Curso</label>
                        <p class="h5 mb-0">
                            <?= $inscripcione->hasValue('curso') ? 
                                $this->Html->link($inscripcione->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $inscripcione->curso->id], ['class' => 'text-info']) 
                                : '<span class="text-muted">-</span>' ?>
                        </p>
                    </div>
                </div>

                <!-- Estado -->
                <div class="col-md-6 mb-4">
                    <div class="info-group">
                        <label class="text-muted small text-uppercase">Estado</label>
                        <p class="mb-0">
                            <?php
                                $estadoClass = [
                                    'pendiente' => 'badge bg-warning text-dark',
                                    'aprobada' => 'badge bg-success',
                                    'rechazada' => 'badge bg-danger'
                                ];
                                $estado = $inscripcione->estado ?? 'pendiente';
                                $badgeClass = $estadoClass[$estado] ?? 'badge bg-secondary';
                            ?>
                            <span class="<?= $badgeClass ?>">
                                <?= ucfirst($estado) ?>
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Progreso -->
                <div class="col-md-6 mb-4">
                    <div class="info-group">
                        <label class="text-muted small text-uppercase">Progreso</label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height: 25px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= $inscripcione->progreso ?>%;" aria-valuenow="<?= $inscripcione->progreso ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?= $inscripcione->progreso ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fecha de Creación -->
                <div class="col-md-6 mb-4">
                    <div class="info-group">
                        <label class="text-muted small text-uppercase">Fecha de Inscripción</label>
                        <p class="mb-0">
                            <i class="fas fa-calendar-alt"></i> <?= $this->Time->format($inscripcione->created, 'dd/MM/yyyy HH:mm') ?>
                        </p>
                    </div>
                </div>

                <!-- Última Modificación -->
                <div class="col-md-6 mb-4">
                    <div class="info-group">
                        <label class="text-muted small text-uppercase">Última Actualización</label>
                        <p class="mb-0">
                            <i class="fas fa-sync-alt"></i> <?= $this->Time->format($inscripcione->modified, 'dd/MM/yyyy HH:mm') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-group {
        padding-bottom: 0.5rem;
    }

    .info-group label {
        display: block;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .progress {
        background-color: #e9ecef;
        border-radius: 0.25rem;
    }

    .progress-bar {
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
</style>
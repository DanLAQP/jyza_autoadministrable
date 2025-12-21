<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 */
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Encabezado con botón de regreso -->
            <div class="mb-4">
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left me-2"></i> Volver a búsqueda',
                    ['action' => 'search'],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
            </div>

            <!-- Tarjeta principal del certificado -->
            <div class="card shadow-lg border-primary bg-dark">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <?php if ($certificado->tipo === 'diplomado'): ?>
                                    <i class="fas fa-medal me-2"></i> DIPLOMADO
                                <?php else: ?>
                                    <i class="fas fa-award me-2"></i> CERTIFICADO
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="badge bg-light text-dark p-2">
                            <i class="fas fa-barcode me-1"></i> <?= h($certificado->codigo) ?>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Información del titular/usuario -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-muted small mb-2"><?= $certificado->user ? 'USUARIO' : 'TITULAR' ?></h5>
                            <h2 class="text-white text-uppercase">
                                <?php if ($certificado->user): ?>
                                    <?= h($certificado->user->username) ?>
                                <?php else: ?>
                                    <?= h($certificado->nombre_titular) ?>
                                <?php endif; ?>
                            </h2>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <!-- Información del curso -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-book me-2"></i> CURSO/DIPLOMADO
                            </h6>
                            <p class="text-white h5">
                                <?php if ($certificado->curso): ?>
                                    <?= h($certificado->curso->titulo) ?>
                                <?php elseif ($certificado->nombre_curso_manual): ?>
                                    <?= h($certificado->nombre_curso_manual) ?>
                                <?php else: ?>
                                    <span class="text-muted">Sin especificar</span>
                                <?php endif; ?>
                            </p>
                        </div>

                        <?php if (!empty($certificado->horas_lectivas)): ?>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-clock me-2"></i> HORAS LECTIVAS
                            </h6>
                            <p class="text-white h5">
                                <?= (int)$certificado->horas_lectivas ?> horas
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Fechas -->
                    <div class="row mb-4">
                        <?php if ($certificado->fecha_inicio): ?>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-calendar-alt me-2"></i> FECHA DE INICIO
                            </h6>
                            <p class="text-white">
                                <?= h(date('d/m/Y', strtotime($certificado->fecha_inicio))) ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <?php if ($certificado->fecha_fin): ?>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-calendar-check me-2"></i> FECHA DE FINALIZACIÓN
                            </h6>
                            <p class="text-white">
                                <?= h(date('d/m/Y', strtotime($certificado->fecha_fin))) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <hr class="border-secondary">

                    <!-- Módulos si existen -->
                    <?php if (!empty($certificado->certificado_modulos)): ?>
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-list-check me-2"></i> MÓDULOS CURSADOS (<?= count($certificado->certificado_modulos) ?>)
                        </h6>
                        <div class="list-group list-group-flush">
                            <?php foreach ($certificado->certificado_modulos as $modulo): ?>
                            <div class="list-group-item bg-dark border-secondary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-white">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <?= h($modulo->titulo) ?>
                                    </h6>
                                </div>
                                <?php if (!empty($modulo->descripcion)): ?>
                                <p class="mb-1 small text-muted">
                                    <?= h($modulo->descripcion) ?>
                                </p>
                                <?php endif; ?>
                                <?php if (!empty($modulo->horas)): ?>
                                <small class="text-info">
                                    <i class="fas fa-hourglass-end me-1"></i> <?= (int)$modulo->horas ?> horas
                                </small>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <hr class="border-secondary">
                    <?php endif; ?>

                    <!-- Información de calificación -->
                    <?php if ($certificado->nota_final !== null): ?>
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-star me-2"></i> CALIFICACIÓN FINAL
                        </h6>
                        <div class="alert alert-info mb-0">
                            <h4 class="mb-0">
                                <?= number_format($certificado->nota_final, 2) ?>
                                <span class="small text-muted">/10.00</span>
                            </h4>
                        </div>
                    </div>

                    <hr class="border-secondary">
                    <?php endif; ?>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2">
                        <?= $this->Html->link(
                            '<i class="fas fa-file-pdf me-2"></i> Descargar Certificado en PDF',
                            ['action' => 'downloadPdf', $certificado->codigo],
                            [
                                'class' => 'btn btn-success btn-lg',
                                'escape' => false,
                                'target' => '_blank'
                            ]
                        ) ?>
                    </div>

                    <div class="mt-3">
                        <?= $this->Html->link(
                            '<i class="fas fa-search me-2"></i> Buscar otro certificado',
                            ['action' => 'search'],
                            [
                                'class' => 'btn btn-outline-primary',
                                'escape' => false
                            ]
                        ) ?>
                    </div>
                </div>

                <!-- Pie de página -->
                <div class="card-footer bg-dark border-secondary">
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-shield-alt me-1"></i> 
                        Este certificado ha sido verificado y es auténtico.
                    </small>
                    <small class="text-muted">
                        Generado: <?= h(date('d/m/Y H:i:s')) ?>
                    </small>
                </div>
            </div>

            <!-- Información de privacidad -->
            <div class="alert alert-info mt-4" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Privacidad:</strong> Esta página muestra solo información pública del certificado. 
                Los datos sensibles no se muestran sin autenticación.
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        padding: 1rem;
        transition: background-color 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #1a3a52 !important;
    }

    .alert-info {
        background-color: rgba(23, 162, 184, 0.1);
        border-color: #17a2b8;
    }
</style>

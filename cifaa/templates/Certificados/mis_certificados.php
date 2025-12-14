<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Certificado> $certificados
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-info d-inline-block">
                <i class="fas fa-award"></i> Mis Certificados
            </h2>
            <p class="text-muted">Descarga los certificados de los cursos que has completado</p>
        </div>
    </div>

    <?php if ($certificados->isEmpty()): ?>
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark border-info">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-certificate fa-5x text-muted mb-4"></i>
                        <h4 class="text-light">No tienes certificados aún</h4>
                        <p class="text-muted">Completa tus cursos para obtener certificados acreditados</p>
                        <?= $this->Html->link(
                            '<i class="fas fa-book"></i> Ver Mis Cursos',
                            ['controller' => 'Cursos', 'action' => 'student'],
                            ['class' => 'btn btn-info mt-3', 'escape' => false]
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($certificados as $certificado): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-warning bg-dark shadow-lg hover-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-certificate fa-4x text-warning"></i>
                        </div>
                        <h5 class="card-title text-center text-light mb-3">
                            <?= h($certificado->curso->titulo) ?>
                        </h5>
                        
                        <div class="mb-3">
                            <hr class="border-secondary">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="fas fa-calendar-alt me-1"></i> Fecha de emisión</span>
                                <strong class="text-light"><?= h($certificado->fecha_emision->format('d/m/Y')) ?></strong>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="fas fa-clock me-1"></i> Horas académicas</span>
                                <strong class="text-light"><?= h($certificado->horas) ?> hrs</strong>
                            </div>
                            <div class="text-muted small mb-2">
                                <span><i class="fas fa-barcode me-1"></i> Código</span><br>
                                <code class="text-warning small"><?= h($certificado->codigo) ?></code>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <?= $this->Html->link(
                                '<i class="fas fa-download me-1"></i> Descargar PDF', 
                                ['action' => 'descargar', $certificado->id], 
                                ['class' => 'btn btn-warning w-100', 'escape' => false]
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Paginación -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        <?= $this->Paginator->counter('Mostrando {{start}} a {{end}} de {{count}} certificados') ?>
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3) !important;
}
</style>

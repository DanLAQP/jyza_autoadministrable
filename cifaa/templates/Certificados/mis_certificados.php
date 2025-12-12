<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Certificado> $certificados
 */
?>
<div class="container mt-4 mb-4">
    <h2 class="text-info mb-4"><i class="fas fa-award"></i> Mis Certificados</h2>

    <?php if ($certificados->isEmpty()): ?>
        <div class="alert alert-info">
            No tienes certificados registrados aún. Completar tus cursos para obtenerlos.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($certificados as $certificado): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-info">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-certificate fa-4x text-warning"></i>
                        </div>
                        <h5 class="card-title"><?= h($certificado->curso->titulo) ?></h5>
                        <p class="card-text text-muted">
                            <small>Fecha: <?= h($certificado->fecha_emision->format('d/m/Y')) ?></small><br>
                            <small>Horas: <?= h($certificado->horas) ?></small>
                        </p>
                        <?= $this->Html->link('<i class="fas fa-download"></i> Descargar PDF', 
                            ['action' => 'descargar', $certificado->id], 
                            ['class' => 'btn btn-outline-info', 'escape' => false]) 
                        ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="paginator">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<< ' . __('Primero')) ?>
                <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
                <?= $this->Paginator->last(__('Último') . ' >>') ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

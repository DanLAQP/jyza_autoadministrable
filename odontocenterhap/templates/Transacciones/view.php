<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaccione $transaccione
 */
?>
<style>
    .label-text {
        color: #f8f9fa;
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
        min-height: 38px;
        display: flex;
        align-items: center;
        color: #ffffff;
    }
</style>

<div class="container mt-4 mb-4">
    <div class="mb-4">
        <h3 class="text-light"><i class="fas fa-exchange-alt me-2"></i> Detalles de la Transacción</h3>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text">Producto:</p>
        </div>
        <div class="col-md-9">
            <div class="data-box">
                <?= $transaccione->hasValue('producto') ? $this->Html->link($transaccione->producto->nombre, ['controller' => 'Productos', 'action' => 'view', $transaccione->producto->id], ['class' => 'text-decoration-none text-white']) : 'No especificado' ?>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text">Tipo de Transacción:</p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($transaccione->tipo_transaccion) ?></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text">Cantidad:</p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= $this->Number->format($transaccione->cantidad) ?></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text">Usuario ID:</p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= $this->Number->format($transaccione->user_id) ?></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text">Fecha de Transacción:</p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($transaccione->fecha_transaccion) ?></div>
        </div>
    </div>

    <div class="text mt-3">
        <strong class="label-text">Notas</strong>
        <blockquote class="data-box">
            <?= $this->Text->autoParagraph(h($transaccione->notas)); ?>
        </blockquote>
    </div>

    <div class="col-12 mt-3 text-center">
        <?= $this->Html->link(__('Editar Transacción'), ['action' => 'edit', $transaccione->id], ['class' => 'btn btn-primary me-3 openModal' , 'target' => '_blank']) ?>
        <?= $this->Html->link(__('Regresar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

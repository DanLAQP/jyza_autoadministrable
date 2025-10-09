<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Egreso $egreso
 */
?>
<style>
    .label-text {
        color: #f8f9fa; /* Texto blanco-gris claro */
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d; /* Gris oscuro tipo input */
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
        color: #fff;
    }
</style>

<div class="container">
    <!-- Título -->
    <div class="mb-5">
        <h3 class="text-info"><i class="fas fa-money-bill-wave"></i> Información del Egreso</h3>
    </div>

    <!-- Fila 1: ID y Cantidad -->
    <div class="row mb-3">
        <div class="col-md-2">
            <p class="label-text"><?= __('Cantidad:') ?></p>
        </div>
        <div class="col-md-10">
            <div class="data-box"><?= $egreso->cantidad !== null ? $this->Number->currency($egreso->cantidad, 'S/. ') : '&nbsp;' ?></div>
        </div>
    </div>

    <!-- Fila 2: Descripción -->
    <div class="row mb-3">
        <div class="col-md-2">
            <p class="label-text"><?= __('Descripción:') ?></p>
        </div>
        <div class="col-md-10">
            <div class="data-box"><?= !empty($egreso->descripcion) ? h($egreso->descripcion) : '&nbsp;' ?></div>
        </div>
    </div>

    <!-- Fila 3: Fechas -->
    <div class="row mb-3">
        <div class="col-md-2">
            <p class="label-text"><?= __('Creado el:') ?></p>
        </div>
        <div class="col-md-3">
            <div class="data-box"><?= h($egreso->created) ?></div>
        </div>

        <div class="col-md-1"></div>

        <div class="col-md-3">
            <p class="label-text"><?= __('Modificado el:') ?></p>
        </div>
        <div class="col-md-3">
            <div class="data-box"><?= h($egreso->modified) ?></div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="text-center mt-5">
        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $egreso->id], ['class' => 'btn btn-warning me-2']) ?>
        <?= $this->Html->link(__('Volver a la Lista'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

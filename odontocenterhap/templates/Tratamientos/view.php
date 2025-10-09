<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tratamiento $tratamiento
 */
?>
<style>
    .label-text {
        color: #f8f9fa; /* Color plomo (gris) */
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d; /* Fondo claro similar a un input */
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
    }
</style>

<div class="container">
    <!-- Header -->
    <div class="mb-5">
        <h3 class="text-info"><i class="fas fa-tooth"></i> Información del Tratamiento</h3>
    </div>

    <!-- Contenido -->
    <div>
        <!-- Campo: Nombre -->
        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('Nombre:') ?></p>
            </div>
            <div class="col-md-3">
                <div class="data-box"><?= h($tratamiento->nombre) ?></div>
            </div>
            <div class="col-md-1"></div>
            <!-- Campo: Costo -->
            <div class="col-md-3">
                <p class="label-text"><?= __('Costo:') ?></p>
            </div>
            <div class="col-md-3">
                <div class="data-box"><?= $tratamiento->costo === null ? '&nbsp;' : $this->Number->format($tratamiento->costo) ?></div>
            </div>
        </div>

        <!-- Campo: Descripción -->
        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('Descripción:') ?></p>
            </div>
            <div class="col-md-10">
                <div class="data-box"><?= !empty($tratamiento->descripcion) ? h($tratamiento->descripcion) : '&nbsp;' ?></div>
            </div>
        </div>

        <!-- Campo: Fechas -->
        <div class="row mb-2">
            <div class="col-md-2">
                <p class="label-text"><?= __('Creado el:') ?></p>
            </div>
            <div class="col-md-3 mb-3">
                <div class="data-box"><?= h($tratamiento->created) ?></div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <p class="label-text"><?= __('Modificado el:') ?></p>
            </div>
            <div class="col-md-3">
                <div class="data-box"><?= h($tratamiento->modified) ?></div>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="text-center mt-5">
    <?= $this->Html->link(__('Volver a la Lista'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
</div>

</div>

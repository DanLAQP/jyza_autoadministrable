<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctore $doctore
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
        padding: 5px 12px;
    }
    .actions {
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="container mt-4 mb-4">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user-md"></i> Información del Doctor</h3>
    </div>

    <!-- Cuerpo -->
    <div>
    <!-- Campo: Nombre y Apellido -->
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Nombre:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->nombre) ?></div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Apellido:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->apellido) ?></div>
        </div>
    </div>

    <!-- Campo: Especialidad -->
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Especialidad:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->especialidad) ?></div>
        </div>
    </div>

    <!-- Campo: Teléfono -->
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Teléfono:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->telefono) ?></div>
        </div>
    </div>

    <!-- Campo: Correo Electrónico -->
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Correo:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->email) ?></div>
        </div>
    </div>

    <!-- Campo: Fechas -->
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Creado:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->created) ?></div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3 col-12">
            <p class="label-text"><?= __('Modificado:') ?></p>
        </div>
        <div class="col-md-9 col-12">
            <div class="data-box"><?= h($doctore->modified) ?></div>
        </div>
    </div>
</div>


    <!-- Botón de regreso -->
    <div class="actions">
        <?= $this->Html->link(__('Volver a la Lista'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

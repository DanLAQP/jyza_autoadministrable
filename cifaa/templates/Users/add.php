<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="container mt-4 mb-4">
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?= h($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php else: ?>
        <?= $this->Form->create($user, ['class' => 'row g-3']) ?>

        <!-- Información del Usuario -->
        <div class="col-12 mb-4">
            <h3 class="text-info"><i class="fas fa-user"></i> Agregar Usuario</h3>
        </div>

        <!-- Campo: Username -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('username', [
                'label' => 'Nombre de Usuario',
                'class' => 'form-control',
                'placeholder' => 'Ejemplo: usuario123'
            ]) ?>
        </div>

        <!-- Campo: DNI -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('dni', [
                'label' => 'DNI',
                'class' => 'form-control',
                'placeholder' => 'Ingrese DNI'
            ]) ?>
        </div>

        <!-- Campo: Password -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('password', [
                'label' => 'Contraseña',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Ingrese la contraseña'
            ]) ?>
        </div>

    <!-- Campo: Rol -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('rol', [
            'label' => 'Rol del Usuario',
            'class' => 'form-control',
            'type' => 'select',
            'options' => [
                1 => 'Administrador',
                2 => 'Usuario',
            ],
            
        ]) ?>
    </div>

    <!-- Campo: Estado -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('estado', [
            'label' => 'Estado',
            'class' => 'form-control',
            'type' => 'select',
            'options' => [
                'activo' => 'Activo',
                'inactivo' => 'Inactivo',
            ],
            'default' => 'activo'
        ]) ?>
    </div>        <!-- Botones -->
        <div class="col-12 text-center">
            <?= $this->Form->button(__('Guardar Usuario'), ['class' => 'btn btn-info']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
            
        </div>

        <?= $this->Form->end() ?>
    <?php endif; ?>

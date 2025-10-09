<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctore $doctore
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($doctore, ['class' => 'row g-3']) ?>

    <!-- Información del Doctor -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user-md"></i> Editar Doctor</h3>
    </div>

    <!-- Campos Nombre y Apellido en la misma fila -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('nombre', [
            'label' => 'Nombre del Doctor',
            'class' => 'form-control',
            'placeholder' => 'Ejemplo: Juan, María'
        ]) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('apellido', [
            'label' => 'Apellido del Doctor',
            'class' => 'form-control',
            'placeholder' => 'Ejemplo: Pérez, García'
        ]) ?>
    </div>

    <!-- Campo Especialidad -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('especialidad', [
            'label' => 'Especialidad',
            'class' => 'form-control',
            'placeholder' => 'Ejemplo: Cardiología, Odontología'
        ]) ?>
    </div>

    <!-- Campos Teléfono y Email en la misma fila -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('telefono', [
            'label' => 'Teléfono',
            'class' => 'form-control',
            'placeholder' => 'Ejemplo: +52 123 456 7890',
            'type' => 'tel'
        ]) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('email', [
            'label' => 'Correo Electrónico',
            'class' => 'form-control',
            'placeholder' => 'Ejemplo: doctor@ejemplo.com',
            'type' => 'email'
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
        
    </div>

    <?= $this->Form->end() ?>
</div>

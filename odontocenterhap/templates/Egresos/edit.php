<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Egreso $egreso
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($egreso, ['class' => 'row g-3']) ?>

    <!-- Título -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-money-bill-wave"></i> Editar Egreso</h3>
    </div>

    <!-- Campo Cantidad -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('cantidad', [
            'label' => 'Cantidad',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el monto del egreso'
        ]) ?>
    </div>

    <!-- Campo Descripción -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => 'Motivo o detalles del egreso'
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaDetalle $odontogramaDetalle
 * @var string[]|\Cake\Collection\CollectionInterface $odontograma
 */
?>

<div class="container mt-4 mb-4">

    <?= $this->Form->create($odontogramaDetalle, ['class' => 'row g-3']) ?>

    <!-- Información del Odontograma Detalle -->
    <div class="col-12 mb-4">
        <h3 class="text-ligth"><i class="fas fa-edit"></i> Editar el Detalle</h3>
    </div>


    <!-- Campo: Especificaciones -->
    <div class="col-md-12 mb-3">
        <?= $this->Form->control('especificaciones', [
            'label' => 'Especificaciones',
            'class' => 'form-control',
            'placeholder' => 'Ingrese las especificaciones del detalle',
            'required' => true
        ]) ?>
    </div>

    <!-- Campo: Observaciones -->
    <div class="col-md-12 mb-3">
        <?= $this->Form->control('observaciones', [
            'label' => 'Observaciones',
            'class' => 'form-control',
            'placeholder' => 'Ingrese observaciones si las hay',
            'required' => true
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info']) ?>
</button>

    </div>

    <?= $this->Form->end() ?>
</div>

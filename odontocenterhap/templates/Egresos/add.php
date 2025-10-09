<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Egreso $egreso
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($egreso, ['class' => 'row g-3']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-money-bill-wave"></i> Agregar Egreso</h3>
    </div>

    <!-- Campo Cantidad -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('cantidad', [
            'label' => 'Cantidad',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el monto del egreso',
        ]) ?>
    </div>

    <!-- Campo Descripción -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'class' => 'form-control',
            'placeholder' => 'Motivo o detalles del egreso',
            'type' => 'text'
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center mt-3">
        <?= $this->Form->button('Guardar Egreso', [
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'id' => 'btnGuardar'
        ]) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<script>
    const form = document.querySelector("form");
    const btnGuardar = document.getElementById("btnGuardar");

    if (form && btnGuardar) {
        form.addEventListener("submit", function(event) {
            if (!form.checkValidity()) {
                event.preventDefault(); // Evita que el formulario se envíe si no es válido
                return;
            }
            btnGuardar.disabled = true;
            btnGuardar.innerText = "Guardando...";
        });
    }
</script>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tratamiento $tratamiento
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($tratamiento, ['class' => 'row g-3']) ?>

    <!-- Información del Tratamiento -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-tooth"></i> Agregar Tratamiento</h3>
    </div>

    <!-- Campos Nombre y Costo en la misma fila -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('nombre', [
            'label' => 'Nombre del Tratamiento',
            'class' => 'form-control',
            'placeholder' => 'Ejemplo: Ortodoncia, Limpieza Dental'
        ]) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('costo', [
            'label' => 'Costo del Tratamiento',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el costo del tratamiento'
        ]) ?>
    </div>

    <!-- Campo Descripción con ancho de 12 columnas -->
    <div class="col-md-12 mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'class' => 'form-control',
            'placeholder' => 'Detalles adicionales del tratamiento',
            'type' => 'text'
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center mt-3">
        <?= $this->Form->button('Guardar Tratamiento', [
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
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
        <h3 class="text-info"><i class="fas fa-user-md"></i> Agregar Doctor</h3>
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
            'placeholder' => 'Ejemplo: 123 456 7890',
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
    <div class="col-12 text-center mt-3">
        <?= $this->Form->button(__('Guardar Doctor'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
<script>
    $(document).ready(function() {
    $(document).on("submit", "form", function(event) {
        const form = $(this)[0]; 
        const btnGuardar = $(this).find("#submitButton");

        if (!form.checkValidity()) {
            event.preventDefault(); // Evita el envío si hay errores en el formulario
            return;
        }

        btnGuardar.prop("disabled", true).text("Guardando...");
    });

    // Detecta cambios en los archivos dentro del modal o cualquier formulario
    $(document).on("change", "input[type='file']", function() {
        const btnGuardar = $(this).closest("form").find("#submitButton");
        if (this.files.length > 0) {
            btnGuardar.prop("disabled", false);
        }
    });
});

</script>

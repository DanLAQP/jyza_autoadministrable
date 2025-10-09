<div class="container mt-4 mb-4">
    <?= $this->Form->create($proveedore, ['class' => 'row g-3', 'id' => 'formAgregarProveedor']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-truck"></i> Agregar Proveedor</h3>
    </div>

    <!-- Nombre del Proveedor -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('nombre', [
            'label' => 'Nombre del Proveedor',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el nombre del proveedor',
        ]) ?>
    </div>

    <!-- Contacto Nombre -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('contacto_nombre', [
            'label' => 'Nombre de Contacto',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el nombre del contacto',
        ]) ?>
    </div>

    <!-- Contacto Email -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('contacto_email', [
            'label' => 'Correo Electrónico',
            'class' => 'form-control',
            'type' => 'email',
            'placeholder' => 'Ingrese el correo electrónico',
        ]) ?>
    </div>

    <!-- Contacto Teléfono -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('contacto_telefono', [
            'label' => 'Teléfono de Contacto',
            'class' => 'form-control',
            'type' => 'tel',
            'placeholder' => 'Ingrese el número de teléfono',
        ]) ?>
    </div>

    <!-- Dirección -->
    <div class="col-12 mb-3">
    <?= $this->Form->control('direccion', [
        'label' => 'Dirección',
        'type' => 'text',
        'class' => 'form-control',
        'placeholder' => 'Ingrese la dirección del proveedor',
    ]) ?>
</div>


    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Proveedor'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
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

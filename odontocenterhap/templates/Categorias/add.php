<div class="container mt-4 mb-4">
    <?= $this->Form->create($categoria, ['class' => 'row g-3', 'id' => 'formAgregarCategoria']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-tags"></i> Agregar Categoría</h3>
    </div>

    <!-- Nombre de la Categoría -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('nombre', [
            'label' => 'Nombre de la Categoría',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el nombre de la categoría',
        ]) ?>
    </div>

    <!-- Descripción -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'type' => 'text',
            'class' => 'form-control',
            'placeholder' => 'Ingrese una descripción breve',
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Categoría'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
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

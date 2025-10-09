<div class="container mt-4 mb-4">
    <?= $this->Form->create($producto, ['class' => 'row g-3', 'id' => 'formAgregarProducto']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-box"></i> Agregar Producto</h3>
    </div>

    <!-- Nombre del Producto -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('nombre', [
            'label' => 'Nombre del Producto',
            'class' => 'form-control',
            'placeholder' => 'Ingrese el nombre del producto',
        ]) ?>
    </div>

    <div class="col-12 mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'type' => 'text', 
            'class' => 'form-control',
            'placeholder' => 'Ingrese una descripción breve',
        ]) ?>
    </div>


    <!-- Categoría -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('categoria_id', [
            'label' => 'Categoría',
            'options' => $categorias,
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Cantidad -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('cantidad', [
            'label' => 'Cantidad',
            'class' => 'form-control',
            'type' => 'number',
        ]) ?>
    </div>

    <!-- Precio -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('precio', [
            'label' => 'Precio',
            'class' => 'form-control',
            'type' => 'number',
            'step' => '0.01',
        ]) ?>
    </div>

    <!-- Proveedor -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('proveedor_id', [
            'label' => 'Proveedor',
            'options' => $proveedores,
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Fechas -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('fecha_vencimiento', [
            'label' => 'Fecha de Vencimiento',
            'class' => 'form-control',
            'type' => 'date',
            'empty' => true,
        ]) ?>
    </div>
    <div class="col-12 mb-3">
        <?= $this->Form->control('fecha_ingreso', [
            'label' => 'Fecha de Ingreso',
            'class' => 'form-control',
            'type' => 'date',
        ]) ?>
    </div>

    <!-- Ubicación y Stock Mínimo -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('ubicacion', [
            'label' => 'Ubicación',
            'class' => 'form-control',
            'placeholder' => 'Ubicación en almacén',
        ]) ?>
    </div>
    <div class="col-12 mb-3">
        <?= $this->Form->control('stock_minimo', [
            'label' => 'Stock Mínimo',
            'class' => 'form-control',
            'type' => 'number',
        ]) ?>
    </div>

    <!-- Estado -->
    <div class="col-12 mb-3">
        <?= $this->Form->control('estado', [
            'label' => 'Estado',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Producto'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
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

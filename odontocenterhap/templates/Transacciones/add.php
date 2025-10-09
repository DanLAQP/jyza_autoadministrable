<div class="container mt-4 mb-4">
    <?= $this->Form->create($transaccione, ['class' => 'row g-3', 'id' => 'transaccionForm']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-truck"></i> Agregar Transacción</h3>
    </div>

    <!-- Buscador de Producto -->
    <div class="col-md-10 mx-auto mb-3">
        <label for="producto_id" class="form-label">Seleccionar Producto</label>
        <?= $this->Form->control('producto_id', [
            'options' => array_map(function ($producto) {
                return $producto['nombre'];  // Solo el nombre del producto
            }, $productosConStock),
            'label' => false,
            'class' => 'form-select form-control',
            'id' => 'producto_id',
            'required' => true
        ]) ?>
    </div>

    <!-- Tipo de Transacción (Entrada/Salida) -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('tipo_transaccion', [
            'type' => 'select',
            'options' => ['entrada' => 'Entrada', 'salida' => 'Salida'],
            'empty' => 'Seleccionar...',
            'label' => 'Tipo de Transacción',
            'class' => 'form-select form-control',
            'id' => 'tipo_transaccion',
            'required' => true
        ]) ?>
    </div>

    <!-- Cantidad -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('cantidad', [
            'label' => 'Cantidad',
            'class' => 'form-control',
            'id' => 'cantidadField',
            'required' => true
        ]) ?>
    </div>

    <!-- Usuario -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('user_id', [
            'options' => $users,
            'label' => 'Usuario',
            'class' => 'form-select form-control',
            'required' => true
        ]) ?>
    </div>

    <!-- Notas (Opcional) -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('notas', [
            'label' => 'Notas (Opcional)',
            'class' => 'form-control',
            'type' => 'text',
        ]) ?>
    </div>

    <!-- Campo oculto de fecha de transacción -->
    <?= $this->Form->hidden('fecha_transaccion', ['value' => date('Y-m-d H:i:s')]) ?>

    <!-- Mostrar stock disponible si es una transacción de salida -->
     <div class="form control col-md-10 mx-auto mb-3">
        <div id="stockInfo" class="alert alert-info" style="display: none;">
            Stock disponible: <span id="stockAmount">0</span> unidades.
        </div>
     </div>
    

    <!-- Mensaje de error si no hay suficiente stock -->
    <div class="form control col-md-10 mx-auto mb-3">
        <div id="stockError" class="alert alert-danger" style="display: none;">
            No hay suficiente stock para realizar esta salida.
        </div>
    </div>
    
    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <button type="submit" class="btn btn-info" id="submitButton">
            <?= __('Guardar Transacción') ?>
        </button>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>




<script>
    function initializeForm() {
    console.log("Inicializando formulario...");

    const form = document.querySelector('#transaccionForm');
    const cantidadField = document.querySelector('#cantidadField');
    const stockInfo = document.querySelector('#stockInfo');
    const stockAmountElement = document.querySelector('#stockAmount');
    const stockError = document.querySelector('#stockError');
    const productoSelect = document.querySelector('#producto_id');

    if (!form || !cantidadField || !stockInfo || !stockAmountElement || !stockError || !productoSelect) {
        console.error("Uno o más elementos del formulario no fueron encontrados.");
        return;
    }

    let stockAmount = 0;
    const productosConStock = <?= json_encode($productosConStock) ?>;
    console.log("Productos con stock:", productosConStock);

    function handleProductChange() {
        const productoId = this.value;
        console.log("Producto seleccionado:", productoId);

        if (productosConStock[productoId]) {
            stockAmount = productosConStock[productoId].stock;
            stockAmountElement.textContent = stockAmount;
            stockInfo.style.display = 'block';
            stockError.style.display = 'none';
        } else {
            stockInfo.style.display = 'none';
            stockAmountElement.textContent = 0;
        }
    }

    function handleFormSubmit(event) {
    event.preventDefault();

    const cantidad = parseInt(cantidadField.value, 10);

    if (isNaN(cantidad) || cantidad <= 0) {
        alert('Por favor, ingresa una cantidad válida.');
        cantidadField.focus();
        return;
    }

    const tipoTransaccion = document.querySelector('[name="tipo_transaccion"]').value; // Cambiado para manejar select
    if (!tipoTransaccion) {
        alert("Por favor, selecciona un tipo de transacción.");
        return;
    }

    if (tipoTransaccion === 'salida' && cantidad > stockAmount) {
        stockError.textContent = 'No se puede guardar, la cantidad solicitada supera el stock disponible.';
        stockError.style.display = 'block';
        cantidadField.focus();
        return;
    } else {
        stockError.style.display = 'none';
    }

    setTimeout(() => form.submit(), 500);
}

    // Eliminar eventos previos para evitar duplicados
    productoSelect.removeEventListener('change', handleProductChange);
    form.removeEventListener('submit', handleFormSubmit);

    // Re-asignar eventos
    productoSelect.addEventListener('change', handleProductChange);
    form.addEventListener('submit', handleFormSubmit);

    // ✅ Mostrar el stock del producto seleccionado por defecto
    if (productoSelect.value) {
        handleProductChange.call(productoSelect);
    }
}

// ✅ Ejecutar el script cuando la página carga normalmente
document.addEventListener('DOMContentLoaded', function () {
    initializeForm();
});

// ✅ Asegurar que el script se ejecuta cuando el modal se abre por AJAX
$(document).on('shown.bs.modal', '#modalLg', function () {
    initializeForm();
});

// ✅ Re-inicializar el script después de cualquier carga AJAX
$(document).on('ajaxComplete', function () {
    initializeForm();
});

</script>
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

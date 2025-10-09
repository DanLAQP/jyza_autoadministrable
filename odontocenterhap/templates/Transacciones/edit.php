<div class="container mt-4 mb-4">
    <?= $this->Form->create($transaccione, ['id' => 'transaccionForm']) ?>
            
    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-truck"></i> Editar Transacción</h3>
    </div>

                <!-- Producto (solo visible, no editable) -->
                <div class="col-md-10 mx-auto mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <div class="form-control">
                        <p id="producto_id "><?= h($transaccione->producto->nombre) ?></p>
                    </div>
                </div>

                <!-- Tipo de Transacción (Entrada/Salida) -->
                <div class="col-md-10 mx-auto mb-3">
                    <?= $this->Form->control('tipo_transaccion', [
                        'type' => 'select',  // Cambiado de 'radio' a 'select'
                        'options' => ['entrada' => 'Entrada', 'salida' => 'Salida'], // Las opciones del select
                        'label' => 'Tipo de Transacción',
                        'empty' => 'Seleccionar...', // Opción vacía para que el usuario seleccione una opción
                        'class' => 'form-select form-control',
                        'required' => true, // Aseguramos que el campo sea obligatorio
                        'value' => $transaccione->tipo_transaccion // El valor preseleccionado para la edición
                    ]) ?>
                </div>

                <!-- Cantidad -->
                <div class="col-md-10 mx-auto mb-3">
                    <?= $this->Form->control('cantidad', [
                        'label' => 'Cantidad',
                        'class' => 'form-control',
                        'id' => 'cantidadField',
                        'required' => true,
                        'value' => $transaccione->cantidad // Valor actual de cantidad
                    ]) ?>
                </div>

                <!-- Usuario -->
                <div class="col-md-10 mx-auto mb-3">
                    <?= $this->Form->control('user_id', [
                        'options' => $users,
                        'label' => 'Usuario',
                        'class' => 'form-select form-control',
                        'required' => true,
                        'value' => $transaccione->user_id // Valor actual del usuario
                    ]) ?>
                </div>

                <!-- Notas (Opcional) -->
                <div class="col-md-10 mx-auto mb-3">
                    <?= $this->Form->control('notas', [
                        'label' => 'Notas (Opcional)',
                        'class' => 'form-control',
                        'value' => $transaccione->notas,
                        'type' => 'text'
                    ]) ?>
                </div>

                <!-- Campo oculto de fecha de transacción -->
                <?= $this->Form->hidden('fecha_transaccion', ['value' => date('Y-m-d H:i:s')]) ?>

                <!-- Campo oculto para enviar el stock después de la edición -->
                <?= $this->Form->hidden('nuevo_stock', ['id' => 'hiddenNewStock']) ?>

                <!-- Mostrar stock disponible si es una transacción de salida -->
                
                <div id="stockInfo" class=" col-md-10 mx-auto mb-3">
                    <p class='form-control bg-info'><strong>Stock antes de la transacción original:</strong> <span id="stockOriginal">-</span> unidades.</p>
                    <p class='form-control bg-info'><strong>Stock actual:</strong> <span id="stockAmount"><?= h($transaccione->producto->cantidad) ?></span> unidades.</p>
                    <p class='form-control bg-success'><strong>Stock después de la edición:</strong> <span id="newStockAmount">-</span> unidades.</p>
                </div>

                <!-- Mensaje de error si no hay suficiente stock -->

                <div class="form control col-md-10 mx-auto mb-3">
                    <div id="stockError" class="alert alert-danger" style="display: none;">
                        No hay suficiente stock para realizar esta salida.
                    </div>
                </div>

                <!-- Botón de envío del formulario -->
                <div class="col-12 mt-3 text-center">
                    <button type="submit" class="btn btn-info" id="submitButton"><?= __('Guardar Transacción') ?></button>
                    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
                </div>

            <?= $this->Form->end() ?>
        </div>

<script>
    let formInitialized = false; // Variable para verificar si el formulario ha sido inicializado

function initializeForm() {
    // Verifica si ya está inicializado, si es así no hace nada
    if (formInitialized) return; 
    formInitialized = true; // Marcamos como inicializado

    const form = document.querySelector('#transaccionForm');
    const cantidadField = document.querySelector('#cantidadField');
    const stockOriginalElement = document.querySelector('#stockOriginal');
    const stockAmountElement = document.querySelector('#stockAmount');
    const newStockAmountElement = document.querySelector('#newStockAmount');
    const stockError = document.querySelector('#stockError');
    const hiddenNewStock = document.querySelector('#hiddenNewStock');
    const tipoTransaccionSelect = document.querySelector('[name="tipo_transaccion"]');

    if (!form || !cantidadField || !stockOriginalElement || !stockAmountElement || !newStockAmountElement || !stockError || !hiddenNewStock || !tipoTransaccionSelect) {
       
        return;
    }

    // Stock actual del producto en la base de datos
    const stockActual = <?= $transaccione->producto->cantidad ?>;
    const cantidadAnterior = <?= $transaccione->cantidad ?>;
    const tipoTransaccionAnterior = "<?= $transaccione->tipo_transaccion ?>";

    // 1️⃣ **Restaurar el stock antes de la transacción original**
    let stockOriginal = stockActual;
    if (tipoTransaccionAnterior === 'entrada') {
        stockOriginal -= cantidadAnterior;
    } else if (tipoTransaccionAnterior === 'salida') {
        stockOriginal += cantidadAnterior;
    }
    
    stockOriginalElement.textContent = stockOriginal;

    // 2️⃣ **Función para calcular el nuevo stock**
    function actualizarStock() {
        let cantidadNueva = parseInt(cantidadField.value, 10) || 0;
        let tipoTransaccionNueva = tipoTransaccionSelect.value;

        if (!tipoTransaccionNueva) return;

        let stockCalculado = stockOriginal;

        if (tipoTransaccionNueva === 'salida') {
            if (cantidadNueva > stockCalculado) {
                stockError.textContent = 'No se puede guardar, la cantidad solicitada supera el stock disponible.';
                stockError.style.display = 'block';
                newStockAmountElement.textContent = "-";
                hiddenNewStock.value = "";
                return;
            } else {
                stockCalculado -= cantidadNueva;
            }
        } else if (tipoTransaccionNueva === 'entrada') {
            stockCalculado += cantidadNueva;
        }

        if (stockCalculado < 0) {
            stockError.textContent = 'Error: El stock no puede ser negativo.';
            stockError.style.display = 'block';
            newStockAmountElement.textContent = "-";
            hiddenNewStock.value = "";
            return;
        } else {
            stockError.style.display = 'none';
        }

        newStockAmountElement.textContent = stockCalculado;
        hiddenNewStock.value = stockCalculado;
    }

    // Eliminar eventos previos para evitar duplicados
    cantidadField.removeEventListener('input', actualizarStock);
    tipoTransaccionSelect.removeEventListener('change', actualizarStock);

    // 4️⃣ **Escuchar cambios en la cantidad y el tipo de transacción**
    cantidadField.addEventListener('input', actualizarStock);
    tipoTransaccionSelect.addEventListener('change', actualizarStock);

    // Ejecutar cálculo inicial al cargar el formulario
    actualizarStock();

    // Validación antes de enviar el formulario
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const cantidadNueva = parseInt(cantidadField.value, 10);
        const tipoTransaccionNueva = tipoTransaccionSelect.value;

        if (isNaN(cantidadNueva) || cantidadNueva <= 0) {
            alert('Por favor, ingresa una cantidad válida.');
            cantidadField.focus();
            return;
        }

        if (!tipoTransaccionNueva) {
            alert("Por favor, selecciona un tipo de transacción.");
            return;
        }

        if (hiddenNewStock.value === "" || parseInt(hiddenNewStock.value, 10) < 0) {
            alert("Error: No se puede guardar porque el stock quedaría negativo.");
            return;
        }

        form.submit();
    });
}

// Ejecutar el script cuando la página carga normalmente
document.addEventListener('DOMContentLoaded', function () {
    initializeForm();
});

// Asegurar que el script se ejecuta cuando el modal se abre por AJAX
$(document).on('shown.bs.modal', '#modalLg', function () {
    if (!formInitialized) { // Solo inicializamos si no se ha hecho antes
        initializeForm();
    }
});

// Re-inicializar el script después de cualquier carga AJAX
$(document).on('ajaxComplete', function () {
    if (!formInitialized) { // Solo re-inicializamos si no se ha hecho antes
        initializeForm();
    }
});

</script>
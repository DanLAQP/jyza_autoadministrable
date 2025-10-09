<style> 
    .error-js{
        display:none;
    }
</style>
<div class="container mt-4 mb-4">
    <?= $this->Form->create($presupuesto, ['class' => 'row g-3']) ?>

    <!-- Selección de Paciente -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user"></i> Agregar Presupuesto</h3>
    </div>

    <!-- Buscador de Paciente -->
    <div class="col-md-12 mx-auto mb-3">
        <label for="searchPaciente" class="form-label">Buscar Paciente</label>
        <div class="input-group">
            <?= $this->Form->text('search_paciente', [
                'label' => false,
                'class' => 'form-control',
                'id' => 'searchPaciente',
                'placeholder' => 'Ingrese el nombre o apellido del paciente',
                'required' => true,
                'value' => $pacienteSeleccionado ? "{$pacienteSeleccionado->nombre} {$pacienteSeleccionado->apellido}" : '', // Mostrar nombre si ya está preseleccionado
                'readonly' => $pacienteSeleccionado ? true : false // Bloquear el input si viene por URL
            ]) ?>
            <button type="button" id="searchButton" class="btn btn-primary" <?= $pacienteSeleccionado ? 'disabled' : '' ?>>
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
        <div id="pacienteResults" class="list-group mt-2"></div>
<?= $this->Form->hidden('paciente_id', [
    'id' => 'pacienteId',
    'value' => $pacienteSeleccionado ? $pacienteSeleccionado->id : ''
]) ?>
    </div>
    
    
<!-- Mostrar Dirección y DNI del paciente seleccionado -->
<div class="col-md-3 mb-3 error-js">
    <label class="form-label">Dirección</label>
    <input type="text" id="paciente-direccion" class="form-control" readonly />
</div>
<div class="col-md-3 mb-3 error-js">
    <label class="form-label">DNI</label>
    <input type="text" id="paciente-dni" class="form-control" readonly/>
</div>

<div class="col-md-3 mb-3">
    <?= $this->Form->control('modified', [
        'label' => 'Fecha de Presupuesto',
        'class' => 'form-control',
        'type' => 'date',
        'value' => date('Y-m-d'), // Fecha actual por defecto
    ]) ?>
</div>

<!-- notas -->
<div class="col-md-10 mb-3">
<?= $this->Form->control('notas', [
    'label' => 'Observaciones',
    'type' => 'text',
    'class' => 'form-control',
]) ?>
</div>

    <!-- Tabla de Tratamientos -->
    <div class="col-12 mb-4 mt-3">
        <h3 class="text-info"><i class="fas fa-tooth"></i> Tratamientos</h3>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped" id="tabla-tratamientos">
                <thead class="bg-info text-white">
                    <tr>
                        <th><?= __('Cantidad') ?></th>
                        <th><?= __('Tratamiento') ?></th>
                        <th><?= __('Precio Unitario') ?></th>
                        <th><?= __('Subtotal') ?></th>
                        <th><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Las filas se añadirán dinámicamente con JavaScript -->
                </tbody>
            </table>
        </div>
        <button id="add-tratamiento-btn" type="button" class="btn btn-info mt-2" onclick="validateAndAddTratamiento()">
            Agregar Tratamiento
        </button>        
    </div>


    <!-- Desglose de Totales -->
    <div class="col-12 mt-4 mb-4 mt-3">
        <h3 class="text-info"><i class="fas fa-calculator"></i> Total</h3>
    </div>

    <div class="col-md-4 mb-3">
        <?= $this->Form->control('total_visible', [
            'label' => 'Total',
            'class' => 'form-control',
            'id' => 'total-visible',
            'readonly' => true,
        ]) ?>
    </div>
    <div class="col-md-4 mb-3">
        <?= $this->Form->control('subtotal', [
            'type' => 'hidden',
            'class' => 'form-control',
            'id' => 'subtotal',
            'readonly' => true,
        ]) ?>
    </div>
    <div class="col-md-4 mb-3">
        <?= $this->Form->control('igv', [
            'type' => 'hidden',
            'class' => 'form-control',
            'id' => 'igv',
            'readonly' => true,
        ]) ?>
    </div>
    <div class="col-md-4 mb-3">
        <?= $this->Form->control('total', [
            'type' => 'hidden',
            'class' => 'form-control',
            'id' => 'total',
            'readonly' => true,
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center">
        <?= $this->Form->button(('Guardar Presupuesto'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- Datos JSON -->
<script>
    const pacientesData = <?= json_encode($pacientesData) ?>;
    const pacientesData2 = <?= json_encode($pacientesData2) ?>;
    const tratamientosData = <?= json_encode($tratamientosData) ?>;
</script>

<?= $this->Html->script('presupuestos.js') ?>
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
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
                'required' => true,
                'placeholder' => 'Ingrese el nombre o apellido del paciente',
                'value' => $presupuesto->pacientes1 ? $presupuesto->pacientes1->nombre . ' ' . $presupuesto->pacientes1->apellido : '',
            ]) ?>
            <button type="button" id="searchButton" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
        <div id="pacienteResults" class="list-group mt-2"></div>
        <?= $this->Form->hidden('paciente_id', ['id' => 'pacienteId']) ?>
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

<!-- fecha modified -->
<div class="col-md-3 mb-3">
    <?= $this->Form->control('modified', [
        'label' => 'Fecha de Presupuesto',
        'class' => 'form-control',
        'type' => 'date',
        'value' => $presupuesto->modified ? $presupuesto->modified->format('Y-m-d') : date('Y-m-d'),
    ]) ?>
</div>

<!-- notas -->
<div class="col-md-10 mb-3">
<?= $this->Form->control('notas', [
    'label' => 'Observaciones',
    'type' => 'text',
    'class' => 'form-control',
    'value' => $presupuesto->notas ? $presupuesto->notas : '',
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
                    <?php foreach ($presupuesto->presupuestos_tratamientos as $index => $tratamiento): ?>
                    <tr>
                        <!-- Campo ID oculto -->
                        <?= $this->Form->control("tratamientos.$index.id", [
                            'type' => 'hidden',
                            'value' => $tratamiento->id,
                        ]) ?>
                
                        <!-- Campo de cantidad -->
                        <td>
                            <?= $this->Form->control("tratamientos.$index.cantidad", [
                                'type' => 'number',
                                'value' => $tratamiento->cantidad,
                                'min' => 1,
                                'class' => 'form-control cantidad',
                                'label' => false,
                            ]) ?>
                        </td>
                
                        <!-- Campo de búsqueda para tratamiento -->
                        <td>
                            <input type="text" name="tratamientos[<?= $index ?>][tratamiento_name]" 
                                   class="form-control tratamiento-search" 
                                   placeholder="Escriba para buscar tratamiento"
                                   value="<?= h($tratamiento->tratamiento->nombre) ?>" 
                                   autocomplete="off">
                
                            <input type="hidden" name="tratamientos[<?= $index ?>][tratamiento_id]" 
                                   class="tratamiento-id" 
                                   value="<?= $tratamiento->tratamiento_id ?>">
                
                            <ul class="tratamiento-suggestions" 
                                style="list-style-type: none; padding-left: 0; margin-top: 5px; max-height: 150px; overflow-y: auto;">
                                <?php foreach ($tratamientosData as $t): ?>
                                    <li class="tratamiento-item" data-id="<?= $t['id'] ?>" 
                                        data-name="<?= h($t['nombre']) ?>" 
                                        data-precio="<?= $t['costo'] ?>">
                                        <?= h($t['nombre']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                
                        <!-- Campo de precio unitario -->
                        <td>
                            <?= $this->Form->control("tratamientos.$index.precio_unitario", [
                                'type' => 'number',
                                'value' => $tratamiento->precio_unitario,
                                'class' => 'form-control precio-unitario',
                                'step' => '0.01',
                                'min' => 0,
                                'label' => false,
                            ]) ?>
                        </td>
                
                        <!-- Campo de subtotal -->
                        <td>
                            <?= $this->Form->control("tratamientos.$index.total", [
                                'type' => 'text',
                                'value' => $tratamiento->total,
                                'class' => 'form-control subtotal',
                                'readonly' => true,
                                'label' => false,
                            ]) ?>
                        </td>
                
                        <!-- Botón Eliminar -->
                        <td>
                            <button type="button" class="btn btn-danger" onclick="removeRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
        
        <?= $this->Form->button(__('Guardar Presupuesto'), ['class' => 'btn btn-info']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary me-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- Datos en formato JSON para JS -->
<script>
    const pacientesData = <?= json_encode($pacientesData) ?>;
    const pacientesData2 = <?= json_encode($pacientesData2) ?>;
    const tratamientosData = <?= json_encode($tratamientosData) ?>;
</script>

<?= $this->Html->script('presupuestos.js') ?>


<div class="container mt-4 mb-4">
    <?= $this->Form->create($odontograma, ['class' => 'row g-3', 'id' => 'formAgregarOdontograma']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user"></i> Agregar Odontograma</h3>
    </div>

    <!-- Buscador de Paciente -->
    <!-- <div class="col-md-10 mx-auto mb-3">
        <label for="searchPaciente" class="form-label">Buscar Paciente</label>
        <div class="input-group">
            <?= $this->Form->text('search_paciente', [
                'label' => false,
                'class' => 'form-control',
                'id' => 'searchPaciente',
                'placeholder' => 'Ingrese el nombre o apellido del paciente',
            ]) ?>
            <button type="button" id="searchButton" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
        <div id="pacienteResults" class="list-group mt-2"></div>
        <?= $this->Form->hidden('paciente_id', ['id' => 'pacienteId', 'required' => true]) ?>
    </div> -->
    <!-- Campo oculto para paciente_id si ya se pasa desde la URL -->
    <?php if (!empty($odontograma->paciente_id)) : ?>
        <?= $this->Form->hidden('paciente_id', ['value' => $odontograma->paciente_id]) ?>
    <?php else : ?>
        <!-- Buscador de Paciente (se muestra solo si paciente_id no está predefinido) -->
        <div class="col-md-10 mx-auto mb-3">
            <label for="searchPaciente" class="form-label">Buscar Paciente</label>
            <div class="input-group">
                <?= $this->Form->text('search_paciente', [
                    'label' => false,
                    'class' => 'form-control',
                    'id' => 'searchPaciente',
                    'placeholder' => 'Ingrese el nombre o apellido del paciente',
                ]) ?>
                <button type="button" id="searchButton" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
            <div id="pacienteResults" class="list-group mt-2"></div>
            <?= $this->Form->hidden('paciente_id', ['id' => 'pacienteId', 'required' => true]) ?>
        </div>
    <?php endif; ?>


    <!-- Tipo de Odontograma -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('tipo', [
            'type' => 'select',
            'options' => [
                'adulto' => 'Adulto',
                'nino' => 'Niño',
                'mixto' => 'Mixto'
            ],
            'label' => 'Tipo de Odontograma',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Campo para el título -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('titulo', [
            'type' => 'text',
            'label' => 'Título',
            'maxlength' => 50,
            'placeholder' => 'Ingresa un título',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Timestamps (ocultos, manejados automáticamente) -->
    <?= $this->Form->hidden('created_at', ['value' => date('Y-m-d H:i:s')]) ?>
    <?= $this->Form->hidden('updated_at', ['value' => date('Y-m-d H:i:s')]) ?>

    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Odontograma'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
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

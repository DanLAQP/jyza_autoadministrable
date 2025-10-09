<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ArchivosPaciente $archivosPaciente
 * @var \Cake\Collection\CollectionInterface|string[] $pacientes
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($archivosPaciente, ['type' => 'file', 'class' => 'row g-3']) ?>

    <!-- Título -->
    <div class="col-md-10 mx-auto mb-3">
        <h3 class="text-info"><i class="fas fa-file-upload"></i> Subir Archivo de Paciente</h3>
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
        <?= $this->Form->hidden('paciente_id', ['id' => 'pacienteId']) ?>
    </div> -->
<!-- Buscador de Paciente o Campo Oculto -->
<?php if (!empty($archivosPaciente->paciente_id)) : ?>
    <?= $this->Form->hidden('paciente_id', ['value' => $archivosPaciente->paciente_id]) ?>
<?php else : ?>
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

    <!-- Selección de Tipo -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('tipo', [
            'type' => 'select',
            'options' => ['radiografia' => 'Radiografía', 'foto_avance' => 'Foto de Avance'],
            'label' => 'Tipo de Archivo',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Subida de Archivo -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('ruta_archivo', [
            'type' => 'file',
            'label' => 'Archivo',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Campo Descripción -->
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'type' => 'text', // Se asegura que sea un input normal
            'class' => 'form-control',
            'placeholder' => 'Detalles adicionales sobre el archivo',
        ]) ?>
    </div>


    <!-- Botones -->
    <div class="col-12 text-center mt-3">
        <?= $this->Form->button(__('Guardar Archivo'), ['class' => 'btn btn-info', 'id' => 'submitButton']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
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

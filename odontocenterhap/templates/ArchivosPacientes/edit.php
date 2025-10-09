<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ArchivosPaciente $archivosPaciente
 * @var string[]|\Cake\Collection\CollectionInterface $pacientes
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($archivosPaciente, ['type' => 'file', 'class' => 'row g-3']) ?>

    <!-- Título -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-file-upload"></i> Editar Archivo del Paciente</h3>
    </div>

    <!-- Selección de Paciente -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('paciente_id', [
            'options' => $pacientes,
            'label' => 'Paciente',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Selección de Tipo -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('tipo', [
            'type' => 'select',
            'options' => ['radiografia' => 'Radiografía', 'foto_avance' => 'Foto de Avance'],
            'label' => 'Tipo de Archivo',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Subida de Archivo -->
    <div class="col-md-12 mb-3">
        <?= $this->Form->control('ruta_archivo', [
            'type' => 'file',
            'label' => 'Archivo (deja vacío para no cambiar)',
            'class' => 'form-control',
        ]) ?>
    </div>

    <!-- Campo Descripción -->
    <div class="col-md-12 mb-3">
        <?= $this->Form->control('descripcion', [
            'label' => 'Descripción',
            'type' => 'text', // Se asegura que sea un input normal
            'class' => 'form-control',
            'placeholder' => 'Detalles adicionales sobre el archivo',
        ]) ?>
    </div>


    <!-- Botones -->
    <div class="col-12 text-center mt-3">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

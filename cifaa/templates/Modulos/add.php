<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Modulo $modulo
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 */
?>
<div class="container mt-4 mb-4">
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-layer-group"></i> Agregar Módulo</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?= $this->Form->create($modulo, ['class' => 'row g-3']) ?>
            <div class="col-12 mb-3">
                <?= $this->Form->control('curso_id', [
                    'label' => 'Curso',
                    'class' => 'form-control',
                    'options' => $cursos
                ]) ?>
            </div>
            <div class="col-12 mb-3">
                <?= $this->Form->control('titulo', [
                    'label' => 'Título del Módulo',
                    'class' => 'form-control',
                    'placeholder' => 'Ej: Introducción, Módulo 1, etc.'
                ]) ?>
            </div>
            <div class="col-12 mb-3">
                <?= $this->Form->control('posicion', [
                    'label' => 'Posición',
                    'class' => 'form-control',
                    'type' => 'number',
                    'min' => 1
                ]) ?>
            </div>
            <div class="col-12 text-center">
                <?= $this->Form->button(__('Guardar Módulo'), ['class' => 'btn btn-info']) ?>
                <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

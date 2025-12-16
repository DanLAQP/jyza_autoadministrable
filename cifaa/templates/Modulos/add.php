<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Modulo $modulo
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 * @var iterable<\App\Model\Entity\Modulo>|null $modulosExistentes
 * @var int|null $siguientePosicion
 */
?>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($modulo, ['class' => 'row g-3']) ?>
    
    <!-- Información del Módulo -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-layer-group"></i> Agregar Módulo</h3>
    </div>

    <!-- Campo: Curso -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('curso_id', [
            'label' => 'Curso',
            'class' => 'form-control',
            'type' => 'select',
            'options' => $cursos,
            'empty' => '-- Seleccione un curso --',
            'required' => true
        ]) ?>
        <small class="form-text text-muted">Selecciona el curso al que pertenece este módulo.</small>
    </div>

    <!-- Campo: Título del Módulo -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('titulo', [
            'label' => 'Título del Módulo',
            'class' => 'form-control',
            'placeholder' => 'Ej: Introducción, Fundamentos, etc.',
            'required' => true
        ]) ?>
        <small class="form-text text-muted">Nombre descriptivo del módulo.</small>
    </div>

    <!-- Campo: Posición -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('posicion', [
            'label' => 'Posición',
            'type' => 'number',
            'class' => 'form-control',
            'min' => 1,
            'required' => true
        ]) ?>
        <small class="form-text text-muted">
            Orden del módulo en el curso.
            <?php if (isset($siguientePosicion)): ?>
                Sugerido: <?= $siguientePosicion ?>
            <?php endif; ?>
        </small>
    </div>

    <!-- Módulos Existentes -->
    <?php if (isset($modulosExistentes) && !$modulosExistentes->isEmpty()): ?>
        <div class="col-12 mt-4">
            <h5 class="text-info mb-3"><i class="fas fa-list"></i> Módulos Existentes (<?= $modulosExistentes->count() ?>)</h5>
            <div class="row g-2">
                <?php foreach ($modulosExistentes as $mod): ?>
                    <div class="col-12">
                        <div class="card bg-dark border-secondary p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-3"><?= $mod->posicion ?></span>
                                    <strong class="text-light"><?= h($mod->titulo) ?></strong>
                                </div>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $mod->id],
                                    ['class' => 'btn btn-sm btn-warning openModal', 'escape' => false, 'title' => 'Editar módulo']
                                ) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Botones -->
    <div class="col-12 text-center mt-4">
        <?= $this->Form->button(__('Guardar Módulo'), ['class' => 'btn btn-info']) ?>
        <?= $this->Html->link(
            __('Cancelar'),
            ['action' => 'index', '?' => isset($cursoId) ? ['curso_id' => $cursoId] : []],
            ['class' => 'btn btn-secondary ms-2']
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<!-- CSS para placeholder visible y selects diferenciados -->
<style>
    .form-control::placeholder {
        color: #6c757d !important;
        opacity: 1;
    }
    
    .form-control:focus::placeholder {
        color: #6c757d !important;
    }
    
    /* Mejorar visual de los select */
    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22%3E%3Cpath fill=%22%23495057%22 d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E');
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 24px 24px;
        padding-right: 3rem;
        cursor: pointer;
    }
    
    select.form-control:hover {
        background-color: #f8f9fa;
    }
    
    select.form-control:focus {
        background-color: #fff;
    }
</style>

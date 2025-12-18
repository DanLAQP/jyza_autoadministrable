<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Modulo $modulo
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 * @var iterable<\App\Model\Entity\Modulo>|null $modulosExistentes
 * @var int|null $siguientePosicion
 */
?>

<div class="container-fluid mt-3 mb-4">
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="text-info mb-1"><i class="fas fa-layer-group me-2"></i>Agregar Módulo</h4>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm bg-dark border-secondary">
                <div class="card-header bg-dark border-secondary" style="border-bottom: 2px solid #5dade2;">
                    <h6 class="mb-0 text-info"><i class="fas fa-plus-circle me-2"></i>Datos del Módulo</h6>
                </div>
                <div class="card-body p-3">
                    <?= $this->Form->create($modulo, ['novalidate' => true, 'class' => 'form']) ?>
                    
                    <!-- Campo: Curso -->
                    <div class="mb-2">
                        <?php if (isset($cursoId)): ?>
                            <?= $this->Form->label('curso_id', 'Curso', ['class' => 'form-label small text-muted']) ?>
                            <div class="form-control form-control-sm bg-secondary bg-opacity-25 text-light border-secondary" style="padding: 0.4rem 0.75rem;">
                                <?php
                                    $nombreCurso = 'Curso';
                                    foreach ($cursos as $id => $nombre) {
                                        if ($id == $cursoId) {
                                            $nombreCurso = $nombre;
                                            break;
                                        }
                                    }
                                ?>
                                <small><strong><?= h($nombreCurso) ?></strong></small>
                            </div>
                            <?= $this->Form->hidden('curso_id', ['value' => $cursoId]) ?>
                        <?php else: ?>
                            <?= $this->Form->label('curso_id', 'Curso', ['class' => 'form-label small text-muted']) ?>
                            <?= $this->Form->select(
                                'curso_id',
                                $cursos,
                                [
                                    'class' => 'form-select form-select-sm',
                                    'empty' => '-- Selecciona un curso --',
                                    'required' => true
                                ]
                            ) ?>
                        <?php endif; ?>
                    </div>

                    <!-- Campo: Título del Módulo -->
                    <div class="mb-2">
                        <?= $this->Form->label('titulo', 'Título', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->text(
                            'titulo',
                            [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'Ej: Introducción, Fundamentos...',
                                'required' => true,
                                'maxlength' => 255
                            ]
                        ) ?>
                    </div>

                    <!-- Campo: Posición -->
                    <div class="mb-3">
                        <?= $this->Form->label('posicion', 'Posición', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->number(
                            'posicion',
                            [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => '1',
                                'required' => true,
                                'min' => 1
                            ]
                        ) ?>
                        <?php if (isset($siguientePosicion)): ?>
                            <small class="text-muted d-block mt-1">Sugerido: <?= $siguientePosicion ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-info flex-grow-1">
                            <i class="fas fa-save me-1"></i> Guardar
                        </button>
                        <!-- <?= $this->Html->link(
                            '<i class="fas fa-times me-1"></i>Cancelar',
                            ['action' => 'index', '?' => isset($cursoId) ? ['curso_id' => $cursoId] : []],
                            ['class' => 'btn btn-sm btn-secondary', 'escape' => false]
                        ) ?> -->
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        
        <!-- Lista de módulos existentes -->
        <div class="col-lg-5">
            <div id="modulos-existentes-container">
                <?php if (isset($modulosExistentes) && !$modulosExistentes->isEmpty()): ?>
                    <div class="card border-0 shadow-sm bg-dark border-secondary">
                        <div class="card-header bg-dark border-secondary p-2" style="border-bottom: 2px solid #5dade2;">
                            <h6 class="mb-0 text-info" style="font-size: 0.9rem;">
                                <i class="fas fa-list me-2"></i>Módulos (<?= $modulosExistentes->count() ?>)
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($modulosExistentes as $mod): ?>
                                    <div class="list-group-item bg-dark border-secondary p-2">
                                        <div class="mb-0">
                                            <span class="badge bg-info me-2" style="font-size: 0.7rem;"><?= $mod->posicion ?></span>
                                            <span class="text-light" style="font-size: 0.85rem;"><strong><?= h($mod->titulo) ?></strong></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i>No hay módulos existentes.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- CSS para mejorar visual -->
<style>
    .form-control::placeholder {
        color: #8eb4d6 !important;
        opacity: 1;
    }
    
    .form-control:focus::placeholder {
        color: #8eb4d6 !important;
    }
    
    /* Mejorar visual de los select */
    select.form-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22%3E%3Cpath fill=%22%23495057%22 d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E');
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 24px 24px;
        padding-right: 3rem;
        cursor: pointer;
    }
</style>

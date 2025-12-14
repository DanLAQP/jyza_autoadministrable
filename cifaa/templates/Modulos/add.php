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
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-info"><i class="fas fa-layer-group"></i> Agregar Nuevo Módulo</h3>
            <p class="text-muted">Completa los datos para crear un nuevo módulo</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="card shadow-sm bg-dark border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Datos del Módulo</h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($modulo) ?>
                    
                    <div class="mb-3">
                        <?= $this->Form->control('curso_id', [
                            'label' => ['text' => '<i class="fas fa-book"></i> Curso', 'escape' => false],
                            'class' => 'form-select form-select-lg',
                            'options' => $cursos,
                            'required' => true
                        ]) ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= $this->Form->control('titulo', [
                            'label' => ['text' => '<i class="fas fa-heading"></i> Título del Módulo', 'escape' => false],
                            'class' => 'form-control form-control-lg',
                            'placeholder' => 'Ej: Introducción, Fundamentos, Módulo 1, etc.',
                            'required' => true
                        ]) ?>
                    </div>
                    
                    <div class="mb-3">
                        <?= $this->Form->control('posicion', [
                            'label' => ['text' => '<i class="fas fa-sort-numeric-up"></i> Posición', 'escape' => false],
                            'class' => 'form-control form-control-lg',
                            'type' => 'number',
                            'min' => 1,
                            'required' => true
                        ]) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Define el orden en que aparecerá este módulo
                            <?php if (isset($siguientePosicion)): ?>
                                (Sugerido: <?= $siguientePosicion ?>)
                            <?php endif; ?>
                        </small>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="fas fa-save"></i> Guardar Módulo
                        </button>
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'index', '?' => isset($cursoId) ? ['curso_id' => $cursoId] : []],
                            ['class' => 'btn btn-secondary btn-lg ms-2', 'escape' => false]
                        ) ?>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        
        <!-- Lista de módulos existentes -->
        <div class="col-lg-5">
            <?php if (isset($modulosExistentes) && !$modulosExistentes->isEmpty()): ?>
                <div class="card shadow-sm bg-dark border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Módulos Existentes
                            <span class="badge bg-light text-dark"><?= $modulosExistentes->count() ?></span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($modulosExistentes as $mod): ?>
                                <div class="list-group-item list-group-item-dark d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <span class="badge bg-primary me-2">#<?= $mod->posicion ?></span>
                                            <?= h($mod->titulo) ?>
                                        </div>
                                    </div>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-edit"></i>',
                                        ['action' => 'edit', $mod->id],
                                        ['class' => 'btn btn-sm btn-warning', 'escape' => false, 'title' => 'Editar']
                                    ) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Este será el primer módulo del curso
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

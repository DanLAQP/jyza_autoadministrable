<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 * 
 * IMPORTANTE: Esta vista es SOLO para Admin/Docente.
 * Los estudiantes solicitan inscripción desde la vista del curso (CursosController::solicitar).
 */
?>
<div class="container mt-4 mb-4">
    <?= $this->Form->create($inscripcione, ['class' => 'row g-3']) ?>
    
    <!-- Título de la sección -->
    <div class="col-12 mb-4">
        <h3 class="text-info">
            <i class="fas fa-user-plus"></i> 
            <?= __('Nueva Inscripción') ?>
        </h3>
        <p class="text-muted">
            <?= __('Crea una nueva inscripción para un estudiante. Puedes establecer el estado inicial y el progreso.') ?>
        </p>
    </div>

    <!-- Campo: Usuario/Estudiante -->
    <div class="col-md-6 mb-3">
        <label for="usuario-id" class="form-label">
            <i class="fas fa-user"></i> Estudiante <span class="text-danger">*</span>
        </label>
        <?= $this->Form->control('usuario_id', [
            'options' => $users,
            'class' => 'form-control',
            'label' => false,
            'required' => true,
            'empty' => '-- Seleccione un estudiante --'
        ]) ?>
        <small class="form-text text-muted">Solo aparecen usuarios con rol de estudiante.</small>
    </div>

    <!-- Campo: Curso -->
    <div class="col-md-6 mb-3">
        <label for="curso-id" class="form-label">
            <i class="fas fa-book"></i> Curso <span class="text-danger">*</span>
        </label>
        <?= $this->Form->control('curso_id', [
            'options' => $cursos,
            'class' => 'form-control',
            'label' => false,
            'required' => true,
            'empty' => '-- Seleccione un curso --'
        ]) ?>
    </div>

    <!-- Campo: Estado -->
    <div class="col-md-6 mb-3">
        <label for="estado" class="form-label">
            <i class="fas fa-info-circle"></i> Estado
        </label>
        <?= $this->Form->control('estado', [
            'options' => [
                'pendiente' => 'Pendiente',
                'aprobada' => 'Aprobada',
                'rechazada' => 'Rechazada'
            ],
            'class' => 'form-control',
            'label' => false,
            'default' => 'pendiente'
        ]) ?>
        <small class="form-text text-muted">Estado inicial de la inscripción.</small>
    </div>

    <!-- Campo: Progreso -->
    <div class="col-md-6 mb-3">
        <label for="progreso" class="form-label">
            <i class="fas fa-chart-line"></i> Progreso (%)
        </label>
        <?= $this->Form->control('progreso', [
            'type' => 'number',
            'class' => 'form-control',
            'label' => false,
            'min' => 0,
            'max' => 100,
            'default' => 0
        ]) ?>
        <small class="form-text text-muted">Valor entre 0 y 100.</small>
    </div>

    <!-- Botones de acción -->
    <div class="col-12 mt-4">
        <div class="d-flex gap-2">
            <?= $this->Form->button(__('Guardar Inscripción'), [
                'class' => 'btn btn-primary',
                'escape' => false
            ]) ?>
            <?= $this->Html->link(
                '<i class="fas fa-times"></i> ' . __('Cancelar'),
                ['action' => 'index'],
                ['class' => 'btn btn-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    
    .text-danger {
        font-size: 0.875rem;
    }
    
    .btn i {
        margin-right: 5px;
    }
</style>

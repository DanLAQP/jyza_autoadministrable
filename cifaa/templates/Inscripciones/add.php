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
$usuario = $this->getRequest()->getAttribute('identity');
?>
<div class="container mt-4 mb-4">
    <?php if (!$usuario || ($usuario->rol != 1 && $usuario->rol != 2)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> No tienes permisos para crear inscripciones.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php else: ?>
        <?= $this->Form->create($inscripcione, ['class' => 'row g-3']) ?>
        
        <!-- Información de la Inscripción -->
        <div class="col-12 mb-4">
            <h3 class="text-info"><i class="fas fa-user-plus"></i> Agregar Inscripción</h3>
        </div>
        
        <!-- Campo: Usuario/Estudiante -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('usuario_id', [
                'label' => 'Estudiante',
                'class' => 'form-control',
                'type' => 'select',
                'options' => $users,
                'empty' => '-- Seleccione un estudiante --',
                'required' => true
            ]) ?>
            <small class="form-text text-muted">Solo aparecen usuarios con rol de estudiante.</small>
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
        </div>

        <!-- Campo: Estado -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('estado', [
                'label' => 'Estado',
                'class' => 'form-control',
                'type' => 'select',
                'options' => [
                    'pendiente' => 'Pendiente',
                    'aprobada' => 'Aprobada',
                    'rechazada' => 'Rechazada'
                ],
                'default' => 'pendiente',
                'required' => true
            ]) ?>
            <small class="form-text text-muted">Estado inicial de la inscripción.</small>
        </div>

        <!-- Campo: Progreso -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('progreso', [
                'label' => 'Progreso (%)',
                'type' => 'number',
                'class' => 'form-control',
                'min' => 0,
                'max' => 100,
                'value' => 0,
                'required' => true
            ]) ?>
            <small class="form-text text-muted">Valor entre 0 y 100.</small>
        </div>

        <!-- Botones -->
        <div class="col-12 text-center">
            <?= $this->Form->button(__('Guardar Inscripción'), ['class' => 'btn btn-info']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
        </div>
        
        <?= $this->Form->end() ?>
    <?php endif; ?>
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

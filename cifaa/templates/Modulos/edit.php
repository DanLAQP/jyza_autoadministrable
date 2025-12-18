<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Modulo $modulo
 * @var string[]|\Cake\Collection\CollectionInterface $cursos
 */
?>

<div class="container-fluid mt-3 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="row mb-3">
                <div class="col-12">
                    <h4 class="text-warning mb-1"><i class="fas fa-edit me-2"></i>Editar Módulo</h4>
                </div>
            </div>
            
            <!-- Formulario -->
            <div class="card border-0 shadow-sm bg-dark border-secondary">
                <div class="card-header bg-dark border-secondary" style="border-bottom: 2px solid #5dade2;">
                    <h6 class="mb-0 text-warning"><i class="fas fa-edit me-2"></i>Datos del Módulo</h6>
                </div>
                <div class="card-body p-3">
                    <?= $this->Form->create($modulo, ['novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-2">
                        <?= $this->Form->label('curso_id', 'Curso', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->select(
                            'curso_id',
                            $cursos,
                            [
                                'class' => 'form-select form-select-sm',
                                'required' => true,
                                'empty' => false
                            ]
                        ) ?>
                    </div>

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
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-warning flex-grow-1">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                        <!-- <?= $this->Html->link(
                            '<i class="fas fa-times me-1"></i>Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-sm btn-secondary', 'escape' => false]
                        ) ?> -->
                    </div>

                    <?= $this->Form->end() ?>
                </div>
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

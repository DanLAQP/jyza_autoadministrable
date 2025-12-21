<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leccione $leccione
 * @var string[]|\Cake\Collection\CollectionInterface $modulos
 */
?>

<div class="container-fluid mt-3 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="row mb-3">
                <div class="col-12">
                    <h4 class="text-warning mb-1"><i class="fas fa-edit me-2"></i>Editar Lección</h4>
                </div>
            </div>
            
            <!-- Formulario -->
            <div class="card border-0 shadow-sm bg-dark border-secondary">
                <div class="card-header bg-dark border-secondary" style="border-bottom: 2px solid #5dade2;">
                    <h6 class="mb-0 text-warning"><i class="fas fa-edit me-2"></i>Datos de la Lección</h6>
                </div>
                <div class="card-body p-3">
                    <?= $this->Form->create($leccione, ['novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-2">
                        <?= $this->Form->label('modulo_id', 'Módulo', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->select(
                            'modulo_id',
                            $modulos,
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
                                'placeholder' => 'Ej: Introducción a HTML...',
                                'required' => true,
                                'maxlength' => 255
                            ]
                        ) ?>
                    </div>

                    <div class="mb-2">
                        <?= $this->Form->label('descripcion', 'Descripción', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->textarea(
                            'descripcion',
                            [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'Descripción de la lección (opcional)',
                                'rows' => 3
                            ]
                        ) ?>
                        <small class="text-muted d-block mt-1">Texto adicional sobre el contenido de esta lección</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <?= $this->Form->label('tipo_contenido', 'Tipo Contenido', ['class' => 'form-label small text-muted']) ?>
                            <?= $this->Form->select(
                                'tipo_contenido',
                                [
                                    'video' => 'Video',
                                    'texto' => 'Texto',
                                    'imagen' => 'Imagen',
                                    'quiz' => 'Quiz'
                                ],
                                [
                                    'class' => 'form-select form-select-sm',
                                    'required' => true,
                                    'empty' => false
                                ]
                            ) ?>
                        </div>

                        <div class="col-md-6 mb-3">
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
                    </div>

                    <div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-3" style="font-size: 0.8rem;">
                        <small><i class="fas fa-info-circle me-1"></i>Creado: <?= $leccione->created->format('d/m/Y H:i') ?> | Actualizado: <?= $leccione->modified->format('d/m/Y H:i') ?></small>
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

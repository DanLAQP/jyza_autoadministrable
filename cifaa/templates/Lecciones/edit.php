<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leccione $leccione
 * @var string[]|\Cake\Collection\CollectionInterface $modulos
 */
?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Lección</h4>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($leccione, ['novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-3">
                        <?= $this->Form->label('modulo_id', 'Módulo *') ?>
                        <?= $this->Form->select(
                            'modulo_id',
                            $modulos,
                            [
                                'class' => 'form-control form-control-lg',
                                'required' => true
                            ]
                        ) ?>
                        <small class="form-text text-muted">Selecciona el módulo al que pertenece esta lección</small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('titulo', 'Título de la Lección *') ?>
                        <?= $this->Form->text(
                            'titulo',
                            [
                                'class' => 'form-control form-control-lg',
                                'placeholder' => 'Ej: Introducción a HTML',
                                'required' => true,
                                'maxlength' => 255
                            ]
                        ) ?>
                        <small class="form-text text-muted">Nombre descriptivo de la lección</small>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <?= $this->Form->label('tipo_contenido', 'Tipo de Contenido *') ?>
                            <?= $this->Form->select(
                                'tipo_contenido',
                                [
                                    'video' => 'Video',
                                    'texto' => 'Texto',
                                    'imagen' => 'Imagen',
                                    'quiz' => 'Quiz'
                                ],
                                [
                                    'class' => 'form-control form-control-lg',
                                    'required' => true
                                ]
                            ) ?>
                            <small class="form-text text-muted">Formato del contenido</small>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->label('posicion', 'Posición *') ?>
                            <?= $this->Form->number(
                                'posicion',
                                [
                                    'class' => 'form-control form-control-lg',
                                    'placeholder' => 'Ej: 1',
                                    'required' => true,
                                    'min' => 1
                                ]
                            ) ?>
                            <small class="form-text text-muted">Orden en el módulo</small>
                        </div>
                    </div>

                    <div class="alert alert-info mb-3">
                        <small><i class="fas fa-info-circle"></i> Creado: <?= $leccione->created->format('d/m/Y H:i') ?> | Actualizado: <?= $leccione->modified->format('d/m/Y H:i') ?></small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
                        <?= $this->Html->link(
                            'Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary btn-lg', 'escape' => false]
                        ) ?>
                        <?= $this->Form->submit(
                            'Guardar Cambios',
                            [
                                'class' => 'btn btn-primary btn-lg',
                                'icon' => '<i class="fas fa-save"></i> '
                            ]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

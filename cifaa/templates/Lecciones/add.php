<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leccione $leccione
 * @var \Cake\Collection\CollectionInterface|string[] $modulos
 */
?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Crear Nueva Lección</h4>
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
                                'empty' => '-- Selecciona un módulo --',
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
                                    'empty' => '-- Selecciona tipo --',
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

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary btn-lg', 'escape' => false]
                        ) ?>
                        <?= $this->Form->submit(
                            'Crear Lección',
                            [
                                'class' => 'btn btn-primary btn-lg',
                                'icon' => '<i class="fas fa-check-circle"></i> '
                            ]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

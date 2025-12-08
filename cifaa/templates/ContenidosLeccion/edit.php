<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContenidosLeccion $contenidosLeccion
 * @var string[]|\Cake\Collection\CollectionInterface $lecciones
 * @var mixed $leccionId
 */
?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Contenido</h4>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($contenidosLeccion, ['type' => 'file', 'novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-3">
                        <?= $this->Form->label('leccion_id', 'Lección *') ?>
                        <?= $this->Form->select(
                            'leccion_id',
                            $lecciones,
                            [
                                'class' => 'form-control form-control-lg',
                                'required' => true
                            ]
                        ) ?>
                        <small class="form-text text-muted">Selecciona la lección a la que pertenece este contenido</small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('tipo', 'Tipo de Contenido *') ?>
                        <?= $this->Form->select(
                            'tipo',
                            [
                                'video' => 'Video',
                                'texto' => 'Texto',
                                'imagen' => 'Imagen',
                                'pdf' => 'Archivo PDF',
                                'documento' => 'Documento Word/Excel'
                            ],
                            [
                                'class' => 'form-control form-control-lg',
                                'required' => true
                            ]
                        ) ?>
                        <small class="form-text text-muted">Tipo de contenido que vas a cargar</small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('contenido', 'Contenido (Texto)') ?>
                        <?= $this->Form->textarea(
                            'contenido',
                            [
                                'class' => 'form-control form-control-lg',
                                'rows' => 5,
                                'placeholder' => 'Ej: Descripción del contenido, enlace del video (YouTube, Vimeo), etc.'
                            ]
                        ) ?>
                        <small class="form-text text-muted">Para videos: puedes pegar el link de YouTube o la descripción. Para texto: ingresa el contenido aquí</small>
                    </div>

                    <?php if ($contenidosLeccion->archivo): ?>
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-file"></i> 
                            <strong>Archivo actual:</strong> 
                            <a href="<?= $this->Url->assetUrl($contenidosLeccion->archivo) ?>" target="_blank" class="alert-link">
                                <?= basename($contenidosLeccion->archivo) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <?= $this->Form->label('archivo', 'Nuevo Archivo (Opcional)') ?>
                        <?= $this->Form->file(
                            'archivo',
                            [
                                'class' => 'form-control form-control-lg',
                                'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.mp4,.webm'
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Formatos permitidos: 
                            PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, WEBP, MP4, WEBM
                        </small>
                    </div>

                    <div class="mb-3">
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
                        <small class="form-text text-muted">Orden en el que aparecerá este contenido</small>
                    </div>

                    <div class="alert alert-info mb-3">
                        <small>
                            <i class="fas fa-history"></i>
                            Creado: <?= $contenidosLeccion->created->format('d/m/Y H:i') ?> | 
                            Actualizado: <?= $contenidosLeccion->modified->format('d/m/Y H:i') ?>
                        </small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i> Eliminar',
                            ['action' => 'delete', $contenidosLeccion->id],
                            ['confirm' => '¿Estás seguro de que deseas eliminar este contenido?', 'class' => 'btn btn-danger btn-lg', 'escape' => false]
                        ) ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
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

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContenidosLeccion $contenidosLeccion
 * @var \Cake\Collection\CollectionInterface|string[] $lecciones
 * @var mixed $leccionId
 */
?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Agregar Contenido a la Lección</h4>
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
                                'empty' => '-- Selecciona una lección --',
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
                                'empty' => '-- Selecciona tipo --',
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

                    <div class="mb-3">
                        <?= $this->Form->label('archivo', 'Archivo') ?>
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

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary btn-lg', 'escape' => false]
                        ) ?>
                        <?= $this->Form->submit(
                            'Guardar Contenido',
                            [
                                'class' => 'btn btn-success btn-lg',
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const archivo = document.querySelector('input[name="archivo"]');
        
        archivo?.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                const maxSize = 100 * 1024 * 1024; // 100MB
                
                if (file.size > maxSize) {
                    alert('El archivo no puede exceder 100MB');
                    this.value = '';
                    return;
                }
                
                // Mostrar información del archivo
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                console.log(`Archivo: ${file.name}, Tamaño: ${sizeInMB}MB`);
            }
        });
    });
</script>

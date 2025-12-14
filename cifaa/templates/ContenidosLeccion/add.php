<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContenidosLeccion $contenidosLeccion
 * @var \Cake\Collection\CollectionInterface|string[] $lecciones
 * @var iterable<\App\Model\Entity\ContenidosLeccion>|null $contenidosExistentes
 * @var int|null $siguientePosicion
 * @var mixed $leccionId
 */
?>

<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-success"><i class="fas fa-file-alt"></i> Agregar Nuevo Contenido</h3>
            <p class="text-muted">Completa los datos para agregar contenido a una lección</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm bg-dark border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Datos del Contenido</h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($contenidosLeccion, ['type' => 'file', 'novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-3">
                        <?= $this->Form->label('leccion_id', '<i class="fas fa-chalkboard-teacher"></i> Lección *', ['escape' => false]) ?>
                        <?= $this->Form->select(
                            'leccion_id',
                            $lecciones,
                            [
                                'class' => 'form-select form-select-lg',
                                'empty' => '-- Selecciona una lección --',
                                'required' => true
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Selecciona la lección a la que pertenece este contenido
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('tipo', '<i class="fas fa-tag"></i> Tipo de Contenido *', ['escape' => false]) ?>
                        <?= $this->Form->select(
                            'tipo',
                            [
                                'video' => '📹 Video',
                                'texto' => '📄 Texto',
                                'imagen' => '🖼️ Imagen',
                                'pdf' => '📕 Archivo PDF',
                                'documento' => '📝 Documento Word/Excel'
                            ],
                            [
                                'class' => 'form-select form-select-lg',
                                'empty' => '-- Selecciona tipo --',
                                'required' => true
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Tipo de contenido que vas a cargar
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('contenido', '<i class="fas fa-edit"></i> Contenido (Texto)', ['escape' => false]) ?>
                        <?= $this->Form->textarea(
                            'contenido',
                            [
                                'class' => 'form-control form-control-lg',
                                'rows' => 6,
                                'placeholder' => 'Ej: Descripción del contenido, enlace del video (YouTube, Vimeo), etc.'
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Para videos: link de YouTube o descripción. Para texto: ingresa el contenido aquí
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('archivo', '<i class="fas fa-paperclip"></i> Archivo', ['escape' => false]) ?>
                        <?= $this->Form->file(
                            'archivo',
                            [
                                'class' => 'form-control form-control-lg',
                                'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.mp4,.webm',
                                'id' => 'archivo-input'
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-file-upload"></i> Formatos: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, WEBP, MP4, WEBM (Máx. 50MB)
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('posicion', '<i class="fas fa-sort-numeric-up"></i> Posición *', ['escape' => false]) ?>
                        <?= $this->Form->number(
                            'posicion',
                            [
                                'class' => 'form-control form-control-lg',
                                'placeholder' => 'Ej: 1',
                                'required' => true,
                                'min' => 1
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Orden en el que aparecerá este contenido
                            <?php if (isset($siguientePosicion)): ?>
                                (Sugerido: <?= $siguientePosicion ?>)
                            <?php endif; ?>
                        </small>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Guardar Contenido
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
        
        <!-- Lista de contenidos existentes -->
        <div class="col-lg-5">
            <div id="contenidos-existentes-container">
                <?php if (isset($contenidosExistentes) && !$contenidosExistentes->isEmpty()): ?>
                    <div class="card shadow-sm bg-dark border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-list"></i> Contenidos Existentes
                                <span class="badge bg-light text-dark"><?= $contenidosExistentes->count() ?></span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($contenidosExistentes as $cont): ?>
                                    <div class="list-group-item list-group-item-dark d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                <span class="badge bg-primary me-2">#<?= $cont->posicion ?></span>
                                                <?php
                                                $tipoIcon = match($cont->tipo) {
                                                    'video' => 'video',
                                                    'texto' => 'file-alt',
                                                    'imagen' => 'image',
                                                    'pdf' => 'file-pdf',
                                                    'documento' => 'file-word',
                                                    default => 'file'
                                                };
                                                ?>
                                                <i class="fas fa-<?= $tipoIcon ?> text-info"></i>
                                                <?= ucfirst($cont->tipo) ?>
                                            </div>
                                            <?php if ($cont->archivo): ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-paperclip"></i> <?= h($cont->archivo) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-edit"></i>',
                                            ['action' => 'edit', $cont->id],
                                            ['class' => 'btn btn-sm btn-warning', 'escape' => false, 'title' => 'Editar']
                                        ) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Selecciona una lección para ver sus contenidos
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const leccionSelect = document.querySelector('select[name="leccion_id"]');
        const posicionInput = document.querySelector('input[name="posicion"]');
        const contenidosContainer = document.getElementById('contenidos-existentes-container');
        const archivo = document.querySelector('input[name="archivo"]');
        
        // Cargar contenidos al seleccionar lección
        if (leccionSelect) {
            leccionSelect.addEventListener('change', function() {
                const leccionId = this.value;
                
                if (!leccionId) {
                    contenidosContainer.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> Selecciona una lección para ver sus contenidos</div>';
                    return;
                }
                
                // Mostrar loading
                contenidosContainer.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Cargando contenidos...</p></div>';
                
                // Cargar contenidos de la lección
                fetch(`<?= $this->Url->build(['controller' => 'ContenidosLeccion', 'action' => 'obtenerPorLeccion']) ?>?leccion_id=${leccionId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Actualizar posición sugerida
                        if (posicionInput && data.siguientePosicion) {
                            posicionInput.value = data.siguientePosicion;
                            const smallText = posicionInput.parentElement.querySelector('small');
                            if (smallText) {
                                smallText.innerHTML = `<i class="fas fa-info-circle"></i> Orden en el que aparecerá este contenido (Sugerido: ${data.siguientePosicion})`;
                            }
                        }
                        
                        // Actualizar lista de contenidos
                        if (data.contenidos && data.contenidos.length > 0) {
                            let html = `
                                <div class="card shadow-sm bg-dark border-secondary">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-list"></i> Contenidos Existentes
                                            <span class="badge bg-light text-dark">${data.contenidos.length}</span>
                                        </h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="list-group list-group-flush">`;
                            
                            data.contenidos.forEach(cont => {
                                const iconMap = {
                                    'video': 'video',
                                    'texto': 'file-alt',
                                    'imagen': 'image',
                                    'pdf': 'file-pdf',
                                    'documento': 'file-word'
                                };
                                const icon = iconMap[cont.tipo] || 'file';
                                
                                html += `
                                    <div class="list-group-item list-group-item-dark d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                <span class="badge bg-primary me-2">#${cont.posicion}</span>
                                                <i class="fas fa-${icon} text-info"></i>
                                                ${cont.tipo.charAt(0).toUpperCase() + cont.tipo.slice(1)}
                                            </div>
                                            ${cont.archivo ? `<small class="text-muted"><i class="fas fa-paperclip"></i> ${cont.archivo}</small>` : ''}
                                        </div>
                                        <a href="<?= $this->Url->build(['action' => 'edit']) ?>/${cont.id}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>`;
                            });
                            
                            html += `
                                        </div>
                                    </div>
                                </div>`;
                            
                            contenidosContainer.innerHTML = html;
                        } else {
                            contenidosContainer.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> Este será el primer contenido de la lección seleccionada</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error completo:', error);
                        contenidosContainer.innerHTML = `<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error al cargar contenidos: ${error.message}</div>`;
                    });
            });
        }
        
        // Validación de archivo
        
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

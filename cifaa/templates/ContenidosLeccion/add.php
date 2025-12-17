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

<div class="container-fluid mt-3 mb-4">
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="text-success mb-1"><i class="fas fa-file-alt me-2"></i>Agregar Contenido</h4>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm bg-dark border-secondary">
                <div class="card-header bg-dark border-secondary" style="border-bottom: 2px solid #5dade2;">
                    <h6 class="mb-0 text-success"><i class="fas fa-plus-circle me-2"></i>Datos del Contenido</h6>
                </div>
                <div class="card-body p-3">
                    <?= $this->Form->create($contenidosLeccion, ['type' => 'file', 'novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-2">
                        <?php if (isset($leccionId)): ?>
                            <?= $this->Form->label('leccion_id', 'Lección', ['class' => 'form-label small text-muted']) ?>
                            <div class="form-control form-control-sm bg-secondary bg-opacity-25 text-light border-secondary" style="padding: 0.4rem 0.75rem;">
                                <?php
                                    $nombreLeccion = 'Lección';
                                    foreach ($lecciones as $id => $nombre) {
                                        if ($id == $leccionId) {
                                            $nombreLeccion = $nombre;
                                            break;
                                        }
                                    }
                                ?>
                                <small><strong><?= h($nombreLeccion) ?></strong></small>
                            </div>
                            <?= $this->Form->hidden('leccion_id', ['value' => $leccionId]) ?>
                        <?php else: ?>
                            <?= $this->Form->label('leccion_id', 'Lección', ['class' => 'form-label small text-muted']) ?>
                            <?= $this->Form->select(
                                'leccion_id',
                                $lecciones,
                                [
                                    'class' => 'form-select form-select-sm',
                                    'empty' => '-- Selecciona una lección --',
                                    'required' => true
                                ]
                            ) ?>
                        <?php endif; ?>
                    </div>

                    <div class="mb-2">
                        <?= $this->Form->label('tipo', 'Tipo Contenido', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->select(
                            'tipo',
                            [
                                'video' => 'Video',
                                'texto' => 'Texto',
                                'imagen' => 'Imagen',
                                'pdf' => 'PDF',
                                'documento' => 'Documento'
                            ],
                            [
                                'class' => 'form-select form-select-sm',
                                'empty' => false,
                                'required' => true
                            ]
                        ) ?>
                    </div>

                    <div class="mb-2">
                        <?= $this->Form->label('contenido', 'Descripción', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->textarea(
                            'contenido',
                            [
                                'class' => 'form-control form-control-sm',
                                'rows' => 3,
                                'placeholder' => 'Ej: Link YouTube, descripción, etc.'
                            ]
                        ) ?>
                    </div>

                    <div class="mb-2">
                        <?= $this->Form->label('archivo', 'Archivo', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->file(
                            'archivo',
                            [
                                'class' => 'form-control form-control-sm',
                                'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.mp4,.webm',
                                'id' => 'archivo-input'
                            ]
                        ) ?>
                        <small class="text-muted d-block mt-1">PDF, DOC, XLSX, JPG, PNG, MP4... (Máx. 50MB)</small>
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
                        <?php if (isset($siguientePosicion)): ?>
                            <small class="text-muted d-block mt-1">Sugerido: <?= $siguientePosicion ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-success flex-grow-1">
                            <i class="fas fa-save me-1"></i> Guardar
                        </button>
                        <?= $this->Html->link(
                            '<i class="fas fa-times me-1"></i>Cancelar',
                            ['action' => 'index', '?' => isset($leccionId) ? ['leccion_id' => $leccionId] : []],
                            ['class' => 'btn btn-sm btn-secondary', 'escape' => false]
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
                    <div class="card border-0 shadow-sm bg-dark border-secondary">
                        <div class="card-header bg-dark border-secondary p-2" style="border-bottom: 2px solid #5dade2;">
                            <h6 class="mb-0 text-success" style="font-size: 0.9rem;">
                                <i class="fas fa-list me-2"></i>Contenidos (<?= $contenidosExistentes->count() ?>)
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($contenidosExistentes as $cont): ?>
                                    <div class="list-group-item bg-dark border-secondary p-2">
                                        <div class="mb-0">
                                            <span class="badge bg-success me-2" style="font-size: 0.7rem;"><?= $cont->posicion ?></span>
                                            <span class="text-light" style="font-size: 0.85rem;"><strong><?php
                                                $tipoIcon = match($cont->tipo) {
                                                    'video' => 'video',
                                                    'texto' => 'file-alt',
                                                    'imagen' => 'image',
                                                    'pdf' => 'file-pdf',
                                                    'documento' => 'file-word',
                                                    default => 'file'
                                                };
                                            ?>
                                            <i class="fas fa-<?= $tipoIcon ?> me-1"></i><?= ucfirst($cont->tipo) ?></strong></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i>No hay contenidos aún.
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
                    contenidosContainer.innerHTML = '<div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i>Selecciona lección para ver contenidos</div>';
                    return;
                }
                
                // Mostrar loading
                contenidosContainer.innerHTML = '<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i><p class="mt-2" style="font-size: 0.85rem;">Cargando...</p></div>';
                
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
                                smallText.innerHTML = `Sugerido: ${data.siguientePosicion}`;
                            }
                        }
                        
                        // Actualizar lista de contenidos
                        if (data.contenidos && data.contenidos.length > 0) {
                            let html = `
                                <div class="card border-0 shadow-sm bg-dark border-secondary">
                                    <div class="card-header bg-dark border-secondary p-2" style="border-bottom: 2px solid #5dade2;">
                                        <h6 class="mb-0 text-success" style="font-size: 0.9rem;">
                                            <i class="fas fa-list me-2"></i>Contenidos (${data.contenidos.length})
                                        </h6>
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
                                    <div class="list-group-item bg-dark border-secondary p-2">
                                        <div class="mb-0">
                                            <span class="badge bg-success me-2" style="font-size: 0.7rem;">${cont.posicion}</span>
                                            <span class="text-light" style="font-size: 0.85rem;"><strong><i class="fas fa-${icon} me-1"></i>${cont.tipo.charAt(0).toUpperCase() + cont.tipo.slice(1)}</strong></span>
                                        </div>
                                    </div>`;
                            });
                            
                            html += `
                                        </div>
                                    </div>
                                </div>`;
                            
                            contenidosContainer.innerHTML = html;
                        } else {
                            contenidosContainer.innerHTML = '<div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i>No hay contenidos aún</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        contenidosContainer.innerHTML = `<div class="alert alert-danger bg-dark text-danger p-2 mb-0" style="font-size: 0.85rem;"><i class="fas fa-exclamation-triangle me-1"></i>Error al cargar</div>`;
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

<!-- CSS para mejorar visual -->
<style>
    .form-control::placeholder {
        color: #6c757d !important;
        opacity: 1;
    }
    
    .form-control:focus::placeholder {
        color: #6c757d !important;
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

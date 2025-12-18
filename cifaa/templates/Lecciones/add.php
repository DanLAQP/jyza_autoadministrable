<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leccione $leccione
 * @var \Cake\Collection\CollectionInterface|string[] $modulos
 * @var iterable<\App\Model\Entity\Leccione>|null $leccionesExistentes
 * @var int|null $siguientePosicion
 */
?>

<div class="container-fluid mt-3 mb-4">
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="text-info mb-1"><i class="fas fa-chalkboard-teacher me-2"></i>Agregar Lección</h4>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm bg-dark border-secondary">
                <div class="card-header bg-dark border-secondary" style="border-bottom: 2px solid #5dade2;">
                    <h6 class="mb-0 text-info"><i class="fas fa-plus-circle me-2"></i>Datos de la Lección</h6>
                </div>
                <div class="card-body p-3">
                    <?= $this->Form->create($leccione, ['novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-2">
                        <?php if (isset($moduloId)): ?>
                            <?= $this->Form->label('modulo_id', 'Módulo', ['class' => 'form-label small text-muted']) ?>
                            <div class="form-control form-control-sm bg-secondary bg-opacity-25 text-light border-secondary" style="padding: 0.4rem 0.75rem;">
                                <?php
                                    $nombreModulo = 'Módulo';
                                    foreach ($modulos as $id => $nombre) {
                                        if ($id == $moduloId) {
                                            $nombreModulo = $nombre;
                                            break;
                                        }
                                    }
                                ?>
                                <small><strong><?= h($nombreModulo) ?></strong></small>
                            </div>
                            <?= $this->Form->hidden('modulo_id', ['value' => $moduloId]) ?>
                        <?php else: ?>
                            <?= $this->Form->label('modulo_id', 'Módulo', ['class' => 'form-label small text-muted']) ?>
                            <?= $this->Form->select(
                                'modulo_id',
                                $modulos,
                                [
                                    'class' => 'form-select form-select-sm',
                                    'empty' => '-- Selecciona un módulo --',
                                    'required' => true
                                ]
                            ) ?>
                        <?php endif; ?>
                    </div>

                    <div class="mb-2">
                        <?= $this->Form->label('titulo', 'Título', ['class' => 'form-label small text-muted']) ?>
                        <?= $this->Form->text(
                            'titulo',
                            [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => 'Ej: Introducción a HTML, Variables...',
                                'required' => true,
                                'maxlength' => 255
                            ]
                        ) ?>
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
                                    'empty' => false,
                                    'required' => true
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
                            <?php if (isset($siguientePosicion)): ?>
                                <small class="text-muted d-block mt-1">Sugerido: <?= $siguientePosicion ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-info flex-grow-1">
                            <i class="fas fa-save me-1"></i> Guardar
                        </button>
                        <!-- <?= $this->Html->link(
                            '<i class="fas fa-times me-1"></i>Cancelar',
                            ['action' => 'index', '?' => isset($cursoId) ? ['curso_id' => $cursoId] : []],
                            ['class' => 'btn btn-sm btn-secondary', 'escape' => false]
                        ) ?> -->
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        
        <!-- Lista de lecciones existentes -->
        <div class="col-lg-5">
            <div id="lecciones-existentes-container">
                <?php if (isset($leccionesExistentes) && !$leccionesExistentes->isEmpty()): ?>
                    <div class="card border-0 shadow-sm bg-dark border-secondary">
                        <div class="card-header bg-dark border-secondary p-2" style="border-bottom: 2px solid #5dade2;">
                            <h6 class="mb-0 text-info" style="font-size: 0.9rem;">
                                <i class="fas fa-list me-2"></i>Lecciones (<?= $leccionesExistentes->count() ?>)
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($leccionesExistentes as $lec): ?>
                                    <div class="list-group-item bg-dark border-secondary p-2">
                                        <div class="mb-0">
                                            <span class="badge bg-info me-2" style="font-size: 0.7rem;"><?= $lec->posicion ?></span>
                                            <span class="text-light" style="font-size: 0.85rem;"><strong><?= h($lec->titulo) ?></strong></span>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-<?= $lec->tipo_contenido == 'video' ? 'video' : ($lec->tipo_contenido == 'texto' ? 'file-alt' : ($lec->tipo_contenido == 'imagen' ? 'image' : 'question-circle')) ?>"></i>
                                            <?= ucfirst($lec->tipo_contenido) ?>
                                        </small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-1"></i>No hay lecciones aún.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const moduloSelect = document.querySelector('select[name="modulo_id"]');
    const posicionInput = document.querySelector('input[name="posicion"]');
    const leccionesContainer = document.getElementById('lecciones-existentes-container');
    
    if (moduloSelect) {
        moduloSelect.addEventListener('change', function() {
            const moduloId = this.value;
            
            if (!moduloId) {
                leccionesContainer.innerHTML = '<div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i>Selecciona un módulo para ver lecciones</div>';
                return;
            }
            
            leccionesContainer.innerHTML = '<div class="text-center p-3"><i class="fas fa-spinner fa-spin"></i><p class="mt-2" style="font-size: 0.85rem;">Cargando...</p></div>';
            
            fetch(`<?= $this->Url->build(['controller' => 'Lecciones', 'action' => 'obtenerPorModulo']) ?>?modulo_id=${moduloId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (posicionInput && data.siguientePosicion) {
                        posicionInput.value = data.siguientePosicion;
                        const smallText = posicionInput.parentElement.querySelector('small');
                        if (smallText) {
                            smallText.innerHTML = `Sugerido: ${data.siguientePosicion}`;
                        }
                    }
                    
                    if (data.lecciones && data.lecciones.length > 0) {
                        let html = `
                            <div class="card border-0 shadow-sm bg-dark border-secondary">
                                <div class="card-header bg-dark border-secondary p-2" style="border-bottom: 2px solid #5dade2;">
                                    <h6 class="mb-0 text-info" style="font-size: 0.9rem;">
                                        <i class="fas fa-list me-2"></i>Lecciones (${data.lecciones.length})
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">`;
                        
                        data.lecciones.forEach(lec => {
                            const iconMap = {
                                'video': 'video',
                                'texto': 'file-alt',
                                'imagen': 'image',
                                'quiz': 'question-circle'
                            };
                            const icon = iconMap[lec.tipo] || 'book';
                            
                            html += `
                                <div class="list-group-item bg-dark border-secondary p-2">
                                    <div class="mb-0">
                                        <span class="badge bg-info me-2" style="font-size: 0.7rem;">${lec.posicion}</span>
                                        <span class="text-light" style="font-size: 0.85rem;"><strong>${lec.titulo}</strong></span>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-${icon}"></i>
                                        ${lec.tipo ? lec.tipo.charAt(0).toUpperCase() + lec.tipo.slice(1) : ''}
                                    </small>
                                </div>`;
                        });
                        
                        html += `
                                    </div>
                                </div>
                            </div>`;
                        
                        leccionesContainer.innerHTML = html;
                    } else {
                        leccionesContainer.innerHTML = '<div class="alert alert-secondary bg-dark border-secondary text-muted p-2 mb-0" style="font-size: 0.85rem;"><i class="fas fa-info-circle me-1"></i>No hay lecciones aún</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    leccionesContainer.innerHTML = `<div class="alert alert-danger bg-dark text-danger p-2 mb-0" style="font-size: 0.85rem;"><i class="fas fa-exclamation-triangle me-1"></i>Error al cargar</div>`;
                });
        });
    }
});
</script>

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

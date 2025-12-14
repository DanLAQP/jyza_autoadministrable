<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leccione $leccione
 * @var \Cake\Collection\CollectionInterface|string[] $modulos
 * @var iterable<\App\Model\Entity\Leccione>|null $leccionesExistentes
 * @var int|null $siguientePosicion
 */
?>

<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-info"><i class="fas fa-chalkboard-teacher"></i> Crear Nueva Lección</h3>
            <p class="text-muted">Completa los datos para crear una nueva lección</p>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm bg-dark border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Datos de la Lección</h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($leccione, ['novalidate' => true, 'class' => 'form']) ?>
                    
                    <div class="mb-3">
                        <?= $this->Form->label('modulo_id', '<i class="fas fa-folder"></i> Módulo *', ['escape' => false]) ?>
                        <?= $this->Form->select(
                            'modulo_id',
                            $modulos,
                            [
                                'class' => 'form-select form-select-lg',
                                'empty' => '-- Selecciona un módulo --',
                                'required' => true
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Selecciona el módulo al que pertenece esta lección
                        </small>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('titulo', '<i class="fas fa-heading"></i> Título de la Lección *', ['escape' => false]) ?>
                        <?= $this->Form->text(
                            'titulo',
                            [
                                'class' => 'form-control form-control-lg',
                                'placeholder' => 'Ej: Introducción a HTML, Variables en Python, etc.',
                                'required' => true,
                                'maxlength' => 255
                            ]
                        ) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Nombre descriptivo de la lección
                        </small>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <?= $this->Form->label('tipo_contenido', '<i class="fas fa-film"></i> Tipo de Contenido *', ['escape' => false]) ?>
                            <?= $this->Form->select(
                                'tipo_contenido',
                                [
                                    'video' => 'Video',
                                    'texto' => 'Texto',
                                    'imagen' => 'Imagen',
                                    'quiz' => 'Quiz'
                                ],
                                [
                                    'class' => 'form-select form-select-lg',
                                    'empty' => '-- Selecciona tipo --',
                                    'required' => true
                                ]
                            ) ?>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Formato del contenido
                            </small>
                        </div>

                        <div class="col-md-6">
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
                                <i class="fas fa-info-circle"></i> Orden en el módulo
                                <?php if (isset($siguientePosicion)): ?>
                                    (Sugerido: <?= $siguientePosicion ?>)
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="fas fa-save"></i> Crear Lección
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
        
        <!-- Lista de lecciones existentes -->
        <div class="col-lg-5">
            <div id="lecciones-existentes-container">
                <?php if (isset($leccionesExistentes) && !$leccionesExistentes->isEmpty()): ?>
                    <div class="card shadow-sm bg-dark border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-list"></i> Lecciones Existentes
                                <span class="badge bg-light text-dark"><?= $leccionesExistentes->count() ?></span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($leccionesExistentes as $lec): ?>
                                    <div class="list-group-item list-group-item-dark d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                <span class="badge bg-primary me-2">#<?= $lec->posicion ?></span>
                                                <?= h($lec->titulo) ?>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-<?= $lec->tipo_contenido == 'video' ? 'video' : ($lec->tipo_contenido == 'texto' ? 'file-alt' : ($lec->tipo_contenido == 'imagen' ? 'image' : 'question-circle')) ?>"></i>
                                                <?= ucfirst($lec->tipo_contenido) ?>
                                            </small>
                                        </div>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-edit"></i>',
                                            ['action' => 'edit', $lec->id],
                                            ['class' => 'btn btn-sm btn-warning', 'escape' => false, 'title' => 'Editar']
                                        ) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Selecciona un módulo para ver sus lecciones
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
                leccionesContainer.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> Selecciona un módulo para ver sus lecciones</div>';
                return;
            }
            
            // Mostrar loading
            leccionesContainer.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Cargando lecciones...</p></div>';
            
            // Cargar lecciones del módulo
            fetch(`<?= $this->Url->build(['controller' => 'Lecciones', 'action' => 'obtenerPorModulo']) ?>?modulo_id=${moduloId}`)
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
                            smallText.innerHTML = `<i class="fas fa-info-circle"></i> Orden en el módulo (Sugerido: ${data.siguientePosicion})`;
                        }
                    }
                    
                    // Actualizar lista de lecciones
                    if (data.lecciones && data.lecciones.length > 0) {
                        let html = `
                            <div class="card shadow-sm bg-dark border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-list"></i> Lecciones Existentes
                                        <span class="badge bg-light text-dark">${data.lecciones.length}</span>
                                    </h5>
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
                                <div class="list-group-item list-group-item-dark d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <span class="badge bg-primary me-2">#${lec.posicion}</span>
                                            ${lec.titulo}
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-${icon}"></i>
                                            ${lec.tipo ? lec.tipo.charAt(0).toUpperCase() + lec.tipo.slice(1) : ''}
                                        </small>
                                    </div>
                                    <a href="<?= $this->Url->build(['action' => 'edit']) ?>/${lec.id}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>`;
                        });
                        
                        html += `
                                    </div>
                                </div>
                            </div>`;
                        
                        leccionesContainer.innerHTML = html;
                    } else {
                        leccionesContainer.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> Esta será la primera lección del módulo seleccionado</div>';
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    leccionesContainer.innerHTML = `<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error al cargar lecciones: ${error.message}</div>`;
                });
        });
    }
});
</script>

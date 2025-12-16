<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Curso> $cursos
 */
?>

<div class="container mt-4 mb-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-light"><i class="fas fa-book"></i> Catálogo de Cursos</h2>
                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Nuevo Curso',
                        ['action' => 'add'],
                        ['class' => 'btn openModal', 'style' => 'background-color: #5dade2; color: #ffffff; font-weight: bold;', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
            <p class="text-light" style="opacity: 0.8;">Explora y únete a los cursos disponibles</p>
        </div>
    </div>

    <!-- Buscador AJAX en Tiempo Real -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="background-color: #16213e; border-color: #5dade2; border: 2px solid;">
                <div class="card-body">
                    <label for="buscar-curso-ajax" class="form-label fw-bold text-light">
                        <i class="fas fa-search" style="color: #5dade2;"></i> Búsqueda en Tiempo Real
                    </label>
                    <input 
                        type="text" 
                        id="buscar-curso-ajax" 
                        class="form-control form-control-lg" 
                        placeholder="Escriba título, descripción o categoría del curso..."
                        autocomplete="off"
                        style="background-color: #0f3460; color: #d9d9d9; border-color: #5dade2; padding: 12px; font-size: 1rem;"
                    >
                    <small class="form-text" style="color: #a0a0a0;">
                        <i class="fas fa-info-circle"></i> Búsqueda automática mientras escribes. Busca por título, descripción o categoría.
                    </small>
                    
                    <!-- Lista de resultados AJAX -->
                    <div id="resultados-cursos-ajax" class="list-group mt-3" style="display: none; max-height: 500px; overflow-y: scroll; overflow-x: hidden; background-color: #0f3460; border-color: #5dade2;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Cursos en Cards -->
    <div class="row g-3">
        <?php if (empty($cursos)): ?>
            <div class="col-12">
                <div class="alert text-center" style="background-color: #0f3460; color: #5dade2; border-color: #5dade2; border: 1px solid;">
                    <i class="fas fa-info-circle"></i> No hay cursos disponibles en este momento.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($cursos as $curso): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm border-0 hover-card" style="transition: transform 0.3s, box-shadow 0.3s; background-color: #16213e; border: 1px solid #5dade2; overflow: hidden;">
                        <!-- Miniatura -->
                        <?php if (!empty($curso->miniatura)): ?>
                            <img src="<?= $curso->miniatura ?>" class="card-img-top" alt="<?= h($curso->titulo) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="background-color: #0f3460 !important;">
                                <i class="fas fa-image fa-3x" style="color: #404040;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column p-2">
                            <!-- Título -->
                            <h5 class="card-title" style="color: #5dade2; font-size: 0.95rem; margin-bottom: 6px;"><?= h($curso->titulo) ?></h5>

                            <!-- Instructor -->
                            <?php if ($curso->hasValue('user')): ?>
                                <p class="card-text small mb-1" style="color: #b8b8b8; font-size: 0.8rem;">
                                    <i class="fas fa-user-tie"></i> 
                                    <?= $this->Html->link($curso->user->username, ['controller' => 'Users', 'action' => 'view', $curso->user->id], ['style' => 'color: #5dade2; text-decoration: none;']) ?>
                                </p>
                            <?php endif; ?>

                            <!-- Descripción -->
                            <p class="card-text flex-grow-1" style="color: #c5c5c5; font-size: 0.8rem; margin-bottom: 8px; line-height: 1.3;">
                                <?= substr(h($curso->descripcion), 0, 80) ?>...
                            </p>

                            <!-- Metadata -->
                            <div class="mb-2">
                                <div class="row g-1">
                                    <div class="col-6">
                                        <span class="badge w-100 text-center" style="background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2; font-size: 0.7rem;">
                                            <i class="fas fa-graduation-cap"></i> <?= ucfirst(h($curso->nivel)) ?>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <span class="badge w-100 text-center" style="background-color: #1a3a52; color: #5dade2; border: 1px solid #5dade2; font-size: 0.7rem;">
                                            <i class="fas fa-tag"></i> <?= h($curso->categoria) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado -->
                            <?php
                                $estadoColor = $curso->estado === 'activo' ? '#76c74d' : '#e07856';
                                $estadoIcon = $curso->estado === 'activo' ? 'check-circle' : 'times-circle';
                            ?>
                            <p class="text-sm mb-2">
                                <span class="badge" style="background-color: transparent; color: <?= $estadoColor ?>; border: 1px solid <?= $estadoColor ?>; font-size: 0.7rem;">
                                    <i class="fas fa-<?= $estadoIcon ?>"></i> <?= ucfirst(h($curso->estado)) ?>
                                </span>
                            </p>

                            <!-- Botones de Acción -->
                            <div class="btn-group w-100 gap-1" role="group" style="gap: 5px !important;">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $curso->id],
                                    ['class' => 'btn btn-sm flex-grow-1 btn-action-view', 'style' => 'background-color: #5dade2; color: #ffffff; border: none; font-size: 1rem; padding: 5px;', 'title' => 'Ver', 'escape' => false]
                                ) ?>
                                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-edit"></i>',
                                        ['action' => 'edit', $curso->id],
                                        ['class' => 'btn btn-sm flex-grow-1 btn-action-edit openModal', 'style' => 'background-color: #d4a574; color: #ffffff; border: none; font-size: 1rem; padding: 5px;', 'title' => 'Editar', 'escape' => false]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-trash"></i>',
                                        ['action' => 'delete', $curso->id],
                                        [
                                            'confirm' => '¿Estás seguro de que deseas eliminar este curso?',
                                            'class' => 'btn btn-sm btn-action-delete',
                                            'style' => 'background-color: #e07856; color: #ffffff; border: none; font-size: 1rem; padding: 5px;',
                                            'title' => 'Eliminar',
                                            'escape' => false
                                        ]
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer" style="background-color: #0f3460; border-top: 1px solid #5dade2; font-size: 0.75rem; color: #b8b8b8; text-align: center; padding: 6px;">
                            Creado: <?= $curso->created->format('d/m/Y') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <?php if (!empty($cursos)): ?>
        <div class="mt-5">
            <nav aria-label="Paginación de cursos">
                <ul class="pagination justify-content-center pagination-lg">
                    <?php
                    echo $this->Paginator->first(
                        '<i class="fas fa-angle-double-left"></i> Primera', 
                        ['escape' => false, 'class' => 'btn', 'style' => 'background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2;']
                    );
                    echo $this->Paginator->prev(
                        '<i class="fas fa-chevron-left"></i> Anterior', 
                        ['escape' => false, 'class' => 'btn', 'style' => 'background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2;']
                    );
                    echo $this->Paginator->numbers([
                        'modulus' => 4,
                        'first' => 2,
                        'last' => 2,
                        'class' => 'btn',
                        'style' => 'background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2;'
                    ]);
                    echo $this->Paginator->next(
                        'Siguiente <i class="fas fa-chevron-right"></i>', 
                        ['escape' => false, 'class' => 'btn', 'style' => 'background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2;']
                    );
                    echo $this->Paginator->last(
                        'Última <i class="fas fa-angle-double-right"></i>', 
                        ['escape' => false, 'class' => 'btn', 'style' => 'background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2;']
                    );
                    ?>
                </ul>
            </nav>
            <p class="text-center mt-2" style="color: #b8b8b8;">
                <i class="fas fa-info-circle"></i> 
                <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} curso(s) de {{count}} totales') ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- CSS personalizado para hover effect y tema oscuro -->
<style>
    .card-img-top {
        border-radius: 8px 8px 0 0;
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: contain;
        object-position: center;
        display: block;
        background-color: #0f3460;
    }
    
    .btn-group {
        gap: 5px;
    }
    
    .btn-group .btn {
        flex: 1;
    }
    
    /* Estilos de botones de acción */
    .btn-action-view {
        transition: background-color 0.2s ease;
    }
    
    .btn-action-view:hover {
        background-color: #4a92ba !important;
    }
    
    .btn-action-edit {
        transition: background-color 0.2s ease;
    }
    
    .btn-action-edit:hover {
        background-color: #bf9660 !important;
    }
    
    .btn-action-delete {
        transition: background-color 0.2s ease;
    }
    
    .btn-action-delete:hover {
        background-color: #d46844 !important;
    }
    
    #resultados-cursos-ajax .list-group-item {
        cursor: pointer;
        transition: background-color 0.2s;
        background-color: #16213e;
        color: #d9d9d9;
        border-color: #5dade2;
        border-bottom: 1px solid #5dade2;
    }
    
    /* Mejora de placeholder */
    #buscar-curso-ajax::placeholder {
        color: #606060 !important;
        opacity: 1;
    }
    
    #buscar-curso-ajax:focus {
        background-color: #0f3460 !important;
        color: #d9d9d9 !important;
        border-color: #5dade2 !important;
        box-shadow: 0 0 5px rgba(93, 173, 226, 0.4) !important;
    }
</style>

<!-- Script de Búsqueda AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscar-curso-ajax');
    const resultadosDiv = document.getElementById('resultados-cursos-ajax');
    let timeoutBusqueda = null;
    
    buscarInput.addEventListener('input', function() {
        const termino = this.value.trim();
        
        // Limpiar timeout anterior
        clearTimeout(timeoutBusqueda);
        
        // Ocultar resultados si está vacío o muy corto
        if (termino.length < 2) {
            resultadosDiv.style.display = 'none';
            resultadosDiv.innerHTML = '';
            return;
        }
        
        // Buscar después de 300ms de inactividad
        timeoutBusqueda = setTimeout(function() {
            fetch('<?= $this->Url->build(['controller' => 'Cursos', 'action' => 'buscarCursos']) ?>?termino=' + encodeURIComponent(termino))
                .then(response => response.json())
                .then(data => {
                    resultadosDiv.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultadosDiv.innerHTML = '<div class="list-group-item" style="background-color: #16213e; color: #b8b8b8; border: 1px solid #5dade2;"><i class="fas fa-info-circle"></i> No se encontraron cursos con ese criterio</div>';
                        resultadosDiv.style.display = 'block';
                    } else {
                        data.forEach(curso => {
                            const item = document.createElement('div');
                            item.className = 'list-group-item';
                            
                            // Badges de estado y nivel
                            let estadoBadge = '';
                            let estadoColor = '#76c74d';
                            let estadoIcon = 'check-circle';
                            if (!(curso.estado === 'activo' || curso.estado === 'publicado')) {
                                estadoBadge = '<span class="badge" style="background-color: transparent; color: #e07856; border: 1px solid #e07856;"><i class="fas fa-times-circle"></i> ' + curso.estado + '</span>';
                            } else {
                                estadoBadge = '<span class="badge" style="background-color: transparent; color: #76c74d; border: 1px solid #76c74d;"><i class="fas fa-check-circle"></i> ' + curso.estado + '</span>';
                            }
                            
                            let nivelBadge = curso.nivel ? '<span class="badge" style="background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2; margin-left: 5px;"><i class="fas fa-graduation-cap"></i> ' + curso.nivel + '</span>' : '';
                            let categoriaBadge = curso.categoria ? '<span class="badge" style="background-color: #1a3a52; color: #5dade2; border: 1px solid #5dade2; margin-left: 5px;"><i class="fas fa-tag"></i> ' + curso.categoria + '</span>' : '';
                            
                            let viewBtn = '<a href="<?= $this->Url->build(['action' => 'view']) ?>/' + curso.id + '" class="btn btn-sm btn-action-view" style="background-color: #5dade2; color: #ffffff; border: none; font-size: 1rem; padding: 5px 10px; text-decoration: none; margin-left: 5px;" title="Ver"><i class="fas fa-eye"></i></a>';
                            let editBtn = '<a href="<?= $this->Url->build(['action' => 'edit']) ?>/' + curso.id + '" class="btn btn-sm btn-action-edit openModal" style="background-color: #d4a574; color: #ffffff; border: none; font-size: 1rem; padding: 5px 10px; text-decoration: none; margin-left: 5px;" title="Editar"><i class="fas fa-edit"></i></a>';
                            
                            item.innerHTML = '<div class="d-flex justify-content-between align-items-center" style="flex-wrap: wrap; gap: 10px;">' +
                                           '<div style="flex: 1;">' +
                                           '<strong style="color: #5dade2;"><i class="fas fa-book"></i> ' + curso.titulo + '</strong>' +
                                           '<div class="small" style="color: #b8b8b8; margin-top: 5px;\">' + nivelBadge + categoriaBadge + '</div>' +
                                           '</div>' +
                                           '<div style="display: flex; gap: 5px; align-items: center;">' +
                                           estadoBadge +
                                           viewBtn +
                                           editBtn +
                                           '</div>' +
                                           '</div>';
                            
                            resultadosDiv.appendChild(item);
                        });
                        resultadosDiv.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error al buscar cursos:', error);
                    resultadosDiv.innerHTML = '<div class="list-group-item text-danger"><i class="fas fa-exclamation-triangle"></i> Error en la búsqueda</div>';
                    resultadosDiv.style.display = 'block';
                });
        }, 300);
    });
    
    // Ocultar resultados al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!buscarInput.contains(e.target) && !resultadosDiv.contains(e.target)) {
            resultadosDiv.style.display = 'none';
        }
    });
});
</script>
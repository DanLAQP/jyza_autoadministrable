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
                <h2 class="text-info"><i class="fas fa-book"></i> Catálogo de Cursos</h2>
                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Nuevo Curso',
                        ['action' => 'add'],
                        ['class' => 'btn btn-info', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
            <p class="text-muted">Explora y únete a los cursos disponibles</p>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Búsqueda por término -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'd-flex']) ?>
                    <div class="input-group">
                        <input type="text" name="termino" class="form-control" 
                               placeholder="Buscar curso por título..." 
                               value="<?= h($this->request->getQuery('termino')) ?>">
                        <input type="hidden" name="estado" value="<?= h($filtroEstado ?? 'activo') ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <?php if (!empty($this->request->getQuery('termino'))): ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-times"></i>',
                                ['action' => 'index', '?' => ['estado' => $filtroEstado ?? 'activo']],
                                ['class' => 'btn btn-secondary', 'escape' => false, 'title' => 'Limpiar búsqueda']
                            ) ?>
                        <?php endif; ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                
                <!-- Filtro por estado -->
                <div class="col-md-6">
                    <div class="btn-group float-end" role="group" aria-label="Filtro por estado">
                        <?= $this->Html->link(
                            '<i class="fas fa-check-circle"></i> Activos',
                            ['action' => 'index', '?' => ['estado' => 'activo']],
                            [
                                'class' => 'btn ' . (($filtroEstado ?? 'activo') === 'activo' ? 'btn-success' : 'btn-outline-success'),
                                'escape' => false,
                                'title' => 'Ver cursos activos'
                            ]
                        ) ?>
                        
                        <?= $this->Html->link(
                            '<i class="fas fa-ban"></i> Inactivos',
                            ['action' => 'index', '?' => ['estado' => 'inactivo']],
                            [
                                'class' => 'btn ' . (($filtroEstado ?? 'activo') === 'inactivo' ? 'btn-danger' : 'btn-outline-danger'),
                                'escape' => false,
                                'title' => 'Ver cursos desactivados'
                            ]
                        ) ?>
                        
                        <?= $this->Html->link(
                            '<i class="fas fa-list"></i> Todos',
                            ['action' => 'index', '?' => ['estado' => 'todos']],
                            [
                                'class' => 'btn ' . (($filtroEstado ?? 'activo') === 'todos' ? 'btn-secondary' : 'btn-outline-secondary'),
                                'escape' => false,
                                'title' => 'Ver todos los cursos'
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
            
            <!-- Indicador de filtro activo -->
            <?php if (isset($filtroEstado) && $filtroEstado !== 'activo'): ?>
                <div class="alert alert-info mt-3 mb-0">
                    <i class="fas fa-info-circle"></i> 
                    Mostrando cursos: <strong><?= ucfirst($filtroEstado) ?></strong>
                    <?php if ($filtroEstado === 'inactivo'): ?>
                        <span class="ms-2 text-muted">(Cursos desactivados pueden ser reactivados)</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Lista de Cursos en Cards -->
    <div class="row g-4">
        <?php if (empty($cursos)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No hay cursos disponibles en este momento.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($cursos as $curso): ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow-sm border-0 hover-card <?= $curso->estado === 'inactivo' ? 'curso-inactivo' : '' ?>" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <?php if ($curso->estado === 'inactivo'): ?>
                            <div class="ribbon ribbon-top-right"><span>INACTIVO</span></div>
                        <?php endif; ?>
                        
                        <!-- Miniatura -->
                        <?php if (!empty($curso->miniatura)): ?>
                            <img src="<?= $curso->miniatura ?>" class="card-img-top <?= $curso->estado === 'inactivo' ? 'opacity-50' : '' ?>" alt="<?= h($curso->titulo) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center <?= $curso->estado === 'inactivo' ? 'opacity-50' : '' ?>" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <!-- Título -->
                            <h5 class="card-title <?= $curso->estado === 'inactivo' ? 'text-muted' : 'text-info' ?>">
                                <?= h($curso->titulo) ?>
                                <?php if ($curso->estado === 'inactivo'): ?>
                                    <span class="badge bg-danger ms-2">DESACTIVADO</span>
                                <?php endif; ?>
                            </h5>

                            <!-- Instructor -->
                            <?php if ($curso->hasValue('user')): ?>
                                <p class="card-text small text-muted mb-2">
                                    <i class="fas fa-user-tie"></i> 
                                    <?= $this->Html->link($curso->user->username, ['controller' => 'Users', 'action' => 'view', $curso->user->id]) ?>
                                </p>
                            <?php endif; ?>

                            <!-- Descripción -->
                            <p class="card-text text-muted flex-grow-1" style="font-size: 0.95rem;">
                                <?= substr(h($curso->descripcion), 0, 100) ?>...
                            </p>

                            <!-- Metadata -->
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <span class="badge bg-secondary" style="width: 100%; text-align: center;">
                                            <i class="fas fa-graduation-cap"></i> <?= ucfirst(h($curso->nivel)) ?>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <span class="badge bg-primary" style="width: 100%; text-align: center;">
                                            <i class="fas fa-tag"></i> <?= h($curso->categoria) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado -->
                            <?php
                                if ($curso->estado === 'inactivo') {
                                    $estadoClass = 'secondary';
                                    $estadoIcon = 'ban';
                                    $estadoTexto = 'INACTIVO';
                                } elseif ($curso->estado === 'publicado' || $curso->estado === 'activo') {
                                    $estadoClass = 'success';
                                    $estadoIcon = 'check-circle';
                                    $estadoTexto = ucfirst($curso->estado);
                                } else {
                                    $estadoClass = 'warning';
                                    $estadoIcon = 'edit';
                                    $estadoTexto = ucfirst($curso->estado);
                                }
                            ?>
                            <p class="text-sm mb-3">
                                <span class="badge bg-<?= $estadoClass ?>">
                                    <i class="fas fa-<?= $estadoIcon ?>"></i> <?= $estadoTexto ?>
                                </span>
                            </p>

                            <!-- Botones de Acción -->
                            <div class="btn-group w-100" role="group">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $curso->id],
                                    ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Ver', 'escape' => false]
                                ) ?>
                                
                                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                                    <?php if ($curso->estado !== 'inactivo'): ?>
                                        <!-- Curso activo: mostrar editar y desactivar -->
                                        <?= $this->Html->link(
                                            '<i class="fas fa-edit"></i>',
                                            ['action' => 'edit', $curso->id],
                                            ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Editar', 'escape' => false]
                                        ) ?>
                                        
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-ban"></i>',
                                            ['action' => 'delete', $curso->id],
                                            [
                                                'confirm' => '¿Está seguro de desactivar este curso? Podrá reactivarlo después.',
                                                'class' => 'btn btn-sm btn-danger',
                                                'title' => 'Desactivar curso',
                                                'escape' => false
                                            ]
                                        ) ?>
                                    <?php else: ?>
                                        <!-- Curso inactivo: mostrar reactivar -->
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-redo"></i> Reactivar',
                                            ['action' => 'reactivar', $curso->id],
                                            [
                                                'confirm' => '¿Está seguro de reactivar este curso?',
                                                'class' => 'btn btn-sm btn-success w-100',
                                                'title' => 'Reactivar curso',
                                                'escape' => false
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-white border-top small text-muted text-center">
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
                <ul class="pagination justify-content-center">
                    <?php
                    echo $this->Paginator->first(
                        '<i class="fas fa-angle-double-left"></i>',
                        ['escape' => false, 'class' => 'page-link', 'title' => 'Primera página']
                    );
                    echo $this->Paginator->prev(
                        '<i class="fas fa-chevron-left"></i> Anterior',
                        ['escape' => false, 'class' => 'page-link']
                    );
                    echo $this->Paginator->numbers([
                        'modulus' => 3,
                        'first' => 1,
                        'last' => 1
                    ]);
                    echo $this->Paginator->next(
                        'Siguiente <i class="fas fa-chevron-right"></i>',
                        ['escape' => false, 'class' => 'page-link']
                    );
                    echo $this->Paginator->last(
                        '<i class="fas fa-angle-double-right"></i>',
                        ['escape' => false, 'class' => 'page-link', 'title' => 'Última página']
                    );
                    ?>
                </ul>
            </nav>
            <p class="text-center text-muted mt-2 small">
                <i class="fas fa-info-circle"></i> 
                <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} curso(s) de {{count}} totales') ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<!-- CSS personalizado para hover effect -->
<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }
    
    .card-img-top {
        border-radius: 8px 8px 0 0;
    }
    
    .btn-group {
        gap: 5px;
    }
    
    .btn-group .btn {
        flex: 1;
    }
    
    /* Cursos inactivos */
    .curso-inactivo {
        opacity: 0.85;
        border: 2px solid #dc3545 !important;
        position: relative;
    }
    
    .curso-inactivo .card-body {
        background-color: #f8f9fa;
    }
    
    /* Cinta INACTIVO */
    .ribbon {
        width: 150px;
        height: 150px;
        overflow: hidden;
        position: absolute;
        z-index: 10;
    }
    
    .ribbon-top-right {
        top: -10px;
        right: -10px;
    }
    
    .ribbon span {
        position: absolute;
        display: block;
        width: 225px;
        padding: 8px 0;
        background-color: #dc3545;
        box-shadow: 0 5px 10px rgba(0,0,0,.1);
        color: #fff;
        font-weight: bold;
        font-size: 13px;
        text-shadow: 0 1px 1px rgba(0,0,0,.2);
        text-transform: uppercase;
        text-align: center;
    }
    
    .ribbon-top-right span {
        right: -25px;
        top: 30px;
        transform: rotate(45deg);
    }
    
    #resultados-cursos-ajax .list-group-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    #resultados-cursos-ajax .list-group-item:hover {
        background-color: #f0f0f0;
    }
    
    /* Estilos de paginación mejorados */
    .pagination {
        gap: 5px;
    }
    
    .pagination .page-link {
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid #dee2e6;
    }
    
    .pagination .page-link:hover {
        background-color: #17a2b8;
        color: white;
        border-color: #17a2b8;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
    }
    
    .pagination .active .page-link {
        background-color: #17a2b8;
        border-color: #17a2b8;
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
    }
    
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
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
                        resultadosDiv.innerHTML = '<div class="list-group-item text-muted"><i class="fas fa-info-circle"></i> No se encontraron cursos con ese criterio</div>';
                        resultadosDiv.style.display = 'block';
                    } else {
                        data.forEach(curso => {
                            const item = document.createElement('a');
                            item.href = '<?= $this->Url->build(['action' => 'view']) ?>/' + curso.id;
                            item.className = 'list-group-item list-group-item-action';
                            
                            // Badges de estado y nivel
                            let estadoBadge = '';
                            if (curso.estado === 'activo' || curso.estado === 'publicado') {
                                estadoBadge = '<span class="badge bg-success ms-2"><i class="fas fa-check-circle"></i> ' + curso.estado + '</span>';
                            } else {
                                estadoBadge = '<span class="badge bg-danger ms-2"><i class="fas fa-times-circle"></i> ' + curso.estado + '</span>';
                            }
                            
                            let nivelBadge = curso.nivel ? '<span class="badge bg-secondary ms-1"><i class="fas fa-graduation-cap"></i> ' + curso.nivel + '</span>' : '';
                            let categoriaBadge = curso.categoria ? '<span class="badge bg-primary ms-1"><i class="fas fa-tag"></i> ' + curso.categoria + '</span>' : '';
                            
                            item.innerHTML = '<div class="d-flex justify-content-between align-items-center">' +
                                           '<div>' +
                                           '<strong class="text-info"><i class="fas fa-book"></i> ' + curso.titulo + '</strong>' +
                                           '<div class="small text-muted mt-1">' + nivelBadge + categoriaBadge + '</div>' +
                                           '</div>' +
                                           '<div>' + estadoBadge + '</div>' +
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
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 * @var string $searchTerm
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0"><i class="fas fa-users"></i> Usuarios</h2>
            <?= $this->Html->link(__('Añadir Usuario'), ['action' => 'add'], ['class' => 'btn btn-info openModal']) ?>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="card shadow-sm mb-4 bg-dark border-primary">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Búsqueda por término -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'd-flex']) ?>
                    <div class="input-group">
                        <input type="text" name="termino" class="form-control" 
                               placeholder="Buscar por usuario o nombre..." 
                               value="<?= h($this->request->getQuery('termino')) ?>"
                               style="background-color: #1a3a52; color: #ffffff; border: 1px solid #0d6efd;">
                        <input type="hidden" name="estado" value="<?= h($filtroEstado) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <?php if (!empty($this->request->getQuery('termino'))): ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-times"></i>',
                                ['action' => 'index', '?' => ['estado' => $filtroEstado]],
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
                                'class' => 'btn ' . ($filtroEstado === 'activo' ? 'btn-success' : 'btn-outline-success'),
                                'escape' => false,
                                'title' => 'Ver solo usuarios activos'
                            ]
                        ) ?>
                        
                        <?= $this->Html->link(
                            '<i class="fas fa-ban"></i> Inactivos',
                            ['action' => 'index', '?' => ['estado' => 'inactivo']],
                            [
                                'class' => 'btn ' . ($filtroEstado === 'inactivo' ? 'btn-danger' : 'btn-outline-danger'),
                                'escape' => false,
                                'title' => 'Ver usuarios desactivados'
                            ]
                        ) ?>
                        
                        <?= $this->Html->link(
                            '<i class="fas fa-list"></i> Todos',
                            ['action' => 'index', '?' => ['estado' => 'todos']],
                            [
                                'class' => 'btn ' . ($filtroEstado === 'todos' ? 'btn-secondary' : 'btn-outline-secondary'),
                                'escape' => false,
                                'title' => 'Ver todos los usuarios'
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
            
            <!-- Indicador de filtro activo -->
            <?php if ($filtroEstado !== 'activo'): ?>
                <div class="alert alert-info mt-3 mb-0" style="background-color: #0f3460; border-color: #0d6efd; color: #0d6efd;">
                    <i class="fas fa-info-circle"></i> 
                    Mostrando usuarios: <strong><?= ucfirst($filtroEstado) ?></strong>
                    <?php if ($filtroEstado === 'inactivo'): ?>
                        <span class="ms-2 text-muted">(Usuarios desactivados pueden ser reactivados)</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Todos los Usuarios</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark table-sticky-actions">
                            <thead class="table-dark">
                                <tr>
                                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                                    <th><?= $this->Paginator->sort('username', 'Usuario') ?></th>
                                    <th><?= $this->Paginator->sort('nombres', 'Nombres') ?></th>
                                    <th><?= $this->Paginator->sort('rol', 'Rol') ?></th>
                                    <th><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                                    <th class="text-center sticky-col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr class="<?= $user->estado === 'inactivo' ? 'table-secondary text-muted' : '' ?>">
                                    <td><?= $this->Number->format($user->id) ?></td>
                                    <td>
                                        <i class="fas fa-user"></i> <?= h($user->username) ?>
                                        <?php if ($user->estado === 'inactivo'): ?>
                                            <span class="badge bg-danger ms-2">DESACTIVADO</span>
                                        <?php endif; ?>
                                        <?php if ($user->id == 1): ?>
                                            <span class="badge bg-warning text-dark ms-2"><i class="fas fa-shield-alt"></i> PROTEGIDO</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= h($user->nombres) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $user->rol == 1 ? 'danger' : 'info' ?>">
                                            <?= $roles[$user->rol] ?? 'Desconocido' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($user->estado === 'activo'): ?>
                                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><i class="fas fa-ban"></i> Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($user->created->format('d/m/Y')) ?></td>
                                    <td class="text-center sticky-col sticky-actions">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i>',
                                                ['action' => 'view', $user->id],
                                                ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info openModal']
                                            ) ?>
                                            
                                            <?php if ($user->estado === 'activo'): ?>
                                                <!-- Usuario activo: mostrar editar y desactivar -->
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-edit"></i>',
                                                    ['action' => 'edit', $user->id],
                                                    ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning openModal']
                                                ) ?>
                                                
                                                <?php if ($user->id != 1): // Proteger admin principal ?>
                                                    <?= $this->Form->postLink(
                                                        '<i class="fas fa-ban"></i>',
                                                        ['action' => 'delete', $user->id],
                                                        [
                                                            'confirm' => '¿Está seguro de desactivar este usuario? Podrá reactivarlo desde el filtro de inactivos.',
                                                            'class' => 'btn btn-danger',
                                                            'escape' => false,
                                                            'title' => 'Desactivar usuario'
                                                        ]
                                                    ) ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <!-- Usuario inactivo: mostrar reactivar -->
                                                <?= $this->Form->postLink(
                                                    '<i class="fas fa-redo"></i> Reactivar',
                                                    ['action' => 'reactivar', $user->id],
                                                    [
                                                        'confirm' => '¿Está seguro de reactivar este usuario?',
                                                        'class' => 'btn btn-success',
                                                        'escape' => false,
                                                        'title' => 'Reactivar usuario'
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginación -->
                    <div class="mt-4">
                        <nav aria-label="Paginación de usuarios">
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
                        <p class="text-center text-muted small">
                            <i class="fas fa-info-circle"></i>
                            <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} usuario(s) de {{count}} totales') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script de Búsqueda AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscar-usuario-ajax');
    const resultadosDiv = document.getElementById('resultados-usuarios-ajax');
    let timeoutBusqueda = null;
    
    // Definir roles para mostrar
    const roles = {
        1: 'Administrador',
        2: 'Usuario'
    };
    
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
            fetch('<?= $this->Url->build(['controller' => 'Users', 'action' => 'buscarUsuarios']) ?>?termino=' + encodeURIComponent(termino))
                .then(response => response.json())
                .then(data => {
                    resultadosDiv.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultadosDiv.innerHTML = '<div class="list-group-item text-muted"><i class="fas fa-info-circle"></i> No se encontraron usuarios con ese criterio</div>';
                        resultadosDiv.style.display = 'block';
                    } else {
                        data.forEach(usuario => {
                            const item = document.createElement('a');
                            item.href = '<?= $this->Url->build(['action' => 'view']) ?>/' + usuario.id;
                            item.className = 'list-group-item list-group-item-action';
                            
                            // Badges de estado y rol
                            let estadoBadge = '';
                            if (usuario.estado === 'activo') {
                                estadoBadge = '<span class="badge bg-success ms-2"><i class="fas fa-check-circle"></i> Activo</span>';
                            } else {
                                estadoBadge = '<span class="badge bg-danger ms-2"><i class="fas fa-times-circle"></i> Inactivo</span>';
                            }
                            
                            let rolNombre = roles[usuario.rol] || 'Desconocido';
                            let rolBadge = '<span class="badge bg-info ms-1"><i class="fas fa-user-tag"></i> ' + rolNombre + '</span>';
                            
                            item.innerHTML = '<div class="d-flex justify-content-between align-items-center">' +
                                           '<div>' +
                                           '<strong class="text-primary"><i class="fas fa-user"></i> ' + usuario.username + '</strong>' +
                                           '<div class="small text-muted mt-1">' + rolBadge + '</div>' +
                                           '</div>' +
                                           '<div>' + estadoBadge + '</div>' +
                                           '</div>';
                            
                            resultadosDiv.appendChild(item);
                        });
                        resultadosDiv.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error al buscar usuarios:', error);
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

<style>
    /* Estilos para input de búsqueda */
    input[name="termino"]::placeholder {
        color: #8eb4d6 !important;
        opacity: 1;
    }
    
    input[name="termino"]:focus {
        background-color: #1a3a52 !important;
        color: #ffffff !important;
        border-color: #0d6efd !important;
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.5) !important;
    }
    
    /* Estilos sticky para la columna de acciones */
    .table-sticky-actions {
        position: relative;
    }
    
    .table-sticky-actions .sticky-col {
        background-color: inherit;
        position: sticky;
        right: 0;
        z-index: 10;
        min-width: 140px;
        white-space: nowrap;
    }
    
    /* Para el header */
    .table-sticky-actions thead .sticky-col {
        background-color: #212529;
        box-shadow: -2px 0 4px rgba(0, 0, 0, 0.3);
    }
    
    /* Para las filas del body */
    .table-sticky-actions tbody .sticky-col {
        box-shadow: -2px 0 4px rgba(0, 0, 0, 0.2);
    }
    
    /* Cuando la fila está inactiva */
    .table-sticky-actions tbody tr.table-secondary .sticky-col {
        background-color: #6c757d;
    }
    
    /* Cuando la fila está activa */
    .table-sticky-actions tbody tr:not(.table-secondary) .sticky-col {
        background-color: #212529;
    }
    
    /* En responsive, asegurar que sea visible */
    @media (max-width: 992px) {
        .table-sticky-actions .sticky-col {
            min-width: 95px;
        }
        
        .table-sticky-actions .sticky-col .btn-group {
            flex-direction: row;
            gap: 2px;
            width: 100%;
        }
        
        .table-sticky-actions .sticky-col .btn-group-sm {
            width: 100%;
        }
        
        .table-sticky-actions .sticky-col .btn {
            flex: 1;
            padding: 0.35rem 0.5rem !important;
            font-size: 0.7rem !important;
            min-width: 32px;
        }
        
        .table-sticky-actions .sticky-col .btn i {
            margin-right: 0 !important;
        }
    }
    
    @media (max-width: 576px) {
        .table-sticky-actions .sticky-col {
            min-width: 85px;
        }
        
        .table-sticky-actions .sticky-col .btn {
            padding: 0.25rem 0.4rem !important;
            font-size: 0.65rem !important;
            min-width: 28px;
        }
    }
    
    #resultados-usuarios-ajax .list-group-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    #resultados-usuarios-ajax .list-group-item:hover {
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
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }
    
    .pagination .active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
    }
    
    .pagination .disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

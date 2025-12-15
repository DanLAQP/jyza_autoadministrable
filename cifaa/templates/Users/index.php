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
    <!-- Buscador AJAX en Tiempo Real -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <label for="buscar-usuario-ajax" class="form-label fw-bold">
                        <i class="fas fa-search text-primary"></i> Búsqueda en Tiempo Real
                    </label>
                    <input 
                        type="text" 
                        id="buscar-usuario-ajax" 
                        class="form-control form-control-lg" 
                        placeholder="Escriba nombre de usuario, DNI o nombre completo (mín. 2 caracteres)..."
                        autocomplete="off"
                    >
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Búsqueda automática mientras escribes. Busca por username, DNI o nombre completo.
                    </small>
                    
                    <!-- Lista de resultados AJAX -->
                    <div id="resultados-usuarios-ajax" class="list-group mt-3" style="display: none; max-height: 400px; overflow-y: auto;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Todos los Usuarios</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead class="table-secondary">
                                <tr>
                                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                                    <th><?= $this->Paginator->sort('username', 'Usuario') ?></th>
                                    <th><?= $this->Paginator->sort('dni', 'DNI') ?></th>
                                    <th><?= $this->Paginator->sort('rol', 'Rol') ?></th>
                                    <th><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                                    <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $this->Number->format($user->id) ?></td>
                                    <td><?= h($user->username) ?></td>
                                    <td><?= h($user->dni) ?></td>
                                    <td><?= $roles[$user->rol] ?? 'Desconocido' ?></td>
                                    <td>
                                        <?php if ($user->estado === 'activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($user->created) ?></td>
                                    <td><?= h($user->modified) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i>',
                                                ['action' => 'view', $user->id],
                                                ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info openModal']
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fas fa-edit"></i>',
                                                ['action' => 'edit', $user->id],
                                                ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning openModal']
                                            ) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginación -->
                    <div class="mt-3">
                        <nav aria-label="Paginación">
                            <ul class="pagination justify-content-center">
                                <?php
                                echo $this->Paginator->first('<i class="fas fa-step-backward"></i> Primera', ['class' => 'page-link']);
                                echo $this->Paginator->prev('<i class="fas fa-chevron-left"></i> Anterior', ['class' => 'page-link']);
                                echo $this->Paginator->numbers(['class' => 'page-link']);
                                echo $this->Paginator->next('Siguiente <i class="fas fa-chevron-right"></i>', ['class' => 'page-link']);
                                echo $this->Paginator->last('Última <i class="fas fa-step-forward"></i>', ['class' => 'page-link']);
                                ?>
                            </ul>
                        </nav>
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
        2: 'Docente',
        3: 'Estudiante'
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
                            let dniBadge = usuario.dni ? '<span class="badge bg-secondary ms-1"><i class="fas fa-id-card"></i> DNI: ' + usuario.dni + '</span>' : '';
                            
                            item.innerHTML = '<div class="d-flex justify-content-between align-items-center">' +
                                           '<div>' +
                                           '<strong class="text-primary"><i class="fas fa-user"></i> ' + usuario.username + '</strong>' +
                                           '<div class="small text-muted mt-1">' + rolBadge + dniBadge + '</div>' +
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
    #resultados-usuarios-ajax .list-group-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    #resultados-usuarios-ajax .list-group-item:hover {
        background-color: #f0f0f0;
    }
</style>

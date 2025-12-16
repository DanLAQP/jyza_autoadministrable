<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Titular> $titulares
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0"><i class="fas fa-id-card"></i> Titulares de Certificados</h2>
        </div>
    </div>

    <!-- Información del sistema -->
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> <strong>¿Qué son los titulares?</strong>
        <p class="mb-0 mt-2">Los titulares son las personas que reciben certificados. Pueden o no tener una cuenta de usuario en el sistema. 
        Cada titular tiene un DNI único y puede acumular múltiples certificados.</p>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Búsqueda por término -->
                <div class="col-md-8 mb-3 mb-md-0">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'd-flex']) ?>
                    <div class="input-group">
                        <input type="text" name="termino" class="form-control" 
                               placeholder="Buscar por DNI, nombres o apellidos..." 
                               value="<?= h($this->request->getQuery('termino')) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <?php if (!empty($this->request->getQuery('termino'))): ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-times"></i>',
                                ['action' => 'index'],
                                ['class' => 'btn btn-secondary', 'escape' => false, 'title' => 'Limpiar búsqueda']
                            ) ?>
                        <?php endif; ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                
                <!-- Estadísticas rápidas -->
                <div class="col-md-4">
                    <div class="text-end">
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-users"></i> Total: <?= $this->Paginator->counter('{{count}}') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Titulares -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Lista de Titulares</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead class="table-secondary">
                                <tr>
                                    <th><?= $this->Paginator->sort('dni', 'DNI') ?></th>
                                    <th><?= $this->Paginator->sort('nombres', 'Nombres') ?></th>
                                    <th><?= $this->Paginator->sort('apellidos', 'Apellidos') ?></th>
                                    <th>Usuario Vinculado</th>
                                    <th>Certificados</th>
                                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($titulares)): ?>
                                    <?php foreach ($titulares as $titular): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= h($titular->dni) ?>
                                                </span>
                                            </td>
                                            <td><?= h($titular->nombres) ?></td>
                                            <td><?= h($titular->apellidos) ?></td>
                                            <td>
                                                <?php if ($titular->tiene_usuario): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Sí
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-times-circle"></i> No
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (isset($titular->total_certificados) && $titular->total_certificados > 0): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-certificate"></i> <?= $titular->total_certificados ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">0</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= $titular->created->format('d/m/Y') ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-eye"></i>',
                                                        ['action' => 'view', $titular->id],
                                                        [
                                                            'class' => 'btn btn-info',
                                                            'escape' => false,
                                                            'title' => 'Ver detalles'
                                                        ]
                                                    ) ?>
                                                    
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-edit"></i>',
                                                        ['action' => 'edit', $titular->id],
                                                        [
                                                            'class' => 'btn btn-warning',
                                                            'escape' => false,
                                                            'title' => 'Editar datos'
                                                        ]
                                                    ) ?>
                                                    
                                                    <?php if (!$titular->tiene_usuario && (!isset($titular->total_certificados) || $titular->total_certificados == 0)): ?>
                                                        <?= $this->Form->postLink(
                                                            '<i class="fas fa-trash"></i>',
                                                            ['action' => 'delete', $titular->id],
                                                            [
                                                                'class' => 'btn btn-danger',
                                                                'escape' => false,
                                                                'title' => 'Eliminar',
                                                                'confirm' => '¿Está seguro de eliminar este titular?'
                                                            ]
                                                        ) ?>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-danger" disabled title="No se puede eliminar: tiene usuario o certificados vinculados">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">
                                                <?php if (!empty($this->request->getQuery('termino'))): ?>
                                                    No se encontraron titulares con ese criterio de búsqueda.
                                                <?php else: ?>
                                                    No hay titulares registrados en el sistema.
                                                <?php endif; ?>
                                            </p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <?php if ($this->Paginator->total() > 1): ?>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} de {{count}} titulares') ?>
            </div>
            <nav>
                <ul class="pagination mb-0">
                    <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->numbers(['modulus' => 4]) ?>
                    <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>

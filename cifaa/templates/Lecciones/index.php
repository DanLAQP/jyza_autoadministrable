<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Leccione> $lecciones
 */
?>

<div class="container mt-4 mb-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-info"><i class="fas fa-chalkboard-teacher"></i> Lecciones</h2>
                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Crear Nueva Lección',
                        ['action' => 'add'],
                        ['class' => 'btn btn-primary btn-lg', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Listado de Lecciones -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Todas las Lecciones</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($lecciones)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark">
                                <thead class="table-secondary">
                                    <tr>
                                        <th><?= $this->Paginator->sort('posicion', 'Pos.') ?></th>
                                        <th><?= $this->Paginator->sort('titulo', 'Título') ?></th>
                                        <th><?= $this->Paginator->sort('modulo_id', 'Módulo') ?></th>
                                        <th><?= $this->Paginator->sort('tipo_contenido', 'Tipo') ?></th>
                                        <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lecciones as $leccione): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?= h($leccione->posicion) ?></span>
                                            </td>
                                            <td><?= h($leccione->titulo) ?></td>
                                            <td>
                                                <?= $leccione->hasValue('modulo') 
                                                    ? $this->Html->link($leccione->modulo->titulo, ['controller' => 'Modulos', 'action' => 'view', $leccione->modulo->id]) 
                                                    : '<em class="text-muted">Sin módulo</em>' ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $tipoClass = match($leccione->tipo_contenido) {
                                                        'video' => 'primary',
                                                        'texto' => 'info',
                                                        'imagen' => 'success',
                                                        'quiz' => 'warning',
                                                        default => 'secondary'
                                                    };
                                                    $tipoIcon = match($leccione->tipo_contenido) {
                                                        'video' => 'film',
                                                        'texto' => 'file-alt',
                                                        'imagen' => 'image',
                                                        'quiz' => 'question-circle',
                                                        default => 'file'
                                                    };
                                                ?>
                                                <span class="badge bg-<?= $tipoClass ?>">
                                                    <i class="fas fa-<?= $tipoIcon ?>"></i> <?= ucfirst(h($leccione->tipo_contenido)) ?>
                                                </span>
                                            </td>
                                            <td><?= $leccione->created->format('d/m/Y') ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-eye"></i>',
                                                        ['action' => 'view', $leccione->id],
                                                        ['class' => 'btn btn-info', 'title' => 'Ver', 'escape' => false]
                                                    ) ?>
                                                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                                                        <?= $this->Html->link(
                                                            '<i class="fas fa-edit"></i>',
                                                            ['action' => 'edit', $leccione->id],
                                                            ['class' => 'btn btn-warning', 'title' => 'Editar', 'escape' => false]
                                                        ) ?>
                                                        <?= $this->Form->postLink(
                                                            '<i class="fas fa-trash"></i>',
                                                            ['action' => 'delete', $leccione->id],
                                                            ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'title' => 'Eliminar', 'escape' => false]
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
                    <?php else: ?>
                        <div class="alert alert-info text-center mb-0">
                            <i class="fas fa-info-circle"></i> No hay lecciones disponibles. 
                            <?= $this->Html->link('Crear la primera lección', ['action' => 'add'], ['class' => 'alert-link']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Leccione> $lecciones
 * @var \App\Model\Entity\Curso|null $curso
 * @var string|null $cursoId
 */
?>

<div class="container mt-4 mb-4">
    <?php if (isset($curso)): ?>
        <!-- Información del curso -->
        <div class="alert alert-info mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-book me-2"></i><?= h($curso->titulo) ?>
                    </h4>
                    <p class="mb-0 text-muted">Editando lecciones de este curso</p>
                </div>
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left me-1"></i> Volver al Curso',
                    ['controller' => 'Cursos', 'action' => 'view', $curso->id],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-info">
                    <i class="fas fa-chalkboard-teacher"></i> Lecciones
                    <?php if (isset($curso)): ?>
                        <span class="badge bg-info"><?= count($lecciones) ?></span>
                    <?php endif; ?>
                </h2>
                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Crear Nueva Lección',
                        ['action' => 'add', '?' => isset($cursoId) ? ['curso_id' => $cursoId] : []],
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
                        <div class="mt-4">
                            <nav aria-label="Paginación de lecciones">
                                <ul class="pagination justify-content-center pagination-lg">
                                    <?php
                                    echo $this->Paginator->first(
                                        '<i class="fas fa-angle-double-left"></i> Primera', 
                                        ['escape' => false, 'class' => 'btn btn-outline-info']
                                    );
                                    echo $this->Paginator->prev(
                                        '<i class="fas fa-chevron-left"></i> Anterior', 
                                        ['escape' => false, 'class' => 'btn btn-outline-info']
                                    );
                                    echo $this->Paginator->numbers([
                                        'modulus' => 4,
                                        'first' => 2,
                                        'last' => 2,
                                        'class' => 'btn btn-outline-info'
                                    ]);
                                    echo $this->Paginator->next(
                                        'Siguiente <i class="fas fa-chevron-right"></i>', 
                                        ['escape' => false, 'class' => 'btn btn-outline-info']
                                    );
                                    echo $this->Paginator->last(
                                        'Última <i class="fas fa-angle-double-right"></i>', 
                                        ['escape' => false, 'class' => 'btn btn-outline-info']
                                    );
                                    ?>
                                </ul>
                            </nav>
                            <p class="text-center text-muted mt-2">
                                <i class="fas fa-info-circle"></i> 
                                <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} lección(es) de {{count}} totales') ?>
                            </p>
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
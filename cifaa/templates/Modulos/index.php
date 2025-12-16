<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Modulo> $modulos
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
                    <p class="mb-0 text-muted">Editando módulos de este curso</p>
                </div>
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left me-1"></i> Volver al Curso',
                    ['controller' => 'Cursos', 'action' => 'view', $curso->id],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <h3 class="text-info mb-0">
            <i class="fas fa-layer-group"></i> Módulos
            <?php if (isset($curso)): ?>
                <span class="badge bg-info"><?= count($modulos) ?></span>
            <?php endif; ?>
        </h3>
        <?php if (!empty($usuario) && $usuario->rol == 1): ?>
            <?= $this->Html->link(
                __('Agregar Módulo'), 
                ['action' => 'add', '?' => isset($cursoId) ? ['curso_id' => $cursoId] : []], 
                ['class' => 'btn btn-info']
            ) ?>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('curso_id') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <th><?= $this->Paginator->sort('posicion') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modulos as $modulo): ?>
                <tr>
                    <td><?= $this->Number->format($modulo->id) ?></td>
                    <td><?= $modulo->hasValue('curso') ? $this->Html->link($modulo->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $modulo->curso->id], ['class' => 'link-light']) : '' ?></td>
                    <td><?= h($modulo->titulo) ?></td>
                    <td><?= $this->Number->format($modulo->posicion) ?></td>
                    <td><?= h($modulo->created) ?></td>
                    <td><?= h($modulo->modified) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $modulo->id], ['class' => 'btn btn-sm btn-outline-light me-1']) ?>
                        <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $modulo->id], ['class' => 'btn btn-sm btn-info me-1 openModal']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $modulo->id], ['class' => 'btn btn-sm btn-danger', 'confirm' => __('¿Seguro que deseas eliminar el módulo #{0}?', $modulo->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <nav aria-label="Paginación de módulos">
            <ul class="pagination justify-content-center pagination-lg">
                <?php
                echo $this->Paginator->first(
                    '<i class="fas fa-angle-double-left"></i> Primera', 
                    ['escape' => false, 'class' => 'btn btn-outline-success']
                );
                echo $this->Paginator->prev(
                    '<i class="fas fa-chevron-left"></i> Anterior', 
                    ['escape' => false, 'class' => 'btn btn-outline-success']
                );
                echo $this->Paginator->numbers([
                    'modulus' => 4,
                    'first' => 2,
                    'last' => 2,
                    'class' => 'btn btn-outline-success'
                ]);
                echo $this->Paginator->next(
                    'Siguiente <i class="fas fa-chevron-right"></i>', 
                    ['escape' => false, 'class' => 'btn btn-outline-success']
                );
                echo $this->Paginator->last(
                    'Última <i class="fas fa-angle-double-right"></i>', 
                    ['escape' => false, 'class' => 'btn btn-outline-success']
                );
                ?>
            </ul>
        </nav>
        <p class="text-center text-muted mt-2">
            <i class="fas fa-info-circle"></i> 
            <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} módulo(s) de {{count}} totales') ?>
        </p>
    </div>
</div>
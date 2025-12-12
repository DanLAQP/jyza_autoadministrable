<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Modulo> $modulos
 */
?>
<div class="container mt-4 mb-4">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <h3 class="text-info mb-0"><i class="fas fa-layer-group"></i> Módulos</h3>
        <?php if (!empty($usuario) && $usuario->rol == 1): ?>
            <?= $this->Html->link(__('Agregar Módulo'), ['action' => 'add'], ['class' => 'btn btn-info']) ?>
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
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $modulo->id], ['class' => 'btn btn-sm btn-info me-1']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $modulo->id], ['class' => 'btn btn-sm btn-danger', 'confirm' => __('¿Seguro que deseas eliminar el módulo #{0}?', $modulo->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ' . __('primera')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('última') . ' >>') ?>
        </ul>
        <p class="text-center text-muted"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}}')) ?></p>
    </div>
</div>
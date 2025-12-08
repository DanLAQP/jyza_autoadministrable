<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContenidosLeccion> $contenidosLeccion
 */
?>
<div class="contenidosLeccion index content">
    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
        <?= $this->Html->link(__('New Contenidos Leccion'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Contenidos Leccion') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('leccion_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('archivo') ?></th>
                    <th><?= $this->Paginator->sort('posicion') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contenidosLeccion as $contenidosLeccion): ?>
                <tr>
                    <td><?= $this->Number->format($contenidosLeccion->id) ?></td>
                    <td><?= $contenidosLeccion->hasValue('leccione') ? $this->Html->link($contenidosLeccion->leccione->titulo, ['controller' => 'Lecciones', 'action' => 'view', $contenidosLeccion->leccione->id]) : '' ?></td>
                    <td><?= h($contenidosLeccion->tipo) ?></td>
                    <td><?= h($contenidosLeccion->archivo) ?></td>
                    <td><?= $this->Number->format($contenidosLeccion->posicion) ?></td>
                    <td><?= h($contenidosLeccion->created) ?></td>
                    <td><?= h($contenidosLeccion->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contenidosLeccion->id]) ?>
                        <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contenidosLeccion->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contenidosLeccion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contenidosLeccion->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Modulo> $modulos
 */
?>
<div class="modulos index content">
    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
        <?= $this->Html->link(__('New Modulo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Modulos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('curso_id') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <th><?= $this->Paginator->sort('posicion') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modulos as $modulo): ?>
                <tr>
                    <td><?= $this->Number->format($modulo->id) ?></td>
                    <td><?= $modulo->hasValue('curso') ? $this->Html->link($modulo->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $modulo->curso->id]) : '' ?></td>
                    <td><?= h($modulo->titulo) ?></td>
                    <td><?= $this->Number->format($modulo->posicion) ?></td>
                    <td><?= h($modulo->created) ?></td>
                    <td><?= h($modulo->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $modulo->id]) ?>
                        <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $modulo->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $modulo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modulo->id)]) ?>
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
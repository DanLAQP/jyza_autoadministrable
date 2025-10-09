<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\OrdenesTratamiento> $ordenesTratamientos
 */
?>
<div class="ordenesTratamientos index content">
    <?= $this->Html->link(__('New Ordenes Tratamiento'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Ordenes Tratamientos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('orden_id') ?></th>
                    <th><?= $this->Paginator->sort('tratamiento_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('precio_unitario') ?></th>
                    <th><?= $this->Paginator->sort('subtotal') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordenesTratamientos as $ordenesTratamiento): ?>
                <tr>
                    <td><?= $this->Number->format($ordenesTratamiento->id) ?></td>
                    <td><?= $ordenesTratamiento->hasValue('ordene') ? $this->Html->link($ordenesTratamiento->ordene->id, ['controller' => 'Ordenes', 'action' => 'view', $ordenesTratamiento->ordene->id]) : '' ?></td>
                    <td><?= $ordenesTratamiento->hasValue('tratamiento') ? $this->Html->link($ordenesTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $ordenesTratamiento->tratamiento->id]) : '' ?></td>
                    <td><?= $this->Number->format($ordenesTratamiento->cantidad) ?></td>
                    <td><?= $this->Number->format($ordenesTratamiento->precio_unitario) ?></td>
                    <td><?= $this->Number->format($ordenesTratamiento->subtotal) ?></td>
                    <td><?= h($ordenesTratamiento->created) ?></td>
                    <td><?= h($ordenesTratamiento->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $ordenesTratamiento->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ordenesTratamiento->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ordenesTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordenesTratamiento->id)]) ?>
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
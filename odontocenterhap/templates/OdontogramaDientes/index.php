<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\OdontogramaDiente> $odontogramaDientes
 */
?>
<div class="odontogramaDientes index content">
    <?= $this->Html->link(__('New Odontograma Diente'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Odontograma Dientes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('odontograma_id') ?></th>
                    <th><?= $this->Paginator->sort('diente_id') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($odontogramaDientes as $odontogramaDiente): ?>
                <tr>
                    <td><?= $this->Number->format($odontogramaDiente->id) ?></td>
                    <td><?= $odontogramaDiente->hasValue('odontograma') ? $this->Html->link($odontogramaDiente->odontograma->id, ['controller' => 'Odontograma', 'action' => 'view', $odontogramaDiente->odontograma->id]) : '' ?></td>
                    <td><?= $odontogramaDiente->hasValue('diente') ? $this->Html->link($odontogramaDiente->diente->nombre, ['controller' => 'Dientes', 'action' => 'view', $odontogramaDiente->diente->id]) : '' ?></td>
                    <td><?= h($odontogramaDiente->created_at) ?></td>
                    <td><?= h($odontogramaDiente->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $odontogramaDiente->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $odontogramaDiente->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $odontogramaDiente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaDiente->id)]) ?>
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
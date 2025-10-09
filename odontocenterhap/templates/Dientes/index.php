<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Diente> $dientes
 */
?>
<div class="dientes index content">
    <?= $this->Html->link(__('New Diente'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Dientes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nombre') ?></th>
                    <th><?= $this->Paginator->sort('posicion') ?></th>
                    <th><?= $this->Paginator->sort('imagen') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dientes as $diente): ?>
                <tr>
                    <td><?= $this->Number->format($diente->id) ?></td>
                    <td><?= h($diente->nombre) ?></td>
                    <td><?= $this->Number->format($diente->posicion) ?></td>
                    <td><?= h($diente->imagen) ?></td>
                    <td><?= h($diente->created_at) ?></td>
                    <td><?= h($diente->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $diente->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $diente->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $diente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $diente->id)]) ?>
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
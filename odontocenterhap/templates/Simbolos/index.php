<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Simbolo> $simbolos
 */
?>
<div class="simbolos index content">
    <?= $this->Html->link(__('New Simbolo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Simbolos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nombre') ?></th>
                    <th><?= $this->Paginator->sort('imagen') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($simbolos as $simbolo): ?>
                <tr>
                    <td><?= $this->Number->format($simbolo->id) ?></td>
                    <td><?= h($simbolo->nombre) ?></td>
                    <td><?= h($simbolo->imagen) ?></td>
                    <td><?= h($simbolo->created_at) ?></td>
                    <td><?= h($simbolo->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $simbolo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $simbolo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $simbolo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $simbolo->id)]) ?>
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
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\OdontogramaSimbolo> $odontogramaSimbolos
 */
?>
<div class="odontogramaSimbolos index content">
    <?= $this->Html->link(__('New Odontograma Simbolo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Odontograma Simbolos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('odontograma_id') ?></th>
                    <th><?= $this->Paginator->sort('simbolo_id') ?></th>
                    <th><?= $this->Paginator->sort('posicion_x') ?></th>
                    <th><?= $this->Paginator->sort('posicion_y') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($odontogramaSimbolos as $odontogramaSimbolo): ?>
                <tr>
                    <td><?= $this->Number->format($odontogramaSimbolo->id) ?></td>
                    <td><?= $odontogramaSimbolo->hasValue('odontograma') ? $this->Html->link($odontogramaSimbolo->odontograma->id, ['controller' => 'Odontograma', 'action' => 'view', $odontogramaSimbolo->odontograma->id]) : '' ?></td>
                    <td><?= $odontogramaSimbolo->hasValue('simbolo') ? $this->Html->link($odontogramaSimbolo->simbolo->nombre, ['controller' => 'Simbolos', 'action' => 'view', $odontogramaSimbolo->simbolo->id]) : '' ?></td>
                    <td><?= $odontogramaSimbolo->posicion_x === null ? '' : $this->Number->format($odontogramaSimbolo->posicion_x) ?></td>
                    <td><?= $odontogramaSimbolo->posicion_y === null ? '' : $this->Number->format($odontogramaSimbolo->posicion_y) ?></td>
                    <td><?= h($odontogramaSimbolo->created_at) ?></td>
                    <td><?= h($odontogramaSimbolo->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $odontogramaSimbolo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $odontogramaSimbolo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $odontogramaSimbolo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaSimbolo->id)]) ?>
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
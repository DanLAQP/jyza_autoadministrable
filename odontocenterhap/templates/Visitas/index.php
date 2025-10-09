<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Visita> $visitas
 */
?>
<div class="visitas index content">
    <?= $this->Html->link(__('New Visita'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Visitas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('orden_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_pago') ?></th>
                    <th><?= $this->Paginator->sort('abonado') ?></th>
                    <th><?= $this->Paginator->sort('fecha_entrega') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?= $this->Number->format($visita->id) ?></td>
                    <td><?= $visita->hasValue('ordene') ? $this->Html->link($visita->ordene->id, ['controller' => 'Ordenes', 'action' => 'view', $visita->ordene->id]) : '' ?></td>
                    <td><?= h($visita->tipo_pago) ?></td>
                    <td><?= $this->Number->format($visita->abonado) ?></td>
                    <td><?= h($visita->fecha_entrega) ?></td>
                    <td><?= h($visita->created) ?></td>
                    <td><?= h($visita->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $visita->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $visita->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $visita->id], ['confirm' => __('Are you sure you want to delete # {0}?', $visita->id)]) ?>
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
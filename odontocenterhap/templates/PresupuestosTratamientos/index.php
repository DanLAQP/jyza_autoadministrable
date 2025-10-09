<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PresupuestosTratamiento> $presupuestosTratamientos
 */
?>
<div class="presupuestosTratamientos index content">
    <?= $this->Html->link(__('New Presupuestos Tratamiento'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Presupuestos Tratamientos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('presupuesto_id') ?></th>
                    <th><?= $this->Paginator->sort('tratamiento_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('total') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($presupuestosTratamientos as $presupuestosTratamiento): ?>
                <tr>
                    <td><?= $this->Number->format($presupuestosTratamiento->id) ?></td>
                    <td><?= $presupuestosTratamiento->hasValue('presupuesto') ? $this->Html->link($presupuestosTratamiento->presupuesto->id, ['controller' => 'Presupuestos', 'action' => 'view', $presupuestosTratamiento->presupuesto->id]) : '' ?></td>
                    <td><?= $presupuestosTratamiento->hasValue('tratamiento') ? $this->Html->link($presupuestosTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $presupuestosTratamiento->tratamiento->id]) : '' ?></td>
                    <td><?= $this->Number->format($presupuestosTratamiento->cantidad) ?></td>
                    <td><?= $this->Number->format($presupuestosTratamiento->total) ?></td>
                    <td><?= h($presupuestosTratamiento->created) ?></td>
                    <td><?= h($presupuestosTratamiento->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $presupuestosTratamiento->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $presupuestosTratamiento->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $presupuestosTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $presupuestosTratamiento->id)]) ?>
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
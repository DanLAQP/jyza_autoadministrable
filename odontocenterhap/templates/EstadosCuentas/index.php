<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\EstadosCuenta> $estadosCuentas
 */
?>
<div class="estadosCuentas index content">
    <?= $this->Html->link(__('New Estados Cuenta'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Estados Cuentas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id') ?></th>
                    <th><?= $this->Paginator->sort('saldo_actual') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estadosCuentas as $estadosCuenta): ?>
                <tr>
                    <td><?= $this->Number->format($estadosCuenta->id) ?></td>
                    <td><?= $estadosCuenta->hasValue('paciente') ? $this->Html->link($estadosCuenta->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $estadosCuenta->paciente->id]) : '' ?></td>
                    <td><?= $estadosCuenta->saldo_actual === null ? '' : $this->Number->format($estadosCuenta->saldo_actual) ?></td>
                    <td><?= h($estadosCuenta->created) ?></td>
                    <td><?= h($estadosCuenta->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $estadosCuenta->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estadosCuenta->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estadosCuenta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estadosCuenta->id)]) ?>
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
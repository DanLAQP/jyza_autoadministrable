<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\EnfermedadesActuale> $enfermedadesActuales
 */
?>
<div class="enfermedadesActuales index content">
    <?= $this->Html->link(__('New Enfermedades Actuale'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Enfermedades Actuales') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id') ?></th>
                    <th><?= $this->Paginator->sort('tiempo_enfermedad') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enfermedadesActuales as $enfermedadesActuale): ?>
                <tr>
                    <td><?= $this->Number->format($enfermedadesActuale->id) ?></td>
                    <td><?= $enfermedadesActuale->hasValue('paciente') ? $this->Html->link($enfermedadesActuale->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $enfermedadesActuale->paciente->id]) : '' ?></td>
                    <td><?= h($enfermedadesActuale->tiempo_enfermedad) ?></td>
                    <td><?= h($enfermedadesActuale->created) ?></td>
                    <td><?= h($enfermedadesActuale->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $enfermedadesActuale->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $enfermedadesActuale->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $enfermedadesActuale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enfermedadesActuale->id)]) ?>
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
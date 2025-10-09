<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RegistrosTratamiento> $registrosTratamientos
 */
?>
<div class="registrosTratamientos index content">
    <?= $this->Html->link(__('New Registros Tratamiento'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Registros Tratamientos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id') ?></th>
                    <th><?= $this->Paginator->sort('tratamiento_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrosTratamientos as $registrosTratamiento): ?>
                <tr>
                    <td><?= $this->Number->format($registrosTratamiento->id) ?></td>
                    <td><?= $registrosTratamiento->hasValue('paciente') ? $this->Html->link($registrosTratamiento->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $registrosTratamiento->paciente->id]) : '' ?></td>
                    <td><?= $registrosTratamiento->hasValue('tratamiento') ? $this->Html->link($registrosTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $registrosTratamiento->tratamiento->id]) : '' ?></td>
                    <td><?= h($registrosTratamiento->created) ?></td>
                    <td><?= h($registrosTratamiento->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $registrosTratamiento->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registrosTratamiento->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registrosTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrosTratamiento->id)]) ?>
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
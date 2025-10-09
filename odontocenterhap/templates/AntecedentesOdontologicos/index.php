<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AntecedentesOdontologico> $antecedentesOdontologicos
 */
?>
<div class="antecedentesOdontologicos index content">
    <?= $this->Html->link(__('New Antecedentes Odontologico'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Antecedentes Odontologicos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id') ?></th>
                    <th><?= $this->Paginator->sort('frecuencia_visita') ?></th>
                    <th><?= $this->Paginator->sort('sangrado_encias') ?></th>
                    <th><?= $this->Paginator->sort('fecha_ultima_profilaxis') ?></th>
                    <th><?= $this->Paginator->sort('dolor_mandibula') ?></th>
                    <th><?= $this->Paginator->sort('satisfaccion_dental') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($antecedentesOdontologicos as $antecedentesOdontologico): ?>
                <tr>
                    <td><?= $this->Number->format($antecedentesOdontologico->id) ?></td>
                    <td><?= $antecedentesOdontologico->hasValue('paciente') ? $this->Html->link($antecedentesOdontologico->paciente->nombre, ['controller' => 'Pacientes', 'action' => 'view', $antecedentesOdontologico->paciente->id]) : '' ?></td>
                    <td><?= h($antecedentesOdontologico->frecuencia_visita) ?></td>
                    <td><?= h($antecedentesOdontologico->sangrado_encias) ?></td>
                    <td><?= h($antecedentesOdontologico->fecha_ultima_profilaxis) ?></td>
                    <td><?= h($antecedentesOdontologico->dolor_mandibula) ?></td>
                    <td><?= h($antecedentesOdontologico->satisfaccion_dental) ?></td>
                    <td><?= h($antecedentesOdontologico->created) ?></td>
                    <td><?= h($antecedentesOdontologico->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $antecedentesOdontologico->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $antecedentesOdontologico->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $antecedentesOdontologico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $antecedentesOdontologico->id)]) ?>
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
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AntecedentesMedico> $antecedentesMedicos
 */
?>
<div class="antecedentesMedicos index content">
    <?= $this->Html->link(__('New Antecedentes Medico'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Antecedentes Medicos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id') ?></th>
                    <th><?= $this->Paginator->sort('nombre_medico') ?></th>
                    <th><?= $this->Paginator->sort('telefono_medico') ?></th>
                    <th><?= $this->Paginator->sort('hepatitis') ?></th>
                    <th><?= $this->Paginator->sort('tipo_hepatitis') ?></th>
                    <th><?= $this->Paginator->sort('diabetes') ?></th>
                    <th><?= $this->Paginator->sort('diabetes_estado') ?></th>
                    <th><?= $this->Paginator->sort('condicion_cardiaca') ?></th>
                    <th><?= $this->Paginator->sort('tratamiento_cardiaco') ?></th>
                    <th><?= $this->Paginator->sort('presion_alta') ?></th>
                    <th><?= $this->Paginator->sort('estado_gestacion') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($antecedentesMedicos as $antecedentesMedico): ?>
                <tr>
                    <td><?= $this->Number->format($antecedentesMedico->id) ?></td>
                    <td><?= $antecedentesMedico->hasValue('paciente') ? $this->Html->link($antecedentesMedico->paciente->nombre, ['controller' => 'Pacientes', 'action' => 'view', $antecedentesMedico->paciente->id]) : '' ?></td>
                    <td><?= h($antecedentesMedico->nombre_medico) ?></td>
                    <td><?= h($antecedentesMedico->telefono_medico) ?></td>
                    <td><?= h($antecedentesMedico->hepatitis) ?></td>
                    <td><?= h($antecedentesMedico->tipo_hepatitis) ?></td>
                    <td><?= h($antecedentesMedico->diabetes) ?></td>
                    <td><?= h($antecedentesMedico->diabetes_estado) ?></td>
                    <td><?= h($antecedentesMedico->condicion_cardiaca) ?></td>
                    <td><?= h($antecedentesMedico->tratamiento_cardiaco) ?></td>
                    <td><?= h($antecedentesMedico->presion_alta) ?></td>
                    <td><?= h($antecedentesMedico->estado_gestacion) ?></td>
                    <td><?= h($antecedentesMedico->created) ?></td>
                    <td><?= h($antecedentesMedico->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $antecedentesMedico->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $antecedentesMedico->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $antecedentesMedico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $antecedentesMedico->id)]) ?>
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
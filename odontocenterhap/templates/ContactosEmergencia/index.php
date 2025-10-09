<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContactosEmergencium> $contactosEmergencia
 */
?>
<div class="contactosEmergencia index content">
    <?= $this->Html->link(__('New Contactos Emergencium'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Contactos Emergencia') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id') ?></th>
                    <th><?= $this->Paginator->sort('medico_confianza') ?></th>
                    <th><?= $this->Paginator->sort('servicio_ambulancia') ?></th>
                    <th><?= $this->Paginator->sort('nombre_contacto') ?></th>
                    <th><?= $this->Paginator->sort('telefono_contacto') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactosEmergencia as $contactosEmergencium): ?>
                <tr>
                    <td><?= $this->Number->format($contactosEmergencium->id) ?></td>
                    <td><?= $contactosEmergencium->hasValue('paciente') ? $this->Html->link($contactosEmergencium->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $contactosEmergencium->paciente->id]) : '' ?></td>
                    <td><?= h($contactosEmergencium->medico_confianza) ?></td>
                    <td><?= h($contactosEmergencium->servicio_ambulancia) ?></td>
                    <td><?= h($contactosEmergencium->nombre_contacto) ?></td>
                    <td><?= h($contactosEmergencium->telefono_contacto) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contactosEmergencium->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contactosEmergencium->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contactosEmergencium->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contactosEmergencium->id)]) ?>
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
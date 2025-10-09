<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactosEmergencium $contactosEmergencium
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Contactos Emergencium'), ['action' => 'edit', $contactosEmergencium->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Contactos Emergencium'), ['action' => 'delete', $contactosEmergencium->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contactosEmergencium->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Contactos Emergencia'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Contactos Emergencium'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contactosEmergencia view content">
            <h3><?= h($contactosEmergencium->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Paciente') ?></th>
                    <td><?= $contactosEmergencium->hasValue('paciente') ? $this->Html->link($contactosEmergencium->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $contactosEmergencium->paciente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Medico Confianza') ?></th>
                    <td><?= h($contactosEmergencium->medico_confianza) ?></td>
                </tr>
                <tr>
                    <th><?= __('Servicio Ambulancia') ?></th>
                    <td><?= h($contactosEmergencium->servicio_ambulancia) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre Contacto') ?></th>
                    <td><?= h($contactosEmergencium->nombre_contacto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefono Contacto') ?></th>
                    <td><?= h($contactosEmergencium->telefono_contacto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contactosEmergencium->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RegistrosTratamientos $registrosTratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Registros Tratamiento'), ['action' => 'edit', $registrosTratamientos->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Registros Tratamiento'), ['action' => 'delete', $registrosTratamientos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrosTratamientos->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Registros Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Registros Tratamiento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="registrosTratamientoss view content">
            <h3><?= h($registrosTratamientos->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Paciente') ?></th>
                    <td><?= $registrosTratamientos->hasValue('paciente') ? $this->Html->link($registrosTratamientos->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $registrosTratamientos->paciente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tratamiento') ?></th>
                    <td><?= $registrosTratamientos->hasValue('tratamiento') ? $this->Html->link($registrosTratamientos->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $registrosTratamientos->tratamiento->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($registrosTratamientos->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($registrosTratamientos->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($registrosTratamientos->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notas') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($registrosTratamientos->notas)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
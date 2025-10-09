<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EnfermedadesActuale $enfermedadesActuale
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Enfermedades Actuale'), ['action' => 'edit', $enfermedadesActuale->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Enfermedades Actuale'), ['action' => 'delete', $enfermedadesActuale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $enfermedadesActuale->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Enfermedades Actuales'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Enfermedades Actuale'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="enfermedadesActuales view content">
            <h3><?= h($enfermedadesActuale->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Paciente') ?></th>
                    <td><?= $enfermedadesActuale->hasValue('paciente') ? $this->Html->link($enfermedadesActuale->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $enfermedadesActuale->paciente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tiempo Enfermedad') ?></th>
                    <td><?= h($enfermedadesActuale->tiempo_enfermedad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($enfermedadesActuale->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($enfermedadesActuale->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($enfermedadesActuale->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Enfermedad') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($enfermedadesActuale->enfermedad)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Sintomas Principales') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($enfermedadesActuale->sintomas_principales)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
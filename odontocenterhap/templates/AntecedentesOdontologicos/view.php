<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AntecedentesOdontologico $antecedentesOdontologico
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Antecedentes Odontologico'), ['action' => 'edit', $antecedentesOdontologico->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Antecedentes Odontologico'), ['action' => 'delete', $antecedentesOdontologico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $antecedentesOdontologico->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Antecedentes Odontologicos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Antecedentes Odontologico'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="antecedentesOdontologicos view content">
            <h3><?= h($antecedentesOdontologico->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Paciente') ?></th>
                    <td><?= $antecedentesOdontologico->hasValue('paciente') ? $this->Html->link($antecedentesOdontologico->paciente->nombre, ['controller' => 'Pacientes', 'action' => 'view', $antecedentesOdontologico->paciente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Frecuencia Visita') ?></th>
                    <td><?= h($antecedentesOdontologico->frecuencia_visita) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dolor Mandibula') ?></th>
                    <td><?= h($antecedentesOdontologico->dolor_mandibula) ?></td>
                </tr>
                <tr>
                    <th><?= __('Satisfaccion Dental') ?></th>
                    <td><?= h($antecedentesOdontologico->satisfaccion_dental) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($antecedentesOdontologico->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Ultima Profilaxis') ?></th>
                    <td><?= h($antecedentesOdontologico->fecha_ultima_profilaxis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($antecedentesOdontologico->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($antecedentesOdontologico->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sangrado Encias') ?></th>
                    <td><?= $antecedentesOdontologico->sangrado_encias ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Motivo Consulta') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesOdontologico->motivo_consulta)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Experiencia Traumatica') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesOdontologico->experiencia_traumatica)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Extracciones Dentales') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesOdontologico->extracciones_dentales)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Complicaciones Anestesia') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesOdontologico->complicaciones_anestesia)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
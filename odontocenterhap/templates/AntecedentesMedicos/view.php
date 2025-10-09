<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AntecedentesMedico $antecedentesMedico
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Antecedentes Medico'), ['action' => 'edit', $antecedentesMedico->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Antecedentes Medico'), ['action' => 'delete', $antecedentesMedico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $antecedentesMedico->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Antecedentes Medicos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Antecedentes Medico'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="antecedentesMedicos view content">
            <h3><?= h($antecedentesMedico->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Paciente') ?></th>
                    <td><?= $antecedentesMedico->hasValue('paciente') ? $this->Html->link($antecedentesMedico->paciente->nombre, ['controller' => 'Pacientes', 'action' => 'view', $antecedentesMedico->paciente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombre Medico') ?></th>
                    <td><?= h($antecedentesMedico->nombre_medico) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefono Medico') ?></th>
                    <td><?= h($antecedentesMedico->telefono_medico) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hepatitis') ?></th>
                    <td><?= h($antecedentesMedico->hepatitis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Hepatitis') ?></th>
                    <td><?= h($antecedentesMedico->tipo_hepatitis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Diabetes') ?></th>
                    <td><?= h($antecedentesMedico->diabetes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Diabetes Estado') ?></th>
                    <td><?= h($antecedentesMedico->diabetes_estado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Condicion Cardiaca') ?></th>
                    <td><?= h($antecedentesMedico->condicion_cardiaca) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tratamiento Cardiaco') ?></th>
                    <td><?= h($antecedentesMedico->tratamiento_cardiaco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Presion Alta') ?></th>
                    <td><?= h($antecedentesMedico->presion_alta) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado Gestacion') ?></th>
                    <td><?= h($antecedentesMedico->estado_gestacion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($antecedentesMedico->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($antecedentesMedico->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($antecedentesMedico->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Alergias') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesMedico->alergias)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Medicacion') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesMedico->medicacion)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Enfermedad Riesgo') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($antecedentesMedico->enfermedad_riesgo)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
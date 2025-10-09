<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AntecedentesMedico $antecedentesMedico
 * @var \Cake\Collection\CollectionInterface|string[] $pacientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Antecedentes Medicos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="antecedentesMedicos form content">
            <?= $this->Form->create($antecedentesMedico) ?>
            <fieldset>
                <legend><?= __('Add Antecedentes Medico') ?></legend>
                <?php
                    echo $this->Form->control('paciente_id', ['options' => $pacientes, 'empty' => true]);
                    echo $this->Form->control('alergias');
                    echo $this->Form->control('medicacion');
                    echo $this->Form->control('nombre_medico');
                    echo $this->Form->control('telefono_medico');
                    echo $this->Form->control('hepatitis');
                    echo $this->Form->control('tipo_hepatitis');
                    echo $this->Form->control('diabetes');
                    echo $this->Form->control('diabetes_estado');
                    echo $this->Form->control('condicion_cardiaca');
                    echo $this->Form->control('tratamiento_cardiaco');
                    echo $this->Form->control('presion_alta');
                    echo $this->Form->control('enfermedad_riesgo');
                    echo $this->Form->control('estado_gestacion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

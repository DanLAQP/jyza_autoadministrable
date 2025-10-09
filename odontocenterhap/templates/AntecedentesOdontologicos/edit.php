<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AntecedentesOdontologico $antecedentesOdontologico
 * @var string[]|\Cake\Collection\CollectionInterface $pacientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $antecedentesOdontologico->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $antecedentesOdontologico->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Antecedentes Odontologicos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="antecedentesOdontologicos form content">
            <?= $this->Form->create($antecedentesOdontologico) ?>
            <fieldset>
                <legend><?= __('Edit Antecedentes Odontologico') ?></legend>
                <?php
                    echo $this->Form->control('paciente_id', ['options' => $pacientes, 'empty' => true]);
                    echo $this->Form->control('motivo_consulta');
                    echo $this->Form->control('frecuencia_visita');
                    echo $this->Form->control('experiencia_traumatica');
                    echo $this->Form->control('extracciones_dentales');
                    echo $this->Form->control('complicaciones_anestesia');
                    echo $this->Form->control('sangrado_encias');
                    echo $this->Form->control('fecha_ultima_profilaxis', ['empty' => true]);
                    echo $this->Form->control('dolor_mandibula');
                    echo $this->Form->control('satisfaccion_dental');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

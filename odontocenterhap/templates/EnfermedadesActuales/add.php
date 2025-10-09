<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EnfermedadesActuale $enfermedadesActuale
 * @var \Cake\Collection\CollectionInterface|string[] $pacientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Enfermedades Actuales'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="enfermedadesActuales form content">
            <?= $this->Form->create($enfermedadesActuale) ?>
            <fieldset>
                <legend><?= __('Add Enfermedades Actuale') ?></legend>
                <?php
                    echo $this->Form->control('paciente_id', ['options' => $pacientes, 'empty' => true]);
                    echo $this->Form->control('enfermedad');
                    echo $this->Form->control('tiempo_enfermedad');
                    echo $this->Form->control('sintomas_principales');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

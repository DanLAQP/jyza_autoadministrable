<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RegistrosTratamientos $registrosTratamientos
 * @var \Cake\Collection\CollectionInterface|string[] $pacientes
 * @var \Cake\Collection\CollectionInterface|string[] $tratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Registros Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="registrosTratamientos form content">
            <?= $this->Form->create($registrosTratamientos) ?>
            <fieldset>
                <legend><?= __('Add Registros Tratamiento') ?></legend>
                <?php
                    echo $this->Form->control('paciente_id', ['options' => $pacientes, 'empty' => true]);
                    echo $this->Form->control('tratamiento_id', ['options' => $tratamientos, 'empty' => true]);
                    echo $this->Form->control('notas');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

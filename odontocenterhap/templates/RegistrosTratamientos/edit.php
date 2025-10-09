<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RegistrosTratamientos $registrosTratamientos
 * @var string[]|\Cake\Collection\CollectionInterface $pacientes
 * @var string[]|\Cake\Collection\CollectionInterface $tratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $registrosTratamientos->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $registrosTratamientos->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Registros Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="registrosTratamientos form content">
            <?= $this->Form->create($registrosTratamientos) ?>
            <fieldset>
                <legend><?= __('Edit Registros Tratamiento') ?></legend>
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

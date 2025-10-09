<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactosEmergencium $contactosEmergencium
 * @var string[]|\Cake\Collection\CollectionInterface $pacientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contactosEmergencium->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contactosEmergencium->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Contactos Emergencia'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contactosEmergencia form content">
            <?= $this->Form->create($contactosEmergencium) ?>
            <fieldset>
                <legend><?= __('Edit Contactos Emergencium') ?></legend>
                <?php
                    echo $this->Form->control('paciente_id', ['options' => $pacientes, 'empty' => true]);
                    echo $this->Form->control('medico_confianza');
                    echo $this->Form->control('servicio_ambulancia');
                    echo $this->Form->control('nombre_contacto');
                    echo $this->Form->control('telefono_contacto');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

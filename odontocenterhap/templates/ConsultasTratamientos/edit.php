<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ConsultasTratamiento $consultasTratamiento
 * @var string[]|\Cake\Collection\CollectionInterface $registrosConsultas
 * @var string[]|\Cake\Collection\CollectionInterface $tratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $consultasTratamiento->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $consultasTratamiento->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Consultas Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="consultasTratamientos form content">
            <?= $this->Form->create($consultasTratamiento) ?>
            <fieldset>
                <legend><?= __('Edit Consultas Tratamiento') ?></legend>
                <?php
                    echo $this->Form->control('registro_id', ['options' => $registrosConsultas]);
                    echo $this->Form->control('tratamiento_id', ['options' => $tratamientos]);
                    echo $this->Form->control('costo');
                    echo $this->Form->control('monto_clinica');
                    echo $this->Form->control('monto_doctor');
                    echo $this->Form->control('monto_materiales');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

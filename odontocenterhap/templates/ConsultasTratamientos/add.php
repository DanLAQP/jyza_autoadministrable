<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ConsultasTratamiento $consultasTratamiento
 * @var \Cake\Collection\CollectionInterface|string[] $registrosConsultas
 * @var \Cake\Collection\CollectionInterface|string[] $tratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Consultas Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="consultasTratamientos form content">
            <?= $this->Form->create($consultasTratamiento) ?>
            <fieldset>
                <legend><?= __('Add Consultas Tratamiento') ?></legend>
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

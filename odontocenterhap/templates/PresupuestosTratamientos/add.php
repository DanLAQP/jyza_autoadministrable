<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PresupuestosTratamiento $presupuestosTratamiento
 * @var \Cake\Collection\CollectionInterface|string[] $presupuestos
 * @var \Cake\Collection\CollectionInterface|string[] $tratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Presupuestos Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="presupuestosTratamientos form content">
            <?= $this->Form->create($presupuestosTratamiento) ?>
            <fieldset>
                <legend><?= __('Add Presupuestos Tratamiento') ?></legend>
                <?php
                    echo $this->Form->control('presupuesto_id', ['options' => $presupuestos]);
                    echo $this->Form->control('tratamiento_id', ['options' => $tratamientos]);
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('total');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

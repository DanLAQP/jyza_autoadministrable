<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrdenesTratamiento $ordenesTratamiento
 * @var \Cake\Collection\CollectionInterface|string[] $ordenes
 * @var \Cake\Collection\CollectionInterface|string[] $tratamientos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Ordenes Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="ordenesTratamientos form content">
            <?= $this->Form->create($ordenesTratamiento) ?>
            <fieldset>
                <legend><?= __('Add Ordenes Tratamiento') ?></legend>
                <?php
                    echo $this->Form->control('orden_id', ['options' => $ordenes]);
                    echo $this->Form->control('tratamiento_id', ['options' => $tratamientos]);
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('precio_unitario');
                    echo $this->Form->control('subtotal');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

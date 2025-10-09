<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaDetalle $odontogramaDetalle
 * @var \Cake\Collection\CollectionInterface|string[] $odontograma
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Odontograma Detalles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaDetalles form content">
            <?= $this->Form->create($odontogramaDetalle) ?>
            <fieldset>
                <legend><?= __('Add Odontograma Detalle') ?></legend>
                <?php
                    echo $this->Form->control('odontograma_id', ['options' => $odontograma]);
                    echo $this->Form->control('especificaciones');
                    echo $this->Form->control('observaciones');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

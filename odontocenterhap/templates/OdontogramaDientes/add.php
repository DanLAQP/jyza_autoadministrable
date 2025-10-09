<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaDiente $odontogramaDiente
 * @var \Cake\Collection\CollectionInterface|string[] $odontograma
 * @var \Cake\Collection\CollectionInterface|string[] $dientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Odontograma Dientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaDientes form content">
            <?= $this->Form->create($odontogramaDiente) ?>
            <fieldset>
                <legend><?= __('Add Odontograma Diente') ?></legend>
                <?php
                    echo $this->Form->control('odontograma_id', ['options' => $odontograma]);
                    echo $this->Form->control('diente_id', ['options' => $dientes]);
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

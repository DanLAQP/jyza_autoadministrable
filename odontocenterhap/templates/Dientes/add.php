<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Diente $diente
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Dientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="dientes form content">
            <?= $this->Form->create($diente) ?>
            <fieldset>
                <legend><?= __('Add Diente') ?></legend>
                <?php
                    echo $this->Form->control('nombre');
                    echo $this->Form->control('posicion');
                    echo $this->Form->control('imagen');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

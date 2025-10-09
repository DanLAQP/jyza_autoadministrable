<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaDiente $odontogramaDiente
 * @var string[]|\Cake\Collection\CollectionInterface $odontograma
 * @var string[]|\Cake\Collection\CollectionInterface $dientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $odontogramaDiente->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaDiente->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Odontograma Dientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaDientes form content">
            <?= $this->Form->create($odontogramaDiente) ?>
            <fieldset>
                <legend><?= __('Edit Odontograma Diente') ?></legend>
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

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Simbolo $simbolo
 * @var string[]|\Cake\Collection\CollectionInterface $odontograma
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $simbolo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $simbolo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Simbolos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="simbolos form content">
            <?= $this->Form->create($simbolo) ?>
            <fieldset>
                <legend><?= __('Edit Simbolo') ?></legend>
                <?php
                    echo $this->Form->control('nombre');
                    echo $this->Form->control('imagen');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                    echo $this->Form->control('odontograma._ids', ['options' => $odontograma]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

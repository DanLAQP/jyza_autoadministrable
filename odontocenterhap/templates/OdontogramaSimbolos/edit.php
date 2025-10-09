<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaSimbolo $odontogramaSimbolo
 * @var string[]|\Cake\Collection\CollectionInterface $odontograma
 * @var string[]|\Cake\Collection\CollectionInterface $simbolos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $odontogramaSimbolo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaSimbolo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Odontograma Simbolos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaSimbolos form content">
            <?= $this->Form->create($odontogramaSimbolo) ?>
            <fieldset>
                <legend><?= __('Edit Odontograma Simbolo') ?></legend>
                <?php
                    echo $this->Form->control('odontograma_id', ['options' => $odontograma]);
                    echo $this->Form->control('simbolo_id', ['options' => $simbolos]);
                    echo $this->Form->control('posicion_x');
                    echo $this->Form->control('posicion_y');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Modulo $modulo
 * @var string[]|\Cake\Collection\CollectionInterface $cursos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $modulo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $modulo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Modulos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="modulos form content">
            <?= $this->Form->create($modulo) ?>
            <fieldset>
                <legend><?= __('Edit Modulo') ?></legend>
                <?php
                    echo $this->Form->control('curso_id', ['options' => $cursos]);
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('posicion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

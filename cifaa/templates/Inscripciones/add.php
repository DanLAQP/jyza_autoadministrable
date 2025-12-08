<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inscripciones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inscripciones form content">
            <?= $this->Form->create($inscripcione) ?>
            <fieldset>
                <legend><?= __('Add Inscripcione') ?></legend>
                <?php
                    echo $this->Form->control('usuario_id', ['options' => $users]);
                    echo $this->Form->control('curso_id', ['options' => $cursos]);
                    echo $this->Form->control('progreso');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

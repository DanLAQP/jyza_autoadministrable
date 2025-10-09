<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 * @var string[]|\Cake\Collection\CollectionInterface $ordenes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $visita->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $visita->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="visitas form content">
            <?= $this->Form->create($visita) ?>
            <fieldset>
                <legend><?= __('Edit Visita') ?></legend>
                <?php
                    echo $this->Form->control('orden_id', ['options' => $ordenes]);
                    echo $this->Form->control('tipo_pago');
                    echo $this->Form->control('abonado');
                    echo $this->Form->control('fecha_entrega', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

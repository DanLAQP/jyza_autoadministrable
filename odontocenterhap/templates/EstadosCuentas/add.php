<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EstadosCuenta $estadosCuenta
 * @var \Cake\Collection\CollectionInterface|string[] $pacientes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Estados Cuentas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="estadosCuentas form content">
            <?= $this->Form->create($estadosCuenta) ?>
            <fieldset>
                <legend><?= __('Add Estados Cuenta') ?></legend>
                <?php
                    echo $this->Form->control('paciente_id', ['options' => $pacientes, 'empty' => true]);
                    echo $this->Form->control('saldo_actual');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

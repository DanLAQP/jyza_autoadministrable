<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EstadosCuenta $estadosCuenta
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Estados Cuenta'), ['action' => 'edit', $estadosCuenta->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Estados Cuenta'), ['action' => 'delete', $estadosCuenta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estadosCuenta->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Estados Cuentas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Estados Cuenta'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="estadosCuentas view content">
            <h3><?= h($estadosCuenta->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Paciente') ?></th>
                    <td><?= $estadosCuenta->hasValue('paciente') ? $this->Html->link($estadosCuenta->paciente->id, ['controller' => 'Pacientes', 'action' => 'view', $estadosCuenta->paciente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($estadosCuenta->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Saldo Actual') ?></th>
                    <td><?= $estadosCuenta->saldo_actual === null ? '' : $this->Number->format($estadosCuenta->saldo_actual) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($estadosCuenta->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($estadosCuenta->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PresupuestosTratamiento $presupuestosTratamiento
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Presupuestos Tratamiento'), ['action' => 'edit', $presupuestosTratamiento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Presupuestos Tratamiento'), ['action' => 'delete', $presupuestosTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $presupuestosTratamiento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Presupuestos Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Presupuestos Tratamiento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="presupuestosTratamientos view content">
            <h3><?= h($presupuestosTratamiento->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Presupuesto') ?></th>
                    <td><?= $presupuestosTratamiento->hasValue('presupuesto') ? $this->Html->link($presupuestosTratamiento->presupuesto->id, ['controller' => 'Presupuestos', 'action' => 'view', $presupuestosTratamiento->presupuesto->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tratamiento') ?></th>
                    <td><?= $presupuestosTratamiento->hasValue('tratamiento') ? $this->Html->link($presupuestosTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $presupuestosTratamiento->tratamiento->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($presupuestosTratamiento->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($presupuestosTratamiento->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td><?= $this->Number->format($presupuestosTratamiento->total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($presupuestosTratamiento->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($presupuestosTratamiento->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
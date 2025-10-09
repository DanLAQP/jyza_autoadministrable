<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrdenesTratamiento $ordenesTratamiento
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Ordenes Tratamiento'), ['action' => 'edit', $ordenesTratamiento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ordenes Tratamiento'), ['action' => 'delete', $ordenesTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordenesTratamiento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Ordenes Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ordenes Tratamiento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="ordenesTratamientos view content">
            <h3><?= h($ordenesTratamiento->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Ordene') ?></th>
                    <td><?= $ordenesTratamiento->hasValue('ordene') ? $this->Html->link($ordenesTratamiento->ordene->id, ['controller' => 'Ordenes', 'action' => 'view', $ordenesTratamiento->ordene->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tratamiento') ?></th>
                    <td><?= $ordenesTratamiento->hasValue('tratamiento') ? $this->Html->link($ordenesTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $ordenesTratamiento->tratamiento->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($ordenesTratamiento->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($ordenesTratamiento->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Precio Unitario') ?></th>
                    <td><?= $this->Number->format($ordenesTratamiento->precio_unitario) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtotal') ?></th>
                    <td><?= $this->Number->format($ordenesTratamiento->subtotal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($ordenesTratamiento->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($ordenesTratamiento->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
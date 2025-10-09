<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaDetalle $odontogramaDetalle
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Odontograma Detalle'), ['action' => 'edit', $odontogramaDetalle->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Odontograma Detalle'), ['action' => 'delete', $odontogramaDetalle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaDetalle->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Odontograma Detalles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Odontograma Detalle'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaDetalles view content">
            <h3><?= h($odontogramaDetalle->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Odontograma') ?></th>
                    <td><?= $odontogramaDetalle->hasValue('odontograma') ? $this->Html->link($odontogramaDetalle->odontograma->id, ['controller' => 'Odontograma', 'action' => 'view', $odontogramaDetalle->odontograma->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Especificaciones') ?></th>
                    <td><?= h($odontogramaDetalle->especificaciones) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observaciones') ?></th>
                    <td><?= h($odontogramaDetalle->observaciones) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($odontogramaDetalle->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($odontogramaDetalle->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($odontogramaDetalle->updated_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
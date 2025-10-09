<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Visita'), ['action' => 'edit', $visita->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Visita'), ['action' => 'delete', $visita->id], ['confirm' => __('Are you sure you want to delete # {0}?', $visita->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Visitas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Visita'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="visitas view content">
            <h3><?= h($visita->tipo_pago) ?></h3>
            <table>
                <tr>
                    <th><?= __('Ordene') ?></th>
                    <td><?= $visita->hasValue('ordene') ? $this->Html->link($visita->ordene->id, ['controller' => 'Ordenes', 'action' => 'view', $visita->ordene->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Pago') ?></th>
                    <td><?= h($visita->tipo_pago) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($visita->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Abonado') ?></th>
                    <td><?= $this->Number->format($visita->abonado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Entrega') ?></th>
                    <td><?= h($visita->fecha_entrega) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($visita->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($visita->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
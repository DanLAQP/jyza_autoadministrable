<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaDiente $odontogramaDiente
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Odontograma Diente'), ['action' => 'edit', $odontogramaDiente->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Odontograma Diente'), ['action' => 'delete', $odontogramaDiente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaDiente->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Odontograma Dientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Odontograma Diente'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaDientes view content">
            <h3><?= h($odontogramaDiente->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Odontograma') ?></th>
                    <td><?= $odontogramaDiente->hasValue('odontograma') ? $this->Html->link($odontogramaDiente->odontograma->id, ['controller' => 'Odontograma', 'action' => 'view', $odontogramaDiente->odontograma->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Diente') ?></th>
                    <td><?= $odontogramaDiente->hasValue('diente') ? $this->Html->link($odontogramaDiente->diente->nombre, ['controller' => 'Dientes', 'action' => 'view', $odontogramaDiente->diente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($odontogramaDiente->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($odontogramaDiente->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($odontogramaDiente->updated_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
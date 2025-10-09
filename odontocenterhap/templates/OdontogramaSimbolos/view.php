<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OdontogramaSimbolo $odontogramaSimbolo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Odontograma Simbolo'), ['action' => 'edit', $odontogramaSimbolo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Odontograma Simbolo'), ['action' => 'delete', $odontogramaSimbolo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $odontogramaSimbolo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Odontograma Simbolos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Odontograma Simbolo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="odontogramaSimbolos view content">
            <h3><?= h($odontogramaSimbolo->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Odontograma') ?></th>
                    <td><?= $odontogramaSimbolo->hasValue('odontograma') ? $this->Html->link($odontogramaSimbolo->odontograma->id, ['controller' => 'Odontograma', 'action' => 'view', $odontogramaSimbolo->odontograma->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Simbolo') ?></th>
                    <td><?= $odontogramaSimbolo->hasValue('simbolo') ? $this->Html->link($odontogramaSimbolo->simbolo->nombre, ['controller' => 'Simbolos', 'action' => 'view', $odontogramaSimbolo->simbolo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($odontogramaSimbolo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Posicion X') ?></th>
                    <td><?= $odontogramaSimbolo->posicion_x === null ? '' : $this->Number->format($odontogramaSimbolo->posicion_x) ?></td>
                </tr>
                <tr>
                    <th><?= __('Posicion Y') ?></th>
                    <td><?= $odontogramaSimbolo->posicion_y === null ? '' : $this->Number->format($odontogramaSimbolo->posicion_y) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($odontogramaSimbolo->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($odontogramaSimbolo->updated_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
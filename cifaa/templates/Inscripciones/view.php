<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inscripcione'), ['action' => 'edit', $inscripcione->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inscripcione'), ['action' => 'delete', $inscripcione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscripcione->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inscripciones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inscripcione'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inscripciones view content">
            <h3><?= h($inscripcione->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $inscripcione->hasValue('user') ? $this->Html->link($inscripcione->user->username, ['controller' => 'Users', 'action' => 'view', $inscripcione->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Curso') ?></th>
                    <td><?= $inscripcione->hasValue('curso') ? $this->Html->link($inscripcione->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $inscripcione->curso->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inscripcione->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Progreso') ?></th>
                    <td><?= $inscripcione->progreso === null ? '' : $this->Number->format($inscripcione->progreso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($inscripcione->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($inscripcione->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
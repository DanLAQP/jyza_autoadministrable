<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Simbolo $simbolo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Simbolo'), ['action' => 'edit', $simbolo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Simbolo'), ['action' => 'delete', $simbolo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $simbolo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Simbolos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Simbolo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="simbolos view content">
            <h3><?= h($simbolo->nombre) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($simbolo->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Imagen') ?></th>
                    <td><?= h($simbolo->imagen) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($simbolo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($simbolo->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($simbolo->updated_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Odontograma') ?></h4>
                <?php if (!empty($simbolo->odontograma)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Paciente Id') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($simbolo->odontograma as $odontograma) : ?>
                        <tr>
                            <td><?= h($odontograma->id) ?></td>
                            <td><?= h($odontograma->paciente_id) ?></td>
                            <td><?= h($odontograma->created_at) ?></td>
                            <td><?= h($odontograma->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Odontograma', 'action' => 'view', $odontograma->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Odontograma', 'action' => 'edit', $odontograma->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Odontograma', 'action' => 'delete', $odontograma->id], ['confirm' => __('Are you sure you want to delete # {0}?', $odontograma->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Diente $diente
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Diente'), ['action' => 'edit', $diente->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Diente'), ['action' => 'delete', $diente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $diente->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Dientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Diente'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="dientes view content">
            <h3><?= h($diente->nombre) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nombre') ?></th>
                    <td><?= h($diente->nombre) ?></td>
                </tr>
                <tr>
                    <th><?= __('Imagen') ?></th>
                    <td><?= h($diente->imagen) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($diente->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Posicion') ?></th>
                    <td><?= $this->Number->format($diente->posicion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($diente->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($diente->updated_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Odontograma') ?></h4>
                <?php if (!empty($diente->odontograma)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Paciente Id') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($diente->odontograma as $odontograma) : ?>
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
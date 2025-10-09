<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ConsultasTratamiento> $consultasTratamientos
 */
?>
<div class="consultasTratamientos index content">
    <?= $this->Html->link(__('New Consultas Tratamiento'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Consultas Tratamientos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('registro_id') ?></th>
                    <th><?= $this->Paginator->sort('tratamiento_id') ?></th>
                    <th><?= $this->Paginator->sort('costo') ?></th>
                    <th><?= $this->Paginator->sort('monto_clinica') ?></th>
                    <th><?= $this->Paginator->sort('monto_doctor') ?></th>
                    <th><?= $this->Paginator->sort('monto_materiales') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultasTratamientos as $consultasTratamiento): ?>
                <tr>
                    <td><?= $this->Number->format($consultasTratamiento->id) ?></td>
                    <td><?= $consultasTratamiento->hasValue('registros_consulta') ? $this->Html->link($consultasTratamiento->registros_consulta->id, ['controller' => 'RegistrosConsultas', 'action' => 'view', $consultasTratamiento->registros_consulta->id]) : '' ?></td>
                    <td><?= $consultasTratamiento->hasValue('tratamiento') ? $this->Html->link($consultasTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $consultasTratamiento->tratamiento->id]) : '' ?></td>
                    <td><?= $this->Number->format($consultasTratamiento->costo) ?></td>
                    <td><?= $this->Number->format($consultasTratamiento->monto_clinica) ?></td>
                    <td><?= $this->Number->format($consultasTratamiento->monto_doctor) ?></td>
                    <td><?= $this->Number->format($consultasTratamiento->monto_materiales) ?></td>
                    <td><?= h($consultasTratamiento->created) ?></td>
                    <td><?= h($consultasTratamiento->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $consultasTratamiento->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consultasTratamiento->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consultasTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consultasTratamiento->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CertificadoModulo> $certificadoModulos
 */
?>
<div class="certificadoModulos index content">
    <?= $this->Html->link(__('New Certificado Modulo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Certificado Modulos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('certificado_id') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <th><?= $this->Paginator->sort('horas') ?></th>
                    <th><?= $this->Paginator->sort('posicion') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certificadoModulos as $certificadoModulo): ?>
                <tr>
                    <td><?= $this->Number->format($certificadoModulo->id) ?></td>
                    <td><?= $certificadoModulo->hasValue('certificado') ? $this->Html->link($certificadoModulo->certificado->tipo, ['controller' => 'Certificados', 'action' => 'view', $certificadoModulo->certificado->id]) : '' ?></td>
                    <td><?= h($certificadoModulo->titulo) ?></td>
                    <td><?= $certificadoModulo->horas === null ? '' : $this->Number->format($certificadoModulo->horas) ?></td>
                    <td><?= $this->Number->format($certificadoModulo->posicion) ?></td>
                    <td><?= h($certificadoModulo->created) ?></td>
                    <td><?= h($certificadoModulo->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $certificadoModulo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $certificadoModulo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $certificadoModulo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certificadoModulo->id)]) ?>
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
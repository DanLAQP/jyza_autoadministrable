<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CertificadoModulo $certificadoModulo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Certificado Modulo'), ['action' => 'edit', $certificadoModulo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Certificado Modulo'), ['action' => 'delete', $certificadoModulo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certificadoModulo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Certificado Modulos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Certificado Modulo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="certificadoModulos view content">
            <h3><?= h($certificadoModulo->titulo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Certificado') ?></th>
                    <td><?= $certificadoModulo->hasValue('certificado') ? $this->Html->link($certificadoModulo->certificado->tipo, ['controller' => 'Certificados', 'action' => 'view', $certificadoModulo->certificado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Titulo') ?></th>
                    <td><?= h($certificadoModulo->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($certificadoModulo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Horas') ?></th>
                    <td><?= $certificadoModulo->horas === null ? '' : $this->Number->format($certificadoModulo->horas) ?></td>
                </tr>
                <tr>
                    <th><?= __('Posicion') ?></th>
                    <td><?= $this->Number->format($certificadoModulo->posicion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($certificadoModulo->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($certificadoModulo->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descripcion') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($certificadoModulo->descripcion)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
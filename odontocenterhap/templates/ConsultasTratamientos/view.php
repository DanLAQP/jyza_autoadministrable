<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ConsultasTratamiento $consultasTratamiento
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Consultas Tratamiento'), ['action' => 'edit', $consultasTratamiento->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Consultas Tratamiento'), ['action' => 'delete', $consultasTratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consultasTratamiento->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Consultas Tratamientos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Consultas Tratamiento'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="consultasTratamientos view content">
            <h3><?= h($consultasTratamiento->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Registros Consulta') ?></th>
                    <td><?= $consultasTratamiento->hasValue('registros_consulta') ? $this->Html->link($consultasTratamiento->registros_consulta->id, ['controller' => 'RegistrosConsultas', 'action' => 'view', $consultasTratamiento->registros_consulta->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tratamiento') ?></th>
                    <td><?= $consultasTratamiento->hasValue('tratamiento') ? $this->Html->link($consultasTratamiento->tratamiento->id, ['controller' => 'Tratamientos', 'action' => 'view', $consultasTratamiento->tratamiento->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($consultasTratamiento->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Costo') ?></th>
                    <td><?= $this->Number->format($consultasTratamiento->costo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto Clinica') ?></th>
                    <td><?= $this->Number->format($consultasTratamiento->monto_clinica) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto Doctor') ?></th>
                    <td><?= $this->Number->format($consultasTratamiento->monto_doctor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monto Materiales') ?></th>
                    <td><?= $this->Number->format($consultasTratamiento->monto_materiales) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($consultasTratamiento->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($consultasTratamiento->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
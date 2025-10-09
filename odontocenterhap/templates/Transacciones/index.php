<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Transaccione> $transacciones
 */
?>
<div class="transacciones index content">
    <?= $this->Html->link(__('Añadir Transacción'), ['action' => 'add'], ['class' => 'button float-right btn btn-info openModal']) ?>

    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead class="bg-info text-white">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('producto_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_transaccion') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('fecha_transaccion') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transacciones as $transaccione): ?>
                <tr>
                    <td><?= $this->Number->format($transaccione->id) ?></td>
                    <td>
                        <?= $transaccione->hasValue('producto') 
                            ? $this->Html->link(
                                $transaccione->producto->nombre, 
                                ['controller' => 'Productos', 'action' => 'view', $transaccione->producto->id], 
                                ['class' => 'openModal  text-white btn-link']
                            ) 
                            : '' 
                        ?>
                    </td>
                    <td><?= h($transaccione->tipo_transaccion) ?></td>
                    <td><?= $this->Number->format($transaccione->cantidad) ?></td>
                    <td><?= h($transaccione->fecha_transaccion) ?></td>
                    <td><?= $this->Number->format($transaccione->user_id) ?></td>
                    <td class="actions text-center">
                        <!-- Íconos personalizados para acciones -->
                        <?= $this->Html->link(
                            '<i class="fas fa-eye"></i>',
                            ['action' => 'view', $transaccione->id],
                            ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                        ) ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-edit"></i>',
                            ['action' => 'edit', $transaccione->id],
                            ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm openModal']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('Primero')) ?>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')) ?></p>
    </div>
</div>

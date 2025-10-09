<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Egreso> $egresos
 */
?>

<?= $this->Html->link(__('Añadir Egreso'), ['action' => 'add'], [
    'class' => 'button float-right btn btn-info openModal d-block d-sm-inline-block mt-3 mb-3'
]) ?>

<div class="egresos index content">
    <div class="contenedor principal">
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead class="bg-info text-white">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('cantidad', 'Cantidad') ?></th>
                        <th><?= $this->Paginator->sort('descripcion', 'Descripcion') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                        <th class="actions text-white text-center"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($egresos as $egreso): ?>
                    <tr>
                        <td><?= $this->Number->format($egreso->id) ?></td>
                        <td><?= $egreso->cantidad !== null ? $this->Number->currency($egreso->cantidad, 'S/. ') : '&nbsp;' ?></td>
                        <td><?= h($egreso->descripcion) ?></td>
                        <td><?= h($egreso->created) ?></td>
                        <td class="actions text-center">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $egreso->id],
                                ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $egreso->id],
                                ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm openModal']
                            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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

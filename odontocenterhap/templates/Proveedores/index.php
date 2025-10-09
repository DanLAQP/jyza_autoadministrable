<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Proveedore> $proveedores
 * @var string $searchTerm
 */
?>
<div class="proveedores index content">
    <?= $this->Html->link(__('Añadir Proveedor'), ['action' => 'add'], ['class' => 'button float-right btn btn-info openModal']) ?>

    <div class="contenedor principal">
        <div class="table-responsive">
            <?php if ($proveedores->items()->isEmpty()): ?>
                
            <?php else: ?>
                <table class="table table-striped mt-3">
                    <thead class="bg-info text-white">
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('nombre', 'Nombre') ?></th>
                            <th><?= $this->Paginator->sort('contacto_nombre', 'Contacto') ?></th>
                            <th><?= $this->Paginator->sort('contacto_email', 'Email') ?></th>
                            <th><?= $this->Paginator->sort('contacto_telefono', 'Teléfono') ?></th>
                            <th class="actions text-dark"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proveedores as $proveedore): ?>
                        <tr>
                            <td><?= $this->Number->format($proveedore->id) ?></td>
                            <td><?= h($proveedore->nombre) ?></td>
                            <td><?= h($proveedore->contacto_nombre) ?></td>
                            <td><?= h($proveedore->contacto_email) ?></td>
                            <td><?= h($proveedore->contacto_telefono) ?></td>
                            <td class="actions text-center">
                                <!-- Íconos personalizados para acciones -->
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $proveedore->id],
                                    ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $proveedore->id],
                                    ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm openModal']
                                ) ?>
                                
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
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

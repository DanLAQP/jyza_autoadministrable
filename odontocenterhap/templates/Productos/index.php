<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Producto> $productos
 * @var string $searchTerm
 */
?>

<div class="productos index content">
    <?= $this->Html->link(__('Añadir Producto'), ['action' => 'add'], ['class' => 'button float-right btn btn-info openModal' ]) ?>

    <div class="contenedor principal">
        <div class="table-responsive">
            <?php if ($productos->items()->isEmpty()): ?>
                
            <?php else: ?>
                <table class="table table-striped mt-3">
                    <thead class="bg-info text-white">
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('nombre', 'Nombre') ?></th>
                            <th><?= $this->Paginator->sort('categoria_id', 'Categoría') ?></th>
                            <th><?= $this->Paginator->sort('cantidad', 'Cantidad') ?></th>
                            <th><?= $this->Paginator->sort('precio', 'Precio') ?></th>
                            <th><?= $this->Paginator->sort('proveedor_id', 'Proveedor') ?></th>
                            <th><?= $this->Paginator->sort('fecha_vencimiento', 'Fecha Vencimiento') ?></th>
                            <th><?= $this->Paginator->sort('fecha_ingreso', 'Fecha Ingreso') ?></th>
                            <th><?= $this->Paginator->sort('ubicacion', 'Ubicación') ?></th>
                            <th><?= $this->Paginator->sort('stock_minimo', 'Stock Mínimo') ?></th>
                            <th><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                            <th class="actions text-dark"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= $this->Number->format($producto->id) ?></td>
                            <td><?= h($producto->nombre) ?></td>
                            <td><?= $producto->hasValue('categoria') 
                                    ? $this->Html->link(h($producto->categoria->nombre), ['controller' => 'Categorias', 'action' => 'view', $producto->categoria->id],['class' => 'text-white openModal'])
                                    : 'N/A' 
                                ?>
                            </td>
                            <td><?= $producto->cantidad === null ? '' : $this->Number->format($producto->cantidad) ?></td>
                            <td><?= $this->Number->format($producto->precio) ?></td>
                            <td><?= $producto->hasValue('proveedore') 
                                    ? $this->Html->link(h($producto->proveedore->nombre), ['controller' => 'Proveedores', 'action' => 'view', $producto->proveedore->id],['class' => 'text-white openModal']) 
                                    : 'N/A' 
                                ?>
                            </td>
                            <td><?= h($producto->fecha_vencimiento) ?></td>
                            <td><?= h($producto->fecha_ingreso) ?></td>
                            <td><?= h($producto->ubicacion) ?></td>
                            <td><?= $producto->stock_minimo === null ? '' : $this->Number->format($producto->stock_minimo) ?></td>
                            <td><?= h($producto->estado) ?></td>
                            <td class="actions text-center">
                                <!-- Íconos personalizados para acciones -->
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $producto->id],
                                    ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $producto->id],
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

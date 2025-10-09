<style>
    .label-text {
        color: #f8f9fa;
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
        min-height: 38px;
        display: flex;
        align-items: center;
        color: #ffffff;
    }
</style>

<div class="container mt-4 mb-4">
    <!-- Título -->
    <div class="mb-4">
        <h3 class="text-info"><i class="fas fa-tags me-2"></i> Detalles de la Categoría</h3>
    </div>

    <!-- Información de la Categoría -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Nombre:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($categoria->nombre) ?></div>
        </div>
    </div>

    <!-- ID de la Categoría -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('ID:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= $this->Number->format($categoria->id) ?></div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Descripción:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($categoria->descripcion) ?: 'No especificada' ?></div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Html->link(__('Editar Categoría'), ['action' => 'edit', $categoria->id], ['class' => 'btn btn-warning me-2 openModal', 'target' => '_blank']) ?>
        <?= $this->Html->link(__('Regresar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <!-- Productos Relacionados -->
    <?php if (!empty($categoria->productos)) : ?>
        <div class="mt-4">
            <h4 class="text-info"><i class="fas fa-box-open me-2"></i> Productos en esta Categoría</h4>
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <th><?= __('Nombre') ?></th>
                            <th><?= __('Descripción') ?></th>
                            <th><?= __('Cantidad') ?></th>
                            <th><?= __('Precio') ?></th>
                            <th><?= __('Stock Mínimo') ?></th>
                            <th><?= __('Estado') ?></th>
                            <th class="text-center"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categoria->productos as $producto) : ?>
                        <tr>
                            <td><?= h($producto->id) ?></td>
                            <td><?= h($producto->nombre) ?></td>
                            <td><?= h($producto->descripcion) ?: 'Sin descripción' ?></td>
                            <td><?= h($producto->cantidad) ?></td>
                            <td>$<?= $this->Number->format($producto->precio) ?></td>
                            <td><?= h($producto->stock_minimo) ?></td>
                            <td><?= h($producto->estado) ?></td>
                            <td class="text-center">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Productos', 'action' => 'view', $producto->id], ['class' => 'btn btn-sm btn-info openModal', 'target' => '_blank']) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Productos', 'action' => 'edit', $producto->id], ['class' => 'btn btn-sm btn-warning openModal', 'target' => '_blank']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

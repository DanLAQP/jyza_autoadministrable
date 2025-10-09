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
        <h3 class="text-info"><i class="fas fa-box me-2"></i> Detalles del Producto</h3>
    </div>

    <!-- Información del Producto -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Nombre:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($producto->nombre) ?></div>
        </div>
    </div>

    <!-- Categoría -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Categoría:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box">
                <?= $producto->hasValue('categoria') ? 
                    $this->Html->link(
                        $producto->categoria->nombre,
                        ['controller' => 'Categorias', 'action' => 'view', $producto->categoria->id],
                        ['class' => 'text-decoration-none text-white openModal', 'target' => '_blank']
                    ) : 'No asignado' ?>
            </div>
        </div>
    </div>

    <!-- Proveedor -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Proveedor:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box">
                <?= $producto->hasValue('proveedore') ? 
                    $this->Html->link(
                        $producto->proveedore->nombre,
                        ['controller' => 'Proveedores', 'action' => 'view', $producto->proveedore->id],
                        ['class' => 'text-decoration-none text-white openModal', 'target' => '_blank']
                    ) : 'No asignado' ?>
            </div>
        </div>
    </div>

    <!-- Ubicación -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Ubicación:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($producto->ubicacion) ?: 'No especificada' ?></div>
        </div>
    </div>

    <!-- Estado -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Estado:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($producto->estado) ?></div>
        </div>
    </div>

    <!-- Cantidad, Precio y Stock Mínimo -->
    <div class="row mb-3">
        <div class="col-md-4">
            <<p class="label-text"><?= __('Cantidad:') ?></p>
            <div class="data-box"><?= $this->Number->format($producto->cantidad ?? 0) ?></div> 
        </div>
        <div class="col-md-4">
            <p class="label-text"><?= __('Precio:') ?></p>
            <div class="data-box">S/. <?= $this->Number->format($producto->precio ?: 0) ?></div>
        </div>

        <div class="col-md-4">
            <p class="label-text"><?= __('Stock Mínimo:') ?></p>
            <div class="data-box"><?= $this->Number->format($producto->stock_minimo ?? 0) ?></div>
        </div>
    </div>

    <!-- Fechas -->
    <div class="row mb-3">
        <div class="col-md-4">
            <p class="label-text"><?= __('Fecha de Vencimiento:') ?></p>
            <div class="data-box"><?= h($producto->fecha_vencimiento) ?: 'No especificada' ?></div>
        </div>
        <div class="col-md-4">
            <p class="label-text"><?= __('Fecha de Ingreso:') ?></p>
            <div class="data-box"><?= h($producto->fecha_ingreso) ?></div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Descripción:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($producto->descripcion) ?: 'No especificada' ?></div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Html->link(__('Editar Producto'), ['action' => 'edit', $producto->id], ['class' => 'btn btn-warning me-2 openModal', 'target' => '_blank']) ?>
        <?= $this->Html->link(__('Regresar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <!-- Transacciones Relacionadas -->
    <?php if (!empty($producto->transacciones)) : ?>
        <div class="mt-4">
            <h4 class="text-light"><i class="fas fa-exchange-alt me-2"></i> Transacciones Relacionadas</h4>
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Cantidad') ?></th>
                            <th><?= __('Fecha') ?></th>
                            <th><?= __('Usuario') ?></th>
                            <th><?= __('Notas') ?></th>
                            <th class="text-center"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($producto->transacciones as $transaccione) : ?>
                        <tr>
                            <td><?= h($transaccione->id) ?></td>
                            <td><?= h($transaccione->tipo_transaccion) ?></td>
                            <td><?= h($transaccione->cantidad)  ?></td>
                            <td><?= h($transaccione->fecha_transaccion) ?></td>
                            <td><?= h($transaccione->user_id) ?></td>
                            <td><?= h($transaccione->notas) ?: 'N/A' ?></td>
                            <td class="text-center">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Transacciones', 'action' => 'view', $transaccione->id], ['class' => 'btn btn-sm btn-info openModal' , 'target' => '_blank']) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Transacciones', 'action' => 'edit', $transaccione->id], ['class' => 'btn btn-sm btn-warning openModal' , 'target' => '_blank']) ?>
                                
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

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
        <h3 class="text-info"><i class="fas fa-truck me-2"></i> Detalles del Proveedor</h3>
    </div>

    <!-- Información del Proveedor -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Nombre:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($proveedore->nombre) ?></div>
        </div>
    </div>

    <!-- Contacto Nombre -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Nombre de Contacto:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($proveedore->contacto_nombre) ?: 'No especificado' ?></div>
        </div>
    </div>

    <!-- Contacto Email -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Correo Electrónico:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box">
                <?= $proveedore->contacto_email ? 
                    $this->Html->link(
                        $proveedore->contacto_email,
                        'mailto:' . $proveedore->contacto_email,
                        ['class' => 'text-decoration-none text-white']
                    ) : 'No especificado' ?>
            </div>
        </div>
    </div>

    <!-- Contacto Teléfono -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Teléfono de Contacto:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($proveedore->contacto_telefono) ?: 'No especificado' ?></div>
        </div>
    </div>

    <!-- ID del Proveedor -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('ID:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= $this->Number->format($proveedore->id) ?></div>
        </div>
    </div>

    <!-- Dirección -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Dirección:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($proveedore->direccion) ?: 'No especificada' ?></div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Html->link(__('Editar Proveedor'), ['action' => 'edit', $proveedore->id], ['class' => 'btn btn-warning me-2 openModal', 'target' => '_blank']) ?>
        <?= $this->Html->link(__('Regresar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>
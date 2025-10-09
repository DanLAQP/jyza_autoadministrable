<style>
    .label-text {
        font-weight: bold;
    }
    .data-box {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
        min-height: 38px;
        display: flex;
        align-items: center;
    }
</style>

<div class="container mt-4 mb-4">
    <!-- Título -->
    <div class="mb-4">
        <h3 class="text-info"><i class="fas fa-cogs me-2"></i> Detalles de la Campaña</h3>
    </div>

    <!-- Nombre -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Nombre:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($campaña->nombre) ?></div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Descripción:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($campaña->descripcion) ?: 'No especificada' ?></div>
        </div>
    </div>

    <!-- Fechas -->
    <div class="row mb-3">
        <div class="col-md-6">
            <p class="label-text"><?= __('Fecha de Creación:') ?></p>
            <div class="data-box"><?= h($campaña->created) ?></div>
        </div>
        <div class="col-md-6">
            <p class="label-text"><?= __('Última Modificación:') ?></p>
            <div class="data-box"><?= h($campaña->modified) ?></div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Html->link(__('Editar Campaña'), ['action' => 'edit', $campaña->id], ['class' => 'btn btn-warning me-2 openModal', 'target' => '_blank']) ?>
        <?= $this->Html->link(__('Regresar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>
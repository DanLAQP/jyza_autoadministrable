<div class="container mt-4 mb-4">
    <?= $this->Form->create($proveedore, ['class' => 'row g-3', 'id' => 'formEditarProveedor']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-truck"></i> Editar Proveedor</h3>
    </div>

    <!-- Nombre del Proveedor -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Nombre del Proveedor') ?></label>
        <?= $this->Form->control('nombre', [
            'class' => 'form-control',
            'label' => false,
            'placeholder' => 'Ingrese el nombre del proveedor',
        ]) ?>
    </div>

    <!-- Contacto Nombre -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Nombre de Contacto') ?></label>
        <?= $this->Form->control('contacto_nombre', [
            'class' => 'form-control',
            'label' => false,
            'placeholder' => 'Ingrese el nombre del contacto',
        ]) ?>
    </div>

    <!-- Contacto Email -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Correo Electrónico') ?></label>
        <?= $this->Form->control('contacto_email', [
            'class' => 'form-control',
            'type' => 'email',
            'label' => false,
            'placeholder' => 'Ingrese el correo electrónico',
        ]) ?>
    </div>

    <!-- Contacto Teléfono -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Teléfono de Contacto') ?></label>
        <?= $this->Form->control('contacto_telefono', [
            'class' => 'form-control',
            'type' => 'tel',
            'label' => false,
            'placeholder' => 'Ingrese el número de teléfono',
        ]) ?>
    </div>

    <!-- Dirección -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Dirección') ?></label>
        <?= $this->Form->control('direccion', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => false,
            'placeholder' => 'Ingrese la dirección del proveedor',
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info mb-2', 'id' => 'submitButton']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary mb-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<div class="container mt-4 mb-4">
    <?= $this->Form->create($categoria, ['class' => 'row g-3', 'id' => 'formEditarCategoria']) ?>

    <!-- Título del formulario -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-tags"></i> Editar Categoría</h3>
    </div>

    <!-- Nombre de la Categoría -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Nombre de la Categoría') ?></label>
        <?= $this->Form->control('nombre', [
            'class' => 'form-control',
            'label' => false, // Ocultamos el label duplicado
            'placeholder' => 'Ingrese el nombre de la categoría',
        ]) ?>
    </div>

    <!-- Descripción -->
    <div class="col-12 mb-3">
        <label class="form-label"><?= __('Descripción') ?></label>
        <?= $this->Form->control('descripcion', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => false,
            'placeholder' => 'Ingrese una descripción breve',
        ]) ?>
    </div>

    <!-- Botones -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info mb-2', 'id' => 'submitButton']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary mb-2']) ?>
        
    </div>

    <?= $this->Form->end() ?>
</div>

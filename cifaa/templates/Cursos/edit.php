<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Curso $curso
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="container mt-4 mb-4">
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?= h($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php else: ?>
        <?= $this->Form->create($curso, ['type' => 'file', 'class' => 'row g-3']) ?>

        <!-- Información del Curso -->
        <div class="col-12 mb-4">
            <h3 class="text-info"><i class="fas fa-book"></i> Editar Curso</h3>
        </div>

        <!-- Campo: Título -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('titulo', [
                'label' => 'Título del Curso',
                'class' => 'form-control',
                'placeholder' => 'Ej: Python Avanzado'
            ]) ?>
        </div>

        <!-- Campo: Usuario/Instructor -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('usuario_id', [
                'label' => 'Instructor',
                'class' => 'form-control',
                'options' => $users
            ]) ?>
        </div>

        <!-- Campo: Descripción -->
        <div class="col-12 mb-3">
            <?= $this->Form->control('descripcion', [
                'label' => 'Descripción',
                'type' => 'textarea',
                'class' => 'form-control',
                'rows' => 4,
                'placeholder' => 'Describa el contenido y objetivos del curso'
            ]) ?>
        </div>

        <!-- Campo: Nivel -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('nivel', [
                'label' => 'Nivel del Curso',
                'class' => 'form-control',
                'type' => 'select',
                'options' => [
                    'basico' => 'Básico',
                    'intermedio' => 'Intermedio',
                    'avanzado' => 'Avanzado',
                ],
            ]) ?>
        </div>

        <!-- Campo: Categoría -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('categoria', [
                'label' => 'Categoría',
                'class' => 'form-control',
                'placeholder' => 'Ej: Programación, Diseño, etc.'
            ]) ?>
        </div>

        <!-- Campo: Miniatura (Imagen) -->
        <div class="col-12 mb-3">
            <label class="form-label">Miniatura del Curso</label>
            <?php if (!empty($curso->miniatura)): ?>
                <div class="mb-3">
                    <p class="text-muted">Imagen actual:</p>
                    <img src="<?= $curso->miniatura ?>" alt="Miniatura actual" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #17a2b8;">
                </div>
            <?php endif; ?>
            <div class="input-group">
                <input type="file" class="form-control" id="miniatura" name="miniatura" accept="image/*" />
                <small class="d-block text-muted mt-2">Formatos soportados: JPG, PNG, GIF. Tamaño máximo: 5MB</small>
            </div>
            <div id="preview-miniatura" class="mt-3"></div>
        </div>

        <!-- Campo: Estado -->
        <div class="col-md-6 mb-3">
            <?= $this->Form->control('estado', [
                'label' => 'Estado',
                'class' => 'form-control',
                'type' => 'select',
                'options' => [
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ]
            ]) ?>
        </div>

        <!-- Botones -->
        <div class="col-12 text-center">
            <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info']) ?>
            <?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $curso->id],
                ['confirm' => __('¿Está seguro de que desea eliminar este curso?'), 'class' => 'btn btn-danger ms-2']
            ) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
        </div>

        <?= $this->Form->end() ?>
    <?php endif; ?>
</div>

<!-- Script para preview de imagen -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const miniaturaBgInput = document.getElementById('miniatura');
    const previewContainer = document.getElementById('preview-miniatura');
    
    if (miniaturaBgInput) {
        miniaturaBgInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #17a2b8;">';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>

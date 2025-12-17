<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Titular $titular
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-warning mb-0">
                <i class="fas fa-edit"></i> Editar Titular
            </h2>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left"></i> Volver',
                ['action' => 'view', $titular->id],
                ['class' => 'btn btn-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Advertencias -->
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> <strong>¡CUIDADO!</strong>
        <ul class="mb-0 mt-2">
            <li>Editar estos datos puede afectar la validez de los certificados emitidos.</li>
            <li>Los cambios se reflejarán en <strong>futuros</strong> certificados, no en los ya emitidos.</li>
            <li>Si el titular tiene usuario vinculado, cambiar el DNI puede causar inconsistencias.</li>
            <li>Solo corrija errores de tipeo evidentes.</li>
        </ul>
    </div>

    <?php if ($titular->tiene_usuario): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Este titular tiene un <strong>usuario vinculado</strong>. 
            Tenga especial cuidado al modificar el DNI.
        </div>
    <?php endif; ?>

    <?php if (isset($titular->total_certificados) && $titular->total_certificados > 0): ?>
        <div class="alert alert-danger">
            <i class="fas fa-certificate"></i> Este titular tiene <strong><?= $titular->total_certificados ?> certificado(s)</strong> emitido(s). 
            Los certificados existentes mantienen los datos originales (snapshots).
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-user-edit"></i> Formulario de Edición</h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($titular) ?>
                    
                    <div class="mb-3">
                        <label for="dni" class="form-label">
                            <i class="fas fa-id-card"></i> DNI <span class="text-danger">*</span>
                        </label>
                        <?= $this->Form->control('dni', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Ej: 12345678',
                            'required' => true,
                            'maxlength' => 20
                        ]) ?>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> El DNI debe ser único en el sistema. 
                            Verifique cuidadosamente antes de modificar.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="nombres" class="form-label">
                            <i class="fas fa-user"></i> Nombres <span class="text-danger">*</span>
                        </label>
                        <?= $this->Form->control('nombres', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Ej: Juan Carlos',
                            'required' => true,
                            'maxlength' => 100
                        ]) ?>
                        <small class="form-text text-muted">
                            Ingrese los nombres completos del titular (sin apellidos).
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="apellidos" class="form-label">
                            <i class="fas fa-user"></i> Apellidos <span class="text-danger">*</span>
                        </label>
                        <?= $this->Form->control('apellidos', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Ej: Pérez García',
                            'required' => true,
                            'maxlength' => 100
                        ]) ?>
                        <small class="form-text text-muted">
                            Ingrese los apellidos completos del titular.
                        </small>
                    </div>

                    <!-- Información de Vista Previa -->
                    <div class="alert alert-light border">
                        <strong>Vista previa del nombre completo:</strong>
                        <p class="mb-0 mt-2" id="preview-nombre-completo">
                            <span id="preview-nombres"><?= h($titular->nombres) ?></span>
                            <span id="preview-apellidos"><?= h($titular->apellidos) ?></span>
                        </p>
                    </div>

                    <!-- Información adicional (no editable) -->
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Información del Registro</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Creado:</strong><br>
                                        <?= $titular->created->format('d/m/Y H:i:s') ?>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Última modificación:</strong><br>
                                        <?= $titular->modified->format('d/m/Y H:i:s') ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'view', $titular->id],
                            ['class' => 'btn btn-secondary me-md-2', 'escape' => false]
                        ) ?>
                        <?= $this->Form->button(
                            '<i class="fas fa-save"></i> Guardar Cambios',
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-warning',
                                'escape' => false
                            ]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vista previa del nombre completo en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const nombresInput = document.querySelector('input[name="nombres"]');
    const apellidosInput = document.querySelector('input[name="apellidos"]');
    const previewNombres = document.getElementById('preview-nombres');
    const previewApellidos = document.getElementById('preview-apellidos');
    
    function actualizarPreview() {
        previewNombres.textContent = nombresInput.value || '[Nombres]';
        previewApellidos.textContent = ' ' + (apellidosInput.value || '[Apellidos]');
    }
    
    nombresInput.addEventListener('input', actualizarPreview);
    apellidosInput.addEventListener('input', actualizarPreview);
});
</script>

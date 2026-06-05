<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Agregar Nuevo Usuario</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?= h($error_message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?= $this->Form->create($user, ['id' => 'form-usuario']) ?>

                    <!-- Datos de Acceso -->
                    <fieldset class="border p-3 mb-4">
                        <legend class="w-auto px-2 text-info">
                            <i class="fas fa-key"></i> Datos de Acceso
                        </legend>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user"></i> Nombre de Usuario <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('username', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Ej: juan.perez',
                                    'required' => true
                                ]) ?>
                                <small class="text-muted">Único en el sistema, sin espacios</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Contraseña <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('password', [
                                    'label' => false,
                                    'type' => 'password',
                                    'class' => 'form-control',
                                    'placeholder' => 'Mínimo 8 caracteres',
                                    'required' => true
                                ]) ?>
                                <small class="text-muted">Mínimo 8 caracteres</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label">
                                    <i class="fas fa-user-tag"></i> Rol <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('rol', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'id' => 'rol-select',
                                    'type' => 'select',
                                    'options' => [
                                        1 => 'Administrador',
                                        2 => 'Docente',
                                        3 => 'Estudiante'
                                    ],
                                    'empty' => 'Seleccione un rol',
                                    'required' => true
                                ]) ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">
                                    <i class="fas fa-toggle-on"></i> Estado
                                </label>
                                <?= $this->Form->control('estado', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'type' => 'select',
                                    'options' => [
                                        'activo' => 'Activo',
                                        'inactivo' => 'Inactivo'
                                    ],
                                    'default' => 'activo'
                                ]) ?>
                            </div>

                        </div>
                        <div class="row"> 
                            <div class="col-md-6 mb-3">
                                <label for="nombres" class="form-label">
                                    <i class="fas fa-id-card"></i> Nombres completos <span class="text-danger">*</span>
                                </label>

                                <?= $this->Form->control('nombres', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Ej: Juan Pérez Gómez',
                                    'required' => true
                                ]) ?>

                                <small class="text-muted">Tal como aparecerá en certificados y reportes</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">
                                    <i class="fas fa-passport"></i> DNI/Documento <span class="text-danger">*</span>
                                </label>

                                <?= $this->Form->control('dni', [
                                    'label' => false,
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'placeholder' => 'Ej: 12345678',
                                    'required' => true
                                ]) ?>

                                <small class="text-muted">Número de documento de identidad</small>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary', 'escape' => false]
                        ) ?>
                        <button type="submit" class="btn btn-info" id="btn-guardar">
                            <i class="fas fa-save"></i> Guardar Usuario
                        </button>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para placeholders y controles de formulario oscuros */
    .form-control::placeholder,
    .form-select::placeholder {
        color: #8eb4d6 !important;
        opacity: 1;
    }

    .form-control {
        background-color: #1a3a52;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .form-control:focus {
        background-color: #1a3a52;
        border-color: #5dade2;
        color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(93, 173, 226, 0.25);
    }

    .form-select {
        background-color: #1a3a52;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .form-select:focus {
        background-color: #1a3a52;
        border-color: #5dade2;
        color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(93, 173, 226, 0.25);
    }

    .form-check-input {
        background-color: #1a3a52;
        border-color: #0d6efd;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-label {
        color: #ffffff;
    }

    fieldset {
        background-color: rgba(26, 58, 82, 0.3) !important;
        border-color: #0d6efd !important;
    }

    legend {
        background-color: transparent !important;
    }
</style>

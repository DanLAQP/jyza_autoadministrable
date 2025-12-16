<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var bool $esAdmin
 */
?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-user-edit"></i> Editar Usuario</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?= h($error_message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Advertencias sobre titular vinculado -->
                    <?php if ($user->titular_id && isset($user->titular)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-link"></i> <strong>Usuario vinculado a titular:</strong>
                            <p class="mb-0 mt-2">
                                <strong><?= h($user->titular->nombre_completo) ?></strong> (DNI: <?= h($user->titular->dni) ?>)<br>
                                <small class="text-muted">
                                    Este usuario tiene <?= $user->titular->total_certificados ?? 0 ?> certificado(s) vinculado(s).
                                    <?php if (!$esAdmin): ?>
                                        No puede cambiar el DNI porque está vinculado a un titular.
                                    <?php endif; ?>
                                </small>
                            </p>
                        </div>
                    <?php endif; ?>

                    <?= $this->Form->create($user, ['id' => 'form-editar-usuario']) ?>

                    <!-- Datos de Acceso -->
                    <fieldset class="border p-3 mb-4">
                        <legend class="w-auto px-2 text-primary">
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
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Nueva Contraseña
                                </label>
                                <?= $this->Form->control('password', [
                                    'label' => false,
                                    'type' => 'password',
                                    'class' => 'form-control',
                                    'placeholder' => 'Dejar vacío para no cambiar',
                                    'value' => ''
                                ]) ?>
                                <small class="text-muted">Solo si desea cambiar la contraseña</small>
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
                                    'type' => 'select',
                                    'options' => [
                                        1 => 'Administrador',
                                        2 => 'Docente',
                                        3 => 'Estudiante'
                                    ],
                                    'disabled' => ($user->id == 1) // Proteger admin principal
                                ]) ?>
                                <?php if ($user->id == 1): ?>
                                    <small class="text-danger">
                                        <i class="fas fa-shield-alt"></i> Usuario protegido, no se puede cambiar el rol
                                    </small>
                                <?php endif; ?>
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
                                    ]
                                ]) ?>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Datos Personales -->
                    <fieldset class="border p-3 mb-4">
                        <legend class="w-auto px-2 text-success">
                            <i class="fas fa-id-card"></i> Datos Personales
                        </legend>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre-completo" class="form-label">
                                    <i class="fas fa-user"></i> Nombre Completo
                                    <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('nombre_completo', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'value' => $user->titular ? $user->titular->nombre_completo : '',
                                    'placeholder' => 'Ej: Juan Carlos Pérez García',
                                    'maxlength' => 200,
                                    'required' => true
                                ]) ?>
                                <small class="text-muted">Nombre completo del usuario</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">
                                    <i class="fas fa-fingerprint"></i> DNI
                                    <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('dni', [
                                    'label' => false,
                                    'class' => 'form-control' . ($user->titular_id && !$esAdmin ? ' bg-light' : ''),
                                    'placeholder' => 'Ej: 12345678',
                                    'maxlength' => 20,
                                    'readonly' => ($user->titular_id && !$esAdmin),
                                    'required' => true
                                ]) ?>
                                <?php if ($user->titular_id && !$esAdmin): ?>
                                    <small class="text-danger">
                                        <i class="fas fa-lock"></i> DNI protegido (vinculado a titular)
                                    </small>
                                <?php elseif ($esAdmin && $user->titular_id): ?>
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Cambiar el DNI modificará la vinculación
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">Documento de identidad</small>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <?= $this->Form->control('email', [
                                    'label' => false,
                                    'type' => 'email',
                                    'class' => 'form-control',
                                    'placeholder' => 'ejemplo@correo.com (opcional)'
                                ]) ?>
                                <small class="text-muted">Opcional</small>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Información de auditoría -->
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title">Información del Registro</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Creado:</strong><br>
                                        <?= $user->created->format('d/m/Y H:i:s') ?>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Última modificación:</strong><br>
                                        <?= $user->modified->format('d/m/Y H:i:s') ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-arrow-left"></i> Volver',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary', 'escape' => false]
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

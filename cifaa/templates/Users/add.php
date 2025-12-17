<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
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

                    <!-- Información sobre sistema de titulares -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Nuevo sistema de titulares:</strong>
                        <p class="mb-0 mt-2 small">
                            Si el usuario es estudiante y proporciona un DNI, se vinculará automáticamente con su registro de titular.
                            Esto permite heredar certificados emitidos previamente.
                        </p>
                    </div>

                    <?= $this->Form->create($user, ['id' => 'form-usuario']) ?>

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
                    </fieldset>

                    <!-- Datos Personales -->
                    <fieldset class="border p-3 mb-4" id="datos-personales">
                        <legend class="w-auto px-2 text-success">
                            <i class="fas fa-id-card"></i> Datos Personales
                        </legend>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre-completo" class="form-label">
                                    <i class="fas fa-user"></i> Nombre Completo
                                    <span class="text-danger" id="nombre-required-mark">*</span>
                                </label>
                                <?= $this->Form->control('nombre_completo', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'id' => 'nombre-completo-input',
                                    'placeholder' => 'Ej: Juan Carlos Pérez García',
                                    'maxlength' => 200,
                                    'required' => true
                                ]) ?>
                                <small class="text-muted">
                                    Nombre completo del usuario
                                </small>
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
                                    'class' => 'form-control',
                                    'id' => 'dni-input',
                                    'placeholder' => 'Ej: 12345678',
                                    'maxlength' => 20,
                                    'required' => true
                                ]) ?>
                                <small class="text-muted">
                                    Documento de identidad
                                </small>
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
                                <small class="text-muted">
                                    Opcional
                                </small>
                            </div>
                        </div>

                        <!-- Alertas de vinculación con titular -->
                        <div id="titular-duplicado-alert" class="alert alert-danger" style="display:none;">
                            <i class="fas fa-times-circle"></i> <strong>¡Error!</strong>
                            <p class="mb-0 mt-2" id="titular-duplicado-mensaje"></p>
                        </div>

                        <div id="titular-heredar-alert" class="alert alert-success" style="display:none;">
                            <i class="fas fa-check-circle"></i> <strong>Titular encontrado:</strong>
                            <p class="mb-0 mt-2" id="titular-heredar-info"></p>
                        </div>

                        <div id="titular-nuevo-alert" class="alert alert-info" style="display:none;">
                            <i class="fas fa-info-circle"></i> <strong>Nuevo titular:</strong>
                            Se creará un registro de titular automáticamente con este DNI.
                        </div>
                    </fieldset>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary', 'escape' => false]
                        ) ?>
                        <?= $this->Form->button(
                            '<i class="fas fa-save"></i> Guardar Usuario',
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-info',
                                'id' => 'btn-guardar',
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
document.addEventListener('DOMContentLoaded', function() {
    const rolSelect = document.getElementById('rol-select');
    const dniInput = document.getElementById('dni-input');
    const dniRequiredMark = document.getElementById('dni-required-mark');
    const dniHint = document.getElementById('dni-hint');
    const dniLoading = document.getElementById('dni-loading');
    
    const titularDuplicadoAlert = document.getElementById('titular-duplicado-alert');
    const titularDuplicadoMensaje = document.getElementById('titular-duplicado-mensaje');
    const titularHeredarAlert = document.getElementById('titular-heredar-alert');
    const titularHeredarInfo = document.getElementById('titular-heredar-info');
    const titularNuevoAlert = document.getElementById('titular-nuevo-alert');
    const btnGuardar = document.getElementById('btn-guardar');
    
    let titularExistente = null;
    let timeoutVerificacion = null;

    // Ya no necesitamos validación dinámica, los campos son siempre obligatorios

    // Verificar titular al escribir DNI
    dniInput.addEventListener('input', function() {
        const dni = this.value.trim();
        
        // Limpiar alertas
        titularDuplicadoAlert.style.display = 'none';
        titularHeredarAlert.style.display = 'none';
        titularNuevoAlert.style.display = 'none';
        btnGuardar.disabled = false;
        
        if (dni.length < 3 || rolSelect.value != '3') {
            return;
        }
        
        clearTimeout(timeoutVerificacion);
        
        timeoutVerificacion = setTimeout(() => {
            verificarTitular(dni);
        }, 500);
    });

    function verificarTitular(dni) {
        dniLoading.style.display = 'block';
        
        fetch(`<?= $this->Url->build(['controller' => 'Titulares', 'action' => 'verificar']) ?>/${encodeURIComponent(dni)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            dniLoading.style.display = 'none';
            
            if (data.existe) {
                titularExistente = data.titular;
                
                if (data.titular.tiene_usuario) {
                    // ERROR: Ya está vinculado a otro usuario
                    titularDuplicadoAlert.style.display = 'block';
                    titularDuplicadoMensaje.innerHTML = `
                        El DNI <strong>${dni}</strong> ya está vinculado al usuario: <strong>${data.usuario.username}</strong>.<br>
                        <small class="text-muted">Un titular solo puede tener un usuario del sistema.</small>
                    `;
                    btnGuardar.disabled = true;
                } else {
                    // OK: Heredará certificados
                    titularHeredarAlert.style.display = 'block';
                    titularHeredarInfo.innerHTML = `
                        <strong>${data.titular.nombre_completo}</strong> (DNI: ${data.titular.dni})<br>
                        Este usuario heredará <strong>${data.titular.total_certificados || 0} certificado(s)</strong> existente(s).
                    `;
                }
            } else {
                // Nuevo titular - se creará automáticamente
                titularNuevoAlert.style.display = 'block';
            }
        })
        .catch(error => {
            dniLoading.style.display = 'none';
            console.error('Error al verificar titular:', error);
        });
    }
});
</script>

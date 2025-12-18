<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0">
                <i class="fas fa-user"></i> Perfil de Usuario
            </h2>
            <div>
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left"></i> Volver',
                    ['action' => 'index'],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Datos del Usuario -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm bg-dark border-info text-white">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle"></i> Información del Usuario</h5>
                </div>
                <div class="card-body py-3 px-3">
                    <div class="mb-3">
                        <span><strong>Usuario:</strong> <?= h($user->username) ?></span>
                    </div>
                    <div class="mb-3">
                        <span class="d-block mb-1"><strong>DNI:</strong></span>
                        <?php if ($user->dni): ?>
                            <span class="badge bg-secondary"><?= h($user->dni) ?></span>
                        <?php else: ?>
                            <span class="text-muted">No especificado</span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <span class="d-block mb-1"><strong>Rol:</strong></span>
                        <?php
                        $roles = [1 => 'Administrador', 2 => 'Docente', 3 => 'Estudiante'];
                        $rolClass = [1 => 'danger', 2 => 'primary', 3 => 'success'];
                        ?>
                        <span class="badge bg-<?= $rolClass[$user->rol] ?>">
                            <?= $roles[$user->rol] ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <span><strong>Estado:</strong></span>
                        <div>
                            <?php if ($user->estado === 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <span><strong><i class="fas fa-calendar"></i> Creado:</strong> <?= $user->created->format('d/m/Y H:i') ?></span>
                    </div>
                    <div>
                        <span><strong><i class="fas fa-clock"></i> Modificado:</strong> <?= $user->modified->format('d/m/Y H:i') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Titular Vinculado -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm bg-dark border-success text-white">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Titular Vinculado</h5>
                </div>
                <div class="card-body py-3 px-3">
                    <?php if (!empty($user->titular)): ?>
                        <div class="alert alert-success mb-3 py-2 px-2">
                            <i class="fas fa-check-circle"></i> Usuario vinculado a titular
                        </div>
                        
                        <div class="mb-3">
                            <span><strong>Nombre:</strong> <?= h($user->titular->nombre_completo) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="d-block mb-1"><strong>DNI:</strong></span>
                            <span class="badge bg-secondary"><?= h($user->titular->dni) ?></span>
                        </div>
                        <div>
                            <span><strong>Registro:</strong> <?= $user->titular->created->format('d/m/Y') ?></span>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Sin titular vinculado</strong>
                        </div>
                        <p class="mb-0 text-muted">
                            <?php if ($user->rol == 3): ?>
                                <small>
                                    Este estudiante no tiene un titular vinculado. 
                                    Agregue un DNI para vincular automáticamente.
                                </small>
                            <?php else: ?>
                                <small>
                                    Los administradores y docentes no requieren titular vinculado.
                                </small>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

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
    </div>
</div>

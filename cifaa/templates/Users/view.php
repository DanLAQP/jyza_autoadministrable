<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0">
                <i class="fas fa-user"></i> Perfil de Usuario
            </h2>
            <div>
                <?= $this->Html->link(
                    '<i class="fas fa-edit"></i> Editar',
                    ['action' => 'edit', $user->id],
                    ['class' => 'btn btn-warning me-2', 'escape' => false]
                ) ?>
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
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle"></i> Información del Usuario</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 40%">Usuario:</th>
                                <td><strong><?= h($user->username) ?></strong></td>
                            </tr>
                            <tr>
                                <th>DNI:</th>
                                <td>
                                    <?php if ($user->dni): ?>
                                        <span class="badge bg-secondary fs-6"><?= h($user->dni) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= $user->email ? h($user->email) : '<span class="text-muted">No especificado</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Rol:</th>
                                <td>
                                    <?php
                                    $roles = [1 => 'Administrador', 2 => 'Docente', 3 => 'Estudiante'];
                                    $rolClass = [1 => 'danger', 2 => 'primary', 3 => 'success'];
                                    ?>
                                    <span class="badge bg-<?= $rolClass[$user->rol] ?>">
                                        <?= $roles[$user->rol] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>
                                    <?php if ($user->estado === 'activo'): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Creado:</th>
                                <td>
                                    <i class="fas fa-calendar"></i>
                                    <?= $user->created->format('d/m/Y H:i') ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Última modificación:</th>
                                <td>
                                    <i class="fas fa-clock"></i>
                                    <?= $user->modified->format('d/m/Y H:i') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Titular Vinculado -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-id-card"></i> Titular Vinculado</h5>
                </div>
                <div class="card-body">
                    <?php if ($user->titular_id && isset($user->titular)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Usuario vinculado a titular
                        </div>
                        
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 40%">Nombre Completo:</th>
                                <td><strong><?= h($user->titular->nombre_completo) ?></strong></td>
                            </tr>
                            <tr>
                                <th>DNI:</th>
                                <td><span class="badge bg-secondary"><?= h($user->titular->dni) ?></span></td>
                            </tr>
                            <tr>
                                <th>Certificados:</th>
                                <td>
                                    <span class="badge bg-info fs-6">
                                        <?= $user->titular->total_certificados ?? 0 ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Registro del titular:</th>
                                <td>
                                    <small class="text-muted">
                                        <?= $user->titular->created->format('d/m/Y') ?>
                                    </small>
                                </td>
                            </tr>
                        </table>

                        <?= $this->Html->link(
                            '<i class="fas fa-external-link-alt"></i> Ver detalles del titular',
                            ['controller' => 'Titulares', 'action' => 'view', $user->titular->id],
                            ['class' => 'btn btn-sm btn-outline-success', 'escape' => false]
                        ) ?>

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

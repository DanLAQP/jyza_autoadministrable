<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Titular $titular
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0">
                <i class="fas fa-id-card"></i> Detalles del Titular
            </h2>
            <div>
                <?= $this->Html->link(
                    '<i class="fas fa-edit"></i> Editar',
                    ['action' => 'edit', $titular->id],
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
        <!-- Información del Titular -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th style="width: 40%">DNI:</th>
                                <td>
                                    <span class="badge bg-secondary fs-6">
                                        <?= h($titular->dni) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nombres:</th>
                                <td><?= h($titular->nombres) ?></td>
                            </tr>
                            <tr>
                                <th>Apellidos:</th>
                                <td><?= h($titular->apellidos) ?></td>
                            </tr>
                            <tr>
                                <th>Nombre Completo:</th>
                                <td><strong><?= h($titular->nombre_completo) ?></strong></td>
                            </tr>
                            <tr>
                                <th>Fecha de Registro:</th>
                                <td>
                                    <i class="fas fa-calendar"></i>
                                    <?= $titular->created->format('d/m/Y H:i') ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Última Modificación:</th>
                                <td>
                                    <i class="fas fa-clock"></i>
                                    <?= $titular->modified->format('d/m/Y H:i') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Usuario Vinculado y Estadísticas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle"></i> Usuario Vinculado</h5>
                </div>
                <div class="card-body">
                    <?php if ($titular->tiene_usuario && isset($titular->user)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Este titular tiene un usuario del sistema vinculado
                        </div>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 40%">Username:</th>
                                <td><?= h($titular->user->username) ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= h($titular->user->email ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Rol:</th>
                                <td>
                                    <?php
                                    $roles = [1 => 'Administrador', 2 => 'Docente', 3 => 'Estudiante'];
                                    $rolClass = [1 => 'danger', 2 => 'primary', 3 => 'success'];
                                    ?>
                                    <span class="badge bg-<?= $rolClass[$titular->user->rol] ?>">
                                        <?= $roles[$titular->user->rol] ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <?= $this->Html->link(
                            '<i class="fas fa-external-link-alt"></i> Ver perfil de usuario',
                            ['controller' => 'Users', 'action' => 'view', $titular->user->id],
                            ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]
                        ) ?>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Este titular <strong>NO</strong> tiene un usuario del sistema vinculado
                        </div>
                        <p class="mb-0 text-muted">
                            <small>Los certificados fueron emitidos sin crear una cuenta de usuario. 
                            El titular puede recibir certificados sin necesidad de tener acceso al sistema.</small>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Estadísticas</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($estadisticas)): ?>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-info mb-0"><?= $estadisticas['total'] ?></h3>
                                    <small class="text-muted">Total Certificados</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-success mb-0"><?= $estadisticas['activos'] ?></h3>
                                    <small class="text-muted">Activos</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary mb-0"><?= $estadisticas['certificados'] ?></h3>
                                    <small class="text-muted">Certificados (CER)</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h3 class="text-warning mb-0"><?= $estadisticas['diplomados'] ?></h3>
                                    <small class="text-muted">Diplomados (DIP)</small>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Certificados -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-certificate"></i> Certificados Emitidos</h5>
                    <span class="badge bg-info fs-6">
                        <?= isset($titular->certificados) ? count($titular->certificados) : 0 ?>
                    </span>
                </div>
                <div class="card-body">
                    <?php if (!empty($titular->certificados)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Curso</th>
                                        <th>Horas</th>
                                        <th>Fecha Emisión</th>
                                        <th>Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($titular->certificados as $certificado): ?>
                                        <tr>
                                            <td>
                                                <code><?= h($certificado->codigo) ?></code>
                                            </td>
                                            <td>
                                                <?= h($certificado->nombre_curso) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= h($certificado->horas_curso) ?> hrs
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= $certificado->created->format('d/m/Y') ?></small>
                                            </td>
                                            <td>
                                                <?php if ($certificado->estado === 'activo'): ?>
                                                    <span class="badge bg-success">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Anulado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-eye"></i>',
                                                    ['controller' => 'Certificados', 'action' => 'view', $certificado->id],
                                                    [
                                                        'class' => 'btn btn-sm btn-info',
                                                        'escape' => false,
                                                        'title' => 'Ver certificado'
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">Este titular aún no tiene certificados emitidos.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

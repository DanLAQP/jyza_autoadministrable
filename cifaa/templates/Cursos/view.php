<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Curso $curso
 */

// Verificar que el curso existe
if (empty($curso)) {
    echo '<div class="alert alert-danger">Curso no encontrado</div>';
    return;
}
?>

<div class="container mt-4 mb-4">
    <!-- Header del Curso -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="text-info"><i class="fas fa-book"></i> <?= h($curso->titulo) ?></h2>
                    <p class="text-muted">
                        <i class="fas fa-user-tie"></i> 
                        <?= $curso->hasValue('user') ? $this->Html->link($curso->user->username, ['controller' => 'Users', 'action' => 'view', $curso->user->id]) : 'Sin instructor' ?>
                    </p>
                </div>
                <div class="btn-group" role="group">
                    <?php
                        // Verificar si el usuario actual está inscrito
                        $usuarioActual = $this->getRequest()->getAttribute('identity');
                        $estaAprobado = false;
                        $estaPendiente = false;
                        $estaRechazado = false;
                        
                        if ($usuarioActual && !empty($curso->inscripciones)) {
                            foreach ($curso->inscripciones as $inscripcion) {
                                if ($inscripcion->usuario_id == $usuarioActual->id) {
                                    if ($inscripcion->estado === 'aprobada') {
                                        $estaAprobado = true;
                                    } elseif ($inscripcion->estado === 'pendiente') {
                                        $estaPendiente = true;
                                    } elseif ($inscripcion->estado === 'rechazada') {
                                        $estaRechazado = true;
                                    }
                                    break;
                                }
                            }
                        }
                    ?>
                    
                    <?php if ($estaAprobado): ?>
                        <button class="btn btn-success" disabled>
                            <i class="fas fa-check-circle"></i> Inscrito
                        </button>
                    <?php elseif ($estaPendiente): ?>
                        <button class="btn btn-info" disabled>
                            <i class="fas fa-hourglass-half"></i> Solicitud Pendiente
                        </button>
                    <?php elseif ($estaRechazado): ?>
                        <button class="btn btn-danger" disabled>
                            <i class="fas fa-times-circle"></i> Solicitud Rechazada
                        </button>
                    <?php elseif ($usuarioActual): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-plus-circle"></i> Solicitar Inscripción',
                            ['controller' => 'Inscripciones', 'action' => 'add', '?' => ['curso_id' => $curso->id]],
                            ['class' => 'btn btn-success', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                    
                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-edit"></i> Editar',
                            ['action' => 'edit', $curso->id],
                            ['class' => 'btn btn-warning', 'escape' => false]
                        ) ?>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i> Eliminar',
                            ['action' => 'delete', $curso->id],
                            ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                    
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> Volver',
                        ['action' => 'index'],
                        ['class' => 'btn btn-secondary', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Principal -->
    <div class="row mb-4">
        <div class="col-md-4">
            <?php if (!empty($curso->miniatura)): ?>
                <img src="<?= $this->Url->assetUrl($curso->miniatura) ?>" alt="<?= h($curso->titulo) ?>" class="img-fluid rounded border" style="border: 2px solid #17a2b8; width: 100%; height: auto;">
            <?php else: ?>
                <div class="bg-secondary rounded border d-flex align-items-center justify-content-center" style="height: 300px; border: 2px solid #17a2b8;">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-body">
                    <h5 class="card-title text-info">Detalles del Curso</h5>
                    <table class="table table-borderless table-dark">
                        <tr>
                            <th style="width: 30%;">Nivel:</th>
                            <td><span class="badge bg-secondary"><?= ucfirst(h($curso->nivel)) ?></span></td>
                        </tr>
                        <tr>
                            <th>Categoría:</th>
                            <td><span class="badge bg-primary"><?= h($curso->categoria) ?></span></td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <?php
                                    $estadoClass = $curso->estado === 'activo' ? 'success' : 'danger';
                                    $estadoIcon = $curso->estado === 'activo' ? 'check-circle' : 'times-circle';
                                ?>
                                <span class="badge bg-<?= $estadoClass ?>">
                                    <i class="fas fa-<?= $estadoIcon ?>"></i> <?= ucfirst(h($curso->estado)) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td><?= $curso->created->format('d/m/Y H:i') ?></td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td><?= $curso->modified->format('d/m/Y H:i') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-body">
                    <h5 class="card-title text-info"><i class="fas fa-file-alt"></i> Descripción</h5>
                    <p class="card-text text-muted"><?= $this->Text->autoParagraph(h($curso->descripcion)); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos del Curso -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-layer-group"></i> Módulos del Curso</h5>
                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-plus"></i> Agregar Módulo',
                            ['controller' => 'Modulos', 'action' => 'add', '?' => ['curso_id' => $curso->id]],
                            ['class' => 'btn btn-sm btn-success', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($curso->modulos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Posición</th>
                                        <th>Título</th>
                                        <th>Creado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($curso->modulos as $modulo): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?= h($modulo->posicion) ?></span>
                                            </td>
                                            <td><?= h($modulo->titulo) ?></td>
                                            <td><?= $modulo->created->format('d/m/Y') ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-eye"></i>',
                                                        ['controller' => 'Modulos', 'action' => 'view', $modulo->id],
                                                        ['class' => 'btn btn-info', 'title' => 'Ver', 'escape' => false]
                                                    ) ?>
                                                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                                                        <?= $this->Html->link(
                                                            '<i class="fas fa-edit"></i>',
                                                            ['controller' => 'Modulos', 'action' => 'edit', $modulo->id],
                                                            ['class' => 'btn btn-warning', 'title' => 'Editar', 'escape' => false]
                                                        ) ?>
                                                        <?= $this->Form->postLink(
                                                            '<i class="fas fa-trash"></i>',
                                                            ['controller' => 'Modulos', 'action' => 'delete', $modulo->id],
                                                            ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'title' => 'Eliminar', 'escape' => false]
                                                        ) ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center mb-0">
                            <i class="fas fa-info-circle"></i> No hay módulos disponibles. 
                            <?= $this->Html->link('Crear el primer módulo', ['controller' => 'Modulos', 'action' => 'add', '?' => ['curso_id' => $curso->id]], ['class' => 'alert-link']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Inscripciones (Solo para Administradores) -->
    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-check"></i> Inscripciones (<?= count($curso->inscripciones) ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($curso->inscripciones)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Usuario ID</th>
                                        <th>Progreso</th>
                                        <th>Fecha Inscripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($curso->inscripciones as $inscripcion): ?>
                                        <tr>
                                            <td><?= h($inscripcion->usuario_id) ?></td>
                                            <td>
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= h($inscripcion->progreso) ?>%" aria-valuenow="<?= h($inscripcion->progreso) ?>" aria-valuemin="0" aria-valuemax="100">
                                                        <?= h($inscripcion->progreso) ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $inscripcion->created->format('d/m/Y') ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-eye"></i>',
                                                        ['controller' => 'Inscripciones', 'action' => 'view', $inscripcion->id],
                                                        ['class' => 'btn btn-info', 'title' => 'Ver', 'escape' => false]
                                                    ) ?>
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-edit"></i>',
                                                        ['controller' => 'Inscripciones', 'action' => 'edit', $inscripcion->id],
                                                        ['class' => 'btn btn-warning', 'title' => 'Editar', 'escape' => false]
                                                    ) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center mb-0">
                            <i class="fas fa-info-circle"></i> No hay inscripciones aún.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
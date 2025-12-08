<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Modulo $modulo
 */

// Verificar que el módulo existe
if (empty($modulo)) {
    echo '<div class="alert alert-danger">Módulo no encontrado</div>';
    return;
}

// Si el usuario no está inscrito, mostrar modal
if (!empty($noInscrito)) {
    ?>
    <!-- Modal de Solicitud Pendiente o Rechazada -->
    <?php if (!empty($tieneSolicitud)): ?>
    <div class="modal fade show" id="noInscriptoModal" tabindex="-1" role="dialog" aria-labelledby="noInscriptoLabel" aria-modal="true" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-info text-light">
                <div class="modal-header border-info">
                    <h5 class="modal-title text-info" id="noInscriptoLabel">
                        <i class="fas fa-hourglass-half"></i> Solicitud Pendiente
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3" role="alert">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Tu solicitud está siendo revisada</strong>
                    </div>
                    <p class="mb-3">
                        Tu solicitud de inscripción para el curso <strong><?= h($curso->titulo) ?></strong> ya ha sido enviada y está pendiente de aprobación.
                    </p>
                    <p class="text-muted">
                        Un administrador revisará tu solicitud pronto. Podrás acceder al contenido una vez que sea aprobada.
                    </p>
                    <div class="card bg-secondary border-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-light">
                                <i class="fas fa-layer-group"></i> Módulo que intentabas ver:
                            </h6>
                            <p class="mb-0 text-light"><?= h($modulo->titulo) ?></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-info">
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> Volver al Curso',
                        ['controller' => 'Cursos', 'action' => 'view', $cursoId],
                        ['class' => 'btn btn-secondary', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Modal de No Inscripción - Primera vez -->
    <div class="modal fade show" id="noInscriptoModal" tabindex="-1" role="dialog" aria-labelledby="noInscriptoLabel" aria-modal="true" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-warning text-light">
                <div class="modal-header border-warning">
                    <h5 class="modal-title text-warning" id="noInscriptoLabel">
                        <i class="fas fa-lock"></i> Acceso Restringido
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-3" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Debes solicitar inscripción al curso para acceder a este contenido</strong>
                    </div>
                    <p class="mb-3">
                        Parece que aún no te has inscrito en el curso <strong><?= h($curso->titulo) ?></strong>. 
                        Para acceder a los módulos, lecciones y contenido de este curso, primero debes solicitar tu inscripción.
                    </p>
                    <div class="card bg-secondary border-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-light">
                                <i class="fas fa-layer-group"></i> Módulo que intentabas ver:
                            </h6>
                            <p class="mb-0 text-light"><?= h($modulo->titulo) ?></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-warning">
                    <?= $this->Html->link(
                        '<i class="fas fa-times-circle"></i> Cancelar',
                        ['controller' => 'Cursos', 'action' => 'view', $cursoId],
                        ['class' => 'btn btn-secondary', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-check-circle"></i> Solicitar Inscripción',
                        ['controller' => 'Inscripciones', 'action' => 'add', '?' => ['curso_id' => $cursoId]],
                        ['class' => 'btn btn-warning text-dark fw-bold', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <script>
        // Mostrar modal automáticamente
        var modal = new bootstrap.Modal(document.getElementById('noInscriptoModal'), {
            keyboard: false,
            backdrop: 'static'
        });
        modal.show();
    </script>
    <?php
    return;
}
?>

<div class="container mt-4 mb-4">
    <!-- Header del Módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="text-info"><i class="fas fa-layer-group"></i> <?= h($modulo->titulo) ?></h2>
                    <p class="text-muted">
                        <i class="fas fa-book"></i> 
                        <?= $modulo->hasValue('curso') ? $this->Html->link($modulo->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $modulo->curso->id]) : 'Sin curso asignado' ?>
                    </p>
                </div>
                <div class="btn-group" role="group">
                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-edit"></i> Editar',
                            ['action' => 'edit', $modulo->id],
                            ['class' => 'btn btn-warning', 'escape' => false]
                        ) ?>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i> Eliminar',
                            ['action' => 'delete', $modulo->id],
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
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-body">
                    <h5 class="card-title text-info">Detalles del Módulo</h5>
                    <table class="table table-borderless table-dark">
                        <tr>
                            <th style="width: 30%;">Posición:</th>
                            <td><span class="badge bg-secondary"><?= $this->Number->format($modulo->posicion) ?></span></td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td><?= $modulo->created->format('d/m/Y H:i') ?></td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td><?= $modulo->modified->format('d/m/Y H:i') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Lecciones del Módulo -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chalkboard-teacher"></i> Lecciones del Módulo</h5>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Agregar Lección',
                        ['controller' => 'Lecciones', 'action' => 'add', '?' => ['modulo_id' => $modulo->id]],
                        ['class' => 'btn btn-sm btn-success', 'escape' => false]
                    ) ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($modulo->lecciones)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Posición</th>
                                        <th>Título</th>
                                        <th>Tipo de Contenido</th>
                                        <th>Creado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modulo->lecciones as $leccion): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?= h($leccion->posicion) ?></span>
                                            </td>
                                            <td><?= h($leccion->titulo) ?></td>
                                            <td>
                                                <?php
                                                    $tipoClass = match($leccion->tipo_contenido) {
                                                        'video' => 'primary',
                                                        'texto' => 'info',
                                                        'imagen' => 'success',
                                                        'quiz' => 'warning',
                                                        default => 'secondary'
                                                    };
                                                    $tipoIcon = match($leccion->tipo_contenido) {
                                                        'video' => 'film',
                                                        'texto' => 'file-alt',
                                                        'imagen' => 'image',
                                                        'quiz' => 'question-circle',
                                                        default => 'file'
                                                    };
                                                ?>
                                                <span class="badge bg-<?= $tipoClass ?>">
                                                    <i class="fas fa-<?= $tipoIcon ?>"></i> <?= ucfirst(h($leccion->tipo_contenido)) ?>
                                                </span>
                                            </td>
                                            <td><?= $leccion->created->format('d/m/Y') ?></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-eye"></i>',
                                                        ['controller' => 'Lecciones', 'action' => 'view', $leccion->id],
                                                        ['class' => 'btn btn-info', 'title' => 'Ver', 'escape' => false]
                                                    ) ?>
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-edit"></i>',
                                                        ['controller' => 'Lecciones', 'action' => 'edit', $leccion->id],
                                                        ['class' => 'btn btn-warning', 'title' => 'Editar', 'escape' => false]
                                                    ) ?>
                                                    <?= $this->Form->postLink(
                                                        '<i class="fas fa-trash"></i>',
                                                        ['controller' => 'Lecciones', 'action' => 'delete', $leccion->id],
                                                        ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'title' => 'Eliminar', 'escape' => false]
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
                            <i class="fas fa-info-circle"></i> No hay lecciones disponibles. 
                            <?= $this->Html->link('Crear la primera lección', ['controller' => 'Lecciones', 'action' => 'add', '?' => ['modulo_id' => $modulo->id]], ['class' => 'alert-link']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
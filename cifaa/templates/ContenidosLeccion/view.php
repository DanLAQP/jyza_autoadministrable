<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContenidosLeccion $contenidosLeccion
 */

// Verificar que el contenido existe
if (empty($contenidosLeccion)) {
    echo '<div class="alert alert-danger">Contenido no encontrado</div>';
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
                                <i class="fas fa-file-upload"></i> Contenido que intentabas ver:
                            </h6>
                            <p class="mb-0 text-light">
                                <strong>Tipo:</strong> <?= ucfirst(h($contenidosLeccion->tipo)) ?>
                            </p>
                            <p class="mb-0 text-light">
                                <strong>Lección:</strong> <?= h($leccion->titulo) ?>
                            </p>
                            <p class="mb-0 text-muted small mt-2">En el módulo: <?= h($modulo->titulo) ?></p>
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
                        Para acceder a todas las lecciones y contenido de este curso, primero debes solicitar tu inscripción.
                    </p>
                    <div class="card bg-secondary border-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-light">
                                <i class="fas fa-file-upload"></i> Contenido que intentabas ver:
                            </h6>
                            <p class="mb-0 text-light">
                                <strong>Tipo:</strong> <?= ucfirst(h($contenidosLeccion->tipo)) ?>
                            </p>
                            <p class="mb-0 text-light">
                                <strong>Lección:</strong> <?= h($leccion->titulo) ?>
                            </p>
                            <p class="mb-0 text-muted small mt-2">En el módulo: <?= h($modulo->titulo) ?></p>
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
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="text-info"><i class="fas fa-file-upload"></i> <?= ucfirst(h($contenidosLeccion->tipo)) ?></h2>
                    <p class="text-muted">
                        <i class="fas fa-chalkboard-teacher"></i> 
                        <?= $contenidosLeccion->hasValue('leccione') ? $this->Html->link($contenidosLeccion->leccione->titulo, ['controller' => 'Lecciones', 'action' => 'view', $contenidosLeccion->leccione->id]) : 'Sin lección asignada' ?>
                    </p>
                </div>
                <div class="btn-group" role="group">
                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-edit"></i> Editar',
                            ['action' => 'edit', $contenidosLeccion->id],
                            ['class' => 'btn btn-warning', 'escape' => false]
                        ) ?>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i> Eliminar',
                            ['action' => 'delete', $contenidosLeccion->id],
                            ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> Volver',
                        $contenidosLeccion->hasValue('leccione') ? ['controller' => 'Lecciones', 'action' => 'view', $contenidosLeccion->leccione->id] : ['action' => 'index'],
                        ['class' => 'btn btn-secondary', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Principal -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark mb-4">
                <div class="card-body">
                    <h5 class="card-title text-info">Detalles del Contenido</h5>
                    <table class="table table-borderless table-dark">
                        <tr>
                            <th style="width: 30%;">Tipo:</th>
                            <td>
                                <?php
                                    $tipoClass = match($contenidosLeccion->tipo) {
                                        'video' => 'primary',
                                        'texto' => 'info',
                                        'imagen' => 'success',
                                        'pdf' => 'danger',
                                        'documento' => 'warning',
                                        default => 'secondary'
                                    };
                                    $tipoIcon = match($contenidosLeccion->tipo) {
                                        'video' => 'video',
                                        'texto' => 'align-left',
                                        'imagen' => 'image',
                                        'pdf' => 'file-pdf',
                                        'documento' => 'file-word',
                                        default => 'file'
                                    };
                                ?>
                                <span class="badge bg-<?= $tipoClass ?>">
                                    <i class="fas fa-<?= $tipoIcon ?>"></i> <?= ucfirst(h($contenidosLeccion->tipo)) ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Posición:</th>
                            <td><span class="badge bg-secondary"><?= $this->Number->format($contenidosLeccion->posicion) ?></span></td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td><?= $contenidosLeccion->created->format('d/m/Y H:i') ?></td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td><?= $contenidosLeccion->modified->format('d/m/Y H:i') ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <?php if ($contenidosLeccion->contenido): ?>
                <div class="card border-0 shadow-sm bg-dark mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-align-left"></i> Contenido de Texto</h5>
                    </div>
                    <div class="card-body">
                        <div class="content-text">
                            <?= nl2br(h($contenidosLeccion->contenido)) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($contenidosLeccion->archivo): ?>
                <div class="card border-0 shadow-sm bg-dark">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-download"></i> Archivo</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Nombre:</strong> <?= basename($contenidosLeccion->archivo) ?>
                        </p>
                        <p>
                            <strong>Tamaño:</strong> 
                            <?php
                                $filePath = WWW_ROOT . $contenidosLeccion->archivo;
                                if (file_exists($filePath)) {
                                    $sizeInBytes = filesize($filePath);
                                    $sizeInKB = $sizeInBytes / 1024;
                                    $sizeInMB = $sizeInKB / 1024;
                                    
                                    if ($sizeInMB > 1) {
                                        echo number_format($sizeInMB, 2) . ' MB';
                                    } else {
                                        echo number_format($sizeInKB, 2) . ' KB';
                                    }
                                }
                            ?>
                        </p>
                        <a href="<?= $this->Url->assetUrl($contenidosLeccion->archivo) ?>" target="_blank" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
                <strong><?= __('Contenido') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contenidosLeccion->contenido)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leccion $leccion
 */

// Verificar que la lección existe
if (empty($leccion)) {
    echo '<div class="alert alert-danger">Lección no encontrada</div>';
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
                                <i class="fas fa-book"></i> Lección que intentabas ver:
                            </h6>
                            <p class="mb-0 text-light"><?= h($leccion->titulo) ?></p>
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
                        Para acceder a las lecciones y contenido de este curso, primero debes solicitar tu inscripción.
                    </p>
                    <div class="card bg-secondary border-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-light">
                                <i class="fas fa-book"></i> Lección que intentabas ver:
                            </h6>
                            <p class="mb-0 text-light"><?= h($leccion->titulo) ?></p>
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
    <!-- Header de la Lección -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="text-info"><i class="fas fa-chalkboard-teacher"></i> <?= h($leccion->titulo) ?></h2>
                    <p class="text-muted">
                        <i class="fas fa-layer-group"></i> 
                        <?= $leccion->hasValue('modulo') ? $this->Html->link($leccion->modulo->titulo, ['controller' => 'Modulos', 'action' => 'view', $leccion->modulo->id]) : 'Sin módulo asignado' ?>
                    </p>
                </div>
                <div class="btn-group" role="group">
                    <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-edit"></i> Editar',
                            ['action' => 'edit', $leccion->id],
                            ['class' => 'btn btn-warning', 'escape' => false]
                        ) ?>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i> Eliminar',
                            ['action' => 'delete', $leccion->id],
                            ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left"></i> Volver',
                        $leccion->hasValue('modulo') ? ['controller' => 'Modulos', 'action' => 'view', $leccion->modulo->id] : ['action' => 'index'],
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
                    <h5 class="card-title text-info">Detalles de la Lección</h5>
                    <table class="table table-borderless table-dark">
                        <tr>
                            <th style="width: 30%;">Tipo de Contenido:</th>
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
                        </tr>
                        <tr>
                            <th>Posición:</th>
                            <td><span class="badge bg-secondary"><?= $this->Number->format($leccion->posicion) ?></span></td>
                        </tr>
                        <tr>
                            <th>Creado:</th>
                            <td><?= $leccion->created->format('d/m/Y H:i') ?></td>
                        </tr>
                        <tr>
                            <th>Actualizado:</th>
                            <td><?= $leccion->modified->format('d/m/Y H:i') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenidos de la Lección -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-upload"></i> Contenidos de la Lección</h5>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Agregar Contenido',
                        ['controller' => 'ContenidosLeccion', 'action' => 'add', '?' => ['leccion_id' => $leccion->id]],
                        ['class' => 'btn btn-sm btn-primary text-dark fw-bold', 'escape' => false]
                    ) ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($leccion->contenidos_leccion)): ?>
                        <div class="row g-3">
                            <?php foreach ($leccion->contenidos_leccion as $contenido): ?>
                                <div class="col-12 col-lg-6">
                                    <div class="card border-0 bg-secondary shadow-sm h-100">
                                        <!-- Header de la Card -->
                                        <div class="card-header bg-dark border-bottom border-light d-flex justify-content-between align-items-center">
                                            <div>
                                                <?php
                                                    $tipoContentClass = match($contenido->tipo) {
                                                        'video' => 'primary',
                                                        'texto' => 'info',
                                                        'imagen' => 'success',
                                                        'pdf' => 'danger',
                                                        'documento' => 'warning',
                                                        default => 'secondary'
                                                    };
                                                    $tipoContentIcon = match($contenido->tipo) {
                                                        'video' => 'video',
                                                        'texto' => 'align-left',
                                                        'imagen' => 'image',
                                                        'pdf' => 'file-pdf',
                                                        'documento' => 'file-word',
                                                        default => 'file'
                                                    };
                                                ?>
                                                <span class="badge bg-<?= $tipoContentClass ?> me-2">
                                                    <i class="fas fa-<?= $tipoContentIcon ?>"></i> <?= ucfirst(h($contenido->tipo)) ?>
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    Pos. <?= h($contenido->posicion) ?>
                                                </span>
                                            </div>
                                            <small class="text-muted"><?= $contenido->created->format('d/m/Y') ?></small>
                                        </div>

                                        <!-- Contenido de la Card -->
                                        <div class="card-body d-flex flex-column">
                                            <!-- Texto/Descripción -->
                                            <?php if ($contenido->contenido): ?>
                                                <div class="mb-3">
                                                    <h6 class="card-subtitle text-white mb-2">
                                                        <i class="fas fa-align-left"></i> Descripción/Contenido
                                                    </h6>
                                                    <p class="card-text text-light small" style="line-height: 1.6;">
                                                        <?= nl2br(h(strlen($contenido->contenido) > 300 ? substr($contenido->contenido, 0, 300) . '...' : $contenido->contenido)) ?>
                                                    </p>
                                                </div>
                                                <hr class="border-light">
                                            <?php endif; ?>

                                            <!-- Archivo/Video -->
                                            <?php if ($contenido->archivo): ?>
                                                <div class="mb-3 flex-grow-1">
                                                    <h6 class="card-subtitle text-white mb-2">
                                                        <i class="fas fa-paperclip"></i> Recurso
                                                    </h6>
                                                    <?php
                                                        $extension = strtolower(pathinfo($contenido->archivo, PATHINFO_EXTENSION));
                                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                        $isVideo = in_array($extension, ['mp4', 'webm']);
                                                        $isPdf = $extension === 'pdf';
                                                    ?>
                                                    
                                                    <?php if ($isImage): ?>
                                                        <div class="mb-3">
                                                            <img src="<?= $this->Url->assetUrl($contenido->archivo) ?>" 
                                                                 alt="<?= h($contenido->tipo) ?>" 
                                                                 class="img-fluid rounded border border-light"
                                                                 style="max-height: 250px; object-fit: cover; width: 100%;">
                                                        </div>
                                                    <?php elseif ($isVideo): ?>
                                                        <div class="mb-3">
                                                            <video width="100%" height="auto" controls class="rounded border border-light">
                                                                <source src="<?= $this->Url->assetUrl($contenido->archivo) ?>" type="video/<?= $extension ?>">
                                                                Tu navegador no soporta la etiqueta de video.
                                                            </video>
                                                        </div>
                                                    <?php elseif ($isPdf): ?>
                                                        <div class="mb-3">
                                                            <embed src="<?= $this->Url->assetUrl($contenido->archivo) ?>" 
                                                                   type="application/pdf" 
                                                                   class="w-100 rounded border border-light"
                                                                   style="height: 400px;">
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="d-flex align-items-center p-3 bg-dark rounded border border-light">
                                                            <?php
                                                                $icon = match($extension) {
                                                                    'pdf' => 'file-pdf',
                                                                    'doc', 'docx' => 'file-word',
                                                                    'xls', 'xlsx' => 'file-excel',
                                                                    default => 'file'
                                                                };
                                                                $color = match($extension) {
                                                                    'pdf' => 'danger',
                                                                    'doc', 'docx' => 'primary',
                                                                    'xls', 'xlsx' => 'success',
                                                                    default => 'secondary'
                                                                };
                                                            ?>
                                                            <i class="fas fa-<?= $icon ?> text-<?= $color ?>" style="font-size: 2rem;"></i>
                                                            <div class="ms-3 flex-grow-1">
                                                                <small class="text-light d-block text-truncate">
                                                                    <?= basename($contenido->archivo) ?>
                                                                </small>
                                                                <small class="text-muted d-block">
                                                                    <?php
                                                                        $filePath = WWW_ROOT . $contenido->archivo;
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
                                                                </small>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Footer de la Card con Acciones -->
                                        <div class="card-footer bg-dark border-top border-light">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-eye"></i>',
                                                    ['controller' => 'ContenidosLeccion', 'action' => 'view', $contenido->id],
                                                    ['class' => 'btn btn-sm btn-info', 'title' => 'Ver detalle', 'escape' => false]
                                                ) ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-edit"></i>',
                                                    ['controller' => 'ContenidosLeccion', 'action' => 'edit', $contenido->id],
                                                    ['class' => 'btn btn-sm btn-warning', 'title' => 'Editar', 'escape' => false]
                                                ) ?>
                                                <?= $this->Form->postLink(
                                                    '<i class="fas fa-trash"></i>',
                                                    ['controller' => 'ContenidosLeccion', 'action' => 'delete', $contenido->id],
                                                    ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-sm btn-danger', 'title' => 'Eliminar', 'escape' => false]
                                                ) ?>
                                                <?php if ($contenido->archivo): ?>
                                                    <a href="<?= $this->Url->assetUrl($contenido->archivo) ?>" 
                                                       download 
                                                       class="btn btn-sm btn-success" 
                                                       title="Descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center mb-0" role="alert">
                            <i class="fas fa-info-circle"></i> No hay contenidos disponibles. 
                            <?= $this->Html->link('Agregar el primer contenido', ['controller' => 'ContenidosLeccion', 'action' => 'add', '?' => ['leccion_id' => $leccion->id]], ['class' => 'alert-link']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


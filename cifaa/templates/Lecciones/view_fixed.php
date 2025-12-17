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

$modulo = $leccion->modulo;
$curso = $modulo->curso;
$identity = $this->getRequest()->getAttribute('identity');
?>

<div class="container py-4">
    <div class="row">
        <!-- ============================================ -->
        <!-- PLAYER / CONTENIDO PRINCIPAL                 -->
        <!-- ============================================ -->
        <div class="col-lg-8 mb-4">
            <!-- Breadcrumb / Navegación -->
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-dark p-3 rounded">
                        <li class="breadcrumb-item">
                            <?= $this->Html->link(
                                '<i class="fas fa-arrow-left me-1"></i>Volver al curso',
                                ['controller' => 'Cursos', 'action' => 'view', $curso->id],
                                ['class' => 'text-info text-decoration-none', 'escape' => false]
                            ) ?>
                        </li>
                        <li class="breadcrumb-item active text-muted" aria-current="page">
                            Módulo: <?= h($modulo->titulo) ?>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Título de la Lección -->
            <h2 class="h4 mb-3 text-light">
                <i class="fas fa-chalkboard-teacher me-2 text-info"></i>
                <?= h($leccion->titulo) ?>
            </h2>

            <!-- Tabs / Selector de Contenidos -->
            <?php if (!empty($leccion->contenidos_leccion)): ?>
                <ul class="nav nav-tabs mb-3 border-bottom border-secondary" role="tablist">
                    <?php foreach ($leccion->contenidos_leccion as $index => $cont): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?> text-light"
                                    id="tab-contenido-<?= $cont->id ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#contenido-<?= $cont->id ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="contenido-<?= $cont->id ?>"
                                    aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                                <i class="fas fa-<?= match(strtolower(pathinfo($cont->archivo ?? '', PATHINFO_EXTENSION))) {
                                    'pdf' => 'file-pdf',
                                    'doc', 'docx' => 'file-word',
                                    'xls', 'xlsx' => 'file-excel',
                                    'mp4', 'webm' => 'play-circle',
                                    'jpg', 'jpeg', 'png', 'gif', 'webp' => 'image',
                                    default => 'file'
                                } ?> me-1"></i>
                                <?= h($cont->contenido ?: basename($cont->archivo ?? 'Contenido ' . ($index + 1))) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <?php foreach ($leccion->contenidos_leccion as $index => $cont): ?>
                        <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>"
                             id="contenido-<?= $cont->id ?>"
                             role="tabpanel"
                             aria-labelledby="tab-contenido-<?= $cont->id ?>">
                            <div class="card mb-3 bg-dark border-secondary shadow">
                                <div class="card-body p-0">
                                    <?php if ($cont->archivo): ?>
                                        <?php
                                        $ext = strtolower(pathinfo($cont->archivo, PATHINFO_EXTENSION));
                                        $isImg = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                                        $isVid = in_array($ext, ['mp4','webm']);
                                        $isPdf = $ext === 'pdf';
                                        ?>
                                        <?php if ($isVid): ?>
                                            <video width="100%" controls class="rounded" style="max-height: 500px;">
                                                <source src="<?= $this->Url->assetUrl($cont->archivo) ?>" type="video/<?= $ext ?>">
                                                Tu navegador no soporta video HTML5.
                                            </video>
                                        <?php elseif ($isImg): ?>
                                            <img src="<?= $this->Url->assetUrl($cont->archivo) ?>"
                                                 alt="<?= h($leccion->titulo) ?>"
                                                 class="img-fluid rounded w-100"
                                                 style="max-height: 500px; object-fit: contain; background: #000;">
                                        <?php elseif ($isPdf): ?>
                                            <embed src="<?= $this->Url->assetUrl($cont->archivo) ?>"
                                                   type="application/pdf"
                                                   class="w-100 rounded"
                                                   style="height: 600px;">
                                        <?php else: ?>
                                            <div class="p-5 text-center">
                                                <i class="fas fa-file fa-4x text-muted mb-3"></i>
                                                <p class="text-muted">Recurso no compatible para previsualizar.</p>
                                                <a href="<?= $this->Url->assetUrl($cont->archivo) ?>" download class="btn btn-info">
                                                    <i class="fas fa-download me-1"></i>Descargar
                                                </a>    
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="p-5 text-center">
                                            <i class="fas fa-align-left fa-4x text-muted mb-3"></i>
                                            <p class="text-muted">Contenido sin archivo adjunto.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Descripción del contenido -->
                            <?php if ($cont->contenido): ?>
                                <div class="card bg-dark border-secondary">
                                    <div class="card-body">
                                        <h5 class="card-title text-info mb-3">
                                            <i class="fas fa-align-left me-2"></i>Descripción
                                        </h5>
                                        <p class="card-text text-light" style="line-height: 1.8;">
                                            <?= nl2br(h($cont->contenido)) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Sin contenidos -->
                <div class="card mb-3 bg-dark border-secondary shadow">
                    <div class="card-body p-0">
                        <div class="p-5 text-center">
                            <i class="fas fa-video-slash fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Esta lección aún no tiene contenido.</p>
                            <?php if (!empty($identity) && $identity->rol == 1): ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-plus me-1"></i>Agregar Contenido',
                                    ['controller' => 'ContenidosLeccion', 'action' => 'add', '?' => ['leccion_id' => $leccion->id]],
                                    ['class' => 'btn btn-primary openModal', 'escape' => false]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Detalles de la Lección -->
            <div class="card bg-dark border-secondary mt-3">
                <div class="card-body">
                    <h6 class="text-info mb-3"><i class="fas fa-info-circle me-2"></i>Detalles</h6>
                    <div class="row text-muted small">
                        <div class="col-md-6 mb-2">
                            <i class="fas fa-list-ol me-2 text-info"></i>
                            <strong>Posición:</strong> Lección <?= h($leccion->posicion) ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <?php
                                $tipoIcon = match($leccion->tipo_contenido) {
                                    'video' => 'film',
                                    'texto' => 'file-alt',
                                    'imagen' => 'image',
                                    'quiz' => 'question-circle',
                                    default => 'file'
                                };
                            ?>
                            <i class="fas fa-<?= $tipoIcon ?> me-2 text-info"></i>
                            <strong>Tipo:</strong> <?= ucfirst(h($leccion->tipo_contenido)) ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <i class="far fa-calendar-plus me-2 text-info"></i>
                            <strong>Creado:</strong> <?= $leccion->created->format('d/m/Y') ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <i class="far fa-calendar-check me-2 text-info"></i>
                            <strong>Actualizado:</strong> <?= $leccion->modified->format('d/m/Y') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Admin -->
            <?php if (!empty($identity) && $identity->rol == 1): ?>
                <div class="d-flex gap-2 mt-3">
                    <?= $this->Html->link(
                        '<i class="fas fa-edit me-1"></i>Editar Lección',
                        ['action' => 'edit', $leccion->id],
                        ['class' => 'btn btn-warning openModal', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus me-1"></i>Agregar Contenido',
                        ['controller' => 'ContenidosLeccion', 'action' => 'add', '?' => ['leccion_id' => $leccion->id]],
                        ['class' => 'btn btn-success openModal', 'escape' => false]
                    ) ?>
                    <?= $this->Form->postLink(
                        '<i class="fas fa-trash me-1"></i>Eliminar',
                        ['action' => 'delete', $leccion->id],
                        ['confirm' => '¿Estás seguro?', 'class' => 'btn btn-danger', 'escape' => false]
                    ) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ============================================ -->
        <!-- SIDEBAR: Índice y Recursos                   -->
        <!-- ============================================ -->
        <div class="col-lg-4">
            <!-- Índice de Lecciones del Módulo -->
            <div class="card mb-3 bg-dark border-secondary shadow">
                <div class="card-header bg-info text-white">
                    <strong><i class="fas fa-list me-2"></i>Lecciones del módulo</strong>
                </div>
                <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    <?php if (!empty($modulo->lecciones)): ?>
                        <?php foreach ($modulo->lecciones as $lec): ?>
                            <?php
                                $isActive = $lec->id === $leccion->id;
                                $iconLec = match($lec->tipo_contenido) {
                                    'video' => 'play-circle',
                                    'texto' => 'file-alt',
                                    'imagen' => 'image',
                                    'quiz' => 'question-circle',
                                    default => 'file'
                                };
                            ?>
                            <div class="list-group-item bg-dark border-secondary <?= $isActive ? 'border-info border-2' : '' ?> d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center flex-grow-1">
                                    <span class="badge bg-<?= $isActive ? 'info' : 'secondary' ?> me-2">
                                        <?= $lec->posicion ?>
                                    </span>
                                    <div class="flex-grow-1">
                                        <div class="text-light small">
                                            <i class="far fa-<?= $iconLec ?> me-1"></i>
                                            <?= h($lec->titulo) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!$isActive): ?>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-play"></i>',
                                        ['action' => 'view', $lec->id],
                                        ['class' => 'btn btn-sm btn-outline-info rounded-circle', 'escape' => false, 'title' => 'Ver lección']
                                    ) ?>
                                <?php else: ?>
                                    <i class="fas fa-circle text-info" style="font-size: 0.6rem;"></i>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="list-group-item bg-dark border-secondary text-muted small">
                            <i class="fas fa-info-circle me-1"></i>No hay lecciones en este módulo.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recursos Descargables -->
            <div class="card bg-dark border-secondary shadow">
                <div class="card-header bg-success text-white">
                    <strong><i class="fas fa-download me-2"></i>Recursos de la lección</strong>
                </div>
                <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                    <?php if (!empty($leccion->contenidos_leccion)): ?>
                        <?php foreach ($leccion->contenidos_leccion as $cont): ?>
                            <?php 
                                $ext = strtolower(pathinfo($cont->archivo ?? '', PATHINFO_EXTENSION));
                                $iconRecurso = match($ext) {
                                    'pdf' => 'file-pdf',
                                    'doc', 'docx' => 'file-word',
                                    'xls', 'xlsx' => 'file-excel',
                                    'mp4', 'webm' => 'file-video',
                                    'jpg', 'jpeg', 'png', 'gif', 'webp' => 'file-image',
                                    default => 'file'
                                };
                                $colorRecurso = match($ext) {
                                    'pdf' => 'danger',
                                    'doc', 'docx' => 'primary',
                                    'xls', 'xlsx' => 'success',
                                    'mp4', 'webm' => 'info',
                                    'jpg', 'jpeg', 'png', 'gif', 'webp' => 'warning',
                                    default => 'secondary'
                                };
                            ?>
                            <div class="list-group-item bg-dark border-secondary d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center flex-grow-1 me-2">
                                    <i class="fas fa-<?= $iconRecurso ?> text-<?= $colorRecurso ?> me-3" style="font-size: 1.5rem;"></i>
                                    <div class="flex-grow-1" style="min-width: 0;">
                                        <div class="fw-semibold text-light small text-truncate">
                                            <?= h($cont->contenido ?: basename($cont->archivo ?? '')) ?>
                                        </div>
                                        <?php if ($cont->archivo): ?>
                                            <span class="text-muted text-uppercase" style="font-size: 0.7rem;">
                                                <?= $ext ?>
                                                <?php
                                                    $filePath = WWW_ROOT . $cont->archivo;
                                                    if (file_exists($filePath)) {
                                                        $sizeInBytes = filesize($filePath);
                                                        $sizeInMB = $sizeInBytes / 1024 / 1024;
                                                        if ($sizeInMB > 1) {
                                                            echo ' · ' . number_format($sizeInMB, 1) . ' MB';
                                                        } else {
                                                            echo ' · ' . number_format($sizeInBytes / 1024, 0) . ' KB';
                                                        }
                                                    }
                                                ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted" style="font-size: 0.7rem;">Sin archivo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Restricción: Solo Admin (rol 1) y Docente (rol 2) pueden descargar -->
                                <div class="d-flex gap-2">
                                    <?php if ($cont->archivo): ?>
                                        <?php if (!empty($identity) && in_array($identity->rol, [1, 2])): ?>
                                            <a href="<?= $this->Url->assetUrl($cont->archivo) ?>" download
                                               class="btn btn-outline-success btn-sm rounded-circle"
                                               title="Descargar archivo">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        <?php else: ?>
                                            <!-- Botón deshabilitado para estudiantes -->
                                            <button class="btn btn-outline-secondary btn-sm rounded-circle" 
                                                    disabled 
                                                    title="Descarga no disponible para estudiantes">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <!-- Botón editar solo para admin -->
                                    <?php if (!empty($identity) && $identity->rol == 1): ?>
                                        <?= $this->Html->link(
                                            '<i class="fas fa-edit"></i>',
                                            ['controller' => 'ContenidosLeccion', 'action' => 'edit', $cont->id],
                                            ['class' => 'btn btn-outline-warning btn-sm rounded-circle openModal', 'escape' => false, 'title' => 'Editar contenido']
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="list-group-item bg-dark border-secondary text-muted small">
                            <i class="fas fa-info-circle me-1"></i>No hay recursos adjuntos.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

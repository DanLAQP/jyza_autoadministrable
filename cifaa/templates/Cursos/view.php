<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Curso $curso
 * @var bool $estaAprobado
 * @var bool $estaPendiente
 * @var bool $estaRechazado
 * @var int $progresoUsuario
 * @var int $totalLecciones
 * @var int $totalEstudiantes
 */

// Verificar que el curso existe
if (empty($curso)) {
    echo '<div class="alert alert-danger">Curso no encontrado</div>';
    return;
}

$identity = $this->getRequest()->getAttribute('identity');
?>

<div class="container py-4">
    <div class="row">
        <!-- ============================================ -->
        <!-- COLUMNA PRINCIPAL (Contenido del curso)      -->
        <!-- ============================================ -->
        <div class="col-lg-8 mb-4">
            <!-- Cover / Miniatura Grande -->
            <div class="mb-3 position-relative">
                <?php if (!empty($curso->miniatura)): ?>
                    <img src="<?= $this->Url->assetUrl($curso->miniatura) ?>"
                         alt="<?= h($curso->titulo) ?>"
                         class="img-fluid rounded-3 w-100"
                         style="max-height: 420px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    <?php if ($estaAprobado): ?>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <button class="btn btn-light rounded-circle shadow-lg" style="width: 70px; height: 70px;">
                                <i class="fas fa-play fa-2x text-info"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center"
                         style="height: 320px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                        <i class="fas fa-image fa-4x text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Título + Autor -->
            <h1 class="h3 mb-1 text-light"><?= h($curso->titulo) ?></h1>
            <p class="text-muted mb-2">
                <i class="fas fa-user-tie me-1"></i>
                <?= $curso->hasValue('user')
                    ? $this->Html->link($curso->user->username, ['controller' => 'Users', 'action' => 'view', $curso->user->id], ['class' => 'text-info text-decoration-none'])
                    : 'Sin instructor' ?>
            </p>

            <!-- Stats pequeños tipo Domestika -->
            <div class="d-flex flex-wrap gap-3 small text-muted mb-3">
                <span><i class="fas fa-list-ul me-1"></i><?= $totalLecciones ?> lecciones</span>
                <span><i class="fas fa-users me-1"></i><?= $totalEstudiantes ?> estudiantes</span>
                <span><i class="fas fa-signal me-1"></i><?= ucfirst(h($curso->nivel)) ?></span>
                <?php if ($curso->categoria): ?>
                    <span><i class="fas fa-tag me-1"></i><?= h($curso->categoria) ?></span>
                <?php endif; ?>
            </div>

            <!-- Tabs Presentación / Contenido -->
            <ul class="nav nav-tabs mt-3" id="cursoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="presentacion-tab" data-bs-toggle="tab"
                            data-bs-target="#presentacion" type="button" role="tab">
                        <i class="fas fa-info-circle me-1"></i> Presentación
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contenido-tab" data-bs-toggle="tab"
                            data-bs-target="#contenido" type="button" role="tab">
                        <i class="fas fa-book-open me-1"></i> Contenido
                    </button>
                </li>
            </ul>

            <div class="tab-content border-start border-end border-bottom p-3 bg-dark rounded-bottom" id="cursoTabsContent">
                <!-- TAB 1: Presentación -->
                <div class="tab-pane fade show active" id="presentacion" role="tabpanel">
                    <h5 class="text-info"><i class="fas fa-file-alt me-2"></i>Descripción</h5>
                    <p class="mb-3 text-light">
                        <?= $this->Text->autoParagraph(h($curso->descripcion)) ?>
                    </p>

                    <hr class="border-secondary">

                    <h6 class="text-info"><i class="fas fa-info-circle me-2"></i>Información adicional</h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2">
                            <strong><i class="fas fa-signal me-2"></i>Nivel:</strong> 
                            <span class="badge bg-secondary"><?= ucfirst(h($curso->nivel)) ?></span>
                        </li>
                        <li class="mb-2">
                            <strong><i class="fas fa-toggle-on me-2"></i>Estado:</strong> 
                            <?php
                                $estadoClass = $curso->estado === 'activo' ? 'success' : 'danger';
                                $estadoIcon = $curso->estado === 'activo' ? 'check-circle' : 'times-circle';
                            ?>
                            <span class="badge bg-<?= $estadoClass ?>">
                                <i class="fas fa-<?= $estadoIcon ?>"></i> <?= ucfirst(h($curso->estado)) ?>
                            </span>
                        </li>
                        <li class="mb-2"><strong><i class="far fa-calendar-plus me-2"></i>Creado:</strong> <?= $curso->created->format('d/m/Y') ?></li>
                        <li class="mb-2"><strong><i class="far fa-calendar-check me-2"></i>Última actualización:</strong> <?= $curso->modified->format('d/m/Y') ?></li>
                    </ul>
                </div>

                <!-- TAB 2: Contenido (Módulos + Lecciones) -->
                <div class="tab-pane fade" id="contenido" role="tabpanel">
                    <?php if (!empty($curso->modulos)): ?>
                        <div class="accordion accordion-flush" id="modulosAccordion">
                            <?php foreach ($curso->modulos as $index => $modulo): ?>
                                <div class="accordion-item bg-dark border-secondary">
                                    <h2 class="accordion-header" id="heading<?= $modulo->id ?>">
                                        <button class="accordion-button bg-dark text-light <?= $index === 0 ? '' : 'collapsed' ?>"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse<?= $modulo->id ?>"
                                                aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">
                                            <span class="me-2 badge bg-info"><?= $modulo->posicion ?></span>
                                            <strong><?= h($modulo->titulo) ?></strong>
                                            <?php if (!empty($modulo->lecciones)): ?>
                                                <span class="ms-auto me-3 small text-muted">
                                                    <?= count($modulo->lecciones) ?> lecciones
                                                </span>
                                            <?php endif; ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $modulo->id ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                                         aria-labelledby="heading<?= $modulo->id ?>"
                                         data-bs-parent="#modulosAccordion">
                                        <div class="accordion-body p-0 bg-dark">
                                            <?php if (!empty($modulo->lecciones)): ?>
                                                <ul class="list-group list-group-flush">
                                                    <?php foreach ($modulo->lecciones as $leccion): ?>
                                                        <?php
                                                            // Icono por tipo de contenido
                                                            $icon = match($leccion->tipo_contenido) {
                                                                'video' => 'play-circle',
                                                                'texto' => 'file-alt',
                                                                'imagen' => 'image',
                                                                'quiz' => 'question-circle',
                                                                default => 'file'
                                                            };

                                                            $bloqueado = !$estaAprobado; // Si no está aprobado, bloqueamos
                                                        ?>
                                                        <li class="list-group-item bg-dark border-secondary d-flex align-items-center justify-content-between py-3">
                                                            <div class="d-flex align-items-center flex-grow-1">
                                                                <i class="far fa-<?= $icon ?> me-3 text-info" style="font-size: 1.2rem;"></i>
                                                                <div>
                                                                    <div class="text-light"><?= h($leccion->titulo) ?></div>
                                                                    <small class="text-muted">
                                                                        Lección <?= h($leccion->posicion) ?>
                                                                        <?php if (!empty($leccion->contenidos_leccion)): ?>
                                                                            · <?= count($leccion->contenidos_leccion) ?> recursos
                                                                        <?php endif; ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <?php if ($bloqueado): ?>
                                                                    <span class="text-muted small">
                                                                        <i class="fas fa-lock me-1"></i>Solo alumnos
                                                                    </span>
                                                                <?php else: ?>
                                                                    <?= $this->Html->link(
                                                                        '<i class="fas fa-play me-1"></i>Ver',
                                                                        ['controller' => 'Lecciones', 'action' => 'view', $leccion->id],
                                                                        [
                                                                            'class' => 'btn btn-sm btn-outline-info rounded-pill',
                                                                            'escape' => false,
                                                                            'title' => 'Ver lección'
                                                                        ]
                                                                    ) ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-muted small p-3 mb-0">
                                                    <i class="fas fa-info-circle me-1"></i>Sin lecciones aún.
                                                    <?php if (!empty($identity) && $identity->rol == 1): ?>
                                                        <?= $this->Html->link(
                                                            'Agregar lección',
                                                            ['controller' => 'Lecciones', 'action' => 'add', '?' => ['modulo_id' => $modulo->id]],
                                                            ['class' => 'text-info']
                                                        ) ?>
                                                    <?php endif; ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>Este curso todavía no tiene módulos.
                            <?php if (!empty($identity) && $identity->rol == 1): ?>
                                <?= $this->Html->link(
                                    'Crear el primer módulo',
                                    ['controller' => 'Modulos', 'action' => 'add', '?' => ['curso_id' => $curso->id]],
                                    ['class' => 'alert-link']
                                ) ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- SIDEBAR (Inscripción y metadatos)            -->
        <!-- ============================================ -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-3 bg-dark border-secondary">
                <div class="card-body">
                    <?php if ($identity): ?>
                        <?php if ($estaAprobado): ?>
                            <button class="btn btn-success w-100 mb-3" onclick="document.getElementById('contenido-tab').click(); document.querySelector('.accordion-button').click();">
                                <i class="fas fa-play me-1"></i> Continuar curso
                            </button>
                            <label class="small text-muted mb-1">Tu progreso</label>
                            <div class="progress mb-2" style="height: 12px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: <?= (int)$progresoUsuario ?>%;"
                                     aria-valuenow="<?= (int)$progresoUsuario ?>"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="small text-muted mb-0"><?= $progresoUsuario ?>% completado</p>
                        <?php elseif ($estaPendiente): ?>
                            <button class="btn btn-info w-100 mb-3" disabled>
                                <i class="fas fa-hourglass-half me-1"></i> Solicitud Pendiente
                            </button>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Tu solicitud está siendo revisada por un administrador.
                            </p>
                        <?php elseif ($estaRechazado): ?>
                            <button class="btn btn-danger w-100 mb-3" disabled>
                                <i class="fas fa-times-circle me-1"></i> Solicitud Rechazada
                            </button>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Tu solicitud fue rechazada. Contacta al administrador.
                            </p>
                        <?php else: ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-plus-circle me-1"></i> Solicitar Inscripción',
                                ['controller' => 'Cursos', 'action' => 'solicitar', $curso->id],
                                [
                                    'class' => 'btn btn-primary w-100 mb-3', 
                                    'escape' => false,
                                    'confirm' => '¿Estás seguro de que deseas solicitar inscripción al curso "' . h($curso->titulo) . '"?'
                                ]
                            ) ?>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Tu solicitud será enviada al administrador para aprobación.
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Inicia sesión para inscribirte en este curso.
                        </p>
                        <?= $this->Html->link(
                            '<i class="fas fa-sign-in-alt me-1"></i>Iniciar sesión',
                            ['controller' => 'Users', 'action' => 'login'],
                            ['class' => 'btn btn-outline-primary w-100 mb-3', 'escape' => false]
                        ) ?>
                    <?php endif; ?>

                    <hr class="border-secondary">

                    <ul class="list-unstyled small mb-0 text-muted">
                        <li class="mb-2 d-flex align-items-center">
                            <i class="fas fa-signal me-2 text-info" style="width: 20px;"></i>
                            <span>Nivel: <strong class="text-light"><?= ucfirst(h($curso->nivel)) ?></strong></span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="fas fa-book me-2 text-info" style="width: 20px;"></i>
                            <span>Lecciones: <strong class="text-light"><?= $totalLecciones ?></strong></span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="fas fa-users me-2 text-info" style="width: 20px;"></i>
                            <span>Estudiantes: <strong class="text-light"><?= $totalEstudiantes ?></strong></span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="far fa-calendar-alt me-2 text-info" style="width: 20px;"></i>
                            <span>Creado: <strong class="text-light"><?= $curso->created->format('d/m/Y') ?></strong></span>
                        </li>
                        <?php if ($curso->categoria): ?>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="fas fa-tag me-2 text-info" style="width: 20px;"></i>
                            <span>Categoría: <strong class="text-light"><?= h($curso->categoria) ?></strong></span>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <?php if (!empty($identity) && $identity->rol == 1): ?>
                        <hr class="border-secondary">
                        <div class="d-grid gap-2">
                            <?= $this->Html->link(
                                '<i class="fas fa-edit me-1"></i> Editar Curso',
                                ['action' => 'edit', $curso->id],
                                ['class' => 'btn btn-sm btn-warning', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-plus me-1"></i> Agregar Módulo',
                                ['controller' => 'Modulos', 'action' => 'add', '?' => ['curso_id' => $curso->id]],
                                ['class' => 'btn btn-sm btn-success', 'escape' => false]
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash me-1"></i> Eliminar Curso',
                                ['action' => 'delete', $curso->id],
                                ['confirm' => '¿Estás seguro de eliminar este curso?', 'class' => 'btn btn-sm btn-danger', 'escape' => false]
                            ) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Botón Volver -->
            <div class="d-grid">
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left me-1"></i> Volver a Cursos',
                    ['action' => 'index'],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- Inscripciones (Solo para Administradores) -->
    <?php if (!empty($identity) && $identity->rol == 1 && !empty($curso->inscripciones)): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark border-secondary">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-check me-2"></i>
                        Inscripciones (<?= count($curso->inscripciones) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Progreso</th>
                                    <th>Fecha Inscripción</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($curso->inscripciones as $inscripcion): ?>
                                    <tr>
                                        <td>
                                            <?php if ($inscripcion->hasValue('user')): ?>
                                                <i class="fas fa-user me-2"></i><?= h($inscripcion->user->username) ?>
                                            <?php else: ?>
                                                ID: <?= h($inscripcion->usuario_id) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $estadoBadge = match($inscripcion->estado) {
                                                    'aprobada' => 'success',
                                                    'pendiente' => 'warning',
                                                    'rechazada' => 'danger',
                                                    default => 'secondary'
                                                };
                                            ?>
                                            <span class="badge bg-<?= $estadoBadge ?>">
                                                <?= ucfirst(h($inscripcion->estado)) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px; min-width: 100px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: <?= h($inscripcion->progreso) ?>%" 
                                                     aria-valuenow="<?= h($inscripcion->progreso) ?>" 
                                                     aria-valuemin="0" aria-valuemax="100">
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
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
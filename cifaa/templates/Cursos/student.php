<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Curso> $disponibles
 * @var array<\App\Model\Entity\Inscripcion> $matriculados
 * @var array<\App\Model\Entity\Inscripcion> $pendientes
 */

use Cake\Core\Configure;

// Configuración de WhatsApp
$whatsappAdmin = Configure::read('Cifa.whatsapp_admin', '51999999999');
?>

<div class="container mt-4 mb-5">
    
    <!-- HEADER -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-info border-bottom pb-2">
                <i class="fas fa-graduation-cap"></i> Panel de Estudiante
            </h2>
            <p class="text-muted">Gestiona tus cursos y explora nuevo contenido.</p>
        </div>
    </div>

    <!-- SECCIÓN 1: MIS CURSOS (MATRICULADOS) -->
    <?php if (!empty($matriculados)): ?>
        <div class="mb-5">
            <h4 class="text-primary mb-3"><i class="fas fa-book-open me-2"></i>Mis Cursos Activos</h4>
            <div class="row g-4">
                <?php foreach ($matriculados as $inscripcion): ?>
                    <?php $curso = $inscripcion->curso; ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card h-100 shadow-sm border-0 course-card">
                            <a href="<?= $this->Url->build(['action' => 'view', $curso->id]) ?>" class="text-decoration-none">
                                <div class="mb-3 position-relative">
                                    <?php if (!empty($curso->miniatura)): ?>
                                        <img src="<?= (strpos($curso->miniatura, 'http') === 0) ? $curso->miniatura : $this->Url->image($curso->miniatura) ?>"
                                             alt="<?= h($curso->titulo) ?>"
                                             class="img-fluid rounded-3 w-100"
                                             style="max-height: 200px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center"
                                             style="height: 320px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                            <i class="fas fa-image fa-4x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark mb-1"><?= h($curso->titulo) ?></h5>
                                <div class="mb-3">
                                    <small class="text-muted">Progreso: <?= $inscripcion->progreso ?>%</small>
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $inscripcion->progreso ?>%"></div>
                                    </div>
                                </div>
                                <div class="mt-auto d-grid">
                                    <?= $this->Html->link(
                                        '<i class="fas fa-play-circle me-1"></i> Continuar',
                                        ['action' => 'view', $curso->id],
                                        ['class' => 'btn btn-primary rounded-pill', 'escape' => false]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- SECCIÓN 2: SOLICITUDES PENDIENTES -->
    <?php if (!empty($pendientes)): ?>
        <div class="mb-5">
            <h4 class="text-warning mb-3"><i class="fas fa-clock me-2"></i>Solicitudes Pendientes</h4>
            <div class="row g-4">
                <?php foreach ($pendientes as $inscripcion): ?>
                    <?php $curso = $inscripcion->curso; ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card h-100 shadow-sm border-warning course-card">
                            <div class="mb-3 position-relative">
                                <?php if (!empty($curso->miniatura)): ?>
                                    <img src="<?= (strpos($curso->miniatura, 'http') === 0) ? $curso->miniatura : $this->Url->image($curso->miniatura) ?>"
                                         alt="<?= h($curso->titulo) ?>"
                                         class="img-fluid rounded-3 w-100 opacity-75"
                                         style="max-height: 200px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                <?php else: ?>
                                    <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center"
                                         style="height: 200px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                        <i class="fas fa-image fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">
                                    Pendiente
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark"><?= h($curso->titulo) ?></h5>
                                <p class="small text-muted mb-3">Tu solicitud está siendo revisada.</p>
                                <div class="mt-auto d-grid">
                                    <a href="https://wa.me/<?= $whatsappAdmin ?>?text=<?= urlencode("Hola, mi solicitud para el curso '{$curso->titulo}' sigue pendiente.") ?>" 
                                       target="_blank" 
                                       class="btn btn-outline-warning rounded-pill">
                                        <i class="fab fa-whatsapp me-1"></i> Consultar Estado
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- SECCIÓN 3: EXPLORAR CURSOS (DISPONIBLES) -->
    <div class="mb-5">
        <h4 class="text-info mb-3"><i class="fas fa-search me-2"></i>Explorar Cursos Disponibles</h4>
        
        <?php if ($disponibles->isEmpty()): ?>
            <div class="alert alert-light text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <p class="mb-0">No hay nuevos cursos disponibles en este momento.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($disponibles as $curso): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card h-100 shadow-sm border-0 course-card">
                            <a href="<?= $this->Url->build(['action' => 'view', $curso->id]) ?>" class="text-decoration-none">
                                <div class="mb-3 position-relative">
                                    <?php if (!empty($curso->miniatura)): ?>
                                        <img src="<?= (strpos($curso->miniatura, 'http') === 0) ? $curso->miniatura : $this->Url->image($curso->miniatura) ?>"
                                             alt="<?= h($curso->titulo) ?>"
                                             class="img-fluid rounded-3 w-100"
                                             style="max-height: 200px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center"
                                             style="height: 200px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                            <i class="fas fa-image fa-4x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="badge bg-dark position-absolute top-0 end-0 m-2 opacity-75">
                                        <?= ucfirst(h($curso->nivel)) ?>
                                    </span>
                                </div>
                            </a>

                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-light text-primary border border-primary text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
                                        <?= h($curso->categoria) ?>
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold">
                                    <?= $this->Html->link(h($curso->titulo), ['action' => 'view', $curso->id], ['class' => 'text-dark text-decoration-none stretched-link-custom']) ?>
                                </h5>
                                <?php if ($curso->hasValue('user')): ?>
                                    <p class="small text-muted mb-2">Por <span class="fw-semibold"><?= h($curso->user->username) ?></span></p>
                                <?php endif; ?>
                                
                                <div class="mt-auto pt-3 border-top d-grid">
                                    <?= $this->Form->postLink(
                                        'Solicitar Inscripción',
                                        ['action' => 'solicitar', $curso->id],
                                        [
                                            'confirm' => '¿Deseas solicitar inscripción a "' . h($curso->titulo) . '"?',
                                            'class' => 'btn btn-outline-success rounded-pill fw-bold'
                                        ]
                                    ) ?>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white border-0 text-muted small pt-0 pb-3">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-clock me-1"></i><?= h($curso->duracion ?? 'N/A') ?></span>
                                    <span><i class="fas fa-layer-group me-1"></i><?= isset($curso->modulos) ? count($curso->modulos) : 0 ?> Módulos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- PAGINACIÓN -->
            <div class="row mt-4">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                            <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        border-radius: 12px;
    }
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
    }
    .course-img {
        height: 180px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }
    .course-card:hover .course-img {
        transform: scale(1.05);
    }
    .card-title a {
        color: #333;
        transition: color 0.2s;
    }
    .course-card:hover .card-title a {
        color: #0dcaf0;
    }
</style>

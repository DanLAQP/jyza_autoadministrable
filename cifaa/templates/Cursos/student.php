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
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-light"><i class="fas fa-graduation-cap"></i> Panel de Estudiante</h2>
            <p class="text-light" style="opacity: 0.8;">Gestiona tus cursos y explora nuevo contenido.</p>
        </div>
    </div>

    <!-- SECCIÓN 1: MIS CURSOS (MATRICULADOS) -->
    <?php if (!empty($matriculados)): ?>
        <div class="mb-5">
            <h4 class="text-light mb-3"><i class="fas fa-book-open me-2"></i>Mis Cursos Activos</h4>
            <div class="row g-3">
                <?php foreach ($matriculados as $inscripcion): ?>
                    <?php $curso = $inscripcion->curso; ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100 shadow-sm border-0 hover-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                            <a href="<?= $this->Url->build(['action' => 'view', $curso->id]) ?>" class="text-decoration-none">
                                <?php if (!empty($curso->miniatura)): ?>
                                    <img src="<?= $this->Url->assetUrl($curso->miniatura) ?>" class="card-img-top" alt="<?= h($curso->titulo) ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="card-body d-flex flex-column p-1">
                                <h6 class="card-title text-info" style="margin-bottom: 4px; font-size: 0.95rem;">
                                    <?= h($curso->titulo) ?>
                                </h6>
                                <div class="mb-2">
                                    <small class="text-muted">Progreso: <?= $inscripcion->progreso ?>%</small>
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $inscripcion->progreso ?>%"></div>
                                    </div>
                                </div>
                                <div class="mt-auto d-grid">
                                    <?= $this->Html->link(
                                        '<i class="fas fa-play-circle"></i> Continuar',
                                        ['action' => 'view', $curso->id],
                                        ['class' => 'btn btn-sm btn-primary', 'style' => 'padding: 3px 5px; font-size: 0.8rem;', 'escape' => false]
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
            <h4 class="text-light mb-3"><i class="fas fa-clock me-2"></i>Solicitudes Pendientes</h4>
            <div class="row g-3">
                <?php foreach ($pendientes as $inscripcion): ?>
                    <?php $curso = $inscripcion->curso; ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100 shadow-sm border-0 hover-card" style="transition: transform 0.3s, box-shadow 0.3s; border: 2px solid #ffc107 !important;">
                            <div class="position-relative">
                                <?php if (!empty($curso->miniatura)): ?>
                                    <img src="<?= $this->Url->assetUrl($curso->miniatura) ?>" class="card-img-top opacity-75" alt="<?= h($curso->titulo) ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center opacity-75">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">
                                    Pendiente
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column p-1">
                                <h6 class="card-title text-light" style="margin-bottom: 4px; font-size: 0.95rem;">
                                    <?= h($curso->titulo) ?>
                                </h6>
                                <p class="small text-muted mb-2" style="font-size: 0.75rem;">Tu solicitud está siendo revisada.</p>
                                <div class="mt-auto d-grid">
                                    <a href="https://wa.me/<?= $whatsappAdmin ?>?text=<?= urlencode("Hola, mi solicitud para el curso '{$curso->titulo}' sigue pendiente.") ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-warning"
                                       style="padding: 3px 5px; font-size: 0.8rem;">
                                        <i class="fab fa-whatsapp"></i> Consultar
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
        <h4 class="text-light mb-3"><i class="fas fa-search me-2"></i>Explorar Cursos Disponibles</h4>

        <!-- Buscador estándar -->
        <div class="card shadow-sm mb-4" style="background-color: #0f3460; border: none;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'd-flex']) ?>
                        <div class="input-group">
                            <input type="text" name="termino" id="termino-busqueda" class="form-control" 
                                   placeholder="🔍 Buscar curso por título..." 
                                   value="<?= h($this->request->getQuery('termino')) ?>"
                                   style="background-color: #1a3a52; color: #ffffff; border: 1px solid #5dade2;">
                            <button type="submit" class="btn btn-primary" style="border: 1px solid #5dade2;">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <?php if (!empty($this->request->getQuery('termino'))): ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-times"></i>',
                                    ['action' => 'student'],
                                    ['class' => 'btn btn-secondary', 'escape' => false, 'title' => 'Limpiar']
                                ) ?>
                            <?php endif; ?>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($disponibles->items()->isEmpty()): ?>
            <div class="alert text-center" style="background-color: #0f3460; color: #5dade2; border-color: #5dade2; border: 1px solid;">
                <i class="fas fa-box-open fa-3x mb-3"></i>
                <p class="mb-0">No hay nuevos cursos disponibles en este momento.</p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($disponibles as $curso): ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100 shadow-sm border-0 hover-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                            <a href="<?= $this->Url->build(['action' => 'view', $curso->id]) ?>" class="text-decoration-none">
                                <?php if (!empty($curso->miniatura)): ?>
                                    <img src="<?= $this->Url->assetUrl($curso->miniatura) ?>" class="card-img-top" alt="<?= h($curso->titulo) ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </a>

                            <div class="card-body d-flex flex-column p-1">
                                <div class="mb-1">
                                    <span class="badge bg-light text-primary border border-primary text-uppercase" style="font-size: 0.65rem;">
                                        <?= h($curso->categoria) ?>
                                    </span>
                                </div>
                                <h6 class="card-title text-info" style="margin-bottom: 4px; font-size: 0.95rem;">
                                    <?= $this->Html->link(h($curso->titulo), ['action' => 'view', $curso->id], ['class' => 'text-info text-decoration-none']) ?>
                                </h6>
                                <?php if ($curso->hasValue('user')): ?>
                                    <p class="small text-muted mb-2" style="font-size: 0.75rem;">
                                        <i class="fas fa-user-tie"></i> 
                                        <?= $this->Html->link($curso->user->username, ['controller' => 'Users', 'action' => 'view', $curso->user->id], ['style' => 'color: #5dade2; text-decoration: none;']) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="mb-2">
                                    <div class="row g-1">
                                        <div class="col-6">
                                            <span class="badge w-100 text-center" style="background-color: #0f3460; color: #5dade2; border: 1px solid #5dade2; font-size: 0.65rem;">
                                                <i class="fas fa-graduation-cap"></i> <?= ucfirst(h($curso->nivel)) ?>
                                            </span>
                                        </div>
                                        <div class="col-6">
                                            <span class="badge w-100 text-center" style="background-color: #1a3a52; color: #5dade2; border: 1px solid #5dade2; font-size: 0.65rem;">
                                                <i class="fas fa-clock"></i> <?= h($curso->duracion ?? 'N/A') ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-auto d-grid">
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-plus"></i> Solicitar',
                                        ['action' => 'solicitar', $curso->id],
                                        [
                                            'confirm' => '¿Deseas solicitar inscripción a "' . h($curso->titulo) . '"?',
                                            'class' => 'btn btn-sm btn-outline-success',
                                            'style' => 'padding: 3px 5px; font-size: 0.8rem;',
                                            'escape' => false
                                        ]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- PAGINACIÓN -->
            <div class="mt-5">
                <nav aria-label="Paginación de cursos">
                    <ul class="pagination justify-content-center">
                        <?php
                        echo $this->Paginator->first(
                            '<i class="fas fa-angle-double-left"></i>',
                            ['escape' => false, 'class' => 'page-link', 'title' => 'Primera página']
                        );
                        echo $this->Paginator->prev(
                            '<i class="fas fa-chevron-left"></i> Anterior',
                            ['escape' => false, 'class' => 'page-link']
                        );
                        echo $this->Paginator->numbers([
                            'modulus' => 3,
                            'first' => 1,
                            'last' => 1
                        ]);
                        echo $this->Paginator->next(
                            'Siguiente <i class="fas fa-chevron-right"></i>',
                            ['escape' => false, 'class' => 'page-link']
                        );
                        echo $this->Paginator->last(
                            '<i class="fas fa-angle-double-right"></i>',
                            ['escape' => false, 'class' => 'page-link', 'title' => 'Última página']
                        );
                        ?>
                    </ul>
                </nav>
                <p class="text-center text-muted mt-2 small">
                    <i class="fas fa-info-circle"></i> 
                    <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} curso(s) de {{count}} totales') ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .card-img-top {
        border-radius: 8px 8px 0 0;
        width: 100%;
        aspect-ratio: 16 / 9;
        object-fit: contain;
        object-position: center;
        display: block;
        background-color: #0f3460;
        max-height: 180px;
    }
    
    .hover-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Estilos para el input de búsqueda */
    #termino-busqueda::placeholder {
        color: #8eb4d6;
        opacity: 1;
    }
    
    #termino-busqueda:focus {
        background-color: #1a3a52 !important;
        color: #ffffff;
        border-color: #5dade2 !important;
        box-shadow: 0 0 0 0.2rem rgba(93, 173, 226, 0.25);
    }
    
    #termino-busqueda {
        transition: all 0.3s ease;
    }

    /* Estilos de paginación mejorados */
    .pagination {
        gap: 5px;
    }
    
   
</style>

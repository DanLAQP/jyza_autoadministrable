<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Curso> $cursos
 */

use Cake\Core\Configure;

// Configuración de WhatsApp desde config/app.php
$whatsappAdmin = Configure::read('Cifa.whatsapp_admin', '51999999999');
?>

<div class="container mt-4 mb-4">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-info">
                <i class="fas fa-graduation-cap"></i> Catálogo de Cursos
            </h2>
            <p class="text-muted">Explora nuestros cursos disponibles y solicita tu inscripción</p>
        </div>
    </div>

    <!-- Botón para ver mis inscripciones -->
    <div class="row mb-3">
        <div class="col-12">
            <?= $this->Html->link(
                '<i class="fas fa-list-alt"></i> Ver Mis Inscripciones',
                ['controller' => 'Inscripciones', 'action' => 'misInscripciones'],
                ['class' => 'btn btn-outline-primary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Lista de cursos -->
    <?php if (empty($cursos->toArray())): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>No hay cursos disponibles en este momento</h4>
                    <p>Vuelve pronto para ver nuevos cursos.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- DEBUG: Mostrar cu\u00e1ntas inscripciones tiene el usuario -->
        <?php if (Configure::read('debug')): ?>
            <div class="alert alert-info">
                <strong>DEBUG:</strong> Inscripciones del usuario: <?= count($inscripcionesDelUsuario ?? []) ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <?php foreach ($cursos as $curso): ?>
                <?php
                // Buscar inscripci\u00f3n del usuario en este curso
                // Usando el array indexado por curso_id (acceso O(1))
                $inscripcion = $inscripcionesDelUsuario[$curso->id] ?? null;
                
                // DEBUG
                if (Configure::read('debug') && $inscripcion) {
                    echo "<!-- DEBUG: Curso {$curso->id} tiene inscripci\u00f3n ID {$inscripcion->id} con estado {$inscripcion->estado} -->";
                }
                ?>
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 curso-card shadow-sm">
                        <!-- Header del curso -->
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-book"></i> 
                                <?= h($curso->titulo) ?>
                            </h5>
                        </div>
                        
                        <!-- Cuerpo de la tarjeta -->
                        <div class="card-body">
                            <!-- Descripción -->
                            <p class="card-text text-muted mb-3">
                                <?= $this->Text->truncate(
                                    h($curso->descripcion),
                                    120,
                                    ['ellipsis' => '...', 'exact' => false]
                                ) ?>
                            </p>
                            
                            <!-- Información del curso -->
                            <div class="mb-3">
                                <?php if ($curso->duracion): ?>
                                    <p class="small mb-1">
                                        <i class="fas fa-clock text-primary"></i> 
                                        <strong>Duración:</strong> <?= h($curso->duracion) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (!empty($curso->modulos)): ?>
                                    <p class="small mb-1">
                                        <i class="fas fa-layer-group text-primary"></i> 
                                        <strong>Módulos:</strong> <?= count($curso->modulos) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ($curso->has('user')): ?>
                                    <p class="small mb-1">
                                        <i class="fas fa-user-tie text-primary"></i> 
                                        <strong>Instructor:</strong> <?= h($curso->user->username) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Estado de inscripción -->
                            <?php if ($inscripcion): ?>
                                <?php if ($inscripcion->estado === 'pendiente'): ?>
                                    <div class="alert alert-warning mb-2">
                                        <i class="fas fa-clock"></i> 
                                        <strong>Solicitud Pendiente</strong>
                                        <p class="mb-0 small">Tu inscripción está siendo revisada.</p>
                                    </div>
                                    
                                <?php elseif ($inscripcion->estado === 'aprobada'): ?>
                                    <div class="alert alert-success mb-2">
                                        <i class="fas fa-check-circle"></i> 
                                        <strong>¡Inscrito!</strong>
                                    </div>
                                    
                                    <!-- Barra de progreso -->
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="small"><strong>Tu progreso</strong></span>
                                            <span class="small text-primary"><strong><?= $inscripcion->progreso ?>%</strong></span>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success progress-bar-striped <?= $inscripcion->progreso < 100 ? 'progress-bar-animated' : '' ?>" 
                                                 style="width: <?= $inscripcion->progreso ?>%">
                                                <?= $inscripcion->progreso ?>%
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php else: ?>
                                    <div class="alert alert-danger mb-2">
                                        <i class="fas fa-times-circle"></i> 
                                        <strong>Solicitud Rechazada</strong>
                                        <p class="mb-0 small">Contacta al administrador.</p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Footer con botones de acción -->
                        <div class="card-footer bg-transparent">
                            <?php if (!$inscripcion): ?>
                                <!-- SIN INSCRIPCIÓN: Botón para solicitar -->
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-paper-plane"></i> Solicitar Inscripción',
                                    ['action' => 'solicitar', $curso->id],
                                    [
                                        'confirm' => '¿Deseas solicitar inscripción al curso "' . h($curso->titulo) . '"?',
                                        'class' => 'btn btn-success w-100 mb-2',
                                        'escape' => false
                                    ]
                                ) ?>
                                
                                <?= $this->Html->link(
                                    '<i class="fas fa-info-circle"></i> Ver Detalles',
                                    ['action' => 'view', $curso->id],
                                    ['class' => 'btn btn-outline-info btn-sm w-100', 'escape' => false]
                                ) ?>
                                
                            <?php elseif ($inscripcion->estado === 'pendiente'): ?>
                                <!-- PENDIENTE: Botón deshabilitado + WhatsApp -->
                                <button class="btn btn-warning w-100 mb-2" disabled>
                                    <i class="fas fa-hourglass-half"></i> Solicitud Pendiente
                                </button>
                                
                                <a href="https://wa.me/<?= $whatsappAdmin ?>?text=<?= urlencode("Hola, solicité inscripción al curso '{$curso->titulo}'. ¿Podrían revisarla?") ?>" 
                                   target="_blank" 
                                   class="btn btn-outline-success btn-sm w-100 mb-2">
                                    <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                                </a>
                                
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i> Ver Detalles',
                                    ['action' => 'view', $curso->id],
                                    ['class' => 'btn btn-outline-info btn-sm w-100', 'escape' => false]
                                ) ?>
                                
                            <?php elseif ($inscripcion->estado === 'aprobada'): ?>
                                <!-- APROBADA: Botón para continuar -->
                                <?= $this->Html->link(
                                    '<i class="fas fa-play-circle"></i> Continuar Curso',
                                    ['action' => 'view', $curso->id],
                                    ['class' => 'btn btn-primary w-100 mb-2', 'escape' => false]
                                ) ?>
                                
                                <?= $this->Html->link(
                                    '<i class="fas fa-list"></i> Mis Inscripciones',
                                    ['controller' => 'Inscripciones', 'action' => 'misInscripciones'],
                                    ['class' => 'btn btn-outline-secondary btn-sm w-100', 'escape' => false]
                                ) ?>
                                
                            <?php else: ?>
                                <!-- RECHAZADA: Botón deshabilitado + WhatsApp -->
                                <button class="btn btn-danger w-100 mb-2" disabled>
                                    <i class="fas fa-ban"></i> Solicitud Rechazada
                                </button>
                                
                                <a href="https://wa.me/<?= $whatsappAdmin ?>?text=<?= urlencode("Hola, mi solicitud al curso '{$curso->titulo}' fue rechazada. ¿Podrían explicarme el motivo?") ?>" 
                                   target="_blank" 
                                   class="btn btn-outline-success btn-sm w-100">
                                    <i class="fab fa-whatsapp"></i> Contactar al Administrador
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Paginación de cursos">
                    <ul class="pagination justify-content-center">
                        <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                    </ul>
                </nav>
                <p class="text-center text-muted small">
                    <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} de {{count}} cursos') ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.curso-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: none;
}

.curso-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

.card-header {
    border-bottom: none;
}

.card-footer {
    border-top: 1px solid rgba(0,0,0,.125);
    padding: 1rem;
}

.progress {
    border-radius: 0.5rem;
    background-color: #e9ecef;
}

.alert {
    border-left: 4px solid;
    font-size: 0.875rem;
}

.alert-warning {
    border-left-color: #ffc107;
}

.alert-success {
    border-left-color: #28a745;
}

.alert-danger {
    border-left-color: #dc3545;
}

.btn i {
    margin-right: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}
</style>

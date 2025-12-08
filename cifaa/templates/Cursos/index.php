<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Curso> $cursos
 */
?>

<div class="container mt-4 mb-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-info"><i class="fas fa-book"></i> Catálogo de Cursos</h2>
                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-plus"></i> Nuevo Curso',
                        ['action' => 'add'],
                        ['class' => 'btn btn-info', 'escape' => false]
                    ) ?>
                <?php endif; ?>
            </div>
            <p class="text-muted">Explora y únete a los cursos disponibles</p>
        </div>
    </div>

    <!-- Lista de Cursos en Cards -->
    <div class="row g-4">
        <?php if (empty($cursos)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No hay cursos disponibles en este momento.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($cursos as $curso): ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow-sm border-0 hover-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                        <!-- Miniatura -->
                        <?php if (!empty($curso->miniatura)): ?>
                            <img src="<?= $curso->miniatura ?>" class="card-img-top" alt="<?= h($curso->titulo) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <!-- Título -->
                            <h5 class="card-title text-info"><?= h($curso->titulo) ?></h5>

                            <!-- Instructor -->
                            <?php if ($curso->hasValue('user')): ?>
                                <p class="card-text small text-muted mb-2">
                                    <i class="fas fa-user-tie"></i> 
                                    <?= $this->Html->link($curso->user->username, ['controller' => 'Users', 'action' => 'view', $curso->user->id]) ?>
                                </p>
                            <?php endif; ?>

                            <!-- Descripción -->
                            <p class="card-text text-muted flex-grow-1" style="font-size: 0.95rem;">
                                <?= substr(h($curso->descripcion), 0, 100) ?>...
                            </p>

                            <!-- Metadata -->
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <span class="badge bg-secondary" style="width: 100%; text-align: center;">
                                            <i class="fas fa-graduation-cap"></i> <?= ucfirst(h($curso->nivel)) ?>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <span class="badge bg-primary" style="width: 100%; text-align: center;">
                                            <i class="fas fa-tag"></i> <?= h($curso->categoria) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado -->
                            <?php
                                $estadoClass = $curso->estado === 'activo' ? 'success' : 'danger';
                                $estadoIcon = $curso->estado === 'activo' ? 'check-circle' : 'times-circle';
                            ?>
                            <p class="text-sm mb-3">
                                <span class="badge bg-<?= $estadoClass ?>">
                                    <i class="fas fa-<?= $estadoIcon ?>"></i> <?= ucfirst(h($curso->estado)) ?>
                                </span>
                            </p>

                            <!-- Botones de Acción -->
                            <div class="btn-group w-100" role="group">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $curso->id],
                                    ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Ver', 'escape' => false]
                                ) ?>
                                <?php if (!empty($usuario) && $usuario->rol == 1): ?>
                                    <?= $this->Html->link(
                                        '<i class="fas fa-edit"></i>',
                                        ['action' => 'edit', $curso->id],
                                        ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Editar', 'escape' => false]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fas fa-trash"></i>',
                                        ['action' => 'delete', $curso->id],
                                        [
                                            'confirm' => '¿Estás seguro de que deseas eliminar este curso?',
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'title' => 'Eliminar',
                                            'escape' => false
                                        ]
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-white border-top small text-muted text-center">
                            Creado: <?= $curso->created->format('d/m/Y') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <?php if (!empty($cursos)): ?>
        <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i>', ['escape' => false]) ?>
                <?= $this->Paginator->prev('<i class="fas fa-chevron-left"></i>', ['escape' => false]) ?>
                <?= $this->Paginator->numbers(['separator' => '']) ?>
                <?= $this->Paginator->next('<i class="fas fa-chevron-right"></i>', ['escape' => false]) ?>
                <?= $this->Paginator->last('<i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i>', ['escape' => false]) ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- CSS personalizado para hover effect -->
<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }
    
    .card-img-top {
        border-radius: 8px 8px 0 0;
    }
    
    .btn-group {
        gap: 5px;
    }
    
    .btn-group .btn {
        flex: 1;
    }
</style>
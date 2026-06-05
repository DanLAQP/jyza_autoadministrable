<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContentSection> $contentSections
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-info mb-1"><i class="fas fa-sliders-h"></i> Panel Autoadministrable</h2>
            <p class="text-muted">Gestiona las secciones y bloques de contenido.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Secciones</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($contentSections)): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle"></i> <strong>Sin datos</strong> 
                            No hay secciones registradas. Puedes crear entradas en la tabla <strong>content_sections</strong>.
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-dark align-middle table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="60">ID</th>
                                        <th>Slug</th>
                                        <th>Título</th>
                                        <th width="120" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contentSections as $s): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?= h($s->id) ?></span>
                                            </td>
                                            <td>
                                                <code class="text-info"><?= h($s->slug) ?></code>
                                            </td>
                                            <td>
                                                <strong class="text-white"><?= h($s->title) ?></strong>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?= $this->Html->link(
                                                        '<i class="fas fa-edit"></i>',
                                                        ['controller' => 'Content', 'action' => 'edit', $s->id],
                                                        ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning']
                                                    ) ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos de tabla para tema oscuro */
    .table-dark {
        --bs-table-color: #ffffff;
        --bs-table-bg: #1a1a1a;
        --bs-table-border-color: #2d2d2d;
    }
    
    .table-dark tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.08);
        transition: background-color 0.2s ease;
    }
    
    /* Code styling */
    code {
        padding: 0.25rem 0.5rem;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    /* Badge styling */
    .badge {
        font-weight: 500;
        padding: 0.35rem 0.65rem;
    }
    
    /* Botones en grupo */
    .btn-group-sm .btn {
        transition: all 0.2s ease;
    }
    
    .btn-group-sm .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    
    .btn-group-sm .btn:active {
        transform: translateY(0);
    }
    
    /* Card styling */
    .card {
        transition: box-shadow 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3) !important;
    }
    
    /* Table responsive */
    .table-responsive {
        border-radius: 0.5rem;
    }
    
    /* Alert styling */
    .alert {
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
</style>
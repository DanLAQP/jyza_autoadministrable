<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Certificado> $certificados
 * @var string $searchTerm
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0"><i class="fas fa-certificate"></i> Certificados</h2>
            <?php if (!isset($identity) || $identity->rol != 3): ?>
                <?= $this->Html->link(__('Nuevo Certificado'), ['action' => 'add'], ['class' => 'btn btn-info']) ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="card shadow-sm mb-4 bg-dark border-primary">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Search bar -->
                <div class="col-md-6 mb-3 mb-md-0">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'd-flex']) ?>
                    <div class="input-group">
                        <input type="text" name="termino" class="form-control" 
                               placeholder="Buscar por código, titular, DNI, usuario, nombre o curso..." 
                               value="<?= h($this->request->getQuery('termino')) ?>"
                               style="background-color: #1a3a52; color: #ffffff; border: 1px solid #0d6efd;">
                        <input type="hidden" name="tipo" value="<?= h($this->request->getQuery('tipo')) ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <?php if (!empty($this->request->getQuery('termino'))): ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-times"></i>',
                                ['action' => 'index', '?' => ['tipo' => $this->request->getQuery('tipo')]],
                                ['class' => 'btn btn-secondary', 'escape' => false, 'title' => 'Limpiar búsqueda']
                            ) ?>
                        <?php endif; ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <!-- Filter by type -->
                <div class="col-md-6">
                    <div class="btn-group float-end" role="group" aria-label="Filtro por tipo">
                        <?= $this->Html->link(
                            '<i class="fas fa-award"></i> Certificados',
                            ['action' => 'index', '?' => ['tipo' => 'certificado']],
                            [
                                'class' => 'btn ' . ($this->request->getQuery('tipo') === 'certificado' ? 'btn-success' : 'btn-outline-success'),
                                'escape' => false,
                                'title' => 'Ver solo certificados'
                            ]
                        ) ?>

                        <?= $this->Html->link(
                            '<i class="fas fa-medal"></i> Diplomados',
                            ['action' => 'index', '?' => ['tipo' => 'diplomado']],
                            [
                                'class' => 'btn ' . ($this->request->getQuery('tipo') === 'diplomado' ? 'btn-info' : 'btn-outline-info'),
                                'escape' => false,
                                'title' => 'Ver solo diplomados'
                            ]
                        ) ?>

                        <?= $this->Html->link(
                            '<i class="fas fa-list"></i> Todos',
                            ['action' => 'index'],
                            [
                                'class' => 'btn ' . (empty($this->request->getQuery('tipo')) ? 'btn-secondary' : 'btn-outline-secondary'),
                                'escape' => false,
                                'title' => 'Ver todos los certificados'
                            ]
                        ) ?>
                    </div>
                </div>
            </div>

            <!-- Active filter indicator -->
            <!-- <?php if (!empty($this->request->getQuery('tipo'))): ?>
                <div class="alert alert-primary mt-3" style="background-color: #0d6efd; color: #ffffff;">
                    <i class="fas fa-info-circle"></i>
                    Mostrando: <strong><?= ucfirst($this->request->getQuery('tipo')) ?></strong>
                </div>
            <?php endif; ?> -->
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Listado de Certificados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark table-sticky-actions">
                            <thead class="table-dark">
                                <tr>
                                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                                    <th><?= $this->Paginator->sort('codigo', 'Código') ?></th>
                                    <th><?= $this->Paginator->sort('tipo', 'Tipo') ?></th>
                                    <th><?= $this->Paginator->sort('usuario_id', 'Usuario') ?></th>
                                    <th><?= $this->Paginator->sort('nombre_titular', 'Titular') ?></th>
                                    <th><?= $this->Paginator->sort('dni_titular', 'DNI') ?></th>
                                    <th><?= $this->Paginator->sort('curso_id', 'Curso') ?></th>
                                    <th><?= $this->Paginator->sort('nota_final', 'Nota') ?></th>
                                    <th><?= $this->Paginator->sort('fecha_inicio', 'Inicio') ?></th>
                                    <th><?= $this->Paginator->sort('fecha_fin', 'Fin') ?></th>
                                    <th class="text-center sticky-col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($certificados as $certificado): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary"><?= $this->Number->format($certificado->id) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-barcode"></i> <?= h($certificado->codigo) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($certificado->tipo === 'certificado'): ?>
                                            <span class="badge bg-info"><i class="fas fa-award"></i>Certificado</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><i class="fas fa-medal"></i>Diplomado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->user): ?>
                                            <i class="fas fa-user"></i> <?= h($certificado->user->username) ?><br>
                                            <small class="text-muted"><?= h($certificado->user->nombres ?? '') ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->nombre_titular): ?>
                                            <strong><?= h($certificado->nombre_titular) ?></strong>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->dni_titular): ?>
                                            <span class="badge bg-secondary"><?= h($certificado->dni_titular) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->curso): ?>
                                            <?= h($certificado->curso->titulo) ?>
                                        <?php elseif ($certificado->nombre_curso_manual): ?>
                                            <em><?= h($certificado->nombre_curso_manual) ?></em>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->nota_final !== null): ?>
                                            <strong><?= number_format($certificado->nota_final, 2) ?></strong>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->fecha_inicio): ?>
                                            <?= h(date('d/m/Y', strtotime($certificado->fecha_inicio))) ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($certificado->fecha_fin): ?>
                                            <?= h(date('d/m/Y', strtotime($certificado->fecha_fin))) ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center sticky-col sticky-actions">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?php if (!isset($identity) || $identity->rol != 3): ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-eye"></i>',
                                                    ['action' => 'view', $certificado->id],
                                                    ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info']
                                                ) ?>
                                            <?php endif; ?>
                                            <?php if ($certificado->archivo_ruta): ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-download"></i>',
                                                    ['action' => 'downloadFile', $certificado->id],
                                                    ['escape' => false, 'title' => 'Descargar archivo', 'class' => 'btn btn-success']
                                                ) ?>
                                            <?php else: ?>
                                                <button class="btn btn-success disabled" title="Sin archivo subido" disabled>
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <!-- <?= $this->Html->link(
                                                '<i class="fas fa-print"></i>',
                                                ['action' => 'exportPdf', $certificado->id],
                                                ['escape' => false, 'title' => 'Descargar PDF', 'class' => 'btn btn-success', 'target' => '_blank']
                                            ) ?> -->
                                            
                                            <?php if (!isset($identity) || $identity->rol != 3): ?>
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-edit"></i>',
                                                    ['action' => 'edit', $certificado->id],
                                                    ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning']
                                                ) ?>
                                                
                                                <!-- <?= $this->Form->postLink(
                                                    '<i class="fas fa-trash"></i>',
                                                    ['action' => 'delete', $certificado->id],
                                                    [
                                                        'confirm' => '¿Está seguro de eliminar este certificado?',
                                                        'class' => 'btn btn-danger',
                                                        'escape' => false,
                                                        'title' => 'Eliminar'
                                                    ]
                                                ) ?> -->
                                            <?php endif; ?>
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

    <!-- Paginador -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <?= $this->Paginator->first('<i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i>', ['escape' => false, 'class' => 'page-link']) ?>
                    </li>
                    <li class="page-item">
                        <?= $this->Paginator->prev('<i class="fas fa-chevron-left"></i>', ['escape' => false, 'class' => 'page-link']) ?>
                    </li>
                    <li class="page-item">
                        <?= $this->Paginator->numbers(['separator' => '', 'currentClass' => 'active', 'modulus' => 5, 'class' => 'page-link']) ?>
                    </li>
                    <li class="page-item">
                        <?= $this->Paginator->next('<i class="fas fa-chevron-right"></i>', ['escape' => false, 'class' => 'page-link']) ?>
                    </li>
                    <li class="page-item">
                        <?= $this->Paginator->last('<i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i>', ['escape' => false, 'class' => 'page-link']) ?>
                    </li>
                </ul>
            </nav>
            <div class="text-center text-muted mt-2">
                <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} certificado(s) de {{count}} total')) ?>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky-col {
        position: sticky;
        right: 0;
        background-color: #1e1e2e;
        z-index: 10;
    }

    .sticky-actions {
        min-width: 150px;
    }

    .table-sticky-actions {
        margin-bottom: 0;
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .card {
        border-radius: 8px;
    }

    .card-header {
        border-radius: 8px 8px 0 0 !important;
    }

    input[name="termino"]::placeholder {
        color: #8eb4d6 !important;
        opacity: 1;
    }
</style>
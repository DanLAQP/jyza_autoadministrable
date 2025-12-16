<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Certificado> $certificados
 * @var bool $esDiplomado Variable para saber si estamos listando diplomados
 */
$tipoDocumento = isset($esDiplomado) && $esDiplomado ? 'Diplomados' : 'Certificados';
$iconoTipo = isset($esDiplomado) && $esDiplomado ? 'medal' : 'certificate';
$colorTipo = isset($esDiplomado) && $esDiplomado ? 'warning' : 'info';
$accionGenerar = isset($esDiplomado) && $esDiplomado ? 'generarDiplomado' : 'generar';
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="text-<?= $colorTipo ?> d-inline-block">
                <i class="fas fa-<?= $iconoTipo ?>"></i> Gestión de <?= $tipoDocumento ?>
            </h2>
            <p class="text-muted">Administra los <?= strtolower($tipoDocumento) ?> emitidos a los estudiantes</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="btn-group" role="group">
                <?= $this->Html->link(
                    '<i class="fas fa-certificate"></i> Ver Certificados',
                    ['action' => 'index'],
                    ['class' => 'btn btn-outline-info' . (!isset($esDiplomado) || !$esDiplomado ? ' active' : ''), 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-medal"></i> Ver Diplomados',
                    ['action' => 'diplomados'],
                    ['class' => 'btn btn-outline-warning' . (isset($esDiplomado) && $esDiplomado ? ' active' : ''), 'escape' => false]
                ) ?>
            </div>
            <div class="btn-group ms-2" role="group">
                <?= $this->Html->link(
                    '<i class="fas fa-plus-circle"></i> Generar Certificado',
                    ['action' => 'generar'],
                    ['class' => 'btn btn-info', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-plus-square"></i> Generar Diplomado',
                    ['action' => 'generarDiplomado'],
                    ['class' => 'btn btn-warning', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- Buscador estándar -->
    <div class="row mb-4">
        <div class="col-md-8">
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="input-group">
                <?= $this->Form->control('termino', [
                    'label' => false, 
                    'placeholder' => 'Buscar por nombre, curso o código...',
                    'class' => 'form-control',
                    'value' => $this->request->getQuery('termino'),
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ]
                ]) ?>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
                <?php if (!empty($this->request->getQuery('termino'))): ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-times"></i>', 
                        ['action' => isset($esDiplomado) && $esDiplomado ? 'diplomados' : 'index'], 
                        ['class' => 'btn btn-secondary', 'escape' => false, 'title' => 'Limpiar búsqueda']
                    ) ?>
                <?php endif; ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <!-- Tabla de certificados -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;"><?= $this->Paginator->sort('id', '#') ?></th>
                            <th style="width: 20%;"><i class="fas fa-user-graduate"></i> <?= $this->Paginator->sort('user_id', 'Alumno') ?></th>
                            <th style="width: 25%;"><i class="fas fa-book"></i> <?= $this->Paginator->sort('curso_id', 'Curso') ?></th>
                            <th style="width: 10%;"><i class="fas fa-clock"></i> <?= $this->Paginator->sort('horas', 'Horas') ?></th>
                            <th style="width: 12%;"><i class="fas fa-calendar"></i> <?= $this->Paginator->sort('fecha_emision', 'Fecha') ?></th>
                            <th style="width: 18%;"><i class="fas fa-barcode"></i> <?= $this->Paginator->sort('codigo', 'Código') ?></th>
                            <th style="width: 10%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($certificados->toArray())): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No hay certificados generados aún</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($certificados as $certificado): ?>
                            <tr>
                                <td class="text-muted"><?= $this->Number->format($certificado->id) ?></td>
                                <td>
                                    <i class="fas fa-user-circle text-primary me-1"></i>
                                    <strong>
                                        <?php 
                                        if (!empty($certificado->nombre_completo)) {
                                            echo h($certificado->nombre_completo);
                                        } elseif ($certificado->has('user')) {
                                            echo h($certificado->user->username);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </strong>
                                    <?php if ($certificado->has('user') && $certificado->user->dni): ?>
                                        <br><small class="text-muted">DNI: <?= h($certificado->user->dni) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <i class="fas fa-graduation-cap text-info me-1"></i>
                                    <?php 
                                    if (!empty($certificado->nombre_curso)) {
                                        echo h($certificado->nombre_curso);
                                    } elseif ($certificado->has('curso')) {
                                        echo h($certificado->curso->titulo);
                                    } else {
                                        echo '<span class="text-muted">N/A</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= $this->Number->format($certificado->horas) ?> hrs
                                    </span>
                                </td>
                                <td><?= h($certificado->fecha_emision->format('d/m/Y')) ?></td>
                                <td>
                                    <code class="text-warning"><?= h($certificado->codigo) ?></code>
                                    <?php
                                    // Badge para identificar el tipo de documento
                                    $esCertificado = strpos($certificado->codigo, 'CER-') === 0;
                                    $esDiploma = strpos($certificado->codigo, 'DIP-') === 0;
                                    ?>
                                    <?php if ($esCertificado): ?>
                                        <br><span class="badge bg-info mt-1" style="font-size: 0.7em;"><i class="fas fa-certificate"></i> Certificado</span>
                                    <?php elseif ($esDiploma): ?>
                                        <br><span class="badge bg-warning mt-1" style="font-size: 0.7em;"><i class="fas fa-medal"></i> Diplomado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <?= $this->Html->link(
                                            '<i class="fas fa-download"></i>',
                                            ['action' => 'descargar', $certificado->id],
                                            [
                                                'escape' => false,
                                                'class' => 'btn btn-sm btn-success',
                                                'title' => 'Descargar PDF',
                                                'data-bs-toggle' => 'tooltip'
                                            ]
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-trash"></i>',
                                            ['action' => 'delete', $certificado->id],
                                            [
                                                'confirm' => __('¿Estás seguro de eliminar el certificado {0}?', $certificado->codigo),
                                                'escape' => false,
                                                'class' => 'btn btn-sm btn-danger',
                                                'title' => 'Eliminar',
                                                'data-bs-toggle' => 'tooltip'
                                            ]
                                        ) ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    <?= $this->Paginator->counter('Mostrando {{start}} a {{end}} de {{count}} certificados') ?>
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                        <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
// Activar tooltips de Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

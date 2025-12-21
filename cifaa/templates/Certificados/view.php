<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0"><i class="fas fa-certificate"></i> Detalle del Certificado</h2>
            <div>
                <?= $this->Html->link('<i class="fas fa-arrow-left"></i> Regresar', ['action' => 'index'], ['class' => 'btn btn-secondary me-2', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="fas fa-print"></i> Imprimir', ['action' => 'exportPdf', $certificado->id], ['class' => 'btn btn-success', 'escape' => false, 'target' => '_blank']) ?>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-dark border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información del Certificado</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-dark">
                <tr>
                    <th>Usuario</th>
                    <td><?= $certificado->hasValue('user') ? $this->Html->link($certificado->user->username, ['controller' => 'Users', 'action' => 'view', $certificado->user->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th>Nombre del Titular</th>
                    <td><?= h($certificado->nombre_titular) ?></td>
                </tr>
                <tr>
                    <th>DNI del Titular</th>
                    <td><?= h($certificado->dni_titular) ?></td>
                </tr>
                <tr>
                    <th>Curso</th>
                    <td><?= $certificado->hasValue('curso') ? $this->Html->link($certificado->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $certificado->curso->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th>Tipo</th>
                    <td><?= h($certificado->tipo) ?></td>
                </tr>
                <tr>
                    <th>Nota Final</th>
                    <td><?= $certificado->nota_final !== null ? number_format($certificado->nota_final, 2) : '-' ?></td>
                </tr>
                <tr>
                    <th>Fecha de Inicio</th>
                    <td><?= h(date('d/m/Y', strtotime($certificado->fecha_inicio))) ?></td>
                </tr>
                <tr>
                    <th>Fecha de Fin</th>
                    <td><?= h(date('d/m/Y', strtotime($certificado->fecha_fin))) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if (!empty($certificado->certificado_modulos)): ?>
        <div class="card border-0 shadow-sm bg-dark border-primary mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-list"></i> Módulos Relacionados</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificado->certificado_modulos as $modulo): ?>
                            <tr>
                                <td><?= h($modulo->id) ?></td>
                                <td><?= h($modulo->titulo) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inscripcione> $inscripciones
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-info"><i class="fas fa-clipboard-list"></i> Solicitudes de Inscripción</h2>
            <p class="text-muted">Aprueba o rechaza las solicitudes de inscripción a los cursos</p>
        </div>
    </div>

    <!-- Filtros por estado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group" role="group">
                <?= $this->Html->link(
                    '<i class="fas fa-hourglass-half"></i> Pendientes',
                    ['action' => 'index', '?' => ['estado' => 'pendiente']],
                    ['class' => 'btn btn-outline-warning', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-check-circle"></i> Aprobadas',
                    ['action' => 'index', '?' => ['estado' => 'aprobada']],
                    ['class' => 'btn btn-outline-success', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-times-circle"></i> Rechazadas',
                    ['action' => 'index', '?' => ['estado' => 'rechazada']],
                    ['class' => 'btn btn-outline-danger', 'escape' => false]
                ) ?>
                <?= $this->Html->link(
                    '<i class="fas fa-list"></i> Todas',
                    ['action' => 'index'],
                    ['class' => 'btn btn-outline-secondary', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- Tabla de inscripciones -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th style="width: 25%;"><i class="fas fa-user"></i> Usuario</th>
                            <th style="width: 25%;"><i class="fas fa-book"></i> Curso</th>
                            <th style="width: 15%;"><i class="fas fa-info-circle"></i> Estado</th>
                            <th style="width: 10%;"><i class="fas fa-calendar"></i> Fecha</th>
                            <th style="width: 15%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($inscripciones)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox"></i> No hay solicitudes de inscripción
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($inscripciones as $inscripcione): ?>
                            <?php if (empty($inscripcione)): ?>
                                <?php continue; ?>
                            <?php endif; ?>
                            <tr>
                                <td><?= $this->Number->format($inscripcione->id) ?></td>
                                <td>
                                    <?php if ($inscripcione && $inscripcione->hasValue('user')): ?>
                                        <i class="fas fa-user-circle"></i> 
                                        <?= $this->Html->link(
                                            h($inscripcione->user->username),
                                            ['controller' => 'Users', 'action' => 'view', $inscripcione->user->id],
                                            ['class' => 'text-info']
                                        ) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($inscripcione && $inscripcione->hasValue('curso')): ?>
                                        <i class="fas fa-book"></i> 
                                        <?= $this->Html->link(
                                            h($inscripcione->curso->titulo),
                                            ['controller' => 'Cursos', 'action' => 'view', $inscripcione->curso->id],
                                            ['class' => 'text-info']
                                        ) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $badgeClass = match($inscripcione->estado) {
                                            'pendiente' => 'bg-warning text-dark',
                                            'aprobada' => 'bg-success',
                                            'rechazada' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                        $iconClass = match($inscripcione->estado) {
                                            'pendiente' => 'fas fa-hourglass-half',
                                            'aprobada' => 'fas fa-check-circle',
                                            'rechazada' => 'fas fa-times-circle',
                                            default => 'fas fa-question-circle'
                                        };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <i class="<?= $iconClass ?>"></i>
                                        <?= ucfirst($inscripcione->estado) ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= $inscripcione->created->format('d/m/Y H:i') ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <?php if ($inscripcione->estado === 'pendiente'): ?>
                                        <!-- Botones de aprobación/rechazo para pendientes -->
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-check"></i> Aprobar',
                                            ['action' => 'aprobar', $inscripcione->id],
                                            [
                                                'class' => 'btn btn-sm btn-success',
                                                'escape' => false,
                                                'confirm' => '¿Aprobar esta inscripción?'
                                            ]
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-times"></i> Rechazar',
                                            ['action' => 'rechazar', $inscripcione->id],
                                            [
                                                'class' => 'btn btn-sm btn-danger',
                                                'escape' => false,
                                                'confirm' => '¿Rechazar esta inscripción?'
                                            ]
                                        ) ?>
                                    <?php else: ?>
                                        <!-- Vista solo para aprobadas/rechazadas -->
                                        <?= $this->Html->link(
                                            '<i class="fas fa-eye"></i> Ver',
                                            ['action' => 'view', $inscripcione->id],
                                            ['class' => 'btn btn-sm btn-info', 'escape' => false]
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-trash"></i> Eliminar',
                                            ['action' => 'delete', $inscripcione->id],
                                            [
                                                'class' => 'btn btn-sm btn-danger',
                                                'escape' => false,
                                                'confirm' => '¿Eliminar esta inscripción?'
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i> Primera', ['escape' => false, 'class' => 'page-link']) ?>
                    <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i> Anterior', ['escape' => false, 'class' => 'page-link']) ?>
                    <?= $this->Paginator->numbers(['class' => 'page-link']) ?>
                    <?= $this->Paginator->next('Siguiente <i class="fas fa-angle-right"></i>', ['escape' => false, 'class' => 'page-link']) ?>
                    <?= $this->Paginator->last('Última <i class="fas fa-angle-double-right"></i>', ['escape' => false, 'class' => 'page-link']) ?>
                </ul>
            </nav>
            <p class="text-center text-muted">
                <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} de {{count}} registros')) ?>
            </p>
        </div>
    </div>
</div>
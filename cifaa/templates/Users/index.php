<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 * @var string $searchTerm
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0"><i class="fas fa-users"></i> Usuarios</h2>
            <?= $this->Html->link(__('Añadir Usuario'), ['action' => 'add'], ['class' => 'btn btn-info openModal']) ?>
        </div>
    </div>
    <!-- Buscador -->
    <div class="mb-3">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3']) ?>
        <div class="col-auto">
            <?= $this->Form->control('dni', [
                'label' => false, 
                'placeholder' => 'Buscar por DNI',
                'class' => 'form-control',
                'value' => $this->request->getQuery('dni')
            ]) ?>
        </div>
        <div class="col-auto">
            <?= $this->Form->button(__('Buscar'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Limpiar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Todos los Usuarios</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-dark">
                            <thead class="table-secondary">
                                <tr>
                                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                                    <th><?= $this->Paginator->sort('username', 'Usuario') ?></th>
                                    <th><?= $this->Paginator->sort('dni', 'DNI') ?></th>
                                    <th><?= $this->Paginator->sort('rol', 'Rol') ?></th>
                                    <th><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                                    <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $this->Number->format($user->id) ?></td>
                                    <td><?= h($user->username) ?></td>
                                    <td><?= h($user->dni) ?></td>
                                    <td><?= $roles[$user->rol] ?? 'Desconocido' ?></td>
                                    <td>
                                        <?php if ($user->estado === 'activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($user->created) ?></td>
                                    <td><?= h($user->modified) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fas fa-eye"></i>',
                                                ['action' => 'view', $user->id],
                                                ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info openModal']
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fas fa-edit"></i>',
                                                ['action' => 'edit', $user->id],
                                                ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning openModal']
                                            ) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginación -->
                    <div class="mt-3">
                        <nav aria-label="Paginación">
                            <ul class="pagination justify-content-center">
                                <?php
                                echo $this->Paginator->first('<i class="fas fa-step-backward"></i> Primera', ['class' => 'page-link']);
                                echo $this->Paginator->prev('<i class="fas fa-chevron-left"></i> Anterior', ['class' => 'page-link']);
                                echo $this->Paginator->numbers(['class' => 'page-link']);
                                echo $this->Paginator->next('Siguiente <i class="fas fa-chevron-right"></i>', ['class' => 'page-link']);
                                echo $this->Paginator->last('Última <i class="fas fa-step-forward"></i>', ['class' => 'page-link']);
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')) ?></p>
    </div>
</div>

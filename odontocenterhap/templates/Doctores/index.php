<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Doctore> $doctores
 * @var string $searchTerm
 */
?>

<div class="contenedor principal">
    <div class="doctores index content">
        <!-- Formulario de búsqueda -->
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
        <div class="input-group">
            <?= $this->Form->control('search', [
                'label' => false,
                'placeholder' => 'Buscar por Nombre o Apellido',
                'value' => $searchTerm ?? '',
                'class' => 'form-control',
            ]) ?>
            <button class="btn btn-info mx-2" type="submit">Buscar</button>
        </div>
        <?= $this->Form->end() ?>
        <!-- Botón para añadir un nuevo doctor -->
        <?= $this->Html->link(__('Añadir Doctor'), ['action' => 'add'], ['class' => 'button float-right btn btn-info openModalMd']) ?>
        <!-- Tabla de doctores -->
       
        <div class="table-responsive">
            <?php if (empty($doctores)): ?>
                <p>No se encontraron resultados para "<?= h($searchTerm) ?>".</p>
            <?php else: ?>
                <table class="table table-striped mt-3">
                    <thead class="bg-info text-white">
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'N° de Doctor') ?></th>
                            <th><?= $this->Paginator->sort('nombre', 'Nombre') ?></th>
                            <th><?= $this->Paginator->sort('apellido', 'Apellido') ?></th>
                            <th><?= $this->Paginator->sort('especialidad', 'Especialidad') ?></th>
                            <th><?= $this->Paginator->sort('telefono', 'Teléfono') ?></th>
                            <th><?= $this->Paginator->sort('email', 'Correo Electrónico') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                            <th class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($doctores as $doctore): ?>
                        <tr>
                            <td><?= $this->Number->format($doctore->id) ?></td>
                            <td><?= h($doctore->nombre) ?></td>
                            <td><?= h($doctore->apellido) ?></td>
                            <td><?= h($doctore->especialidad) ?></td>
                            <td><?= h($doctore->telefono) ?></td>
                            <td><?= h($doctore->email) ?></td>
                            <td><?= h($doctore->created) ?></td>
                            <td><?= h($doctore->modified) ?></td>
                            <td class="actions text-center">
                                <!-- Íconos personalizados para acciones -->
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $doctore->id],
                                    ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $doctore->id],
                                    ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm openModal']
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Paginación -->
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('Primero')) ?>
                <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
                <?= $this->Paginator->last(__('Último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')) ?></p>
        </div>
    </div>
</div>

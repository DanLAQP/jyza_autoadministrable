<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Odontograma> $odontograma
 * @var string $searchTerm
 */
?>

<!-- Formulario de búsqueda -->
<?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
<div class="input-group">
    <?= $this->Form->control('search', [
        'label' => false,
        'placeholder' => 'Buscar por: Apellido/Nombre',
        'value' => $searchTerm ?? '',
        'class' => 'form-control',
    ]) ?>
    <button class="btn btn-info mx-2" type="submit">Buscar</button>
</div>
<?= $this->Form->end() ?>

<div class="odontogramas index content">
    <?= $this->Html->link(__('Añadir Odontograma'), ['action' => 'add'], ['class' => 'button float-right btn btn-info openModal' ]) ?>


    <div class="contenedor principal">
        <div class="table-responsive">
            <?php if ($odontograma->items()->isEmpty()): ?>
                <p>No se encontraron resultados para "<?= h($searchTerm) ?>".</p>
            <?php else: ?>
                <table class="table table-striped mt-3">
                    <thead class="bg-info text-white">
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'N° de Odontograma') ?></th>
                            <th><?= $this->Paginator->sort('paciente_id', 'Paciente') ?></th>
                            <th><?= $this->Paginator->sort('titulo', 'Titulo') ?></th>
                            <th><?= $this->Paginator->sort('created_at', 'Creado') ?></th>
                            <th><?= $this->Paginator->sort('updated_at', 'Actualizado') ?></th>
                            <th class="actions text-dark"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($odontograma as $item): ?>
                        <tr>
                            <td><?= $this->Number->format($item->id) ?></td>
                            <td>
                            <?= $item->hasValue('pacientes1') 
                                ? $this->Html->link(
                                    h($item->pacientes1->nombre . ' ' . $item->pacientes1->apellido),
                                    ['controller' => 'Pacientes', 'action' => 'view', $item->pacientes1->id],
                                    ['class' => 'text-white openModal']
                                )
                                : 'N/A'
                            ?>

                        </td>

                            </td>
                            <td><?= h($item->titulo) ?></td>
                            <td><?= h($item->created_at) ?></td>
                            <td><?= h($item->updated_at) ?></td>
                            <td class="actions text-center">
                                <!-- Íconos personalizados para acciones -->
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $item->id],
                                    ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModalXl']
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $item->id],
                                    ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm']
                                ) ?>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
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

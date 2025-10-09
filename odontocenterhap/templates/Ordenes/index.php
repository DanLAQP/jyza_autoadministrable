<?php
/**
 * @var \App\View\AppView            $this
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Ordene> $ordenes
 */
?>

<!-- Formulario de búsqueda -->
<!-- <?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3 me-3']) ?>
<div class="input-group">
    <?= $this->Form->control('search', [
        'label'       => false,
        'placeholder' => 'Buscar por: Paciente / Doctor',
        'value'       => $searchTerm ?? '',
        'class'       => 'form-control',
    ]) ?>
    <button class="btn btn-info mx-2" type="submit">Buscar</button>
</div>
<?= $this->Form->end() ?> -->

<div class="ordenes index content">
    <?= $this->Html->link(
        __('Añadir Orden'),
        ['action' => 'add'],
        ['class' => 'button float-right btn btn-info']
    ) ?>

    <div class="contenedor principal">
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead class="bg-info text-white">
                    <tr>
                        <th><?= $this->Paginator->sort('id',          'ID')            ?></th>
                        <th><?= $this->Paginator->sort('paciente_id', 'Paciente')      ?></th>
                        <th><?= $this->Paginator->sort('doctor_id',   'Doctor')        ?></th>
                        <th><?= $this->Paginator->sort('total',       'Total (S/)')    ?></th>
                        <th><?= $this->Paginator->sort('saldo',       'Saldo (S/)')    ?></th>
                        <th><?= $this->Paginator->sort('created',     'Creado')        ?></th>
                        <th class="actions text-dark"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordenes as $ordene): ?>
                        <tr>
                            <td><?= $this->Number->format($ordene->id) ?></td>

                            <td>
                                <?= $ordene->paciente_id !== null
                                    ? h($ordene->paciente_id)
                                    : '<em>Sin paciente</em>' ?>
                            </td>

                            <td>
                                <?= $ordene->doctor_id !== null
                                    ? h($ordene->doctor_id)
                                    : '<em>Sin doctor</em>' ?>
                            </td>

                            <td><?= $ordene->total  === null ? '' : $this->Number->format($ordene->total)  ?></td>
                            <td><?= $ordene->saldo  === null ? '' : $this->Number->format($ordene->saldo)  ?></td>
                            <td><?= h($ordene->created) ?></td>

                            <!-- Botones de acción -->
                            <td class="actions text-center">
                                <?= $this->Html->link(
                                    '<i class="fas fa-eye"></i>',
                                    ['action' => 'view', $ordene->id],
                                    ['escape' => false, 'title' => 'Ver',   'class' => 'btn btn-info btn-sm openModal']
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-edit"></i>',
                                    ['action' => 'edit', $ordene->id],
                                    ['escape' => false, 'title' => 'Editar','class' => 'btn btn-warning btn-sm']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('Primero')) ?>
            <?= $this->Paginator->prev('< '  . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Último')    . ' >>') ?>
        </ul>
        <p>
            <?= $this->Paginator->counter(
                __('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')
            ) ?>
        </p>
    </div>
</div>

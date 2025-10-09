<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Pacientes1> $pacientes1
 */
?>
<?php $this->assign('title', 'Pacientes'); ?>
<!-- Formulario de búsqueda -->
<?= $this->Form->create(null, [
    'type' => 'get',
    'class' => 'mb-3 me-3',
    'url' => ['controller' => 'Pacientes1', 'action' => 'index']
]) ?>
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


<div class="pacientes1 index content">
    <?= $this->Html->link(__('Añadir Paciente'), ['action' => 'add'], ['class' => 'button float-right btn btn-info']) ?>
    <div class="contenedor principal">
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead class="bg-info text-white">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nombre', 'Nombre') ?></th>
                        <th><?= $this->Paginator->sort('apellido', 'Apellido') ?></th>
                        <th><?= $this->Paginator->sort('telefono_celular', 'Celular') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                        <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                        <th class="actions text-dark"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes1 as $paciente): ?>
                    <tr>
                        <td><?= $this->Number->format($paciente->id) ?></td>
                        <td><?= h($paciente->nombre) ?></td>
                        <td><?= h($paciente->apellido) ?></td>
                        <td><?= h($paciente->telefono_celular) ?></td>
                        <td><?= h($paciente->created) ?></td>
                        <td><?= h($paciente->modified) ?></td>
                        <td class="actions text-center">
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $paciente->id],
                                ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $paciente->id],
                                ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-file-pdf"></i>',
                                ['action' => 'exportPacientePdf', $paciente->id],
                                ['escape' => false, 'title' => 'Exportar a PDF', 'class' => 'btn btn-danger btn-sm']
                            ) ?>
            <?php
                $numero = preg_replace('/\D/', '', $paciente->telefono_celular);
                $mensaje = urlencode("Hola, te hablamos del Consultorio Dental HeaDent");
                $urlWhatsapp = "https://wa.me/51{$numero}?text={$mensaje}";
            ?>
            <?= $this->Html->link(
                '<i class="fab fa-whatsapp"></i>',
                $urlWhatsapp,
                ['escape' => false, 'title' => 'Enviar WhatsApp', 'class' => 'btn btn-success btn-sm', 'target' => '_blank']
            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

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
<?php $this->assign('title', 'Registros de Consultas'); ?>

<!-- Formulario de búsqueda estilo mejorado -->
<?= $this->Form->create(null, ['url' => ['action' => 'index'], 'method' => 'get', 'class' => 'mb-3']) ?>

    <legend>Filtrar por Rango de Fechas, Paciente y Tratamiento</legend>
    <div class="input-group">
        <div class="col">
            <?= $this->Form->control('search', [
                'label' => 'Buscar por Paciente o Doctor',
                'placeholder' => 'Buscar por: Nombre/Apellido',
                'value' => $searchTerm,
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('start_date', [
                'type' => 'date',
                'label' => 'Fecha Inicio',
                'value' => $startDate,
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('end_date', [
                'type' => 'date',
                'label' => 'Fecha Fin',
                'value' => $endDate,
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
    
    <button class="btn btn-info mt-3 mx-2" type="submit">Buscar</button>

<?= $this->Form->end() ?>

<!-- Botón Agregar Consulta -->


<div class="consultas index content">
    <!--<?= $this->Html->link(__('Agregar Consulta'), ['action' => 'add'], ['class' => 'button float-right btn btn-info openModal' ]) ?>-->
   
    <div class="contenedor principal">
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead class="bg-info text-white">
                    <tr>
                        <th><?= $this->Paginator->sort('N° de Consulta') ?></th> <!-- Añadir ID al encabezado -->
                        <th><?= $this->Paginator->sort('Paciente') ?></th>
                        <th><?= $this->Paginator->sort('Doctor') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Fecha') ?></th>
                        <th><?= $this->Paginator->sort('_total_monto_doctor', 'Total Doctor') ?></th>
                        <th><?= $this->Paginator->sort('_total_monto_materiales', 'Total Materiales') ?></th>
                        <th><?= $this->Paginator->sort('_total_monto_clinica', 'Total Clínica') ?></th>
                        <th><?= $this->Paginator->sort('_total_costo', 'Costo Total') ?></th>
                        <th class="actions text-dark"><?= __('Acciones') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registroConsulta): ?>
                        <tr>
                            <td><?= $this->Number->format($registroConsulta->id) ?></td> <!-- Mostrar ID -->
<td class="text-white">
    <?php
$nombrePaciente = $registroConsulta->pacientes1->nombre ?? null;
$idPaciente = $registroConsulta->pacientes1->id ?? null;

    if ($nombrePaciente && $idPaciente) {
        echo $this->Html->link(
            h($nombrePaciente),
            ['controller' => 'Pacientes', 'action' => 'view', $idPaciente],
            ['class' => 'text-white openModal']
        );
    } else {
        echo 'N/A';
    }
    ?>
</td>
                            <td><?= h($registroConsulta->doctore->nombre) ?></td>
                            <td><?= h($registroConsulta->created->format('d/m/Y')) ?></td>
                            <td><?= $this->Number->currency($registroConsulta->_total_monto_doctor) ?></td>
                            <td><?= $this->Number->currency($registroConsulta->_total_monto_materiales) ?></td>
                            <td><?= $this->Number->currency($registroConsulta->_total_monto_clinica) ?></td>
                            <td><?= $this->Number->currency($registroConsulta->_total_costo) ?></td>
                            <td class="actions text-center">
                            <!-- Íconos personalizados para acciones -->
                            <?= $this->Html->link(
                                '<i class="fas fa-eye"></i>',
                                ['action' => 'view', $registroConsulta->id],
                                ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                            ) ?>
                            <?php if (in_array($usuario->rol, [1, 2])): ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-edit"></i>',
                                ['action' => 'edit', $registroConsulta->id],
                                ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm openModal']
                            ) ?>
                            <?php endif; ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-file-pdf"></i>',
                                ['action' => 'exportPdf', $registroConsulta->id],
                                ['escape' => false, 'title' => 'Exportar a PDF', 'class' => 'btn btn-danger btn-sm']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fas fa-eye" style="color:' . ($registroConsulta->estado === 'A' ? 'green' : 'red') . '"></i>',
                                ['action' => 'toggleState', $registroConsulta->id],
                                ['escape' => false, 'title' => $registroConsulta->estado === 'A' ? 'Desactivar' : 'Activar', 'class' => 'btn btn-sm toggle-state']
                            ) ?>                            
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación estilo unificado -->
    <div class="paginator">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ' . __('Primero')) ?>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Último') . ' >>') ?>
        </ul>
        <p class="text-muted text-center">
            <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}}')) ?>
        </p>
    </div>
</div>

<script>
    document.addEventListener('click', function (event) {
        if (event.target.closest('.toggle-state')) {
            event.preventDefault(); // Evita la navegación inmediata
    
            const button = event.target.closest('.toggle-state');
            const estado = button.querySelector('i').style.color === 'green' ? 'A' : 'I';
    
            const message = estado === 'A' 
                ? '¿Estás seguro de inactivar el registro?' 
                : '¿Estás seguro de activar el registro?';
    
            if (confirm(message)) {
                window.location.href = button.href; // Redirigir solo si el usuario confirma
            }
        }
    });
</script>
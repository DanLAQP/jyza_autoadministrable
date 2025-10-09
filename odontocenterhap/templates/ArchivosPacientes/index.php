<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ArchivosPaciente> $archivosPacientes
 */
?>

<?php $this->assign('title', 'Archivos'); ?>

<div class="archivosPacientes index content">
    <!-- Botón para añadir nuevo archivo -->
    <?= $this->Html->link(__('Subir Archivo'), ['action' => 'add'], ['class' => 'btn btn-info float-right openModal']) ?>

    <!-- Tabla de archivos -->
    <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead class="bg-info text-white">
                <tr>
                    <th><?= $this->Paginator->sort('id', 'N° de Archivo') ?></th>
                    <th><?= $this->Paginator->sort('paciente_id', 'Paciente') ?></th>
                    <th><?= $this->Paginator->sort('tipo', 'Tipo') ?></th>
                    <th><?= $this->Paginator->sort('ruta_archivo', 'Archivo') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Creado') ?></th>
                    <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                    <th class="actions text-dark"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($archivosPacientes as $archivosPaciente): ?>
                <tr>
                    <td><?= $this->Number->format($archivosPaciente->id) ?></td>
<td>
    <?php if (!empty($archivosPaciente->paciente->pacientes1) && !empty($archivosPaciente->paciente->pacientes1)): ?>
        <?= $this->Html->link(
            h($archivosPaciente->paciente->pacientes1->nombre),
            ['controller' => 'Pacientes', 'action' => 'view', $archivosPaciente->paciente->pacientes1->id],
            ['class' => 'text-white openModal']
        ) ?>
    <?php else: ?>
        <!-- Mostrar algo por defecto si no hay paciente -->
        <span>No disponible</span>
    <?php endif; ?>
</td>
                    <td><?= h($archivosPaciente->tipo) ?></td>
                    
                    <!-- Mostrar imagen, PDF o enlace de descarga -->
                    <td>
                        <?php
                        $rutaArchivo = $archivosPaciente->ruta_archivo;
                        $extension = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));

                        if (in_array($extension, ['png', 'jpg', 'jpeg'])):
                        ?>
                            <!-- Miniatura para imágenes -->
                            <img src="<?= $this->Url->build('/' . h($rutaArchivo), ['fullBase' => true]) ?>" 
                                alt="Imagen" 
                                style="max-width: 40px; max-height: 40px; display: block; ">
                        <?php elseif ($extension === 'pdf'): ?>
                            <!-- Icono de PDF -->
                            <i class="fas fa-file-pdf" style="font-size: 24px; color: red; display: block;" title="Archivo PDF"></i>
                        <?php else: ?>
                            <!-- Icono de documento genérico -->
                            <i class="fas fa-file-alt" style="font-size: 24px; color: gray; display: block; " title="Documento"></i>
                        <?php endif; ?>



                    <td><?= h($archivosPaciente->created) ?></td>
                    <td><?= h($archivosPaciente->modified) ?></td>
                    <td class="actions text-center">
                        <!-- Íconos personalizados para acciones -->
                        <?= $this->Html->link(
                            '<i class="fas fa-eye"></i>',
                            ['action' => 'view', $archivosPaciente->id],
                            ['escape' => false, 'title' => 'Ver', 'class' => 'btn btn-info btn-sm openModal']
                        ) ?>
                        <?= $this->Html->link(
                            '<i class="fas fa-edit"></i>',
                            ['action' => 'edit', $archivosPaciente->id],
                            ['escape' => false, 'title' => 'Editar', 'class' => 'btn btn-warning btn-sm openModal']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="paginator">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ' . __('Primero')) ?>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('Último') . ' >>') ?>
        </ul>
        <p class="text-center"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')) ?></p>
    </div>
</div>

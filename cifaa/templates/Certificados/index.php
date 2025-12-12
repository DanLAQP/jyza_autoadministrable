<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Certificado> $certificados
 */
?>
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info"><i class="fas fa-certificate"></i> Gestión de Certificados</h2>
            <?= $this->Html->link('<i class="fas fa-plus"></i> Generar Nuevo Certificado', ['action' => 'generar'], ['class' => 'btn btn-info', 'escape' => false]) ?>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Alumno') ?></th>
                            <th><?= $this->Paginator->sort('curso_id', 'Curso') ?></th>
                            <th><?= $this->Paginator->sort('horas') ?></th>
                            <th><?= $this->Paginator->sort('fecha_emision') ?></th>
                            <th><?= $this->Paginator->sort('codigo') ?></th>
                            <th class="actions"><?= __('Acciones') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($certificados as $certificado): ?>
                        <tr>
                            <td><?= $this->Number->format($certificado->id) ?></td>
                            <td><?= $certificado->has('user') ? h($certificado->user->username) : '' ?></td>
                            <td><?= $certificado->has('curso') ? h($certificado->curso->titulo) : '' ?></td>
                            <td><?= $this->Number->format($certificado->horas) ?> hrs</td>
                            <td><?= h($certificado->fecha_emision) ?></td>
                            <td><span class="badge bg-secondary"><?= h($certificado->codigo) ?></span></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-download"></i>', ['action' => 'descargar', $certificado->id], ['escape' => false, 'class' => 'btn btn-sm btn-success', 'title' => 'Descargar PDF']) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $certificado->id], ['confirm' => __('¿Estás seguro de eliminar el certificado # {0}?', $certificado->id), 'escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => 'Eliminar']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="paginator mt-3">
                <ul class="pagination justify-content-center">
                    <?= $this->Paginator->first('<< ' . __('Primero')) ?>
                    <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('Siguiente') . ' >') ?>
                    <?= $this->Paginator->last(__('Último') . ' >>') ?>
                </ul>
            </div>
        </div>
    </div>
</div>

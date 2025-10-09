<style>
    .label-text {
        color: #f8f9fa;
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
        min-height: 38px;
        display: flex;
        align-items: center;
        color: #ffffff;
    }
</style>

<div class="container mt-4 mb-4">
    <!-- Título -->
    <div class="mb-4">
        <h3 class="text-info"><i class="fas fa-file-medical me-2"></i> Detalles de la Consulta</h3>
    </div>

    <!-- Información de la Consulta -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Paciente:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($registro->pacientes1->nombre . ' ' . $registro->pacientes1->apellido) ?></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Doctor:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($registro->doctore->nombre) ?></div>
        </div>
    </div>
    <?php
    $opcionesPago = [
        'efectivo' => 'Efectivo',
        'transferencia' => 'Transferencia',
        'tarjeta' => 'Tarjeta'
    ];
    
    $tipoPagoTexto = $opcionesPago[$registro->tipo_pago] ?? 'Desconocido';
    ?>
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Tipo de Pago:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($tipoPagoTexto) ?></div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Observaciones:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($registro->observaciones) ?: 'No especificadas' ?></div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Fecha:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($registro->created->format('d/m/Y')) ?></div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="col-12 mt-3 text-center">
        <?= $this->Html->link(__('Editar Consulta'), ['action' => 'edit', $registro->id], ['class' => 'btn btn-warning me-2 openModal', 'target' => '_blank']) ?>
        <?= $this->Html->link(__('Descargar PDF'), ['action' => 'exportPdf', $registro->id], ['class' => 'btn btn-info me-2']) ?>
        <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <!-- Tratamientos Relacionados -->
    <div class="mt-4">
        <h4 class="text-info"><i class="fas fa-medkit me-2"></i> Tratamientos</h4>
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th><?= __('Tratamiento') ?></th>
                        <th><?= __('Cantidad') ?></th>
                        <th><?= __('Precio Unitario') ?></th>
                        <th><?= __('Costo Total') ?></th>
                        <th><?= __('Monto Doctor') ?></th>
                        <th><?= __('Monto Materiales') ?></th>
                        <th><?= __('Monto Clínica') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registro->consultas_tratamientos as $tratamiento): ?>
                        <tr>
                            <td><?= h($tratamiento->tratamiento->nombre) ?></td>
                            <td><?= $this->Number->format($tratamiento->cantidad) ?></td>
                            <td>S/.<?= $this->Number->format($tratamiento->costo) ?></td>
                            <td>S/.<?= $this->Number->format($tratamiento->costo * $tratamiento->cantidad) ?></td>
                            <td>S/.<?= $this->Number->format($tratamiento->monto_doctor) ?></td>
                            <td>S/.<?= $this->Number->format($tratamiento->monto_materiales) ?></td>
                            <td>S/.<?= $this->Number->format($tratamiento->monto_clinica) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

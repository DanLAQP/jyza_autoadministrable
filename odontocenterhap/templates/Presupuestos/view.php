<style>
    .label-text {
        color:  #f8f9fa;
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
        margin-top: -5px;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .actions {
        text-align: center;
        margin-top: 30px;
    }
</style>

<div class="container">
    <!-- Header -->
    <div class="mb-4 mt-3">
        <h3 class="text-info"><i class="fas fa-tooth"></i> Información del Presupuesto</h3>
    </div>

    <!-- Cuerpo -->
    <div>
        <!-- Campo: Información del Paciente -->
        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('Paciente:') ?></p>
            </div>
            <div class="col-md-10">
                <div class="data-box">
    <?php
    if (!empty($presupuesto->pacientes1)) {
        echo h($presupuesto->pacientes1->nombre . ' ' . $presupuesto->pacientes1->apellido);
    } else {
        echo __('No asignado');
    }
    ?>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('Dirección:') ?></p>
            </div>
            <div class="col-md-10">
                <div class="data-box">
                    <?= !empty($presupuesto->pacientes1->paciente->direccion) 
                        ? h($presupuesto->pacientes1->paciente->direccion) 
                        : __('No disponible') ?>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('DNI:') ?></p>
            </div>
            <div class="col-md-3">
                <div class="data-box">
                    <?= !empty($presupuesto->pacientes1->paciente->dni) 
                        ? h($presupuesto->pacientes1->paciente->dni) 
                        : __('No disponible') ?>
                </div>
            </div>
            <div class="col-md-2"></div>
            <!-- Campo: Fecha -->
            <div class="col-md-2">
                <p class="label-text"><?= __('Fecha:') ?></p>
            </div>
            <div class="col-md-3">
                <div class="data-box"><?= $presupuesto->modified->format('d/m/Y') ?></div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('Observaciones:') ?></p>
            </div>
            <div class="col-md-10">
                <div class="data-box">
                    <?= !empty($presupuesto->notas) && !empty($presupuesto->notas) 
                        ? h($presupuesto->notas) 
                        : __('Ninguna observacion') ?>
                </div>
            </div>
        </div>

        <!-- Detalles de la Cotización -->
       
            
            <div class="mt-4 ">
                <h3 class="text-info"><i class="fas fa-list"></i> Detalles de la Cotización</h3>
            </div>
        

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-info text-white">
                    <tr>
                        <th><?= __('Tratamiento') ?></th>
                        <th><?= __('Cantidad') ?></th>
                        <th><?= __('Precio Unitario') ?></th>
                        <th><?= __('Subtotal') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($presupuesto->presupuestos_tratamientos as $detalle): ?>
                        <tr>
                            <td><?= h($detalle->tratamiento->nombre) ?></td>
                            <td><?= h($detalle->cantidad) ?></td>
                            <td>
                                <?= $this->Number->currency($detalle->precio_unitario, 'S/ ') ?>
                            </td>
                            <td>
                                <?= $this->Number->currency($detalle->total, 'S/ ') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="row mb-3">
            <div class="col-md-2">
                <p class="label-text"><?= __('Total:') ?></p>
            </div>
            <div class="col-md-3">
                <div class="data-box">
                    S/ <?= $this->Number->format(array_sum(array_map(function ($detalle) {
                        return $detalle->total;
                    }, $presupuesto->presupuestos_tratamientos)), ['places' => 2]) ?>
                </div>
            </div>
        </div>        
    </div>

    <!-- Acciones -->
    <div class="actions">
        <?= $this->Html->link(__('Descargar PDF'), ['action' => 'exportPresupuestoPdf', $presupuesto->id], ['class' => 'btn btn-info me-2']) ?>
        <?= $this->Html->link(__('Volver a la Lista'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

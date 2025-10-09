<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">

            <!-- Título -->
            <div class="text-center mb-4">
                <h2 class="fw-bold text-white">
                    <?= __('Detalle de la Orden #') . h($ordene->id) ?>
                </h2>
                <hr class="border-primary border-2 w-25 mx-auto">
            </div>

            <!-- Info General y Totales -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="h-100 border border-secondary rounded-3 p-4 bg-dark">
                        <h5 class="text-info mb-3 fw-bold">
                            <i class="fas fa-file-medical me-2"></i> Información General
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2 text-light">
                                    <i class="fas fa-user me-2 text-success"></i><strong> Paciente:</strong>
                                    <span>
                                        <?= h(trim(($ordene->pacientes1->nombre ?? '') . ' ' . ($ordene->pacientes1->apellido ?? ''))) ?>
                                    </span>


                                </div>
                                <!-- <div class="mb-2 text-light">
                                    <i class="fas fa-user-md me-2 text-primary"></i><strong> Doctor ID:</strong>
                                    
                                    <span class="ms-2"><?= $this->Number->format($ordene->doctor_id) ?></span>
                                </div> -->
                                <div class="mb-2 text-light">
                                    <i class="fas fa-user-md me-2 text-primary"></i><strong>Doctor:</strong>
                                    <span class="ms-2">
                                        <?= h($ordene->doctore->nombre . ' ' . $ordene->doctore->apellido ?? 'Sin nombre') ?>
                                    </span>
                                </div>

                                <div class="mb-2">
                                    <span class="text-muted"><i class="fas fa-flag me-2 text-warning"></i> Estado:</span>
                                    <?php
                                    $estado = strtolower($ordene->estado);
                                    $clase = $estado === 'cancelado' ? 'text-success' : 'text-danger';
                                    ?>
                                    <span class="fw-semibold ms-3 <?= $clase ?>"><?= ucfirst($estado) ?></span>
                                </div>
                            </div>
                            

                            <div class="col-md-6">
                                <div class="mb-2 text-light">
                                    <i class="fas fa-calendar-plus me-2 text-warning"></i><strong> Creado:</strong>
                                    <span class="ms-2"><?= h($ordene->created) ?></span>
                                </div>
                                <div class="mb-2 text-light">
                                    <i class="fas fa-edit me-2 text-danger"></i><strong> Modificado:</strong>
                                    <span class="ms-2"><?= h($ordene->modified) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Totales -->
                <div class="col-lg-4">
                    <div class="h-100 d-flex flex-column justify-content-between">
                        <div class="mb-3 border border-success rounded-3 p-3 text-center bg-success">
                            <small class="d-block mb-1 fw-bold">TOTAL</small>
                            <h2 class="fw-bold mb-0">S/ <?= $this->Number->format($ordene->total) ?></h2>
                        </div>
                        <div class="border border-warning rounded-3 p-3 text-center bg-warning">
                            <small class="d-block mb-1 fw-bold">SALDO PENDIENTE</small>
                            <h2 class="fw-bold mb-0">S/ <?= $this->Number->format($ordene->saldo) ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tratamientos -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="border border-secondary rounded-3 p-4 bg-dark">
                        <h5 class="text-info mb-4 fw-bold">
                            <i class="bi bi-clipboard2-pulse me-2"></i>Tratamientos de la Orden
                        </h5>
                        <?php if (!empty($ordene->ordenes_tratamientos)) : ?>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover table-bordered border-secondary">
                                    <thead class="bg-info text-dark">

                                        <tr>
                                            <th>Tratamientos</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Precio Unitario</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ordene->ordenes_tratamientos as $ot) : ?>
                                            <tr>
                                                <td><?= h($ot->tratamiento->nombre ?? 'N/A') ?></td>
                                                <td class="text-center"><?= h($ot->cantidad) ?></td>
                                                <td class="text-end">S/ <?= h($ot->precio_unitario) ?></td>
                                                <td class="text-end fw-bold">S/ <?= h($ot->subtotal) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <i class="bi bi-info-circle text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 fs-6">No hay tratamientos registrados para esta orden.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Visitas -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="border border-secondary rounded-3 p-4 bg-dark">
                        <h5 class="text-info mb-4 fw-bold">
                            <i class="bi bi-calendar-check me-2"></i>Visitas de la Orden
                        </h5>
                        <?php if (!empty($ordene->visitas)) : ?>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover table-bordered border-secondary">
                                    <thead class="bg-info text-dark">

                                        <tr>
                                            <th class="text-center">Tipo de Pago</th>
                                            <th class="text-end">Monto Abonado</th>
                                            <th class="text-center">Fecha de Entrega</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ordene->visitas as $visita) : ?>
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge bg-primary fs-6"><?= h($visita->tipo_pago) ?></span>
                                                </td>
                                                <td class="text-end fw-bold">S/ <?= h($visita->abonado) ?></td>
                                                <td class="text-center"><?= h($visita->fecha_entrega) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-5">
                                <i class="bi bi-info-circle text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 fs-6">No hay visitas registradas para esta orden.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <?php if (!empty($ordene->observaciones)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="border border-secondary rounded-3 p-4 bg-dark">
                        <h5 class="text-info mb-3 fw-bold">
                            <i class="bi bi-chat-text me-2"></i>Observaciones
                        </h5>
                        <div class="bg-secondary border border-info rounded-2 p-3">
                            <pre class="text-white mb-0 fs-6"><?= h($ordene->observaciones) ?></pre>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Desglose Financiero -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="border border-secondary rounded-3 p-4 bg-dark">
                        <h5 class="text-info mb-4 fw-bold">
                            <i class="bi bi-calculator me-2"></i>Desglose Financiero
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="text-center p-3 border border-info rounded-2 bg-info">
                                    <small class="d-block fw-semibold">Monto Laboratorio</small>
                                    <strong class="fs-5">S/ <?= $this->Number->format($ordene->monto_laboratorio) ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 border border-primary rounded-2 bg-primary">
                                    <small class="d-block fw-semibold">Monto Materiales</small>
                                    <strong class="fs-5">S/ <?= $this->Number->format($ordene->monto_materiales) ?></strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 border border-success rounded-2 bg-success">
                                    <small class="d-block fw-semibold">% Pago Doctor</small>
                                    <strong class="fs-5"><?= ($ordene->porcentaje_doctor * 100) . '%' ?></strong>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="text-center p-3 border border-warning rounded-2 bg-warning">
                                    <small class="d-block fw-semibold">Pago al Doctor</small>
                                    <strong class="fs-5">S/ <?= $this->Number->format($ordene->pago_doctor) ?></strong>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="text-center p-3 border border-danger rounded-2 bg-danger">
                                    <small class="d-block fw-semibold">Restante Clínica</small>
                                    <strong class="fs-5">S/ <?= $this->Number->format($ordene->restante_clinica) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="container-lg text-center mt-4">
                <div class="simbolos-container mt-4">
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <!-- Botón Volver a la Lista -->
                        <?= $this->Html->link(
                            __('Volver a la Lista'),
                            ['action' => 'index'],
                            ['class' => 'btn btn-info mx-2']
                        ) ?>

                        <!-- Botón Editar Orden -->
                        <?= $this->Html->link(
                            __('Editar Orden'),
                            ['action' => 'edit', $ordene->id],
                            ['class' => 'btn btn-warning mx-2', 'target' => '_blank']
                        ) ?>

                        <!-- Botón Imprimir -->
                        <button type="button" class="btn btn-success mx-2" onclick="window.print()">
                            <i class="bi bi-printer me-1"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

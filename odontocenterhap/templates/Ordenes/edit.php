<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ordene $ordene
 * @var \App\Model\Entity\Paciente $pacienteSeleccionado
 * @var array $pacientesData
 * @var \Cake\Collection\CollectionInterface|string[] $doctores
 * @var array $tratamientosData
 */
?>

<div class="ordenes form content container mt-4 mb-4">
    <?= $this->Form->create($ordene, ['class' => 'needs-validation row g-3']) ?>
    <fieldset class="border p-3 rounded">
        <legend class="mb-3 text-light fw-bold fs-4">
            <i class="fas fa-edit"></i> <?= __('Editar Orden') ?>
        </legend>

        <div class="row">
            <!-- IZQUIERDA -->
            <div class="col-md-8">
                <!-- Mostrar Paciente (solo lectura) -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-light">Paciente</label>
                    <input type="text" class="form-control" 
                        value="<?= h(($pacienteSeleccionado->nombre ?? '') . ' ' . ($pacienteSeleccionado->apellido ?? '')) ?>"
                        readonly>
                    <?= $this->Form->hidden('paciente_id', ['value' => $pacienteSeleccionado->id]) ?>
                </div>


                <!-- Doctor -->
                <div class="mb-3">
                    <label for="doctor-id" class="form-label fw-bold">Doctor</label>
                    <?= $this->Form->select('doctor_id', $doctores, [
                        'id' => 'doctor-id',
                        'class' => 'form-select py-2 w-100',
                        'empty' => 'Seleccione doctor'
                    ]) ?>
                </div>

                <!-- Tratamientos -->
                <div class="mb-4">
                    <h5 class="text-info fw-bold"><i class="fas fa-tooth"></i> Tratamientos</h5>
                    <div class="table-responsive">
                        <table class="table table-striped" id="tabla-tratamientos">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>Tratamiento</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas se llenan con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-tratamiento">Agregar Tratamiento</button>
                </div>

                <!-- Visitas -->
                <div class="mb-4">
                    <h5 class="text-info fw-bold"><i class="fas fa-money-bill-wave"></i> Visitas (Pagos / Adelantos)</h5>
                    <div class="table-responsive">
                        <table class="table table-striped" id="tabla-visitas">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th>Tipo de Pago</th>
                                    <th>Abonado</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="visitas-container">
                                <!-- Las filas se llenan con JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-visita">Agregar Visita</button>
                </div>
            </div>

            <!-- DERECHA -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white text-center fw-bold">
                        Costos Adicionales y Distribución
                    </div>
                    <div class="card-body">
                        <?= $this->Form->control('monto_laboratorio', ['label' => 'Monto Laboratorio (S/.)', 'class' => 'form-control mb-3', 'type' => 'number', 'step' => '0.01', 'min' => 0]) ?>
                        <?= $this->Form->control('monto_materiales', ['label' => 'Monto Materiales (S/.)', 'class' => 'form-control mb-3', 'type' => 'number', 'step' => '0.01', 'min' => 0]) ?>
                        <?= $this->Form->control('porcentaje_doctor', ['label' => '% Pago al Doctor', 'class' => 'form-control mb-3', 'type' => 'number', 'min' => 0, 'max' => 1, 'step' => '0.01']) ?>
                        <?= $this->Form->control('observaciones', ['label' => 'Observaciones', 'class' => 'form-control mb-3', 'rows' => 3]) ?>
                        <?= $this->Form->control('pago_doctor', ['label' => 'Pago Doctor (calculado)', 'class' => 'form-control bg-warning text-light fw-bold mb-3', 'readonly' => true]) ?>
                        <?= $this->Form->control('restante_clinica', ['label' => 'Restante Clínica (calculado)', 'class' => 'form-control bg-warning text-light fw-bold', 'readonly' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Totales y acciones -->
        <div class="row mt-3">
            <div class="col-md-4 mb-3">
                <?= $this->Form->control('total', ['label' => 'Total', 'class' => 'form-control-plaintext bg-warning text-light fw-bold text-center', 'readonly' => true]) ?>
            </div>
            <div class="col-md-4 mb-3">
                <?= $this->Form->control('saldo', ['label' => 'Saldo', 'class' => 'form-control-plaintext bg-warning text-light fw-bold text-center', 'readonly' => true]) ?>
            </div>
            <div class="col-md-3 d-flex align-items-end mb-3">
                <?= $this->Form->button('Guardar Cambios', ['class' => 'btn btn-success w-100 fw-bold py-2', 'escape' => false]) ?>
            </div>
            <div class="col-md-1 d-flex align-items-end mb-3">
    <a href="<?= $this->Url->build([
        'controller' => 'Pacientes1',
        'action' => 'view',
        $pacienteSeleccionado->id,
        '#' => 'ordenes'
    ]) ?>" class="btn btn-danger w-100 fw-bold py-2">Salir</a>
</div>

        </div>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
<style>
    .tratamiento-results .list-group-item {
        color: white !important;
    }

    .tratamiento-results .list-group-item:hover {
        background-color: #0056b3;
        color: #fff;
    }
    #tabla-tratamientos td:first-child {
        width: 300px;
        max-width: 300px;
        overflow: hidden;
    }
    input[type="hidden"] {
        display: none !important;
    }

    .is-invalid {
        border: 2px solid red;
    }
    select.is-invalid {
        border-color: #dc3545 !important;
        padding-right: 2.25rem;
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 0.65rem 0.65rem;
    }
</style>

<script>
const tratamientosData = <?= json_encode($tratamientosData) ?>;
const pacientesData = <?= json_encode($pacientesData) ?>;
const tratamientosExistentes = <?= json_encode($ordene->ordenes_tratamientos) ?>;
const visitasExistentes = <?= json_encode($ordene->visitas) ?>;

document.addEventListener('DOMContentLoaded', function () {
    let indexTrat = tratamientosExistentes.length;
    let indexVisita = visitasExistentes.length;

    const tbodyTratamientos = document.querySelector('#tabla-tratamientos tbody');
    const tbodyVisitas = document.getElementById('visitas-container');

    // PRECARGAR TRATAMIENTOS EXISTENTES
    tratamientosExistentes.forEach((tr, idx) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="text" class="form-control search-tratamiento" placeholder="Buscar tratamiento" value="${tr.tratamiento.nombre}">
                <input type="hidden" name="tratamientos[${idx}][id]" value="${tr.id}">
                <input type="hidden" name="tratamientos[${idx}][tratamiento_id]" class="tratamiento-id" value="${tr.tratamiento_id}">
                <div class="tratamiento-results list-group mt-1"></div>
            </td>
            <td><input type="number" class="form-control cantidad" name="tratamientos[${idx}][cantidad]" value="${tr.cantidad}"></td>
            <td><input type="text" class="form-control precio" name="tratamientos[${idx}][precio_unitario]" value="${parseFloat(tr.precio_unitario).toFixed(2)}"></td>
            <td><input type="text" class="form-control subtotal" name="tratamientos[${idx}][subtotal]" value="${parseFloat(tr.subtotal).toFixed(2)}" readonly></td>
            <td><button type="button" class="btn btn-sm btn-secondary" disabled>No eliminable</button></td>
        `;
        tbodyTratamientos.appendChild(row);
    });
    function formatFechaEntrega(fecha) {
    if (!fecha) return '';
    const date = new Date(fecha);
    if (isNaN(date)) return '';
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    const hh = String(date.getHours()).padStart(2, '0');
    const min = String(date.getMinutes()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
}


    // PRECARGAR VISITAS EXISTENTES
    visitasExistentes.forEach((v, idx) => {
        const row = document.createElement('tr');
        row.classList.add('visita-item');
        const fechaEntrega = formatFechaEntrega(v.fecha_entrega);

        row.innerHTML = `
            <td>
                <input type="hidden" name="visitas[${idx}][id]" value="${v.id}">
                <select class="form-select py-2" name="visitas[${idx}][tipo_pago]">
                    <option value="">Seleccione</option>
                    <option value="transferencia" ${v.tipo_pago === 'transferencia' ? 'selected' : ''}>Transferencia</option>
                    <option value="tarjeta" ${v.tipo_pago === 'tarjeta' ? 'selected' : ''}>Tarjeta</option>
                    <option value="efectivo" ${v.tipo_pago === 'efectivo' ? 'selected' : ''}>Efectivo</option>
                    <option value="yape" ${v.tipo_pago === 'yape' ? 'selected' : ''}>Yape</option>
                    <option value="plin" ${v.tipo_pago === 'plin' ? 'selected' : ''}>Plin</option>
                </select>
            </td>
            <td><input type="number" class="form-control" name="visitas[${idx}][abonado]" value="${v.abonado}"></td>
            <td><input type="datetime-local" class="form-control" name="visitas[${idx}][fecha_entrega]" value="${fechaEntrega}"></td>
            <td><button type="button" class="btn btn-sm btn-secondary" disabled>No eliminable</button></td>
        `;
        tbodyVisitas.appendChild(row);
    });

    // AGREGAR NUEVO TRATAMIENTO
    document.getElementById('add-tratamiento').addEventListener('click', function () {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="text" class="form-control search-tratamiento" placeholder="Buscar tratamiento">
                <input type="hidden" name="tratamientos[${indexTrat}][tratamiento_id]" class="tratamiento-id">
                <div class="tratamiento-results list-group mt-1"></div>
            </td>
            <td><input type="number" class="form-control cantidad" name="tratamientos[${indexTrat}][cantidad]" value="1"></td>
            <td><input type="text" class="form-control precio" name="tratamientos[${indexTrat}][precio_unitario]"></td>
            <td><input type="text" class="form-control subtotal" name="tratamientos[${indexTrat}][subtotal]" readonly></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-tratamiento">Eliminar</button></td>
        `;
        tbodyTratamientos.appendChild(row);
        indexTrat++;
    });

    tbodyTratamientos.addEventListener('input', function (e) {
        const tr = e.target.closest('tr');
        if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
            calcularSubtotal(tr);
        }
        if (e.target.classList.contains('search-tratamiento')) {
            const input = e.target.value.toLowerCase();
            const resultDiv = tr.querySelector('.tratamiento-results');
            const results = tratamientosData.filter(t => t.nombre.toLowerCase().includes(input));
            resultDiv.innerHTML = results.map(t => `
                <button type="button" class="list-group-item list-group-item-action"
                    data-id="${t.id}" data-costo="${t.costo}">${t.nombre}</button>
            `).join('');
        }
    });

    tbodyTratamientos.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-tratamiento')) {
            e.target.closest('tr').remove();
        }
        if (e.target.dataset.id) {
            const tr = e.target.closest('tr');
            tr.querySelector('.search-tratamiento').value = e.target.textContent;
            tr.querySelector('.tratamiento-id').value = e.target.dataset.id;
            tr.querySelector('.precio').value = parseFloat(e.target.dataset.costo).toFixed(2);
            tr.querySelector('.tratamiento-results').innerHTML = '';
            calcularSubtotal(tr);
        }
    });

    function calcularSubtotal(tr) {
        const cantidad = parseFloat(tr.querySelector('.cantidad')?.value) || 0;
        const precio = parseFloat(tr.querySelector('.precio')?.value) || 0;
        const subtotal = cantidad * precio;
        tr.querySelector('.subtotal').value = subtotal.toFixed(2);
    }

    // AGREGAR NUEVA VISITA
    document.getElementById('add-visita').addEventListener('click', function () {
        const row = document.createElement('tr');
        row.classList.add('visita-item');
        row.innerHTML = `
            <td>
                <select class="form-select py-2" name="visitas[${indexVisita}][tipo_pago]">
                    <option value="">Seleccione</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="yape">Yape</option>
                    <option value="plin">Plin</option>
                </select>
            </td>
            <td><input type="number" class="form-control" name="visitas[${indexVisita}][abonado]"></td>
            <td><input type="datetime-local" class="form-control" name="visitas[${indexVisita}][fecha_entrega]"></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-visita">Eliminar</button></td>
        `;
        tbodyVisitas.appendChild(row);
        indexVisita++;
    });

    tbodyVisitas.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-visita')) {
            e.target.closest('tr').remove();
        }
    });
 // === ESCUCHAR CAMBIOS Y ACTUALIZAR TOTALES ===
    document.querySelector('#tabla-tratamientos').addEventListener('input', function (e) {
        if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
            const tr = e.target.closest('tr');
            calcularSubtotal(tr);
        }
    });

    document.getElementById('visitas-container').addEventListener('input', function () {
        actualizarSaldo();
    });

     // === CAMBIOS EN CAMPOS DE DISTRIBUCIÓN ===
    document.querySelectorAll('[name="monto_laboratorio"], [name="monto_materiales"], [name="porcentaje_doctor"]').forEach(el => {
        el.addEventListener('input', () => {
            calcularDistribucion();
        });
    });

     // === VALIDAR SALDO ANTES DE GUARDAR ===
    document.querySelector('form').addEventListener('submit', function (e) {
        const saldo = parseFloat(document.querySelector('[name="saldo"]').value) || 0;
        if (saldo < 0) {
            e.preventDefault();
            alert('⚠️ El saldo no puede ser negativo. Por favor revise los montos abonados.');
        }
        // Validar que monto laboratorio + materiales no superen el total
        const total = parseFloat(document.querySelector('[name="total"]').value) || 0;
        const montoLab = parseFloat(document.querySelector('[name="monto_laboratorio"]').value) || 0;
        const montoMat = parseFloat(document.querySelector('[name="monto_materiales"]').value) || 0;

        // Limpiar clases anteriores
        document.querySelector('[name="monto_laboratorio"]').classList.remove('is-invalid');
        document.querySelector('[name="monto_materiales"]').classList.remove('is-invalid');
        document.querySelector('[name="total"]').classList.remove('is-invalid');

        // Validar que monto laboratorio + materiales no superen el total
        if (montoLab + montoMat > total) {
            e.preventDefault();
            alert('⚠️ La suma de Monto de Laboratorio y Materiales no puede ser mayor al Total de la orden.');

            document.querySelector('[name="monto_laboratorio"]').classList.add('is-invalid');
            document.querySelector('[name="monto_materiales"]').classList.add('is-invalid');
            document.querySelector('[name="total"]').classList.add('is-invalid');

            return;
        }


        // 🔴 Validar que todos los tratamientos tengan ID seleccionado
            let tratamientosValidos = true;

            document.querySelectorAll('.tratamiento-id').forEach(function (input) {
                if (!input.value.trim()) {
                    tratamientosValidos = false;

                    // Marcar el campo visible de búsqueda como inválido
                    const searchInput = input.closest('td').querySelector('.search-tratamiento');
                    if (searchInput) {
                        searchInput.classList.add('is-invalid');
                    }
                }
            });

            if (!tratamientosValidos) {
                e.preventDefault();
                alert('Por favor, asegúrese de seleccionar un tratamiento válido en cada fila.');
                return;
            }
            // Validar visitas completas
        const visitasIncompletas = [];
        document.querySelectorAll('.visita-item').forEach((fila, index) => {
            const tipoPago = fila.querySelector('[name^="visitas"][name$="[tipo_pago]"]');
            const abonado = fila.querySelector('[name^="visitas"][name$="[abonado]"]');
            const fechaEntrega = fila.querySelector('[name^="visitas"][name$="[fecha_entrega]"]');

            // Limpiar errores anteriores
            [tipoPago, abonado, fechaEntrega].forEach(input => input.classList.remove('is-invalid'));

            const camposInvalidos = [];

            if (!tipoPago.value.trim()) {
                camposInvalidos.push(tipoPago);
            }

            if (!abonado.value || parseFloat(abonado.value) <= 0) {
                camposInvalidos.push(abonado);
            }

            if (!fechaEntrega.value.trim()) {
                camposInvalidos.push(fechaEntrega);
            }

            if (camposInvalidos.length > 0) {
                visitasIncompletas.push(index + 1);
                camposInvalidos.forEach(input => input.classList.add('is-invalid'));
            }
        });

        if (visitasIncompletas.length > 0) {
            e.preventDefault();
            alert(`Por favor, completa correctamente las visitas: ${visitasIncompletas.join(', ')}`);
            return;
        }

    });
    //quitar el borde rojo de los campos de búsqueda
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('search-tratamiento')) {
        e.target.classList.remove('is-invalid');
    }
});
document.getElementById('tabla-visitas').addEventListener('input', function (e) {
    if (e.target.classList.contains('is-invalid')) {
        e.target.classList.remove('is-invalid');
    }
});



//funciones extras de validación

    // === FUNCIONES AUXILIARES ===
    function calcularSubtotal(tr) {
        const cantidad = parseFloat(tr.querySelector('.cantidad')?.value) || 0;
        const precio = parseFloat(tr.querySelector('.precio')?.value) || 0;
        const subtotal = cantidad * precio;
        tr.querySelector('.subtotal').value = subtotal.toFixed(2);
        actualizarTotal();
    }

    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.querySelector('[name="total"]').value = total.toFixed(2);
        calcularDistribucion();
        actualizarSaldo();
    }

    function actualizarSaldo() {
        const total = parseFloat(document.querySelector('[name="total"]').value) || 0;
        let abonado = 0;
        document.querySelectorAll('[name$="[abonado]"]').forEach(input => {
            abonado += parseFloat(input.value) || 0;
        });
        const saldo = total - abonado;
        document.querySelector('[name="saldo"]').value = saldo.toFixed(2);
    }

    function calcularDistribucion() {
        const total = parseFloat(document.querySelector('[name="total"]').value) || 0;
        const lab = parseFloat(document.querySelector('[name="monto_laboratorio"]').value) || 0;
        const mat = parseFloat(document.querySelector('[name="monto_materiales"]').value) || 0;
        const porcentaje = parseFloat(document.querySelector('[name="porcentaje_doctor"]').value) || 0.5;
        const base = total - lab - mat;
        const pagoDoctor = base * porcentaje;
        const restante = base - pagoDoctor;
        document.querySelector('[name="pago_doctor"]').value = pagoDoctor.toFixed(2);
        document.querySelector('[name="restante_clinica"]').value = restante.toFixed(2);
    }

    // Inicializar totales al cargar
    actualizarTotal();

});
</script>

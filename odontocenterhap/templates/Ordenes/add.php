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
            <i class="fas fa-file-medical"></i> <?= __('Agregar Orden') ?>
        </legend>

        <div class="row">
            <!-- IZQUIERDA: Datos principales, tratamientos y visitas -->
            <div class="col-md-8">
                <!-- Buscar Paciente -->
                <div class="mb-3">
                    <label for="searchPaciente" class="form-label fw-bold text-light">Buscar Paciente</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchPaciente"
                            placeholder="Ingrese nombre o apellido"
                            value="<?= $pacienteSeleccionado ? h($pacienteSeleccionado->nombre . ' ' . $pacienteSeleccionado->apellido) : '' ?>"
                            <?= $pacienteSeleccionado ? 'readonly' : '' ?>>
                        <button type="button" class="btn btn-primary" id="searchButton" <?= $pacienteSeleccionado ? 'disabled' : '' ?>><i class="fas fa-search"></i></button>
                    </div>
                    <div id="pacienteResults" class="list-group mt-2"></div>
                    <?= $this->Form->hidden('paciente_id', ['id' => 'pacienteId', 'value' => $pacienteSeleccionado ? $pacienteSeleccionado->id : '']) ?>
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
                                <tr>
                                    <td>
                                        <input type="text" class="form-control search-tratamiento" placeholder="Buscar tratamiento">
                                        <input type="hidden" name="tratamientos[0][tratamiento_id]" class="tratamiento-id">
                                        <div class="tratamiento-results list-group mt-1"></div>
                                    </td>
                                    <td><input type="number" class="form-control cantidad" name="tratamientos[0][cantidad]" min="1" value="1"></td>
                                    <td><input type="text" class="form-control precio" name="tratamientos[0][precio_unitario]"></td>
                                    <td><input type="text" class="form-control subtotal" name="tratamientos[0][subtotal]" readonly></td>
                                    <td><button type="button" class="btn btn-sm btn-danger remove-tratamiento">Eliminar</button></td>
                                </tr>
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
                                <!-- Sin fila por defecto -->
                            </tbody>

                            <!-- <tbody id="visitas-container">
                                <tr class="visita-item">
                                    <td>
                                        <select class="form-select py-2" name="visitas[0][tipo_pago]">
                                            <option value="">Seleccione</option>
                                            <option value="transferencia">Transferencia</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="yape">Yape</option>
                                            <option value="plin">Plin</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control" name="visitas[0][abonado]" placeholder="Abonado"></td>
                                    <td><input type="datetime-local" class="form-control" name="visitas[0][fecha_entrega]"></td>
                                    <td><button type="button" class="btn btn-sm btn-danger remove-visita">Eliminar</button></td>
                                </tr>
                            </tbody> -->

                        </table>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-visita">Agregar Visita</button>
                </div>
            </div>

            <!-- DERECHA: Costos y distribución -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white text-center fw-bold">
                        Costos Adicionales y Distribución
                    </div>
                    <div class="card-body">
                        <?= $this->Form->control('monto_laboratorio', ['label' => 'Monto Laboratorio (S/.)', 'class' => 'form-control mb-3', 'id' => 'monto-laboratorio', 'type' => 'number', 'step' => '0.01', 'min' => 0]) ?>
                        <?= $this->Form->control('monto_materiales', ['label' => 'Monto Materiales (S/.)', 'class' => 'form-control mb-3', 'id' => 'monto-materiales', 'type' => 'number', 'step' => '0.01', 'min' => 0]) ?>
                        <?= $this->Form->control('porcentaje_doctor', [
                            'label' => '% Pago al Doctor',
                            'class' => 'form-control mb-3',
                            'type' => 'number',
                            'min' => 0,
                            'max' => 1,
                            'step' => '0.01',
                            'id' => 'porcentaje-doctor',
                            'value' => $ordene->porcentaje_doctor ?? 
                                ((isset($ordene->doctor_id) && in_array($ordene->doctor_id, [2, 5])) ? 0.45 : 0.4)
                        ]) ?>

                        <?= $this->Form->control('observaciones', ['label' => 'Observaciones', 'class' => 'form-control mb-3', 'rows' => 3]) ?>
                        <?= $this->Form->control('pago_doctor', ['label' => 'Pago Doctor (calculado)', 'class' => 'form-control bg-warning text-light fw-bold mb-3', 'id' => 'pago-doctor', 'readonly' => true]) ?>
                        <?= $this->Form->control('restante_clinica', ['label' => 'Restante Clínica (calculado)', 'class' => 'form-control bg-warning text-light fw-bold', 'id' => 'restante-clinica', 'readonly' => true]) ?>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- inferior saldos y botones de guardado -->
         <div class="row mt-3">
    <!-- Total -->
    <div class="col-md-4 mb-3">
        <?= $this->Form->control('total', [
            'label' => 'Total',
            'class' => 'form-control-plaintext bg-warning text-light fw-bold text-center',
            'readonly' => true,
            'id' => 'orden-total'
        ]) ?>
    </div>

    <!-- Saldo -->
    <div class="col-md-4 mb-3">
        <?= $this->Form->control('saldo', [
            'label' => 'Saldo',
            'class' => 'form-control-plaintext bg-warning text-light fw-bold text-center',
            'readonly' => true,
            'id' => 'orden-saldo'
        ]) ?>
    </div>

    <!-- Guardar -->
    <div class="col-md-3 d-flex align-items-end mb-3">
        <?= $this->Form->button(__('Guardar Orden'), [
            'class' => 'btn btn-success w-100 fw-bold py-2'
        ]) ?>
    </div>

    <!-- Cancelar -->
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





<script>
const tratamientosData = <?= json_encode($tratamientosData) ?>;
const pacientesData = <?= json_encode($pacientesData) ?>;

document.addEventListener('DOMContentLoaded', function () {
    let indexTrat = 1;
    let indexVisita = 1;

    // Agregar tratamiento dinámico con buscador
    document.getElementById('add-tratamiento').addEventListener('click', function () {
        const tbody = document.querySelector('#tabla-tratamientos tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="text" class="form-control search-tratamiento" placeholder="Buscar tratamiento">
                <input type="hidden" name="tratamientos[${indexTrat}][tratamiento_id]" class="tratamiento-id">
                <div class="tratamiento-results list-group mt-1"></div>
            </td>
            <td><input type="number" class="form-control cantidad" name="tratamientos[${indexTrat}][cantidad]" min="1" value="1"></td>
            <td><input type="text" class="form-control precio" name="tratamientos[${indexTrat}][precio_unitario]"></td>
            <td><input type="text" class="form-control subtotal" name="tratamientos[${indexTrat}][subtotal]" readonly></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-tratamiento">Eliminar</button></td>
        `;
        tbody.appendChild(row);
        indexTrat++;
    });

    // Buscador dinámico de tratamientos
    document.getElementById('tabla-tratamientos').addEventListener('input', function (e) {
        if (e.target.classList.contains('search-tratamiento')) {
            const input = e.target.value.toLowerCase();
            const resultDiv = e.target.nextElementSibling.nextElementSibling;
            const results = tratamientosData.filter(t => t.nombre.toLowerCase().includes(input));
            resultDiv.innerHTML = results.map(t => `
                <button type="button" class="list-group-item list-group-item-action"
                    data-id="${t.id}" data-costo="${t.costo}">
                    ${t.nombre}
                </button>
            `).join('');
        }
    });

    // Selección de tratamiento
    document.getElementById('tabla-tratamientos').addEventListener('click', function (e) {
        if (e.target.dataset.id) {
            const tr = e.target.closest('tr');
            tr.querySelector('.search-tratamiento').value = e.target.textContent.trim();
            tr.querySelector('.tratamiento-id').value = e.target.dataset.id;
            tr.querySelector('.precio').value = parseFloat(e.target.dataset.costo).toFixed(2);
            tr.querySelector('.tratamiento-results').innerHTML = '';
            calcularSubtotal(tr);
        }

        if (e.target.classList.contains('remove-tratamiento')) {
            e.target.closest('tr').remove();
            actualizarTotal();
        }
    });

    // Cambios en cantidad o precio
    document.getElementById('tabla-tratamientos').addEventListener('input', function (e) {
        if (e.target.classList.contains('cantidad') || e.target.classList.contains('precio')) {
            const tr = e.target.closest('tr');
            calcularSubtotal(tr);
        }
    });

    function calcularSubtotal(tr) {
        const cantidad = parseFloat(tr.querySelector('.cantidad').value) || 0;
        const precio = parseFloat(tr.querySelector('.precio').value) || 0;
        const subtotal = cantidad * precio;
        tr.querySelector('.subtotal').value = subtotal.toFixed(2);
        actualizarTotal();
    }

    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('orden-total').value = total.toFixed(2);
        actualizarSaldo();
        validarMontosContraTotal();
    }

  // Agregar visita (formato tabla)
    document.getElementById('add-visita').addEventListener('click', function () {
    const container = document.getElementById('visitas-container');
    const tr = document.createElement('tr');
    tr.classList.add('visita-item');
    tr.innerHTML = `
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

        <td>
            <input type="number" class="form-control" name="visitas[${indexVisita}][abonado]" placeholder="Abonado">
        </td>
        <td>
            <input type="datetime-local" class="form-control" name="visitas[${indexVisita}][fecha_entrega]">
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-visita">Eliminar</button>
        </td>
    `;
    container.appendChild(tr);
    indexVisita++;
});


    // Eliminar visita
    document.getElementById('visitas-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-visita')) {
            e.target.closest('tr').remove();
        }
    });


    // Buscador de paciente
    document.getElementById('searchButton').addEventListener('click', function () {
        const input = document.getElementById('searchPaciente').value.toLowerCase();
        const results = pacientesData.filter(p =>
            `${p.nombre} ${p.apellido}`.toLowerCase().includes(input)
        );
        const list = document.getElementById('pacienteResults');
        list.innerHTML = results.map(p => `
            <button type="button" class="list-group-item list-group-item-action"
                data-id="${p.id}">
                ${p.nombre} ${p.apellido} - DNI: ${p.dni}
            </button>
        `).join('');
    });

    document.getElementById('pacienteResults').addEventListener('click', function (e) {
        if (e.target.dataset.id) {
            document.getElementById('pacienteId').value = e.target.dataset.id;
            document.getElementById('searchPaciente').value = e.target.textContent;
            document.getElementById('searchPaciente').readOnly = true;
            document.getElementById('searchButton').disabled = true;
            e.currentTarget.innerHTML = '';
        }
    });

        // Recalcular el saldo después de cada cambio en los pagos
    function actualizarSaldo() {
        const total = parseFloat(document.getElementById('orden-total').value) || 0;
        let abonadoTotal = 0;

        document.querySelectorAll('input[name^="visitas"][name$="[abonado]"]').forEach(input => {
            abonadoTotal += parseFloat(input.value) || 0;
        });

        const saldo = total - abonadoTotal;
        const saldoInput = document.getElementById('orden-saldo');
        if (saldoInput) {
            saldoInput.value = saldo.toFixed(2);

            // Marcar error visual si el saldo es negativo
            if (saldo < 0) {
                saldoInput.classList.add('is-invalid');
            } else {
                saldoInput.classList.remove('is-invalid');
            }
        }
    }

    // Cuando se agregue una nueva visita, recalcular saldo
    document.getElementById('add-visita').addEventListener('click', function () {
        setTimeout(actualizarSaldo, 50); // Asegura que los elementos nuevos ya estén en el DOM
    });

    // Cuando se elimine una visita, recalcular saldo
    document.getElementById('visitas-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-visita')) {
            setTimeout(actualizarSaldo, 50);
        }
    });

    // Cuando cambie algún input de tipo abonado, recalcular saldo
    document.getElementById('visitas-container').addEventListener('input', function (e) {
        if (e.target.name.includes('[abonado]')) {
            actualizarSaldo();
        }
    });

    // También recalcular saldo cada vez que cambie el total
    const totalInput = document.getElementById('orden-total');
    if (totalInput) {
        totalInput.addEventListener('input', actualizarSaldo);
    }

    // Recalcular inicialmente por si ya hay datos precargados
    actualizarSaldo();

    // Validación antes de enviar el formulario
const form = document.querySelector('form');
form.addEventListener('submit', function (e) {
    const pacienteId = document.getElementById('pacienteId').value;
    const saldo = parseFloat(document.getElementById('orden-saldo').value) || 0;

    // Validar paciente seleccionado
    if (!pacienteId) {
        e.preventDefault();
        alert('Por favor, seleccione un paciente antes de guardar.');
        return;
    }

    // Validar que el saldo no sea negativo
    if (saldo < 0) {
        e.preventDefault();
        alert('El saldo no puede ser negativo. Revise los montos abonados.');
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

// Asumiendo que el select tiene id="doctor-id"
const selectDoctor = document.getElementById('doctor-id');
if (selectDoctor) {
    selectDoctor.addEventListener('change', function () {
        const porcentajeInput = document.getElementById('porcentaje-doctor');
        const doctorId = parseInt(this.value);

        // IDs especiales con 45%
        if (doctorId === 2 || doctorId === 5) {
            porcentajeInput.value = 0.45;
        } else {
            porcentajeInput.value = 0.4;
        }

        // Recalcular distribución con el nuevo porcentaje
        calcularDistribucion();
    });
}

  function calcularDistribucion() {
    const total = parseFloat(document.getElementById('orden-total').value) || 0;
    const montoLab = parseFloat(document.getElementById('monto-laboratorio').value) || 0;
    const montoMat = parseFloat(document.getElementById('monto-materiales').value) || 0;
    const porcentajeDoctor = parseFloat(document.getElementById('porcentaje-doctor').value) || 0.5;

    const base = total - montoLab - montoMat;

    const pagoDoctor = base * porcentajeDoctor;
    const restanteClinica = base - pagoDoctor;

    document.getElementById('pago-doctor').value = pagoDoctor.toFixed(2);
    document.getElementById('restante-clinica').value = restanteClinica.toFixed(2);
}

function validarMontosContraTotal() {
    const total = parseFloat(document.getElementById('orden-total').value) || 0;
    const montoLabInput = document.getElementById('monto-laboratorio');
    const montoMatInput = document.getElementById('monto-materiales');

    let montoLab = parseFloat(montoLabInput.value) || 0;
    let montoMat = parseFloat(montoMatInput.value) || 0;

    let huboCambio = false;

    if (montoLab > total) {
        alert('El monto de laboratorio no puede ser mayor que el total.');
        montoLabInput.value = '';
        montoLab = 0;
        huboCambio = true;
    }

    if (montoMat > total) {
        alert('El monto de materiales no puede ser mayor que el total.');
        montoMatInput.value = '';
        montoMat = 0;
        huboCambio = true;
    }

    if (montoLab + montoMat > total) {
        alert('La suma de laboratorio y materiales no puede superar el total.');
        if (montoLab >= montoMat) {
            montoLabInput.value = '';
            montoLab = 0;
        } else {
            montoMatInput.value = '';
            montoMat = 0;
        }
        huboCambio = true;
    }

    if (montoLab === 0 && montoMat === 0) {
        // Aun sin montos, debe haber distribución
        calcularDistribucion();
    } else {
        calcularDistribucion(); // Si hay montos válidos, recalcular
    }

    return !huboCambio;
}

function limpiarDistribucion() {
    document.getElementById('pago-doctor').value = '';
    document.getElementById('restante-clinica').value = '';
}

// Ejecutar cálculo al cambiar total o montos
 const campos = ['orden-total', 'monto-laboratorio', 'monto-materiales', 'porcentaje-doctor'];
    campos.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function () {
                validarMontosContraTotal();
            });
        }
    });

    // Ejecutar al inicio si ya hay valores
    calcularDistribucion();


});
</script>
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

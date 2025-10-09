<?= $this->Form->create($registroConsulta, ['id' => 'form-edit-consulta']) ?>
<fieldset>
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-tooth"></i> Editar Registro de Consulta</h3>
    </div>

    <div class="col-md-10 mx-auto mb-3">
    <?= $this->Form->control('paciente_id', [
        'label' => 'Paciente',
        'options' => $pacientes,
        'empty' => 'Seleccione un paciente',
        'class' => 'form-control'
    ]) ?>
    </div>
    <div class="col-md-10 mx-auto mb-3">
    <?= $this->Form->control('doctor_id', [
        'label' => 'Doctor',
        'options' => $doctores,
        'empty' => 'Seleccione un doctor',
        'class' => 'form-control'
    ]) ?>
    </div>
    <div class="col-md-10 mx-auto mb-3">
        <?= $this->Form->control('tipo_pago', [
            'type' => 'select',
            'options' => [
                'efectivo' => 'Efectivo',
                'transferencia' => 'Transferencia',
                'tarjeta' => 'Tarjeta'
            ],
            'class' => 'form-control tipo-pago',
            'label' => 'Tipo de Pago',
            'default' => $registroConsulta->tipo_pago ?? 'efectivo' 
        ]) ?>
    </div>    
    <div class="col-md-10 mx-auto mb-3">
    <?= $this->Form->control('observaciones', [
        'type' => 'text',
        'label' => 'Observaciones',
        'class' => 'form-control'
    ]) ?>
    </div>
    <div class="col-md-10 mx-auto mb-3">
        <h4 class="text-info mb-3">Tratamientos:</h4>
        <div id="contenedor-tratamientos" class="mb-3">
            <?php foreach ($registroConsulta->consultas_tratamientos as $index => $consultaTratamiento): ?>
                <div class="tratamientos mb-4 p-3 border rounded shadow-sm" data-index="<?= $index ?>">
                    <!-- campo oculto del id-->
                    <?= $this->Form->hidden("tratamientos.{$index}.id", [
                        'value' => $consultaTratamiento->id,
                        'type' => 'hidden'
                    ]) ?>
                    <?= $this->Form->control("tratamientos.{$index}.tratamiento_id", [
                        'label' => 'Tratamiento ' . ($index + 1),
                        'options' => array_map(function ($tratamiento) {
                            return [
                                'value' => $tratamiento['id'],
                                'text' => $tratamiento['nombre'],
                                'data-costo' => $tratamiento['costo']
                            ];
                        }, $tratamientos),
                        'empty' => 'Seleccione un tratamiento',
                        'class' => 'form-control tratamiento-select mb-2',
                        'value' => $consultaTratamiento->tratamiento_id,
                    ]) ?>
                    <?= $this->Form->control("tratamientos.{$index}.costo", [
                        'label' => 'Costo',
                        'class' => 'form-control costo-tratamiento mb-2',
                        'value' => $consultaTratamiento->costo,
                        'min' => '0',
                        'step' => '0.01',
                        'type' => 'number',
                    ]) ?>
                    <?= $this->Form->control("tratamientos.{$index}.cantidad", [
                        'label' => 'Cantidad',
                        'class' => 'form-control cantidad-tratamiento mb-2',
                        'value' => $consultaTratamiento->cantidad,
                        'min' => '0',
                        'step' => '0.01',
                        'type' => 'number',
                    ]) ?>
                    Costo Total: <span class="costo-total">0.00</span>
                    <?= $this->Form->control("tratamientos.{$index}.monto_materiales", [
                        'label' => 'Monto Materiales',
                        'class' => 'form-control monto-materiales mb-2',
                        'value' => $consultaTratamiento->monto_materiales,
                        'min' => '0',
                        'step' => '0.01',
                        'type' => 'number'
                    ]) ?>
                    <?= $this->Form->control("tratamientos.{$index}.porcentaje_doctor", [
                        'label' => 'Porcentaje Doctor',
                        'class' => 'form-control porcentaje-doctor mb-2',
                        'value' => '0',
                        'min' => '0',
                        'max' => '100',
                        'step' => '0.01',
                        'type' => 'number',
                    ]) ?>
                    <?= $this->Form->control("tratamientos.{$index}.monto_doctor", [
                        'label' => 'Monto Doctor',
                        'class' => 'form-control monto-doctor mb-2',
                        'value' => $consultaTratamiento->monto_doctor,
                        'readonly' => true,
                        'min' => '0',
                        'type' => 'number',
                    ]) ?>
                    <?= $this->Form->control("tratamientos.{$index}.monto_clinica", [
                        'label' => 'Monto Clínica',
                        'class' => 'form-control monto-clinica mb-2',
                        'value' => $consultaTratamiento->monto_clinica,
                        'readonly' => true,
                        'min' => '0',
                        'type' => 'number',
                    ]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-10 mx-auto mb-3">
        <button type="button" id="add-tratamiento" class="btn btn-primary" onclick="addTratamiento()">Agregar Tratamiento</button>
    </div>
    <div class="col-12 mt-3 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-info mt-3']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary mt-3']) ?>
    </div>
</fieldset>

<?= $this->Form->end() ?>

<script>
    // Evita la redeclaración si ya está definida, pero asegúrate de que esté disponible globalmente
    if (typeof window.tratamientosDisponibles === "undefined") {
        window.tratamientosDisponibles = <?= json_encode($tratamientos) ?>;
    }

    document.addEventListener("DOMContentLoaded", function () {
        inicializarEventosTratamientos();
    });

    // Aseguramos que los campos no puedan ser negativos, agregando un controlador para la validación
    document.querySelectorAll(".tratamientos").forEach(select => {
        select.addEventListener("change", (event) => {
            const div = event.target.closest(".tratamientos");
            const selectedOption = event.target.options[event.target.selectedIndex];
            const costo = parseFloat(selectedOption.getAttribute("data-costo")) || 0;
            div.querySelector(".costo-tratamiento").value = costo.toFixed(2);
            calcularMontos(div);
        });

        select.closest(".tratamientos").querySelector(".porcentaje-doctor").addEventListener("input", () => {
            validarNoNegativo(select.closest(".tratamientos"));
            calcularMontos(select.closest(".tratamientos"));
        });
        select.closest(".tratamientos").querySelector(".monto-materiales").addEventListener("input", () => {
            validarNoNegativo(select.closest(".tratamientos"));
            calcularMontos(select.closest(".tratamientos"));
        });
        select.closest(".tratamientos").querySelector(".costo-tratamiento").addEventListener("input", () => {
            validarNoNegativo(select.closest(".tratamientos"));
            calcularMontos(select.closest(".tratamientos"));
        });
        select.closest(".tratamientos").querySelector(".cantidad-tratamiento").addEventListener("input", () => {
            validarNoNegativo(select.closest(".tratamientos"));
            calcularMontos(select.closest(".tratamientos"));
        });
        inicializarEventosTratamientos();
    });

    // Función para validar que no haya valores negativos
    function validarNoNegativo(tratamientoDiv) {
        const campos = ['.costo-tratamiento', '.porcentaje-doctor', '.monto-materiales', '.cantidad-tratamiento'];
        campos.forEach(campo => {
            const input = tratamientoDiv.querySelector(campo);
            if (parseFloat(input.value) < 0) {
                input.value = 0;
            }
        });
    
        // Validamos monto_clinica después de calcular los montos
        const montoClinicaInput = tratamientoDiv.querySelector(".monto-clinica");
        const montoClinica = parseFloat(montoClinicaInput.value);
    
        if (montoClinica < 0) {
            // Mostrar el mensaje de error debajo del campo
            if (!tratamientoDiv.querySelector(".mensaje-error-clinica")) {
                const errorMensaje = document.createElement("div");
                errorMensaje.classList.add("mensaje-error-clinica", "text-danger", "mt-2");
                errorMensaje.textContent = "El monto de la clínica no puede negativo.";
                tratamientoDiv.appendChild(errorMensaje);
            }
            montoClinicaInput.setCustomValidity("El monto de la clínica no puede negativo.");
        } else {
            // Restablecer el mensaje de validación
            montoClinicaInput.setCustomValidity("");
            const errorMensaje = tratamientoDiv.querySelector(".mensaje-error-clinica");
            if (errorMensaje) {
                errorMensaje.remove();
            }
        }
    }

    function inicializarEventosTratamientos() {
        document.querySelectorAll(".tratamientos").forEach(tratamientoDiv => {
            const selectTratamiento = tratamientoDiv.querySelector(".tratamiento-select");

            // Evento para actualizar el costo cuando cambia el tratamiento
            selectTratamiento.addEventListener("change", function (event) {
                const selectedOption = event.target.options[event.target.selectedIndex];
                const costo = parseFloat(selectedOption.getAttribute("data-costo")) || 0;
                tratamientoDiv.querySelector(".costo-tratamiento").value = costo.toFixed(2);
                calcularMontos(tratamientoDiv);
            });

            // Eventos para recalcular montos al modificar valores
            ["porcentaje-doctor", "monto-materiales", "costo-tratamiento", "cantidad-tratamiento"].forEach(className => {
                tratamientoDiv.querySelector(`.${className}`).addEventListener("input", () => calcularMontos(tratamientoDiv));
            });

            if (tratamientoDiv.querySelector(".monto-doctor").value !== '') {
                calcularPorcentajeDoctorParaTratamientosPrevios(tratamientoDiv);
            }

            // Calcular montos iniciales para tratamientos previos
            calcularMontos(tratamientoDiv);
        });
    }

    function calcularMontos(tratamientoDiv) {
        let costo = parseFloat(tratamientoDiv.querySelector(".costo-tratamiento").value) || 0;
        let porcentajeDoctor = parseFloat(tratamientoDiv.querySelector(".porcentaje-doctor").value) || 0;
        let montoMateriales = parseFloat(tratamientoDiv.querySelector(".monto-materiales").value) || 0;
        let cantidad = parseFloat(tratamientoDiv.querySelector(".cantidad-tratamiento").value) || 0;

        // Validación para asegurarnos que los valores no sean negativos
        if (costo < 0 || porcentajeDoctor < 0 || montoMateriales < 0) {
            // Si alguno de los valores es negativo, mostramos un mensaje de error y evitamos el cálculo
            tratamientoDiv.querySelector(".costo-tratamiento").classList.add("is-invalid");
            tratamientoDiv.querySelector(".porcentaje-doctor").classList.add("is-invalid");
            tratamientoDiv.querySelector(".monto-materiales").classList.add("is-invalid");
            tratamientoDiv.querySelector(".cantidad-tratamiento").classList.add("is-invalid");
    
            if (!tratamientoDiv.querySelector(".mensaje-error-valores")) {
                const errorMensaje = document.createElement("div");
                errorMensaje.classList.add("mensaje-error-valores", "text-danger", "mt-2");
                errorMensaje.textContent = "Los valores no pueden ser negativos.";
                tratamientoDiv.appendChild(errorMensaje);
            }
    
            // No calculamos los montos si hay valores inválidos
            return;
        } else {
            // Si los valores son válidos, eliminamos las clases de error
            tratamientoDiv.querySelector(".costo-tratamiento").classList.remove("is-invalid");
            tratamientoDiv.querySelector(".porcentaje-doctor").classList.remove("is-invalid");
            tratamientoDiv.querySelector(".monto-materiales").classList.remove("is-invalid");
            tratamientoDiv.querySelector(".cantidad-tratamiento").classList.remove("is-invalid");
    
            // Eliminamos el mensaje de error
            const errorMensaje = tratamientoDiv.querySelector(".mensaje-error-valores");
            if (errorMensaje) {
                errorMensaje.remove();
            }
        }
    
        // Ahora que hemos validado que los valores no son negativos, realizamos los cálculos
        let costoTotal = cantidad * costo;
        let restante = costoTotal - montoMateriales;
        let montoDoctor = (restante * porcentajeDoctor) / 100;
        let montoClinica = restante - montoDoctor
    
        // Asignamos los valores calculados a los campos correspondientes
        tratamientoDiv.querySelector(".monto-doctor").value = montoDoctor.toFixed(2);
        tratamientoDiv.querySelector(".monto-clinica").value = montoClinica.toFixed(2);
        tratamientoDiv.querySelector(".costo-total").textContent = costoTotal.toFixed(2);
    }

    function addTratamiento() {
        const contenedor = document.getElementById("contenedor-tratamientos");
        const index = document.querySelectorAll(".tratamientos").length;

        const nuevoTratamiento = document.createElement("div");
        nuevoTratamiento.classList.add("tratamientos", "mb-4", "p-3", "border", "rounded", "shadow-sm");
        nuevoTratamiento.setAttribute("data-index", index);
        nuevoTratamiento.innerHTML = `
            <input type="hidden" name="tratamientos[${index}][id]" value="">
    
            <label>Tratamiento ${index + 1}</label>
            <select name="tratamientos[${index}][tratamiento_id]" class="form-control tratamiento-select mb-2">
                <option value="">Seleccione un tratamiento</option>
                ${tratamientosOptions()}
            </select>
    
            <label>Costo</label>
            <input type="number" name="tratamientos[${index}][costo]" class="form-control costo-tratamiento mb-2" min="0" step="0.01" value="0">

            <label>Cantidad</label>
            <input type="number" name="tratamientos[${index}][cantidad]" class="form-control cantidad-tratamiento mb-2" min="0" step="0.01" value="1">
            <div class="costo-total-container p-2 border rounded">
                <strong>Costo Total:</strong> <span class="costo-total">0.00</span>
            </div> 

            <label>Monto Materiales</label>
            <input type="number" name="tratamientos[${index}][monto_materiales]" class="form-control monto-materiales mb-2" min="0" step="0.01" value="0">
    
            <label>Porcentaje Doctor</label>
            <input type="number" name="tratamientos[${index}][porcentaje_doctor]" class="form-control porcentaje-doctor mb-2" min="0" max="100" step="0.01" value="50">
    
            <label>Monto Doctor</label>
            <input type="number" name="tratamientos[${index}][monto_doctor]" class="form-control monto-doctor mb-2" min="0" readonly value="0">
    
            <label>Monto Clínica</label>
            <input type="number" name="tratamientos[${index}][monto_clinica]" class="form-control monto-clinica mb-2" min="0" readonly value="0">

            <button type="button" class="btn btn-danger btn-remove-row" onclick="removeRowTratamiento(this)">Eliminar</button>
        `;

        contenedor.appendChild(nuevoTratamiento);
        inicializarEventosTratamientos(); // Reasignar eventos a los nuevos tratamientos
    }

    function removeRowTratamiento(button) {
        const contenedor = document.getElementById("contenedor-tratamientos");
        const row = button.closest('.tratamientos');
        row.remove();
    
        // Reasignar los índices de los tratamientos restantes
        const tratamientos = document.querySelectorAll(".tratamientos");
        tratamientos.forEach((tratamiento, newIndex) => {
            tratamiento.setAttribute("data-index", newIndex);
            
            // Actualizar los nombres de los inputs
            tratamiento.querySelectorAll("input, select").forEach(input => {
                if (input.name.includes("tratamientos[")) {
                    input.name = input.name.replace(/\d+/, newIndex);
                }
            });
    
            // Actualizar la etiqueta del tratamiento
            const label = tratamiento.querySelector("label:first-of-type");
            if (label) {
                label.textContent = `Tratamiento ${newIndex + 1}`;
            }
        });
    }

    function tratamientosOptions() {
        let options = "";
        tratamientosDisponibles.forEach(tratamiento => {
            options += `<option value="${tratamiento.id}" data-costo="${tratamiento.costo}">${tratamiento.nombre}</option>`;
        });
        return options;
    }
    function calcularPorcentajeDoctorParaTratamientosPrevios(tratamientoDiv) {
        let costo = parseFloat(tratamientoDiv.querySelector(".costo-tratamiento").value) || 0;
        let montoDoctor = parseFloat(tratamientoDiv.querySelector(".monto-doctor").value) || 0;
        let montoMateriales = parseFloat(tratamientoDiv.querySelector(".monto-materiales").value) || 0;
        let cantidad = parseFloat(tratamientoDiv.querySelector(".cantidad-tratamiento").value) || 0;
        
        let costoTotal = cantidad * costo;
        let restante = costoTotal - montoMateriales;
    
        // Solo calculamos el porcentaje_doctor si ya hay un monto_doctor (tratamiento previo)
        if (restante > 0 && montoDoctor > 0) {
            let porcentajeDoctor = (montoDoctor / restante) * 100;
            tratamientoDiv.querySelector(".porcentaje-doctor").value = porcentajeDoctor;
        }
    }

    document.getElementById('form-edit-consulta').addEventListener('submit', (event) => {
        const rows = document.querySelectorAll('.tratamientos');
        let valid = true;
    
        rows.forEach(row => {
            const montoClinica = parseFloat(row.querySelector('.monto-clinica').value) || 0;
    
            // Si el monto de la clínica es negativo, mostrar error
            if (montoClinica < 0) {
                valid = false;
                row.querySelector('.monto-clinica').classList.add("is-invalid");
                if (!row.querySelector(".mensaje-error-clinica")) {
                    const errorMensaje = document.createElement("div");
                    errorMensaje.classList.add("mensaje-error-clinica", "text-danger", "mt-2");
                    errorMensaje.textContent = "El monto de la clínica no puede ser negativo.";
                    row.appendChild(errorMensaje);
                }
            }
        });
    
        if (!valid) {
            event.preventDefault(); // Impide el envío del formulario si hay campos inválidos
        }
    });
</script>
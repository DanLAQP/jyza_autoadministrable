<div class="container mt-4">
    
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-tooth"></i> Registrar Consulta</h3>
    </div>
    <?= $this->Form->create($registros, ['id' => 'form-add-consulta']) ?>
    
    <!-- Buscador de Paciente -->
    <div class="col-md-10 mx-auto mb-3">
        <label for="searchPaciente" class="form-label">Buscar Paciente</label>
        <div class="input-group">
            <?= $this->Form->text('search_paciente', [
                'label' => false,
                'class' => 'form-control',
                'id' => 'searchPaciente',
                'placeholder' => 'Ingrese el nombre o apellido del paciente',
                'required' => true,
                'value' => $pacienteSeleccionado ? "{$pacienteSeleccionado->nombre} {$pacienteSeleccionado->apellido}" : '', // Mostrar nombre si ya está preseleccionado
                'readonly' => $pacienteSeleccionado ? true : false // Bloquear el input si viene por URL
            ]) ?>
            <button type="button" id="searchButton" class="btn btn-primary" <?= $pacienteSeleccionado ? 'disabled' : '' ?>>
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
        <div id="pacienteResults" class="list-group mt-2"></div>
<?= $this->Form->hidden('paciente_id', [
    'id' => 'pacienteId',
    'value' => $pacienteSeleccionado ? $pacienteSeleccionado->id : ''
]) ?>
    </div>

    <!-- Selector de Doctor -->
    <div class="col-md-10 mx-auto mb-3">
        <label for="doctor-id" class="form-label">Doctor</label>
        <?= $this->Form->select('doctor_id', $doctores, [
            'empty' => 'Seleccione un doctor',
            'id' => 'doctor-id',
            'class' => 'form-control',
            'value' => $doctorId, // Asigna el doctor automáticamente si el usuario es un doctor
            'disabled' => isset($doctorId), // Deshabilita la selección si el usuario es doctor
        ]) ?>
    
        <?php if (isset($doctorId)): ?>
            <?= $this->Form->hidden('doctor_id', ['value' => $doctorId]); ?>
        <?php endif; ?>
    </div>
    
    <!-- Campo de Tipo Pago -->
    <div class="col-md-10 mx-auto mb-3">
    <?= $this->Form->control('tipo_pago', [
        'type' => 'select',
        'options' => [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia',
            'tarjeta' => 'Tarjeta'
        ],
        'class' => 'form-control tipo-pago',
        'label' => 'Tipo de Pago'
    ]) ?>
    </div>
    <!-- Campo de Observaciones -->
    <div class="col-md-10 mx-auto mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <?= $this->Form->control('observaciones', [
            'id' => 'observaciones',
            'type' => 'text',
            'class' => 'form-control',
            'label' => false,
        ]) ?>
    </div>
    <div class="col-md-10 mx-auto mb-3">
        <div id="contenedor-tratamientos"></div>
    </div>
    <div class="col-md-10 mx-auto mb-3">
        <button type="button" id="agregar-tratamiento" class="btn btn-primary" onclick="addTratamiento()">Agregar Tratamiento</button>
    </div>
    <div class="col-12 mt-3 text-center">
        
        <button type="submit" id="submitButton" class="btn btn-info mt-3">Guardar</button>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary mt-3']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<script>
    // Cargar los datos de tratamientos desde PHP
    const tratamientos = <?= json_encode($tratamientos) ?>;
    
    let index = 0; // Contador para los tratamientos
    
    function addTratamiento() {
        const contenedor = document.getElementById("contenedor-tratamientos");
    
        const div = document.createElement("div");
        const doctorIdInput = document.getElementById("doctor-id") || document.querySelector('input[name="doctor_id"]');
        const doctorId = parseInt(doctorIdInput?.value || "0");
        const porcentaje = (doctorId === 2 || doctorId === 5) ? 45 : 40;
        div.className = "tratamiento-row mb-3 p-3 border rounded";
    
        div.innerHTML = `
            <label>Tratamiento ${index + 1}</label>
            <input type="text" name="tratamientos[${index}][tratamiento_name]" class="form-control mb-2 tratamiento-search" placeholder="Escriba para buscar tratamiento" autocomplete="off">
            <input type="hidden" name="tratamientos[${index}][tratamiento_id]" class="tratamiento-id" value="">
    
            <ul class="tratamiento-suggestions" style="list-style-type: none; padding-left: 0; margin-top: 5px; max-height: 150px; overflow-y: auto;"></ul>
    
            <label>Costo</label>
            <input type="text" name="tratamientos[${index}][costo]" class="form-control costo-tratamiento mb-2" />
    
            <label>Cantidad</label>
            <input type="text" name="tratamientos[${index}][cantidad]" class="form-control cantidad-tratamiento mb-2" step="0.01" min="0" value="1" />
    
            <div class="costo-total-container p-2 border rounded">
                <strong>Costo Total:</strong> <span class="costo-total">0.00</span>
            </div>            
    
            <label>Monto Materiales (S/)</label>
            <input type="number" name="tratamientos[${index}][monto_materiales]" class="form-control monto-materiales mb-2" step="0.01" min="0" value="0" />
            
            <label>Porcentaje Doctor (%)</label>
            <input type="number" name="tratamientos[${index}][porcentaje_doctor]" class="form-control porcentaje-doctor mb-2" step="0.01" min="0" max="100" value="${porcentaje}" />
            
            <label>Monto Doctor (S/)</label>
            <input type="text" name="tratamientos[${index}][monto_doctor]" class="form-control monto-doctor mb-2" readonly />
            
            <label>Monto Clínica (S/)</label>
            <input type="text" name="tratamientos[${index}][monto_clinica]" class="form-control monto-clinica mb-2" readonly />
    
            <button type="button" class="btn btn-danger btn-remove-row mt-2" onclick="removeRowTratamiento(this)">Eliminar</button>
        `;
    
        // Agregar el tratamiento al contenedor
        contenedor.appendChild(div);
    
        // Agregar los eventos a los campos recién creados
        const searchInput = div.querySelector('.tratamiento-search');
        const suggestionsList = div.querySelector('.tratamiento-suggestions');
        const inputCosto = div.querySelector('.costo-tratamiento');
        const inputPorcentajeDoctor = div.querySelector('.porcentaje-doctor');
        const inputMontoDoctor = div.querySelector('.monto-doctor');
        const inputMontoMateriales = div.querySelector('.monto-materiales');
        const inputMontoClinica = div.querySelector('.monto-clinica');
        const inputCantidad = div.querySelector('.cantidad-tratamiento');
        const costoTotalSpam = div.querySelector('.costo-total');
    
        // Filtrar las sugerencias a medida que el usuario escribe
        searchInput.addEventListener("input", () => {
            const searchText = searchInput.value.toLowerCase();
            suggestionsList.innerHTML = tratamientos
                .filter(t => t.nombre.toLowerCase().includes(searchText))
                .map(t => `
                    <li class="tratamiento-item" 
                        data-id="${t.id}" 
                        data-costo="${t.costo}" 
                        style="padding: 10px; cursor: pointer; transition: background-color 0.3s;" 
                        onmouseover="this.style.backgroundColor='#111';" 
                        onmouseout="this.style.backgroundColor='';">
                        ${t.nombre}
                    </li>`).join('');
        });
    
        // Seleccionar un tratamiento al hacer clic en la sugerencia
        suggestionsList.addEventListener("click", (event) => {
            const selectedItem = event.target.closest(".tratamiento-item");
            if (!selectedItem) return;
    
            const tratamientoId = selectedItem.getAttribute("data-id");
            const tratamientoName = selectedItem.textContent.trim();
            const costo = parseFloat(selectedItem.getAttribute("data-costo")) || 0;
    
            // Establecer el nombre en el input de búsqueda
            searchInput.value = tratamientoName;
            // Establecer el ID en el campo oculto
            div.querySelector("input[name^='tratamientos'][name$='[tratamiento_id]']").value = tratamientoId;
            // Establecer el costo
            inputCosto.value = costo.toFixed(2);
    
            // Ocultar las sugerencias
            suggestionsList.innerHTML = '';
            calcularMontos(div);
        });
    
        // Otros eventos (Materiales, Porcentaje Doctor, Costo, etc.)
        inputMontoMateriales.addEventListener("input", () => {
            if (parseFloat(inputMontoMateriales.value) < 0) {
                inputMontoMateriales.value = 0;
            }
            calcularMontos(div);
        });
    
        inputPorcentajeDoctor.addEventListener("input", () => {
            if (parseFloat(inputPorcentajeDoctor.value) < 0) {
                inputPorcentajeDoctor.value = 0;
            } else if (parseFloat(inputPorcentajeDoctor.value) > 100) {
                inputPorcentajeDoctor.value = 100;
            }
            calcularMontos(div);
        });
    
        inputCosto.addEventListener("input", () => {
            if (parseFloat(inputCosto.value) < 0) {
                inputCosto.value = 0;
            }
            calcularMontos(div);
        });
    
        inputCantidad.addEventListener("input", () => {
            if (parseFloat(inputCantidad.value) < 0) {
                inputCantidad.value = 1;
            }
            calcularMontos(div);
        });
    
        index++;
    }    
    
    function calcularMontos(row) {
        const costoTratamiento = parseFloat(row.querySelector(".costo-tratamiento").value) || 0;
        const porcentajeDoctor = parseFloat(row.querySelector(".porcentaje-doctor").value) || 0;
        const montoMateriales = parseFloat(row.querySelector(".monto-materiales").value) || 0;
        const cantidad = parseFloat(row.querySelector(".cantidad-tratamiento").value) || 0;

        const costoTotal = costoTratamiento * cantidad;
        row.querySelector(".costo-total").textContent = costoTotal.toFixed(2);
        const restante = costoTotal - montoMateriales;
        const montoDoctor = (restante * porcentajeDoctor) / 100;
        const montoClinica = restante - montoDoctor
    
        row.querySelector(".monto-doctor").value = montoDoctor.toFixed(2);
        row.querySelector(".monto-clinica").value = montoClinica.toFixed(2);

        if (montoClinica < 0) {
            row.querySelector(".monto-clinica").classList.add("is-invalid");
            if (!row.querySelector(".mensaje-error-clinica")) {
                const errorMensaje = document.createElement("div");
                errorMensaje.classList.add("mensaje-error-clinica", "text-danger", "mt-2");
                errorMensaje.textContent = "El monto de la clínica no puede ser negativo.";
                row.appendChild(errorMensaje);
            }
        } else {
            row.querySelector(".monto-clinica").classList.remove("is-invalid");
            const errorMensaje = row.querySelector(".mensaje-error-clinica");
            if (errorMensaje) {
                errorMensaje.remove();
            }
        }
    }
    
    function removeRowTratamiento(button) {
        const contenedor = document.getElementById("contenedor-tratamientos");
        const row = button.closest('.tratamiento-row');
        contenedor.removeChild(row);
    
        // Obtener todas las filas restantes
        const rows = document.querySelectorAll('.tratamiento-row');
    
        // Recorrer cada fila y actualizar los índices correctamente
        rows.forEach((row, newIndex) => {
            row.querySelector("label").textContent = `Tratamiento ${newIndex + 1}`;
            
            row.querySelector("input[name^='tratamientos'][name$='[tratamiento_name]']").setAttribute("name", `tratamientos[${newIndex}][tratamiento_name]`);
            row.querySelector("input[name^='tratamientos'][name$='[tratamiento_id]']").setAttribute("name", `tratamientos[${newIndex}][tratamiento_id]`);
            row.querySelector("input[name^='tratamientos'][name$='[costo]']").setAttribute("name", `tratamientos[${newIndex}][costo]`);
            row.querySelector("input[name^='tratamientos'][name$='[cantidad]']").setAttribute("name", `tratamientos[${newIndex}][cantidad]`);
            row.querySelector("input[name^='tratamientos'][name$='[monto_materiales]']").setAttribute("name", `tratamientos[${newIndex}][monto_materiales]`);
            row.querySelector("input[name^='tratamientos'][name$='[porcentaje_doctor]']").setAttribute("name", `tratamientos[${newIndex}][porcentaje_doctor]`);
            row.querySelector("input[name^='tratamientos'][name$='[monto_doctor]']").setAttribute("name", `tratamientos[${newIndex}][monto_doctor]`);
            row.querySelector("input[name^='tratamientos'][name$='[monto_clinica]']").setAttribute("name", `tratamientos[${newIndex}][monto_clinica]`);
        });
    
        // Actualizar el índice global con la cantidad actual de tratamientos
        index = rows.length;
    }    
    
    document.getElementById('form-add-consulta').addEventListener('submit', (event) => {
        const rows = document.querySelectorAll('.tratamiento-row');
        let valid = true;
    
        rows.forEach(row => {
            const montoClinica = parseFloat(row.querySelector('.monto-clinica').value) || 0;
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
<script>
    $(document).ready(function() {
        $(document).on("submit", "form", function(event) {
            const form = $(this)[0]; 
            const btnGuardar = $(this).find("#submitButton");

            if (!form.checkValidity()) {
                event.preventDefault(); // Evita el envío si hay errores en el formulario
                return;
            }

            btnGuardar.prop("disabled", true).text("Guardando...");
        });

        // Detecta cambios en los archivos dentro del modal o cualquier formulario
        $(document).on("change", "input[type='file']", function() {
            const btnGuardar = $(this).closest("form").find("#submitButton");
            if (this.files.length > 0) {
                btnGuardar.prop("disabled", false);
            }
        });
    });

</script>
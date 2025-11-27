// Inicializar los índices para cada tipo de antecedente
let medicoIndex = document.querySelectorAll(".antecedente-medico").length;
let totalMedicoIndex = document.querySelectorAll(".antecedente-medico").length;
let odontologicoIndex = document.querySelectorAll(".antecedente-odontologico").length;
let totalOdontoIndex = document.querySelectorAll(".antecedente-odontologico").length;

// Función para añadir un nuevo antecedente médico
function addAntecedenteMedico() {
    const container = document.getElementById("antecedentes-medicos-container");
    const newDiv = document.createElement("div");
    newDiv.className = "antecedente-medico";
    const controlHTML = `
        <h5 class="text-info">Antecedente Médico #${medicoIndex + 1}</h5>
        <div class="row g-3">
            <!-- Alergias -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Alergias</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][alergias]" class="form-control">
            </div>
            <!-- Medicación -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Medicación</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][medicacion]" class="form-control">
            </div>
            <!-- Médico -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre del Médico</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][nombre_medico]" class="form-control">
            </div>
            <!-- Teléfono -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono del Médico</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][telefono_medico]" class="form-control">
            </div>
            <!-- Hepatitis -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Hepatitis</label>
                <div class="radio-group d-flex gap-4">
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][hepatitis]" id="hepatitis_si_${medicoIndex}" value="si" class="form-check-input">
                        <label for="hepatitis_si_${medicoIndex}" class="form-check-label ms-2">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][hepatitis]" id="hepatitis_no_${medicoIndex}" value="no" class="form-check-input">
                        <label for="hepatitis_no_${medicoIndex}" class="form-check-label ms-2">No</label>
                    </div>
                </div>
            </div>
            <!-- Tipo de Hepatitis -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Tipo de Hepatitis</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][tipo_hepatitis]" class="form-control">
            </div>
            <!-- Diabetes -->
            <div class="col-md-6 mb-3">
                <label class="form-label">¿Diabetes?</label>
                <div class="radio-group d-flex gap-4">
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][diabetes]" id="diabetes_si_${medicoIndex}" value="si" class="form-check-input">
                        <label for="diabetes_si_${medicoIndex}" class="form-check-label ms-2">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][diabetes]" id="diabetes_no_${medicoIndex}" value="no" class="form-check-input">
                        <label for="diabetes_no_${medicoIndex}" class="form-check-label ms-2">No</label>
                    </div>
                </div>
            </div>
            <!-- Estado de Diabetes -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Estado de la Diabetes</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][diabetes_estado]" class="form-control">
            </div>
            <!-- Condición Cardíaca -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Condición Cardíaca</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][condicion_cardiaca]" class="form-control">
            </div>
            <!-- Tratamiento Cardíaco -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Tratamiento Cardíaco</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][tratamiento_cardiaco]" class="form-control">
            </div>
            <!-- Presión Alta -->
            <div class="col-md-6 mb-3">
                <label class="form-label">¿Presión Alta?</label>
                <div class="radio-group d-flex gap-4">
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][presion_alta]" id="presion_alta_si_${medicoIndex}" value="si" class="form-check-input">
                        <label for="presion_alta_si_${medicoIndex}" class="form-check-label ms-2">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][presion_alta]" id="presion_alta_no_${medicoIndex}" value="no" class="form-check-input">
                        <label for="presion_alta_no_${medicoIndex}" class="form-check-label ms-2">No</label>
                    </div>
                </div>
            </div>
            <!-- Riesgo de Enfermedad -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Riesgo de Enfermedad</label>
                <input type="text" name="antecedentes_medicos[${medicoIndex}][enfermedad_riesgo]" class="form-control">
            </div>
            <!-- Estado de Gestación -->
            <div class="col-md-12 mb-3">
                <label class="form-label">¿Estado de Gestación?</label>
                <div class="radio-group d-flex gap-4">
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][estado_gestacion]" id="estado_gestacion_si_${medicoIndex}" value="si" class="form-check-input">
                        <label for="estado_gestacion_si_${medicoIndex}" class="form-check-label ms-2">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="antecedentes_medicos[${medicoIndex}][estado_gestacion]" id="estado_gestacion_no_${medicoIndex}" value="no" class="form-check-input">
                        <label for="estado_gestacion_no_${medicoIndex}" class="form-check-label ms-2">No</label>
                    </div>
                </div>
            </div>
        </div>
    `;

    newDiv.innerHTML = controlHTML;
    container.appendChild(newDiv);
    medicoIndex++;
}

// Función para añadir un nuevo antecedente odontológico

function addAntecedenteOdontologico() {
    const container = document.getElementById(
        "antecedentes-odontologicos-container"
    );
    const newDiv = document.createElement("div");
    newDiv.className = "antecedente-odontologico";

    const controlHTML = `
        <h5 class="text-info">Antecedente Odontológico #${
            odontologicoIndex + 1
        }</h5>
        <div class="row g-3">
            <!-- Motivo de Consulta -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-motivo-consulta">Motivo de Consulta</label>
                <input 
                    type="text" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][motivo_consulta]" 
                    id="odontologico-${odontologicoIndex}-motivo_consulta" 
                    class="form-control">
            </div>

            <!-- Frecuencia de Visita -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-frecuencia-visita">Frecuencia de Visita</label>
                <input 
                    type="text" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][frecuencia_visita]" 
                    id="odontologico-${odontologicoIndex}-frecuencia-visita" 
                    class="form-control">
            </div>

            <!-- Experiencia Traumática -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-experiencia-traumatica">Experiencia Traumática</label>
                <input 
                    type="text" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][experiencia_traumatica]" 
                    id="odontologico-${odontologicoIndex}-experiencia_traumatica" 
                    class="form-control">
            </div>

            <!-- Extracciones Dentales -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-extracciones-dentales">Extracciones Dentales</label>
                <input 
                    type="text" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][extracciones_dentales]" 
                    id="odontologico-${odontologicoIndex}-extracciones_dentales" 
                    class="form-control">
            </div>

            <!-- Complicaciones con Anestesia -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-complicaciones-anestesia">Complicaciones con Anestesia</label>
                <input 
                    type="text" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][complicaciones_anestesia]" 
                    id="odontologico-${odontologicoIndex}-complicaciones_anestesia" 
                    class="form-control">
            </div>

            <!-- Sangrado de Encías -->
            <div class="col-md-6 mb-3">
                <label class="form-label">¿Sufre Sangrado de Encías?</label>
                <div class="radio-group d-flex gap-4">
                    <!-- Opción Sí -->
                    <div class="form-check">
                        <input 
                            type="radio" 
                            name="antecedentes_odontologicos[${odontologicoIndex}][sangrado_encias]" 
                            id="odontologico-${odontologicoIndex}-sangrado-encias-si" 
                            value="si" 
                            class="form-check-input">
                        <label for="odontologico-${odontologicoIndex}-sangrado-encias-si" class="form-check-label ms-2">Sí</label>
                    </div>
                    <!-- Opción No -->
                    <div class="form-check">
                        <input 
                            type="radio" 
                            name="antecedentes_odontologicos[${odontologicoIndex}][sangrado_encias]" 
                            id="odontologico-${odontologicoIndex}-sangrado-encias-no" 
                            value="no" 
                            class="form-check-input">
                        <label for="odontologico-${odontologicoIndex}-sangrado-encias-no" class="form-check-label ms-2">No</label>
                    </div>
                </div>
            </div>

            <!-- Fecha de Última Profilaxis -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-fecha-profilaxis">Fecha de Última Profilaxis</label>
                <input 
                    type="date" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][fecha_ultima_profilaxis]" 
                    id="odontologico-${odontologicoIndex}-fecha-profilaxis" 
                    class="form-control"
                    max="date('Y-m-d')">
            </div>

            <!-- Dolor en la Mandíbula -->
            <div class="col-md-6 mb-3">
                <label class="form-label">¿Tiene Dolor en la Mandíbula?</label>
                <div class="radio-group d-flex gap-4">
                    <!-- Opción Sí -->
                    <div class="form-check">
                        <input 
                            type="radio" 
                            name="antecedentes_odontologicos[${odontologicoIndex}][dolor_mandibula]" 
                            id="odontologico-${odontologicoIndex}-dolor-mandibula-si" 
                            value="si" 
                            class="form-check-input">
                        <label for="odontologico-${odontologicoIndex}-dolor-mandibula-si" class="form-check-label ms-2">Sí</label>
                    </div>
                    <!-- Opción No -->
                    <div class="form-check">
                        <input 
                            type="radio" 
                            name="antecedentes_odontologicos[${odontologicoIndex}][dolor_mandibula]" 
                            id="odontologico-${odontologicoIndex}-dolor-mandibula-no" 
                            value="no" 
                            class="form-check-input">
                        <label for="odontologico-${odontologicoIndex}-dolor-mandibula-no" class="form-check-label ms-2">No</label>
                    </div>
                </div>
            </div>

            <!-- Satisfacción Dental -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="odontologico-${odontologicoIndex}-satisfaccion-dental">Satisfacción Dental</label>
                <input 
                    type="text" 
                    name="antecedentes_odontologicos[${odontologicoIndex}][satisfaccion_dental]" 
                    id="odontologico-${odontologicoIndex}-satisfaccion-dental" 
                    class="form-control">
            </div>
        </div>
    `;

    newDiv.innerHTML = controlHTML;
    container.appendChild(newDiv);
    odontologicoIndex++;
}

function removeRowMedicos() {
    const container = document.getElementById("antecedentes-medicos-container");
    if (medicoIndex == totalMedicoIndex) {
        medicoIndex = totalMedicoIndex;
    } else {
        medicoIndex--;
        container.removeChild(container.lastChild);
    }
}

function removeRowOdontologicos() {
    const container = document.getElementById(
        "antecedentes-odontologicos-container"
    );
    if (odontologicoIndex == totalOdontoIndex) {
        odontologicoIndex = totalOdontoIndex;
    } else {
        container.removeChild(container.lastChild);
        odontologicoIndex--;
    }
}

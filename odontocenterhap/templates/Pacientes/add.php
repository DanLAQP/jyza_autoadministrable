<div class="container mt-5 mb-4">
    <?= $this->Form->create($paciente, ['class' => 'row g-3']) ?>

    <!-- Id de pacientes1 oculto -->
        <?= $this->Form->hidden('paciente_id', ['value' => $paciente->paciente_id]) ?>


        <!-- Información Personal -->
        <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user"></i> Agregar información del Paciente</h3>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('dni', ['label' => 'Dni', 'class' => 'form-control', 'pattern' => '^[0-9]{0,20}$', 'title' => 'Debe ser un número de 8 o 20 dígitos', 'required' => true]) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('ruc', ['label' => 'Ruc', 'class' => 'form-control', 'pattern' => '[0-9]{11}', 'title' => 'Debe ser un número de 11 dígitos']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('fecha_nacimiento', ['label' => 'Fecha de Nacimiento', 'type' => 'date', 'class' => 'form-control', 'max' => date('Y-m-d')]) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('sexo', [
            'label' => 'Sexo',
            'type' => 'select',
            'empty' => 'Seleccione una opción',
            'options' => ['M' => 'Masculino', 'F' => 'Femenino'],
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('edad', ['label' => 'Edad', 'class' => 'form-control', 'readonly' => true]) ?>
    </div>

    <div class="col-md-6 mb-3">
        <?= $this->Form->control('nombre_apoderado', ['label' => 'Nombre del Apoderado', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('parentesco_apoderado', ['label' => 'Parentesco del Apoderado', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('direccion', ['label' => 'Dirección', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('distrito', ['label' => 'Distrito', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('codigo_postal', ['label' => 'Código Postal', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('centro_trabajo', ['label' => 'Centro de Trabajo', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('centro_estudio', ['label' => 'Centro de Estudio', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('recomendacion', ['label' => 'Recomendado por:', 'class' => 'form-control']) ?>
    </div>
</div>
<!-- Contactos de Emergencia -->
<div class="container mt-4 mb-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-ligth" style="font-size: 1.05rem;">
            <i class="fas fa-phone me-2"></i> Contactos de Emergencia
        </summary>

        <fieldset class="mt-3">
            <div id="contactos-emergencia-container">
                <div class="contacto-emergencia">
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('contactos_emergencia.0.medico_confianza', [
                                'label' => 'Médico de Confianza',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('contactos_emergencia.0.servicio_ambulancia', [
                                'label' => 'Servicio de Ambulancia',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('contactos_emergencia.0.nombre_contacto', [
                                'label' => 'Nombre del Contacto',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('contactos_emergencia.0.telefono_contacto', [
                                'label' => 'Teléfono del Contacto',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </details>
</div>

<!-- Enfermedades Actuales -->
<div class="container mt-4 mb-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-ligth" style="font-size: 1.05rem;">
            <i class="fas fa-user-md me-2"></i> Enfermedades Actuales
        </summary>
        <fieldset class="mt-3">
            <div id="enfermedades-container">
                <div class="enfermedad-actual">
                    <div class="row g-3">
                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('enfermedades_actuales.0.enfermedad', [
                                'label' => 'Enfermedad',
                                'type' => 'textarea',
                                'class' => 'form-control textarea-adjust',
                                'style' => 'height: 38px;',
                            ]) ?>
                        </div>
                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('enfermedades_actuales.0.tiempo_enfermedad', [
                                'label' => 'Tiempo de Enfermedad',
                                'class' => 'form-control',
                            ]) ?>
                        </div>
                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('enfermedades_actuales.0.sintomas_principales', [
                                'label' => 'Síntomas Principales',
                                'type' => 'textarea',
                                'class' => 'form-control textarea-adjust',
                                'style' => 'height: 38px;'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </details>
</div>


<!-- Sección para añadir antecedentes médicos -->
<div class="container mt-4 mb-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-ligth" style="font-size: 1.05rem;">
            <i class="fas fa-notes-medical me-2"></i> Antecedentes Médicos
        </summary>
        <fieldset id="antecedentes-medicos-section" class="mt-3">
            <div id="antecedentes-medicos-container">
                <div class="antecedente-medico">
                    
                    <div class="row g-3">
                        <!-- Alergias -->
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][alergias]', [
                                'label' => 'Alergias',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Medicación -->
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][medicacion]', [
                                'label' => 'Medicación',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Médico -->
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][nombre_medico]', [
                                'label' => 'Médico',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][telefono_medico]', [
                                'label' => 'Teléfono',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Hepatitis -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hepatitis</label>
                            <div class="radio-group">
                                <!-- Opción Sí -->
                                <div class="form-check">
                                    <input type="radio" name="antecedentes_medicos[0][hepatitis]" id="hepatitis_si" value="si" class="form-check-input">
                                    <label for="hepatitis_si" class="form-check-label">Sí</label>
                                </div>
                                <!-- Opción No -->
                                <div class="form-check">
                                    <input type="radio" name="antecedentes_medicos[0][hepatitis]" id="hepatitis_no" value="no" class="form-check-input">
                                    <label for="hepatitis_no" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <!-- Tipo de Hepatitis -->
                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][tipo_hepatitis]', [
                                'label' => 'Tipo de Hepatitis',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Diabetes -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">¿Diabetes?</label>
                            <div class="radio-group d-flex gap-4">
                                <!-- Opción Sí -->
                                <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_medicos[0][diabetes]" id="diabetes_si" value="si" class="form-check-input">
                                    <label for="diabetes_si" class="form-check-label ms-2">Sí</label>
                                </div>
                                <!-- Opción No -->
                                <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_medicos[0][diabetes]" id="diabetes_no" value="no" class="form-check-input">
                                    <label for="diabetes_no" class="form-check-label ms-2">No</label>
                                </div>
                            </div>
                        </div>

                        <!-- Estado de Diabetes -->
                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][diabetes_estado]', [
                                'label' => 'Estado de Diabetes',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        
                        <!-- condicion_cardiaca -->
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][condicion_cardiaca]', [
                                'label' => 'Condicion Cardiaca',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <!-- tratamiento cardiaco -->
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][tratamiento_cardiaco]', [
                                'label' => 'Tratamiento Cardiaco',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Presión Alta -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">¿Presión Alta?</label>
                            <div class="radio-group d-flex gap-4">
                                <!-- Opción Sí -->
                                <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_medicos[0][presion_alta]" id="presion_alta_si" value="si" class="form-check-input">
                                    <label for="presion_alta_si" class="form-check-label ms-2">Sí</label>
                                </div>
                                <!-- Opción No -->
                                <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_medicos[0][presion_alta]" id="presion_alta_no" value="no" class="form-check-input">
                                    <label for="presion_alta_no" class="form-check-label ms-2">No</label>
                                </div>
                            </div>
                        </div>

                        <!-- Riesgo de Enfermedad -->
                        <div class="col-md-12 mb-3">
                            <?= $this->Form->control('antecedentes_medicos[0][enfermedad_riesgo]', [
                                'label' => 'Riesgo de Enfermedad',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <!-- Estado de Gestación -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">¿Estado de Gestación?</label>
                            <div class="radio-group d-flex gap-4">
                                <!-- Opción Sí -->
                                <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_medicos[0][estado_gestacion]" id="estado_gestacion_si" value="si" class="form-check-input">
                                    <label for="estado_gestacion_si" class="form-check-label ms-2">Sí</label>
                                </div>
                                <!-- Opción No -->
                                <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_medicos[0][estado_gestacion]" id="estado_gestacion_no" value="no" class="form-check-input">
                                    <label for="estado_gestacion_no" class="form-check-label ms-2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </details>                 
</div>

<!-- Sección para añadir antecedentes odontológicos -->
<div class="container mt-4 mb-4">
<details class="border p-3 mb-3">
<summary class="fw-bold text-light" style="font-size: 1.05rem;">
    <i class="fas fa-tooth me-2"></i> Antecedentes Odontológicos
</summary>

    <fieldset id="antecedentes-odontologicos-section" class="mt-3">
        <div id="antecedentes-odontologicos-container">
            <div class="antecedente-odontologico">
                
                <div class="row g-3">
                    <!-- Motivo de Consulta -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][motivo_consulta]', [
                            'label' => 'Motivo de Consulta',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <!-- Frecuencia de Visita -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][frecuencia_visita]', [
                            'label' => 'Frecuencia de Visita',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <!-- Experiencia Traumática -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][experiencia_traumatica]', [
                            'label' => 'Experiencia Traumática',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <!-- Extracciones Dentales -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][extracciones_dentales]', [
                            'label' => 'Extracciones Dentales',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <!-- Complicaciones con Anestesia -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][complicaciones_anestesia]', [
                            'label' => 'Complicaciones con Anestesia',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <!-- Sufre Sangrado de Encías -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">¿Sufre Sangrado de Encías?</label>
                        <div class="radio-group d-flex gap-4">
                            <div class="form-check">
                                <input type="radio" name="antecedentes_odontologicos[0][sangrado_encias]" id="sangrado_encias" value="si" class="form-check-input">
                                <label for="sangrado_encias" class="form-check-label  ms-2">Sí</label>
                            </div>
                            <!-- Opción No -->
                            <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_odontologicos[0][sangrado_encias]" id="sangrado_encias_no" value="no" class="form-check-input">
                                    <label for="sangrado_encias_no" class="form-check-label ms-2">No</label>
                                </div>
                        </div>
                    </div>


                    <!-- Fecha de Última Profilaxis -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][fecha_ultima_profilaxis]', [
                            'type' => 'date',
                            'label' => 'Fecha de Última Profilaxis',
                            'class' => 'form-control',
                            'max' => date('Y-m-d')
                        ]) ?>
                    </div>

                    <!-- Dolor en la Mandíbula -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">¿Tiene Dolor en la Mandíbula?</label>
                        <div class="radio-group">
                            <div class="form-check">
                                <input type="radio" name="antecedentes_odontologicos[0][dolor_mandibula]" id="dolor_mandibula" value="si" class="form-check-input">
                                <label for="dolor_mandibula" class="form-check-label">Sí</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                                    <input type="radio" name="antecedentes_odontologicos[0][dolor_mandibula]" id="dolor_mandibula_no" value="no" class="form-check-input">
                                    <label for="dolor_mandibula_no" class="form-check-label ms-2">No</label>
                                </div>
                        </div>
                    </div>

                    <!-- Satisfacción Dental -->
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('antecedentes_odontologicos[0][satisfaccion_dental]', [
                            'label' => 'Satisfacción Dental',
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</details>
                         
</div>
<div class="container mt-4 mb-4 text-center">
   <?= $this->Form->button('Guardar', [
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'id' => 'btnGuardar'
    ]) ?>
    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], [
        'class' => 'btn btn-danger' // Estilo Bootstrap para el botón de cancelar
    ]) ?>
    <?= $this->Form->end() ?>                        
</div>

<!-- CSS personalizado -->
<style>
    .radio-group {
        display: flex;
        gap: 20px; /* Espaciado entre las opciones Sí y No */
        align-items: center; /* Asegura alineación vertical */
    }
    .radio-group .form-check {
        display: flex;
        align-items: center; /* Asegura que el texto esté alineado con el botón */
        gap: 8px; /* Espaciado entre el círculo del radio y el texto */
    }
</style>

<script>
    document.getElementById('fecha-nacimiento').addEventListener('change', function() {
        var fechaNacimiento = new Date(this.value);
        var hoy = new Date();
        var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        var mes = hoy.getMonth() - fechaNacimiento.getMonth();
    
        if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }
    
        document.getElementById('edad').value = edad;
    });

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form"); // Obtiene el formulario
        const btnGuardar = document.getElementById("btnGuardar");

        form.addEventListener("submit", function(event) {
            if (!form.checkValidity()) {
                event.preventDefault(); // Evita que el formulario se envíe si no es válido
                return;
            }
            btnGuardar.disabled = true;
            btnGuardar.innerText = "Guardando...";
        });
    });
</script>


<!-- Incluir el archivo JavaScript -->
<?= $this->Html->script('antecedentes.js') ?>
<?= $this->Html->script('contactos.js') ?>
<?= $this->Html->script('enfermedad.js') ?>
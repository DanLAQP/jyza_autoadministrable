<div class="container mt-5 mb-4">
    <!-- Formulario principal -->
    <?= $this->Form->create($paciente, ['class' => 'row g-3']) ?>

    <!-- Información Personal -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-user"></i> Editar Información del Paciente</h3>
    </div>

    <div class="col-md-6 mb-3">
        <?= $this->Form->control('pacientes1.nombre', ['label' => 'Nombre', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('pacientes1.apellido', ['label' => 'Apellido', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('fecha_nacimiento', ['label' => 'Fecha de Nacimiento', 'type' => 'date', 'class' => 'form-control', 'max' => date('Y-m-d')]) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('dni', ['label' => 'DNI', 'class' => 'form-control' , 'pattern' => '[0-9]{8}', 'title' => 'Debe ser un número de 8 dígitos']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('ruc', ['label' => 'RUC', 'class' => 'form-control', 'pattern' => '[0-9]{11}', 'title' => 'Debe ser un número de 11 dígitos']) ?>
    </div>
    <div class="col-md-3 mb-3">
        <?= $this->Form->control('sexo', [
            'label' => 'Sexo',
            'options' => ['M' => 'Masculino', 'F' => 'Femenino'],
            'class' => 'form-control',
            'value' => $paciente->sexo,
        ]) ?>
    </div>

    <div class="col-md-3 mb-3">
        <?= $this->Form->control('edad', ['label' => 'Edad', 'class' => 'form-control', 'type' => 'number',
        'min' => '0',
        'title' => 'Solo se permiten números enteros positivos',
        'readonly' => true]) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('pasaporte', ['label' => 'Pasaporte', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('carnet_extranjeria', ['label' => 'Carnet de Extranjeria', 'class' => 'form-control']) ?>
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
        <?= $this->Form->control('codigo_postal', ['label' => 'Código Postal', 'class' => 'form-control', 'pattern' => '[0-9]+', 'title' => 'Debe ser un número válido']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('telefono_oficina', ['label' => 'Teléfono Oficina', 'class' => 'form-control', 'pattern' => '[0-9]+', 'title' => 'Solo se permiten números']) ?>
    </div>
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('pacientes1.telefono_celular', ['label' => 'Teléfono Celular', 'class' => 'form-control', 'pattern' => '[0-9]+', 'title' => 'Solo se permiten números']) ?>
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

<!-- Contactos de Emergencia -->
<div class="container mt-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-light" style="font-size: 1.05rem;">
            <i class="fas fa-phone me-2"></i> Contactos de Emergencia
        </summary>
        <fieldset class="mt-3">
            <div id="contactos-emergencia-container">
                <?php foreach ($paciente->contactos_emergencia as $index => $contacto): ?>
                    <div class="contacto-emergencia">
                        <h5 class="text-info">Contacto de Emergencia #<?= $index + 1 ?></h5>
                        <div class="row g-3">
                            <!-- Campo Médico de Confianza -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("contactos_emergencia.{$index}.id", [
                                    'type' => 'hidden',
                                    'value' => $contacto->id,
                                ]) ?>
                                <?= $this->Form->control("contactos_emergencia.{$index}.medico_confianza", [
                                    'label' => 'Médico de Confianza',
                                    'value' => $contacto->medico_confianza,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Campo Servicio de Ambulancia -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("contactos_emergencia.{$index}.servicio_ambulancia", [
                                    'label' => 'Servicio de Ambulancia',
                                    'value' => $contacto->servicio_ambulancia,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Campo Nombre del Contacto -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("contactos_emergencia.{$index}.nombre_contacto", [
                                    'label' => 'Nombre del Contacto',
                                    'value' => $contacto->nombre_contacto,
                                    'class' => 'form-control',

                                ]) ?>
                            </div>

                            <!-- Campo Teléfono del Contacto -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("contactos_emergencia.{$index}.telefono_contacto", [
                                    'label' => 'Teléfono del Contacto',
                                    'value' => $contacto->telefono_contacto,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-secondary btn-sm" onclick="addContacto()">Agregar Contacto</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="removeRowContactos()">Remover Contacto</button>
            </div>
        </fieldset>
    </details>
</div>

<!-- Enfermedades Actuales -->
<div class="container mt-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-light" style="font-size: 1.05rem;">
            <i class="fas fa-user-md me-2"></i> Enfermedades Actuales
        </summary>

        <fieldset class="mt-3">
            <div id="enfermedades-container">
                <?php foreach ($paciente->enfermedades_actuales as $index => $enfermedad): ?>
                    <div class="enfermedad-actual">
                        <h5 class="text-info">Enfermedad Actual #<?= $index + 1 ?></h5>
                        <div class="row g-3">
                            <!-- Campo oculto para el ID de la enfermedad -->
                            <?= $this->Form->control("enfermedades_actuales.{$index}.id", [
                                'type' => 'hidden',
                                'value' => $enfermedad->id,
                            ]) ?>
                            <!-- Campo Enfermedad -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("enfermedades_actuales.{$index}.enfermedad", [
                                    'label' => 'Enfermedad',
                                    'value' => $enfermedad->enfermedad,
                                    'type' => 'textarea',
                                    'class' => 'form-control textarea-adjust',
                                    'style' => 'height: 38px;',
                                ]) ?>
                            </div>

                            <!-- Campo Tiempo de Enfermedad -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("enfermedades_actuales.{$index}.tiempo_enfermedad", [
                                    'label' => 'Tiempo de Enfermedad',
                                    'value' => $enfermedad->tiempo_enfermedad,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Campo Síntomas Principales -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("enfermedades_actuales.{$index}.sintomas_principales", [
                                    'label' => 'Síntomas Principales',
                                    'value' => $enfermedad->sintomas_principales,
                                    'type' => 'textarea',
                                    'class' => 'form-control textarea-adjust',
                                    'style' => 'height: 38px;',
                                ]) ?>
                            </div>

                            <!-- Campo Fecha de Registro -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("enfermedades_actuales.{$index}.created", [
                                    'label' => 'Fecha de Registro',
                                    'value' => $enfermedad->created->format('Y-m-d H:i'),
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'disabled' => true, // Solo lectura
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-secondary btn-sm" onclick="addEnfermedad()">Agregar Enfermedad</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="removeRowEnfermedad()">Remover Enfermedad</button>
            </div>
        </fieldset>
    </details>
</div>

<!-- Antecedentes Médicos -->
<div class="container mt-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-light" style="font-size: 1.05rem;">
            <i class="fas fa-notes-medical me-2"></i> Antecedentes Médicos
        </summary>
        <fieldset id="antecedentes-medicos-section" class="mt-3">
            <div id="antecedentes-medicos-container">
                <?php foreach ($paciente->antecedentes_medicos as $index => $antecedente): ?>
                    <div class="antecedente-medico">
                        <h5>Antecedente Médico #<?= $index + 1 ?></h5>
                        <div class="row g-3">
                            <!-- Campo oculto para el ID del antecedente médico -->
                            <?= $this->Form->control("antecedentes_medicos.{$index}.id", [
                                'type' => 'hidden',
                                'value' => $antecedente->id,
                            ]) ?>
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.alergias", [
                                    'label' => 'Alergias',
                                    'value' => $antecedente->alergias,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Medicación -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.medicacion", [
                                    'label' => 'Medicación',
                                    'value' => $antecedente->medicacion,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Médico -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.nombre_medico", [
                                    'label' => 'Médico',
                                    'value' => $antecedente->nombre_medico,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.telefono_medico", [
                                    'label' => 'Teléfono',
                                    'value' => $antecedente->telefono_medico,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Hepatitis -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Hepatitis?</label>
                                <div class="radio-group d-flex gap-4">
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][hepatitis]" id="hepatitis_si" value="si" class="form-check-input" <?= $antecedente->hepatitis ? 'checked' : '' ?>>
                                        <label for="hepatitis_si" class="form-check-label ms-2">Sí</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][hepatitis]" id="hepatitis_no" value="no" class="form-check-input" <?= !$antecedente->hepatitis ? 'checked' : '' ?>>
                                        <label for="hepatitis_no" class="form-check-label ms-2">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Tipo de Hepatitis -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.tipo_hepatitis", [
                                    'label' => 'Tipo de Hepatitis',
                                    'value' => $antecedente->tipo_hepatitis,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Diabetes -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Diabetes?</label>
                                <div class="radio-group d-flex gap-4">
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][diabetes]" id="diabetes_si" value="si" class="form-check-input" <?= $antecedente->diabetes ? 'checked' : '' ?>>
                                        <label for="diabetes_si" class="form-check-label ms-2">Sí</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][diabetes]" id="diabetes_no" value="no" class="form-check-input" <?= !$antecedente->diabetes ? 'checked' : '' ?>>
                                        <label for="diabetes_no" class="form-check-label ms-2">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado de Diabetes -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.diabetes_estado", [
                                    'label' => 'Estado de Diabetes',
                                    'value' => $antecedente->diabetes_estado,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Condición Cardíaca -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.condicion_cardiaca", [
                                    'label' => 'Condición Cardíaca',
                                    'value' => $antecedente->condicion_cardiaca,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Tratamiento Cardíaco -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.tratamiento_cardiaco", [
                                    'label' => 'Tratamiento Cardíaco',
                                    'value' => $antecedente->tratamiento_cardiaco,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Presión Alta -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Presión Alta?</label>
                                <div class="radio-group d-flex gap-4">
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][presion_alta]" id="presion_alta_si" value="si" class="form-check-input" <?= $antecedente->presion_alta ? 'checked' : '' ?>>
                                        <label for="presion_alta_si" class="form-check-label ms-2">Sí</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][presion_alta]" id="presion_alta_no" value="no" class="form-check-input" <?= !$antecedente->presion_alta ? 'checked' : '' ?>>
                                        <label for="presion_alta_no" class="form-check-label ms-2">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Riesgo de Enfermedad -->
                            <div class="col-md-12 mb-3">
                                <?= $this->Form->control("antecedentes_medicos.{$index}.enfermedad_riesgo", [
                                    'label' => 'Riesgo de Enfermedad',
                                    'value' => $antecedente->enfermedad_riesgo,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>


                            <!-- Estado de Gestación -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">¿Estado de Gestación?</label>
                                <div class="radio-group d-flex gap-4">
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][estado_gestacion]" id="estado_gestacion_si" value="si" class="form-check-input" <?= $antecedente->estado_gestacion ? 'checked' : '' ?>>
                                        <label for="estado_gestacion_si" class="form-check-label ms-2">Sí</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_medicos[<?= $index ?>][estado_gestacion]" id="estado_gestacion_no" value="no" class="form-check-input" <?= !$antecedente->estado_gestacion ? 'checked' : '' ?>>
                                        <label for="estado_gestacion_no" class="form-check-label ms-2">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </fieldset>
        <div class="mt-3">
            <button type="button" class="btn btn-secondary btn-sm" onclick="addAntecedenteMedico()">Añadir Antecedente Médico</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="removeRowMedicos()">Remover Antecedente Médico</button>
        </div>
    </details>
</div>

<!-- Antecedentes Odontológicos -->
<div class="container mt-4">
    <details class="border p-3 mb-3">
        <summary class="fw-bold text-light" style="font-size: 1.05rem;">
            <i class="fas fa-tooth me-2"></i> Antecedentes Odontológicos
        </summary>

        <fieldset id="antecedentes-odontologicos-section" class="mt-3">
            <div id="antecedentes-odontologicos-container">
                <?php foreach ($paciente->antecedentes_odontologicos as $index => $antecedente): ?>
                    <div class="antecedente-odontologico">
                        <h5 class="text-info">Antecedente Odontológico #<?= $index + 1 ?></h5>
                        <div class="row g-3">
                            <!-- Control oculto para ID -->
                            <?= $this->Form->control("antecedentes_odontologicos.{$index}.id", [
                                'type' => 'hidden',
                                'value' => $antecedente->id,
                            ]) ?>

                            <!-- Motivo de Consulta -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.motivo_consulta", [
                                    'label' => 'Motivo de Consulta',
                                    'value' => $antecedente->motivo_consulta,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>


                            <!-- Frecuencia de Visita -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.frecuencia_visita", [
                                    'label' => 'Frecuencia de Visita',
                                    'value' => $antecedente->frecuencia_visita,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Experiencia Traumática -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.experiencia_traumatica", [
                                    'label' => 'Experiencia Traumática',
                                    'value' => $antecedente->experiencia_traumatica,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Extracciones Dentales -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.extracciones_dentales", [
                                    'label' => 'Extracciones Dentales',
                                    'value' => $antecedente->extracciones_dentales,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>

                            <!-- Complicaciones con Anestesia -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.complicaciones_anestesia", [
                                    'label' => 'Complicaciones con Anestesia',
                                    'value' => $antecedente->complicaciones_anestesia,
                                    'type' => 'text', // Se asegura que sea un input normal
                                    'class' => 'form-control',
                                ]) ?>
                            </div>


                            <!-- Sufre Sangrado de Encías -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Sufre Sangrado de Encías?</label>
                                <div class="radio-group d-flex gap-4">
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_odontologicos[<?= $index ?>][sangrado_encias]" id="sangrado_encias_si" value="si" class="form-check-input" <?= $antecedente->sangrado_encias ? 'checked' : '' ?>>
                                        <label for="sangrado_encias_si" class="form-check-label ms-2">Sí</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_odontologicos[<?= $index ?>][sangrado_encias]" id="sangrado_encias_no" value="0" class="form-check-input" <?= !$antecedente->sangrado_encias ? 'checked' : '' ?>>
                                        <label for="sangrado_encias_no" class="form-check-label ms-2">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Fecha de Última Profilaxis -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.fecha_ultima_profilaxis", [
                                    'type' => 'date',
                                    'label' => 'Fecha de Última Profilaxis',
                                    'value' => $antecedente->fecha_ultima_profilaxis,
                                    'class' => 'form-control',
                                    'max' => date('Y-m-d'),
                                ]) ?>
                            </div>

                            <!-- Dolor en la Mandíbula -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Tiene Dolor en la Mandíbula?</label>
                                <div class="radio-group d-flex gap-4">
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_odontologicos[<?= $index ?>][dolor_mandibula]" id="dolor_mandibula_si" value="si" class="form-check-input" <?= $antecedente->dolor_mandibula ? 'checked' : '' ?>>
                                        <label for="dolor_mandibula_si" class="form-check-label ms-2">Sí</label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input type="radio" name="antecedentes_odontologicos[<?= $index ?>][dolor_mandibula]" id="dolor_mandibula_no" value="0" class="form-check-input" <?= !$antecedente->dolor_mandibula ? 'checked' : '' ?>>
                                        <label for="dolor_mandibula_no" class="form-check-label ms-2">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Satisfacción Dental -->
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control("antecedentes_odontologicos.{$index}.satisfaccion_dental", [
                                    'label' => 'Satisfacción Dental',
                                    'value' => $antecedente->satisfaccion_dental,
                                    'class' => 'form-control',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-secondary btn-sm" onclick="addAntecedenteOdontologico()">Añadir Antecedente Odontológico</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="removeRowOdontologicos()">Remover Antecedente Odontológico</button>
            </div>
        </fieldset>
    </details>
</div>

<!-- Boton para actualizar paciente-->
<div class="col-12 mt-4 text-center">
    <?= $this->Form->button('Actualizar Paciente', ['class' => 'btn btn-info']) ?>
    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], [
        'class' => 'btn btn-danger' // Estilo Bootstrap para el botón de cancelar
    ]) ?>
</div>

<!-- Incluir el archivo JavaScript -->

<?= $this->Html->script('antecedentes.js') ?>
<?= $this->Html->script('contactos.js') ?>
<?= $this->Html->script('enfermedad.js') ?>

<script>
    const tratamientosData = <?= json_encode($tratamientosData); ?>;
</script>
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
    </script>
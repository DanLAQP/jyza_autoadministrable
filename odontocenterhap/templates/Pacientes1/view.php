<style>
    .label-text {
        color: #f8f9fa; /* Color plomo (gris) */
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d; /* Fondo claro similar a un input */
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
    }
</style>
<?php $this->assign('title', ' '); ?>
<!-- Información básica del pacientes1->paciente -->
<div class="container mt-5">
        <div class="card shadow">
            <div class="card-header text-center">
                <h3>Información del Paciente</h3>
            </div>
            <div class="card-body">
                <!-- Campo: Nombre y Apellido -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Nombres:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->nombre) ? h($pacientes1->nombre) : '&nbsp;' ?> <?= !empty($pacientes1->apellido) ? h($pacientes1->apellido) : '&nbsp;' ?></div>
                    </div>
                </div>
                <!-- Campo: RUC -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">RUC:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->ruc) ? h($pacientes1->paciente->ruc) : '&nbsp;' ?></div>
                    </div>
                </div>
                <!-- Campo: DNI -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">DNI/Carnet/Pasaporte:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->dni) ? h($pacientes1->paciente->dni) : '&nbsp;' ?></div>
                    </div>
                    <div class="col-md-1"></div>
                    <!-- Campo: Fecha de Nacimiento -->
                    <div class="col-md-3">
                        <p class="label-text">Fecha de Nacimiento:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->fecha_nacimiento) ? h($pacientes1->paciente->fecha_nacimiento->format('d-m-Y')) : '&nbsp;' ?></div>
                    </div>
                </div>
                <!-- Campo: Sexo -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Sexo:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->sexo) ? h($pacientes1->paciente->sexo) : '&nbsp;' ?></div>
                    </div>
                    <div class="col-md-1"></div>
                    <!-- Campo: Edad -->
                
                    <div class="col-md-3">
                        <p class="label-text">Edad:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->edad) ? h($pacientes1->paciente->edad) : '&nbsp;' ?></div>
                    </div>
                </div>

                <!-- Campo: Dirección -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Dirección:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->direccion) ? h($pacientes1->paciente->direccion) : '&nbsp;' ?></div>
                    </div>
                    
                </div>
 
                <div class="row mb-3">
                    <!-- Campo: Distrito -->
                    <div class="col-md-2">
                        <p class="label-text">Distrito:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->distrito) ? h($pacientes1->paciente->distrito) : '&nbsp;' ?></div>
                    </div>
                    <div class="col-md-1">  </div>
                    <!-- Campo: Código Postal -->
                    <div class="col-md-3">
                        <p class="label-text">Código Postal:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->codigo_postal) ? h($pacientes1->paciente->codigo_postal) : '&nbsp;' ?></div>
                    </div>
                    
                </div>
                <!-- Campo: Nombre del Apoderado -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Apoderado:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->nombre_apoderado) ? h($pacientes1->paciente->nombre_apoderado) : '&nbsp;' ?></div>
                    </div>
                </div>

                <!-- Campo: Parentesco del Apoderado -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Parentesco:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->parentesco_apoderado) ? h($pacientes1->paciente->parentesco_apoderado) : '&nbsp;' ?></div>
                    </div>
                </div>
                <!-- campo email -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Email:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->email) ? h($pacientes1->paciente->email) : '&nbsp;' ?></div>
                    </div>
                </div>

                <div class="row mb-3">
                    
                    <!-- Campo: Teléfono Celular -->
                    <div class="col-md-2">
                        <p class="label-text">Teléfono Celular:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->telefono_celular) ? h($pacientes1->telefono_celular) : '&nbsp;' ?></div>
                    </div>
                    <div class="col-md-1"></div>
                    <!-- Campo: Teléfono Oficina -->
                    <div class="col-md-3">
                        <p class="label-text">Teléfono Oficina:</p>
                    </div>
                    <div class="col-md-3">
                        <div class="data-box"><?= !empty($pacientes1->paciente->telefono_oficina) ? h($pacientes1->paciente->telefono_oficina) : '&nbsp;' ?></div>
                    </div>
                    
                </div>

                <!-- Campo: Centro de Trabajo -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Centro de Trabajo:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->centro_trabajo) ? h($pacientes1->paciente->centro_trabajo) : '&nbsp;' ?></div>
                    </div>
                </div>

                <!-- Campo: Centro de Estudios -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Centro de Estudios:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->centro_estudio) ? h($pacientes1->paciente->centro_estudio) : '&nbsp;' ?></div>
                    </div>
                </div>
                <!-- Campo: Recomendacion -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <p class="label-text">Recomendado por:</p>
                    </div>
                    <div class="col-md-10">
                        <div class="data-box"><?= !empty($pacientes1->paciente->recomendacion) ? h($pacientes1->paciente->recomendacion) : '&nbsp;' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php if (!empty($pacientes1->paciente)) : ?>
<!-- Información de Contactos de Emergencia -->
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Contactos de Emergencia</h3>
        </div>
        <div class="card-body">
            <div>
            <?php if (!empty($pacientes1->paciente->contactos_emergencia)) : ?>
                <?php foreach ($pacientes1->paciente->contactos_emergencia as $contacto) : ?>
                    <div class="row mb-3">
                       <div class="col-md-3">
                                <p class="label-text">Médico de Confianza:</p>
                            </div>
                            <div class="col-md-9">
                            <div class="data-box"><?= !empty($contacto->medico_confianza) ? h($contacto->medico_confianza) : '&nbsp;' ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <p class="label-text">Servicio de Ambulancia:</p>
                              </div>
                            <div class="col-md-9">
                                <div class="data-box"><?= !empty($contacto->servicio_ambulancia) ? h($contacto->servicio_ambulancia) : '&nbsp;' ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <p class="label-text">Nombre del Contacto:</p>
                            </div>
                            <div class="col-md-9">
                                <div class="data-box"><?= !empty($contacto->nombre_contacto) ? h($contacto->nombre_contacto) : '&nbsp;' ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                              <p class="label-text">Teléfono del Contacto:</p>
                            </div>
                            <div class="col-md-9">
                                <div class="data-box"><?= !empty($contacto->telefono_contacto) ? h($contacto->telefono_contacto) : '&nbsp;' ?></div>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No hay contactos de emergencia registrados para este paciente.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Enfermedades Actuales -->
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Enfermedades Actuales</h3>
        </div>
        <div class="card-body">
            <div>
            <?php if (!empty($pacientes1->paciente->enfermedades_actuales)) : ?>
                <?php foreach ($pacientes1->paciente->enfermedades_actuales as $enfermedad) : ?>
                    <!-- Enfermedad -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Enfermedad:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($enfermedad->enfermedad) ? h($enfermedad->enfermedad) : '&nbsp;' ?></div>
                        </div>
                    </div>
                    
                    <!-- Tiempo de Enfermedad -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Tiempo de Enfermedad:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($enfermedad->tiempo_enfermedad) ? h($enfermedad->tiempo_enfermedad) : '&nbsp;' ?></div>
                        </div>
                    </div>
                    
                    <!-- Síntomas Principales -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Síntomas Principales:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($enfermedad->sintomas_principales) ? h($enfermedad->sintomas_principales) : '&nbsp;' ?></div>
                        </div>
                    </div>
                    
                    <!-- Fecha de Registro -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Registrado el:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($enfermedad->created) ? h($enfermedad->created->format('d-m-Y H:i')) : '&nbsp;' ?></div>
                        </div>
                    </div>
                    
                    <hr> <!-- Separador entre enfermedades -->
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay enfermedades actuales registradas para este paciente.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Antecedentes Médicos -->
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Antecedentes Médicos</h3>
        </div>
        <div class="card-body">
            <div>
            <?php if (!empty($pacientes1->paciente->antecedentes_medicos)) : ?>
                <?php foreach ($pacientes1->paciente->antecedentes_medicos as $antecedente) : ?>
                    <!-- Alergias -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Alergias:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= !empty($antecedente->alergias) ? h($antecedente->alergias) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Medicación -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Medicación:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= !empty($antecedente->medicacion) ? h($antecedente->medicacion) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Nombre del Médico -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Nombre del Médico:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= !empty($antecedente->nombre_medico) ? h($antecedente->nombre_medico) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Teléfono del Médico -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Teléfono del Médico:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= !empty($antecedente->telefono_medico) ? h($antecedente->telefono_medico) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Hepatitis -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Hepatitis:</p>
                        </div>
                        <div class="col-md-2">
                            <div class="data-box"><?= $antecedente->hepatitis == 'si' ? 'Sí' : 'No' ?></div>
                        </div>
                        <div class="col-md-1"></div>
                        <!-- Tipo de Hepatitis -->
                        <div class="col-md-3">
                            <p class="label-text">Tipo de Hepatitis:</p>
                        </div>
                        <div class="col-md-4">
                            <div class="data-box"><?= !empty($antecedente->tipo_hepatitis) ? h($antecedente->tipo_hepatitis) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Diabetes -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Diabetes:</p>
                        </div>
                        <div class="col-md-2">
                            <div class="data-box"><?= $antecedente->diabetes == 'si' ? 'Sí' : 'No' ?></div>
                        </div>
                        <div class="col-md-1"></div>
                        <!-- Estado de la Diabetes -->
                        <div class="col-md-3">
                            <p class="label-text">Estado de la Diabetes:</p>
                        </div>
                        <div class="col-md-4">
                            <div class="data-box"><?= !empty($antecedente->diabetes_estado) ? h($antecedente->diabetes_estado) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Condición Cardíaca -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Condición Cardíaca:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= !empty($antecedente->condicion_cardiaca) ? h($antecedente->condicion_cardiaca) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Tratamiento Cardíaco -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Tratamiento Cardíaco:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= !empty($antecedente->tratamiento_cardiaco) ? h($antecedente->tratamiento_cardiaco) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Presión Alta -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Presión Alta:</p>
                        </div>
                        <div class="col-md-2">
                            <div class="data-box"><?= $antecedente->presion_alta == 'si' ? 'Sí' : 'No' ?></div>
                        </div>
                        <div class="col-md-1"></div>
                        <!-- Enfermedad de Riesgo -->
                        <div class="col-md-3">
                            <p class="label-text">Enfermedad de Riesgo:</p>
                        </div>
                        <div class="col-md-4">
                            <div class="data-box"><?= !empty($antecedente->enfermedad_riesgo) ? h($antecedente->enfermedad_riesgo) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    

                    <!-- Estado de Gestación -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <p class="label-text">Estado de Gestación:</p>
                        </div>
                        <div class="col-md-10">
                            <div class="data-box"><?= $antecedente->estado_gestacion == 'si' ? 'Sí' : 'No' ?></div>
                        </div>
                    </div>

                    <hr> <!-- Separador entre antecedentes -->
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay antecedentes médicos registrados para este paciente.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Antecedentes Odontológicos -->
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Antecedentes Odontológicos</h3>
        </div>
        <div class="card-body">
            <div>
            <?php if (!empty($pacientes1->paciente->antecedentes_odontologicos)) : ?>
                <?php foreach ($pacientes1->paciente->antecedentes_odontologicos as $antecedente) : ?>
                    <!-- Motivo de Consulta -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Motivo de Consulta:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($antecedente->motivo_consulta) ? h($antecedente->motivo_consulta) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Frecuencia de Visita -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Frecuencia de Visita:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($antecedente->frecuencia_visita) ? h($antecedente->frecuencia_visita) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Experiencia Traumática -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Experiencia Traumática:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($antecedente->experiencia_traumatica) ? h($antecedente->experiencia_traumatica) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Extracciones Dentales -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Extracciones Dentales:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($antecedente->extracciones_dentales) ? h($antecedente->extracciones_dentales) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Complicaciones con Anestesia -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Complicaciones con Anestesia:</p>
                        </div>
                        <div class="col-md-9">
                            <div class="data-box"><?= !empty($antecedente->complicaciones_anestesia) ? h($antecedente->complicaciones_anestesia) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    <!-- Sangrado de Encías -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Sangrado de Encías:</p>
                        </div>
                        <div class="col-md-2">
                            <div class="data-box"><?= $antecedente->sangrado_encias == 'si' ? 'Sí' : 'No' ?></div>
                        </div>
                        <div class="col-md-1"></div>
                        <!-- Fecha de Última Profilaxis -->
                        <div class="col-md-3">
                            <p class="label-text">Fecha Última Profilaxis:</p>
                        </div>
                        <div class="col-md-3">
                            <div class="data-box"><?= !empty($antecedente->fecha_ultima_profilaxis) ? h($antecedente->fecha_ultima_profilaxis->format('d-m-Y')) : 'No registrada' ?></div>
                        </div>
                    
                    </div>

                    

                    <!-- Dolor en la Mandíbula -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="label-text">Dolor en la Mandíbula:</p>
                        </div>
                        <div class="col-md-2">
                            <div class="data-box"><?= $antecedente->dolor_mandibula == 'si' ? 'Sí' : 'No' ?></div>
                        </div>
                        <div class="col-md-1"></div>
                        <!-- Satisfacción Dental -->
                        <div class="col-md-3">
                            <p class="label-text">Satisfacción Dental:</p>
                        </div>
                        <div class="col-md-3">
                            <div class="data-box"><?= !empty($antecedente->satisfaccion_dental) ? h($antecedente->satisfaccion_dental) : '&nbsp;' ?></div>
                        </div>
                    </div>

                    

                    <hr> <!-- Separador entre antecedentes -->
                <?php endforeach; ?>
            <?php else : ?>
                <p>No hay antecedentes odontológicos registrados para este paciente.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- tratamientos 
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Registros de Tratamientos</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($pacientes1->paciente->registros_tratamientos)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->paciente->registros_tratamientos as $index => $registro): ?>
                                <tr>
                                    <td><?= !empty($registro->tratamiento->nombre) ? h($registro->tratamiento->nombre) : 'No registrado' ?></td>
                                    <td><?= !empty($registro->tratamiento->descripcion) ? h($registro->tratamiento->descripcion) : 'No registrada' ?></td>
                                    <td><?= !empty($registro->tratamiento->costo) ? h($registro->tratamiento->costo) : 'No registrado' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay tratamientos registrados para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
-->
<!-- ordenes -->
<!-- Historial de Órdenes -->
<div id="ordenes" class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Historial de Órdenes</h3>
        </div>
        <div class="card-body">
            <!-- Botón para agregar nueva orden -->
            <div class="mb-3 text-end">
                <?= $this->Html->link(
                    __('Agregar Orden'),
                    ['controller' => 'Ordenes', 'action' => 'add', $pacientes1->paciente->id], //pasar el ID del paciente
                    ['class' => 'btn btn-info', 'target' => '_blank']
                ) ?>
            </div>

            <?php if (!empty($pacientes1->paciente->ordenes)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Doctor</th>
                                <th>Total</th>
                                <th>Saldo</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->paciente->ordenes as $orden): ?>
                                <tr>
                                    <td>
                                        <?= $orden->doctore ?
                                            h($orden->doctore->nombre . ' ' . $orden->doctore->apellido) :
                                            'N/A' ?>
                                    </td>
                                    <td class="text-end fw-bold">S/ <?= $this->Number->format($orden->total) ?></td>
                                    <td class="text-end text-warning fw-semibold">S/ <?= $this->Number->format($orden->saldo) ?></td>
                                    <td><?= h($orden->created->format('d-m-Y H:i')) ?></td>
                                    <td>
                                        <?= $this->Html->link(__('Ver Orden'), 
                                            ['controller' => 'Ordenes', 'action' => 'view', $orden->id], 
                                            ['class' => 'btn btn-info openModalXl', 'target' => '_blank']
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay órdenes registradas para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Registros de Consultas -->
<div id="consultas" class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Historial de Consultas</h3>
        </div>
        <div class="card-body">
        <!-- Botón para agregar Consultas -->
        <div class="mb-3 text-end">
            <?= $this->Html->link(
                __('Agregar Consultas'),
                ['controller' => 'RegistrosConsultas', 'action' => 'add', $pacientes1->id],
                ['class' => 'btn btn-info openModal', 'target' => '_blank']
            ) ?>
        </div>
        <div class="card-body">
            <?php if (!empty($pacientes1->registros_consultas)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Doctor</th>
                                <th>Observaciones</th>
                                <th>Fecha de Consulta</th>
                                <th>Total Costo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->registros_consultas as $registro): ?>
                                <tr>
                                    <td>
                                        <?= $registro->doctore ? 
                                            h($registro->doctore->nombre . ' ' . $registro->doctore->apellido) : 
                                            'N/A' ?>
                                    </td>
                                    <td><?= h($registro->observaciones) ?: 'N/A' ?></td>
                                    <td><?= $registro->created->format('d-m-Y H:i') ?></td>
                                    <td class="text-end fw-bold">
                                        S/. <?= number_format($registro->_total_costo  ?? 0, 2) ?> <!-- Usamos el total calculado -->
                                    </td>
                                    <td>
                                        <?= $this->Html->link(__('Ver Consulta'), 
                                            ['controller' => 'RegistrosConsultas', 'action' => 'view', $registro->id], 
                                            ['class' => 'btn btn-info openModalXl', 'target' => '_blank']
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay registros de consultas para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- citas -->
<!-- Citas del Paciente -->
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Citas del Paciente</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($pacientes1->paciente->citas)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Doctor</th>
                                <th>Fecha y Hora</th>
                                <th>Estado</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->paciente->citas as $cita): ?>
                                <tr>
                                    <td>
                                        <?= isset($doctores[$cita->doctor_id]) ? h($doctores[$cita->doctor_id]) : 'No asignado' ?>
                                    </td>
                                    <td><?= h($cita->fecha_hora->format('d-m-Y')) ?></td>
                                    <td><?= h($cita->estado) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay citas registradas para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Odontogramas del Paciente -->
<div id="odontogramas" class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Odontogramas del Paciente</h3>
        </div>
        <div class="card-body">
            <!-- Botón para agregar odontograma -->
            <div class="mb-3 text-end">
                <?= $this->Html->link(
                    __('Agregar Odontograma'),
                    ['controller' => 'Odontograma', 'action' => 'add', $pacientes1->id],
                    ['class' => 'btn btn-info openModal', 'target' => '_blank']
                ) ?>
            </div>
            <?php if (!empty($pacientes1->paciente->odontogramas_asociados)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Titulo</th>
                                <th>Fecha de Creación</th>
                                <th>Última Actualización</th>
                                <th>Tipo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->paciente->odontogramas_asociados as $odontograma): ?>
                                <tr>
                                    <td><?= h($odontograma->titulo) ?></td>
                                    <td><?= h($odontograma->created_at->format('d-m-Y')) ?></td>
                                    <td><?= h($odontograma->updated_at->format('d-m-Y')) ?></td>
                                    <td><?= h($odontograma->tipo) ?></td>
                                    <td>
                                        <?= $this->Html->link(__('Ver Odontograma'), ['controller' => 'Odontograma', 'action' => 'view', $odontograma->id], ['class' => 'btn btn-info openModalXl', 'target' => '_blank']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay odontogramas registrados para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- para imagenesy archivos subido -->
<!-- Archivos del Paciente -->
<div id="archivos" class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Archivos del Paciente</h3>
        </div>
        <div class="card-body">
        <div class="mb-3 text-end">
            <?= $this->Html->link(
                __('Agregar Archivo'),
                ['controller' => 'ArchivosPacientes', 'action' => 'add', $pacientes1->id],
                ['class' => 'btn btn-info openModal', 'target' => '_blank']
            ) ?>
        </div>

            <?php if (!empty($pacientes1->archivos_pacientes)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Fecha de Creación</th>
                                <th>Última Modificación</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->archivos_pacientes as $archivo): ?>
                                <tr>
                                    <td><?= h($archivo->tipo) ?></td>
                                    <td><?= h($archivo->descripcion) ?></td>
                                    <td><?= h($archivo->created->format('d-m-Y')) ?></td>
                                    <td><?= h($archivo->modified->format('d-m-Y')) ?></td>
                                    <td>
                                        <?= $this->Html->link(__('Ver Archivo'), 
                                            ['controller' => 'ArchivosPacientes', 'action' => 'view', $archivo->id], 
                                            ['class' => 'btn btn-info openModalXl', 'target' => '_blank']
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay archivos registrados para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Presupuestos del pacientes1->paciente -->
<div id="presupuestos" class="container mt-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h3>Presupuestos</h3>
        </div>
        <div class="card-body">
        <!-- Botón para agregar Presupuesto -->
        <div class="mb-3 text-end">
            <?= $this->Html->link(
                __('Agregar Presupuesto'),
                ['controller' => 'Presupuestos', 'action' => 'add', $pacientes1->id],
                ['class' => 'btn btn-info openModal', 'target' => '_blank']
            ) ?>
        </div>
        </div>
        <div class="card-body">
            <?php if (!empty($pacientes1->presupuestos)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Tratamientos</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pacientes1->presupuestos as $presupuesto): ?>
                                <?php 
                                    // Calcular suma de tratamientos
                                    $sumaTotal = 0;
                                    foreach ($presupuesto->presupuestos_tratamientos as $detalle) {
                                        $sumaTotal += $detalle->precio_unitario * $detalle->cantidad;
                                    }
                                ?>
                                <tr>
                                    <td>
                                        <ul>
                                            <?php foreach ($presupuesto->presupuestos_tratamientos as $detalle): ?>
                                                <li><?= h($detalle->tratamiento->nombre) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <?php foreach ($presupuesto->presupuestos_tratamientos as $detalle): ?>
                                                <li><?= h(number_format($detalle->precio_unitario, 2)) ?> $</li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <?php foreach ($presupuesto->presupuestos_tratamientos as $detalle): ?>
                                                <li><?= h($detalle->cantidad) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td><?= number_format($sumaTotal, 2) ?> $</td> <!-- Total calculado -->
                                    <td><?= h($presupuesto->created->format('d-m-Y')) ?></td>
                                    <td>
                                        <?= $this->Html->link(__('Ver Presupuesto'), 
                                            ['controller' => 'Presupuestos', 'action' => 'view', $presupuesto->id], 
                                            ['class' => 'btn btn-info openModalXl', 'target' => '_blank']
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="text-center">No hay presupuestos registrados para este paciente.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php else : ?>

<!-- Si no hay historia clínica, mostrar botón -->
<div class="container mt-5 text-center">
<?= $this->Html->link(
    'Agregar Historia Clínica',
    ['controller' => 'Pacientes', 'action' => 'add', $pacientes1->id],
    ['class' => 'btn btn-primary btn-lg']
) ?>
</div>

<?php endif; ?>
<div class="container mt-5 text-center">
    <!-- Botón para descargar PDF -->
    <a href="<?= $this->Url->build(['action' => 'exportPacientePdf', $pacientes1->id]) ?>" class="btn btn-primary mb-3">
        Descargar PDF
    </a>
    <!-- Botón para volver -->
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-secondary me-2 mb-3">
        Volver
    </a>
    <!-- Botón Editar Odontograma -->
    <?= $this->Html->link(
                __('Editar'),
                ['action' => 'edit', $pacientes1->id],
                ['class' => 'btn btn-info me-2 mb-3'] // Espaciado horizontal
            ) ?>

</div>

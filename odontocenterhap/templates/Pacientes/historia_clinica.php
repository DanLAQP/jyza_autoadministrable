<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historia Clínica</title>
    <style>
        body {
            font-size: 12px;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td {
            padding: 5px 10px;
            vertical-align: middle;
        }

        .label-text {
            font-weight: bold;
        }

        .align-right {
            text-align: right;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 0 auto;
        }

        .subtitle {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        hr {
            border: 0;
            height: 1px;
            background: #ccc;
            margin: 10px 0;
        }
        /* Pie de página */
        .footer {
            margin-top: 60px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }

        .signature-line {
            margin-top: 10px;
            display: inline-block;
            width: 50%;
            border-top: 1px solid #000;
            text-align: center;
        }
        .margin-izquierdo {
            margin-left: 10px;
        }
        .Fecha {
            margin-bottom: 15px;
            margin-left:8px;
        }
    </style>
</head>
<body>
    <!-- Título Logo -->
    <!-- Encabezado -->
    
    <div style=" vertical-align: middle; width: 180px;">
        <?= $this->Html->image($logoUrl, ['alt' => 'Logo', 'style' => 'width: 180px;']) ?>
    </div>

    <div class="title" style="text-align: center;">FICHA DE DATOS</div>

    <br>
    <table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 100%; text-align: right;">
            <!-- Cuadro para ID -->
            <div style="
                display: inline-block; 
                width: 150px; 
                height: 30px; 
                border: 1px solid #000; 
                text-align: center; 
                line-height: 30px;
            ">
                <?= h($paciente->id) ?>
            </div>
            <br>
            <!-- Texto debajo -->
            <span style="font-size: 12px; text-align: center; margin-top:10px;">N° DE HIST. CLÍNICA</span>
            <br>
            
        </td>
    </tr>
</table>
<div class="Fecha">FECHA: <?= h($paciente->created->format('Y-m-d')) ?></div>

    
<!-- prueba -->
<table style="width: 100%; border-collapse: collapse;">
    <!-- Primera Fila: Nombre y DNI -->
    <tr>
        <td style="width: 80%;">
            <span class="label-text">Nombre y Apellido:</span> <?= h($paciente->pacientes1->nombre) ?> <?= h($paciente->pacientes1->apellido) ?>
        </td>
        <td style="width: 5%;"></td>
        <td style="width: 15%;">
            <span class="label-text">DNI:</span> <?= h($paciente->dni) ?>
        </td>
    </tr>
    <!-- Segunda Fila: Edad, Sexo y RUC -->
    <tr>
        <td style="width: 30%;">
            <span class="label-text">Edad:</span> <?= h($paciente->edad) ?>
        </td>
        
        <td style="width: 40%;">
            <span class="label-text">Sexo:</span> <?= h($paciente->sexo) ?>
        </td>
        <td style="width: 30%;">
            <span class="label-text">Ruc:</span> <?= h($paciente->sexo) ?>
        </td>
    </tr>
    <!-- tercera fila -->
    <tr>
        <td style="width: 30%; ">
            <span class="label-text">Fecha de Nacimiento:</span> <?= h($paciente->fecha_nacimiento) ?>
        </td>
        <td style="width: 40%;"></td>
        <td style="width: 30%;"></td>
    </tr>
    <?php if (!empty($paciente->pasaporte) || !empty($paciente->carnet_extranjeria)): ?>
    <?php if (!empty($paciente->pasaporte)): ?>
        <tr>
            <td style="width: 100%;">
                <span class="label-text">Número de Pasaporte:</span> <?= h($paciente->pasaporte) ?>
            </td>   
        </tr>
    <?php endif; ?>

    <?php if (!empty($paciente->carnet_extranjeria)): ?>
        <tr>
            <td style="width: 100%;">
                <span class="label-text">Carnet de extranjería:</span> <?= h($paciente->carnet_extranjeria) ?>
            </td>
        </tr>
    <?php endif; ?>
<?php endif; ?>
    <tr>
        <td style="width: 100%;">
            <span class="label-text">Apoderado - Titular:</span> <?= h($paciente->nombre_apoderado) ?>
        </td>   
    </tr>
    <tr>
        <td style="width: 100%;">
            <span class="label-text">Parentesco:</span> <?= h($paciente->parentesco_apoderado) ?>
        </td>
    </tr>
    
    <tr>
        <td style="width: 60%;">
            <span class="label-text">Dirección:</span> <?= h($paciente->direccion) ?>
        </td>
    </tr>
    <tr>
        <td style="width: 60%; ">
            <span class="label-text">Distrito:</span> <?= h($paciente->distrito) ?>
        </td>
        <td style="width: 40%;">
            <span class="label-text">Código Postal:</span> <?= h($paciente->codigo_postal) ?>
        </td>
    </tr>
    <tr>
    <td style="width: 40%; ">
        <span class="label-text">E-mail:</span> <?= h($paciente->email) ?>
    </td>
        <td style="width: 30%;">
            <span class="label-text">Teléfono:</span> <?= h($paciente->telefono_oficina) ?>
        </td>
        <td style="width: 30%; ">
            <span class="label-text">Celular:</span> <?= h($paciente->pacientes1->telefono_celular) ?>
        </td>
    </tr>
    <tr>
        <td style="width: 100%;">
            <span class="label-text">Centro de trabajo:</span> <?= h($paciente->centro_trabajo) ?>
        </td>
    </tr>
        <tr>
            <td style="width: 100%;">
                <span class="label-text">Centro de estudios:</span> <?= h($paciente->centro_estudio) ?>
            </td>
        </tr>
    <tr>
        <td style="width: 100%;">
            <span class="label-text">Recomendado por:</span> <?= h($paciente->recomendacion) ?>
        </td>
    </tr>


</table>
    <!-- Contactos de Emergencia -->
    <div class="subtitle">PARA CASOS DE EMERGENCIA DAR LOS SIGUIENTES DATOS</div>
    <?php if (!empty($paciente->contactos_emergencia)) : ?>
        <?php foreach ($paciente->contactos_emergencia as $contacto) : ?>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 100%;">
                        <span class="label-text">MÉDICO DE CONFIANZA:</span> <?= h($contacto->medico_confianza) ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%;">
                        <span class="label-text">SERVICIO DE AMBULANCIA:</span> <?= h($contacto->servicio_ambulancia) ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%;">
                        <span class="label-text">EN CASO DE EMERGENCIA CONTACTAR:</span> <?= h($contacto->nombre_contacto) ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100%;">
                        <span class="label-text">TELÉFONO DEL CONTACTO:</span> <?= h($contacto->telefono_contacto) ?>
                    </td>
                </tr>

            </table>
            
        <?php endforeach; ?>
    <?php else : ?>
        <p>No hay contactos de emergencia registrados.</p>
    <?php endif; ?>

    <!-- antecedentes medicos -->
    <div class="subtitle">ANTECEDENTES MÉDICOS</div>
    <?php if (!empty($paciente->antecedentes_medicos)) : ?>
        <?php foreach ($paciente->antecedentes_medicos as $antecedente) : ?>
            <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 100%;">
                    <span class="label-text">Alérgico a:</span> <?= h($antecedente->alergia) ?>
                </td>
            </tr>
            <tr>
                <td style="width: 100%;">
                    <span class="label-text">Está tomando algún tipo de medicamento:</span> <?= h($antecedente->medicacion) ?>
                </td>
            </tr>
            <tr>
                <td style="width: 55%;">
                    <span class="label-text">Nombre de su médico:</span> <?= h($antecedente->nombre_medico) ?>
                </td>
                <td style="width: 10%;"></td>
                <td style="width: 35%; ">
                    <span class="label-text">Teléfono:</span> <?= h($antecedente->telefono_medico) ?>
                </td>
            </tr>
            <tr>
    <td style="width: 55%;">
        <span class="label-text">Ha padecido de hepatitis sí o no:</span> <?= h($antecedente->hepatitis ? 'Sí' : 'No') ?>
    </td>
    <td style="width: 40%; padding-left: 45px;">
        <span class="label-text">Qué tipo:</span> <?= h($antecedente->tipo_hepatitis) ?>
    </td>
    <td style="width: 55%;"></td>
</tr>

            <tr>
                <td style="width: 40%;">
                    <span class="label-text">Sufre diabetes sí o no:</span> <?= h($antecedente->diabetes ? 'Sí' : 'No') ?>
                </td>
                
                <td style="width: 40%;">
                    <span class="label-text">Está compensando:</span> <?= h($antecedente->tipo_hepatitis) ?>
                </td>
                
                
            </tr>
            
            <tr>
                <td style="width: 40%;">
                    <span class="label-text">Sufre de presión alta o del corazón sí o no:</span> <?= h($antecedente->condicion_cardiaca ? 'Sí' : 'No') ?>
                </td>
                <td style="width: 60%; padding-left: 15px;">
                    <span class="label-text">Está en tratamiento:</span> <?= h($antecedente->tratamiento_cardiaco) ?>
                </td>
            </tr>
            <tr>
                <td style="width: 100%;">
                    <span class="label-text">Sufre de presión alta sí o no:</span> <?= h($antecedente->presion_alta ? 'Sí' : 'No') ?>
                </td>
            </tr>
            
</table>
            <table style="margin-top: -12px;">
            <tr>
                <td style="width: 100%;">
                    <span class="label-text">Sufre de alguna enfermedad que ponga en riesgo su vida o sea de vital importancia:</span> <?= h($antecedente->enfermedad_riesgo) ?>
                </td>
            </tr>
            <tr>
                <td style="width: 100%;">
                    <span class="label-text">¿Si es gestante o está gestando?:</span> <?= h($antecedente->condicion_cardiaca ? 'Sí' : 'No') ?>
                </td>
            </tr>
            </table>
            
        <?php endforeach; ?>
    <?php else : ?>
        <p>No hay contactos de emergencia registrados.</p>
    <?php endif; ?>

    <!-- antecedentes odontologicos -->
    <div class="subtitle">ANTECEDENTES ODONTOLÓGICOS</div>
<?php if (!empty($paciente->antecedentes_odontologicos)) : ?>
    <?php foreach ($paciente->antecedentes_odontologicos as $antecedente) : ?>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
            <tr>
                <td style="width: 100%;"><span class="label-text">Motivo de consulta:</span> <?= h($antecedente->motivo_consulta) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Frecuencia con que visita al dentista:</span> <?= h($antecedente->frecuencia_visita) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Experiencias dentales traumáticas, describa:</span> <?= h($antecedente->experiencia_traumatica) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Le han extraído muelas:</span> <?= h($antecedente->extracciones_dentales) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Presenta alguna complicación a la anestesia:</span> <?= h($antecedente->complicaciones_anestesia) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Le sangran las encías:</span> <?= h($antecedente->sangrado_encias ? 'Sí' : 'No') ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Fecha de última profilaxis:</span> <?= h($antecedente->fecha_ultima_profilaxis) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Siente chasquidos y ruidos al masticar o abrir la boca:</span> <?= h($antecedente->dolor_mandibula ? 'Sí' : 'No') ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Está satisfecho con su estética dental:</span> <?= h($antecedente->satisfaccion_dental) ?></td>
            </tr>
            <tr>
                <td style="width: 100%;"><span class="label-text">Constato que todo lo indicado anteriormente es cierto sin omision.</span></td>
            </tr>
            
        </table>
        
    <?php endforeach; ?>
<?php else : ?>
    <p>No hay antecedentes odontológicos registrados.</p>
<?php endif; ?>
    <!-- Pie de página -->
    <div class="footer">
        <span class="signature-line"></span>
        <br>
        FIRMA DEL PACIENTE - TUTOR
        <br>
    </div>
</body>
</html>
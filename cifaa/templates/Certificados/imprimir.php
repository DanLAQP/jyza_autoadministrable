<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado - <?= h($certificado->codigo) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 40px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #004687;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #004687;
            font-size: 32px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            background-color: #004687;
            color: white;
            padding: 10px 15px;
            margin-bottom: 15px;
            font-weight: bold;
            border-left: 4px solid #002d5a;
        }
        
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .row.full {
            grid-template-columns: 1fr;
        }
        
        .field {
            display: flex;
            flex-direction: column;
        }
        
        .field-label {
            font-weight: bold;
            color: #004687;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .field-value {
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }
        
        .field-value.empty {
            color: #999;
            font-style: italic;
        }
        
        .modules-list {
            list-style: none;
        }
        
        .modules-list li {
            padding: 8px;
            background-color: #f9f9f9;
            border-left: 3px solid #004687;
            margin-bottom: 8px;
            border-radius: 3px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: #004687;
            color: white;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge.success {
            background-color: #28a745;
        }
        
        .badge.info {
            background-color: #17a2b8;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        
        .no-print {
            margin-top: 20px;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background-color: #004687;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: #002d5a;
        }
        
        .btn-secondary {
            background-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        @media print {
            body {
                background-color: white;
            }
            
            .container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                max-width: 100%;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Certificado Digital</h1>
            <p>CIFAA - Centro de Innovación y Formación Académica Avanzada</p>
            <p>Código: <strong><?= h($certificado->codigo) ?></strong></p>
        </div>

        <!-- Sección 1: Información del Receptor -->
        <div class="section">
            <div class="section-title">📋 Información del Receptor</div>
            <div class="row">
                <div class="field">
                    <span class="field-label">Tipo de Certificación</span>
                    <span class="field-value">
                        <span class="badge <?= $certificado->tipo === 'certificado' ? 'info' : 'success' ?>">
                            <?= ucfirst(h($certificado->tipo)) ?>
                        </span>
                    </span>
                </div>
                <div class="field">
                    <span class="field-label">Código</span>
                    <span class="field-value"><?= h($certificado->codigo) ?></span>
                </div>
            </div>

            <?php if ($certificado->user): ?>
                <div class="row">
                    <div class="field">
                        <span class="field-label">Usuario Registrado</span>
                        <span class="field-value"><?= h($certificado->user->username) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($certificado->nombre_titular || $certificado->dni_titular): ?>
                <div class="row">
                    <div class="field">
                        <span class="field-label">Nombre del Titular</span>
                        <span class="field-value"><?= h($certificado->nombre_titular) ?: '<span class="empty">No especificado</span>' ?></span>
                    </div>
                    <div class="field">
                        <span class="field-label">DNI/Cédula</span>
                        <span class="field-value"><?= h($certificado->dni_titular) ?: '<span class="empty">No especificado</span>' ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección 2: Información del Curso -->
        <div class="section">
            <div class="section-title">🎓 Información del Curso</div>
            
            <?php if ($certificado->curso): ?>
                <div class="row">
                    <div class="field">
                        <span class="field-label">Nombre del Curso</span>
                        <span class="field-value"><?= h($certificado->curso->titulo) ?></span>
                    </div>
                </div>
            <?php elseif ($certificado->nombre_curso_manual): ?>
                <div class="row full">
                    <div class="field">
                        <span class="field-label">Nombre del Curso (Manual)</span>
                        <span class="field-value"><?= h($certificado->nombre_curso_manual) ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Módulos -->
            <?php 
                $tieneModulos = !empty($certificado->certificado_modulos) || !empty($modulosCurso) || $certificado->modulos;
            ?>
            <?php if ($tieneModulos): ?>
                <div class="row full">
                    <div class="field">
                        <span class="field-label">Módulos del Curso</span>
                        <ul class="modules-list">
                            <?php 
                                $modulosRegistrados = [];
                                
                                // Módulos registrados en certificado_modulos
                                if (!empty($certificado->certificado_modulos)): 
                                    foreach ($certificado->certificado_modulos as $modulo):
                                        $modulosRegistrados[] = $modulo->nombre_modulo ?? 'Módulo sin nombre';
                                    endforeach;
                                endif;
                                
                                // Módulos del curso (todos los disponibles)
                                if (!empty($modulosCurso)):
                                    foreach ($modulosCurso as $modulo):
                                        $nombre = $modulo->titulo ?? $modulo->nombre ?? 'Módulo sin nombre';
                                        $marcado = in_array($nombre, $modulosRegistrados) ? '✓' : '✓';
                                        echo '<li>' . $marcado . ' ' . h($nombre) . '</li>';
                                    endforeach;
                                elseif ($certificado->modulos):
                                    $modulos = json_decode($certificado->modulos, true);
                                    if (is_array($modulos)):
                                        foreach ($modulos as $modulo):
                                            echo '<li>✓ ' . h($modulo) . '</li>';
                                        endforeach;
                                    endif;
                                endif;
                            ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sección 3: Detalles Académicos -->
        <div class="section">
            <div class="section-title">📊 Detalles Académicos</div>
            <div class="row">
                <div class="field">
                    <span class="field-label">Nota Final</span>
                    <span class="field-value"><?= $certificado->nota_final !== null ? number_format($certificado->nota_final, 2) : '<span class="empty">No especificada</span>' ?></span>
                </div>
                <div class="field">
                    <span class="field-label">Horas Lectivas</span>
                    <span class="field-value"><?= $certificado->horas !== null ? $certificado->horas . ' horas' : '<span class="empty">No especificadas</span>' ?></span>
                </div>
            </div>
            <div class="row">
                <div class="field">
                    <span class="field-label">Duración</span>
                    <span class="field-value"><?= $certificado->duracion_meses !== null ? $certificado->duracion_meses . ' meses' : '<span class="empty">No especificada</span>' ?></span>
                </div>
                <div class="field">
                    <span class="field-label">Responsable/Gerente</span>
                    <span class="field-value"><?= h($certificado->nombre_gerente) ?: '<span class="empty">No especificado</span>' ?></span>
                </div>
            </div>
        </div>

        <!-- Sección 4: Fechas -->
        <div class="section">
            <div class="section-title">📅 Período de Formación</div>
            <div class="row">
                <div class="field">
                    <span class="field-label">Fecha de Inicio</span>
                    <span class="field-value">
                        <?php if ($certificado->fecha_inicio): ?>
                            <?= date('d/m/Y', strtotime($certificado->fecha_inicio)) ?>
                        <?php else: ?>
                            <span class="empty">No especificada</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="field">
                    <span class="field-label">Fecha de Finalización</span>
                    <span class="field-value">
                        <?php if ($certificado->fecha_fin): ?>
                            <?= date('d/m/Y', strtotime($certificado->fecha_fin)) ?>
                        <?php else: ?>
                            <span class="empty">No especificada</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Sección 5: Metadatos -->
        <div class="section">
            <div class="section-title">ℹ️ Información del Sistema</div>
            <div class="row">
                <div class="field">
                    <span class="field-label">Creado el</span>
                    <span class="field-value"><?= date('d/m/Y H:i', strtotime($certificado->created)) ?></span>
                </div>
                <div class="field">
                    <span class="field-label">Última Modificación</span>
                    <span class="field-value"><?= date('d/m/Y H:i', strtotime($certificado->modified)) ?></span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Este certificado fue generado automáticamente por el sistema CIFAA.</p>
            <p>Documento imprimible - Descargue en PDF para preservar el contenido.</p>
        </div>

        <!-- Botones no imprimibles -->
        <div class="no-print">
            <button class="btn" onclick="window.print()">🖨️ Imprimir / Guardar como PDF</button>
            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-secondary">← Volver al Listado</a>
        </div>
    </div>
</body>
</html>

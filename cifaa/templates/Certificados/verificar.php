<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado|null $certificado
 * @var string|null $codigo
 * @var string|null $mensaje
 * @var string|null $tipo
 */
$this->assign('title', 'Verificación de Certificado');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="mb-4">
                    <?= $this->Html->image('logoCifa.png', [
                        'alt' => 'Logo CIFAA',
                        'class' => 'img-fluid',
                        'style' => 'max-width: 180px;'
                    ]) ?>
                </div>
                <h1 class="display-5 fw-bold text-primary mb-2">
                    <i class="fas fa-shield-check"></i> Verificación de Certificado
                </h1>
                <p class="lead text-muted">
                    Centro Integral de Formación y Asesoría Académica - CIFAA
                </p>
            </div>

            <!-- Formulario de búsqueda -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-search"></i> Buscar Certificado
                    </h5>
                </div>
                <div class="card-body p-4 bg-white">
                    <?= $this->Form->create(null, [
                        'url' => ['action' => 'verificar'],
                        'type' => 'post',
                        'class' => 'needs-validation'
                    ]) ?>
                    
                    <div class="mb-3">
                        <label for="codigo" class="form-label fw-bold">
                            <i class="fas fa-barcode"></i> Código del Certificado
                        </label>
                        <?= $this->Form->control('codigo', [
                            'type' => 'text',
                            'class' => 'form-control form-control-lg text-uppercase',
                            'placeholder' => 'Ej: CER-2025-E650ADCCAA',
                            'required' => true,
                            'label' => false,
                            'value' => $codigo ?? '',
                            'maxlength' => 50,
                            'style' => 'font-family: monospace; letter-spacing: 1px;'
                        ]) ?>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> 
                            Ingrese el código que aparece en el certificado (formato: CER-YYYY-XXXXXXXXXX)
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check-circle"></i> Verificar Certificado
                        </button>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>

            <!-- Resultado de la verificación -->
            <?php if ($mensaje): ?>
            <div class="card shadow-lg border-0 mb-4 alert-card">
                <?php if ($tipo === 'success'): ?>
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <h5 class="mb-0">
                            <i class="fas fa-check-circle"></i> Certificado Válido
                        </h5>
                    </div>
                <?php elseif ($tipo === 'warning'): ?>
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle"></i> Advertencia
                        </h5>
                    </div>
                <?php else: ?>
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);">
                        <h5 class="mb-0">
                            <i class="fas fa-times-circle"></i> Certificado No Válido
                        </h5>
                    </div>
                <?php endif; ?>
                
                <div class="card-body p-4 bg-white">
                    <div class="alert mb-3" style="background: <?= $tipo === 'success' ? '#d4edda' : ($tipo === 'warning' ? '#fff3cd' : '#f8d7da') ?>; border-left: 4px solid <?= $tipo === 'success' ? '#28a745' : ($tipo === 'warning' ? '#ffc107' : '#dc3545') ?>; color: <?= $tipo === 'success' ? '#155724' : ($tipo === 'warning' ? '#856404' : '#721c24') ?>;">
                        <h5 class="alert-heading mb-0">
                            <?= h($mensaje) ?>
                        </h5>
                    </div>
                    
                    <?php if ($certificado && $tipo === 'success'): ?>
                        <!-- Detalles del certificado -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-user"></i> Estudiante:
                                    </strong>
                                    <span class="fs-5">
                                        <?php 
                                        if (!empty($certificado->nombre_completo)) {
                                            echo h($certificado->nombre_completo);
                                        } elseif ($certificado->has('user')) {
                                            echo h($certificado->user->username);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-graduation-cap"></i> Curso:
                                    </strong>
                                    <span class="fs-5">
                                        <?php 
                                        if (!empty($certificado->nombre_curso)) {
                                            echo h($certificado->nombre_curso);
                                        } elseif ($certificado->has('curso')) {
                                            echo h($certificado->curso->titulo);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-calendar"></i> Fecha de Emisión:
                                    </strong>
                                    <span><?= h($certificado->fecha_emision->format('d/m/Y')) ?></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-clock"></i> Horas Lectivas:
                                    </strong>
                                    <span><?= h($certificado->horas) ?> horas</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-barcode"></i> Código:
                                    </strong>
                                    <code class="text-warning fs-6"><?= h($certificado->codigo) ?></code>
                                </div>
                            </div>
                            
                            <?php if (!empty($certificado->nota_final)): ?>
                            <div class="col-md-4">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-star"></i> Nota Final:
                                    </strong>
                                    <span class="badge bg-primary fs-6"><?= h($certificado->nota_final) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($certificado->duracion_meses)): ?>
                            <div class="col-md-4">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-calendar-alt"></i> Duración:
                                    </strong>
                                    <span><?= h($certificado->duracion_meses) ?> <?= $certificado->duracion_meses == 1 ? 'mes' : 'meses' ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($certificado->fecha_inicio) && !empty($certificado->fecha_fin)): ?>
                            <div class="col-12">
                                <div class="detail-box">
                                    <strong class="text-muted d-block mb-1">
                                        <i class="fas fa-calendar-check"></i> Período del Curso:
                                    </strong>
                                    <span>Del <?= h($certificado->fecha_inicio) ?> al <?= h($certificado->fecha_fin) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Estado del certificado -->
                        <div class="mt-4 p-3 rounded" style="background: linear-gradient(135deg, #e3ffe7 0%, #d9e7ff 100%); border: 1px solid #d4edda;">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shield-check fa-3x" style="color: #28a745;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1" style="color: #155724;">Certificado Autenticado</h6>
                                    <p class="mb-0 small" style="color: #155724;">
                                        Este certificado ha sido emitido por CIFAA y está registrado en nuestra base de datos oficial.
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($certificado && $tipo === 'warning'): ?>
                        <!-- Certificado anulado -->
                        <div class="alert" style="background: #fff3cd; border-left: 4px solid #ffc107; color: #856404;">
                            <i class="fas fa-info-circle"></i>
                            <strong>Código encontrado:</strong> <?= h($certificado->codigo) ?>
                            <br>
                            <small>Estado: <span class="badge" style="background: #ffc107; color: #000;">Anulado</span></small>
                            <br>
                            <small style="color: #856404;">
                                Este certificado fue emitido pero ha sido anulado posteriormente. 
                                Para más información, contacte con CIFAA.
                            </small>
                        </div>
                    <?php else: ?>
                        <!-- Código no encontrado -->
                        <div class="alert" style="background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24;">
                            <i class="fas fa-times-circle"></i>
                            <strong>Código ingresado:</strong> <code style="background: rgba(0,0,0,0.1); padding: 0.2rem 0.4rem; border-radius: 3px;"><?= h($codigo) ?></code>
                            <br><br>
                            <small style="color: #721c24;">
                                El código ingresado no corresponde a ningún certificado en nuestra base de datos.
                                Por favor, verifique que haya ingresado el código correctamente.
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Información adicional -->
            <div class="card border-0" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #6c3400;">
                        <i class="fas fa-info-circle"></i> Información sobre la verificación
                    </h6>
                    <ul class="small mb-0" style="color: #6c3400;">
                        <li>El código de verificación aparece en el certificado PDF en la esquina superior derecha.</li>
                        <li>También puede escanear el código QR que aparece en la segunda página del certificado.</li>
                        <li>Si el código no es válido, verifique que lo haya ingresado correctamente (distinga mayúsculas).</li>
                        <li>Para consultas adicionales, contacte con CIFAA al +51 901 562 110.</li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.detail-box {
    padding: 1rem;
    background: #ffffff;
    border-radius: 8px;
    border-left: 4px solid #667eea;
    height: 100%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.detail-box strong {
    color: #495057;
}

.detail-box span {
    color: #212529;
}

.alert-card {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

code {
    background: #f8f9fa;
    color: #e83e8c;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}

.card {
    background: #ffffff !important;
}

.form-control {
    background: #ffffff !important;
    color: #212529 !important;
}

.form-label {
    color: #495057;
}

.form-text {
    color: #6c757d;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}
</style>

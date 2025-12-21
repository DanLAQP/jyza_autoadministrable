<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado|null $certificado
 * @var string|null $codigoBuscado
 */
?>

<div class="search-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                
                <!-- Encabezado Elegante -->
                <div class="header-section text-center mb-5">
                    <div class="logo-wrapper mb-4">
                        <?= $this->Html->image('logoCifa.png', [
                            'alt' => 'CIFAA Logo',
                            'class' => 'logo-img'
                        ]) ?>
                    </div>
                    <h2 class="section-title mb-3">Búsqueda de Certificados</h2>
                    <p class="subtitle">Verifica la autenticidad de tu certificado ingresando el código único</p>
                </div>

                <!-- Formulario de Búsqueda -->
                <div class="search-card">
                    <div class="card-body p-4 p-md-5">
                        <?= $this->Form->create(null, [
                            'method' => 'post',
                            'class' => 'search-form'
                        ]) ?>
                        
                        <div class="form-group mb-4">
                            <label for="codigo" class="form-label">
                                <i class="fas fa-barcode me-2"></i>
                                Código del Certificado
                            </label>
                            <?= $this->Form->control('codigo', [
                                'type' => 'text',
                                'class' => 'form-control form-control-lg custom-input',
                                'placeholder' => 'Ej: CERT-20251219-001',
                                'required' => true,
                                'autocomplete' => 'off',
                                'label' => false
                            ]) ?>
                            <small class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Formato: CERT-AAAAMMDD-NNN o DIP-AAAAMMDD-NNN
                            </small>
                        </div>

                        <?= $this->Form->button(
                            '<i class="fas fa-certificate me-2"></i> Buscar Certificado',
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-primary btn-search w-100',
                                'escapeTitle' => false
                            ]
                        ) ?>



                        <?= $this->Form->end() ?>

                        <div class="info-box mt-4">
                            <i class="fas fa-shield-alt me-2"></i>
                            <span><strong>Servicio público:</strong> No requiere inicio de sesión. Solo necesitas el código proporcionado.</span>
                        </div>
                    </div>
                </div>

                <!-- Resultado: Certificado Encontrado -->
                <?php if ($certificado): ?>
                <div class="result-card success-card mt-4">
                    <div class="card-header-custom">
                        <div class="d-flex align-items-center">
                            <div class="status-icon success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Certificado Verificado</h5>
                                <small>Documento válido y autenticado</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Información Principal -->
                        <div class="info-grid mb-4">
                            <div class="info-item">
                                <div class="info-label">Código</div>
                                <div class="info-value">
                                    <i class="fas fa-barcode me-2"></i>
                                    <?= h($certificado->codigo) ?>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">Tipo</div>
                                <div class="info-value">
                                    <?php if ($certificado->tipo === 'diplomado'): ?>
                                        <span class="badge-custom badge-diplomado">
                                            <i class="fas fa-medal me-1"></i>Diplomado
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-custom badge-certificado">
                                            <i class="fas fa-award me-1"></i>Certificado
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="info-grid mb-4">
                            <div class="info-item">
                                <div class="info-label">
                                    <?= $certificado->user ? 'Usuario' : 'Titular' ?>
                                </div>
                                <div class="info-value">
                                    <i class="fas fa-user me-2"></i>
                                    <?php if ($certificado->user): ?>
                                        <?= h($certificado->user->nombres) ?>
                                    <?php else: ?>
                                        <?= h($certificado->nombre_titular) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">Curso</div>
                                <div class="info-value">
                                    <i class="fas fa-book me-2"></i>
                                    <?php if ($certificado->curso): ?>
                                        <?= h($certificado->curso->titulo) ?>
                                    <?php elseif ($certificado->nombre_curso_manual): ?>
                                        <?= h($certificado->nombre_curso_manual) ?>
                                    <?php else: ?>
                                        <span class="text-muted-custom">No especificado</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Módulos -->
                        <?php if (!empty($certificado->certificado_modulos)): ?>
                        <div class="modules-section mb-4">
                            <div class="info-label mb-3">
                                <i class="fas fa-list-check me-2"></i>Módulos Cursados
                            </div>
                            <div class="modules-list">
                                <?php foreach ($certificado->certificado_modulos as $modulo): ?>
                                    <div class="module-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span><?= h($modulo->titulo) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Horas Lectivas -->
                        <?php if (!empty($certificado->horas_lectivas)): ?>
                        <div class="hours-section mb-4">
                            <div class="hours-badge">
                                <i class="fas fa-clock me-2"></i>
                                <strong><?= (int)$certificado->horas_lectivas ?></strong> horas lectivas
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Botones de Acción -->
                        <div class="action-buttons">
                            <?= $this->Html->link(
                                '<i class="fas fa-file-pdf me-2"></i>Descargar PDF',
                                ['action' => 'downloadPdf', $certificado->codigo],
                                [
                                    'class' => 'btn btn-success btn-download',
                                    'escape' => false,
                                    'target' => '_blank'
                                ]
                            ) ?>
                            
                            <?= $this->Html->link(
                                '<i class="fas fa-arrow-left me-2"></i>Nueva Búsqueda',
                                ['action' => 'search'],
                                [
                                    'class' => 'btn btn-secondary btn-back',
                                    'escape' => false
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Resultado: No Encontrado -->
                <?php if (!empty($codigoBuscado) && !$certificado): ?>
                <div class="result-card error-card mt-4">
                    <div class="card-body p-4 text-center">
                        <div class="status-icon error mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h5 class="mb-3" style="color: #e74c3c;">Certificado No Encontrado</h5>
                        <p class="mb-3" style="color: #ffffff;">
                            No se encontró ningún certificado con el código:
                        </p>
                        <div class="code-badge mb-3">
                            <code style="background-color: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 8px 12px; border-radius: 4px; display: inline-block;"><?= h($codigoBuscado) ?></code>
                        </div>
                        <p class="text-muted-custom" style="color: #b8c5d0;">
                            Por favor, verifica que el código sea correcto e intenta nuevamente.
                        </p>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<style>
/* Variables y Colores */
:root {
    --primary-color: #4a90e2;
    --primary-dark: #357abd;
    --success-color: #2ecc71;
    --success-dark: #27ae60;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
    --dark-bg: #1a1f28;
    --card-bg: #242933;
    --card-light: #2d3340;
    --text-primary: #ffffff;
    --text-secondary: #b8c5d0;
    --text-muted: #8892a0;
    --border-color: #3a4352;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
    --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.25);
    --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.3);
}

/* Contenedor Principal */
.search-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #1a1f28 0%, #242933 100%);
    background-attachment: fixed;
    padding: 2rem 0;
}

.search-container::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(74, 144, 226, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(46, 204, 113, 0.03) 0%, transparent 50%);
    pointer-events: none;
    z-index: 0;
}

.container {
    position: relative;
    z-index: 1;
}

/* Header Section */
.header-section {
    animation: fadeInDown 0.6s ease-out;
}

.logo-wrapper {
    display: inline-block;
}

.logo-img {
    max-width: 200px;
    height: auto;
    filter: drop-shadow(0 4px 12px rgba(74, 144, 226, 0.2));
    animation: fadeIn 0.8s ease-out;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--primary-color);
    margin: 0;
}

.subtitle {
    font-size: 1rem;
    color: var(--text-secondary);
    max-width: 500px;
    margin: 0 auto;
}

/* Cards */
.search-card,
.result-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.search-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

/* Form Elements */
.form-label {
    color: var(--text-secondary);
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    display: block;
}

.custom-input {
    background: var(--card-light) !important;
    border: 2px solid var(--border-color) !important;
    color: var(--text-primary) !important;
    border-radius: 12px;
    padding: 0.875rem 1.25rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.custom-input:focus {
    background: var(--dark-bg) !important;
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1) !important;
    color: var(--text-primary) !important;
    outline: none;
}

.custom-input::placeholder {
    color: var(--text-muted);
}

.form-text {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: block;
}

/* Buttons */
.btn-search {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border: none;
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(74, 144, 226, 0.3);
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(74, 144, 226, 0.4);
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
}

.btn-download {
    background: linear-gradient(135deg, var(--success-color), var(--success-dark));
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(46, 204, 113, 0.25);
}

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(46, 204, 113, 0.35);
}

.btn-back {
    background: var(--card-light);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    color: var(--text-secondary);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: var(--border-color);
    color: var(--text-primary);
    transform: translateY(-2px);
}

/* Info Box */
.info-box {
    background: var(--card-light);
    border-left: 4px solid var(--primary-color);
    padding: 1rem 1.25rem;
    border-radius: 8px;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* Result Card Header */
.card-header-custom {
    background: linear-gradient(135deg, rgba(46, 204, 113, 0.1), rgba(46, 204, 113, 0.05));
    border-bottom: 1px solid var(--border-color);
    padding: 1.5rem;
}

.status-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 1rem;
}

.status-icon.success {
    background: rgba(46, 204, 113, 0.2);
    color: var(--success-color);
}

.status-icon.error {
    background: rgba(231, 76, 60, 0.2);
    color: var(--danger-color);
    width: 64px;
    height: 64px;
    font-size: 2rem;
    margin: 0 auto;
}

.card-header-custom h5 {
    color: var(--text-primary);
    font-weight: 600;
    margin: 0;
}

.card-header-custom small {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.info-item {
    background: var(--card-light);
    padding: 1.25rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.info-item:hover {
    background: var(--border-color);
    transform: translateX(4px);
}

.info-label {
    color: var(--text-muted);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.info-value {
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 500;
}

/* Badges */
.badge-custom {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
}

.badge-diplomado {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.2), rgba(243, 156, 18, 0.1));
    color: var(--warning-color);
    border: 1px solid rgba(243, 156, 18, 0.3);
}

.badge-certificado {
    background: linear-gradient(135deg, rgba(74, 144, 226, 0.2), rgba(74, 144, 226, 0.1));
    color: var(--primary-color);
    border: 1px solid rgba(74, 144, 226, 0.3);
}

/* Modules Section */
.modules-section {
    background: var(--card-light);
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.modules-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.module-item {
    display: flex;
    align-items: center;
    color: var(--text-secondary);
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.module-item:last-child {
    border-bottom: none;
}

.module-item i {
    color: var(--success-color);
    margin-right: 0.75rem;
    font-size: 0.875rem;
}

/* Hours Section */
.hours-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(74, 144, 226, 0.15), rgba(74, 144, 226, 0.05));
    border: 1px solid rgba(74, 144, 226, 0.3);
    color: var(--primary-color);
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    font-size: 1rem;
}

/* Action Buttons */
.action-buttons {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-top: 1.5rem;
}

@media (min-width: 768px) {
    .action-buttons {
        grid-template-columns: 2fr 1fr;
    }
}

/* Error Card */
.error-card .card-body {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.05), transparent);
}

.code-badge {
    background: var(--card-light);
    border: 1px solid var(--danger-color);
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    display: inline-block;
}

.code-badge code {
    color: var(--danger-color);
    font-size: 1.1rem;
    font-weight: 600;
}

.text-muted-custom {
    color: var(--text-muted);
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Estilos para mensajes Flash (Error, Success, etc) */
.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.alert-error,
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-error i,
.alert-danger i {
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-success i {
    color: #155724;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.alert-warning i {
    color: #856404;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.alert-info i {
    color: #0c5460;
}

/* Responsive */
@media (max-width: 768px) {
    .section-title {
        font-size: 1.5rem;
    }
    
    .logo-img {
        max-width: 160px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .search-card .card-body,
    .result-card .card-body {
        padding: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .search-container {
        padding: 1rem 0;
    }
    
    .logo-img {
        max-width: 140px;
    }
    
    .btn-search,
    .btn-download,
    .btn-back {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
    }
}
</style>
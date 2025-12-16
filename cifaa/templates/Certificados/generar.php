<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 * @var bool $esDiplomado
 */
$tipoDocumento = isset($esDiplomado) && $esDiplomado ? 'Diplomado' : 'Certificado';
$this->assign('title', 'Generar ' . $tipoDocumento . ' Personalizado');
?>

<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-info text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-certificate"></i> Generar <?= $tipoDocumento ?> Personalizado
            </h3>
            <p class="mb-0 mt-2 small">
                <i class="fas fa-info-circle"></i> Complete todos los datos del <?= strtolower($tipoDocumento) ?>. Los campos marcados con <span class="text-warning">*</span> son requeridos.
            </p>
        </div>
        <div class="card-body">
            <?= $this->Form->create($certificado, ['id' => 'form-certificado']) ?>
            
            <div class="row g-4">
                <!-- COLUMNA IZQUIERDA: Datos del Estudiante y Curso -->
                <div class="col-lg-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-graduate"></i> Información del <?= $tipoDocumento ?></h5>
                        </div>
                        <div class="card-body">
                            <!-- Nombre Completo del Estudiante -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user"></i> Nombre Completo del Estudiante <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('nombre_completo', [
                                    'class' => 'form-control form-control-lg',
                                    'placeholder' => 'Ej: Tapia Cahuana, Gherson',
                                    'required' => true,
                                    'label' => false
                                ]) ?>
                                <small class="text-muted">Ingrese el nombre completo tal como aparecerá en el certificado</small>
                            </div>

                            <!-- Nombre del Curso -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-book"></i> Nombre del Curso <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('nombre_curso', [
                                    'class' => 'form-control form-control-lg',
                                    'placeholder' => 'Ej: METODOLOGÍA DE INVESTIGACIÓN',
                                    'required' => true,
                                    'label' => false
                                ]) ?>
                                <small class="text-muted">Escriba el nombre del curso en mayúsculas como aparecerá en el certificado</small>
                            </div>

                            <!-- Campos ocultos opcionales -->
                            <?= $this->Form->hidden('user_id', ['value' => 1]) ?>
                            <?= $this->Form->hidden('curso_id', ['value' => 1]) ?>
                        </div>
                    </div>

                    <!-- Datos Académicos -->
                    <div class="card border-success mt-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-line"></i> Datos Académicos</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nota Final -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-star"></i> Nota Final <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('nota_final', [
                                        'type' => 'text',
                                        'class' => 'form-control form-control-lg',
                                        'placeholder' => '18.00',
                                        'required' => true,
                                        'label' => false
                                    ]) ?>
                                    <small class="text-muted">Formato: 18.00</small>
                                </div>

                                <!-- Duración -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt"></i> Duración (Meses) <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('duracion_meses', [
                                        'type' => 'number',
                                        'class' => 'form-control form-control-lg',
                                        'placeholder' => '2',
                                        'min' => 1,
                                        'required' => true,
                                        'label' => false
                                    ]) ?>
                                    <small class="text-muted">Cantidad de meses</small>
                                </div>

                                <!-- Horas Lectivas -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-clock"></i> Horas Lectivas <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('horas', [
                                        'type' => 'number',
                                        'class' => 'form-control form-control-lg',
                                        'min' => 1,
                                        'placeholder' => '240',
                                        'required' => true,
                                        'label' => false
                                    ]) ?>
                                </div>

                                <!-- Fecha Inicio -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-check"></i> Fecha Inicio <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('fecha_inicio', [
                                        'type' => 'date',
                                        'class' => 'form-control form-control-lg',
                                        'required' => true,
                                        'label' => false
                                    ]) ?>
                                    <small class="text-muted">Seleccione la fecha de inicio del curso</small>
                                </div>

                                <!-- Fecha Fin -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-times"></i> Fecha Fin <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('fecha_fin', [
                                        'type' => 'date',
                                        'class' => 'form-control form-control-lg',
                                        'required' => true,
                                        'label' => false
                                    ]) ?>
                                    <small class="text-muted">Seleccione la fecha de fin del curso</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLUMNA DERECHA: Módulos -->
                <div class="col-lg-6">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-list-ol"></i> Módulos del Certificado
                                <span class="badge bg-dark ms-2" id="contador-modulos">0</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="modulos-container" class="mb-3">
                                <!-- Los módulos se agregarán aquí dinámicamente -->
                            </div>

                            <button type="button" class="btn btn-success btn-lg w-100 mb-3" id="btn-agregar-modulo">
                                <i class="fas fa-plus-circle"></i> Agregar Tema de Módulo
                            </button>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Instrucciones:</strong>
                                <ul class="mb-0 mt-2 small">
                                    <li>Haga clic en "Agregar Tema" para cada módulo</li>
                                    <li>La numeración romana (I, II, III, IV...) es automática</li>
                                    <li>Use el botón <i class="fas fa-trash text-danger"></i> para eliminar</li>
                                    <li>Solo escriba el tema de cada módulo</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary btn-lg', 'escape' => false]
                        ) ?>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-file-pdf"></i> Generar <?= $tipoDocumento ?>
                        </button>
                    </div>
                </div>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- Template para módulos -->
<script id="modulo-template" type="text/template">
    <div class="modulo-item card mb-2 border-secondary" data-modulo-index="{INDEX}">
        <div class="card-body p-3">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <span class="badge bg-primary fs-6 modulo-numero-badge">{NUMERO}</span>
                </div>
                <div class="flex-grow-1">
                    <textarea name="modulo_tema[]" class="form-control" rows="2" placeholder="Escriba el tema del módulo (Ej: Introducción a la investigación científica)" required></textarea>
                </div>
                <div class="ms-2">
                    <button type="button" class="btn btn-sm btn-danger btn-eliminar-modulo" data-index="{INDEX}" title="Eliminar módulo">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</script>

<style>
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.modulo-item {
    animation: fadeIn 0.3s ease-in;
    transition: all 0.2s;
}

.modulo-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.btn-eliminar-modulo {
    transition: all 0.2s;
}

.btn-eliminar-modulo:hover {
    transform: scale(1.1);
}

.modulo-numero-badge {
    min-width: 35px;
    padding: 8px;
}

#modulos-container {
    max-height: 500px;
    overflow-y: auto;
}

#modulos-container::-webkit-scrollbar {
    width: 8px;
}

#modulos-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#modulos-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

#modulos-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let moduloIndex = 0;
    const numerosRomanos = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV'];
    
    const modulosContainer = document.getElementById('modulos-container');
    const btnAgregarModulo = document.getElementById('btn-agregar-modulo');
    const contadorModulos = document.getElementById('contador-modulos');
    const moduloTemplate = document.getElementById('modulo-template').innerHTML;

    // Función para actualizar el contador
    function actualizarContador() {
        const total = document.querySelectorAll('.modulo-item').length;
        contadorModulos.textContent = total;
    }

    // Función para actualizar la numeración romana
    function actualizarNumeracion() {
        const modulos = document.querySelectorAll('.modulo-item');
        modulos.forEach((modulo, index) => {
            const numeroSpan = modulo.querySelector('.modulo-numero-badge');
            if (numeroSpan) {
                numeroSpan.textContent = numerosRomanos[index] || (index + 1);
            }
        });
        actualizarContador();
    }

    // Agregar módulo
    btnAgregarModulo.addEventListener('click', function() {
        const totalModulos = document.querySelectorAll('.modulo-item').length;
        const numeroRomano = numerosRomanos[totalModulos] || (totalModulos + 1);
        
        const nuevoModulo = moduloTemplate
            .replace(/{INDEX}/g, moduloIndex)
            .replace(/{NUMERO}/g, numeroRomano);
        
        modulosContainer.insertAdjacentHTML('beforeend', nuevoModulo);
        moduloIndex++;

        // Agregar evento al botón de eliminar
        const ultimoModulo = modulosContainer.lastElementChild;
        const btnEliminar = ultimoModulo.querySelector('.btn-eliminar-modulo');
        
        btnEliminar.addEventListener('click', function() {
            if (confirm('¿Está seguro de eliminar este módulo?')) {
                ultimoModulo.remove();
                actualizarNumeracion();
            }
        });

        actualizarContador();
        
        // Scroll suave al nuevo módulo
        ultimoModulo.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Focus en el textarea
        const textarea = ultimoModulo.querySelector('textarea');
        if (textarea) {
            setTimeout(() => textarea.focus(), 300);
        }
    });

    // Validación antes de enviar
    document.getElementById('form-certificado').addEventListener('submit', function(e) {
        const totalModulos = document.querySelectorAll('.modulo-item').length;
        
        if (totalModulos === 0) {
            e.preventDefault();
            alert('Debe agregar al menos un módulo/tema al certificado.');
            return false;
        }
        
        // Validar que todos los campos de texto estén llenos
        const nombreCompleto = document.querySelector('input[name="nombre_completo"]').value.trim();
        const nombreCurso = document.querySelector('input[name="nombre_curso"]').value.trim();
        
        if (!nombreCompleto || !nombreCurso) {
            e.preventDefault();
            alert('Por favor complete todos los campos obligatorios.');
            return false;
        }
    });
    
    // Inicializar contador
    actualizarContador();
});
</script>

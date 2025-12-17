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
            
            <!-- NUEVA SECCIÓN: Datos del Titular (Arquitectura 2025) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-info border-info">
                        <i class="fas fa-id-card"></i> <strong>Nuevo Sistema:</strong> Ingrese primero el <strong>DNI del titular</strong>. 
                        El sistema buscará si ya existe en la base de datos y autocompletará los nombres. 
                        Si es un nuevo titular, complete los nombres manualmente.
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-fingerprint"></i> Identificación del Titular</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Búsqueda de Alumno por DNI ÚNICAMENTE -->
                                <div class="col-md-12 mb-3">
                                    <label for="buscar-alumno" class="form-label fw-bold">
                                        <i class="fas fa-search text-primary"></i> Buscar Alumno por DNI
                                    </label>
                                    <input 
                                        type="text" 
                                        id="buscar-alumno" 
                                        class="form-control form-control-lg" 
                                        placeholder="Ingrese DNI (mínimo 4 caracteres)..."
                                        autocomplete="off"
                                        maxlength="20"
                                    >
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Busque por DNI - se mostrarán hasta 3 resultados
                                    </small>
                                    
                                    <!-- Lista de resultados de la búsqueda -->
                                    <div id="resultados-alumnos" class="list-group mt-2" style="display: none; max-height: 200px; overflow-y: auto;"></div>
                                    
                                    <!-- Mostrar alumno seleccionado -->
                                    <div id="alumno-seleccionado" class="alert alert-success mt-2" style="display: none;">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Alumno seleccionado:</strong> <span id="alumno-seleccionado-texto"></span>
                                        <button type="button" class="btn-close float-end" id="limpiar-alumno"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- DNI del Titular (Campo oculto o manual) -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-id-card"></i> DNI <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('dni', [
                                        'type' => 'text',
                                        'id' => 'dni-titular',
                                        'class' => 'form-control form-control-lg',
                                        'placeholder' => 'Ej: 12345678',
                                        'required' => true,
                                        'label' => false,
                                        'maxlength' => 20
                                    ]) ?>
                                    <small class="text-muted">DNI del titular del certificado</small>
                                </div>

                                <!-- Nombre Completo del Titular -->
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-user"></i> Nombre Completo <span class="text-danger">*</span>
                                    </label>
                                    <?= $this->Form->control('nombre_completo', [
                                        'type' => 'text',
                                        'id' => 'nombre-completo-titular',
                                        'class' => 'form-control form-control-lg',
                                        'placeholder' => 'Ej: Juan Carlos Pérez García',
                                        'required' => true,
                                        'label' => false,
                                        'maxlength' => 200
                                    ]) ?>
                                    <small class="text-muted">Nombre completo del titular</small>
                                </div>
                            </div>

                            <!-- Alerta de titular encontrado -->
                            <div id="titular-encontrado-alert" class="alert alert-success d-none mt-3">
                                <i class="fas fa-check-circle"></i> <strong>Titular encontrado:</strong>
                                <p class="mb-0 mt-2" id="titular-info"></p>
                            </div>

                            <!-- Alerta de titular nuevo -->
                            <div id="titular-nuevo-alert" class="alert alert-warning d-none mt-3">
                                <i class="fas fa-info-circle"></i> <strong>Nuevo titular:</strong> 
                                Se creará un nuevo registro con este DNI.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- COLUMNA IZQUIERDA: Datos del Estudiante y Curso -->
                <div class="col-lg-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-graduate"></i> Información del <?= $tipoDocumento ?></h5>
                        </div>
                        <div class="card-body">
                            <!-- Búsqueda de Curso -->
                            <div class="mb-3">
                                <label for="buscar-curso" class="form-label fw-bold">
                                    <i class="fas fa-search text-info"></i> Buscar Curso Existente
                                </label>
                                <input 
                                    type="text" 
                                    id="buscar-curso" 
                                    class="form-control form-control-lg" 
                                    placeholder="Escriba para buscar un curso registrado (mínimo 2 caracteres)..."
                                    autocomplete="off"
                                >
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Si encuentra el curso, se cargarán automáticamente sus módulos. Si no existe, escríbalo manualmente abajo.
                                </small>
                                
                                <!-- Lista de resultados de cursos -->
                                <div id="resultados-cursos" class="list-group mt-2" style="display: none; max-height: 250px; overflow-y: auto;"></div>
                                
                                <!-- Curso seleccionado -->
                                <div id="curso-seleccionado" class="alert alert-success mt-2" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Curso seleccionado:</strong> <span id="curso-seleccionado-texto"></span>
                                    <button type="button" class="btn-close float-end" id="limpiar-curso"></button>
                                </div>
                            </div>

                            <!-- Campo VISIBLE para el nombre del curso (obligatorio) -->
                            <div class="mb-3">
                                <label for="nombre-curso-input" class="form-label fw-bold">
                                    <i class="fas fa-graduation-cap text-primary"></i> Nombre del Curso <span class="text-danger">*</span>
                                </label>
                                <?= $this->Form->control('nombre_curso', [
                                    'type' => 'text',
                                    'id' => 'nombre-curso-input',
                                    'class' => 'form-control form-control-lg',
                                    'placeholder' => 'Nombre completo del curso o programa',
                                    'required' => true,
                                    'label' => false,
                                    'maxlength' => 255
                                ]) ?>
                                <small class="form-text text-muted">
                                    <i class="fas fa-edit"></i> Este campo se llenará automáticamente si selecciona un curso de la búsqueda, o puede escribirlo manualmente si es un curso nuevo.
                                </small>
                            </div>

                            <!-- Campo oculto para curso_id (solo si se seleccionó de la búsqueda) -->
                            <?= $this->Form->hidden('curso_id', ['id' => 'curso-id-input']) ?>
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
// ============================================
// LOG INMEDIATO - Si no ves esto, hay un error de sintaxis
// ============================================
console.log('%c🚀 SCRIPT GENERAR.PHP CARGADO', 'background: #4CAF50; color: white; padding: 5px; font-size: 16px; font-weight: bold');
console.log('%c📅 Timestamp:', 'color: #2196F3; font-weight: bold', new Date().toLocaleString());
console.log('%c🔧 Esperando DOMContentLoaded...', 'color: #FF9800');

document.addEventListener('DOMContentLoaded', function() {
    console.log('%c✅ DOM CARGADO - Iniciando configuración', 'background: #2196F3; color: white; padding: 5px; font-size: 14px; font-weight: bold');
    
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
        const modulos = document.querySelectorAll('.modulo-item').length;
        modulos.forEach((modulo, index) => {
            const numeroSpan = modulo.querySelector('.modulo-numero-badge');
            if (numeroSpan) {
                numeroSpan.textContent = numerosRomanos[index] || (index + 1);
            }
        });
        actualizarContador();
    }

    // ====================================================================
    // BÚSQUEDA DE ALUMNOS POR DNI ÚNICAMENTE
    // Mínimo 4 caracteres, máximo 3 resultados
    // ====================================================================
    const buscarAlumno = document.getElementById('buscar-alumno');
    const resultadosAlumnos = document.getElementById('resultados-alumnos');
    const alumnoSeleccionado = document.getElementById('alumno-seleccionado');
    const alumnoSeleccionadoTexto = document.getElementById('alumno-seleccionado-texto');
    const limpiarAlumno = document.getElementById('limpiar-alumno');
    
    const dniInput = document.getElementById('dni-titular');
    const nombreCompletoInput = document.getElementById('nombre-completo-titular');
    
    console.log('🔍 Verificando elementos de búsqueda de alumno:');
    console.log('  - buscarAlumno:', buscarAlumno ? '✅ Encontrado' : '❌ NO encontrado');
    console.log('  - resultadosAlumnos:', resultadosAlumnos ? '✅ Encontrado' : '❌ NO encontrado');
    console.log('  - dniInput:', dniInput ? '✅ Encontrado' : '❌ NO encontrado');
    console.log('  - nombreCompletoInput:', nombreCompletoInput ? '✅ Encontrado' : '❌ NO encontrado');
    
    if (!buscarAlumno) {
        console.error('❌ ERROR: No se encontró el elemento #buscar-alumno');
        return;
    }
    
    let timeoutAlumno = null;
    
    console.log('📝 Agregando event listener al input de búsqueda de alumno');
    buscarAlumno.addEventListener('input', function() {
        const dni = this.value.trim();
        
        console.log('=== BUSQUEDA DE ALUMNO INICIADA ===');
        console.log('DNI ingresado:', dni);
        console.log('Longitud:', dni.length);
        
        // Limpiar timeout anterior
        clearTimeout(timeoutAlumno);
        
        // Ocultar resultados si esta vacio o muy corto (mínimo 4 caracteres)
        if (dni.length < 4) {
            console.log('⚠️ DNI muy corto (mínimo 4 caracteres). Búsqueda cancelada.');
            resultadosAlumnos.style.display = 'none';
            resultadosAlumnos.innerHTML = '';
            return;
        }
        
        // Buscar despues de 300ms de inactividad
        console.log('⏱️ Esperando 300ms antes de buscar...');
        timeoutAlumno = setTimeout(function() {
            console.log('🔍 Iniciando búsqueda AJAX...');
            const url = '/cifa_cake/plantillaCake/cifaa/users/buscar-alumnos?dni=' + encodeURIComponent(dni);
            console.log('URL completa:', url);
            
            // Mostrar indicador de carga
            resultadosAlumnos.innerHTML = '<div class="list-group-item text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Buscando...</span></div> Buscando...</div>';
            resultadosAlumnos.style.display = 'block';
            
            fetch(url)
                .then(response => {
                    console.log('✅ Respuesta recibida. Status:', response.status);
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('📦 Datos recibidos del servidor:', data);
                    console.log('Cantidad de resultados:', data ? data.length : 0);
                    resultadosAlumnos.innerHTML = '';
                    
                    if (!data || data.length === 0) {
                        console.log('❌ No se encontraron resultados');
                        resultadosAlumnos.innerHTML = '<div class="list-group-item text-muted text-center">' +
                            '<i class="fas fa-exclamation-circle"></i> No se encontraron alumnos con DNI: <strong>' + dni + '</strong><br>' +
                            '<small class="text-muted">Use el botón "Añadir Usuario" para crear uno nuevo</small>' +
                            '</div>';
                        resultadosAlumnos.style.display = 'block';
                    } else {
                        console.log('✅ Alumnos encontrados:', data.length);
                        data.forEach((alumno, index) => {
                            console.log(`Alumno ${index + 1}:`, alumno);
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            
                            // Datos del titular vinculado
                            const titular = alumno.titulare || {};
                            const dniTitular = titular.dni || 'Sin DNI';
                            const nombreCompleto = titular.nombre_completo || 'Sin nombre';
                            const username = alumno.username || 'Usuario';
                            
                            item.innerHTML = '<div class="d-flex justify-content-between align-items-center">' +
                                '<div>' +
                                '<strong><i class="fas fa-user text-primary"></i> ' + username + '</strong><br>' +
                                '<small class="text-muted">' +
                                '<i class="fas fa-id-card"></i> DNI: <strong>' + dniTitular + '</strong> | ' +
                                '<i class="fas fa-signature"></i> ' + nombreCompleto +
                                '</small>' +
                                '</div>' +
                                '<span class="badge bg-success">' + (index + 1) + '</span>' +
                                '</div>';
                            
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                seleccionarAlumno(dniTitular, nombreCompleto, username);
                            });
                            
                            resultadosAlumnos.appendChild(item);
                        });
                        resultadosAlumnos.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error al buscar alumnos:', error);
                    resultadosAlumnos.innerHTML = '<div class="list-group-item text-danger text-center">' +
                        '<i class="fas fa-times-circle"></i> Error en la búsqueda: ' + error.message +
                        '</div>';
                    resultadosAlumnos.style.display = 'block';
                });
        }, 300);
    });
    
    function seleccionarAlumno(dni, nombreCompleto, username) {
        console.log('=== ALUMNO SELECCIONADO ===');
        console.log('DNI:', dni);
        console.log('Nombre Completo:', nombreCompleto);
        console.log('Username:', username);
        
        // Llenar campos con datos del titular
        dniInput.value = dni;
        nombreCompletoInput.value = nombreCompleto;
        console.log('✅ Campos llenados correctamente');
        console.log('Valor en dniInput:', dniInput.value);
        console.log('Valor en nombreCompletoInput:', nombreCompletoInput.value);
        
        // IMPORTANTE: NO usar readonly porque CakePHP lo ignora en el POST
        // En su lugar, deshabilitamos la edición con JavaScript
        dniInput.setAttribute('data-seleccionado', 'true');
        nombreCompletoInput.setAttribute('data-seleccionado', 'true');
        dniInput.classList.add('bg-light', 'fw-bold');
        nombreCompletoInput.classList.add('bg-light', 'fw-bold');
        
        // Prevenir edición manual
        dniInput.addEventListener('keydown', prevenirEdicion);
        nombreCompletoInput.addEventListener('keydown', prevenirEdicion);
        dniInput.addEventListener('paste', prevenirEdicion);
        nombreCompletoInput.addEventListener('paste', prevenirEdicion);
        
        // Mostrar alumno seleccionado
        alumnoSeleccionadoTexto.innerHTML = '<strong>' + username + '</strong> - ' + nombreCompleto + ' (DNI: ' + dni + ')';
        alumnoSeleccionado.style.display = 'block';
        resultadosAlumnos.style.display = 'none';
        buscarAlumno.value = 'DNI: ' + dni + ' - ' + nombreCompleto;
        buscarAlumno.setAttribute('readonly', true);
    }
    
    function prevenirEdicion(e) {
        if (e.target.getAttribute('data-seleccionado') === 'true') {
            e.preventDefault();
            return false;
        }
    }
    
    limpiarAlumno.addEventListener('click', function() {
        alumnoSeleccionado.style.display = 'none';
        buscarAlumno.value = '';
        buscarAlumno.removeAttribute('readonly');
        resultadosAlumnos.style.display = 'none';
        resultadosAlumnos.innerHTML = '';
        
        // Limpiar y habilitar campos
        dniInput.value = '';
        nombreCompletoInput.value = '';
        dniInput.removeAttribute('data-seleccionado');
        nombreCompletoInput.removeAttribute('data-seleccionado');
        dniInput.classList.remove('bg-light', 'fw-bold');
        nombreCompletoInput.classList.remove('bg-light', 'fw-bold');
        
        // Remover event listeners de prevención
        dniInput.removeEventListener('keydown', prevenirEdicion);
        nombreCompletoInput.removeEventListener('keydown', prevenirEdicion);
        dniInput.removeEventListener('paste', prevenirEdicion);
        nombreCompletoInput.removeEventListener('paste', prevenirEdicion);
    });

    // ====================================================================
    // BÚSQUEDA DE CURSOS
    // ====================================================================
    const buscarCurso = document.getElementById('buscar-curso');
    const resultadosCursos = document.getElementById('resultados-cursos');
    const cursoIdInput = document.getElementById('curso-id-input');
    const nombreCursoInput = document.getElementById('nombre-curso-input');
    const cursoSeleccionado = document.getElementById('curso-seleccionado');
    const cursoSeleccionadoTexto = document.getElementById('curso-seleccionado-texto');
    const limpiarCurso = document.getElementById('limpiar-curso');
    
    console.log('📚 Verificando elementos de búsqueda de curso:');
    console.log('  - buscarCurso:', buscarCurso ? '✅ Encontrado' : '❌ NO encontrado');
    console.log('  - resultadosCursos:', resultadosCursos ? '✅ Encontrado' : '❌ NO encontrado');
    console.log('  - cursoIdInput:', cursoIdInput ? '✅ Encontrado' : '❌ NO encontrado');
    console.log('  - nombreCursoInput:', nombreCursoInput ? '✅ Encontrado' : '❌ NO encontrado');
    
    if (!buscarCurso) {
        console.error('❌ ERROR: No se encontró el elemento #buscar-curso');
        return;
    }
    
    let timeoutCurso = null;
    
    console.log('📝 Agregando event listener al input de búsqueda de curso');
    buscarCurso.addEventListener('input', function() {
        const nombre = this.value.trim();
        
        console.log('=== BUSQUEDA DE CURSO INICIADA ===');
        console.log('Nombre ingresado:', nombre);
        console.log('Longitud:', nombre.length);
        
        clearTimeout(timeoutCurso);
        
        if (nombre.length < 2) {
            console.log('⚠️ Texto muy corto (mínimo 2 caracteres). Búsqueda cancelada.');
            resultadosCursos.style.display = 'none';
            resultadosCursos.innerHTML = '';
            return;
        }
        
        console.log('⏱️ Esperando 300ms antes de buscar...');
        timeoutCurso = setTimeout(function() {
            console.log('🔍 Iniciando búsqueda de curso...');
            const url = '/cifa_cake/plantillaCake/cifaa/inscripciones/buscar-cursos?nombre=' + encodeURIComponent(nombre);
            console.log('URL completa:', url);
            
            resultadosCursos.innerHTML = '<div class="list-group-item text-center"><div class="spinner-border spinner-border-sm" role="status"></div> Buscando...</div>';
            resultadosCursos.style.display = 'block';
            
            fetch(url)
                .then(response => {
                    console.log('✅ Respuesta de cursos recibida. Status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('📦 Cursos recibidos:', data);
                    console.log('Cantidad de cursos:', data ? data.length : 0);
                    resultadosCursos.innerHTML = '';
                    
                    if (data.length === 0) {
                        console.log('❌ No se encontraron cursos');
                        resultadosCursos.innerHTML = '<div class="list-group-item text-center bg-light">' +
                            '<i class="fas fa-info-circle text-primary"></i> <strong>No se encontró ningún curso con ese nombre</strong><br>' +
                            '<small class="text-muted">💡 Puede escribir el nombre del curso manualmente en el campo de abajo</small></div>';
                        resultadosCursos.style.display = 'block';
                    } else {
                        console.log('✅ Cursos encontrados:', data.length);
                        data.forEach((curso, index) => {
                            console.log(`Curso ${index + 1}:`, curso);
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = '<div class="d-flex justify-content-between align-items-center">' +
                                '<div><strong>' + curso.titulo + '</strong><br>' +
                                '<small class="text-muted">Nivel: ' + (curso.nivel || 'N/A') + ' | Categoría: ' + (curso.categoria || 'N/A') + '</small></div>' +
                                '<span class="badge bg-info">' + (index + 1) + '</span></div>';
                            
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                seleccionarCurso(curso.id, curso.titulo);
                            });
                            
                            resultadosCursos.appendChild(item);
                        });
                        resultadosCursos.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error al buscar cursos:', error);
                    resultadosCursos.innerHTML = '<div class="list-group-item text-danger"><i class="fas fa-times-circle"></i> Error en la búsqueda</div>';
                    resultadosCursos.style.display = 'block';
                });
        }, 300);
    });
    
    function seleccionarCurso(id, titulo) {
        console.log('=== CURSO SELECCIONADO ===');
        console.log('ID del curso:', id);
        console.log('Título:', titulo);
        
        // Llenar campos con el curso seleccionado
        cursoIdInput.value = id;
        nombreCursoInput.value = titulo.toUpperCase();
        
        // Mostrar badge de curso seleccionado
        cursoSeleccionadoTexto.textContent = titulo;
        cursoSeleccionado.style.display = 'block';
        resultadosCursos.style.display = 'none';
        
        // Limpiar búsqueda (el usuario ya tiene el nombre en el campo principal)
        buscarCurso.value = '';
        
        console.log('✅ Campo nombre_curso llenado con:', nombreCursoInput.value);
        console.log('🔄 Cargando módulos del curso...');
        
        // Cargar módulos del curso automáticamente
        cargarModulosCurso(id);
    }
    
    function cargarModulosCurso(cursoId) {
        console.log('=== CARGANDO MÓDULOS DEL CURSO ===');
        console.log('Curso ID:', cursoId);
        const url = '/cifa_cake/plantillaCake/cifaa/cursos/getModulos/' + cursoId;
        console.log('URL de módulos:', url);
        
        fetch(url)
            .then(response => {
                console.log('✅ Respuesta de módulos recibida. Status:', response.status);
                if (!response.ok) {
                    throw new Error('Error HTTP: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                console.log('📄 Respuesta RAW del servidor:', text);
                try {
                    const data = JSON.parse(text);
                    console.log('📦 Módulos recibidos:', data);
                    if (data.error) {
                        console.error('❌ Error del servidor:', data.message);
                        alert('Error al cargar módulos: ' + data.message);
                        return;
                    }
                    if (data && data.modulos && data.modulos.length > 0) {
                        console.log('✅ Cantidad de módulos:', data.modulos.length);
                    // Limpiar módulos existentes
                    modulosContainer.innerHTML = '';
                    moduloIndex = 0;
                    
                    // Agregar cada módulo del curso
                    data.modulos.forEach((modulo, index) => {
                        console.log(`Procesando módulo ${index + 1}:`, modulo);
                        const numeroRomano = numerosRomanos[index] || (index + 1);
                        const nuevoModulo = moduloTemplate
                            .replace(/{INDEX}/g, moduloIndex)
                            .replace(/{NUMERO}/g, numeroRomano);
                        
                        modulosContainer.insertAdjacentHTML('beforeend', nuevoModulo);
                        
                        // Llenar el título del módulo
                        const ultimoModulo = modulosContainer.lastElementChild;
                        const textarea = ultimoModulo.querySelector('textarea');
                        if (textarea && modulo.titulo) {
                            textarea.value = modulo.titulo;
                            console.log(`✅ Módulo ${numeroRomano} agregado:`, modulo.titulo);
                        }
                        
                        // Agregar evento al botón de eliminar
                        const btnEliminar = ultimoModulo.querySelector('.btn-eliminar-modulo');
                        if (btnEliminar) {
                            btnEliminar.addEventListener('click', function() {
                                if (confirm('¿Está seguro de eliminar este módulo?')) {
                                    ultimoModulo.remove();
                                    actualizarNumeracion();
                                }
                            });
                        }
                        
                        moduloIndex++;
                    });
                    
                        actualizarContador();
                    } else {
                        console.log('ℹ️ El curso no tiene módulos o la respuesta está vacía');
                    }
                } catch (e) {
                    console.error('❌ Error al parsear JSON:', e);
                    console.error('Texto recibido:', text);
                    alert('Error: La respuesta del servidor no es JSON válido');
                }
            })
            .catch(error => {
                console.error('❌ Error al cargar módulos:', error);
                alert('Error de red al cargar módulos: ' + error.message);
            });
    }
    
    limpiarCurso.addEventListener('click', function() {
        console.log('🧹 Limpiando curso seleccionado...');
        
        // Limpiar campos
        cursoIdInput.value = '';
        nombreCursoInput.value = '';
        cursoSeleccionado.style.display = 'none';
        buscarCurso.value = '';
        resultadosCursos.style.display = 'none';
        
        // Limpiar módulos cargados automáticamente
        modulosContainer.innerHTML = '';
        moduloIndex = 0;
        actualizarContador();
        
        console.log('✅ Curso limpiado. Puede buscar otro o escribir manualmente.');
    });

    // ====================================================================
    // AGREGAR MÓDULO (CORREGIDO)
    // ====================================================================
    if (btnAgregarModulo) {
        // Clonar botón para remover listeners duplicados
        const btnNuevo = btnAgregarModulo.cloneNode(true);
        btnAgregarModulo.parentNode.replaceChild(btnNuevo, btnAgregarModulo);
        
        // Agregar listener al botón nuevo
        btnNuevo.addEventListener('click', function(e) {
            e.preventDefault();
            
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
            
            if (btnEliminar) {
                btnEliminar.addEventListener('click', function() {
                    if (confirm('¿Está seguro de eliminar este módulo?')) {
                        ultimoModulo.remove();
                        actualizarNumeracion();
                    }
                });
            }

            actualizarContador();
            
            // Scroll suave al nuevo módulo
            ultimoModulo.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Focus en el textarea
            const textarea = ultimoModulo.querySelector('textarea');
            if (textarea) {
                setTimeout(() => textarea.focus(), 300);
            }
        });
    }

    // ====================================================================
    // VALIDACIÓN ANTES DE ENVIAR
    // ====================================================================
    document.getElementById('form-certificado').addEventListener('submit', function(e) {
        console.log('=== VALIDANDO FORMULARIO ANTES DE ENVIAR ===');
        
        const dni = dniInput.value.trim();
        const nombreCompleto = nombreCompletoInput.value.trim();
        const totalModulos = document.querySelectorAll('.modulo-item').length;
        const nombreCurso = nombreCursoInput.value.trim();
        
        console.log('Datos a enviar:');
        console.log('  - DNI:', dni);
        console.log('  - Nombre Completo:', nombreCompleto);
        console.log('  - Nombre Curso:', nombreCurso);
        console.log('  - Total Módulos:', totalModulos);
        console.log('  - Curso ID:', cursoIdInput.value);
        
        if (!dni) {
            e.preventDefault();
            console.error('❌ Validación fallida: DNI vacío');
            alert('Por favor ingrese el DNI del titular.');
            dniInput.focus();
            return false;
        }
        
        if (!nombreCompleto) {
            e.preventDefault();
            console.error('❌ Validación fallida: Nombre completo vacío');
            alert('Por favor complete el nombre completo del titular.');
            nombreCompletoInput.focus();
            return false;
        }
        
        if (totalModulos === 0) {
            e.preventDefault();
            console.error('❌ Validación fallida: No hay módulos');
            alert('Debe agregar al menos un módulo/tema al certificado.');
            return false;
        }
        
        if (!nombreCurso) {
            e.preventDefault();
            console.error('❌ Validación fallida: Nombre de curso vacío');
            alert('Por favor complete el nombre del curso.');
            return false;
        }
        
        console.log('✅ Validación exitosa - Enviando formulario');
        return true;
    });
    
    // Inicializar contador
    actualizarContador();
});
</script>

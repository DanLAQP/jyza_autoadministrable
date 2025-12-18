<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 */
$this->assign('title', 'Matricular Alumno');
?>

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-user-plus"></i> Matricular Alumno
            </h3>
            <p class="mb-0 mt-2 small">
                <i class="fas fa-info-circle"></i> Matriculacion directa: El alumno quedara inscrito inmediatamente con estado <strong>APROBADA</strong> y podra acceder al curso.
            </p>
        </div>
        <div class="card-body">
            <?= $this->Form->create($inscripcione, ['class' => 'needs-validation', 'novalidate' => true]) ?>
            
            <div class="row g-4">
                <!-- Busqueda de Alumno por DNI -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="buscar-alumno" class="form-label fw-bold">
                            <i class="fas fa-user-graduate text-primary"></i> Buscar Alumno por DNI
                        </label>
                        <input 
                            type="text" 
                            id="buscar-alumno" 
                            class="form-control form-control-lg" 
                            placeholder="Ingrese DNI o nombre (min. 3 caracteres)..."
                            autocomplete="off"
                        >
                        <small class="form-text text-muted">
                            <i class="fas fa-search"></i> Busca por DNI o nombre de usuario (mínimo 3 caracteres)
                        </small>
                        
                        <!-- Lista de resultados -->
                        <div id="resultados-alumnos" class="list-group mt-2" style="display: none; max-height: 250px; overflow-y: auto;"></div>
                        
                        <!-- Campo oculto para almacenar el ID seleccionado -->
                        <?= $this->Form->control('usuario_id', [
                            'type' => 'hidden',
                            'id' => 'usuario-id',
                            'required' => true
                        ]) ?>
                        
                        <!-- Mostrar alumno seleccionado -->
                        <div id="alumno-seleccionado" class="alert alert-success mt-2" style="display: none;">
                            <strong>Alumno seleccionado:</strong> <span id="alumno-seleccionado-texto"></span>
                            <button type="button" class="btn-close float-end" id="limpiar-alumno"></button>
                        </div>
                    </div>
                </div>

                <!-- Busqueda de Curso por Nombre -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="buscar-curso" class="form-label fw-bold">
                            <i class="fas fa-book text-info"></i> Buscar Curso por Nombre
                        </label>
                        <input 
                            type="text" 
                            id="buscar-curso" 
                            class="form-control form-control-lg" 
                            placeholder="Escriba el nombre del curso (min. 2 caracteres)..."
                            autocomplete="off"
                        >
                        <small class="form-text text-muted">
                            <i class="fas fa-search"></i> Búsqueda dinámica - encuentra Python, Java, HTML, MySQL, etc.
                        </small>
                        
                        <!-- Lista de resultados -->
                        <div id="resultados-cursos" class="list-group mt-2" style="display: none; max-height: 250px; overflow-y: auto;"></div>
                        
                        <!-- Campo oculto para almacenar el ID seleccionado -->
                        <?= $this->Form->control('curso_id', [
                            'type' => 'hidden',
                            'id' => 'curso-id',
                            'required' => true
                        ]) ?>
                        
                        <!-- Mostrar curso seleccionado -->
                        <div id="curso-seleccionado" class="alert alert-info mt-2" style="display: none;">
                            <strong>Curso seleccionado:</strong> <span id="curso-seleccionado-texto"></span>
                            <button type="button" class="btn-close float-end" id="limpiar-curso"></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informacion de Estado -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Configuracion Automatica</h5>
                            <p class="mb-0">
                                Al matricular, la inscripcion se creara con los siguientes valores:
                            </p>
                            <ul class="mb-0 mt-2">
                                <li><strong>Estado:</strong> Aprobada (acceso inmediato)</li>
                                <li><strong>Progreso:</strong> 0% (inicio del curso)</li>
                                <li><strong>Fecha:</strong> <?= date('d/m/Y H:i') ?> (ahora)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Accion -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <div class="btn-group btn-group-lg" role="group">
                        <button type="submit" class="btn btn-success px-5" id="btn-matricular">
                            <i class="fas fa-check-circle"></i> Matricular Alumno
                        </button>
                        <?= $this->Html->link(
                            '<i class="fas fa-times-circle"></i> Cancelar',
                            ['action' => 'index'],
                            [
                                'class' => 'btn btn-secondary px-5',
                                'escape' => false
                            ]
                        ) ?>
                    </div>
                </div>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>

    <!-- Tarjeta de Ayuda -->
    <div class="card shadow-sm mt-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-question-circle"></i> Diferencia: Matricular como Admin vs Solicitar como Estudiante</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-success"><i class="fas fa-user-shield"></i> Matricular como Administrador</h6>
                    <ul>
                        <li><strong>Quien:</strong> Solo administradores</li>
                        <li><strong>Proceso:</strong> Directo, sin aprobacion previa</li>
                        <li><strong>Estado:</strong> Inscripcion aprobada inmediatamente</li>
                        <li><strong>Acceso:</strong> El alumno puede entrar al curso de inmediato</li>
                        <li><strong>Uso:</strong> Matriculas masivas o casos especiales</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-info"><i class="fas fa-user-graduate"></i> Solicitar como Estudiante</h6>
                    <ul>
                        <li><strong>Quien:</strong> Cualquier estudiante registrado</li>
                        <li><strong>Proceso:</strong> Solicitud que debe ser aprobada por admin</li>
                        <li><strong>Estado:</strong> Pendiente hasta que admin apruebe</li>
                        <li><strong>Acceso:</strong> Solo despues de aprobacion del admin</li>
                        <li><strong>Uso:</strong> Proceso normal de inscripcion de estudiantes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script de Busqueda y Validacion -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    const btnMatricular = document.getElementById('btn-matricular');
    
    // BUSQUEDA DE ALUMNOS POR DNI
    const buscarAlumno = document.getElementById('buscar-alumno');
    const resultadosAlumnos = document.getElementById('resultados-alumnos');
    const usuarioIdInput = document.getElementById('usuario-id');
    const alumnoSeleccionado = document.getElementById('alumno-seleccionado');
    const alumnoSeleccionadoTexto = document.getElementById('alumno-seleccionado-texto');
    const limpiarAlumno = document.getElementById('limpiar-alumno');
    
    let timeoutAlumno = null;
    
    buscarAlumno.addEventListener('input', function() {
        const dni = this.value.trim();
        
        // Limpiar timeout anterior
        clearTimeout(timeoutAlumno);
        
        // Ocultar resultados si esta vacio o muy corto
        if (dni.length < 3) {
            resultadosAlumnos.style.display = 'none';
            resultadosAlumnos.innerHTML = '';
            return;
        }
        
        // Buscar despues de 300ms de inactividad
        timeoutAlumno = setTimeout(function() {
            fetch('<?= $this->Url->build(['controller' => 'Inscripciones', 'action' => 'buscarAlumnos']) ?>?dni=' + encodeURIComponent(dni))
                .then(response => response.json())
                .then(data => {
                    resultadosAlumnos.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultadosAlumnos.innerHTML = '<div class="list-group-item text-muted"><i class="fas fa-info-circle"></i> No se encontraron alumnos con ese DNI</div>';
                        resultadosAlumnos.style.display = 'block';
                    } else {
                        data.forEach(alumno => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = '<strong>' + alumno.username + '</strong><br>' +
                                           '<small class="text-muted"><i class="fas fa-id-card"></i> DNI: ' + alumno.dni + '</small>';
                            
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                seleccionarAlumno(alumno.id, alumno.username, alumno.dni);
                            });
                            
                            resultadosAlumnos.appendChild(item);
                        });
                        resultadosAlumnos.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error al buscar alumnos:', error);
                    resultadosAlumnos.innerHTML = '<div class="list-group-item text-danger">Error en la busqueda</div>';
                    resultadosAlumnos.style.display = 'block';
                });
        }, 300);
    });
    
    function seleccionarAlumno(id, nombre, dni) {
        usuarioIdInput.value = id;
        alumnoSeleccionadoTexto.textContent = nombre + ' (DNI: ' + dni + ')';
        alumnoSeleccionado.style.display = 'block';
        resultadosAlumnos.style.display = 'none';
        buscarAlumno.value = nombre + ' (DNI: ' + dni + ')';
        buscarAlumno.setAttribute('readonly', true);
    }
    
    limpiarAlumno.addEventListener('click', function() {
        usuarioIdInput.value = '';
        alumnoSeleccionado.style.display = 'none';
        buscarAlumno.value = '';
        buscarAlumno.removeAttribute('readonly');
    });
    
    // BUSQUEDA DE CURSOS POR NOMBRE
    const buscarCurso = document.getElementById('buscar-curso');
    const resultadosCursos = document.getElementById('resultados-cursos');
    const cursoIdInput = document.getElementById('curso-id');
    const cursoSeleccionado = document.getElementById('curso-seleccionado');
    const cursoSeleccionadoTexto = document.getElementById('curso-seleccionado-texto');
    const limpiarCurso = document.getElementById('limpiar-curso');
    
    let timeoutCurso = null;
    
    buscarCurso.addEventListener('input', function() {
        const nombre = this.value.trim();
        
        // Limpiar timeout anterior
        clearTimeout(timeoutCurso);
        
        // Ocultar resultados si esta vacio o muy corto
        if (nombre.length < 2) {
            resultadosCursos.style.display = 'none';
            resultadosCursos.innerHTML = '';
            return;
        }
        
        // Buscar despues de 300ms de inactividad
        timeoutCurso = setTimeout(function() {
            fetch('<?= $this->Url->build(['controller' => 'Inscripciones', 'action' => 'buscarCursos']) ?>?nombre=' + encodeURIComponent(nombre))
                .then(response => response.json())
                .then(data => {
                    resultadosCursos.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultadosCursos.innerHTML = '<div class="list-group-item text-muted"><i class="fas fa-info-circle"></i> No se encontraron cursos</div>';
                        resultadosCursos.style.display = 'block';
                    } else {
                        data.forEach(curso => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = '<strong>' + curso.titulo + '</strong><br>' +
                                           '<small class="text-muted">Nivel: ' + (curso.nivel || 'N/A') + ' | Categoría: ' + (curso.categoria || 'N/A') + '</small>';
                            
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
                    resultadosCursos.innerHTML = '<div class="list-group-item text-danger">Error en la busqueda</div>';
                    resultadosCursos.style.display = 'block';
                });
        }, 300);
    });
    
    function seleccionarCurso(id, titulo) {
        cursoIdInput.value = id;
        cursoSeleccionadoTexto.textContent = titulo;
        cursoSeleccionado.style.display = 'block';
        resultadosCursos.style.display = 'none';
        buscarCurso.value = titulo;
        buscarCurso.setAttribute('readonly', true);
    }
    
    limpiarCurso.addEventListener('click', function() {
        cursoIdInput.value = '';
        cursoSeleccionado.style.display = 'none';
        buscarCurso.value = '';
        buscarCurso.removeAttribute('readonly');
    });
    
    // VALIDACION Y ENVIO DEL FORMULARIO
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        // PASO 1: Validar que se hayan seleccionado alumno y curso
        const usuarioId = usuarioIdInput.value;
        const cursoId = cursoIdInput.value;
        
        if (!usuarioId || !cursoId) {
            let mensajeError = 'Por favor complete los siguientes campos:\n\n';
            if (!usuarioId) mensajeError += '- Alumno (busque por DNI)\n';
            if (!cursoId) mensajeError += '- Curso (busque por nombre)\n';
            
            alert(mensajeError);
            return false;
        }
        
        // PASO 2: Confirmar matricula
        const alumnoTexto = alumnoSeleccionadoTexto.textContent;
        const cursoTexto = cursoSeleccionadoTexto.textContent;
        
        const confirmar = confirm(
            'Esta seguro de matricular al siguiente alumno?\n\n' +
            'Alumno: ' + alumnoTexto + '\n' +
            'Curso: ' + cursoTexto + '\n\n' +
            'La inscripcion sera aprobada inmediatamente.'
        );
        
        if (!confirmar) {
            return false;
        }
        
        // PASO 3: Deshabilitar boton y enviar formulario
        btnMatricular.disabled = true;
        btnMatricular.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Matriculando...';
        
        // Enviar el formulario
        form.submit();
    });
});
</script>

<style>
    /* Placeholder text styling for dark forms */
    .form-control::placeholder,
    .form-select::placeholder {
        color: #8eb4d6 !important;
        opacity: 1 !important;
    }

    .form-select-lg, .form-control-lg {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
    }
    
    .card-header p {
        font-size: 0.9rem;
    }
    
    .form-label {
        font-size: 1.05rem;
        margin-bottom: 0.5rem;
    }
    
    .alert ul {
        padding-left: 1.5rem;
    }
    
    .btn-group-lg .btn {
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
    }
    
    /* Estilos para resultados de busqueda */
    .list-group-item-action {
        cursor: pointer;
        transition: all 0.2s;
        background-color: #343a40 !important;
        color: #ffffff !important;
        border-color: #495057 !important;
    }
    
    .list-group-item-action:hover {
        background-color: #495057 !important;
        border-left: 4px solid #007bff !important;
        color: #ffffff !important;
    }
    
    .list-group-item-action strong {
        color: #ffffff !important;
        font-weight: 600;
    }
    
    .list-group-item-action small {
        color: #adb5bd !important;
    }
    
    #resultados-alumnos::-webkit-scrollbar,
    #resultados-cursos::-webkit-scrollbar {
        width: 8px;
    }
    
    #resultados-alumnos::-webkit-scrollbar-thumb,
    #resultados-cursos::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        border-radius: 4px;
    }
    
    #alumno-seleccionado,
    #curso-seleccionado {
        position: relative;
        padding-right: 40px;
    }
    
    #alumno-seleccionado .btn-close,
    #curso-seleccionado .btn-close {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }
</style>

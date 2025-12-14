<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Curso $curso
 * @var iterable<\App\Model\Entity\Inscripcione> $inscripciones
 */
$this->assign('title', 'Administrar Inscripciones - ' . h($curso->titulo));
?>

<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-info d-inline-block">
                <i class="fas fa-users-cog"></i> Administrar Inscripciones
            </h2>
            <h4 class="text-light mt-2">
                <i class="fas fa-book me-2"></i><?= h($curso->titulo) ?>
            </h4>
            <p class="text-muted">Gestiona los alumnos inscritos en este curso</p>
        </div>
        <div class="col-md-4 text-end">
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left"></i> Volver al Curso',
                ['controller' => 'Cursos', 'action' => 'view', $curso->id],
                ['class' => 'btn btn-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <!-- Formulario de Matriculación Rápida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm bg-dark border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus"></i> Matricular Nuevo Alumno
                    </h5>
                </div>
                <div class="card-body">
                    <?= $this->Form->create(null, ['type' => 'post']) ?>
                    <?= $this->Form->hidden('action', ['value' => 'matricular']) ?>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="buscar-alumno" class="form-label fw-bold">
                                    <i class="fas fa-search text-primary"></i> Buscar Alumno por DNI o Nombre
                                </label>
                                <input 
                                    type="text" 
                                    id="buscar-alumno" 
                                    class="form-control form-control-lg" 
                                    placeholder="Ingrese DNI o nombre (min. 3 caracteres)..."
                                    autocomplete="off"
                                >
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Busca por DNI o nombre de usuario (mínimo 3 caracteres)
                                </small>
                                
                                <!-- Lista de resultados -->
                                <div id="resultados-alumnos" class="list-group mt-2" style="display: none; max-height: 250px; overflow-y: auto;"></div>
                                
                                <!-- Campo oculto -->
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
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-user-plus"></i> Matricular Alumno
                            </button>
                        </div>
                    </div>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Alumnos Inscritos -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm bg-dark">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list"></i> Alumnos Inscritos 
                        <span class="badge bg-light text-dark ms-2"><?= count($inscripciones) ?></span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 25%;"><i class="fas fa-user"></i> Alumno</th>
                                    <th style="width: 15%;"><i class="fas fa-id-card"></i> DNI</th>
                                    <th style="width: 15%;"><i class="fas fa-chart-line"></i> Progreso</th>
                                    <th style="width: 12%;"><i class="fas fa-info-circle"></i> Estado</th>
                                    <th style="width: 13%;"><i class="fas fa-calendar"></i> Fecha</th>
                                    <th style="width: 15%;" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($inscripciones->toArray())): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No hay alumnos inscritos en este curso aún</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($inscripciones as $key => $inscripcion): ?>
                                    <tr>
                                        <td class="text-muted"><?= $key + 1 ?></td>
                                        <td>
                                            <i class="fas fa-user-circle text-primary me-1"></i>
                                            <strong><?= h($inscripcion->user->username) ?></strong>
                                        </td>
                                        <td>
                                            <?php if (!empty($inscripcion->user->dni)): ?>
                                                <code class="text-info"><?= h($inscripcion->user->dni) ?></code>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar <?= $inscripcion->progreso == 100 ? 'bg-success' : 'bg-info' ?>" 
                                                     role="progressbar" 
                                                     style="width: <?= $inscripcion->progreso ?>%;"
                                                     aria-valuenow="<?= $inscripcion->progreso ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <?= $inscripcion->progreso ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $badgeClass = [
                                                'pendiente' => 'warning',
                                                'aprobada' => 'success',
                                                'rechazada' => 'danger'
                                            ][$inscripcion->estado] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $badgeClass ?>">
                                                <?= ucfirst(h($inscripcion->estado)) ?>
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            <?= h($inscripcion->created->format('d/m/Y')) ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-edit"></i>',
                                                    ['action' => 'edit', $inscripcion->id],
                                                    [
                                                        'escape' => false,
                                                        'class' => 'btn btn-sm btn-warning',
                                                        'title' => 'Editar progreso',
                                                        'data-bs-toggle' => 'tooltip'
                                                    ]
                                                ) ?>
                                                <?= $this->Form->postLink(
                                                    '<i class="fas fa-user-times"></i>',
                                                    ['action' => 'delete', $inscripcion->id],
                                                    [
                                                        'confirm' => __('¿Desmatricular a {0} de este curso?', $inscripcion->user->username),
                                                        'escape' => false,
                                                        'class' => 'btn btn-sm btn-danger',
                                                        'title' => 'Desmatricular',
                                                        'data-bs-toggle' => 'tooltip'
                                                    ]
                                                ) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Activar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // BUSQUEDA DE ALUMNOS
    const buscarAlumno = document.getElementById('buscar-alumno');
    const resultadosAlumnos = document.getElementById('resultados-alumnos');
    const usuarioIdInput = document.getElementById('usuario-id');
    const alumnoSeleccionado = document.getElementById('alumno-seleccionado');
    const alumnoSeleccionadoTexto = document.getElementById('alumno-seleccionado-texto');
    const limpiarAlumno = document.getElementById('limpiar-alumno');
    
    let timeoutAlumno = null;
    
    buscarAlumno.addEventListener('input', function() {
        const dni = this.value.trim();
        
        clearTimeout(timeoutAlumno);
        
        if (dni.length < 3) {
            resultadosAlumnos.style.display = 'none';
            resultadosAlumnos.innerHTML = '';
            return;
        }
        
        timeoutAlumno = setTimeout(function() {
            fetch('<?= $this->Url->build(['controller' => 'Inscripciones', 'action' => 'buscarAlumnos']) ?>?dni=' + encodeURIComponent(dni))
                .then(response => response.json())
                .then(data => {
                    resultadosAlumnos.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultadosAlumnos.innerHTML = '<div class="list-group-item text-muted"><i class="fas fa-info-circle"></i> No se encontraron alumnos</div>';
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
                    resultadosAlumnos.innerHTML = '<div class="list-group-item text-danger">Error en la búsqueda</div>';
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
});
</script>

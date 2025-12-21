<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 * @var \Cake\Collection\CollectionInterface|string[] $titulares
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-certificate"></i> 
                    Generar Certificado / Diplomado
                </h3>
            </div>

            <?= $this->Form->create($certificado, ['class' => 'form-horizontal']) ?>
            <div class="card-body">
                
                <!-- Sección 1: Tipo de Certificado -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipo de Certificado <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="custom-control custom-radio">
                            <input 
                                type="radio" 
                                id="tipoCertificado" 
                                name="tipo" 
                                value="certificado" 
                                class="custom-control-input"
                                checked
                            >
                            <label class="custom-control-label" for="tipoCertificado">
                                <i class="fas fa-award"></i> Certificado
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input 
                                type="radio" 
                                id="tipoDiplomado" 
                                name="tipo" 
                                value="diplomado" 
                                class="custom-control-input"
                            >
                            <label class="custom-control-label" for="tipoDiplomado">
                                <i class="fas fa-medal"></i> Diplomado
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Sección 2: Datos del Estudiante/Titular -->
                <h5 class="text-info mb-3">
                    <i class="fas fa-user-graduate"></i> Datos del Estudiante
                </h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Usuario del Sistema</label>
                    <div class="col-sm-10">
                        <?= $this->Form->control(
                            'usuario_id',
                            [
                                'type' => 'select',
                                'options' => $users,
                                'empty' => '-- Seleccionar usuario --',
                                'class' => 'form-control form-control-border',
                                'id' => 'usuarioId',
                                'label' => false
                            ]
                        ) ?>
                        <small class="text-muted">Opcional. Si está vacío, complete los datos del titular.</small>
                    </div>
                </div>

                <!-- Sección de Titulares (si no hay usuario) -->
                <div id="seccionTitular" style="display: block;">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre Completo del Titular</label>
                        <div class="col-sm-10">
                            <?= $this->Form->control(
                                'nombre_titular',
                                [
                                    'type' => 'text',
                                    'placeholder' => 'Ej: Juan Pérez García',
                                    'class' => 'form-control form-control-border',
                                    'label' => false
                                ]
                            ) ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">DNI del Titular</label>
                        <div class="col-sm-10">
                            <?= $this->Form->control(
                                'dni_titular',
                                [
                                    'type' => 'text',
                                    'placeholder' => 'Ej: 12345678',
                                    'class' => 'form-control form-control-border',
                                    'label' => false
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Sección 3: Información del Curso -->
                <h5 class="text-info mb-3">
                    <i class="fas fa-book"></i> Información del Curso
                </h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Curso de Base de Datos</label>
                    <div class="col-sm-10">
                        <?= $this->Form->control(
                            'curso_id',
                            [
                                'type' => 'select',
                                'options' => $cursos,
                                'empty' => '-- Seleccionar curso --',
                                'class' => 'form-control form-control-border',
                                'id' => 'cursoId',
                                'label' => false
                            ]
                        ) ?>
                        <small class="text-muted">Opcional. Si selecciona un curso, aparecerán sus módulos automáticamente.</small>
                    </div>
                </div>

                <!-- Campo de Curso Manual (mostrar solo si no se selecciona curso) -->
                <div id="seccionCursoManual" style="display: block;">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre del Curso (Manual)</label>
                        <div class="col-sm-10">
                            <?= $this->Form->control(
                                'nombre_curso_manual',
                                [
                                    'type' => 'text',
                                    'placeholder' => 'Ej: Programación en PHP Avanzado',
                                    'class' => 'form-control form-control-border',
                                    'id' => 'cursoManual',
                                    'label' => false
                                ]
                            ) ?>
                            <small class="text-muted">Use esto si el curso no está en la base de datos.</small>
                        </div>
                    </div>
                </div>

                <!-- Módulos del Curso Seleccionado (automáticos) -->
                <div id="seccionModulosAutomaticos" style="display: none;">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Módulos del Curso</label>
                        <div class="col-sm-10">
                            <div id="listaModulos" class="list-group">
                                <!-- Se llena dinámicamente con AJAX -->
                            </div>
                            <!-- Campo oculto para capturar IDs seleccionados -->
                            <input type="hidden" id="modulosIds" name="modulos_ids" value="">
                        </div>
                    </div>
                </div>

                <!-- Módulos Manuales (si se ingresa curso manual) -->
                <div id="seccionModulosManual" style="display: none;">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Módulos (Manual)</label>
                        <div class="col-sm-10">
                            <!-- Lista de módulos manuales existentes -->
                            <div id="listaModulosExistentes" class="list-group mb-3">
                                <!-- Se llena dinámicamente con JavaScript -->
                            </div>
                            
                            <!-- Campo para agregar nuevos módulos -->
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    id="nuevoModuloManual" 
                                    class="form-control form-control-border" 
                                    placeholder="Escriba un nuevo módulo y presione Agregar"
                                >
                                <button 
                                    type="button" 
                                    id="agregarModuloBtn" 
                                    class="btn btn-outline-success"
                                >
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                            
                            <!-- Campo oculto para guardar módulos manuales -->
                            <input type="hidden" id="modulosManualIds" name="modulos" value="">
                            
                            <small class="text-muted d-block mt-2">Los módulos se guardarán automáticamente.</small>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Sección 4: Detalles del Certificado -->
                <h5 class="text-info mb-3">
                    <i class="fas fa-file-alt"></i> Detalles del Certificado
                </h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nota Final <span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <?= $this->Form->control(
                            'nota_final',
                            [
                                'type' => 'number',
                                'step' => '0.01',
                                'min' => '0',
                                'max' => '20',
                                'placeholder' => '0.00',
                                'class' => 'form-control form-control-border',
                                'label' => false,
                                'id' => 'nota-final'
                            ]
                        ) ?>
                    </div>

                    <label class="col-sm-2 col-form-label">Horas Lectivas <span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <?= $this->Form->control(
                            'horas_lectivas',
                            [
                                'type' => 'number',
                                'min' => '0',
                                'placeholder' => 'Ej: 120',
                                'class' => 'form-control form-control-border',
                                'label' => false,
                                'id' => 'horas-lectivas'
                            ]
                        ) ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Duración (meses)</label>
                    <div class="col-sm-4">
                        <?= $this->Form->control(
                            'duracion_meses',
                            [
                                'type' => 'number',
                                'min' => '0',
                                'placeholder' => 'Ej: 3',
                                'class' => 'form-control form-control-border',
                                'label' => false
                            ]
                        ) ?>
                    </div>

                    <label class="col-sm-2 col-form-label">Nombre del Gerente</label>
                    <div class="col-sm-4">
                        <?= $this->Form->control(
                            'nombre_gerente',
                            [
                                'type' => 'text',
                                'placeholder' => 'Nombre del gerente',
                                'class' => 'form-control form-control-border',
                                'label' => false,
                                'id' => 'nombre-gerente'
                            ]
                        ) ?>
                    </div>
                </div>

                <hr>

                <!-- Sección 5: Fechas -->
                <h5 class="text-info mb-3">
                    <i class="fas fa-calendar-alt"></i> Fechas
                </h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Fecha de Inicio</label>
                    <div class="col-sm-4">
                        <?= $this->Form->control(
                            'fecha_inicio',
                            [
                                'type' => 'date',
                                'class' => 'form-control form-control-border',
                                'label' => false,
                                'id' => 'fecha-inicio'
                            ]
                        ) ?>
                    </div>

                    <label class="col-sm-2 col-form-label">Fecha de Finalización</label>
                    <div class="col-sm-4">
                        <?= $this->Form->control(
                            'fecha_fin',
                            [
                                'type' => 'date',
                                'class' => 'form-control form-control-border',
                                'label' => false,
                                'id' => 'fecha-fin'
                            ]
                        ) ?>
                    </div>
                </div>

                <hr>

                <!-- Sección 6: Código Único -->
                <h5 class="text-info mb-3">
                    <i class="fas fa-barcode"></i> Código Único
                </h5>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Código del Certificado</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <?= $this->Form->control(
                                'codigo',
                                [
                                    'type' => 'text',
                                    'placeholder' => 'Se generará automáticamente',
                                    'class' => 'form-control form-control-border',
                                    'id' => 'codigoInput',
                                    'label' => false,
                                    'readonly' => true
                                ]
                            ) ?>
                            <div class="input-group-append">
                                <button 
                                    class="btn btn-outline-secondary" 
                                    type="button" 
                                    id="generarCodigoBtn"
                                >
                                    <i class="fas fa-sync-alt"></i> Generar
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Formato: CERT-YYYYMMDD-XXXX</small>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <?= $this->Form->button(
                    '<i class="fas fa-save me-2"></i> Guardar Certificado',
                    [
                        'type' => 'submit',
                        'class' => 'btn btn-primary',
                        'escapeTitle' => false
                    ]
                ) ?>

                <?= $this->Html->link(
                    '<i class="fas fa-times"></i> Cancelar',
                    ['action' => 'index'],
                    ['class' => 'btn btn-secondary', 'escape' => false]
                ) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
    .form-control-border {
        border: 1px solid #dee2e6;
        transition: border-color 0.3s;
    }

    .form-control-border:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .custom-control-label {
        cursor: pointer;
        margin-left: 0.5rem;
    }

    .text-danger {
        color: #dc3545;
    }

    .text-info {
        color: #17a2b8;
        font-weight: 600;
    }

    .list-group-item {
        padding: 0.75rem 1.25rem;
    }

    .list-group-item input[type="checkbox"] {
        margin-right: 0.5rem;
    }

    .form-control::placeholder {
        color: #a0b9d6 !important; /* Softer placeholder color */
        opacity: 1;
    }

    .form-control:focus::placeholder {
        color: #c0d4e8 !important; /* Softer color on focus */
    }

    .btn-primary i {
        margin-right: 0.5rem; /* Ensure proper spacing for the Font Awesome icon */
    }

    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const usuarioSelect = document.getElementById('usuarioId');
        const seccionTitular = document.getElementById('seccionTitular');
        const cursoSelect = document.getElementById('cursoId');
        const cursoManual = document.getElementById('cursoManual');
        const seccionCursoManual = document.getElementById('seccionCursoManual');
        const seccionModulosAutomaticos = document.getElementById('seccionModulosAutomaticos');
        const seccionModulosManual = document.getElementById('seccionModulosManual');
        const generarCodigoBtn = document.getElementById('generarCodigoBtn');
        const codigoInput = document.getElementById('codigoInput');
        const tipoCertificado = document.getElementById('tipoCertificado');
        const tipoDiplomado = document.getElementById('tipoDiplomado');
        const form = document.querySelector('form');

        // Mostrar/ocultar sección de titulares y sus datos
        function actualizarTitular() {
            if (usuarioSelect.value === '') {
                // Si no hay usuario, mostrar la sección de titular
                seccionTitular.style.display = 'block';
                
                // Si además no hay titular existente, mostrar datos nuevos
                if (titularSelect.value === '') {
                    datosTitularNuevo.style.display = 'block';
                } else {
                    datosTitularNuevo.style.display = 'none';
                }
            } else {
                // Si hay usuario, ocultar la sección de titular
                seccionTitular.style.display = 'none';
            }
        }

        usuarioSelect.addEventListener('change', function() {
            actualizarTitular();
        });

        // Mostrar/ocultar curso manual y módulos
        cursoSelect.addEventListener('change', function() {
            if (this.value !== '') {
                // Si hay curso seleccionado
                seccionCursoManual.style.display = 'none';
                seccionModulosManual.style.display = 'none';
                cargarModulos(this.value);
            } else {
                // Si NO hay curso seleccionado
                seccionCursoManual.style.display = 'block';
                seccionModulosAutomaticos.style.display = 'none';
                
                // Mostrar módulos manuales solo si hay texto en curso manual
                if (cursoManual.value.trim() !== '') {
                    seccionModulosManual.style.display = 'block';
                }
            }
        });

        // Mostrar/ocultar módulos manuales cuando se escribe el curso
        cursoManual.addEventListener('input', function() {
            if (cursoSelect.value === '' && this.value.trim() !== '') {
                // Mostrar módulos manuales si hay curso manual
                seccionModulosManual.style.display = 'block';
            } else if (this.value.trim() === '') {
                // Ocultar módulos manuales si se borra el curso manual
                seccionModulosManual.style.display = 'none';
            }
        });

        // Función para cargar módulos vía AJAX
        function cargarModulos(cursoId) {
            fetch('<?= $this->Url->build(['controller' => 'Certificados', 'action' => 'obtenerModulos']) ?>/' + cursoId)
                .then(response => response.json())
                .then(data => {
                    const listaModulos = document.getElementById('listaModulos');
                    listaModulos.innerHTML = '';

                    if (data.length > 0) {
                        seccionModulosAutomaticos.style.display = 'block';
                        data.forEach(modulo => {
                            const item = document.createElement('div');
                            item.className = 'list-group-item';
                            item.innerHTML = `
                                <div class="custom-control custom-checkbox">
                                    <input 
                                        type="checkbox" 
                                        class="custom-control-input" 
                                        id="modulo_${modulo.id}"
                                        value="${modulo.id}"
                                    >
                                    <label class="custom-control-label" for="modulo_${modulo.id}">
                                        <i class="fas fa-layer-group"></i> ${modulo.titulo || modulo.nombre}
                                    </label>
                                </div>
                            `;
                            listaModulos.appendChild(item);
                        });
                    } else {
                        seccionModulosAutomaticos.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Gestión de módulos manuales
        let modulosManuales = [];
        
        // Función para editar un módulo
        function abrirEditorModulo(index) {
            const modulo = modulosManuales[index];
            const nuevoTitulo = prompt('Editar módulo:', modulo);
            
            if (nuevoTitulo !== null && nuevoTitulo.trim() !== '') {
                modulosManuales[index] = nuevoTitulo.trim();
                renderizarModulosManuales();
                guardarModulosManuales();
            }
        }
        
        function renderizarModulosManuales() {
            const listaModulosExistentes = document.getElementById('listaModulosExistentes');
            listaModulosExistentes.innerHTML = '';
            
            modulosManuales.forEach((modulo, index) => {
                const item = document.createElement('div');
                item.className = 'list-group-item';
                item.innerHTML = `
                    <div class="custom-control custom-checkbox">
                        <input 
                            type="checkbox" 
                            class="custom-control-input checkbox-modulo-manual" 
                            id="modulo_manual_${index}"
                            data-index="${index}"
                            checked
                        >
                        <label class="custom-control-label" for="modulo_manual_${index}">
                            <i class="fas fa-layer-group"></i> 
                            <span class="modulo-titulo-text" data-index="${index}" style="cursor: pointer; text-decoration: underline;" title="Click para editar">
                                ${modulo}
                            </span>
                        </label>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-outline-info float-end btn-editar-modulo me-2"
                            data-index="${index}"
                            title="Editar módulo"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-outline-danger float-end btn-eliminar-modulo"
                            data-index="${index}"
                            title="Eliminar módulo"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                listaModulosExistentes.appendChild(item);
            });
            
            // Event listeners para editar módulos (click en el texto)
            document.querySelectorAll('.modulo-titulo-text').forEach(span => {
                span.addEventListener('click', function(e) {
                    e.preventDefault();
                    const index = parseInt(this.dataset.index);
                    abrirEditorModulo(index);
                });
            });
            
            // Event listeners para botón editar
            document.querySelectorAll('.btn-editar-modulo').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const index = parseInt(this.dataset.index);
                    abrirEditorModulo(index);
                });
            });
            
            // Event listeners para eliminar módulos
            document.querySelectorAll('.btn-eliminar-modulo').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const index = parseInt(this.dataset.index);
                    modulosManuales.splice(index, 1);
                    renderizarModulosManuales();
                    guardarModulosManuales();
                });
            });
            
            // Event listeners para checkboxes
            document.querySelectorAll('.checkbox-modulo-manual').forEach(checkbox => {
                checkbox.addEventListener('change', guardarModulosManuales);
            });
        }
        
        function guardarModulosManuales() {
            const listaModulosExistentes = document.getElementById('listaModulosExistentes');
            const checkboxesSeleccionados = listaModulosExistentes.querySelectorAll('.checkbox-modulo-manual:checked');
            
            // Guardar en el campo oculto como JSON
            const modulosSeleccionados = Array.from(checkboxesSeleccionados).map(cb => {
                const index = parseInt(cb.dataset.index);
                return modulosManuales[index];
            });
            
            document.getElementById('modulosManualIds').value = modulosSeleccionados.join('\n');
        }
        
        // Event listener para agregar nuevo módulo
        document.getElementById('agregarModuloBtn').addEventListener('click', function() {
            const input = document.getElementById('nuevoModuloManual');
            const nuevoModulo = input.value.trim();
            
            if (nuevoModulo !== '') {
                modulosManuales.push(nuevoModulo);
                input.value = '';
                renderizarModulosManuales();
                guardarModulosManuales();
            }
        });
        
        // Permitir agregar módulo con Enter
        document.getElementById('nuevoModuloManual').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('agregarModuloBtn').click();
            }
        });

        // Generar código único con prefijo según tipo
        function generarCodigo() {
            const fecha = new Date();
            const fechaFormato = fecha.getFullYear() + 
                                String(fecha.getMonth() + 1).padStart(2, '0') + 
                                String(fecha.getDate()).padStart(2, '0');
            const aleatorio = String(Math.floor(Math.random() * 10000)).padStart(4, '0');
            
            // Determinar prefijo según el tipo seleccionado
            const prefijo = tipoDiplomado.checked ? 'DIP' : 'CERT';
            const codigo = prefijo + '-' + fechaFormato + '-' + aleatorio;
            
            codigoInput.value = codigo;
        }

        generarCodigoBtn.addEventListener('click', generarCodigo);

        // Regenerar código cuando cambia el tipo de certificado
        tipoCertificado.addEventListener('change', generarCodigo);
        tipoDiplomado.addEventListener('change', generarCodigo);

        // Generar código al cargar la página
        if (codigoInput.value === '') {
            generarCodigo();
        }

        // Capturar módulos seleccionados antes de enviar el formulario
        if (form) {
            form.addEventListener('submit', function(e) {
                const modulosIdsInput = document.getElementById('modulosIds');
                const checkboxesSeleccionados = document.querySelectorAll('#listaModulos input[type="checkbox"]:checked');
                
                // Capturar los IDs de los checkboxes seleccionados
                const idsSeleccionados = Array.from(checkboxesSeleccionados).map(cb => cb.value);
                
                // Guardar en el campo oculto como JSON
                modulosIdsInput.value = JSON.stringify(idsSeleccionados);
            });
        }

        // Validación de campos requeridos
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const requiredFields = [
                { id: 'nota-final', name: 'Nota Final' },
                { id: 'fecha-inicio', name: 'Fecha de Inicio' },
                { id: 'fecha-fin', name: 'Fecha de Fin' },
                { id: 'nombre-gerente', name: 'Nombre del Gerente' },
                { id: 'horas-lectivas', name: 'Horas Lectivas' },
                { id: 'duracion-meses', name: 'Duración (meses)' }
            ];

            let errorMessage = '';

            requiredFields.forEach(field => {
                const input = document.getElementById(field.id);
                if (!input || input.value.trim() === '') {
                    isValid = false;
                    input.classList.add('is-invalid');
                    errorMessage += `- ${field.name} es obligatorio.\n`;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert(`Por favor complete los siguientes campos:\n\n${errorMessage}`);
            }
        });

        // Inicializar estado de titular y curso
        actualizarTitular();
        
        // Inicializar estado de curso
        if (cursoSelect.value !== '') {
            seccionCursoManual.style.display = 'none';
            cargarModulos(cursoSelect.value);
        } else {
            seccionCursoManual.style.display = 'block';
        }

        const guardarBtn = document.querySelector('.btn-primary[type="submit"]');
        if (guardarBtn) {
            guardarBtn.innerHTML = '<i class="fas fa-save"></i> Guardar Certificado';
        }
    });
</script>

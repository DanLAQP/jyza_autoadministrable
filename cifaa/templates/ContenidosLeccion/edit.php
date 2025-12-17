<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContenidosLeccion $contenidosLeccion
 * @var string[]|\Cake\Collection\CollectionInterface $lecciones
 * @var mixed $leccionId
 */
?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm bg-dark">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Contenido</h4>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($contenidosLeccion, ['type' => 'file', 'novalidate' => true, 'class' => 'form']) ?>
                    
                    <!-- Mostrar errores de validación -->
                    <?php if ($contenidosLeccion->getErrors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Errores de validación:</h6>
                            <ul class="mb-0">
                                <?php foreach ($contenidosLeccion->getErrors() as $field => $messages): ?>
                                    <?php foreach ($messages as $message): ?>
                                        <li><?= ucfirst($field) ?>: <?= h($message) ?></li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <?= $this->Form->label('leccion_id', 'Lección *') ?>
                        <?= $this->Form->select(
                            'leccion_id',
                            $lecciones,
                            [
                                'class' => 'form-control form-control-sm' . (!empty($contenidosLeccion->getError('leccion_id')) ? ' is-invalid' : ''),
                                'required' => true
                            ]
                        ) ?>
                        <?php if (!empty($contenidosLeccion->getError('leccion_id'))): ?>
                            <div class="invalid-feedback d-block">
                                <?= implode(', ', $contenidosLeccion->getError('leccion_id')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('tipo', 'Tipo de Contenido *') ?>
                        <?= $this->Form->select(
                            'tipo',
                            [
                                'video' => 'Video',
                                'texto' => 'Texto',
                                'imagen' => 'Imagen',
                                'pdf' => 'Archivo PDF',
                                'documento' => 'Documento Word/Excel'
                            ],
                            [
                                'class' => 'form-control form-control-sm' . (!empty($contenidosLeccion->getError('tipo')) ? ' is-invalid' : ''),
                                'required' => true
                            ]
                        ) ?>
                        <?php if (!empty($contenidosLeccion->getError('tipo'))): ?>
                            <div class="invalid-feedback d-block">
                                <?= implode(', ', $contenidosLeccion->getError('tipo')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('contenido', 'Contenido (Texto/Descripción)') ?>
                        <?= $this->Form->textarea(
                            'contenido',
                            [
                                'class' => 'form-control form-control-sm',
                                'rows' => 3,
                                'placeholder' => 'Descripción del contenido o link del video'
                            ]
                        ) ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('archivo', 'Archivo o Imagen') ?>
                        <?php if ($contenidosLeccion->archivo): ?>
                            <div class="mb-2">
                                <p class="text-muted mb-2">Archivo actual:</p>
                                <div class="p-2 bg-light rounded">
                                    <i class="fas fa-file"></i> 
                                    <a href="<?= $this->Url->assetUrl($contenidosLeccion->archivo) ?>" target="_blank" class="text-info">
                                        <?= basename($contenidosLeccion->archivo) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?= $this->Form->file(
                            'archivo',
                            [
                                'class' => 'form-control form-control-sm',
                                'accept' => '.pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.mp4,.webm',
                                'id' => 'archivo-input'
                            ]
                        ) ?>
                        <small class="form-text text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Formatos permitidos: 
                            PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, WEBP, MP4, WEBM
                        </small>
                        <div id="file-preview" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->label('posicion', 'Posición *') ?>
                        <?= $this->Form->number(
                            'posicion',
                            [
                                'class' => 'form-control form-control-sm' . (!empty($contenidosLeccion->getError('posicion')) ? ' is-invalid' : ''),
                                'required' => true,
                                'min' => 1
                            ]
                        ) ?>
                        <?php if (!empty($contenidosLeccion->getError('posicion'))): ?>
                            <div class="invalid-feedback d-block">
                                <?= implode(', ', $contenidosLeccion->getError('posicion')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                        <?= $this->Html->link(
                            '<i class="fas fa-times"></i> Cancelar',
                            'javascript:void(0);',
                            [
                                'class' => 'btn btn-secondary btn-sm',
                                'escape' => false,
                                'onclick' => 'window.closeModal();'
                            ]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Previsualización de archivo
    const fileInput = document.getElementById('archivo-input');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const preview = document.getElementById('file-preview');
            preview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileType = file.type;
                
                // Preview para imágenes
                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.className = 'rounded mt-2';
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        img.style.objectFit = 'cover';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Para otros archivos mostrar información
                    const info = document.createElement('div');
                    info.className = 'alert alert-info alert-sm mt-2';
                    info.innerHTML = `<small><i class="fas fa-file"></i> ${file.name} (${fileSize} MB)</small>`;
                    preview.appendChild(info);
                }
            }
        });
    }

    // Manejador para envío de formulario AJAX en el modal
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const formAction = form.getAttribute('action');
            
            // Agregar indicador de carga (cambiar icono del botón)
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn?.innerHTML;
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }
            
            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // Obtener el content-type
                const contentType = response.headers.get('content-type');
                
                if (contentType && contentType.includes('application/json')) {
                    // JSON response - success case
                    return response.json().then(data => {
                        if (data.success) {
                            // Mostrar ícono de éxito
                            if (submitBtn) {
                                submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> ¡Guardado!';
                                submitBtn.classList.remove('btn-primary');
                                submitBtn.classList.add('btn-success');
                            }
                            
                            // Cerrar el modal y redirigir
                            if (typeof $ !== 'undefined' && $.fn.modal) {
                                $('#modalLg').modal('hide');
                            }
                            // Redirigir después de cerrar el modal
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 300);
                        }
                    });
                } else {
                    // HTML response - error case with validation errors
                    return response.text().then(html => {
                        // Reemplazar el contenido del modal con el formulario nuevo (con errores)
                        document.getElementById('modalContentLg').innerHTML = html;
                        // Re-registrar los eventos del formulario
                        document.dispatchEvent(new Event('DOMContentLoaded'));
                    });
                }
            })
            .catch(error => {
                console.error('Error al guardar:', error);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                }
                alert('Hubo un error al guardar. Por favor, intenta nuevamente.');
            });
        });
    });
});
</script>

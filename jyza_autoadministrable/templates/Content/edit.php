<div class="container-fluid">
    <h2 class="mb-4">Editar Sección: <?= h($section->title) ?> (<?= h($section->slug) ?>)</h2>

    <?php
    // Función auxiliar para resolver URLs de imágenes (ID o URL directa)
    $resolveImageUrl = function($content, $sectionImages) {
        if (empty($content)) return '';
        
        // Si es URL directa (comienza con / o http)
        if (is_string($content) && (strpos($content, '/') === 0 || strpos($content, 'http') === 0)) {
            return $content;
        }
        
        // Si es un ID numérico, buscar en sectionImages
        if (is_numeric($content) && !empty($sectionImages)) {
            foreach ($sectionImages as $img) {
                if ((string)$img->id === (string)$content) {
                    // Retornar file_path si existe, sino original_filename
                    return $img->file_path ?? '';
                }
            }
        }
        
        return '';
    };
    
    // Función para obtener el contenido del bloque
    $getBlockContent = function($blockKey, $section) {
        foreach ($section->content_blocks as $block) {
            if ($block->block_key === $blockKey) {
                return $block->content;
            }
        }
        return '';
    };
    ?>

    <div class="row g-4">
        <!-- COLUMNA IZQUIERDA: Formulario de edición -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Editar bloques de contenido</h5>

                    <?= $this->Form->create(null, ['type' => 'file']) ?>

                    <!-- FORMULARIO PARA CREAR NUEVOS BLOQUES (para Citas y Club JYZA) -->
                    <?php if (in_array($section->slug, ['citas', 'clubjyza'])): ?>
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    ✨ Agregar nuevo
                                    <?php if ($section->slug === 'citas'): ?>
                                        servicio/especialista
                                    <?php else: ?>
                                        convenio completo
                                    <?php endif; ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if ($section->slug === 'citas'): ?>
                                    <p class="text-muted small mb-3">Crea un nuevo bloque para servicios (servicio_7, servicio_8...) o especialistas (especialista_3, especialista_4...)</p>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Clave del bloque</label>
                                            <input type="text" name="new_block_key" class="form-control" placeholder="ej: servicio_7" />
                                            <small class="text-muted d-block mt-1">Ej: <code>servicio_7</code>, <code>especialista_3</code></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Contenido</label>
                                            <input type="text" name="new_block_content" class="form-control" placeholder="Ej: Ginecología Avanzada" />
                                        </div>
                                    </div>

                                    <button type="submit" name="create_block" value="1" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i> Crear bloque
                                    </button>

                                <?php else: ?>
                                    <!-- FORMULARIO ESPECIAL PARA CLUB JYZA -->
                                    <p class="text-muted small mb-3">Crea un convenio completo con todos los datos necesarios para aparecer en el carousel</p>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Número del convenio</label>
                                            <input type="number" name="new_convenio_number" class="form-control" placeholder="5" min="1" />
                                            <small class="text-muted d-block mt-1">Ej: 5, 6, 7... (para convenio_5, convenio_6, etc.)</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Nombre del convenio</label>
                                            <input type="text" name="new_convenio_name" class="form-control" placeholder="Ej: Clínica Nueva" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Dirección/Teléfono</label>
                                            <input type="text" name="new_convenio_specialty" class="form-control" placeholder="Jr. Calle 123 – Huánuco · +51 999 999 999" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Categoría</label>
                                            <input type="text" name="new_convenio_category" class="form-control" placeholder="Ej: Ginecología" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Color categoría</label>
                                            <select name="new_convenio_category_color" class="form-select">
                                                <option value="">Selecciona...</option>
                                                <option value="cat-gine">🩷 Ginecología (cat-gine)</option>
                                                <option value="cat-ped">🧡 Pediatría (cat-ped)</option>
                                                <option value="cat-odonto">💚 Odontología (cat-odonto)</option>
                                                <option value="cat-estim">💛 Estimulación (cat-estim)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Etiqueta (tag)</label>
                                            <input type="text" name="new_convenio_tag" class="form-control" placeholder="Ej: Fundador, Alianza" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Color etiqueta</label>
                                            <select name="new_convenio_tag_color" class="form-select">
                                                <option value="">Selecciona...</option>
                                                <option value="tag-fundador">tag-fundador</option>
                                                <option value="tag-alianza">tag-alianza</option>
                                                <option value="tag-convenio">tag-convenio</option>
                                                <option value="tag-bienest">tag-bienest</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Descripción 1</label>
                                            <textarea name="new_convenio_description_1" class="form-control" rows="2" placeholder="Primera descripción..."></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Descripción 2</label>
                                            <textarea name="new_convenio_description_2" class="form-control" rows="2" placeholder="Segunda descripción..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Frase destacada (quote)</label>
                                            <input type="text" name="new_convenio_quote" class="form-control" placeholder="Ej: Tu sonrisa es nuestra especialidad" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Beneficio/Descuento</label>
                                            <input type="text" name="new_convenio_benefit" class="form-control" placeholder="Ej: 15% de descuento" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Color del beneficio</label>
                                            <select name="new_convenio_benefit_color" class="form-select">
                                                <option value="">Selecciona...</option>
                                                <option value="pill-purple">💜 Púrpura (pill-purple)</option>
                                                <option value="pill-amber">🟠 Ámbar (pill-amber)</option>
                                                <option value="pill-green">💚 Verde (pill-green)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">URL Facebook</label>
                                            <input type="url" name="new_convenio_facebook_url" class="form-control" placeholder="https://www.facebook.com/..." />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">URL Instagram</label>
                                            <input type="url" name="new_convenio_instagram_url" class="form-control" placeholder="https://www.instagram.com/..." />
                                        </div>
                                    </div>

                                    <button type="submit" name="create_convenio" value="1" class="btn btn-primary mt-4">
                                        <i class="fas fa-plus"></i> Crear convenio completo (14 campos)
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($section->content_blocks)): ?>
                        <?php foreach ($section->content_blocks as $block): ?>
                            <div class="mb-4 pb-4 border-bottom" id="block-<?= $block->id ?>">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold mb-0"><?= h($block->block_key) ?> <span class="badge bg-info"><?= h($block->block_type) ?></span></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active_<?= $block->id ?>" name="is_active[<?= $block->id ?>]" value="1" <?= ($block->is_active ?? 1) ? 'checked' : '' ?> />
                                        <label class="form-check-label small" for="is_active_<?= $block->id ?>">
                                            <?= ($block->is_active ?? 1) ? 'Activo' : 'Inactivo' ?>
                                        </label>
                                    </div>
                                </div>
                                
                                <?php if (in_array($block->block_type, ['text', 'textarea', 'wysiwyg'])): ?>
                                    <?= $this->Form->control('blocks.' . $block->id, ['type' => 'textarea', 'value' => $block->content, 'label' => false, 'class' => 'form-control', 'rows' => 4]) ?>
                                
                                <?php elseif ($block->block_type === 'image'): ?>
                                    <?php
                                    // Resolver la URL de la imagen asignada
                                    $assignedImageUrl = $resolveImageUrl($block->content, $sectionImages ?? []);
                                    $assignedImageName = '';
                                    
                                    // Si es un ID numérico, obtener el nombre de la imagen
                                    if (is_numeric($block->content) && !empty($sectionImages)) {
                                        foreach ($sectionImages as $img) {
                                            if ((string)$img->id === (string)$block->content) {
                                                $assignedImageName = $img->title ?: $img->original_filename;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    
                                    <!-- Mostrar imagen asignada actual -->
                                    <div class="mb-3 p-3 bg-light rounded text-center">
                                        <?php if (!empty($assignedImageUrl)): ?>
                                            <label class="form-label d-block mb-2"><strong>Imagen asignada:</strong></label>
                                            <img src="<?= h($assignedImageUrl) ?>" 
                                                 alt="<?= h($block->block_key) ?>" 
                                                 class="img-fluid" 
                                                 style="max-height: 180px; object-fit: cover; border-radius: 6px;">
                                            <small class="text-muted d-block mt-2"><?= h($assignedImageName) ?></small>
                                        <?php else: ?>
                                            <label class="form-label d-block"><strong>Sin imagen asignada</strong></label>
                                            <small class="text-muted">Sube una imagen para asignarla</small>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Input oculto para que el bloque sea procesado -->
                                    <input type="hidden" name="blocks[<?= $block->id ?>]" value="<?= h($block->content) ?>" />

                                    <!-- Input para subir nueva imagen -->
                                    <div class="mb-3">
                                        <label class="form-label">Subir imagen</label>
                                        <input type="file" name="image_files[<?= $block->id ?>]" class="form-control" accept="image/*" />
                                        <small class="text-muted d-block mt-1">La imagen se asignará automáticamente a este bloque</small>
                                    </div>
                                
                                <?php else: ?>
                                    <?= $this->Form->control('blocks.' . $block->id, ['type' => 'text', 'value' => $block->content, 'label' => false, 'class' => 'form-control']) ?>
                                <?php endif; ?>
                                
                                <small class="text-muted d-block mt-2">ID: <?= h($block->id) ?> | Orden: <?= h($block->sort_order) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">No hay bloques para esta sección.</div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <?= $this->Form->button('Guardar cambios', ['class' => 'btn btn-success btn-lg']) ?>
                        <?= $this->Html->link('Volver', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg ms-2']) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== MANEJO DE CHECKBOXES MAESTROS DE CONVENIOS =====
    const blocks = document.querySelectorAll('[id^="block-"]');
    const convenios = new Map();

    // Agrupar bloques por convenio
    blocks.forEach(block => {
        const label = block.querySelector('.form-label');
        if (!label) return;

        const blockKeyText = label.textContent.trim();
        const match = blockKeyText.match(/convenio_(\d+)_/);

        if (match) {
            const convNum = match[1];
            if (!convenios.has(convNum)) {
                convenios.set(convNum, []);
            }
            convenios.get(convNum).push(block);
        }
    });

    // Si encontramos convenios, crear checkboxes maestros
    if (convenios.size > 0) {
        convenios.forEach((convBlocks, convNum) => {
            const firstBlock = convBlocks[0];
            if (!firstBlock) return;

            // Obtener el nombre del convenio del bloque _name
            let convName = `Convenio #${convNum}`;
            convBlocks.forEach(block => {
                const label = block.querySelector('.form-label');
                if (label && label.textContent.includes(`_name`)) {
                    const inputs = block.querySelectorAll('textarea, input[type="text"]');
                    if (inputs.length > 0) {
                        const content = inputs[inputs.length - 1].value;
                        if (content) convName = content;
                    }
                }
            });

            // Crear elemento maestro
            const masterDiv = document.createElement('div');
            masterDiv.className = 'card mb-4 border-secondary';
            masterDiv.style.background = 'rgba(0,0,0,0.02)';
            masterDiv.innerHTML = `
                <div class="card-header bg-secondary text-white d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">🏥 ${convName} <span class="badge bg-dark">#${convNum}</span></h6>
                    <div class="form-check form-switch" style="margin: 0;">
                        <input class="form-check-input convenio-master-toggle" type="checkbox" id="convenio_master_${convNum}" data-convenio="${convNum}" style="cursor: pointer;" />
                        <label class="form-check-label text-white small" for="convenio_master_${convNum}" style="cursor: pointer; margin-bottom: 0;">
                            Mostrar en carousel
                        </label>
                    </div>
                </div>
                <div class="card-body" style="padding: 1rem;">
                    <!-- Los bloques se insertarán aquí -->
                </div>
            `;

            // Insertar maestro antes del primer bloque
            firstBlock.parentNode.insertBefore(masterDiv, firstBlock);
            const cardBody = masterDiv.querySelector('.card-body');

            // Mover todos los bloques del convenio dentro del card-body
            convBlocks.forEach(block => {
                cardBody.appendChild(block);
            });

            // Evento del checkbox maestro
            const masterCheckbox = masterDiv.querySelector('.convenio-master-toggle');
            masterCheckbox.addEventListener('change', function() {
                convBlocks.forEach(block => {
                    const checkbox = block.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.checked = this.checked;
                    }
                });
            });

            // Sincronizar estado inicial - revisar si TODOS están activos
            const allChecked = convBlocks.every(block => {
                const checkbox = block.querySelector('input[type="checkbox"]');
                return checkbox && checkbox.checked;
            });
            masterCheckbox.checked = allChecked;
        });
    }

    // ===== PREVISUALIZACIÓN DE IMÁGENES =====
    // Detectar todos los inputs de imagen para previsualización en tiempo real
    const imageInputs = document.querySelectorAll('input[type="file"][name*="image_files["]');

    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            // Validar que sea una imagen
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona una imagen válida');
                return;
            }

            // Encontrar el contenedor de imagen asignada (el div superior)
            const blockContainer = this.closest('[id^="block-"]');
            if (!blockContainer) return;

            const imagePreviewDiv = blockContainer.querySelector('.p-3.bg-light.rounded.text-center');
            if (!imagePreviewDiv) return;

            // Leer el archivo con FileReader
            const reader = new FileReader();
            reader.onload = function(e) {
                // Reemplazar el contenido del div de previsualización
                imagePreviewDiv.innerHTML = `
                    <label class="form-label d-block mb-2"><strong>Previsualización de imagen seleccionada:</strong></label>
                    <img src="${e.target.result}"
                         alt="Previsualización"
                         class="img-fluid"
                         style="max-height: 180px; object-fit: cover; border-radius: 6px;">
                    <small class="text-muted d-block mt-2">${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                    <small class="text-success d-block mt-1">✓ Se asignará al hacer clic en "Guardar cambios"</small>
                `;
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>

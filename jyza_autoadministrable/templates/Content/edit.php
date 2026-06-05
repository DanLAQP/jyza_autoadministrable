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
        <div class="col-lg-7">
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

        <!-- COLUMNA DERECHA: Previsualización responsive -->
        <div class="col-lg-5">
            <div class="card sticky-lg-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📱 Previsualización (Responsive)</h5>
                </div>
                <div class="card-body p-0">
                    <div class="preview-container" style="background: #000; overflow-y: auto; max-height: calc(100vh - 150px);">
                        <?php if ($section->slug === 'bienvenida'): ?>
                        <!-- HERO SECTION (copia exacta de Bienvenida.astro) -->
                        <style>
                            .preview-hero {
                                width: 100%;
                                min-height: 100vh;
                                position: relative;
                                overflow: hidden;
                                display: flex;
                                align-items: center;
                            }
                            
                            .preview-hero-background {
                                position: absolute;
                                inset: 0;
                                z-index: 0;
                            }
                            
                            .preview-hero-background img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                object-position: center;
                            }
                            
                            .preview-hero-gradient {
                                position: absolute;
                                inset: 0;
                                background: linear-gradient(
                                    90deg,
                                    rgba(21, 0, 18, 1) 0%,
                                    rgba(21, 0, 18, 0.85) 40%,
                                    rgba(72, 41, 59, 0.6) 60%,
                                    rgba(21, 0, 18, 0.2) 100%
                                );
                            }
                            
                            .preview-hero-container {
                                max-width: 1400px;
                                margin: 0 auto;
                                padding: 4rem 2rem;
                                width: 100%;
                                position: relative;
                                z-index: 1;
                            }
                            
                            .preview-hero-content {
                                max-width: 580px;
                            }
                            
                            .preview-logo-hero {
                                max-width: 100px;
                                height: auto;
                                margin-bottom: 2rem;
                                display: block;
                            }
                            
                            .preview-badge {
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                                background: rgba(239, 68, 68, 0.1);
                                border: 1px solid rgba(239, 68, 68, 0.3);
                                border-radius: 50px;
                                padding: 0.5rem 1rem;
                                margin-bottom: 2rem;
                                backdrop-filter: blur(10px);
                            }
                            
                            .preview-badge-icon {
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: rgba(239, 68, 68, 0.6);
                                border-radius: 50%;
                            }
                            
                            .preview-badge-text {
                                font-size: 0.75rem;
                                font-weight: 600;
                                letter-spacing: 1px;
                                color: #e0c7f0;
                            }
                            
                            .preview-title {
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-size: 3.5rem;
                                font-weight: 700;
                                line-height: 1.1;
                                margin: 0 0 1.5rem 0;
                                color: #fff;
                            }
                            
                            .preview-description {
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-size: 1.125rem;
                                line-height: 1.7;
                                color: #fff;
                                margin: 0 0 2.5rem 0;
                                opacity: 0.95;
                            }
                            
                            .preview-info {
                                display: flex;
                                gap: 1.5rem;
                                flex-wrap: wrap;
                            }
                            
                            .preview-info-card {
                                display: flex;
                                align-items: center;
                                gap: 1rem;
                                background: rgba(255, 255, 255, 0.08);
                                border: 1px solid rgba(255, 255, 255, 0.15);
                                padding: 1rem 2rem;
                                border-radius: 20px;
                                backdrop-filter: blur(10px);
                                flex: 1;
                                min-width: 250px;
                            }
                            
                            .preview-info-icon {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                background-color: rgba(233, 213, 240, 0.1);
                                color: #E9D5F0;
                                border-radius: 20px;
                                padding: 0.75rem;
                                min-width: 50px;
                                height: 50px;
                            }
                            
                            .preview-info-text {
                                display: flex;
                                flex-direction: column;
                                gap: 0.25rem;
                            }
                            
                            .preview-info-label {
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-weight: 600;
                                font-size: 0.95rem;
                                color: #fff;
                            }
                            
                            .preview-info-detail {
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-size: 0.85rem;
                                color: rgba(255, 255, 255, 0.75);
                            }
                            
                            .preview-hero-actions {
                                display: flex;
                                gap: 1rem;
                                margin-bottom: 3rem;
                                flex-wrap: wrap;
                            }
                            
                            .preview-btn-primary {
                                display: inline-flex;
                                align-items: center;
                                gap: 0.75rem;
                                background: #dc2626;
                                color: white;
                                padding: 1rem 2rem;
                                border-radius: 25px;
                                font-weight: 600;
                                text-decoration: none;
                                transition: all 0.3s ease;
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-size: 0.95rem;
                                border: none;
                                cursor: pointer;
                            }
                            
                            .preview-btn-primary:hover {
                                background: #b91c1c;
                                transform: translateY(-2px);
                            }
                            
                            .preview-btn-secondary {
                                display: inline-flex;
                                align-items: center;
                                gap: 1.5rem;
                                background: transparent;
                                color: white;
                                padding: 1rem 2rem;
                                border-radius: 12px;
                                font-weight: 600;
                                text-decoration: none;
                                transition: all 0.3s ease;
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                backdrop-filter: blur(5px);
                                border: none;
                                cursor: pointer;
                                font-size: 0.95rem;
                            }
                            
                            .preview-btn-secondary:hover {
                                background: rgba(255, 255, 255, 0.12);
                                transform: translateY(-2px);
                            }
                            
                            .preview-btn-separator {
                                margin-right: 0.5rem;
                                opacity: 0.8;
                            }
                            
                            .preview-arrow-down {
                                transform: rotate(90deg);
                                transition: transform 0.3s ease;
                                display: inline-block;
                                width: 20px;
                                height: 20px;
                            }
                            
                            /* Club JYZA Button */
                            .preview-club-jyza-btn {
                                position: absolute;
                                top: 0rem;
                                right: 2rem;
                                display: inline-flex;
                                align-items: center;
                                gap: 0.6rem;
                                background: rgba(255, 255, 255, 0.08);
                                border: 1px solid rgba(255, 255, 255, 0.2);
                                border-top: none;
                                border-radius: 0 0 16px 16px;
                                padding: 0.6rem 1.1rem 0.7rem;
                                text-decoration: none;
                                color: #fff;
                                backdrop-filter: blur(12px);
                                transition: all 0.3s ease;
                                z-index: 10;
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                            }
                            
                            .preview-club-jyza-btn:hover {
                                background: rgba(255, 255, 255, 0.15);
                                border-color: rgba(255, 255, 255, 0.4);
                                transform: translateY(4px);
                            }
                            
                            .preview-club-jyza-icon {
                                display: block;
                                color: #c084fc;
                                flex-shrink: 0;
                            }
                            
                            .preview-club-jyza-text {
                                display: flex;
                                flex-direction: column;
                                gap: 0;
                            }
                            
                            .preview-club-jyza-label {
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-size: 0.65rem;
                                font-weight: 500;
                                letter-spacing: 1.5px;
                                text-transform: uppercase;
                                opacity: 0.7;
                                line-height: 1;
                            }
                            
                            .preview-club-jyza-title {
                                font-family: 'Urbanist', -apple-system, BlinkMacSystemFont, sans-serif;
                                font-size: 0.9rem;
                                font-weight: 700;
                                line-height: 1.2;
                                color: #c084fc;
                            }
                            
                            .preview-club-jyza-arrow {
                                opacity: 0.7;
                                width: 16px;
                                height: 16px;
                            }
                            
                            /* RESPONSIVE - Tablets y abajo */
                            @media (max-width: 768px) {
                                .preview-hero {
                                    min-height: 100vh;
                                    padding: 0;
                                    align-items: center;
                                    box-sizing: border-box;
                                }
                                
                                .preview-hero-container {
                                    padding: 1.25rem 1.25rem;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    min-height: 100vh;
                                    box-sizing: border-box;
                                }
                                
                                .preview-hero-content {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: flex-start;
                                    text-align: left;
                                    width: 100%;
                                }
                                
                                .preview-title {
                                    font-size: 1.85rem;
                                    line-height: 1.15;
                                    margin-bottom: 0.75rem;
                                    max-width: 80%;
                                }
                                
                                .preview-description {
                                    font-size: 0.875rem;
                                    line-height: 1.55;
                                    margin-bottom: 1.25rem;
                                    max-width: 80%;
                                }
                                
                                .preview-badge {
                                    padding: 0.25rem 0.6rem;
                                    margin-bottom: 0.6rem;
                                }
                                
                                .preview-badge-icon {
                                    width: 6px;
                                    height: 6px;
                                }
                                
                                .preview-badge-text {
                                    font-size: 0.6rem;
                                    letter-spacing: 0.5px;
                                }
                                
                                .preview-info {
                                    flex-direction: column;
                                    align-items: center;
                                    align-self: stretch;
                                    gap: 0.5rem;
                                }
                                
                                .preview-info-card {
                                    width: 85%;
                                    max-width: 320px;
                                    flex: none;
                                    padding: 0.45rem 0.875rem;
                                    border-radius: 12px;
                                    gap: 0.6rem;
                                    background: rgba(255, 255, 255, 0.08);
                                    border: 1px solid rgba(255, 255, 255, 0.15);
                                    backdrop-filter: none;
                                }
                                
                                .preview-info-text {
                                    gap: 0;
                                }
                                
                                .preview-info-label {
                                    font-size: 0.8rem;
                                    line-height: 1.2;
                                }
                                
                                .preview-info-detail {
                                    font-size: 0.75rem;
                                }
                                
                                .preview-hero-actions {
                                    flex-direction: column;
                                    align-items: center;
                                    align-self: stretch;
                                    gap: 0.6rem;
                                    margin-bottom: 1rem;
                                }
                                
                                .preview-btn-primary {
                                    width: fit-content;
                                    justify-content: center;
                                    padding: 0.65rem 1.5rem;
                                    font-size: 0.825rem;
                                }
                                
                                .preview-btn-secondary {
                                    width: auto;
                                    padding: 0;
                                    background: transparent;
                                    backdrop-filter: none;
                                    font-size: 0.825rem;
                                    gap: 0.4rem;
                                }
                                
                                .preview-btn-separator {
                                    display: none;
                                }
                                
                                .preview-club-jyza-btn {
                                    top: 1.5rem;
                                    right: 0.75rem;
                                    left: auto;
                                    width: auto;
                                    justify-content: flex-start;
                                    padding: 0.6rem 0.9rem 0.7rem;
                                    border-radius: 0 0 14px 0;
                                    flex-direction: column;
                                    align-items: center;
                                    gap: 0.35rem;
                                }
                                
                                .preview-club-jyza-icon {
                                    width: 16px;
                                    height: 16px;
                                }
                                
                                .preview-club-jyza-text {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    text-align: center;
                                    gap: 0;
                                }
                                
                                .preview-club-jyza-label {
                                    font-size: 0.55rem;
                                    letter-spacing: 0.8px;
                                }
                                
                                .preview-club-jyza-title {
                                    font-size: 0.75rem;
                                }
                                
                                .preview-club-jyza-arrow {
                                    width: 12px;
                                    height: 12px;
                                    display: none;
                                }
                            }
                            
                            @media (min-width: 1024px) and (max-width: 1199px) {
                                .preview-title {
                                    font-size: 2.5rem;
                                    margin-bottom: 1rem;
                                }
                                
                                .preview-description {
                                    font-size: 0.85rem;
                                    margin-bottom: 1.5rem;
                                }
                            }
                        </style>
                        
                        <!-- HTML HERO -->
                        <section class="preview-hero">
                            <div class="preview-hero-background">
                                <div class="preview-hero-gradient"></div>
                                <?php 
                                $heroImage = $resolveImageUrl($getBlockContent('hero_background_image', $section), $sectionImages ?? []);
                                ?>
                                <?php if (!empty($heroImage)): ?>
                                    <img src="<?= h($heroImage) ?>" alt="Hero" loading="lazy">
                                <?php endif; ?>
                            </div>
                            
                            <div class="preview-hero-container">
                                <div class="preview-hero-content">
                                    <?php 
                                    // Obtener todos los bloques como array asociativo para fácil acceso
                                    $blocks_data = [];
                                    foreach ($section->content_blocks as $block) {
                                        $blocks_data[$block->block_key] = $block->content;
                                    }
                                    ?>
                                    
                                    <?php 
                                    $logoUrl = $resolveImageUrl($blocks_data['logo_image'] ?? '', $sectionImages ?? []);
                                    if (!empty($logoUrl)): 
                                    ?>
                                        <img src="<?= h($logoUrl) ?>" alt="Logo" class="preview-logo-hero">
                                    <?php endif; ?>
                                    
                                    <div class="preview-badge">
                                        <span class="preview-badge-icon"></span>
                                        <span class="preview-badge-text"><?= h($blocks_data['badge_text'] ?? 'CITAS DISPONIBLES') ?></span>
                                    </div>
                                    
                                    <h1 class="preview-title"><?= h($blocks_data['titulo'] ?? 'Tu Salud Femenina') ?></h1>
                                    <p class="preview-description"><?= h($blocks_data['descripcion'] ?? 'Descripción de la clínica') ?></p>
                                    
                                    <div class="preview-hero-actions">
                                        <?php 
                                        $ctaButtonUrl = $blocks_data['cta_button_url'] ?? 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20cita';
                                        $ctaButtonText = $blocks_data['cta_button_text'] ?? 'Agendar Cita por WhatsApp';
                                        $buttonIconUrl = $resolveImageUrl($blocks_data['button_icon_image'] ?? '', $sectionImages ?? []);
                                        ?>
                                        <a href="<?= h($ctaButtonUrl) ?>" class="preview-btn-primary" target="_blank">
                                            <?php if (!empty($buttonIconUrl)): ?>
                                                <img src="<?= h($buttonIconUrl) ?>" alt="icono" style="width: 20px; height: 20px;">
                                            <?php endif; ?>
                                            <?= h($ctaButtonText) ?>
                                        </a>
                                        
                                        <a href="#servicios" class="preview-btn-secondary">
                                            <span class="preview-btn-separator">ó</span>
                                            <?= h($blocks_data['cta_secundario_text'] ?? 'Ver servicios') ?>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="preview-arrow-down">
                                                <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                    
                                    <div class="preview-info">
                                        <?php if (!empty($blocks_data['ubicacion'] ?? '')): ?>
                                            <div class="preview-info-card">
                                                <div class="preview-info-icon">
                                                    📍
                                                </div>
                                                <div class="preview-info-text">
                                                    <span class="preview-info-label"><?= h($blocks_data['ubicacion']) ?></span>
                                                    <span class="preview-info-detail"><?= h($blocks_data['ubicacion_detail'] ?? '') ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($blocks_data['horarios'] ?? '')): ?>
                                            <div class="preview-info-card">
                                                <div class="preview-info-icon">
                                                    🕐
                                                </div>
                                                <div class="preview-info-text">
                                                    <span class="preview-info-label"><?= h($blocks_data['horarios']) ?></span>
                                                    <span class="preview-info-detail"><?= h($blocks_data['horarios_detail'] ?? '') ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Club JYZA Button (Floating) -->
                            <?php 
                            $clubButtonUrl = $blocks_data['club_button_url'] ?? 'https://wa.me/51961295024?text=Hola,%20deseo%20inscribirme%20al%20Club%20JYZA';
                            $clubButtonLabel = $blocks_data['club_button_label'] ?? 'Únete';
                            $clubButtonTitle = $blocks_data['club_button_title'] ?? 'Club JYZA';
                            $clubButtonAria = $blocks_data['club_button_aria'] ?? 'Inscríbete al Club JYZA por WhatsApp';
                            ?>
                            <a href="<?= h($clubButtonUrl) ?>" class="preview-club-jyza-btn" target="_blank" aria-label="<?= h($clubButtonAria) ?>">
                                <svg class="preview-club-jyza-icon" width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.5l2.9 5.88 6.49.94-4.69 4.57 1.11 6.46L12 17.95 6.19 20.35l1.11-6.46-4.69-4.57 6.49-.94L12 2.5z" fill="currentColor"/>
                                </svg>
                                <div class="preview-club-jyza-text">
                                    <span class="preview-club-jyza-label"><?= h($clubButtonLabel) ?></span>
                                    <span class="preview-club-jyza-title"><?= h($clubButtonTitle) ?></span>
                                </div>
                                <svg class="preview-club-jyza-arrow" width="16" height="16" viewBox="0 0 20 20" fill="none">
                                    <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </a>
                        </section>
                        <?php elseif ($section->slug === 'porqueelegirnos'): ?>
                        <!-- POR QUE ELEGIRNOS SECTION PREVIEW -->
                        <style>
                            .preview-about-section {
                                padding: 5rem 0;
                                background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
                                display: flex;
                                align-items: center;
                            }

                            .preview-about-content {
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                                gap: 4rem;
                                align-items: center;
                                max-width: 1200px;
                                margin: 0 auto;
                                padding: 0 2rem;
                                width: 100%;
                            }

                            .preview-about-gallery {
                                position: relative;
                                margin-top: 100px;
                            }

                            .preview-gallery-grid {
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                grid-template-rows: auto auto;
                                gap: 1rem;
                                height: 550px;
                            }

                            .preview-gallery-img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                border-radius: 20px;
                            }

                            .preview-img-1 {
                                grid-row: 1 / 2;
                                grid-column: 1 / 2;
                                height: 280px;
                            }

                            .preview-img-2 {
                                grid-row: 1 / 2;
                                grid-column: 2 / 3;
                                height: 180px;
                                margin-top: 2rem;
                            }

                            .preview-img-3 {
                                grid-row: 2 / 3;
                                grid-column: 1 / 2;
                                height: 180px;
                                margin-top: -2.5rem;
                            }

                            .preview-img-4 {
                                grid-row: 2 / 3;
                                grid-column: 2 / 3;
                                height: 280px;
                                margin-top: -6.8rem;
                            }

                            .preview-about-text {
                                display: flex;
                                flex-direction: column;
                                gap: 1.5rem;
                            }

                            .preview-section-label {
                                display: inline-flex;
                                align-items: center;
                                gap: 0.5rem;
                                padding: 0.5rem 1rem;
                                background: #f0e6ff;
                                color: #7c3aed;
                                font-size: 0.875rem;
                                font-weight: 500;
                                border-radius: 20px;
                                border: 1.5px solid #e9d5ff;
                                width: fit-content;
                            }

                            .preview-section-title {
                                font-size: 2rem;
                                font-weight: 700;
                                line-height: 1.2;
                                color: #1a1a1a;
                                margin: 0;
                            }

                            .preview-highlight {
                                color: #7c3aed;
                            }

                            .preview-section-description {
                                color: #666;
                                font-size: 1rem;
                                line-height: 1.6;
                                margin: 0;
                                opacity: 0.8;
                            }

                            .preview-stats-grid {
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                gap: 1rem;
                                margin: 1rem 0;
                            }

                            .preview-stat-card {
                                background: white;
                                padding: 1.2rem;
                                border-radius: 12px;
                                box-shadow: 0 0 6px rgba(0, 0, 0, 0.19);
                            }

                            .preview-stat-number {
                                font-size: 2rem;
                                font-weight: 700;
                                color: #1a1a1a;
                                margin-bottom: 0.25rem;
                            }

                            .preview-stat-label {
                                font-size: 0.875rem;
                                color: #1a1a1a;
                                opacity: 0.7;
                            }

                            .preview-features-list {
                                display: flex;
                                flex-direction: column;
                                gap: 1rem;
                            }

                            .preview-feature-item {
                                display: flex;
                                align-items: center;
                                gap: 0.75rem;
                                color: #666;
                                font-size: 0.95rem;
                            }

                            .preview-check-icon {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                width: 28px;
                                height: 28px;
                                background: #7c3aed;
                                color: white;
                                border-radius: 9px;
                                flex-shrink: 0;
                            }

                            @media (max-width: 768px) {
                                .preview-about-section {
                                    padding: 0;
                                    min-height: 100vh;
                                    display: flex;
                                    align-items: center;
                                }

                                .preview-about-content {
                                    grid-template-columns: 1fr;
                                    gap: 1.25rem;
                                    padding: 2rem 1.5rem;
                                }

                                .preview-about-gallery {
                                    display: none;
                                }

                                .preview-about-text {
                                    gap: 1rem;
                                }

                                .preview-section-title {
                                    font-size: 1.75rem;
                                }

                                .preview-section-description {
                                    font-size: 0.9rem;
                                }

                                .preview-stats-grid {
                                    grid-template-columns: repeat(2, 1fr);
                                    gap: 0.75rem;
                                    width: 85%;
                                    margin: 0.5rem auto;
                                }

                                .preview-stat-card {
                                    padding: 0.875rem 1rem;
                                }

                                .preview-stat-number {
                                    font-size: 1.4rem;
                                }

                                .preview-stat-label {
                                    font-size: 0.775rem;
                                }

                                .preview-features-list {
                                    gap: 0.75rem;
                                }

                                .preview-feature-item {
                                    font-size: 0.875rem;
                                }
                            }
                        </style>

                        <section class="preview-about-section">
                            <div class="preview-about-content">
                                <!-- Galería -->
                                <div class="preview-about-gallery">
                                    <div class="preview-gallery-grid">
                                        <?php
                                        $img1 = $resolveImageUrl('1', $sectionImages ?? []);
                                        $img2 = $resolveImageUrl('2', $sectionImages ?? []);
                                        $img3 = $resolveImageUrl('3', $sectionImages ?? []);
                                        $img4 = $resolveImageUrl('4', $sectionImages ?? []);
                                        ?>
                                        <img src="<?= h($img1 ?: '/imag1.webp') ?>" alt="Doctor" class="preview-gallery-img preview-img-1" loading="lazy">
                                        <img src="<?= h($img2 ?: '/imag2.webp') ?>" alt="Equipo" class="preview-gallery-img preview-img-2" loading="lazy">
                                        <img src="<?= h($img3 ?: '/imag3.webp') ?>" alt="Sala" class="preview-gallery-img preview-img-3" loading="lazy">
                                        <img src="<?= h($img4 ?: '/imag4.webp') ?>" alt="Doctor" class="preview-gallery-img preview-img-4" loading="lazy">
                                    </div>
                                </div>

                                <!-- Contenido de texto -->
                                <div class="preview-about-text">
                                    <?php
                                    $por_blocks = [];
                                    foreach ($section->content_blocks as $block) {
                                        $por_blocks[$block->block_key] = $block->content;
                                    }
                                    ?>
                                    <div class="preview-section-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                        <span><?= h($por_blocks['section_label'] ?? 'Por qué elegirnos') ?></span>
                                    </div>

                                    <h2 class="preview-section-title">
                                        <?= h($por_blocks['titulo'] ?? 'Tu Bienestar es Nuestra Prioridad') ?>
                                    </h2>

                                    <p class="preview-section-description">
                                        <?= h($por_blocks['descripcion'] ?? 'En JYZA combinamos experiencia médica, tecnología de vanguardia y un trato humano excepcional.') ?>
                                    </p>

                                    <!-- Stats -->
                                    <div class="preview-stats-grid">
                                        <div class="preview-stat-card">
                                            <div class="preview-stat-number"><?= h($por_blocks['stat_1_number'] ?? '10+') ?></div>
                                            <div class="preview-stat-label"><?= h($por_blocks['stat_1_label'] ?? 'Años de experiencia') ?></div>
                                        </div>
                                        <div class="preview-stat-card">
                                            <div class="preview-stat-number"><?= h($por_blocks['stat_2_number'] ?? '10,000+') ?></div>
                                            <div class="preview-stat-label"><?= h($por_blocks['stat_2_label'] ?? 'Pacientes atendidos') ?></div>
                                        </div>
                                        <div class="preview-stat-card">
                                            <div class="preview-stat-number"><?= h($por_blocks['stat_3_number'] ?? '98%') ?></div>
                                            <div class="preview-stat-label"><?= h($por_blocks['stat_3_label'] ?? 'Satisfacción') ?></div>
                                        </div>
                                        <div class="preview-stat-card">
                                            <div class="preview-stat-number"><?= h($por_blocks['stat_4_number'] ?? '100%') ?></div>
                                            <div class="preview-stat-label"><?= h($por_blocks['stat_4_label'] ?? 'Atención personalizada') ?></div>
                                        </div>
                                    </div>

                                    <!-- Features -->
                                    <div class="preview-features-list">
                                        <div class="preview-feature-item">
                                            <div class="preview-check-icon">✓</div>
                                            <span><?= h($por_blocks['feature_1_text'] ?? 'Equipos de ultrasonido 5D de última generación.') ?></span>
                                        </div>
                                        <div class="preview-feature-item">
                                            <div class="preview-check-icon">✓</div>
                                            <span><?= h($por_blocks['feature_2_text'] ?? 'Laboratorio clínico especializado.') ?></span>
                                        </div>
                                        <div class="preview-feature-item">
                                            <div class="preview-check-icon">✓</div>
                                            <span><?= h($por_blocks['feature_3_text'] ?? 'Instalaciones modernas con ambiente cálido y relajado.') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php else: ?>
                        <div style="padding: 2rem; color: #999; text-align: center;">
                            <p>No hay previsualización disponible para esta sección.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 */
?>
<div class="container-fluid mt-3 mt-md-4 mb-4 px-2 px-md-4">
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center gap-3">
                <h2 class="text-info mb-0 fs-4 fs-md-2"><i class="fas fa-certificate"></i> Detalle del Certificado</h2>
                <div class="d-flex gap-2 flex-wrap">
                    <?= $this->Html->link('<i class="fas fa-arrow-left"></i> <span class="d-none d-sm-inline">Regresar</span>', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-dark border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fs-6"><i class="fas fa-info-circle"></i> Información del Certificado</h5>
        </div>
        <div class="card-body p-2 p-md-4">
            <table class="table table-hover table-dark table-sm">
                <tr>
                    <th class="fs-7 fs-md-6">Usuario</th>
                    <td class="fs-7 fs-md-6"><?= $certificado->hasValue('user') ? $this->Html->link($certificado->user->username, ['controller' => 'Users', 'action' => 'view', $certificado->user->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Nombre del Titular</th>
                    <td class="fs-7 fs-md-6"><?= h($certificado->nombre_titular) ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">DNI del Titular</th>
                    <td class="fs-7 fs-md-6"><?= h($certificado->dni_titular) ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Curso</th>
                    <td class="fs-7 fs-md-6"><?= $certificado->hasValue('curso') ? $this->Html->link($certificado->curso->titulo, ['controller' => 'Cursos', 'action' => 'view', $certificado->curso->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Tipo</th>
                    <td class="fs-7 fs-md-6"><?= h($certificado->tipo) ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Nota Final</th>
                    <td class="fs-7 fs-md-6"><?= $certificado->nota_final !== null ? number_format($certificado->nota_final, 2) : '-' ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Fecha de Inicio</th>
                    <td class="fs-7 fs-md-6"><?= h(date('d/m/Y', strtotime($certificado->fecha_inicio))) ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Fecha de Fin</th>
                    <td class="fs-7 fs-md-6"><?= h(date('d/m/Y', strtotime($certificado->fecha_fin))) ?></td>
                </tr>
                <tr>
                    <th class="fs-7 fs-md-6">Archivo Subido</th>
                    <td class="fs-7 fs-md-6" colspan="1"></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Sección de Previsualización de Archivo -->
    <?php if (!empty($certificado->archivo_ruta)): ?>
        <div class="card border-0 shadow-sm bg-dark border-primary mt-3 mt-md-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fs-6"><i class="fas fa-file"></i> Archivo Adjunto</h5>
                <?php 
                    $fileExtension = strtolower(pathinfo($certificado->archivo_ruta, PATHINFO_EXTENSION));
                    $fileName = basename($certificado->archivo_ruta);
                ?>
                <a href="<?= $this->Url->assetUrl($certificado->archivo_ruta) ?>" download="<?= h($fileName) ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-download"></i> <span class="d-none d-sm-inline">Descargar</span>
                </a>
            </div>
            <div class="card-body p-2 p-md-4">
                <!-- Información del archivo -->
                <div class="mb-3">
                    <p class="text-muted fs-8 fs-md-6">
                        <strong>Nombre:</strong> <span class="text-break"><?= h($fileName) ?></span><br>
                        <strong>Tipo:</strong> <?= h(strtoupper($fileExtension)) ?>
                    </p>
                </div>

                <!-- Previsualización según tipo de archivo -->
                <div class="preview-container">
                    <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])): ?>
                        <!-- Previsualización de imagen -->
                        <div class="text-center">
                            <img src="<?= $this->Url->assetUrl($certificado->archivo_ruta) ?>" alt="Archivo Subido" class="img-fluid" style="max-width: 100%; max-height: 600px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 15px;">
                        </div>
                    <?php elseif ($fileExtension === 'pdf'): ?>
                        <!-- Previsualización de PDF usando PDF.js -->
                        <div class="pdf-viewer-wrapper" style="border: 1px solid #444; border-radius: 5px; overflow: auto; background: #1a1a1a;">
                            <div id="pdf-controls" style="background: #2d2d2d; padding: 10px; border-bottom: 1px solid #444;">
                                <button id="prev-page" class="btn btn-sm btn-primary" style="margin-right: 5px;">← Anterior</button>
                                <span id="page-info" style="margin: 0 10px; color: #fff;">Cargando PDF...</span>
                                <button id="next-page" class="btn btn-sm btn-primary" style="margin-left: 5px;">Siguiente →</button>
                            </div>
                            <div id="pdf-container" style="overflow: auto; max-height: 600px; display: flex; justify-content: center; align-items: flex-start; background: #1a1a1a; padding: 15px;">
                                <canvas id="pdf-canvas" style="max-width: 100%; border: 1px solid #444; border-radius: 3px; box-shadow: 0 0 10px rgba(0,0,0,0.5);"></canvas>
                            </div>
                        </div>
                        
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                        <script>
                            // Configurar el worker de PDF.js
                            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                            
                            const pdfUrl = '<?= $this->Url->assetUrl($certificado->archivo_ruta) ?>';
                            let pdfDoc = null;
                            let currentPage = 1;
                            
                            const canvas = document.getElementById('pdf-canvas');
                            const ctx = canvas.getContext('2d');
                            const pageInfo = document.getElementById('page-info');
                            const prevBtn = document.getElementById('prev-page');
                            const nextBtn = document.getElementById('next-page');
                            
                            // Cargar el PDF
                            pdfjsLib.getDocument(pdfUrl).promise.then(doc => {
                                pdfDoc = doc;
                                pageInfo.textContent = 'Página 1 de ' + pdfDoc.numPages;
                                renderPage(currentPage);
                            }).catch(err => {
                                pageInfo.textContent = 'Error al cargar el PDF: ' + err.message;
                                pageInfo.style.color = '#ff6b6b';
                            });
                            
                            // Renderizar una página
                            function renderPage(num) {
                                if (!pdfDoc) return;
                                
                                pdfDoc.getPage(num).then(page => {
                                    const scale = 1.5;
                                    const viewport = page.getViewport({scale: scale});
                                    
                                    canvas.height = viewport.height;
                                    canvas.width = viewport.width;
                                    
                                    const renderContext = {
                                        canvasContext: ctx,
                                        viewport: viewport
                                    };
                                    
                                    page.render(renderContext).promise.then(() => {
                                        pageInfo.textContent = 'Página ' + num + ' de ' + pdfDoc.numPages;
                                        prevBtn.disabled = num === 1;
                                        nextBtn.disabled = num === pdfDoc.numPages;
                                    });
                                });
                            }
                            
                            // Event listeners para navegación
                            prevBtn.addEventListener('click', () => {
                                if (currentPage > 1) {
                                    currentPage--;
                                    renderPage(currentPage);
                                }
                            });
                            
                            nextBtn.addEventListener('click', () => {
                                if (currentPage < pdfDoc.numPages) {
                                    currentPage++;
                                    renderPage(currentPage);
                                }
                            });
                        </script>
                    <?php elseif (in_array($fileExtension, ['doc', 'docx'])): ?>
                        <!-- Documento Word -->
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-file-word"></i> 
                            Documento de Word<br>
                            <small>Descarga el archivo para ver su contenido</small>
                        </div>
                    <?php elseif (in_array($fileExtension, ['xls', 'xlsx'])): ?>
                        <!-- Hoja de cálculo -->
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-file-excel"></i> 
                            Hoja de cálculo<br>
                            <small>Descarga el archivo para ver su contenido</small>
                        </div>
                    <?php else: ?>
                        <!-- Otros tipos de archivo -->
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-file"></i> 
                            Archivo de tipo <?= h(strtoupper($fileExtension)) ?><br>
                            <small>Descarga el archivo para abrir su contenido</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
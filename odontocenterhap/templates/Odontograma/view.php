<!-- <?= $this->Html->css('odontograma'); ?> -->

<div class="container-lg simple">
    <!-- <div id="odontograma"> -->
    <div id="odontograma" class="<?= $odontograma->tipo === 'adulto' ? 'odontograma-adulto' : ($odontograma->tipo === 'mixto' ? 'odontograma-mixto' : 'odontograma-nino') ?>">

        <div class="diente-container">
            <h4 class="titulo-seccion text-dark text-center mt-3 mb-3">
                <?= h($odontograma->titulo) ?> de: <?= h($odontograma->pacientes1->nombre . ' ' . $odontograma->pacientes1->apellido ?? 'Paciente no especificado') ?>
            </h4>
            <?php
            // Factor de escala para los símbolos (0.54 = 54%)
            $simboloScaleFactor = 0.54;

            // Función helper para obtener dimensiones escaladas de símbolos
            if (!function_exists('getScaledSymbolDimensions')) {
                function getScaledSymbolDimensions($imagePath, $scaleFactor) {
                    list($originalWidth, $originalHeight) = getimagesize($imagePath);
                    return [
                        'width' => round($originalWidth * $scaleFactor),
                        'height' => round($originalHeight * $scaleFactor)
                    ];
                }
            }
            
            // Renderizado especial para tipo 'mixto':
            // - Fila superior: dientes adultos superiores (combina 18..11 y 21..28 -> 16)
            // - Fila central: dientes de niño superiores (combina 55..51 y 61..65 -> 10)
            // - Fila inferior: dientes adultos inferiores (combina 48..41 y 31..38 -> 16)

            // Helper para renderizar una lista de posiciones
            $renderDientes = function($positions) use ($odontograma, $simboloScaleFactor) {
                foreach ($positions as $posicion) {
                    // Filtrar el diente correspondiente
                    $odontogramaDiente = array_filter($odontograma->odontograma_dientes, fn($d) => $d->diente->posicion == $posicion);
                    $odontogramaDiente = array_shift($odontogramaDiente);

                    $dienteId = $odontogramaDiente->diente->id ?? null;
                    if (!$dienteId) {
                        continue;
                    }
                    ?>
                    <!-- Contenedor de cada diente -->
                    <div class="diente" 
                        data-diente-id="<?= $dienteId ?>" 
                            style="position: relative; width: 30px; height: 134px; 
                                    background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                    background-size: contain; background-repeat: no-repeat; border: 1px solid transparent;">
                        
                        <?php if (!empty($odontogramaDiente->simbolos)): ?>
                            <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                <?php
                                $dims = getScaledSymbolDimensions(WWW_ROOT . $simbolo->simbolo->imagen, $simboloScaleFactor);
                                ?>
                                <?= $this->Html->image($simbolo->simbolo->imagen, [
                                    'alt' => $simbolo->simbolo->nombre,
                                    'class' => 'simbolo',
                                    'data-id' => $simbolo->simbolo->id,
                                    'data-pos-x' => $simbolo->posicion_x,
                                    'data-pos-y' => $simbolo->posicion_y,
                                    'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $dims['width'] . 'px; height: ' . $dims['height'] . 'px; max-width: none; max-height: none;',
                                    'draggable' => false,
                                ]) ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php
                }
            };

            if ($odontograma->tipo === 'mixto') {
                // Fila superior: adulto (16 posiciones)
                ?>
                <div class="odontograma-grid">
                    <?php $renderDientes(array_merge(range(18, 11), range(21, 28))); ?>
                </div>

                <!-- Fila central superior: niño (10 posiciones) centrada -->
                <div class="odontogramaN-grid" style="display:flex; justify-content:center; gap:5px; margin:6px 0;">
                    <?php $renderDientes(array_merge(range(55, 51), range(61, 65))); ?>
                </div>

                <!-- Fila central inferior: niño (10 posiciones) centrada (completa las 20 posiciones de dentición primaria) -->
                <div class="odontogramaN-grid" style="display:flex; justify-content:center; gap:5px; margin:6px 0;">
                    <?php $renderDientes(array_merge(range(85, 81), range(71, 75))); ?>
                </div>

                <!-- Fila inferior: adulto (16 posiciones) -->
                <div class="odontograma-grid">
                    <?php $renderDientes(array_merge(range(48, 41), range(31, 38))); ?>
                </div>
                <?php
            } else {
                // Odontograma de adultos: 2 filas de 16 dientes cada una
                if ($odontograma->tipo === 'adulto') {
                    ?>
                    <!-- Fila superior: adulto (16 posiciones) -->
                    <div class="odontograma-grid">
                        <?php $renderDientes(array_merge(range(18, 11), range(21, 28))); ?>
                    </div>

                    <!-- Fila inferior: adulto (16 posiciones) -->
                    <div class="odontograma-grid">
                        <?php $renderDientes(array_merge(range(48, 41), range(31, 38))); ?>
                    </div>
                    <?php
                } else {
                    // Odontograma de niños: 2 filas de 10 dientes cada una
                    ?>
                    <!-- Fila superior: niño (10 posiciones) -->
                    <div class="odontogramaN-grid" style="display:grid; grid-template-columns: repeat(10, 30px); gap:3px; justify-content:center;">
                        <?php $renderDientes(array_merge(range(55, 51), range(61, 65))); ?>
                    </div>

                    <!-- Fila inferior: niño (10 posiciones) -->
                    <div class="odontogramaN-grid" style="display:grid; grid-template-columns: repeat(10, 30px); gap:3px; justify-content:center;">
                        <?php $renderDientes(array_merge(range(85, 81), range(71, 75))); ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<!-- aqui los Detalles -->
<div class="container-lg menorcontent">
    <div class="simbolos-container mt-4">
        <h4 class="titulo-seccion text-muted text-center mb-3">Detalles del Odontograma</h4>

        <!-- Mostrar los detalles existentes -->
        <div class="table-responsive" style="max-width: 1000px; margin: 0 auto;">
            <table class="table table-striped table-bordered">
                <thead class="table-ligth">
                    <tr class="text-center">
                        <th>Especificaciones</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($odontograma->odontograma_detalles as $detalle): ?>
                        <tr>
                            <td><?= h($detalle->especificaciones) ?></td>
                            <td><?= h($detalle->observaciones) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container-lg text-center mt-4 no-print">
    <div class="simbolos-container mt-4">
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <!-- Botón Volver a la Lista -->
            <?= $this->Html->link(
                __('Volver'),
                ['action' => 'index'],
                ['class' => 'btn btn-info mx-2'] // Espaciado horizontal
            ) ?>

            <!-- Botón Editar Odontograma -->
            <?= $this->Html->link(
                __('Editar'),
                ['action' => 'edit', $odontograma->id],
                ['class' => 'btn btn-info mx-2', 'target' => '_blank'] // Espaciado horizontal
            ) ?>

            <!-- Botón Descargar PDF -->
            <button onclick="generarPDF()" class="btn btn-success mx-2" id="btnPDF">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </button>
        </div>
    </div>
</div>

<!-- Librerías para PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous"></script>

<script>
// Definir función global para generar PDF
window.generarPDF = function() {
    // Verificar si las librerías están disponibles
    if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined') {
        alert('Las librerías de PDF no están cargadas. Por favor recarga la página.');
        return;
    }
    
    const btnPDF = document.getElementById('btnPDF');
    if (btnPDF) {
        btnPDF.disabled = true;
        btnPDF.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando PDF...';
    }
    
    // Buscar el contenido del odontograma
    let elementoOriginal = document.querySelector('.simple');
    const modalActivo = document.querySelector('.modal.show');
    let estamosEnModal = false;
    
    if (modalActivo && modalActivo.querySelector('.simple')) {
        elementoOriginal = modalActivo.querySelector('.simple');
        estamosEnModal = true;
        console.log('Detectado contenido en modal');
    }
    
    if (!elementoOriginal) {
        alert('No se encontró el contenido para generar el PDF.');
        if (btnPDF) {
            btnPDF.disabled = false;
            btnPDF.innerHTML = '<i class="fas fa-file-pdf"></i> Descargar PDF';
        }
        return;
    }
    
    // NUEVA ESTRATEGIA: Usar html2canvas directamente y luego jsPDF
    const nombrePaciente = '<?= h($odontograma->pacientes1->nombre . '_' . $odontograma->pacientes1->apellido) ?>';
    const nombreArchivo = 'Odontograma_' + nombrePaciente + '.pdf';
    
    console.log('Iniciando captura para:', nombreArchivo);
    
    // Ocultar elementos no deseados temporalmente
    const elementosOcultar = elementoOriginal.querySelectorAll('.no-print');
    elementosOcultar.forEach(el => el.style.display = 'none');
    
    // Asegurar que el contenido sea visible
    if (estamosEnModal) {
        // Guardar el estado del modal
        const estadoModal = {
            overflow: modalActivo.style.overflow,
            maxHeight: modalActivo.querySelector('.modal-dialog').style.maxHeight,
            height: modalActivo.querySelector('.modal-body').style.height
        };
        
        // Hacer el modal completamente visible
        modalActivo.style.overflow = 'visible';
        const modalDialog = modalActivo.querySelector('.modal-dialog');
        const modalBody = modalActivo.querySelector('.modal-body');
        if (modalDialog) modalDialog.style.maxHeight = 'none';
        if (modalBody) {
            modalBody.style.height = 'auto';
            modalBody.style.overflow = 'visible';
        }
        
        // Esperar un momento y capturar
        setTimeout(() => {
            capturarYGenerarPDF(elementoOriginal, nombreArchivo, btnPDF, elementosOcultar, estamosEnModal, estadoModal, modalActivo);
        }, 500);
    } else {
        capturarYGenerarPDF(elementoOriginal, nombreArchivo, btnPDF, elementosOcultar, false, null, null);
    }
};

window.capturarYGenerarPDF = function(elemento, nombreArchivo, btnPDF, elementosOcultar, estamosEnModal, estadoModal, modalActivo) {
    console.log('Capturando elemento...', elemento);
    console.log('Dimensiones:', elemento.offsetWidth, 'x', elemento.offsetHeight);
    
    // Ocultar temporalmente el backdrop del modal
    let backdrop = null;
    if (estamosEnModal) {
        backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.style.display = 'none';
        }
    }
    
    // Usar html2canvas directamente
    html2canvas(elemento, {
        scale: 2,
        useCORS: true,
        allowTaint: true,
        backgroundColor: '#ffffff',
        logging: false,
        width: elemento.scrollWidth,
        height: elemento.scrollHeight,
        x: 0,
        y: 0,
        scrollX: 0,
        scrollY: 0,
        windowWidth: elemento.scrollWidth,
        windowHeight: elemento.scrollHeight,
        ignoreElements: function(element) {
            // Ignorar el backdrop del modal y elementos no-print
            return element.classList.contains('modal-backdrop') || 
                   element.classList.contains('no-print');
        },
        onclone: function(clonedDoc) {
            // Asegurar que el elemento clonado sea visible
            const clonedElement = clonedDoc.querySelector('.simple');
            if (clonedElement) {
                clonedElement.style.display = 'block';
                clonedElement.style.width = elemento.offsetWidth + 'px';
                clonedElement.style.backgroundColor = '#ffffff';
            }
            // Remover backdrop del documento clonado
            const clonedBackdrop = clonedDoc.querySelector('.modal-backdrop');
            if (clonedBackdrop) {
                clonedBackdrop.remove();
            }
        }
    }).then(canvas => {
        // Restaurar backdrop
        if (backdrop) {
            backdrop.style.display = '';
        }
        console.log('Canvas generado:', canvas.width, 'x', canvas.height);
        
        // Crear PDF con jsPDF
        const imgData = canvas.toDataURL('image/jpeg', 0.95);
        const pdf = new jspdf.jsPDF({
            orientation: 'landscape',
            unit: 'mm',
            format: 'a4'
        });
        
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        
        // Calcular dimensiones para que quepa en una sola página
        const margin = 10;
        const maxWidth = pageWidth - (margin * 2);
        const maxHeight = pageHeight - (margin * 2);
        
        // Calcular ratio de aspecto
        const canvasRatio = canvas.width / canvas.height;
        const pageRatio = maxWidth / maxHeight;
        
        let imgWidth, imgHeight;
        
        // Ajustar según el ratio para que quepa en la página
        if (canvasRatio > pageRatio) {
            // La imagen es más ancha, ajustar por ancho
            imgWidth = maxWidth;
            imgHeight = maxWidth / canvasRatio;
        } else {
            // La imagen es más alta, ajustar por alto
            imgHeight = maxHeight;
            imgWidth = maxHeight * canvasRatio;
        }
        
        // Centrar la imagen en la página
        const xPosition = (pageWidth - imgWidth) / 2;
        const yPosition = (pageHeight - imgHeight) / 2;
        
        // Agregar la imagen al PDF (todo en UNA sola página)
        pdf.addImage(imgData, 'JPEG', xPosition, yPosition, imgWidth, imgHeight);
        
        // Guardar el PDF
        pdf.save(nombreArchivo);
        console.log('PDF guardado exitosamente en una sola página');
        
        // Restaurar elementos ocultos
        elementosOcultar.forEach(el => el.style.display = '');
        
        // Restaurar estado del modal si estábamos en uno
        if (estamosEnModal && estadoModal && modalActivo) {
            modalActivo.style.overflow = estadoModal.overflow;
            const modalDialog = modalActivo.querySelector('.modal-dialog');
            const modalBody = modalActivo.querySelector('.modal-body');
            if (modalDialog) modalDialog.style.maxHeight = estadoModal.maxHeight;
            if (modalBody) modalBody.style.height = estadoModal.height;
        }
        
        // Restaurar botón
        if (btnPDF) {
            btnPDF.disabled = false;
            btnPDF.innerHTML = '<i class="fas fa-file-pdf"></i> Descargar PDF';
        }
    }).catch(error => {
        console.error('Error al generar canvas:', error);
        
        // Restaurar elementos ocultos
        elementosOcultar.forEach(el => el.style.display = '');
        
        // Restaurar estado del modal
        if (estamosEnModal && estadoModal && modalActivo) {
            modalActivo.style.overflow = estadoModal.overflow;
            const modalDialog = modalActivo.querySelector('.modal-dialog');
            const modalBody = modalActivo.querySelector('.modal-body');
            if (modalDialog) modalDialog.style.maxHeight = estadoModal.maxHeight;
            if (modalBody) modalBody.style.height = estadoModal.height;
        }
        
        // Restaurar botón
        if (btnPDF) {
            btnPDF.disabled = false;
            btnPDF.innerHTML = '<i class="fas fa-file-pdf"></i> Descargar PDF';
        }
        
        alert('Error al generar el PDF: ' + error.message);
    });
};
</script>


<style>
/* Contenedor principal del odontograma */
.simple{
    background-color: #D6D6D6;
}
#odontograma {
    position: relative;
    display: inline-block; /* Ajustar tamaño al contenido */
    transform-origin: top left; /* Escalar desde la esquina superior izquierda */
    transition: transform 0.3s ease, width 0.3s ease, height 0.3s ease; /* Transición suave */
    margin: 0;
    padding: 0;
  
}

/* Rejilla del odontograma para adultos */
.odontograma-grid {
    display: grid;
    grid-template-columns: repeat(16, 30px); /* Configuración de la rejilla */
    gap: 3px;
    justify-content: center; /* Cambiado de flex-start a center */
    transform-origin: top left;
}

/* Rejilla del odontograma para niños */
.odontogramaN-grid {
    display: grid;
    grid-template-columns: repeat(10, 30px); /* Configuración de la rejilla */
    gap: 3px;
    justify-content: center; /* Cambiado de flex-start a center */
    transform-origin: top left;
}

/* Contenedor de símbolos */
.simbolos-container {
    margin-top: 10px; /* Ajustar espaciado */
    padding: 20px;
    background-color: #2E2E2E; /* Fondo gris claro */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: margin-top 0.3s ease; /* Transición para el ajuste dinámico */
}

/* Estilo de cada diente */
.diente {
    position: relative;
    width: 30px !important;
    height: 134px !important;
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 3px;
}

/* Media Queries */

/* Media Queries */
@media (min-width: 1100px) {
    #odontograma {
        margin: 0 auto; /* Centra horizontalmente */
        display: block; /* Asegura que se comporte como un bloque */
    }
    
    .diente-container {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centra el contenido del odontograma */
    }

    .simbolos-container {
        margin: 10px auto; /* Centra horizontalmente y ajusta el espaciado arriba/abajo */
        text-align: center; /* Centra el contenido interno, si es necesario */
    }

    .container-lg {
        display: flex; /* Activa Flexbox */
        justify-content: center; /* Centra horizontalmente */
        align-items: center; /* Centra verticalmente */
        flex-direction: column; /* Asegura que los elementos estén en columna */
        max-width: 1200px; /* Limita el ancho del contenedor */
        margin: 0 auto; /* Centra todo el contenido */
        
    }
}


/* Tablets grandes */
@media (max-width: 1099px) {
    #odontograma {
        margin: 0 auto;
        transform: scale(0.85);
    }
    .simple{
        max-height: 650px;
    }
}

@media (max-width: 950px) {
    #odontograma {
        margin: 0 auto;
        transform: scale(0.85);
    }
    .simple{
        max-height: 550px;
    }
}


/* Tablets pequeñas */
@media (max-width: 768px) {
    #odontograma {
        margin: 0 auto;
        transform: scale(0.8);
    }

    .simbolos-container {
        margin-top: 10px;
    }
    .simple{
        max-height: 510px;
    }
}

/* Teléfonos grandes */
@media (max-width: 580px) {
    #odontograma.odontograma-adulto,
    #odontograma.odontograma-mixto {
        margin: 0 auto;
        transform: scale(0.80);
    }
    
    #odontograma.odontograma-nino {
        margin: 0 auto;
        transform: scale(0.65);
    }
    
    .simbolos-container {
        margin-top: 5px;
    }
    #btnPDF{
        margin-top: 10px;
    }
}

/* Teléfonos medianos */
@media (max-width: 440px) {
    #odontograma.odontograma-adulto,
    #odontograma.odontograma-mixto {
        margin: 0 auto;
        transform: scale(0.68);
    }
    
    #odontograma.odontograma-nino {
        margin: 0 auto;
        transform: scale(0.58);
    }
  
    .simbolos-container {
        margin-top: 0;
    }
    .simple{
        max-height: 440px;
    }
}

/* Teléfonos pequeños */
@media (max-width: 415px) {
    #odontograma.odontograma-adulto,
    #odontograma.odontograma-mixto {
        margin: 0 auto;
        transform: scale(0.60);
    }
    
    #odontograma.odontograma-nino {
        margin: 0 auto;
        transform: scale(0.52);
    }
    
    .simbolos-container {
        margin-top: 0;
    }
    .simple{
        max-height: 400px;
    }
}
@media (max-width: 375px) {
    #odontograma.odontograma-adulto,
    #odontograma.odontograma-mixto {
        margin: 0 auto;
        transform: scale(0.55);
    }
    .simple{
        max-height: 350px;
    }
}

/* Ajuste global para evitar márgenes adicionales */
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow-x: hidden;
}

.container-lg {
    margin: 0 auto;
    padding: 0 10px;
    max-width: 100%;   
    border-radius: 10px;
}

/* Clase para ocultar elementos en el PDF */
.no-print {
    /* Los elementos con esta clase no se incluirán en el PDF */
}


</style>

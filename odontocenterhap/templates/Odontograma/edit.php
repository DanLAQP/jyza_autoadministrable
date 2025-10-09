<!-- <?= $this->Html->css('odontograma'); ?> -->
<?php
// Factor de escala para símbolos (ajustado al tamaño reducido de dientes: 30x134px vs original 55x250px)
$simboloScaleFactor = 0.54;

// Función helper para generar dimensiones escaladas de símbolos
function getScaledSymbolDimensions($imagePath, $scaleFactor) {
    list($originalWidth, $originalHeight) = getimagesize($imagePath);
    return [
        'width' => round($originalWidth * $scaleFactor),
        'height' => round($originalHeight * $scaleFactor)
    ];
}
?>
<div class="odontograma-layout" style="display:flex; gap:20px; align-items:flex-start;">
    <div class="container-lg" style="flex:1;">

    <?php if ($odontograma->tipo === 'adulto'): ?>
        
        
    <div id="odontograma">
            <div class="diente-container">
                <h4 class="titulo-seccion"><?= h($odontograma->titulo) ?> de: <?= h($odontograma->pacientes1->nombre . ' ' . $odontograma->pacientes1->apellido ?? 'Paciente no especificado') ?></h4>

                <div class="odontograma-grid">
                    <?php
                    // Posiciones de dientes para adultos
                    $filas = [
                        ['dientes' => range(18, 11)], // Dientes superiores (derecha)
                        ['dientes' => range(21, 28)], // Dientes superiores (izquierda)
                        ['dientes' => range(48, 41)], // Dientes inferiores (derecha)
                        ['dientes' => range(31, 38)]  // Dientes inferiores (izquierda)
                    ];

                    foreach ($filas as $fila) {
                        foreach ($fila['dientes'] as $posicion) {
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
                                style="position: relative; width: 30px; height: 136px; 
                                        background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                        background-size: contain; border: 1px solid #111;">
                                
                                <?php if (!empty($odontogramaDiente->simbolos)): ?>
                                    <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                        <?php
                                        // Obtener dimensiones escaladas de la imagen del símbolo
                                        $dims = getScaledSymbolDimensions(WWW_ROOT . $simbolo->simbolo->imagen, $simboloScaleFactor);
                                        ?>
                                        <?= $this->Html->image($simbolo->simbolo->imagen, [
                                            'alt' => $simbolo->simbolo->nombre,
                                            'class' => 'simbolo',
                                            'data-id' => $simbolo->simbolo->id,
                                            'data-pos-x' => $simbolo->posicion_x,
                                            'data-pos-y' => $simbolo->posicion_y,
                                            'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $dims['width'] . 'px; height: ' . $dims['height'] . 'px; max-width: none; max-height: none;',
                                            'draggable' => true,
                                        ]) ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                    <?php 
                        } 
                    } 
                    ?>
                </div>
            </div>
        </div>
        <?php elseif ($odontograma->tipo === 'mixto'): ?>
    <div id="odontograma">
            <div class="diente-container">
                <h4 class="titulo-seccion"><?php
                    echo h(!empty($odontograma->pacientes1)
                        ? $odontograma->pacientes1->nombre . ' ' . $odontograma->pacientes1->apellido
                        : (!empty($odontograma->paciente)
                            ? $odontograma->paciente->nombre . ' ' . $odontograma->paciente->apellido
                            : 'Paciente no especificado'));
                ?> de: <?= h($odontograma->titulo) ?></h4>

                <!-- Fila superior: adulto (16 posiciones) -->
                <div class="odontograma-grid">
                    <?php
                    $positions = array_merge(range(18, 11), range(21, 28));
                    foreach ($positions as $posicion) {
                        $odontogramaDiente = array_filter($odontograma->odontograma_dientes, fn($d) => $d->diente->posicion == $posicion);
                        $odontogramaDiente = array_shift($odontogramaDiente);
                        $dienteId = $odontogramaDiente->diente->id ?? null;
                        if (!$dienteId) continue;
                    ?>
                        <div class="diente" 
                            data-diente-id="<?= $dienteId ?>" 
                            style="position: relative; width: 30px; height: 134px; 
                                    background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                    background-size: contain; border: 1px solid #111;">
                            <?php if (!empty($odontogramaDiente->simbolos)): ?>
                                <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                    <?php 
                                    list($originalWidth, $originalHeight) = getimagesize(WWW_ROOT . $simbolo->simbolo->imagen);
                                    $scaledWidth = round($originalWidth * $simboloScaleFactor);
                                    $scaledHeight = round($originalHeight * $simboloScaleFactor);
                                    ?>
                                    <?= $this->Html->image($simbolo->simbolo->imagen, [
                                        'alt' => $simbolo->simbolo->nombre,
                                        'class' => 'simbolo',
                                        'data-id' => $simbolo->simbolo->id,
                                        'data-pos-x' => $simbolo->posicion_x,
                                        'data-pos-y' => $simbolo->posicion_y,
                                        'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $scaledWidth . 'px; height: ' . $scaledHeight . 'px; max-width: none; max-height: none;',
                                        'draggable' => true,
                                    ]) ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- Fila central superior: niño (10 posiciones) centrada -->
                <div class="odontogramaN-grid" style="display:grid; grid-template-columns: repeat(10, 30px); gap:5px; justify-content:center;background-size: contain; margin:10px 0;">
                    <?php
                    $positions = array_merge(range(55, 51), range(61, 65));
                    foreach ($positions as $posicion) {
                        $odontogramaDiente = array_filter($odontograma->odontograma_dientes, fn($d) => $d->diente->posicion == $posicion);
                        $odontogramaDiente = array_shift($odontogramaDiente);
                        $dienteId = $odontogramaDiente->diente->id ?? null;
                        if (!$dienteId) continue;
                    ?>
                        <div class="diente" 
                            data-diente-id="<?= $dienteId ?>" 
                            style="position: relative; width: 30px; height: 134px; 
                                    background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                    background-size: contain; border: 1px solid #111;">
                            <?php if (!empty($odontogramaDiente->simbolos)): ?>
                                <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                    <?php $dims = getScaledSymbolDimensions(WWW_ROOT . $simbolo->simbolo->imagen, $simboloScaleFactor); ?>
                                    <?= $this->Html->image($simbolo->simbolo->imagen, [
                                        'alt' => $simbolo->simbolo->nombre,
                                        'class' => 'simbolo',
                                        'data-id' => $simbolo->simbolo->id,
                                        'data-pos-x' => $simbolo->posicion_x,
                                        'data-pos-y' => $simbolo->posicion_y,
                                        'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $dims['width'] . 'px; height: ' . $dims['height'] . 'px; max-width: none; max-height: none;',
                                        'draggable' => true,
                                    ]) ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- Fila central inferior: niño (10 posiciones) centrada -->
                <div class="odontogramaN-grid" style="display:grid; grid-template-columns: repeat(10, 30px); gap:5px; justify-content:center; margin:10px 0;">
                    <?php
                    $positions = array_merge(range(85, 81), range(71, 75));
                    foreach ($positions as $posicion) {
                        $odontogramaDiente = array_filter($odontograma->odontograma_dientes, fn($d) => $d->diente->posicion == $posicion);
                        $odontogramaDiente = array_shift($odontogramaDiente);
                        $dienteId = $odontogramaDiente->diente->id ?? null;
                        if (!$dienteId) continue;
                    ?>
                        <div class="diente" 
                            data-diente-id="<?= $dienteId ?>" 
                            style="position: relative; width: 30px; height: 134px; 
                                    background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                    background-size: contain; border: 1px solid #111;">
                            <?php if (!empty($odontogramaDiente->simbolos)): ?>
                                <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                    <?php $dims = getScaledSymbolDimensions(WWW_ROOT . $simbolo->simbolo->imagen, $simboloScaleFactor); ?>
                                    <?= $this->Html->image($simbolo->simbolo->imagen, [
                                        'alt' => $simbolo->simbolo->nombre,
                                        'class' => 'simbolo',
                                        'data-id' => $simbolo->simbolo->id,
                                        'data-pos-x' => $simbolo->posicion_x,
                                        'data-pos-y' => $simbolo->posicion_y,
                                        'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $dims['width'] . 'px; height: ' . $dims['height'] . 'px; max-width: none; max-height: none;',
                                        'draggable' => true,
                                    ]) ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
                </div>

                <!-- Fila inferior: adulto (16 posiciones) -->
                <div class="odontograma-grid">
                    <?php
                    $positions = array_merge(range(48, 41), range(31, 38));
                    foreach ($positions as $posicion) {
                        $odontogramaDiente = array_filter($odontograma->odontograma_dientes, fn($d) => $d->diente->posicion == $posicion);
                        $odontogramaDiente = array_shift($odontogramaDiente);
                        $dienteId = $odontogramaDiente->diente->id ?? null;
                        if (!$dienteId) continue;
                    ?>
                        <div class="diente" 
                            data-diente-id="<?= $dienteId ?>" 
                            style="position: relative; width: 30px; height: 134px; 
                                    background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                    background-size: contain; border: 1px solid #111;">
                            <?php if (!empty($odontogramaDiente->simbolos)): ?>
                                <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                    <?php $dims = getScaledSymbolDimensions(WWW_ROOT . $simbolo->simbolo->imagen, $simboloScaleFactor); ?>
                                    <?= $this->Html->image($simbolo->simbolo->imagen, [
                                        'alt' => $simbolo->simbolo->nombre,
                                        'class' => 'simbolo',
                                        'data-id' => $simbolo->simbolo->id,
                                        'data-pos-x' => $simbolo->posicion_x,
                                        'data-pos-y' => $simbolo->posicion_y,
                                        'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $dims['width'] . 'px; height: ' . $dims['height'] . 'px; max-width: none; max-height: none;',
                                        'draggable' => true,
                                    ]) ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php else: ?>
    <div id="odontograma">
            <div class="dienteN-container">
                <h4 class="titulo-seccion"><?= h($odontograma->titulo) ?> de: <?= h($odontograma->paciente->nombre . ' ' . $odontograma->paciente->apellido ?? 'Paciente no especificado') ?></h4>

                <div class="odontogramaN-grid">
                    <?php
                    // Posiciones para niños
                    $filas = [
                        ['dientes' => range(55, 51)], // Dientes superiores (derecha)
                        ['dientes' => range(61, 65)], // Dientes superiores (izquierda)
                        ['dientes' => range(85, 81)], // Dientes inferiores (derecha)
                        ['dientes' => range(71, 75)]  // Dientes inferiores (izquierda)
                    ];

                    foreach ($filas as $fila) {
                        foreach ($fila['dientes'] as $posicion) {
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
                                style="position: relative; width: 30px; height: 136px; 
                                        background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                        background-size: contain; border: 1px solid #111;">
                                
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
                                            'draggable' => true,
                                        ]) ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                    <?php 
                        } 
                    } 
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<!-- Filtro de categorías -->
<div class="container-lg">
    <div class="simbolos-container">
        <!-- Área de símbolos disponibles -->
        <!-- <h4 class="titulo-seccion">Arrastra un símbolo al diente</h4> -->
        <h4 class="titulo-seccion">
            <span id="titulo-filtro">Arrastra un símbolo al diente</span>
        </h4>
        <div id="simbolos-list">
            <?php foreach ($simbolosDisponibles as $simbolo): ?>
                <?php $dims = getScaledSymbolDimensions(WWW_ROOT . $simbolo->imagen, $simboloScaleFactor); ?>
                <div class="simbolo-item" data-categoria="<?= $simbolo->categoria ?>" style="display: none; margin: 5px;">
                    <?= $this->Html->image($simbolo->imagen, [
                        'alt' => $simbolo->nombre,
                        'class' => 'simbolo-draggable',
                        'data-id' => $simbolo->id,
                        'draggable' => true,
                        'style' => 'cursor: move; width: ' . $dims['width'] . 'px; height: ' . $dims['height'] . 'px;'
                    ]) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <h4 class="titulo-seccion">Filtrar por Categoría</h4>
        <!-- Buscador de categorías -->
        <input type="text" id="buscador-categorias" class="form-control form-control-md customized-input bg-light text-dark border-primary mb-3" placeholder="Buscar categoría..." style="width: 200px;">
         <!-- Contenedor de categorías -->
        <div id="categorias-container" style="margin-bottom: 15px;">
            <?php foreach ($categorias as $categoria): ?>
                <button class="btn-categoria" data-categoria="<?= $categoria ?>" style="margin-right: 5px;">
                    <?= h($categoria) ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Botón de Guardar -->
<button id="savePositionButton"><i class="fas fa-save"></i></button>
<!-- <button id="savePositionButton">Guardar Posición</button> -->
<div id="trash-bin" >
    🗑️
</div>
<!-- aqui la prueba -->
<div class="container-lg mt-4">
    <div class="simbolos-container">
        <h4 class="titulo-seccion">Detalles del Odontograma</h4>

        <!-- Mostrar los detalles existentes -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>Especificaciones</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($odontograma->odontograma_detalles as $detalle): ?>
                        <tr>
                            <td><?= h($detalle->especificaciones) ?></td>
                            <td><?= h($detalle->observaciones) ?></td>
                            <td class="text-center">
                                <!-- Botón de Editar -->
                                <a href="<?= $this->Url->build(['controller' => 'OdontogramaDetalles', 'action' => 'edit', $detalle->id]) ?>" 
                                   class="btn btn-sm btn-primary openModalMd">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="container-lg">
    <div class="formulario-container">
        <h4 class="titulo-formulario ">Agregar Detalle</h4>
        
        <?= $this->Form->create(null, ['url' => ['action' => 'edit', $odontograma->id], 'class' => 'formulario-personalizado p-4 rounded shadow-sm text-dark']) ?>

        <div class="form-row">
            <!-- Campo Especificaciones -->
            <div class="form-group col-md-6">
                <?= $this->Form->control('especificaciones', [
                    'label' => 'Especificaciones:', 
                    'class' => 'form-control form-control-lg customized-input bg-light text-dark border-primary',
                    'required' => true, 
                    'placeholder' => 'Ingrese las especificaciones',
                    'autocomplete' => 'off'
                ]) ?>
            </div>

            <!-- Campo Observaciones -->
            <div class="form-group col-md-6">
                <?= $this->Form->control('observaciones', [
                    'label' => 'Observaciones:', 
                    'class' => 'form-control form-control-lg customized-input bg-white text-dark border-primary',
                    'required' => true, 
                    'placeholder' => 'Ingrese las observaciones',
                    'autocomplete' => 'off'
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= $this->Form->button(__('Guardar Detalle'), [
                'class' => 'btn btn-categoria custom-btn',
                'style' => 'width: 100%; max-width: 200px;',
                'id' => 'submitButton',
            ]) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
<!-- Formulario para editar el título -->
<div class="container-lg">
    <div class="formulario-container">
    <h4 class="titulo-formulario ">Cambiar titulo del odontograma </h4>
        <?= $this->Form->create(null, ['url' => ['action' => 'edit', $odontograma->id], 'class' => 'formulario-personalizado p-4 rounded shadow-sm text-dark']) ?>

        <div class="form-row">
            <!-- Campo para el Título -->
            <div class="form-group col-md-12">
                <?= $this->Form->control('titulo', [
                    'label' => 'Título del Odontograma:', 
                    'class' => 'form-control form-control-lg customized-input bg-light text-dark border-primary',
                    'required' => true,
                    'maxlength' => 50,
                    'placeholder' => 'Ingrese el título del odontograma',
                    'value' => h($odontograma->titulo), // Prellenar con el título actual
                    'autocomplete' => 'off'
                ]) ?>
            </div>
        </div>

        <!-- Botón para guardar cambios -->
        <div class="form-group">
            <?= $this->Form->button(__('Guardar Cambios'), [
                'class' => 'btn btn-categoria custom-btn',
                'style' => 'width: 100%; max-width: 200px;',
                'id' => 'submitButton',
            ]) ?>
        </div>
            
        <?= $this->Form->end() ?>

    </div>
</div>

<div class="container-lg text-center mt-4">
    <div class="simbolos-container mt-4">
        <div class="d-flex justify-content-center">
            <?= $this->Html->link(
                __('Volver a la Lista'),
                ['action' => 'index'],
                ['class' => 'btn btn-primary mx-2'] // Espaciado horizontal opcional
            ) ?>
        </div>
    </div>
</div>

<!-- Funcion pc completa y tactil -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn-categoria');
    const symbolsList = document.getElementById('simbolos-list');
    
    // Configura la eliminación con triple toque en los símbolos existentes
    setupTripleTapDelete();
    const trashBin = document.getElementById('trash-bin'); // Contenedor de basurero
    let currentSymbol = null; // Referencia al símbolo en movimiento

    // Ocultar todos los símbolos al inicio
    document.querySelectorAll('.simbolo-item').forEach(symbol => {
        symbol.style.display = 'none';
    });

    // Evento de filtro por categoría
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const categoria = this.dataset.categoria;

            // Filtrar los símbolos
            document.querySelectorAll('.simbolo-item').forEach(symbol => {
                if (symbol.dataset.categoria === categoria) {
                    symbol.style.display = 'inline-block';
                } else {
                    symbol.style.display = 'none';
                }
            });
        });
    });

    const symbols = document.querySelectorAll('.simbolo-draggable');
    const teethContainers = document.querySelectorAll('.diente');

    // Configurar eventos para drag y touch
    symbols.forEach(symbol => {
        symbol.addEventListener('dragstart', dragStartFromSymbolsList);
        symbol.addEventListener('touchstart', touchStartFromSymbolsList);
    });

    teethContainers.forEach(diente => {
        diente.addEventListener('dragover', dragOver);
        diente.addEventListener('drop', drop);

        diente.addEventListener('touchmove', touchMove);
        diente.addEventListener('touchend', touchDrop);
    });

    trashBin.addEventListener('dragover', dragOver);
    trashBin.addEventListener('drop', deleteSymbol);

    trashBin.addEventListener('touchmove', touchMove);
    trashBin.addEventListener('touchend', touchDelete);

    function dragStartFromSymbolsList(event) {
        initializeCurrentSymbol(event.target, event.clientX, event.clientY);
        event.dataTransfer.setData('text/plain', JSON.stringify(currentSymbol));
    }
   // prubas
   let touchCount = 0; // Contador de toques consecutivos
let touchTimeout = null; // Temporizador para reiniciar el contador

function setupTripleTapDelete() {
    document.querySelectorAll('.simbolo').forEach(symbol => {
        symbol.addEventListener('touchstart', (event) => {
            // Incrementar el contador de toques
            touchCount++;

            // Iniciar o reiniciar el temporizador
            if (!touchTimeout) {
                touchTimeout = setTimeout(() => {
                    touchCount = 0; // Reinicia el contador si no se completan los toques
                    touchTimeout = null;
                }, 500); // Tiempo máximo entre toques consecutivos
            }

            // Si el contador llega a 3, eliminar el símbolo
            if (touchCount === 3) {
                clearTimeout(touchTimeout); // Cancelar el temporizador
                touchCount = 0; // Reinicia el contador
                touchTimeout = null;

                touchDelete(event); // Llama a touchDelete para eliminar el símbolo
            }
        });

        symbol.addEventListener('touchmove', () => {
            clearTimeout(touchTimeout); // Cancelar el temporizador si el usuario mueve el dedo
            touchCount = 0; // Reinicia el contador
        });

        symbol.addEventListener('touchend', () => {
            // No reiniciar el contador aquí; se maneja con el temporizador
        });

        symbol.addEventListener('touchcancel', () => {
            clearTimeout(touchTimeout); // Cancelar el temporizador si el toque se interrumpe
            touchCount = 0; // Reinicia el contador
        });
    });
}

    function dragStart(event) {
    const rect = event.target.getBoundingClientRect();

    currentSymbol = {
        id: event.target.dataset.id,
        imageUrl: event.target.src,
        originalWidth: rect.width,
        originalHeight: rect.height,
        offsetX: event.clientX - rect.left,
        offsetY: event.clientY - rect.top,
        isNew: false, // Indica que es un símbolo existente
        element: event.target, // Referencia al elemento actual
    };

    event.dataTransfer.setData('text/plain', JSON.stringify(currentSymbol));
}

function touchStart(event) {
    const touch = event.touches[0];
    const rect = event.target.getBoundingClientRect();

    currentSymbol = {
        id: event.target.dataset.id,
        imageUrl: event.target.src,
        originalWidth: rect.width,
        originalHeight: rect.height,
        offsetX: touch.clientX - rect.left,
        offsetY: touch.clientY - rect.top,
        isNew: false, // Indica que no es un símbolo nuevo
        element: event.target, // Aseguramos que el elemento esté definido
    };
}


function touchStartFromSymbolsList(event) {
        const touch = event.touches[0];
        const rect = event.target.getBoundingClientRect();

        currentSymbol = {
            id: event.target.dataset.id,
            imageUrl: event.target.src,
            originalWidth: rect.width,
            originalHeight: rect.height,
            offsetX: touch.clientX - rect.left,
            offsetY: touch.clientY - rect.top,
            isNew: true, // Indica que es un nuevo símbolo
        };
    }

    function initializeCurrentSymbol(target, clientX, clientY) {
        const rect = target.getBoundingClientRect();

        currentSymbol = {
            id: target.dataset.id,
            imageUrl: target.src,
            originalWidth: rect.width,
            originalHeight: rect.height,
            offsetX: clientX - rect.left,
            offsetY: clientY - rect.top,
            isNew: true,
        };
    }

    function dragOver(event) {
        event.preventDefault();
    }

    function drop(event) {
        handleDrop(event, event.clientX, event.clientY);
    }

    function touchMove(event) {
    event.preventDefault();
    if (!currentSymbol || (!currentSymbol.element && !currentSymbol.isNew)) {
        return;
    }

    const touch = event.touches[0];
    const rect = event.currentTarget.getBoundingClientRect();

    // Calcular posición relativa dentro del contenedor
    const x = touch.clientX - rect.left - currentSymbol.offsetX;
    const y = touch.clientY - rect.top - currentSymbol.offsetY;

    // Detectar si el símbolo está fuera de un contenedor válido
    const targetContainer = getDienteContainerAtPoint(touch.clientX, touch.clientY);
    if (!targetContainer) {
        if (currentSymbol.preview) {
            currentSymbol.preview.classList.add('blocked'); // Agregar clase de bloqueo
        } else if (currentSymbol.element) {
            currentSymbol.element.classList.add('blocked');
        }
    } else {
        if (currentSymbol.preview) {
            currentSymbol.preview.classList.remove('blocked'); // Remover clase de bloqueo
        } else if (currentSymbol.element) {
            currentSymbol.element.classList.remove('blocked');
        }
    }

    // Actualizar la posición del símbolo si ya está en movimiento
    if (currentSymbol.isNew && currentSymbol.preview) {
        currentSymbol.preview.style.left = `${x}px`;
        currentSymbol.preview.style.top = `${y}px`;
    } else if (currentSymbol.element) {
        currentSymbol.element.style.left = `${x}px`;
        currentSymbol.element.style.top = `${y}px`;
    }
}



function touchDrop(event) {
    const touch = event.changedTouches[0];
    const targetContainer = getDienteContainerAtPoint(touch.clientX, touch.clientY);
    //si no hay simbolos para realizar el drop
    if (!currentSymbol) {
        return;
    }

    if (!targetContainer) {

        // Restaurar el símbolo a su última posición válida
        if (currentSymbol.element) {
            currentSymbol.element.style.left = `${lastValidPosition.x}px`;
            currentSymbol.element.style.top = `${lastValidPosition.y}px`;
            lastValidPosition.container.appendChild(currentSymbol.element); // Reasignar al último contenedor válido
        }

        return; // No soltar el símbolo
    }

    const rect = targetContainer.getBoundingClientRect();
    const x = touch.clientX - rect.left - currentSymbol.offsetX;
    const y = touch.clientY - rect.top - currentSymbol.offsetY;

    // Permitir colocar el símbolo
    if (currentSymbol.isNew) {
        createNewSymbol(targetContainer, x, y, targetContainer.dataset.dienteId);
    } else {
        moveExistingSymbol(targetContainer, x, y, targetContainer.dataset.dienteId);
    }

    // Actualizar la última posición válida
    lastValidPosition = {
        x: x,
        y: y,
        container: targetContainer,
    };

    currentSymbol = null;
}


function getDienteContainerAtPoint(x, y) {
    return Array.from(teethContainers).find(diente => {
        const rect = diente.getBoundingClientRect();
        return x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom;
    });
}
    function handleDrop(event, clientX, clientY) {
        const dienteId = event.currentTarget.dataset.dienteId;

        if (!currentSymbol || !currentSymbol.id || !currentSymbol.imageUrl || !dienteId) {
            
            return;
        }

        const rect = event.currentTarget.getBoundingClientRect();
        const x = clientX - rect.left - currentSymbol.offsetX;
        const y = clientY - rect.top - currentSymbol.offsetY;

        if (currentSymbol.isNew) {
            createNewSymbol(event.currentTarget, x, y, dienteId);
        } else {
            moveExistingSymbol(event.currentTarget, x, y, dienteId);
        }

        currentSymbol = null;
    }

    function createNewSymbol(container, x, y, dienteId) {
        let img = document.createElement('img');
        img.src = currentSymbol.imageUrl;
        img.classList.add('simbolo');
        img.setAttribute('data-id', currentSymbol.id);
        img.setAttribute('data-diente-id', dienteId);
        img.setAttribute('data-pos-x', x);
        img.setAttribute('data-pos-y', y);
        
        img.setAttribute('draggable', true);
        
        img.style.width = `${currentSymbol.originalWidth}px`;
        img.style.height = `${currentSymbol.originalHeight}px`;

        img.style.maxWidth = 'none';
        img.style.maxHeight = 'none';

        img.style.position = 'absolute';
        img.style.left = `${x}px`;
        img.style.top = `${y}px`;

        img.addEventListener('dragstart', dragStart);
        img.addEventListener('touchstart', touchStart);

        container.appendChild(img);
        // nueva para eliminar
        // Agregar eventos táctiles para el nuevo símbolo
    img.addEventListener('touchstart', (event) => {
        touchCount++;
        if (!touchTimeout) {
            touchTimeout = setTimeout(() => {
                touchCount = 0;
                touchTimeout = null;
            }, 500);
        }

        if (touchCount === 3) {
            clearTimeout(touchTimeout);
            touchCount = 0;
            touchTimeout = null;
            touchDelete(event);
        }
    });
    img.addEventListener('touchmove', () => {
        clearTimeout(touchTimeout);
        touchCount = 0;
    });

    img.addEventListener('touchend', () => {
        // Deja que el temporizador maneje el reinicio del contador
    });

    img.addEventListener('touchcancel', () => {
        clearTimeout(touchTimeout);
        touchCount = 0;
    });

    }

    function moveExistingSymbol(container, x, y, dienteId) {
        const symbolElement = currentSymbol.element;

        if (symbolElement.dataset.dienteId !== dienteId) {
            symbolElement.parentNode.removeChild(symbolElement);
            container.appendChild(symbolElement);
        }

        symbolElement.dataset.dienteId = dienteId;
        symbolElement.dataset.posX = x;
        symbolElement.dataset.posY = y;

        symbolElement.style.left = `${x}px`;
        symbolElement.style.top = `${y}px`;
    }

    // touch delete
    function touchDelete(event) {
    event.preventDefault();

    if (!currentSymbol || (!currentSymbol.element && !currentSymbol.isNew)) {

        return;
    }

    const touch = event.changedTouches[0];
    const targetContainer = getDienteContainerAtPoint(touch.clientX, touch.clientY);

    // Verificar si el símbolo no es nuevo
    if (currentSymbol.isNew === true) {
        alert("Este símbolo ya fue guardado y no puede ser eliminado.");
        return;
    }

    // Verificar si está en un contenedor válido
    if (!targetContainer) {
        alert("El símbolo no está en un área válida y no se puede eliminar.");
        return;
    }

    // Confirmar la eliminación
    const confirmDelete = confirm("¿Seguro que desea eliminar este símbolo?");
    if (confirmDelete) {
        currentSymbol.element.parentNode.removeChild(currentSymbol.element);
        console.log("Símbolo eliminado.");
        currentSymbol = null;
    }
}

    function deleteSymbol(event) {
        if (!currentSymbol || !currentSymbol.element) {
            return;
        }

        const confirmDelete = confirm("¿Seguro que desea eliminar este símbolo?");
        if (confirmDelete) {
            currentSymbol.element.parentNode.removeChild(currentSymbol.element);
            currentSymbol = null;
        }
    }
});
// Guardar las posiciones de los símbolos
document.getElementById('savePositionButton').addEventListener('click', () => {
        const positions = [];
        const odontogramaId = <?= $odontograma->id ?>;

        document.querySelectorAll('.diente .simbolo').forEach(symbol => {
            positions.push({
                symbolId: symbol.dataset.id,
                dienteId: symbol.dataset.dienteId,
                posX: parseFloat(symbol.dataset.posX),
                posY: parseFloat(symbol.dataset.posY),
                odontogramaId: odontogramaId
            });
            // Marcar como no nuevos después de guardar
        });

        fetch('<?= $this->Url->build(['controller' => 'Odontograma', 'action' => 'saveSymbolPositions']) ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>',
            },
            body: JSON.stringify(positions),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert('Posiciones guardadas con éxito');
                window.location.reload();
            } else {
                console.error('Error en el servidor:', data.message);
                alert('Error al guardar las posiciones');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
    });
</script>
<style>
    /* Paleta de colores */
:root {
    --primary-color: #336B8A;
    --secondary-color: #3F85AA;
    --background-color: #D6D6D6;
    --text-color: #2F5081;
}

/* Contenedor de dientes */
.diente-container, .dienteN-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
    /* max-height: 100vh; */
    overflow-y: auto;
    background-color: var(--background-color);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Rejilla de odontograma */
.odontograma-grid {
    display: grid;
    grid-template-columns: repeat(16, 30px);
    gap: 3px;
    justify-content: center;
}

.odontogramaN-grid {
    display: grid;
    grid-template-columns: repeat(10, 30px);
    gap: 3px;
    justify-content: center;
}

/* Estilo de cada diente */
.diente {
    position: relative;
    width: 30px !important;
    height: 134px !important;
    background-size: contain;
    border: 1px solid #B3B3B3;
    border-radius: 3px;
}

/* Contenedor de símbolos */
.simbolos-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background-color: var(--background-color);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.simbolos-list {
    display: flex;
    justify-content: center;
}

/* Elementos de símbolos */
.simbolo-item {
    display: inline-block;
    margin: 5px;
}

.titulo-seccion {
    font-size: 25px;
    font-weight: 500;
    color: var(--text-color);
    margin-bottom: 10px;
    text-align: center;
}

/* Botones de categoría */
#categorias-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 15px;
}

.simbolo {
    width: auto;
    height: auto;
    object-fit: contain;
    /* Los símbolos ahora vienen pre-escalados al 54% desde PHP y JS */
    /* No aplicar transform scale aquí para evitar doble escalado */
}

/* Símbolos arrastrables del panel de categorías */
.simbolo-draggable {
    /* Dimensiones ya escaladas desde PHP al 54%, no aplicar límites restrictivos */
    object-fit: contain;
    cursor: move;
}

.btn-categoria {
    padding: 10px 15px;
    background-color: var(--secondary-color);
    border: 1px solid var(--secondary-color);
    border-radius: 5px;
    cursor: pointer;
    color: #FFF;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s ease;
    min-width: 100px;
    max-width: 250px;
    flex-grow: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-categoria:hover,
.btn-categoria:focus,
.btn-categoria:active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Estado bloqueado */
.simbolo.blocked {
    cursor: not-allowed;
    opacity: 0.5;
    border: 2px dashed red;
}

/* Zoom utility for odontograma: scales the whole odontogram to 60% */
.odontograma-zoom {
    transform-origin: top center;
    transform: scale(0.6);
    /* Ensure the scaled content doesn't clip and remains interactive */
    display: inline-block;
    pointer-events: auto;
}

/* Botones de guardar y basurero */
#savePositionButton {
    position: fixed;
    bottom: 50px;
    right: 20px;
    background-color: transparent;
    color: var(--secondary-color);
    padding: 0px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 50px;
    transition: color 0.3s ease;
}

#savePositionButton:hover {
    color: #0056b3;
}

#trash-bin {
    position: fixed;
    bottom: 100px;
    right: 20px;
    font-size: 50px;
    color: red;
    cursor: pointer;
}

/* Tabla de detalles del odontograma */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th {
    background-color: var(--secondary-color);
    color: #fff;
    font-weight: bold;
    padding: 10px 15px;
}

td {
    background-color: #FFF;
    color: #000;
    padding: 10px 15px;
}

td a {
    color: var(--text-color);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

td a:hover {
    color: var(--primary-color);
}

/* Formularios */
.formulario-container {
    background-color: var(--background-color);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
}

.titulo-formulario {
    font-size: 25px;
    font-weight: 500;
    color: var(--text-color);
    padding-top: 20px;
    text-align: center;
    margin-bottom: 5px;
}

.formulario-personalizado {
    padding: 20px;
}

.formulario-personalizado .form-control {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid var(--secondary-color);
    color: #333;
    font-size: 1em;
}

.formulario-personalizado .form-control:focus {
    border-color: var(--primary-color);
    outline: none;
}

.formulario-personalizado .btn-categoria {
    padding: 10px 15px;
    background-color: var(--secondary-color);
    border: 1px solid var(--secondary-color);
    border-radius: 5px;
    cursor: pointer;
    color: #FFF;
    width: 100%;
    margin: 10px auto;
}

.formulario-personalizado .btn-categoria:hover,
.formulario-personalizado .btn-categoria:focus,
.formulario-personalizado .btn-categoria:active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

@media (max-width: 1200px) {
    .diente-container, .dienteN-container {
        align-items: start;
    }
}

@media (max-width: 760px) {
    #trash-bin {
        display: none;
    }
}

</style>
<script>
    $(document).on('click', '.btn-categoria', function () {
    // Obtén la categoría seleccionada
    const categoriaSeleccionada = $(this).data('categoria');
    
    // Actualiza el título
    $('#titulo-filtro').text('Arrastra un símbolo de la categoría: ' + categoriaSeleccionada);
    });
    // Función para filtrar las categorías mientras el usuario escribe
    $(document).on('input', '#buscador-categorias', function () {
        const query = $(this).val().toLowerCase(); // Obtener el texto de búsqueda
        $('.btn-categoria').each(function () {
            const categoria = $(this).data('categoria').toLowerCase(); // Obtener el nombre de la categoría
            if (categoria.includes(query)) {
                $(this).show(); // Mostrar las categorías que coinciden
            } else {
                $(this).hide(); // Ocultar las categorías que no coinciden
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
    $(document).on("submit", "form", function(event) {
        const form = $(this)[0]; 
        const btnGuardar = $(this).find("#submitButton");

        if (!form.checkValidity()) {
            event.preventDefault(); // Evita el envío si hay errores en el formulario
            return;
        }

        btnGuardar.prop("disabled", true).text("Guardando...");
    });

    // Detecta cambios en los archivos dentro del modal o cualquier formulario
    $(document).on("change", "input[type='file']", function() {
        const btnGuardar = $(this).closest("form").find("#submitButton");
        if (this.files.length > 0) {
            btnGuardar.prop("disabled", false);
        }
    });
});

</script>

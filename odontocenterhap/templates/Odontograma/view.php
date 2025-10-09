<!-- <?= $this->Html->css('odontograma'); ?> -->

<div class="container-lg simple">
    <!-- <div id="odontograma"> -->
    <div id="odontograma" class="<?= $odontograma->tipo === 'adulto' ? 'odontograma-adulto' : ($odontograma->tipo === 'mixto' ? 'odontograma-mixto' : 'odontograma-nino') ?>">

        <div class="diente-container">
            <h4 class="titulo-seccion text-dark text-center mt-3 mb-3">
                <?= h($odontograma->titulo) ?> de: <?= h($odontograma->pacientes1->nombre . ' ' . $odontograma->pacientes1->apellido ?? 'Paciente no especificado') ?>
            </h4>
            <?php
            // Renderizado especial para tipo 'mixto':
            // - Fila superior: dientes adultos superiores (combina 18..11 y 21..28 -> 16)
            // - Fila central: dientes de niño superiores (combina 55..51 y 61..65 -> 10)
            // - Fila inferior: dientes adultos inferiores (combina 48..41 y 31..38 -> 16)

            // Helper para renderizar una lista de posiciones
            $renderDientes = function($positions) use ($odontograma) {
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
                            style="position: relative; width: 55px; height: 250px; 
                                    background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                    background-size: contain; border: 1px solid transparent;">
                        
                        <?php if (!empty($odontogramaDiente->simbolos)): ?>
                            <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                <?php
                                // Obtener dimensiones de la imagen del símbolo
                                list($originalWidth, $originalHeight) = getimagesize(WWW_ROOT . $simbolo->simbolo->imagen);
                                ?>
                                <?= $this->Html->image($simbolo->simbolo->imagen, [
                                    'alt' => $simbolo->simbolo->nombre,
                                    'class' => 'simbolo',
                                    'data-id' => $simbolo->simbolo->id,
                                    'data-pos-x' => $simbolo->posicion_x,
                                    'data-pos-y' => $simbolo->posicion_y,
                                    'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $originalWidth . 'px; height: ' . $originalHeight . 'px; max-width: none; max-height: none;',
                                    'draggable' => true,
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
                // Configurar las filas según el tipo de odontograma (comportamiento existente)
                $filas = $odontograma->tipo === 'adulto' ?
                    [
                        ['dientes' => range(18, 11)], // Dientes superiores (derecha)
                        ['dientes' => range(21, 28)], // Dientes superiores (izquierda)
                        ['dientes' => range(48, 41)], // Dientes inferiores (derecha)
                        ['dientes' => range(31, 38)]  // Dientes inferiores (izquierda)
                    ] :
                    [
                        ['dientes' => range(55, 51)], // Dientes superiores (derecha, niños)
                        ['dientes' => range(61, 65)], // Dientes superiores (izquierda, niños)
                        ['dientes' => range(85, 81)], // Dientes inferiores (derecha, niños)
                        ['dientes' => range(71, 75)]  // Dientes inferiores (izquierda, niños)
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
                                style="position: relative; width: 55px; height: 250px; 
                                        background-image: url('<?= $this->Url->image($odontogramaDiente->diente->imagen ?? '') ?>'); 
                                        background-size: contain; border: 1px solid transparent;">
                            
                            <?php if (!empty($odontogramaDiente->simbolos)): ?>
                                    <?php foreach ($odontogramaDiente->simbolos as $simbolo): ?>
                                        <?php
                                        // Obtener dimensiones de la imagen del símbolo
                                        list($originalWidth, $originalHeight) = getimagesize(WWW_ROOT . $simbolo->simbolo->imagen);
                                        ?>
                                        <?= $this->Html->image($simbolo->simbolo->imagen, [
                                            'alt' => $simbolo->simbolo->nombre,
                                            'class' => 'simbolo',
                                            'data-id' => $simbolo->simbolo->id,
                                            'data-pos-x' => $simbolo->posicion_x,
                                            'data-pos-y' => $simbolo->posicion_y,
                                            'style' => 'position: absolute; left: ' . h($simbolo->posicion_x ?? 0) . 'px; top: ' . h($simbolo->posicion_y ?? 0) . 'px; width: ' . $originalWidth . 'px; height: ' . $originalHeight . 'px; max-width: none; max-height: none;',
                                            'draggable' => true,
                                        ]) ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                        </div>
                        <?php 
                    } 
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
<div class="container-lg text-center mt-4">
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
        </div>
    </div>
</div>


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
    grid-template-columns: repeat(16, 55px); /* Configuración de la rejilla */
    gap: 5px;
    justify-content: flex-start;
    transform-origin: top left;
}

/* Rejilla del odontograma para niños */
.odontogramaN-grid {
    display: grid;
    grid-template-columns: repeat(10, 55px); /* Configuración de la rejilla */
    gap: 5px;
    justify-content: flex-start;
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
    width: 55px;
    height: 250px;
    background-size: contain;
    /* border: 2px solid #B3B3B3; */
    border-radius: 5px;
}

/* Media Queries */

/* Media Queries */
@media (min-width: 1100px) {
    #odontograma {
        margin: 0 auto; /* Centra horizontalmente */
        display: block; /* Asegura que se comporte como un bloque */
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


/* Escalado pantallas intermedias */
@media (max-width: 1099px) {
    #odontograma {
        margin: 0 auto;
        transform: scale(0.50); /* Escalar al 50% */
        width: calc(16 * 55px * 0.4 + 15 * 5px * 0.4); /* Ajustar el ancho al escalado */
        height: calc(180px * 4 * 0.4 + 5px * 3 * 0.4); /* Altura basada en las filas y el escalado */
    }

    .simbolos-container {
        position: relative; /* Relativo al flujo del documento */
        
    }
}
/* Escalado para tablets pequeñas */
@media (max-width: 768px) {
    #odontograma.odontograma-adulto {
        
        margin-left:2rem;
        transform: scale(0.4); /* Escalar al 50% */
        width: calc(16 * 55px * 0.4 + 15 * 5px * 0.4); /* Ajustar el ancho al escalado */
        height: calc(55px * 4 * 0.4 + 5px * 3 * 0.4); /* Altura basada en las filas y el escalado */
    }
    #odontograma.odontograma-nino{ 
        margin-left:7rem;
        transform: scale(0.4); /* Escalar al 50% */
        width: calc(16 * 55px * 0.4 + 15 * 5px * 0.4); /* Ajustar el ancho al escalado */
        height: calc(55px * 4 * 0.4 + 5px * 3 * 0.4); /* Altura basada en las filas y el escalado */
    }
    #odontograma .odontogramaN-grid{
        margin: 0 auto;
    }

    .simbolos-container {
        position: relative; /* Relativo al flujo del documento */
        top: -80px;
    }
}
@media (max-width: 580px) {
    #odontograma.odontograma-nino {
        margin-left:6rem;
        transform: scale(0.35); /* Escalar al 30% */
        width: calc(16 * 55px * 0.35 + 15 * 5px * 0.30); /* Ancho ajustado */
        height: calc(55px * 4 * 0.35 + 5px * 3 * 0.30); /* Altura ajustada */
    }
}
@media (max-width: 440px) {
    #odontograma.odontograma-adulto {
        margin-left:1rem;
        transform: scale(0.35); /* Escalar al 30% */
        width: calc(16 * 55px * 0.35 + 15 * 5px * 0.30); /* Ancho ajustado */
        height: calc(55px * 4 * 0.35 + 5px * 3 * 0.30); /* Altura ajustada */
    }
    #odontograma.odontograma-nino {
        margin-left:4rem;
        transform: scale(0.35); /* Escalar al 30% */
        width: calc(16 * 55px * 0.35 + 15 * 5px * 0.30); /* Ancho ajustado */
        height: calc(55px * 4 * 0.35 + 5px * 3 * 0.30); /* Altura ajustada */
    }
  
    .simbolos-container {
        position: relative; /* Relativo al flujo del documento */
        top: -130px; /* Mueve 100px hacia arriba */
    }

    .table-responsive {
        margin-top: 10px; /* Ajusta el espaciado de la tabla si es necesario */
    }
}

@media (max-width: 380px) {
    #odontograma.odontograma-adulto {
        margin-left:1rem;
        transform: scale(0.30); /* Escalar al 30% */
        width: calc(16 * 55px * 0.35 + 15 * 5px * 0.30); /* Ancho ajustado */
        height: calc(55px * 4 * 0.35 + 5px * 3 * 0.30); /* Altura ajustada */
    }
    #odontograma.odontograma-nino {
        margin-left:3rem;
        transform: scale(0.30); /* Escalar al 30% */
        width: calc(16 * 55px * 0.35 + 15 * 5px * 0.30); /* Ancho ajustado */
        height: calc(55px * 4 * 0.35 + 5px * 3 * 0.30); /* Altura ajustada */
    }
    
    .simbolos-container {
        position: relative; /* Relativo al flujo del documento */
        top: -130px; /* Mueve 100px hacia arriba */
    }

    .table-responsive {
        margin-top: 10px; /* Ajusta el espaciado de la tabla si es necesario */
    }
}

    /* Ajuste global para evitar márgenes adicionales */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden; /* Evitar scroll horizontal */
    
    }

    .container-lg {
        margin: 0 auto;
        padding: 0;
        max-width: 100%;   
        border-radius: 10px;
    
    }

</style>

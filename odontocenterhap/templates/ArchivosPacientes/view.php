<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ArchivosPaciente $archivosPaciente
 */
?>

<style>
    .label-text {
        color: #f8f9fa;
        font-weight: bold;
    }
    .data-box {
        background-color: #6c757d;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 5px 10px;
        min-height: 38px;
        display: flex;
        align-items: center;
        color: #ffffff;
    }
</style>

<div class="container mt-4 mb-4">
    <!-- Título -->
    <div class="mb-4">
        <h3 class="text-info"><i class="fas fa-file-alt me-2"></i> Detalles del Archivo</h3>
    </div>

    <!-- Información del Archivo -->
    <div class="row mb-3">
        <!-- Paciente -->
        <div class="col-md-3">
            <p class="label-text"><?= __('Paciente:') ?></p>
        </div>
<div class="col-md-9">
    <div class="data-box">
        <?php if (!empty($archivosPaciente->paciente->pacientes1) && !empty($archivosPaciente->paciente->pacientes1->nombre)): ?>
            <?= $this->Html->link(
                h($archivosPaciente->paciente->pacientes1->nombre),
                ['controller' => 'Pacientes', 'action' => 'view', $archivosPaciente->paciente->pacientes1->id],
                ['class' => 'text-decoration-none text-white']
            ) ?>
        <?php else: ?>
            <span>No asignado</span>
        <?php endif; ?>
    </div>
</div>
    </div>

    <!-- Tipo -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Tipo:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($archivosPaciente->tipo) ?></div>
        </div>
    </div>

    <!-- Archivo -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Archivo:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box text-center">
                <?php
                $rutaArchivo = $archivosPaciente->ruta_archivo;
                $extension = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
                if (in_array($extension, ['png', 'jpg', 'jpeg'])):
                ?>
                    <img src="<?= $this->Url->build('/' . h($rutaArchivo), ['fullBase' => true]) ?>" 
                         alt="Imagen" class="img-fluid rounded shadow">
                <?php elseif ($extension === 'pdf'): ?>
                    <iframe src="<?= $this->Url->build('/' . h($rutaArchivo), ['fullBase' => true]) ?>" 
                            class="w-100 shadow-lg" style="height: 400px;" frameborder="0"></iframe>
                <?php else: ?>
                    <i class="fas fa-file-alt text-white mx-2"></i> Archivo no visualizable.
                    <?= $this->Html->link('Descargar', '/' . h($rutaArchivo), [
                        'download' => true,
                        'class' => 'btn btn-link text-white'
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Descripción:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($archivosPaciente->descripcion) ?: 'No especificada' ?></div>
        </div>
    </div>

    <!-- Fechas -->
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Creado:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($archivosPaciente->created) ?></div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <p class="label-text"><?= __('Modificado:') ?></p>
        </div>
        <div class="col-md-9">
            <div class="data-box"><?= h($archivosPaciente->modified) ?></div>
        </div>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $cursos
 */
$this->assign('title', 'Editar Inscripción');
?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm bg-dark border-warning">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Editar Inscripción
                    </h3>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($inscripcione, ['class' => 'needs-validation']) ?>
                    
                    <!-- Información del alumno y curso (solo lectura) -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong><i class="fas fa-user-graduate"></i> Alumno:</strong><br>
                                <span class="fs-5"><?= h($inscripcione->user->username) ?></span>
                                <?php if (!empty($inscripcione->user->dni)): ?>
                                    <br><small class="text-muted">DNI: <?= h($inscripcione->user->dni) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <strong><i class="fas fa-book"></i> Curso:</strong><br>
                                <span class="fs-5"><?= h($inscripcione->curso->titulo) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Campos editables -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->control('progreso', [
                                'label' => ['text' => '<i class="fas fa-chart-line"></i> Progreso del Curso (%)', 'escape' => false],
                                'class' => 'form-control form-control-lg',
                                'type' => 'number',
                                'min' => 0,
                                'max' => 100,
                                'required' => true
                            ]) ?>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Ingrese un valor entre 0 y 100
                            </small>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('estado', [
                                'label' => ['text' => '<i class="fas fa-toggle-on"></i> Estado de la Inscripción', 'escape' => false],
                                'options' => [
                                    'pendiente' => 'Pendiente',
                                    'aprobada' => 'Aprobada',
                                    'rechazada' => 'Rechazada'
                                ],
                                'class' => 'form-select form-select-lg',
                                'required' => true
                            ]) ?>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Cambia el estado de la inscripción
                            </small>
                        </div>
                    </div>

                    <!-- Preview del progreso -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">
                                <i class="fas fa-eye"></i> Vista Previa del Progreso
                            </label>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-info" 
                                     role="progressbar" 
                                     id="progress-preview"
                                     style="width: <?= $inscripcione->progreso ?>%;"
                                     aria-valuenow="<?= $inscripcione->progreso ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    <span id="progress-text"><?= $inscripcione->progreso ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                            <?= $this->Html->link(
                                '<i class="fas fa-times"></i> Cancelar',
                                ['action' => 'index'],
                                ['class' => 'btn btn-secondary btn-lg ms-2', 'escape' => false]
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i> Eliminar Inscripción',
                                ['action' => 'delete', $inscripcione->id],
                                [
                                    'confirm' => __('¿Desmatricular a {0} del curso {1}?', $inscripcione->user->username, $inscripcione->curso->titulo),
                                    'class' => 'btn btn-danger btn-lg ms-2',
                                    'escape' => false
                                ]
                            ) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const progresoInput = document.querySelector('input[name="progreso"]');
    const progressBar = document.getElementById('progress-preview');
    const progressText = document.getElementById('progress-text');
    
    if (progresoInput) {
        progresoInput.addEventListener('input', function() {
            let valor = parseInt(this.value) || 0;
            
            // Validar rango
            if (valor < 0) valor = 0;
            if (valor > 100) valor = 100;
            this.value = valor;
            
            // Actualizar barra de progreso
            progressBar.style.width = valor + '%';
            progressBar.setAttribute('aria-valuenow', valor);
            progressText.textContent = valor + '%';
            
            // Cambiar color según progreso
            progressBar.className = 'progress-bar';
            if (valor === 100) {
                progressBar.classList.add('bg-success');
            } else if (valor >= 50) {
                progressBar.classList.add('bg-info');
            } else {
                progressBar.classList.add('bg-warning');
            }
        });
    }
});
</script>

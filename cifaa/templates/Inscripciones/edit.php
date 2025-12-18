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
    <?= $this->Form->create($inscripcione, ['class' => 'row g-3']) ?>
    
    <!-- Información de la Inscripción -->
    <div class="col-12 mb-4">
        <h3 class="text-info"><i class="fas fa-edit"></i> Editar Inscripción</h3>
    </div>
    
    <!-- Campo: Usuario/Estudiante (solo lectura) -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Estudiante</label>
        <div class="form-control" style="padding: 0.375rem 0.75rem; line-height: 1.5;">
            <?php if ($inscripcione->hasValue('user') && $inscripcione->user): ?>
                <strong><?= h($inscripcione->user->username) ?></strong>
                <?php if (!empty($inscripcione->user->dni)): ?>
                    <div style="margin-top: 0.5rem;"><small class="text-muted">DNI: <?= h($inscripcione->user->dni) ?></small></div>
                <?php endif; ?>
            <?php else: ?>
                <span class="text-muted">-</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Campo: Curso (solo lectura) -->
    <div class="col-md-6 mb-3">
        <label class="form-label">Curso</label>
        <div class="form-control" style="padding: 0.375rem 0.75rem; line-height: 1.5;">
            <?php if ($inscripcione->hasValue('curso') && $inscripcione->curso): ?>
                <strong><?= h($inscripcione->curso->titulo) ?></strong>
            <?php else: ?>
                <span class="text-muted">-</span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Campo: Estado -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('estado', [
            'label' => 'Estado',
            'class' => 'form-control',
            'type' => 'select',
            'options' => [
                'pendiente' => 'Pendiente',
                'aprobada' => 'Aprobada',
                'rechazada' => 'Rechazada'
            ],
            'required' => true
        ]) ?>
        <small class="form-text text-muted">Estado de la inscripción.</small>
    </div>

    <!-- Campo: Progreso -->
    <div class="col-md-6 mb-3">
        <?= $this->Form->control('progreso', [
            'label' => 'Progreso (%)',
            'type' => 'number',
            'class' => 'form-control',
            'min' => 0,
            'max' => 100,
            'required' => true,
            'id' => 'progreso-input'
        ]) ?>
        <small class="form-text text-muted">Valor entre 0 y 100.</small>
    </div>

    <!-- Vista Previa del Progreso -->
    <div class="col-12 mb-3">
        <label class="form-label">Vista Previa del Progreso</label>
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

    <!-- Botones -->
    <div class="col-12 text-center">
        <?= $this->Form->button(__('Guardar Cambios'), ['class' => 'btn btn-warning']) ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>

<!-- CSS para placeholder visible y selects diferenciados -->
<style>
    .form-control::placeholder {
        color: #8eb4d6 !important;
        opacity: 1;
    }
    
    .form-control:focus::placeholder {
        color: #8eb4d6 !important;
    }
    
    /* Mejorar visual de los select */
    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22%3E%3Cpath fill=%22%23495057%22 d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E');
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 24px 24px;
        padding-right: 3rem;
        cursor: pointer;
    }
    
    select.form-control:hover {
        background-color: #f8f9fa;
    }
    
    select.form-control:focus {
        background-color: #fff;
    }

    .progress-bar {
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
</style>

<!-- Script para actualizar vista previa del progreso -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const progresoInput = document.getElementById('progreso-input');
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

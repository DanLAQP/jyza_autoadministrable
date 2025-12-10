<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscripcione $inscripcione
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 */
$usuario = $this->getRequest()->getAttribute('identity');
$esEstudiante = ($usuario && $usuario->rol == 3);
?>
<div class="container mt-4 mb-4">
    <?= $this->Form->create($inscripcione, ['class' => 'row g-3']) ?>
    
    <!-- Título de la sección -->
    <div class="col-12 mb-4">
        <h3 class="text-info">
            <i class="fas fa-user-plus"></i> 
            <?= $esEstudiante ? __('Solicitar Inscripción a Curso') : __('Nueva Inscripción') ?>
        </h3>
        <p class="text-muted">
            <?= $esEstudiante 
                ? __('Selecciona el curso al que deseas inscribirte. Tu solicitud será revisada por un administrador.') 
                : __('Crea una nueva inscripción para un estudiante.') 
            ?>
        </p>
    </div>

    <?php if (!$esEstudiante): ?>
        <!-- Campo: Usuario/Estudiante (Solo para Admin/Docente) -->
        <div class="col-md-6 mb-3">
            <label for="usuario-id" class="form-label">
                <i class="fas fa-user"></i> Estudiante
            </label>
            <?= $this->Form->control('usuario_id', [
                'options' => $users,
                'class' => 'form-control',
                'label' => false,
                'required' => true,
                'empty' => '-- Seleccione un estudiante --'
            ]) ?>
        </div>
    <?php endif; ?>

    <!-- Campo: Curso -->
    <div class="<?= $esEstudiante ? 'col-12' : 'col-md-6' ?> mb-3">
        <label for="curso-id" class="form-label">
            <i class="fas fa-book"></i> Curso
        </label>
        <?php if ($cursoId && $esEstudiante): ?>
            <!-- Curso pre-seleccionado desde la vista de curso -->
            <div class="alert alert-info">
                <strong>Curso seleccionado:</strong> <?= h($cursos[$cursoId]) ?>
            </div>
            <?= $this->Form->hidden('curso_id', ['value' => $cursoId]) ?>
        <?php else: ?>
            <?= $this->Form->control('curso_id', [
                'options' => $cursos,
                'class' => 'form-control',
                'label' => false,
                'required' => true,
                'empty' => '-- Seleccione un curso --'
            ]) ?>
        <?php endif; ?>
    </div>

    <?php if (!$esEstudiante): ?>
        <!-- Campo: Estado (Solo para Admin/Docente) -->
        <div class="col-md-6 mb-3">
            <label for="estado" class="form-label">
                <i class="fas fa-flag"></i> Estado
            </label>
            <?= $this->Form->control('estado', [
                'options' => [
                    'pendiente' => 'Pendiente',
                    'aprobada' => 'Aprobada',
                    'rechazada' => 'Rechazada'
                ],
                'class' => 'form-control',
                'label' => false,
                'default' => 'pendiente'
            ]) ?>
        </div>

        <!-- Campo: Progreso (Solo para Admin/Docente) -->
        <div class="col-md-6 mb-3">
            <label for="progreso" class="form-label">
                <i class="fas fa-chart-line"></i> Progreso (%)
            </label>
            <?= $this->Form->control('progreso', [
                'type' => 'number',
                'min' => 0,
                'max' => 100,
                'class' => 'form-control',
                'label' => false,
                'default' => 0,
                'placeholder' => '0-100'
            ]) ?>
        </div>
    <?php else: ?>
        <!-- Mensaje informativo para estudiantes -->
        <div class="col-12 mb-3">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Nota:</strong> Tu solicitud quedará en estado "Pendiente" hasta que sea aprobada por un administrador. 
                Recibirás una notificación cuando tu inscripción sea procesada.
            </div>
        </div>
    <?php endif; ?>

    <!-- Botones de acción -->
    <div class="col-12 mt-4">
        <?= $this->Form->button(
            '<i class="fas fa-paper-plane"></i> ' . ($esEstudiante ? __('Enviar Solicitud') : __('Crear Inscripción')),
            [
                'class' => 'btn btn-primary me-2',
                'escape' => false
            ]
        ) ?>
        <?= $this->Html->link(
            '<i class="fas fa-times"></i> ' . __('Cancelar'),
            $cursoId ? ['controller' => 'Cursos', 'action' => 'view', $cursoId] : ($esEstudiante ? ['action' => 'misInscripciones'] : ['action' => 'index']),
            [
                'class' => 'btn btn-secondary',
                'escape' => false
            ]
        ) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<style>
.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.form-label i {
    margin-right: 0.5rem;
    color: #17a2b8;
}
</style>

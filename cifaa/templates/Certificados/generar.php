<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $cursos
 */
?>
<div class="container mt-4 mb-4">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h3 class="card-title mb-0"><i class="fas fa-file-signature"></i> Generar Certificado</h3>
        </div>
        <div class="card-body">
            <?= $this->Form->create($certificado) ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <?= $this->Form->control('user_id', ['options' => $users, 'class' => 'form-select', 'label' => 'Seleccionar Alumno']) ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('curso_id', ['options' => $cursos, 'class' => 'form-select', 'label' => 'Seleccionar Curso']) ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('horas', ['class' => 'form-control', 'label' => 'Horas Académicas', 'min' => 1]) ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('fecha_emision', ['type' => 'date', 'class' => 'form-control', 'label' => 'Fecha de Emisión']) ?>
                </div>
            </div>
            <div class="mt-4 text-center">
                <?= $this->Form->button(__('Generar Certificado'), ['class' => 'btn btn-primary btn-lg']) ?>
                <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg ms-2']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

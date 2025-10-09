<?php $this->assign('title', 'Reporte de Órdenes'); ?>

<?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
<fieldset>
    <legend>Filtrar por Rango de Fechas, Estado y Tipo de Pago</legend>
    <div class="row">
        <div class="col">
            <!-- Fecha de inicio -->
            <?= $this->Form->control('start_date', [
                'type' => 'date',
                'label' => 'Fecha Inicio',
                'value' => $startDate ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Fecha de fin -->
            <?= $this->Form->control('end_date', [
                'type' => 'date',
                'label' => 'Fecha Fin',
                'value' => $endDate ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Estado de la orden -->
            <?= $this->Form->control('estado', [
                'type' => 'select',
                'options' => $opcionesEstado,
                'empty' => 'Todos los estados',
                'label' => 'Estado',
                'value' => $estado ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Doctor -->
            <?= $this->Form->control('doctor_id', [
                'type' => 'select',
                'options' => $doctores,
                'empty' => 'Todos los doctores',
                'label' => 'Doctor',
                'value' => $doctorId ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Paciente -->
            <?= $this->Form->control('paciente_id', [
                'type' => 'select',
                'options' => $pacientes,
                'empty' => 'Todos los pacientes',
                'label' => 'Paciente',
                'value' => $pacienteId ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Tratamiento -->
            <?= $this->Form->control('tratamiento_id', [
                'type' => 'select',
                'options' => $tratamientos,
                'empty' => 'Todos los tratamientos',
                'label' => 'Tratamiento',
                'value' => $tratamientoId ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
    </div>
</fieldset>
<?= $this->Form->button('Generar Reporte', ['class' => 'btn btn-primary mt-2', 'id' => 'generarReporteBtn']) ?>
<?= $this->Form->end() ?>

<h2 class="mt-4">Previsualización del Reporte</h2>
<iframe id="previewIframe" style="width: 100%; height: 600px; border: 1px solid #ccc;"></iframe>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Actualizar previsualización al cambiar filtros
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
        const doctorId = document.querySelector('select[name="doctor_id"]').value;
        const pacienteId = document.querySelector('select[name="paciente_id"]').value;
        const tratamientoId = document.querySelector('select[name="tratamiento_id"]').value;
        const startDate = document.querySelector('input[name="start_date"]').value;
        const endDate = document.querySelector('input[name="end_date"]').value;
        const estado = document.querySelector('select[name="estado"]').value;

        if (!startDate || !endDate) {
            alert('Por favor, ingrese ambas fechas: Fecha de Inicio y Fecha Fin.');
            return false;
        }

        if (startDate > endDate) {
            alert('La Fecha de Inicio no puede ser mayor que la Fecha Fin.');
            return false;
        }

        const url = `<?= $this->Url->build(['controller' => 'ReportesOrdenes', 'action' => 'exportarPdf']) ?>?doctor_id=${doctorId}&paciente_id=${pacienteId}&tratamiento_id=${tratamientoId}&start_date=${startDate}&end_date=${endDate}&estado=${estado}`;
        document.getElementById('previewIframe').src = url;
    });
});
</script
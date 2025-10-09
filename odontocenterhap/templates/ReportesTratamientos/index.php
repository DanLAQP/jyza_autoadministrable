<?php $this->assign('title', 'Reporte de Consultas'); ?>

<?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
<fieldset>
    <legend>Filtrar por Rango de Fechas, Doctor y Paciente</legend>
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
            <?= $this->Form->control('tipo_pago', [
                'type' => 'select',
                'options' => $opcionesPago, // Opciones de pago definidas en el controlador
                'empty' => 'Seleccione un Tipo de Pago',
                'label' => 'Tipo de Pago',
                'value' => $tipoPago ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Campo para seleccionar Doctor -->
            <?= $this->Form->control('doctor_id', [
                'type' => 'select',
                'options' => $doctores, // Debes pasar la lista de doctores desde el controlador
                'empty' => 'Seleccione un Doctor',
                'label' => 'Doctor',
                'value' => $doctorId ?? '',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Campo para seleccionar Paciente -->
            <?= $this->Form->control('paciente_id', [
                'type' => 'select',
                'options' => $pacientes, // Debes pasar la lista de pacientes desde el controlador
            'empty' => 'Seleccione un Paciente',
            'label' => 'Paciente',
            'value' => $pacienteId ?? '',
            'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col">
            <!-- Campo para seleccionar Tratamiento -->
            <?= $this->Form->control('tratamiento_id', [
                'type' => 'select',
                'options' => $tratamientos, // Debes pasar la lista de pacientes desde el controlador
            'empty' => 'Seleccione un Tratamiento',
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
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;
            const tipoPago = document.querySelector('select[name="tipo_pago"]').value; // Nuevo filtro
            const tratamientoId = document.querySelector('select[name="tratamiento_id"]').value;

            if (!startDate || !endDate) {
                alert('Por favor, ingrese ambas fechas: Fecha de Inicio y Fecha Fin.');
                return false;
            }

            if (startDate > endDate) {
                alert('La Fecha de Inicio no puede ser mayor que la Fecha Fin.');
                return false;
            }

            const url = `<?= $this->Url->build(['controller' => 'ReportesTratamientos', 'action' => 'exportarPdf']) ?>?doctor_id=${doctorId}&paciente_id=${pacienteId}&start_date=${startDate}&end_date=${endDate}&tipo_pago=${tipoPago}&tratamiento_id=${tratamientoId}`;
            document.getElementById('previewIframe').src = url;
        });

        // Validar y exportar al hacer clic en "Exportar Pdf"
        document.getElementById('exportPdfBtn').addEventListener('click', function () {
            const doctorId = document.querySelector('select[name="doctor_id"]').value;
            const pacienteId = document.querySelector('select[name="paciente_id"]').value;
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;
            const tipoPago = document.querySelector('select[name="tipo_pago"]').value; // Nuevo filtro
            const tratamientoId = document.querySelector('select[name="tratamiento_id"]').value;

            const url = `<?= $this->Url->build(['controller' => 'ReportesTratamientos', 'action' => 'exportarPdf']) ?>?doctor_id=${doctorId}&paciente_id=${pacienteId}&start_date=${startDate}&end_date=${endDate}&tipo_pago=${tipoPago}&tratamiento_id=${tratamientoId}&download=1`;
            window.location.href = url;
        });
    });
</script>
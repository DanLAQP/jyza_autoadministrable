<?php $this->assign('title', 'Reporte de Presupuestos'); ?>

<?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
<fieldset>
    <legend>Filtrar por Rango de Fechas, Paciente y Tratamiento</legend>
    <div class="row">
        <div class="col">
            <?= $this->Form->control('start_date', [
                'type' => 'date',
                'label' => 'Fecha Inicio',
                'class' => 'form-control',
                'value' => $startDate ?? ''
            ]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('end_date', [
                'type' => 'date',
                'label' => 'Fecha Fin',
                'class' => 'form-control',
                'value' => $endDate ?? ''
            ]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('paciente_id', [
                'type' => 'select',
                'options' => $pacientes,
                'empty' => 'Seleccione Paciente',
                'label' => 'Paciente',
                'class' => 'form-control',
                'value' => $pacienteId ?? ''
            ]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('tratamiento_id', [
                'type' => 'select',
                'options' => $tratamientos,
                'empty' => 'Tratamiento',
                'label' => 'Tratamiento',
                'class' => 'form-control',
                'value' => $tratamientoId ?? ''
            ]) ?>
        </div>
    </div>
</fieldset>
<?= $this->Form->button('Generar Reporte', ['class' => 'btn btn-primary mt-2', 'id' => 'generarReporteBtn']) ?>
<?= $this->Form->end() ?>

<h3 class="mt-4">Previsualización del Reporte</h3>
<iframe id="previewIframe" style="width: 100%; height: 600px; border: 1px solid #ccc;"></iframe>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Actualizar previsualización al cambiar filtros
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();
            const pacienteId = document.querySelector('select[name="paciente_id"]').value;
            const tratamientoId = document.querySelector('select[name="tratamiento_id"]').value;
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;

            
            if (!startDate || !endDate) {
                alert('Por favor, ingrese ambas fechas: Fecha de Inicio y Fecha Fin.');
                return false;
            }

            if (startDate > endDate) {
                alert('La Fecha de Inicio no puede ser mayor que la Fecha Fin.');
                return false;
            }
            const url = `<?= $this->Url->build(['controller' => 'ReportesPacientes', 'action' => 'exportarPdf']) ?>?paciente_id=${pacienteId}&tratamiento_id=${tratamientoId}&start_date=${startDate}&end_date=${endDate}`;
            document.getElementById('previewIframe').src = url;
        });

    // Validar y exportar al hacer clic en "Exportar Pdf"
        document.getElementById('exportPdfBtn').addEventListener('click', function () {
            const pacienteId = document.querySelector('select[name="paciente_id"]').value;
            const tratamientoId = document.querySelector('select[name="tratamiento_id"]').value;
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;

            const url = `<?= $this->Url->build(['controller' => 'ReportesPacientes', 'action' => 'exportarPdf']) ?>?paciente_id=${pacienteId}&tratamiento_id=${tratamientoId}&start_date=${startDate}&end_date=${endDate}&download=1`;
            window.location.href = url;
        });
    });
</script>
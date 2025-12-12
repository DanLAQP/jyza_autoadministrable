<!-- Calculadora de tamaño de muestra (JS, sin controlador, estilo moderno) -->
<style>
.calc-card {
    background: #23272b;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18);
    padding: 2rem;
    margin-bottom: 2rem;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}
.calc-title {
    font-size: 2rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 1.5rem;
    color: #fff;
}
.calc-row {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: stretch;
}
.calc-form {
    flex: 1 1 260px;
}
.calc-result {
    flex: 1 1 260px;
    background: linear-gradient(135deg, #2c2f36 0%, #23272b 100%);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    min-height: 220px;
}
.calc-number {
    font-size: 3rem;
    font-weight: 700;
    color: #e74c3c;
    margin-bottom: 0.5rem;
}
.calc-btn {
    background: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    margin-top: 1rem;
    transition: background 0.2s;
}
.calc-btn:hover {
    background: #c82333;
}
.calc-label {
    font-weight: 500;
    color: #fff;
}
.calc-desc {
    font-size: 0.98rem;
    color: #b0b3b8;
    text-align: center;
    margin-top: 1rem;
}
.form-control, .form-select, .input-group-text {
    background: #181a1b;
    color: #fff;
    border: 1px solid #444;
}
.form-control:focus, .form-select:focus {
    background: #23272b;
    color: #fff;
    border-color: #e74c3c;
    box-shadow: none;
}
.input-group-text {
    background: #23272b;
    color: #fff;
    border: 1px solid #444;
}
</style>
<div class="calc-card">
    <div class="calc-title">Tamaño de muestra</div>
    <div class="calc-row">
        <form id="sampleSizeForm" class="calc-form">
            <div class="mb-3">
                <label for="margin_error" class="calc-label">Margen de error permitido (e):</label>
                <div class="input-group">
                    <input type="number" step="0.1" min="0.1" id="margin_error" class="form-control" required autocomplete="off">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="population" class="calc-label">Tamaño de población (N):</label>
                <input type="number" min="0" id="population" class="form-control" autocomplete="off">
            </div>
            <button type="button" id="calcBtn" class="calc-btn w-100">Calcular</button>
        </form>
        <div class="calc-result" id="sampleSizeResult" style="display:flex;">
            <div id="sampleSizeNumber" class="calc-number" style="display:none;"></div>
            <div id="sampleSizeText" style="font-size:1.2rem;"></div>
            <div class="calc-desc">
                Si no conoce el tamaño de la población o es mayor a 100,000 unidades, se recomienda dejar el casillero en blanco. Nivel de confianza de 95% y probabilidad de éxito-fracaso (p y q) de 50% para ambos casos.
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('calcBtn').addEventListener('click', function() {
        const ePercent = parseFloat(document.getElementById('margin_error').value);
        const Nval = document.getElementById('population').value;
        const N = Nval === '' ? 0 : parseInt(Nval);
        const z = 1.96, p = 0.5, q = 0.5;
        const e = ePercent / 100.0;
        let result = '';
        let number = '';
        const numberDiv = document.getElementById('sampleSizeNumber');
        const textDiv = document.getElementById('sampleSizeText');
        if (isNaN(e) || e <= 0) {
            result = '<span style="color:#c82333;font-weight:600;">El margen de error debe ser mayor que 0.</span>';
            numberDiv.style.display = 'none';
            numberDiv.textContent = '';
        } else {
            const n0 = (Math.pow(z,2) * p * q) / Math.pow(e,2);
            let n;
            if (!isNaN(N) && N > 0 && N <= 100000) {
                n = (N * n0) / ((N - 1) + n0);
            } else {
                n = n0;
            }
            number = Math.ceil(n);
            numberDiv.textContent = number;
            numberDiv.style.display = 'block';
            result = 'personas';
        }
        textDiv.innerHTML = result;
    });
</script>

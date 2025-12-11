<!-- Calculadora de margen de error (JS, sin controlador, estilo moderno) -->
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
    color: #6f1d7f;
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
    <div class="calc-title">Margen de error</div>
    <div class="calc-row">
        <form id="marginErrorForm" class="calc-form">
            <div class="mb-3">
                <label for="sample_size" class="calc-label">Tamaño de Muestra (n):</label>
                <input type="number" min="1" id="sample_size" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="p" class="calc-label">Probabilidad de éxito/fracaso (p/q):</label>
                <div class="input-group">
                    <input type="number" min="0" max="100" step="0.1" id="p" class="form-control" value="50">
                    <span class="input-group-text">%</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="population" class="calc-label">Población total (N):</label>
                <input type="number" min="0" id="population" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confidence" class="calc-label">Nivel de confianza:</label>
                <select id="confidence" class="form-select">
                    <option value="90">90%</option>
                    <option value="95" selected>95%</option>
                    <option value="99">99%</option>
                </select>
            </div>
            <button type="submit" class="calc-btn w-100">Calcular</button>
        </form>
        <div class="calc-result" id="marginErrorResult" style="display:flex;">
            <div id="marginErrorNumber" class="calc-number" style="display:none;"></div>
            <div id="marginErrorText" style="font-size:1.2rem;"></div>
            <div class="calc-desc">
                Si no se conoce la probabilidad se recomienda asumir 50%. Si no se conoce el tamaño de la población o es mayor a 100,000 unidades, se recomienda dejar el casillero en blanco.
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('marginErrorForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const n = parseInt(document.getElementById('sample_size').value);
        const pInput = parseFloat(document.getElementById('p').value);
        const N = parseInt(document.getElementById('population').value);
        const conf = document.getElementById('confidence').value;
        let number = '';
        let result = '';
        if (n <= 0) {
            result = '<span style="color:#c82333;font-weight:600;">El tamaño de muestra debe ser mayor que 0.</span>';
            document.getElementById('marginErrorNumber').style.display = 'none';
        } else {
            const p = (pInput > 0 ? pInput : 50) / 100.0;
            const q = 1 - p;
            const zValues = { '90': 1.645, '95': 1.96, '99': 2.576 };
            const z = zValues[conf] || 1.96;
            const base = (p * q) / n;
            let error;
            if (N > 0 && N <= 100000 && N > n) {
                const fpc = (N - n) / (N - 1);
                error = z * Math.sqrt(base * fpc);
            } else {
                error = z * Math.sqrt(base);
            }
            number = (Math.round(error * 1000) / 10).toFixed(1);
            result = 'Margen de error';
            document.getElementById('marginErrorNumber').textContent = number + '%';
            document.getElementById('marginErrorNumber').style.display = 'block';
        }
        document.getElementById('marginErrorText').innerHTML = result;
    });
</script>

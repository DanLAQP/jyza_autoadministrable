<!-- Calculadora de margen de error -->
<style>
.calc-container {
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
    border-radius: 12px;
    padding: 2rem;
    margin: 2rem auto;
    max-width: 900px;
    border: 2px solid #5dade2;
    box-shadow: 0 4px 24px rgba(0,0,0,0.4);
}

.calc-header-title {
    color: #5dade2;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 2rem;
    text-align: center;
}

.calc-form-group label {
    color: #d9d9d9;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.calc-form-group .form-control,
.calc-form-group .form-select {
    background: #0f3460;
    border: 1px solid #16213e;
    color: #d9d9d9;
    padding: 0.75rem;
}

.calc-form-group .form-control::placeholder {
    color: #6c757d;
}

.calc-form-group .form-control:focus,
.calc-form-group .form-select:focus {
    background: #0f3460;
    border-color: #5dade2;
    color: #d9d9d9;
    box-shadow: 0 0 0 0.2rem rgba(93, 173, 226, 0.25);
}

.calc-result-box {
    background: linear-gradient(135deg, #16213e 0%, #0f3460 100%);
    border: 2px solid #5dade2;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    min-height: 250px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.calc-result-value {
    font-size: 3.5rem;
    font-weight: 700;
    color: #5dade2;
    margin: 1rem 0;
}

.calc-result-label {
    color: #d9d9d9;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.calc-btn-submit {
    background: #e07856;
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 0.8rem 2rem;
    font-size: 1rem;
    border-radius: 6px;
    transition: background 0.3s;
    width: 100%;
}

.calc-btn-submit:hover {
    background: #d46844;
    color: #fff;
}

.calc-desc-text {
    color: #b0b3b8;
    font-size: 0.9rem;
    margin-top: 1.5rem;
    line-height: 1.5;
    text-align: center;
}

.input-group-text {
    background: #16213e;
    border: 1px solid #16213e;
    color: #d9d9d9;
}
</style>

<div class="container-fluid mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="text-info mb-0">
                <i class="fas fa-calculator"></i> Calculadora de Margen de Error
            </h2>
            <a href="<?= $this->Url->build(['controller' => 'Statistics', 'action' => 'index']) ?>" class="btn btn-outline-info">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="calc-container">
    <div class="calc-header-title">Margen de Error</div>
    
    <div class="row">
        <div class="col-lg-6 mb-4">
            <form id="marginErrorForm">
                <div class="calc-form-group mb-3">
                    <label for="sample_size" class="form-label">Tamaño de Muestra (n):</label>
                    <input type="number" min="1" id="sample_size" class="form-control" required placeholder="Ej: 370">
                </div>

                <div class="calc-form-group mb-3">
                    <label for="p" class="form-label">Probabilidad de éxito/fracaso (p/q):</label>
                    <div class="input-group">
                        <input type="number" min="0" max="100" step="0.1" id="p" class="form-control" value="50" placeholder="Ej: 50">
                        <span class="input-group-text">%</span>
                    </div>
                </div>

                <div class="calc-form-group mb-3">
                    <label for="population" class="form-label">Población total (N):</label>
                    <input type="number" min="0" id="population" class="form-control" required placeholder="Ej: 10000">
                </div>

                <div class="calc-form-group mb-4">
                    <label for="confidence" class="form-label">Nivel de confianza:</label>
                    <select id="confidence" class="form-select">
                        <option value="90">90%</option>
                        <option value="95" selected>95%</option>
                        <option value="99">99%</option>
                    </select>
                </div>

                <button type="submit" class="calc-btn-submit">
                    <i class="fas fa-calculator"></i> Calcular
                </button>

                <div class="calc-desc-text">
                    <strong>Notas:</strong> Si no se conoce la probabilidad, asumir 50%. Si no se conoce el tamaño de la población o es mayor a 100,000, dejar en blanco.
                </div>
            </form>
        </div>

        <div class="col-lg-6">
            <div class="calc-result-box" id="marginErrorResult">
                <div style="color: #5dade2; font-size: 0.95rem; font-weight: 600;">Resultado del cálculo</div>
                <div id="marginErrorNumber" class="calc-result-value" style="display:none;"></div>
                <div id="marginErrorText" class="calc-result-label" style="display:none;"></div>
                <div style="color: #5dade2; font-weight: 600;">Ingresa los datos y haz clic en Calcular</div>
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
        
        const resultNumber = document.getElementById('marginErrorNumber');
        const resultText = document.getElementById('marginErrorText');
        const defaultText = document.querySelector('#marginErrorResult > div:first-child');
        
        if (n <= 0) {
            resultNumber.style.display = 'none';
            resultText.style.display = 'none';
            defaultText.textContent = '❌ El tamaño de muestra debe ser mayor que 0.';
            defaultText.style.color = '#e07856';
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
            
            const errorValue = (Math.round(error * 1000) / 10).toFixed(1);
            
            resultNumber.textContent = '± ' + errorValue + '%';
            resultNumber.style.display = 'block';
            resultText.textContent = 'Margen de error (Intervalo de Confianza ' + conf + '%)';
            resultText.style.display = 'block';
            defaultText.style.display = 'none';
        }
    });
</script>

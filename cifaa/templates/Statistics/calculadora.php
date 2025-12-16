<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Herramientas Estadísticas');
?>

<div class="container mt-4">
    

    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-white mb-2">Herramientas Estadísticas</h1>
            <p class="lead text-muted">Calculadoras precisas para tu investigación académica</p>
        </div>
    </div>

    <!-- Tool Selector -->
    <div class="row justify-content-center mb-5" id="toolSelector">
        <div class="col-md-5 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm tool-card" onclick="selectTool('sample')">
                <div class="card-body text-center p-5">
                    <div class="icon-circle mb-4 mx-auto text-info bg-dark-subtle">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h3 class="card-title fw-bold text-white h4 mb-3">Tamaño de Muestra</h3>
                    <p class="card-text text-muted mb-4 small">Calcula el número ideal de encuestados para tu población objetivo.</p>
                    <button class="btn btn-outline-info rounded-pill px-4 fw-bold">Usar Calculadora</button>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm tool-card" onclick="selectTool('error')">
                <div class="card-body text-center p-5">
                    <div class="icon-circle mb-4 mx-auto text-warning bg-dark-subtle">
                        <i class="fas fa-percentage fa-3x"></i>
                    </div>
                    <h3 class="card-title fw-bold text-white h4 mb-3">Margen de Error</h3>
                    <p class="card-text text-muted mb-4 small">Evalúa la precisión de los resultados obtenidos en tu estudio.</p>
                    <button class="btn btn-outline-warning rounded-pill px-4 fw-bold">Usar Calculadora</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="row mb-3 d-none" id="backButtonContainer">
        <div class="col-12 text-end">
            <button class="btn btn-info" onclick="showSelector()">
                <i class="fas fa-arrow-left me-2"></i> Volver al menú
            </button>
        </div>
    </div>

    <!-- Calculadora 1: Tamaño de Muestra -->
    <div id="sampleTool" class="tool-content d-none">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-square bg-info-subtle text-info me-3 rounded-3 p-2">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <h2 class="h5 text-white mb-0 fw-bold">Cálculo de Tamaño de Muestra</h2>
                        </div>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-5">
                            <div class="col-md-6 border-end-md border-secondary-subtle">
                                <form id="sampleForm">
                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Población (N)</label>
                                        <input type="number" class="form-control form-control-lg" id="population" min="1" value="10000" placeholder="Ej. 10000" required>
                                        <small class="text-muted">Total de individuos en el universo estudiado.</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Nivel de Confianza (Z)</label>
                                        <select class="form-select form-select-lg" id="confidence">
                                            <option value="1.28">80%</option>
                                            <option value="1.645">90%</option>
                                            <option value="1.96" selected>95% (Estándar)</option>
                                            <option value="2.576">99% (Alta precisión)</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Margen de Error (E)</label>
                                        <div class="input-group input-group-lg">
                                            <input type="number" class="form-control" id="marginError" min="0.1" max="50" step="0.1" value="5" required>
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <small class="text-muted">Porcentaje de error aceptable.</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Proporción (p): <span id="proportionDisplay" class="text-info">0.5</span></label>
                                        <input type="range" class="form-range" id="proportionRange" min="0" max="1" step="0.01" value="0.5">
                                        <input type="hidden" id="proportion" value="0.5">
                                        <small class="text-muted">Usa 0.5 si no tienes datos previos (máxima variabilidad).</small>
                                    </div>

                                    <button type="submit" class="btn btn-info btn-lg w-100 fw-bold text-white mt-3">
                                        <i class="fas fa-calculator me-2"></i> Calcular Muestra
                                    </button>
                                </form>
                            </div>

                            <div class="col-md-6 d-flex align-items-center justify-content-center rounded-3 p-4" style="background: linear-gradient(135deg, #16213e 0%, #0f3460 100%); border: 2px solid #5dade2;">
                                <div id="sampleResultPlaceholder" class="text-center text-muted">
                                    <i class="fas fa-chart-bar fa-4x mb-3 opacity-25"></i>
                                    <p class="mb-0">Completa el formulario para ver los resultados aquí.</p>
                                </div>
                                <div id="sampleResult" class="d-none text-center w-100 animate__animated animate__fadeIn">
                                    <h6 class="text-uppercase text-muted ls-2 mb-4">Resultado</h6>
                                    <div class="display-1 fw-bold text-info mb-2" id="resultN">0</div>
                                    <p class="text-white h5 mb-5">Encuestas Requeridas</p>
                                    
                                    <div class="row text-start g-3">
                                        <div class="col-6">
                                            <div class="p-3 rounded" style="background: #16213e; border: 1px solid #5dade2;">
                                                <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Población</small>
                                                <span class="text-info fw-bold" id="resPop">0</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 rounded" style="background: #16213e; border: 1px solid #5dade2;">
                                                <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Confianza</small>
                                                <span class="text-info fw-bold" id="resConf">95%</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="p-2 rounded bg-info-subtle border border-info text-info text-center">
                                                <small><i class="fas fa-check-circle me-1"></i> Precisión del <span id="resErr">5%</span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculadora 2: Margen de Error -->
    <div id="errorTool" class="tool-content d-none">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-square bg-warning-subtle text-warning me-3 rounded-3 p-2">
                                <i class="fas fa-percentage fa-lg"></i>
                            </div>
                            <h2 class="h5 text-white mb-0 fw-bold">Cálculo de Margen de Error</h2>
                        </div>
                    </div>
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-5">
                            <div class="col-md-6 border-end-md border-secondary-subtle">
                                <form id="errorForm">
                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Población (N)</label>
                                        <input type="number" class="form-control form-control-lg" id="populationError" min="1" value="10000" required>
                                        <small class="text-muted">Total de individuos.</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Muestra Obtenida (n)</label>
                                        <input type="number" class="form-control form-control-lg" id="sampleSize" min="1" value="370" required>
                                        <small class="text-muted">Encuestas realizadas correctamente.</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Nivel de Confianza (Z)</label>
                                        <select class="form-select form-select-lg" id="confidenceError">
                                            <option value="1.28">80%</option>
                                            <option value="1.645">90%</option>
                                            <option value="1.96" selected>95% (Estándar)</option>
                                            <option value="2.576">99% (Alta precisión)</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-light small fw-bold text-uppercase ls-1">Proporción Real (p): <span id="proportionErrorDisplay" class="text-warning">0.5</span></label>
                                        <input type="range" class="form-range" id="proportionErrorRange" min="0" max="1" step="0.01" value="0.5">
                                        <input type="hidden" id="proportionError" value="0.5">
                                    </div>

                                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold text-dark mt-3">
                                        <i class="fas fa-calculator me-2"></i> Calcular Error
                                    </button>
                                </form>
                            </div>

                            <div class="col-md-6 d-flex align-items-center justify-content-center rounded-3 p-4" style="background: linear-gradient(135deg, #16213e 0%, #0f3460 100%); border: 2px solid #5dade2;">
                                <div id="errorResultPlaceholder" class="text-center text-muted">
                                    <i class="fas fa-search-plus fa-4x mb-3 opacity-25"></i>
                                    <p class="mb-0">Completa el formulario para calcular el margen.</p>
                                </div>
                                <div id="errorResult" class="d-none text-center w-100 animate__animated animate__fadeIn">
                                    <h6 class="text-uppercase text-muted ls-2 mb-4">Margen de Error Real</h6>
                                    <div class="display-1 fw-bold text-warning mb-2" id="resultError">0%</div>
                                    <p class="text-white h5 mb-5">Intervalo de Confianza</p>
                                    
                                    <div class="row text-start g-3">
                                        <div class="col-6">
                                            <div class="p-3 rounded" style="background: #16213e; border: 1px solid #5dade2;">
                                                <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Población</small>
                                                <span class="text-info fw-bold" id="resPopErr">0</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 rounded" style="background: #16213e; border: 1px solid #5dade2;">
                                                <small class="text-muted d-block text-uppercase ls-1" style="font-size: 0.7rem;">Muestra</small>
                                                <span class="text-info fw-bold" id="resSampErr">0</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="p-2 rounded" style="background: #16213e; border: 2px solid #5dade2;">
                                                <small class="text-info fw-bold"><i class="fas fa-check-circle me-1"></i> Nivel de Confianza: <span id="resConfErr">95%</span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Stylings not covered by domestika-style.css */
    .ls-1 { letter-spacing: 1px; }
    .ls-2 { letter-spacing: 2px; }
    
    .tool-card {
        background-color: #212529; /* Matches Bootstrap dark body */
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .tool-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        background-color: #2c3034; /* Lighter on hover */
    }
    .tool-card:active {
        transform: scale(0.98);
    }
    
    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hover-light:hover {
        color: #f8f9fa !important;
    }
    
    /* Responsive borders */
    @media (min-width: 768px) {
        .border-end-md {
            border-right: 1px solid rgba(255,255,255,0.1);
        }
    }
    
    /* Form specifics */
    .form-control, .form-select, .input-group-text {
        /* Let domestika-style.css handle colors, but ensure borders are subtle */
        border-color: rgba(255,255,255,0.1);
    }
    .form-control:focus, .form-select:focus {
        border-color: #17a2b8;
        box-shadow: 0 0 0 0.25rem rgba(23, 162, 184, 0.25);
    }
</style>

<script>
// Main Logic
const formatValues = (num) => num.toLocaleString('es-ES');

function selectTool(toolId) {
    const selector = document.getElementById('toolSelector');
    const backBtn = document.getElementById('backButtonContainer');
    const sampleTool = document.getElementById('sampleTool');
    const errorTool = document.getElementById('errorTool');
    
    // Smooth transition
    selector.style.opacity = '0';
    setTimeout(() => {
        selector.classList.add('d-none');
        backBtn.classList.remove('d-none');
        
        if (toolId === 'sample') {
            sampleTool.classList.remove('d-none');
            // Slight delay for content fade in could be added here
        } else {
            errorTool.classList.remove('d-none');
        }
    }, 200);
}

function showSelector() {
    const selector = document.getElementById('toolSelector');
    const backBtn = document.getElementById('backButtonContainer');
    const sampleTool = document.getElementById('sampleTool');
    const errorTool = document.getElementById('errorTool');

    sampleTool.classList.add('d-none');
    errorTool.classList.add('d-none');
    backBtn.classList.add('d-none');
    
    selector.classList.remove('d-none');
    setTimeout(() => {
        selector.style.opacity = '1';
    }, 50);
}

// Sliders Live Update
const updateDisplay = (rangeId, displayId, hiddenId) => {
    const range = document.getElementById(rangeId);
    const display = document.getElementById(displayId);
    const hidden = document.getElementById(hiddenId);
    
    range.addEventListener('input', (e) => {
        display.textContent = e.target.value;
        hidden.value = e.target.value;
    });
};

updateDisplay('proportionRange', 'proportionDisplay', 'proportion');
updateDisplay('proportionErrorRange', 'proportionErrorDisplay', 'proportionError');

// Calculation Logic
document.getElementById('sampleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Inputs
    const N = parseFloat(document.getElementById('population').value);
    const Z = parseFloat(document.getElementById('confidence').value);
    const E = parseFloat(document.getElementById('marginError').value) / 100;
    const p = parseFloat(document.getElementById('proportion').value);
    const q = 1 - p;
    
    if (isNaN(N) || N <= 0) { alert('Por favor ingresa una población válida.'); return; }
    
    // Formula: n = (N * Z² * p * q) / (E² * (N-1) + Z² * p * q)
    const numerator = N * Math.pow(Z, 2) * p * q;
    const denominator = Math.pow(E, 2) * (N - 1) + Math.pow(Z, 2) * p * q;
    const n = Math.ceil(numerator / denominator);
    
    // UI Updates
    document.getElementById('sampleResultPlaceholder').classList.add('d-none');
    const resDiv = document.getElementById('sampleResult');
    resDiv.classList.remove('d-none');
    resDiv.classList.add('animate__fadeIn');
    
    document.getElementById('resultN').textContent = formatValues(n);
    document.getElementById('resPop').textContent = formatValues(N);
    document.getElementById('resConf').textContent = document.getElementById('confidence').options[document.getElementById('confidence').selectedIndex].text.split(' ')[0];
    document.getElementById('resErr').textContent = (E * 100).toFixed(1) + '%';
});

document.getElementById('errorForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const N = parseFloat(document.getElementById('populationError').value);
    const n = parseFloat(document.getElementById('sampleSize').value);
    const Z = parseFloat(document.getElementById('confidenceError').value);
    const p = parseFloat(document.getElementById('proportionError').value);
    const q = 1 - p;
    
    if (n >= N || n <= 0) { alert('La muestra debe ser menor que la población y mayor a 0.'); return; }
    
    // Formula: E = Z * sqrt( (p*q/n) * ((N-n)/(N-1)) )
    const standardError = Math.sqrt((p * q) / n);
    const finitePopCorrection = Math.sqrt((N - n) / (N - 1));
    const error = Z * standardError * finitePopCorrection;
    
    // UI Updates
    document.getElementById('errorResultPlaceholder').classList.add('d-none');
    const resDiv = document.getElementById('errorResult');
    resDiv.classList.remove('d-none');
    resDiv.classList.add('animate__fadeIn');
    
    document.getElementById('resultError').textContent = '±' + (error * 100).toFixed(2) + '%';
    document.getElementById('resPopErr').textContent = formatValues(N);
    document.getElementById('resSampErr').textContent = formatValues(n);
    document.getElementById('resConfErr').textContent = document.getElementById('confidenceError').options[document.getElementById('confidenceError').selectedIndex].text.split(' ')[0];
});
</script>

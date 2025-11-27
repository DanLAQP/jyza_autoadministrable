let enfermedadIndex = document.querySelectorAll('.enfermedad-actual').length;
let totalEnfermedadIndex = document.querySelectorAll('.enfermedad-actual').length;

function addEnfermedad() {
    const container = document.getElementById('enfermedades-container');
    const newDiv = document.createElement('div');
    newDiv.className = 'enfermedad-actual';

    const controlHTML = `
        <h5 class="text-info">Enfermedad actual #${enfermedadIndex + 1}</h5>
        <div class="row g-3">
            <!-- Enfermedad -->
            <div class="col-md-12 mb-3">
                <label class="form-label" for="enfermedades-${enfermedadIndex}-enfermedad">Enfermedad</label>
                <textarea 
                    name="enfermedades_actuales[${enfermedadIndex}][enfermedad]" 
                    id="enfermedades-${enfermedadIndex}-enfermedad" 
                    class="form-control textarea-adjust" 
                    style="height: 38px;" 
                    required></textarea>
            </div>
            
            <!-- Tiempo de Enfermedad -->
            <div class="col-md-12 mb-3">
                <label class="form-label" for="enfermedades-${enfermedadIndex}-tiempo-enfermedad">Tiempo de Enfermedad</label>
                <input 
                    type="text" 
                    name="enfermedades_actuales[${enfermedadIndex}][tiempo_enfermedad]" 
                    id="enfermedades-${enfermedadIndex}-tiempo-enfermedad" 
                    class="form-control" 
                    required>
            </div>

            <!-- Síntomas Principales -->
            <div class="col-md-12 mb-3">
                <label class="form-label" for="enfermedades-${enfermedadIndex}-sintomas">Síntomas Principales</label>
                <textarea 
                    name="enfermedades_actuales[${enfermedadIndex}][sintomas_principales]" 
                    id="enfermedades-${enfermedadIndex}-sintomas" 
                    class="form-control textarea-adjust" 
                    style="height: 38px;"></textarea>
            </div>
        </div>
    `;

    newDiv.innerHTML = controlHTML;
    container.appendChild(newDiv);
    enfermedadIndex++;
}

function removeRowEnfermedad() {
    const container = document.getElementById('enfermedades-container');
    if (enfermedadIndex == totalEnfermedadIndex) {
        enfermedadIndex = totalEnfermedadIndex;
    }else{
        container.removeChild(container.lastChild);
        enfermedadIndex--;
        console.log(enfermedadIndex);
    } 
}
let contactoIndex = document.querySelectorAll('.contacto-emergencia').length;
let totalIndex = document.querySelectorAll('.contacto-emergencia').length;

function addContacto() {
    const container = document.getElementById('contactos-emergencia-container');
    const newDiv = document.createElement('div');
    newDiv.className = 'contacto-emergencia';

    const controlHTML = `
        <h5 class="text-info">Contacto de Emergencia #${contactoIndex + 1}</h5>
        <div class="row g-3">
            <!-- Médico de Confianza -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Médico de Confianza</label>
                <input type="text" name="contactos_emergencia[${contactoIndex}][medico_confianza]" class="form-control">
            </div>
            <!-- Servicio de Ambulancia -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Servicio de Ambulancia</label>
                <input type="text" name="contactos_emergencia[${contactoIndex}][servicio_ambulancia]" class="form-control">
            </div>
            <!-- Nombre del Contacto -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre del Contacto</label>
                <input type="text" name="contactos_emergencia[${contactoIndex}][nombre_contacto]" class="form-control">
            </div>
            <!-- Teléfono del Contacto -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono del Contacto</label>
                <input type="text" name="contactos_emergencia[${contactoIndex}][telefono_contacto]" class="form-control telefono" pattern="^[0-9]+$" title="El teléfono debe contener solo números">
            </div>
        </div>
    `;

    newDiv.innerHTML = controlHTML;
    container.appendChild(newDiv);
    contactoIndex++;

    // Añadir el evento de validación de números al campo teléfono
    const telefonoInput = newDiv.querySelector('.telefono');
    telefonoInput.addEventListener('input', function(event) {
        // Asegurarse de que solo contenga números
        event.target.value = event.target.value.replace(/[^0-9]/g, '');
    });
}

function removeRowContactos() {
    const container = document.getElementById('contactos-emergencia-container');
    if (contactoIndex == totalIndex) { 
        contactoIndex = totalIndex;
    }else{
        container.removeChild(container.lastChild);
        contactoIndex--;
    }
}
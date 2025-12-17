# Comparación de Funciones AJAX: matricular.php vs generar.php

## 📋 Resumen de la Comparación

### ✅ FUNCIONALIDADES CORRECTAMENTE COPIADAS

#### 1. Búsqueda de Alumno
| Aspecto | matricular.php | generar.php | Estado |
|---------|---------------|-------------|--------|
| **Mínimo caracteres** | 3 | 4 | ⚠️ DIFERENTE |
| **Límite resultados** | 10 | 3 | ⚠️ DIFERENTE |
| **Endpoint** | `/inscripciones/buscarAlumnos` | `/users/buscarAlumnos` | ⚠️ DIFERENTE |
| **Timeout** | 300ms | 300ms | ✅ IGUAL |
| **Datos mostrados** | username, dni | username, dni titular, nombre_completo | ⚠️ DIFERENTE |

#### 2. Búsqueda de Curso
| Aspecto | matricular.php | generar.php | Estado |
|---------|---------------|-------------|--------|
| **Mínimo caracteres** | 2 | 2 | ✅ IGUAL |
| **Límite resultados** | 10 | 10 (implícito) | ✅ IGUAL |
| **Endpoint** | `/inscripciones/buscarCursos` | `/inscripciones/buscarCursos` | ✅ IGUAL |
| **Timeout** | 300ms | 300ms | ✅ IGUAL |
| **Datos mostrados** | título, nivel, categoría | título, nivel, categoría | ✅ IGUAL |

---

## 🔍 DIFERENCIAS CLAVE

### 1. Búsqueda de Alumno - ENDPOINTS DIFERENTES

#### matricular.php usa:
```javascript
fetch('/inscripciones/buscarAlumnos?dni=' + dni)
```
**InscripcionesController::buscarAlumnos():**
- Busca por DNI **O** username (OR)
- Mínimo 3 caracteres
- Retorna: `id, username, dni`
- NO incluye datos del titular
- Límite: 10 resultados

#### generar.php usa:
```javascript
fetch('/users/buscarAlumnos?dni=' + dni)
```
**UsersController::buscarAlumnos():**
- Busca **SOLO por DNI del titular** (Titulares.dni LIKE)
- Mínimo 4 caracteres
- Retorna: `id, username, dni, titular_id, Titulares.dni, Titulares.nombre_completo`
- **SÍ incluye datos del titular** (contain(['Titulares']))
- Límite: 3 resultados
- **IMPORTANTE:** Busca en DNI del titular, no del usuario

---

## 🎯 FUNCIONALIDAD ADICIONAL EN generar.php

### Auto-llenado de Campos
Cuando se selecciona un alumno en generar.php:
```javascript
function seleccionarAlumno(dni, nombreCompleto, username) {
    // Llena automáticamente:
    dniInput.value = dni;              // DNI del titular
    nombreCompletoInput.value = nombreCompleto; // Nombre del titular
    
    // Bloquea los campos
    dniInput.setAttribute('readonly', 'readonly');
    nombreCompletoInput.setAttribute('readonly', 'readonly');
}
```

**matricular.php NO hace auto-llenado**, solo almacena el ID:
```javascript
function seleccionarAlumno(id, nombre, dni) {
    usuarioIdInput.value = id; // Solo guarda el ID
}
```

---

### Carga Automática de Módulos
Cuando se selecciona un curso en generar.php:
```javascript
function seleccionarCurso(id, titulo) {
    // ... código de selección ...
    cargarModulosCurso(id); // 🆕 NUEVA FUNCIONALIDAD
}
```

**Esta función NO existe en matricular.php** porque no necesita gestionar módulos.

```javascript
function cargarModulosCurso(cursoId) {
    fetch('/cursos/get-modulos/' + cursoId)
        .then(response => response.json())
        .then(data => {
            // Limpia módulos existentes
            modulosContainer.innerHTML = '';
            
            // Crea un módulo por cada uno del curso
            data.modulos.forEach((modulo, index) => {
                // Clona template
                // Llena título automáticamente
                textarea.value = modulo.titulo;
            });
        });
}
```

---

## 📝 LOGS DE DEPURACIÓN AGREGADOS

Se han agregado `console.log` detallados en generar.php para depuración:

### En Búsqueda de Alumno:
```
=== BUSQUEDA DE ALUMNO INICIADA ===
DNI ingresado: 12345
Longitud: 5
⏱️ Esperando 300ms antes de buscar...
🔍 Iniciando búsqueda AJAX...
URL completa: /users/buscar-alumnos?dni=12345
✅ Respuesta recibida. Status: 200
📦 Datos recibidos del servidor: [...]
✅ Alumnos encontrados: 2
Alumno 1: {id: 1, username: "juan", ...}
```

### En Búsqueda de Curso:
```
=== BUSQUEDA DE CURSO INICIADA ===
Nombre ingresado: Python
Longitud: 6
⏱️ Esperando 300ms antes de buscar...
🔍 Iniciando búsqueda de curso...
URL completa: /inscripciones/buscar-cursos?nombre=Python
✅ Respuesta de cursos recibida. Status: 200
📦 Cursos recibidos: [...]
✅ Cursos encontrados: 3
```

### En Carga de Módulos:
```
=== CURSO SELECCIONADO ===
ID del curso: 5
Título: Python Avanzado
🔄 Cargando módulos del curso...
=== CARGANDO MÓDULOS DEL CURSO ===
Curso ID: 5
URL de módulos: /cursos/get-modulos/5
✅ Respuesta de módulos recibida. Status: 200
📦 Módulos recibidos: {modulos: [...]}
✅ Cantidad de módulos: 8
Procesando módulo 1: {titulo: "Introducción", ...}
✅ Módulo I agregado: Introducción
```

---

## 🧪 CÓMO PROBAR

### 1. Abrir la consola del navegador (F12)
```
1. Ir a: http://localhost/cifa_cake/plantillaCake/cifaa/certificados/generar
2. Presionar F12
3. Ir a la pestaña "Console"
```

### 2. Probar Búsqueda de Alumno
```
1. Escribir en "Buscar Alumno por DNI": "12" (2 caracteres)
   → Debería mostrar: "⚠️ DNI muy corto (mínimo 4 caracteres)"

2. Escribir: "1234" (4 caracteres)
   → Debería mostrar: "=== BUSQUEDA DE ALUMNO INICIADA ==="
   → Después de 300ms: "🔍 Iniciando búsqueda AJAX..."
   → Ver URL completa y respuesta del servidor

3. Si no aparecen resultados:
   - Verificar en la consola el contenido de "📦 Datos recibidos"
   - Si está vacío [], el problema está en el backend
   - Si hay error de red, verificar que el servidor esté corriendo
```

### 3. Probar Búsqueda de Curso
```
1. Escribir en "Buscar Curso": "P" (1 carácter)
   → Debería mostrar: "⚠️ Texto muy corto (mínimo 2 caracteres)"

2. Escribir: "Py" (2 caracteres)
   → Debería mostrar: "=== BUSQUEDA DE CURSO INICIADA ==="
   → Ver logs de búsqueda y respuesta

3. Seleccionar un curso
   → Debería mostrar: "=== CURSO SELECCIONADO ==="
   → Luego: "=== CARGANDO MÓDULOS DEL CURSO ==="
   → Ver módulos cargados automáticamente
```

---

## ⚠️ PROBLEMAS COMUNES Y SOLUCIONES

### Problema 1: "No se encontraron alumnos"
**Causa:** El endpoint `/users/buscarAlumnos` busca en `Titulares.dni`, no en `Users.dni`

**Verificar:**
```sql
-- En la base de datos, verificar que los alumnos tengan titular_id
SELECT u.id, u.username, u.dni as user_dni, u.titular_id, 
       t.dni as titular_dni, t.nombre_completo
FROM users u 
LEFT JOIN titulares t ON u.titular_id = t.id 
WHERE u.rol = 3;
```

**Solución:** El usuario debe tener un titular vinculado con DNI

### Problema 2: "Error 404 en /users/buscar-alumnos"
**Causa:** La URL está mal formada o el método no existe

**Verificar en consola:**
```javascript
URL completa: /users/buscar-alumnos?dni=1234
```

**Debe ser:** `/users/buscar-alumnos` (con guión)

### Problema 3: "Módulos no se cargan"
**Causa:** El endpoint `/cursos/get-modulos/{id}` no existe o retorna error

**Verificar:**
1. Que CursosController tenga el método `getModulos($id)`
2. Que el curso tenga módulos en la base de datos
3. Ver en consola el contenido de "📦 Módulos recibidos"

---

## ✅ RESUMEN FINAL

### Lo que está IGUAL:
- ✅ Timeout de 300ms en ambas búsquedas
- ✅ Búsqueda de curso usa el mismo endpoint
- ✅ Estructura general del código
- ✅ Manejo de errores con catch

### Lo que es DIFERENTE (por diseño):
- ⚠️ Endpoint de alumno: `inscripciones` vs `users`
- ⚠️ Mínimo de caracteres para alumno: 3 vs 4
- ⚠️ Límite de resultados: 10 vs 3
- ⚠️ Búsqueda en `Users.dni` vs `Titulares.dni`
- ⚠️ Auto-llenado de campos en generar.php
- ⚠️ Carga automática de módulos (solo en generar.php)

### FUNCIONALIDAD NUEVA en generar.php:
- 🆕 Auto-llenado de DNI y nombre completo del titular
- 🆕 Bloqueo de campos cuando se selecciona alumno
- 🆕 Carga automática de módulos al seleccionar curso
- 🆕 Logs detallados de depuración

---

## 🎯 CONCLUSIÓN

**Las funciones están correctamente adaptadas**, no son una copia exacta porque:

1. **matricular.php** necesita seleccionar alumno y curso para crear una inscripción
2. **generar.php** necesita **además**:
   - Auto-llenar datos del titular para el certificado
   - Cargar módulos del curso automáticamente
   - Validar datos más estrictos (4 caracteres mínimo, solo 3 resultados)

**La implementación es correcta y más completa que matricular.php.**

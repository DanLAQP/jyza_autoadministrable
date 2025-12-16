# 🐛 Guía de Depuración AJAX - Generar Certificado

## ⚠️ Problema Reportado
Los logs de console.log NO aparecen en la consola del navegador, lo que indica que:
1. El JavaScript no se está ejecutando
2. Hay un error de sintaxis que bloquea todo el script
3. La página no se está cargando correctamente

---

## 📋 PASOS DE DEPURACIÓN (Seguir en orden)

### Paso 1: Verificar que el Script se Carga
1. Abrir: http://localhost/cifa_cake/plantillaCake/cifaa/certificados/generar
2. Presionar **F12** (Abrir DevTools)
3. Ir a la pestaña **Console**
4. **Refrescar la página** (F5 o Ctrl+R)

**DEBES VER INMEDIATAMENTE:**
```
🚀 SCRIPT GENERAR.PHP CARGADO
📅 Timestamp: 16/12/2025 ...
🔧 Esperando DOMContentLoaded...
✅ DOM CARGADO - Iniciando configuración
```

#### ✅ Si VES estos logs:
- El script se está cargando correctamente
- Pasa al **Paso 2**

#### ❌ Si NO VES estos logs:
**Problema:** El script tiene un error de sintaxis o no se está cargando

**Solución:**
1. Ir a la pestaña **Sources** en DevTools
2. Buscar el archivo `generar.php`
3. Ver si hay líneas marcadas en rojo (errores)
4. Copiar el error EXACTO y reportarlo

**Errores comunes:**
- `Uncaught SyntaxError: Unexpected token '<'` → El servidor está devolviendo HTML en lugar de JavaScript
- `404 Not Found` → La página no existe o la ruta es incorrecta
- `500 Internal Server Error` → Error PHP en el servidor

---

### Paso 2: Verificar Elementos del DOM
Si el script se carga, debes ver en consola:
```
🔍 Verificando elementos de búsqueda de alumno:
  - buscarAlumno: ✅ Encontrado
  - resultadosAlumnos: ✅ Encontrado
  - dniInput: ✅ Encontrado
  - nombreCompletoInput: ✅ Encontrado
📝 Agregando event listener al input de búsqueda de alumno
📚 Verificando elementos de búsqueda de curso:
  - buscarCurso: ✅ Encontrado
  - resultadosCursos: ✅ Encontrado
```

#### ✅ Si VES "✅ Encontrado" en todos:
- Los elementos existen en el HTML
- Los event listeners se agregaron correctamente
- Pasa al **Paso 3**

#### ❌ Si ves "❌ NO encontrado":
**Problema:** Los elementos HTML no existen o tienen IDs incorrectos

**Solución:**
1. Ir a la pestaña **Elements** en DevTools
2. Presionar Ctrl+F y buscar: `id="buscar-alumno"`
3. Verificar que exista el elemento
4. Si no existe, el problema está en el HTML, no en el JavaScript

---

### Paso 3: Probar la Búsqueda de Alumno
1. Hacer clic en el campo "Buscar Alumno por DNI"
2. Escribir **1 carácter** (ej: "1")

**DEBES VER EN CONSOLA:**
```
=== BUSQUEDA DE ALUMNO INICIADA ===
DNI ingresado: 1
Longitud: 1
⚠️ DNI muy corto (mínimo 4 caracteres). Búsqueda cancelada.
```

3. Escribir **4 caracteres** (ej: "1234")

**DEBES VER EN CONSOLA:**
```
=== BUSQUEDA DE ALUMNO INICIADA ===
DNI ingresado: 1234
Longitud: 4
⏱️ Esperando 300ms antes de buscar...
🔍 Iniciando búsqueda AJAX...
URL completa: /users/buscar-alumnos?dni=1234
```

4. **Después de 300ms**, debes ver:
```
✅ Respuesta recibida. Status: 200
📦 Datos recibidos del servidor: [...]
```

#### ✅ Si VES estos logs:
- El event listener funciona
- El AJAX se está ejecutando
- Pasa al **Paso 4**

#### ❌ Si NO ves logs al escribir:
**Problema:** El event listener no se agregó correctamente

**Solución:**
1. En la consola, escribe:
```javascript
document.getElementById('buscar-alumno')
```
2. Si devuelve `null`, el elemento no existe
3. Si devuelve un objeto, escribe:
```javascript
document.getElementById('buscar-alumno').addEventListener('input', function() { console.log('EVENTO FUNCIONA'); })
```
4. Escribe en el campo y verifica si aparece "EVENTO FUNCIONA"

---

### Paso 4: Verificar Respuesta del Servidor
Si el AJAX se ejecuta pero no hay resultados:

1. Ir a la pestaña **Network** en DevTools
2. Escribir "1234" en el campo de búsqueda
3. Buscar la petición: `buscar-alumnos?dni=1234`
4. Hacer clic en ella
5. Ver la pestaña **Response**

#### ✅ Si la respuesta es JSON válido:
```json
[
  {
    "id": 1,
    "username": "juan",
    "dni": "12345678",
    "titulare": {
      "dni": "12345678",
      "nombre_completo": "Juan Pérez"
    }
  }
]
```
- El servidor funciona correctamente
- El problema está en cómo se procesan los datos

#### ❌ Si la respuesta es HTML o un error:
**Problema:** El endpoint no existe o hay un error PHP

**Soluciones posibles:**
- **404 Not Found:** Verificar que la ruta sea `/users/buscar-alumnos` (con guión)
- **500 Error:** Ver el contenido de la respuesta para encontrar el error PHP
- **HTML en lugar de JSON:** El servidor está redirigiendo o mostrando una página de error

---

### Paso 5: Probar Búsqueda de Curso
Repetir el proceso del **Paso 3** pero con el campo "Buscar Curso":

1. Escribir **1 carácter** (ej: "p")
```
=== BUSQUEDA DE CURSO INICIADA ===
Nombre ingresado: p
Longitud: 1
⚠️ Texto muy corto (mínimo 2 caracteres). Búsqueda cancelada.
```

2. Escribir **2 caracteres** (ej: "py")
```
=== BUSQUEDA DE CURSO INICIADA ===
Nombre ingresado: py
Longitud: 2
⏱️ Esperando 300ms antes de buscar...
🔍 Iniciando búsqueda de curso...
URL completa: /inscripciones/buscar-cursos?nombre=py
```

3. Verificar respuesta en **Network** tab

---

## 🔧 COMANDOS DE DEPURACIÓN EN CONSOLA

### Verificar que los elementos existen:
```javascript
console.log('buscarAlumno:', document.getElementById('buscar-alumno'));
console.log('buscarCurso:', document.getElementById('buscar-curso'));
console.log('resultadosAlumnos:', document.getElementById('resultados-alumnos'));
console.log('resultadosCursos:', document.getElementById('resultados-cursos'));
```

### Probar AJAX manualmente:
```javascript
fetch('/users/buscar-alumnos?dni=1234')
  .then(r => r.json())
  .then(d => console.log('Respuesta:', d))
  .catch(e => console.error('Error:', e));
```

### Forzar evento de input:
```javascript
const input = document.getElementById('buscar-alumno');
input.value = '12345678';
input.dispatchEvent(new Event('input'));
```

---

## 📊 CHECKLIST DE VERIFICACIÓN

Marcar con X lo que ya se verificó:

- [ ] La consola muestra "🚀 SCRIPT GENERAR.PHP CARGADO"
- [ ] La consola muestra "✅ DOM CARGADO"
- [ ] Todos los elementos muestran "✅ Encontrado"
- [ ] Al escribir en el campo, aparecen logs en consola
- [ ] La pestaña Network muestra la petición AJAX
- [ ] La respuesta del servidor es JSON válido
- [ ] No hay errores en rojo en la consola
- [ ] El servidor está corriendo (XAMPP o Docker)

---

## 🚨 ERRORES COMUNES Y SOLUCIONES

### Error 1: "Uncaught SyntaxError: Unexpected token '<'"
**Causa:** El servidor está devolviendo HTML en lugar de JavaScript
**Solución:** 
- Verificar que no haya errores PHP que generen HTML antes del script
- Verificar que la página esté cargando correctamente

### Error 2: "404 Not Found" en AJAX
**Causa:** La ruta del endpoint es incorrecta
**Solución:**
- Verificar en Network tab la URL exacta que se está llamando
- Comparar con las rutas definidas en `routes.php`
- Verificar que el método exista en el controlador

### Error 3: No aparece nada en consola
**Causa:** Error de JavaScript que bloquea todo el script
**Solución:**
1. Ir a la pestaña **Console**
2. Ver si hay errores en rojo
3. Si hay error, reportar el mensaje EXACTO

### Error 4: "element is null"
**Causa:** Los IDs de los elementos HTML no coinciden con los del JavaScript
**Solución:**
- Verificar que exista `<input id="buscar-alumno">`
- Verificar que exista `<div id="resultados-alumnos">`
- Los IDs son case-sensitive (mayúsculas/minúsculas importan)

---

## 📞 REPORTAR EL PROBLEMA

Si después de seguir todos los pasos el problema persiste, reportar:

1. **Captura de la pestaña Console** (completa, desde el inicio)
2. **Captura de la pestaña Network** (mostrando las peticiones AJAX)
3. **Captura de la pestaña Sources** (mostrando si hay errores en el código)
4. **El resultado de estos comandos en consola:**
```javascript
console.log('Elementos:', {
  buscarAlumno: !!document.getElementById('buscar-alumno'),
  buscarCurso: !!document.getElementById('buscar-curso'),
  resultadosAlumnos: !!document.getElementById('resultados-alumnos'),
  resultadosCursos: !!document.getElementById('resultados-cursos')
});
```

5. **La respuesta de este fetch:**
```javascript
fetch('/users/buscar-alumnos?dni=1234')
  .then(r => r.text())
  .then(t => console.log('Respuesta RAW:', t));
```

---

## ✅ RESULTADO ESPERADO

Cuando todo funciona correctamente, al escribir "12345678" en el campo de búsqueda, debes ver:

```
=== BUSQUEDA DE ALUMNO INICIADA ===
DNI ingresado: 12345678
Longitud: 8
⏱️ Esperando 300ms antes de buscar...
🔍 Iniciando búsqueda AJAX...
URL completa: /users/buscar-alumnos?dni=12345678
✅ Respuesta recibida. Status: 200
📦 Datos recibidos del servidor: Array(2)
✅ Alumnos encontrados: 2
Alumno 1: {id: 1, username: "juan", dni: "12345678", ...}
Alumno 2: {id: 5, username: "maria", dni: "12345679", ...}
```

Y en la interfaz deben aparecer los resultados en un dropdown debajo del campo de búsqueda.

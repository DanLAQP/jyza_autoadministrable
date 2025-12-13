# Sistema de Gestión de Cursos CIFA

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

Sistema de gestión de cursos en línea desarrollado con [CakePHP](https://cakephp.org) 4.x.

## Tabla de Contenido

- [Instalación](#installation)
- [Configuración](#configuration)
- [Manual de Uso del Sistema](#manual-de-uso-del-sistema)
  - [Gestión de Cursos](#1-gestión-de-cursos)
  - [Gestión de Módulos](#2-gestión-de-módulos)
  - [Gestión de Lecciones](#3-gestión-de-lecciones)
  - [Gestión de Contenidos](#4-gestión-de-contenidos-de-lección)
  - [Asignación de Docentes](#5-asignación-de-docentes-a-cursos)
  - [Flujo de Inscripciones](#6-flujo-de-inscripciones)
- [Sistema de Roles](#sistema-de-roles)

---

## Manual de Uso del Sistema

### Sistema de Roles

El sistema cuenta con 3 tipos de usuarios:

- **Administrador (rol = 1)**: Acceso completo al sistema
- **Docente (rol = 2)**: Acceso a cursos asignados y sus estudiantes
- **Estudiante (rol = 3)**: Acceso a cursos inscritos y contenido de lecciones

---

### 1. Gestión de Cursos

#### ¿Qué es un Curso?

Un curso es la unidad principal del sistema educativo. Contiene información general como título, descripción, miniatura y está compuesto por múltiples módulos.

#### Crear un Nuevo Curso

**Requisitos**: Solo **Administradores** (rol = 1) pueden crear cursos.

**Pasos**:

1. Acceder a **Cursos** → **Nuevo Curso** (`/cursos/add`)
2. Completar el formulario:
   - **Título**: Nombre del curso
   - **Descripción**: Resumen detallado del contenido
   - **Miniatura**: Imagen representativa (formatos: JPG, PNG, GIF, WebP)
   - **Usuario/Docente**: Seleccionar el docente responsable del curso
3. Hacer clic en **Guardar**

**Resultado**: El curso se crea y aparece en el listado de cursos.

**Relaciones**:
- Un curso pertenece a un **Usuario** (docente asignado)
- Un curso tiene muchos **Módulos**
- Un curso tiene muchas **Inscripciones**

---

### 2. Gestión de Módulos

#### ¿Qué es un Módulo?

Un módulo es una sección temática dentro de un curso. Agrupa lecciones relacionadas con un tema específico.

#### Crear un Nuevo Módulo

**Requisitos**: Solo **Administradores** (rol = 1) pueden crear módulos.

**Pasos**:

1. **Desde la vista del curso**:
   - Acceder a **Cursos** → **Ver Curso** (`/cursos/view/{id}`)
   - Hacer clic en el botón **Agregar Módulo**
   
   **O directamente**:
   - Acceder a **Módulos** → **Nuevo Módulo** (`/modulos/add`)

2. Completar el formulario:
   - **Título**: Nombre del módulo
   - **Descripción**: Contenido que abordará
   - **Orden**: Número de secuencia en el curso
   - **Curso**: Seleccionar el curso al que pertenece

3. Hacer clic en **Guardar**

**Resultado**: El módulo se crea y se vincula al curso seleccionado.

**Relaciones**:
- Un módulo pertenece a un **Curso**
- Un módulo tiene muchas **Lecciones**

---

### 3. Gestión de Lecciones

#### ¿Qué es una Lección?

Una lección es una unidad de aprendizaje dentro de un módulo. Contiene el material educativo específico.

#### Crear una Nueva Lección

**Requisitos**: Solo **Administradores** (rol = 1) pueden crear lecciones.

**Pasos**:

1. **Desde la vista del módulo**:
   - Acceder a **Módulos** → **Ver Módulo** (`/modulos/view/{id}`)
   - Hacer clic en el botón **Agregar Lección**
   
   **O directamente**:
   - Acceder a **Lecciones** → **Nueva Lección** (`/lecciones/add`)

2. Completar el formulario:
   - **Título**: Nombre de la lección
   - **Descripción**: Objetivos de aprendizaje
   - **Orden**: Número de secuencia en el módulo
   - **Módulo**: Seleccionar el módulo al que pertenece

3. Hacer clic en **Guardar**

**Resultado**: La lección se crea y se vincula al módulo seleccionado.

**Relaciones**:
- Una lección pertenece a un **Módulo**
- Una lección tiene muchos **Contenidos**

---

### 4. Gestión de Contenidos de Lección

#### ¿Qué es un Contenido de Lección?

Un contenido es el material educativo específico que se presenta en una lección: videos, PDFs, documentos, imágenes, etc.

#### Crear un Nuevo Contenido

**Requisitos**: Solo **Administradores** (rol = 1) pueden crear contenidos.

**Pasos**:

1. **Desde la vista de la lección**:
   - Acceder a **Lecciones** → **Ver Lección** (`/lecciones/view/{id}`)
   - Hacer clic en el botón **Agregar Contenido**
   
   **O directamente**:
   - Acceder a **Contenidos de Lección** → **Nuevo Contenido** (`/contenidos-leccion/add`)

2. Completar el formulario:
   - **Título**: Nombre descriptivo del contenido
   - **Descripción**: Explicación del material
   - **Tipo**: Seleccionar (video, documento, presentación, etc.)
   - **Archivo**: Subir el archivo (formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, WEBP, MP4, WEBM)
   - **Orden**: Número de secuencia en la lección
   - **Lección**: Seleccionar la lección a la que pertenece

3. Hacer clic en **Guardar**

**Resultado**: El contenido se sube al servidor y se vincula a la lección.

**Restricciones de Acceso**:
- **Administradores y Docentes**: Pueden descargar archivos
- **Estudiantes**: NO pueden descargar archivos (solo visualizar)

**Relaciones**:
- Un contenido pertenece a una **Lección**

---

### 5. Asignación de Docentes a Cursos

#### ¿Cómo se asigna un Docente a un Curso?

La asignación se realiza mediante el campo `usuario_id` en la tabla `cursos`.

**Pasos**:

1. **Al crear un curso nuevo**:
   - En el formulario de creación de curso, seleccionar el docente en el campo **Usuario**
   
2. **Para modificar el docente asignado**:
   - Acceder a **Cursos** → **Editar Curso** (`/cursos/edit/{id}`)
   - Cambiar el campo **Usuario** al nuevo docente
   - Hacer clic en **Guardar**

**Requisitos del Docente**:
- El usuario debe tener `rol = 2` (Docente)
- El docente puede estar asignado a múltiples cursos
- Un curso solo puede tener un docente principal asignado

**Relación en Base de Datos**:
```php
// En CursosTable.php
$this->belongsTo('Users', [
    'foreignKey' => 'usuario_id',
    'joinType' => 'INNER',
]);
```

---

### 6. Flujo de Inscripciones

#### Proceso Completo de Inscripción

El sistema maneja 4 estados de inscripción:

1. **pendiente**: Solicitud enviada, esperando aprobación
2. **aprobado**: Estudiante puede acceder al curso
3. **rechazado**: Solicitud denegada
4. **completado**: Estudiante finalizó el curso

#### Paso a Paso del Flujo

**PASO 1: Estudiante solicita inscripción**

1. El estudiante accede a **Mis Cursos** (`/cursos/student`)
2. Ve el catálogo de cursos disponibles
3. Hace clic en **Solicitar Inscripción** en el curso deseado
4. El sistema crea una inscripción con:
   - `estado = 'pendiente'`
   - `progreso = 0`
   - `usuario_id` del estudiante
   - `curso_id` del curso solicitado

5. El botón cambia a **Pendiente** (deshabilitado)
6. Aparece un enlace a **WhatsApp** para contactar al administrador

**PASO 2: Administrador gestiona la solicitud**

1. El administrador accede a **Inscripciones** (`/inscripciones/index`)
2. Ve todas las solicitudes pendientes
3. Accede a **Ver Inscripción** (`/inscripciones/view/{id}`)
4. Puede realizar dos acciones:
   - **Aprobar**: Cambia `estado = 'aprobado'`
   - **Rechazar**: Cambia `estado = 'rechazado'`

**PASO 3: Estudiante accede al curso aprobado**

1. Si la inscripción fue aprobada:
   - El estudiante ve el botón **Ingresar al Curso**
   - Puede acceder al contenido completo
   - El `progreso` se actualiza según avanza

2. Si la inscripción fue rechazada:
   - El estudiante ve el botón **Rechazado**
   - Puede solicitar nuevamente o contactar vía WhatsApp

**PASO 4: Estudiante completa el curso**

1. Al terminar todas las lecciones:
   - El sistema actualiza `estado = 'completado'`
   - Se genera un certificado de finalización

---

### Estructura de Directorios de Archivos Subidos

```
webroot/
  uploads/
    cursos/                  # Miniaturas de cursos
    contenidos_leccion/      # Archivos de contenido educativo
```

---

### Flujo Recomendado de Creación

**Orden sugerido para configurar un curso completo**:

1. ✅ **Crear el Curso** (asignar docente)
2. ✅ **Crear Módulos** (vincular al curso)
3. ✅ **Crear Lecciones** (vincular a cada módulo)
4. ✅ **Agregar Contenidos** (subir archivos a cada lección)
5. ✅ **Publicar el curso** (los estudiantes pueden verlo)
6. ✅ **Gestionar Inscripciones** (aprobar/rechazar solicitudes)

---

### Configuración de WhatsApp

El sistema permite a los estudiantes contactar al administrador vía WhatsApp cuando su inscripción está pendiente o rechazada.

**Configurar el número de WhatsApp**:

1. Editar el archivo `config/app.php`
2. Buscar la sección `Cifa`:
```php
'Cifa' => [
    'whatsapp_admin' => '51999999999', // Cambiar por el número real
],
```
3. Guardar el archivo

**Formato del número**: Código de país + número sin espacios ni guiones
- Ejemplo Perú: `51987654321`
- Ejemplo México: `5215512345678`

---

## Estructura de la Base de Datos

### Relaciones Principales

```
users (docentes)
  └── cursos (courses)
        ├── inscripciones (enrollments)
        │     └── users (estudiantes)
        └── modulos (modules)
              └── lecciones (lessons)
                    └── contenidos_leccion (lesson contents)
```

### Campos Importantes

**Tabla `cursos`**:
- `usuario_id`: ID del docente asignado
- `titulo`: Nombre del curso
- `descripcion`: Descripción completa
- `miniatura`: Ruta de la imagen

**Tabla `inscripciones`**:
- `usuario_id`: ID del estudiante
- `curso_id`: ID del curso
- `estado`: pendiente/aprobado/rechazado/completado
- `progreso`: Porcentaje de avance (0-100)

**Tabla `modulos`**:
- `curso_id`: ID del curso al que pertenece
- `titulo`: Nombre del módulo
- `orden`: Secuencia de presentación

**Tabla `lecciones`**:
- `modulo_id`: ID del módulo al que pertenece
- `titulo`: Nombre de la lección
- `orden`: Secuencia de presentación

**Tabla `contenidos_leccion`**:
- `leccion_id`: ID de la lección
- `titulo`: Nombre del contenido
- `tipo`: Tipo de archivo
- `archivo`: Ruta del archivo subido
- `orden`: Secuencia de presentación

---

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and set up the
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.

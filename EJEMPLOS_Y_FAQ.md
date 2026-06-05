# Ejemplos de Uso y Preguntas Frecuentes

## 📖 Ejemplos de Uso

### Ejemplo 1: Usar el Hook en un Componente Astro

```astro
---
// src/components/landing/Nosotros.astro
import { getSectionContent, getBlockContent, getImage } from '../hooks/useContent';

// Obtener contenido de la sección
const content = await getSectionContent('nosotros');

// Extraer datos específicos
const titulo = getBlockContent(content, 'titulo', 'Quiénes Somos');
const descripcion = getBlockContent(content, 'descripcion', '');
const imagen = getImage(content, 0);
---

<section class="nosotros">
  <div class="contenedor">
    {imagen && (
      <img 
        src={imagen.url} 
        alt={imagen.alt}
        loading="lazy"
      />
    )}
    
    <div class="contenido">
      <h2>{titulo}</h2>
      <p set:html={descripcion} />
    </div>
  </div>
</section>

<style>
  .nosotros {
    padding: 4rem 2rem;
    background: white;
  }
</style>
```

### Ejemplo 2: Obtener Todo el Contenido en Build Time

```astro
---
// src/pages/index.astro
import { getAllContent } from '../hooks/useContent';

// En build time, obtener TODO el contenido
const allContent = await getAllContent();

// Ahora tienes acceso a todas las secciones
const bienvenida = allContent?.['bienvenida'];
const nosotros = allContent?.['nosotros'];
const servicios = allContent?.['servicios'];
---

<html>
  <body>
    <Bienvenida content={bienvenida} />
    <Nosotros content={nosotros} />
    <Servicios content={servicios} />
  </body>
</html>
```

### Ejemplo 3: Manejo de Errores en Astro

```astro
---
import { getSectionContent } from '../hooks/useContent';

let content = null;
let error = null;

try {
  content = await getSectionContent('bienvenida');
  if (!content) {
    throw new Error('Contenido no encontrado');
  }
} catch (e) {
  error = e.message;
  console.error('Error cargando contenido:', error);
  // Usar contenido por defecto o mostrar mensaje
}
---

<html>
  <body>
    {error ? (
      <div class="error-message">
        <p>No se pudo cargar el contenido. Por favor, intenta más tarde.</p>
      </div>
    ) : (
      <Bienvenida content={content} />
    )}
  </body>
</html>
```

### Ejemplo 4: Contenido con Bloques JSON

```astro
---
// src/components/landing/Equipo.astro
import { getSectionContent, getJSONBlock } from '../hooks/useContent';

const content = await getSectionContent('nosotros');
const teamMembers = getJSONBlock(content, 'team_members');
---

<section class="equipo">
  <h2>Nuestro Equipo</h2>
  
  <div class="team-grid">
    {teamMembers?.map((member) => (
      <div class="team-card">
        <img src={member.foto} alt={member.nombre} />
        <h3>{member.nombre}</h3>
        <p class="especialidad">{member.especialidad}</p>
        <p class="bio">{member.bio}</p>
      </div>
    ))}
  </div>
</section>
```

Donde en CakePHP, el bloque `team_members` sería JSON como:

```json
[
  {
    "nombre": "Dra. María García",
    "especialidad": "Ginecóloga",
    "bio": "Más de 15 años de experiencia",
    "foto": "/images/maria.jpg"
  },
  {
    "nombre": "Dra. Ana López",
    "especialidad": "Obstetra",
    "bio": "Especialista en embarazos de riesgo",
    "foto": "/images/ana.jpg"
  }
]
```

### Ejemplo 5: SEO Dinámico

```astro
---
// src/pages/index.astro
import { getAllContent, getSEOMetadata } from '../hooks/useContent';

const allContent = await getAllContent();
const bienvenida = allContent?.['bienvenida'];
const seo = getSEOMetadata(bienvenida);
---

<html lang="es">
  <head>
    <title>{seo.title}</title>
    <meta name="description" content={seo.description} />
    <meta property="og:image" content={seo.ogImage} />
    <link rel="canonical" href={seo.canonical} />
    
    <!-- JSON-LD -->
    <script type="application/ld+json" set:html={JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'MedicalBusiness',
      name: 'Clínica JYZA',
      description: seo.description,
      image: seo.ogImage,
    })} />
  </head>
  <body>
    <!-- Contenido -->
  </body>
</html>
```

### Ejemplo 6: Validar Que el Contenido es Reciente

```astro
---
import { getSectionContent, isContentFresh } from '../hooks/useContent';

const content = await getSectionContent('bienvenida');
const isFresh = isContentFresh(content, 60); // ¿Menos de 60 minutos viejo?

if (!isFresh) {
  console.warn('Contenido podría estar desactualizado');
}
---

{isFresh ? (
  <div class="content-fresh">
    {/* Mostrar contenido normalmente */}
  </div>
) : (
  <div class="content-warning">
    <p>Contenido posiblemente desactualizado</p>
  </div>
)}
```

---

## 🔧 Ejemplos de CakePHP

### Actualizar Contenido desde API (Admin)

```php
<?php
// En Admin/ContentController.php

public function edit($id = null)
{
    $section = $this->ContentSections->get($id, contain: ['ContentBlocks']);

    if ($this->request->is(['post', 'put'])) {
        $data = $this->request->getData();
        $userId = $this->Authentication->getIdentity()->id;

        foreach ($data['blocks'] as $blockId => $content) {
            $block = $this->ContentBlocks->get($blockId);
            $contentBefore = $block->content;

            $block->content = $content;
            if ($this->ContentBlocks->save($block)) {
                // Registrar versión
                $this->ContentVersions->recordChange(
                    $blockId,
                    $contentBefore,
                    $content,
                    $userId,
                    'Actualización manual desde admin'
                );
            }
        }

        // Invalidar caché
        $this->ContentSections->invalidateCache($section->slug);

        $this->Flash->success('Contenido actualizado');
        return $this->redirect(['action' => 'index']);
    }

    $this->set(compact('section'));
}
```

### Subir Imagen desde Admin

```php
<?php
public function uploadImage()
{
    if (!$this->request->is('post')) {
        throw new MethodNotAllowedException();
    }

    $file = $this->request->getUploadedFile('image');
    $sectionId = (int)$this->request->getData('section_id');
    $userId = $this->Authentication->getIdentity()->id;

    try {
        $imageService = new \App\Service\ImageService();
        $result = $imageService->processAndStore(
            $file,
            $userId,
            $sectionId
        );

        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($result));
    } catch (\Exception $e) {
        $this->response = $this->response
            ->withStatus(400)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => $e->getMessage()]));
    }
}
```

### Ver Historial de Cambios

```php
<?php
public function history($blockId = null)
{
    $versions = $this->ContentVersions->find()
        ->where(['block_id' => $blockId])
        ->contain(['Users'])
        ->orderBy(['created' => 'DESC'])
        ->toArray();

    $this->set(compact('versions'));
    $this->viewBuilder()->setOption('serialize', ['versions']);
}
```

---

## ❓ Preguntas Frecuentes

### P: ¿Cómo edito textos desde el panel administrativo?

R: 
1. Ingresa a `/admin/content`
2. Selecciona la sección que deseas editar (ej: Bienvenida)
3. Haz clic en "Editar"
4. Modifica los campos de texto
5. Si es WYSIWYG (editor de texto enriquecido), usa el editor visual
6. Haz clic en "Guardar cambios"
7. Los cambios aparecerán automáticamente en el sitio web

### P: ¿Cuánto tarda en aparecer un cambio en el sitio web?

R: Depende del caché configurado:
- Si está habilitado caché de 1 hora: Máximo 60 minutos
- Si está deshabilitado: Instantáneamente (menos recomendado)
- Se puede limpiar caché manualmente desde el admin

### P: ¿Puedo subir imágenes?

R: Sí, desde el panel administrativo:
1. Ve a editar una sección
2. Busca el campo de imagen
3. Haz clic en "Seleccionar imagen"
4. Sube una imagen (JPG, PNG, WebP)
5. Se optimizará automáticamente en 3 tamaños: thumbnail, medium, large

### P: ¿Qué pasa si la API no está disponible?

R: El componente Bienvenida.astro tiene un contenido por defecto (fallback):
- Si la API falla, mostrará el contenido hardcodeado
- Esto garantiza que el sitio siempre esté visible
- Se ve un mensaje de error en la consola para debugging

### P: ¿Cómo agrego una nueva sección?

R: Sin cambiar código:
1. En la BD, insertar en `content_sections`:
   ```sql
   INSERT INTO content_sections (slug, title, description) 
   VALUES ('nueva_seccion', 'Título', 'Descripción');
   ```

2. Insertar bloques en `content_blocks`:
   ```sql
   INSERT INTO content_blocks (section_id, block_key, block_type, content) 
   VALUES (2, 'titulo', 'text', 'Mi Título');
   ```

3. Crear componente Astro para esa sección:
   ```astro
   import { getSectionContent } from '../hooks/useContent';
   const content = await getSectionContent('nueva_seccion');
   ```

4. Usar el componente en la página

### P: ¿Cómo doy acceso solo a ciertos usuarios?

R: Usando roles y permisos:
1. En CakePHP, el admin de contenido requiere autenticación
2. Solo usuarios con rol `admin` (rol=1) pueden editar
3. Edita el método `beforeFilter` en Admin/ContentController.php para añadir más validaciones

### P: ¿Puedo revertir cambios?

R: Sí, hay un historial completo:
1. Ve a `/admin/content/history/{blockId}`
2. Ve todos los cambios realizados
3. Haz clic en "Restaurar" para volver a una versión anterior
4. Se crea automáticamente un nuevo registro de versión

### P: ¿Cómo optimizo las imágenes?

R: Automáticamente:
1. Se redimensionan a 3 tamaños: 300px, 800px, 1920px
2. Se comprimen a 85% de calidad
3. Se guardan en WebP cuando es posible
4. Se generan srcset para responsive images

Uso en HTML:
```html
<picture>
  <source media="(max-width: 640px)" srcset="/img.300.webp">
  <source media="(max-width: 1024px)" srcset="/img.800.webp">
  <img src="/img.1920.webp" alt="Descripción">
</picture>
```

### P: ¿Cómo configurar caché?

R: En `config/bootstrap_cli.php` y `config/bootstrap.php`:

```php
Cache::setConfig('api', [
    'className' => 'File',
    'duration' => '+1 hour',
    'path' => CACHE . 'content_api/',
]);
```

Para Redis:
```php
Cache::setConfig('api', [
    'className' => 'Redis',
    'duration' => '+1 hour',
    'servers' => ['127.0.0.1'],
]);
```

### P: ¿Cómo hago testing?

R: Pruebas manuales:

```bash
# API funcionando
curl http://localhost:3000/api/v1/content/bienvenida

# Contenido en Astro
http://localhost:3000 (debería cargar contenido dinámico)

# Panel admin
http://localhost:3000/admin/content (inicia sesión primero)
```

### P: ¿Cómo sé si hay un error?

R: Revisa estos logs:
- **CakePHP**: `logs/debug.log` y `logs/error.log`
- **Frontend**: Consola del navegador (F12 > Console)
- **BD**: PHPMyAdmin

### P: ¿Puedo usar Markdown en vez de HTML?

R: Sí, en los bloques `textarea`:
1. Almacena Markdown en la BD
2. En el componente Astro, convierte con una librería:

```astro
---
import { marked } from 'marked';

const content = await getSectionContent('seccion');
const html = marked(content.blocks.descripcion.content);
---

<div set:html={html} />
```

### P: ¿Cómo monitorizó el rendimiento?

R: Herramientas recomendadas:
- **Google PageSpeed Insights**: https://pagespeed.web.dev
- **Lighthouse**: Integrado en Chrome DevTools
- **New Relic**: Para monitoreo en tiempo real
- **DataDog**: Para APM y logs

---

## 🔐 Consejos de Seguridad

### 1. Sanitizar HTML en WYSIWYG
```php
// En ContentBlocksTable.php
$validator->add('content', 'sanitize', [
    'rule' => function($value, $context) {
        if ($context['data']['block_type'] === 'wysiwyg') {
            return strip_tags($value, '<p><br><strong><em><ul><li><ol>');
        }
        return true;
    }
]);
```

### 2. Validar URLs
```php
$validator->add('content', 'validUrl', [
    'rule' => 'url',
    'when' => function($context) {
        return $context['data']['block_type'] === 'video';
    }
]);
```

### 3. Limitar Tamaño de Archivo
```php
// En ImageService.php
protected $maxFileSize = 5242880; // 5MB
```

### 4. CORS Seguro
```php
// En ContentController.php
$allowedOrigins = [
    'https://jyza.com',
    'https://www.jyza.com',
];

if (in_array($origin, $allowedOrigins)) {
    $this->response = $this->response
        ->withHeader('Access-Control-Allow-Origin', $origin);
}
```

---

## 📊 Estructura de Datos Ejemplos

### Ejemplo de Respuesta API

```json
{
  "id": 1,
  "slug": "bienvenida",
  "title": "Sección Bienvenida",
  "description": "Hero/Bienvenida de la clínica",
  "metadata": {
    "seo_title": "Clínica JYZA - Ginecología",
    "seo_description": "Clínica especializada en ginecología...",
    "og_image": "/og-bienvenida.png"
  },
  "blocks": {
    "titulo": {
      "id": 1,
      "type": "text",
      "content": "Tu Salud Femenina",
      "metadata": {}
    },
    "descripcion": {
      "id": 2,
      "type": "wysiwyg",
      "content": "<p>Somos una clínica especializada...</p>",
      "metadata": {}
    },
    "team": {
      "id": 3,
      "type": "json",
      "content": "[{\"nombre\": \"Dra. María\", \"especialidad\": \"Ginecóloga\"}]",
      "metadata": {}
    }
  },
  "images": [
    {
      "id": 1,
      "url": "/uploads/content/img_hero.webp",
      "alt": "Clínica Jyza",
      "title": "Hero Image",
      "dimensions": {
        "width": 1920,
        "height": 1080,
        "versions": {
          "thumbnail": {"width": 300, "height": 200, "path": "/uploads/content/img_hero.300.webp"},
          "medium": {"width": 800, "height": 533, "path": "/uploads/content/img_hero.800.webp"},
          "large": {"width": 1920, "height": 1080, "path": "/uploads/content/img_hero.1920.webp"}
        }
      }
    }
  ],
  "updated_at": "2026-05-31T18:32:49+00:00"
}
```

---

## 🚀 Performance Tips

1. **Usa build-time content** en Astro para mejor SEO
2. **Habilita caché** en múltiples capas (Redis, File, Browser)
3. **Optimiza imágenes** automáticamente (ya implementado)
4. **Usa CDN** para servir archivos estáticos y imágenes
5. **Implementa lazy loading** para imágenes fuera de viewport
6. **Minifica** CSS y JavaScript en producción

---

**Última actualización**: Mayo 31, 2026

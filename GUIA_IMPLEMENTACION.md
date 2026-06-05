# Guía de Implementación - CMS Autoadministrable

## 📚 Índice
1. [Instalación Inicial](#instalación-inicial)
2. [Configuración Backend (CakePHP)](#configuración-backend-cakephp)
3. [Configuración Frontend (Astro)](#configuración-frontend-astro)
4. [Panel Administrativo](#panel-administrativo)
5. [Testing](#testing)
6. [Deployment](#deployment)

---

## Instalación Inicial

### Requisitos Previos
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+
- Composer
- XAMPP/LAMP Stack

### Paso 1: Preparar Base de Datos

```bash
# 1. Navega al directorio del backend
cd jyza_autoadministrable

# 2. Ejecutar migraciones para crear tablas
./bin/cake migrations migrate

# 3. (Opcional) Cargar datos de ejemplo
mysql -u root jyza_autoadministrable < ../database/seed_content.sql
```

### Paso 2: Instalar Dependencias

```bash
# Backend (CakePHP)
cd jyza_autoadministrable
composer install

# Frontend (Astro)
cd ../jyza
npm install
```

---

## Configuración Backend (CakePHP)

### Paso 1: Copiar Archivos

Copia estos archivos a tu proyecto CakePHP:

```
src/Model/Table/
  ├── ContentSectionsTable.php
  ├── ContentBlocksTable.php
  ├── ContentVersionsTable.php
  └── ContentImagesTable.php

src/Model/Entity/
  ├── ContentSection.php
  ├── ContentBlock.php
  └── ContentVersion.php

src/Service/
  ├── ContentService.php
  └── ImageService.php

src/Controller/Api/V1/
  └── ContentController.php

src/Controller/Admin/
  └── ContentController.php

config/Migrations/
  └── 20260531000000_CreateContentTables.php
```

### Paso 2: Configurar Rutas

En `config/routes.php`, agregar las rutas del archivo `CONFIG_ROUTES_API.php`:

```php
// API Routes
$routes->scope('/api', function (RouteBuilder $builder): void {
    $builder->setExtensions(['json']);
    $builder->scope('/v1', function (RouteBuilder $builder): void {
        $builder->get('/content/{section}', [
            'controller' => 'Api/V1/Content',
            'action' => 'getSectionContent',
        ]);
        $builder->get('/content', [
            'controller' => 'Api/V1/Content',
            'action' => 'getAllContent',
        ]);
    });
});

// Admin Routes
$routes->scope('/admin', function (RouteBuilder $builder): void {
    $builder->get('/content', ['controller' => 'Admin/Content', 'action' => 'index']);
    $builder->get('/content/edit/{id}', ['controller' => 'Admin/Content', 'action' => 'edit']);
    $builder->post('/content/edit/{id}', ['controller' => 'Admin/Content', 'action' => 'edit']);
    // ... más rutas
});
```

### Paso 3: Crear Controladores API

Crear archivo `src/Controller/Api/V1/ContentController.php`:

```php
<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;

class ContentController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir acceso sin autenticación
        $this->Authentication->allowUnauthenticated(['getSectionContent', 'getAllContent']);
    }

    public function getSectionContent()
    {
        $section = $this->request->getParam('section');
        
        try {
            $contentService = new \App\Service\ContentService();
            $content = $contentService->getSectionContent($section);

            if (!$content) {
                return $this->response
                    ->withStatus(404)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['error' => 'Not found']));
            }

            $this->response = $this->response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Cache-Control', 'public, max-age=3600');

            $this->set(compact('content'));
            $this->viewBuilder()->setOption('serialize', 'content');
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->set(['error' => $e->getMessage()]);
            $this->viewBuilder()->setOption('serialize', 'error');
        }
    }

    public function getAllContent()
    {
        try {
            $contentService = new \App\Service\ContentService();
            $content = $contentService->getAllSectionsContent();

            $this->response = $this->response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Cache-Control', 'public, max-age=3600');

            $this->set(compact('content'));
            $this->viewBuilder()->setOption('serialize', 'content');
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->set(['error' => $e->getMessage()]);
            $this->viewBuilder()->setOption('serialize', 'error');
        }
    }
}
```

### Paso 4: Verificar Instalación

```bash
# Probar endpoint de contenido
curl http://localhost:3000/api/v1/content/bienvenida

# Deberías obtener algo como:
# {
#   "id": 1,
#   "slug": "bienvenida",
#   "blocks": {...},
#   "images": [...]
# }
```

---

## Configuración Frontend (Astro)

### Paso 1: Variables de Entorno

Crear `.env.local` en el directorio `jyza/`:

```bash
PUBLIC_API_URL=http://localhost:3000
PUBLIC_CACHE_TTL=3600
PUBLIC_DEBUG=false
```

### Paso 2: Reemplazar Componentes

1. **Reemplazar Bienvenida.astro:**
   ```bash
   cp src/components/landing/Bienvenida.astro.nuevo src/components/landing/Bienvenida.astro
   ```

2. **Reemplazar index.astro:**
   ```bash
   cp src/pages/index.astro.nuevo src/pages/index.astro
   ```

3. **Copiar hook:**
   ```bash
   cp src/hooks/useContent.ts .
   ```

### Paso 3: Instalar Dependencias (si es necesario)

```bash
cd jyza
npm install
```

### Paso 4: Probar en Desarrollo

```bash
npm run dev
```

Abre `http://localhost:3000` en tu navegador. Deberías ver el contenido cargándose desde la API.

---

## Panel Administrativo

### Paso 1: Crear Vistas Administrativas

Crear carpeta `templates/Admin/Content/`:

```html
<!-- templates/Admin/Content/index.php -->
<div class="admin-panel">
    <h1>Administrar Contenido</h1>
    
    <div class="sections-list">
        <?php foreach ($contentSections as $section): ?>
            <div class="section-item">
                <h3><?= $section->title ?></h3>
                <a href="<?= $this->Url->build(['action' => 'edit', $section->id]) ?>">
                    Editar
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
```

### Paso 2: Crear Vista de Edición

```html
<!-- templates/Admin/Content/edit.php -->
<div class="editor">
    <h1>Editar: <?= $section->title ?></h1>
    
    <?= $this->Form->create(null, ['type' => 'post']) ?>
    
    <?php foreach ($section->content_blocks as $block): ?>
        <fieldset>
            <legend><?= $block->block_key ?></legend>
            
            <?php if ($block->block_type === 'wysiwyg'): ?>
                <textarea name="blocks[<?= $block->id ?>]" class="wysiwyg">
                    <?= $block->content ?>
                </textarea>
            <?php elseif ($block->block_type === 'textarea'): ?>
                <textarea name="blocks[<?= $block->id ?>]" rows="6">
                    <?= $block->content ?>
                </textarea>
            <?php else: ?>
                <input type="text" name="blocks[<?= $block->id ?>]" value="<?= $block->content ?>">
            <?php endif; ?>
        </fieldset>
    <?php endforeach; ?>
    
    <?= $this->Form->button('Guardar', ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
```

### Paso 3: Agregar Editor WYSIWYG

En `templates/layout/default.php`:

```html
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
  selector: '.wysiwyg',
  plugins: 'link image code',
  toolbar: 'undo redo | styleselect | bold italic | link image | code'
});
</script>
```

---

## Testing

### Test de API

```bash
# Obtener sección específica
curl -X GET http://localhost:3000/api/v1/content/bienvenida \
  -H "Accept: application/json"

# Obtener todo el contenido
curl -X GET http://localhost:3000/api/v1/content \
  -H "Accept: application/json"
```

### Test de Componente Astro

```bash
# En el navegador, verificar que se carga:
# 1. El componente Bienvenida
# 2. Contenido desde la API
# 3. Fallback si la API falla

# Ver en consola del navegador:
console.log('Contenido cargado correctamente');
```

---

## Deployment

### Backend (CakePHP) en Producción

```bash
# 1. Clonar repo
git clone <repo> /var/www/api.jyza.com

# 2. Instalar dependencias
cd /var/www/api.jyza.com
composer install --no-dev

# 3. Configurar .env
cp .env.example .env
# Editar con datos de producción

# 4. Ejecutar migraciones
./bin/cake migrations migrate

# 5. Configurar permisos
chmod -R 755 tmp logs webroot

# 6. Configurar Apache
# Crear VirtualHost en /etc/apache2/sites-available/api.jyza.conf
<VirtualHost *:443>
    ServerName api.jyza.com
    DocumentRoot /var/www/api.jyza.com/webroot
    
    <Directory /var/www/api.jyza.com/webroot>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^ index.php [QSA,L]
        
        AllowOverride All
    </Directory>
</VirtualHost>

# 7. Habilitar sitio
a2ensite api.jyza.conf
systemctl restart apache2
```

### Frontend (Astro) en Vercel

```bash
# 1. Conectar repo a Vercel
# (via https://vercel.com/import)

# 2. Configurar variables de entorno
# En Vercel Dashboard > Settings > Environment Variables:
PUBLIC_API_URL=https://api.jyza.com

# 3. Deploy automático
# Los pushes a main se despliegan automáticamente
```

### Frontend (Astro) en Netlify

```bash
# 1. Conectar repo
# (via https://app.netlify.com)

# 2. Configurar build
# Build command: npm run build
# Publish directory: dist

# 3. Variables de entorno
# En Netlify > Site settings > Build & deploy > Environment:
PUBLIC_API_URL=https://api.jyza.com

# 4. Deploy
# Los pushes a main se despliegan automáticamente
```

---

## Checklist Final

- [ ] Migraciones ejecutadas en BD
- [ ] Archivos de modelos copiados
- [ ] Archivo de controladores copiados
- [ ] Rutas configuradas
- [ ] API funcionando (`/api/v1/content`)
- [ ] Variables de entorno configuradas
- [ ] Componente Astro actualizado
- [ ] Datos iniciales insertados en BD
- [ ] Panel administrativo accesible
- [ ] Contenido visible en Astro

---

## Troubleshooting

### API retorna 404
```
Verificar:
1. ¿Existen datos en content_sections?
2. ¿El slug está correcto?
3. ¿Las rutas están bien configuradas?
```

### Astro no carga contenido
```
Verificar:
1. PUBLIC_API_URL configurada en .env.local
2. API backend corriendo
3. CORS habilitado en API
4. Sin errores en consola del navegador
```

### Caché viejo
```
Limpiar:
1. Caché de servidor: ./bin/cake cache clear_all
2. Caché del navegador: Ctrl+Shift+Delete
3. Rebuild de Astro: npm run build
```

---

## Documentación Adicional

- [CakePHP Documentation](https://book.cakephp.org/)
- [Astro Documentation](https://docs.astro.build/)
- [REST API Best Practices](https://restfulapi.net/)
- [MySQL 8.0 Documentation](https://dev.mysql.com/doc/)

---

## Soporte

Para problemas o preguntas:
1. Revisar logs: `logs/debug.log` y `logs/error.log`
2. Verificar BD: PHPMyAdmin en `http://localhost/phpmyadmin`
3. Consola del navegador: F12 > Console

---

**Versión:** 1.0  
**Última actualización:** Mayo 31, 2026

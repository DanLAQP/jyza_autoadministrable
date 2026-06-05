# Arquitectura CMS Autoadministrable - Jyza

## 📋 Índice
1. [Visión General](#visión-general)
2. [Diseño de Base de Datos](#diseño-de-base-de-datos)
3. [Backend CakePHP](#backend-cakephp)
4. [Panel Administrativo](#panel-administrativo)
5. [Frontend Astro](#frontend-astro)
6. [Escalabilidad](#escalabilidad)
7. [Seguridad y Buenas Prácticas](#seguridad-y-buenas-prácticas)

---

## Visión General

### Conceptos Clave

El sistema utiliza un modelo **de contenidos basado en secciones** donde:

- **Secciones** = Componentes principales (Hero/Bienvenida, Nosotros, Servicios, etc.)
- **Bloques de contenido** = Elementos dentro de cada sección (título, descripción, CTA, imágenes, etc.)
- **Versionado** = Cada cambio se registra con timestamp y usuario
- **Escalabilidad** = Una única tabla maneja todas las secciones sin redundancia

### Flujo de Datos

```
CakePHP Admin Panel
        ↓
    Base de Datos (MySQL)
        ↓
    API REST (/api/v1/content/{section})
        ↓
    Astro Build Time (getStaticProps) / SSR
        ↓
    HTML Estático o Dinámico
```

---

## Diseño de Base de Datos

### Estructura Propuesta

```sql
-- Tabla Principal: Secciones de Contenido
CREATE TABLE content_sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(255) UNIQUE NOT NULL COMMENT 'bienvenida, nosotros, servicios',
  title VARCHAR(255) NOT NULL COMMENT 'Título interno',
  description TEXT COMMENT 'Descripción de la sección',
  metadata JSON COMMENT '{"seo_title", "seo_description", "og_image"}',
  is_active BOOLEAN DEFAULT TRUE,
  sort_order INT DEFAULT 0,
  created_by INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (created_by) REFERENCES users(id),
  INDEX idx_slug (slug),
  INDEX idx_is_active (is_active)
);

-- Tabla: Bloques de Contenido (flexible para cualquier tipo)
CREATE TABLE content_blocks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_id INT NOT NULL,
  block_key VARCHAR(100) NOT NULL COMMENT 'titulo, descripcion, cta_text, etc',
  block_type ENUM('text', 'textarea', 'wysiwyg', 'image', 'video', 'json') DEFAULT 'text',
  content LONGTEXT COMMENT 'Contenido del bloque',
  metadata JSON COMMENT 'Datos adicionales (alt text, size, etc)',
  sort_order INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (section_id) REFERENCES content_sections(id) ON DELETE CASCADE,
  UNIQUE KEY unique_section_key (section_id, block_key),
  INDEX idx_section (section_id),
  INDEX idx_type (block_type)
);

-- Tabla: Historial/Versionado de Cambios
CREATE TABLE content_versions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  block_id INT NOT NULL,
  content_before LONGTEXT COMMENT 'Contenido anterior',
  content_after LONGTEXT COMMENT 'Contenido nuevo',
  change_type ENUM('created', 'updated', 'deleted') DEFAULT 'updated',
  changed_by INT NOT NULL,
  change_reason VARCHAR(255) COMMENT 'Motivo del cambio',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (block_id) REFERENCES content_blocks(id) ON DELETE CASCADE,
  FOREIGN KEY (changed_by) REFERENCES users(id),
  INDEX idx_block (block_id),
  INDEX idx_date (created_at)
);

-- Tabla: Gestión de Imágenes
CREATE TABLE content_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_id INT,
  block_id INT,
  original_filename VARCHAR(255) NOT NULL,
  stored_filename VARCHAR(255) NOT NULL UNIQUE,
  file_path VARCHAR(500) NOT NULL,
  file_size INT COMMENT 'Tamaño en bytes',
  mime_type VARCHAR(100),
  dimensions JSON COMMENT '{"width", "height", "optimized_versions"}',
  alt_text VARCHAR(500),
  title VARCHAR(255),
  uploaded_by INT NOT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (section_id) REFERENCES content_sections(id) ON DELETE SET NULL,
  FOREIGN KEY (block_id) REFERENCES content_blocks(id) ON DELETE SET NULL,
  FOREIGN KEY (uploaded_by) REFERENCES users(id),
  INDEX idx_section (section_id),
  INDEX idx_block (block_id)
);

-- Tabla: Caché de Compilación (para Astro)
CREATE TABLE content_cache (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_slug VARCHAR(255) UNIQUE NOT NULL,
  cache_data LONGTEXT COMMENT 'JSON serializado',
  etag VARCHAR(100),
  expires_at TIMESTAMP,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_expires (expires_at)
);
```

### Estructura de Permisos

```sql
-- Tabla: Roles y Permisos (ya existe, complementar)
-- Agregar permisos específicos para contenidos:

INSERT INTO permissions (name, description) VALUES
('content.view', 'Ver contenido publicado'),
('content.edit', 'Editar contenido'),
('content.publish', 'Publicar cambios'),
('content.restore', 'Restaurar versiones'),
('content.delete', 'Eliminar contenido'),
('content.manage_all', 'Administrar todo contenido'),
('content.manage_own', 'Administrar solo contenido propio');
```

---

## Backend CakePHP

### 1. Estructura de Carpetas

```
src/
├── Controller/
│   ├── Api/
│   │   └── V1/
│   │       └── ContentController.php      # GET /api/v1/content/{section}
│   └── Admin/
│       └── ContentController.php          # Admin panel
├── Model/
│   ├── Entity/
│   │   ├── ContentSection.php
│   │   ├── ContentBlock.php
│   │   ├── ContentVersion.php
│   │   ├── ContentImage.php
│   │   └── ContentCache.php
│   └── Table/
│       ├── ContentSectionsTable.php
│       ├── ContentBlocksTable.php
│       ├── ContentVersionsTable.php
│       ├── ContentImagesTable.php
│       └── ContentCacheTable.php
├── Policy/
│   └── ContentPolicy.php                 # Autorización
└── Service/
    ├── ContentService.php                # Lógica de negocio
    ├── ImageService.php                  # Procesamiento de imágenes
    └── CacheService.php                  # Gestión de caché
```

### 2. Modelos (Entities)

#### ContentSection.php
```php
<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ContentSection extends Entity
{
    protected array $_accessible = [
        'slug' => true,
        'title' => true,
        'description' => true,
        'metadata' => true,
        'is_active' => true,
        'sort_order' => true,
        'created_by' => true,
        'content_blocks' => true,
        'content_images' => true,
    ];

    protected array $_hidden = [];

    protected function _getMetadata()
    {
        $meta = $this->_properties['metadata'] ?? null;
        return is_string($meta) ? json_decode($meta, true) : $meta;
    }

    protected function _setMetadata($value)
    {
        return is_array($value) ? json_encode($value) : $value;
    }
}
```

#### ContentBlock.php
```php
<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ContentBlock extends Entity
{
    protected array $_accessible = [
        'section_id' => true,
        'block_key' => true,
        'block_type' => true,
        'content' => true,
        'metadata' => true,
        'sort_order' => true,
        'is_active' => true,
        'section' => true,
    ];

    protected function _getMetadata()
    {
        $meta = $this->_properties['metadata'] ?? null;
        return is_string($meta) ? json_decode($meta, true) : $meta;
    }

    protected function _setMetadata($value)
    {
        return is_array($value) ? json_encode($value) : $value;
    }

    // Validar por tipo de bloque
    public function getFieldRules()
    {
        return match($this->block_type) {
            'text' => ['content' => 'string|maxLength:500'],
            'textarea' => ['content' => 'string|maxLength:5000'],
            'wysiwyg' => ['content' => 'string'],
            'image' => ['content' => 'integer'], // ID de imagen
            'video' => ['content' => 'string|url'],
            'json' => ['content' => 'json'],
            default => []
        };
    }
}
```

#### ContentVersion.php
```php
<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class ContentVersion extends Entity
{
    protected array $_accessible = [
        'block_id' => true,
        'content_before' => true,
        'content_after' => true,
        'change_type' => true,
        'changed_by' => true,
        'change_reason' => true,
    ];

    protected array $_hidden = [];
}
```

### 3. Tablas (Tables)

#### ContentBlocksTable.php
```php
<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContentBlocksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('content_blocks');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        // Relaciones
        $this->belongsTo('ContentSections', [
            'foreignKey' => 'section_id',
        ]);

        $this->hasMany('ContentVersions', [
            'foreignKey' => 'block_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('block_key')
            ->maxLength('block_key', 100)
            ->requirePresence('block_key', 'create')
            ->notEmptyString('block_key');

        $validator
            ->scalar('block_type')
            ->inList('block_type', ['text', 'textarea', 'wysiwyg', 'image', 'video', 'json'])
            ->requirePresence('block_type', 'create')
            ->notEmptyString('block_type');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        return $validator;
    }

    /**
     * Obtener contenido con manejo de caché
     */
    public function getContentByKey($sectionId, $blockKey, $useCache = true)
    {
        $cacheKey = "content_block_{$sectionId}_{$blockKey}";

        if ($useCache) {
            $cached = cache($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        $block = $this->find()
            ->where([
                'section_id' => $sectionId,
                'block_key' => $blockKey,
                'is_active' => true,
            ])
            ->first();

        if ($block && $useCache) {
            cache($cacheKey, $block, '+1 hour');
        }

        return $block;
    }
}
```

### 4. Controladores

#### API Controller: ContentController.php

```php
<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;

class ContentController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir acceso sin autenticación para lectura
        $this->Authentication->allowUnauthenticated(['getSectionContent', 'getAllContent']);
    }

    /**
     * GET /api/v1/content/{section}
     * Obtener contenido de una sección específica
     */
    public function getSectionContent()
    {
        $section = $this->request->getParam('section');

        if (!$section) {
            return $this->response
                ->withStatus(400)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Section required']));
        }

        try {
            $contentService = $this->getService('ContentService');
            $content = $contentService->getSectionContent($section);

            if (!$content) {
                return $this->response
                    ->withStatus(404)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['error' => 'Section not found']));
            }

            // CORS headers
            $this->response = $this->response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Cache-Control', 'public, max-age=3600')
                ->withHeader('Content-Type', 'application/json');

            $this->set(compact('content'));
            $this->viewBuilder()->setOption('serialize', 'content');
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->set(['error' => $e->getMessage()]);
            $this->viewBuilder()->setOption('serialize', 'error');
        }
    }

    /**
     * GET /api/v1/content
     * Obtener todo el contenido (para pregenerar en Astro)
     */
    public function getAllContent()
    {
        try {
            $contentService = $this->getService('ContentService');
            $content = $contentService->getAllSectionsContent();

            $this->response = $this->response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Cache-Control', 'public, max-age=3600')
                ->withHeader('Content-Type', 'application/json');

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

#### Admin Controller: src/Controller/Admin/ContentController.php

```php
<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Exception\ForbiddenException;

class ContentController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Solo administradores pueden acceder
        if (!$this->Authorization->can($this->Authentication->getIdentity(), 'edit', $this->getRequest())) {
            throw new ForbiddenException('Acceso denegado');
        }
    }

    /**
     * GET /admin/content
     * Listar secciones
     */
    public function index()
    {
        $contentSections = $this->ContentSections->find()
            ->contain(['ContentBlocks'])
            ->orderBy(['sort_order' => 'ASC'])
            ->toArray();

        $this->set(compact('contentSections'));
    }

    /**
     * GET /admin/content/edit/{id}
     * Editar sección
     */
    public function edit($id = null)
    {
        $section = $this->ContentSections->get($id, contain: ['ContentBlocks' => ['sort' => ['sort_order' => 'ASC']]]);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Crear registro de versión antes de actualizar
            $this->_createVersionRecords($section->content_blocks, $data);

            // Actualizar bloques
            foreach ($data['content_blocks'] as $blockData) {
                if (isset($blockData['id'])) {
                    $block = $this->ContentBlocks->get($blockData['id']);
                    $this->ContentBlocks->patchEntity($block, $blockData);
                    $this->ContentBlocks->save($block);
                }
            }

            // Limpiar caché
            $this->_clearSectionCache($section->slug);

            $this->Flash->success('Contenido actualizado exitosamente');
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('section'));
    }

    /**
     * GET /admin/content/history/{blockId}
     * Ver historial de cambios
     */
    public function history($blockId = null)
    {
        $versions = $this->ContentVersions->find()
            ->where(['block_id' => $blockId])
            ->contain(['Users'])
            ->orderBy(['created_at' => 'DESC'])
            ->toArray();

        $this->set(compact('versions'));
    }

    /**
     * POST /admin/content/restore
     * Restaurar versión anterior
     */
    public function restore()
    {
        if (!$this->request->is('post')) {
            throw new \Cake\Http\Exception\MethodNotAllowedException();
        }

        $versionId = $this->request->getData('version_id');
        $version = $this->ContentVersions->get($versionId);

        // Restaurar contenido
        $block = $this->ContentBlocks->get($version->block_id);
        $block->content = $version->content_before;
        $block->modified = new \DateTime();

        if ($this->ContentBlocks->save($block)) {
            $this->Flash->success('Versión restaurada');
        }

        return $this->redirect($this->referer());
    }

    /**
     * POST /admin/content/upload-image
     * Subir imagen
     */
    public function uploadImage()
    {
        if (!$this->request->is('post')) {
            throw new \Cake\Http\Exception\MethodNotAllowedException();
        }

        $file = $this->request->getUploadedFile('image');
        $imageService = $this->getService('ImageService');

        try {
            $image = $imageService->processAndStore($file, $this->Authentication->getIdentity()->id);
            $this->set(compact('image'));
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(400);
            $this->set(['error' => $e->getMessage()]);
        }

        $this->viewBuilder()->setOption('serialize', ['image', 'error']);
    }

    /**
     * Crear registros de versión para cambios
     */
    private function _createVersionRecords($blocks, $newData)
    {
        $userId = $this->Authentication->getIdentity()->id;

        foreach ($blocks as $block) {
            $newContent = $newData['content_blocks'][$block->id]['content'] ?? null;

            if ($newContent !== $block->content) {
                $this->ContentVersions->save($this->ContentVersions->newEntity([
                    'block_id' => $block->id,
                    'content_before' => $block->content,
                    'content_after' => $newContent,
                    'change_type' => 'updated',
                    'changed_by' => $userId,
                    'change_reason' => $this->request->getData('reason', 'Actualización manual'),
                ]));
            }
        }
    }

    /**
     * Limpiar caché de sección
     */
    private function _clearSectionCache($slug)
    {
        cache("content_section_{$slug}", null);
        cache("content_all", null);
    }
}
```

### 5. Rutas (routes.php)

```php
<?php
// En config/routes.php, agregar:

$routes->scope('/api', function (RouteBuilder $builder): void {
    $builder->setExtensions(['json']);

    $builder->scope('/v1', function (RouteBuilder $builder): void {
        // Rutas públicas
        $builder->get('/content', ['controller' => 'Content', 'action' => 'getAllContent', 'plugin' => false]);
        $builder->get('/content/{section}', ['controller' => 'Content', 'action' => 'getSectionContent', 'plugin' => false]);
    });
});

// Rutas administrativas
$routes->scope('/admin', function (RouteBuilder $builder): void {
    $builder->setExtensions(['json', 'html']);
    
    $builder->get('/content', ['controller' => 'Content', 'action' => 'index', 'prefix' => 'Admin']);
    $builder->get('/content/edit/{id}', ['controller' => 'Content', 'action' => 'edit', 'prefix' => 'Admin']);
    $builder->post('/content/edit/{id}', ['controller' => 'Content', 'action' => 'edit', 'prefix' => 'Admin']);
    $builder->get('/content/history/{blockId}', ['controller' => 'Content', 'action' => 'history', 'prefix' => 'Admin']);
    $builder->post('/content/restore', ['controller' => 'Content', 'action' => 'restore', 'prefix' => 'Admin']);
    $builder->post('/content/upload-image', ['controller' => 'Content', 'action' => 'uploadImage', 'prefix' => 'Admin']);
});
```

### 6. Servicios

#### ContentService.php

```php
<?php
namespace App\Service;

use Cake\Cache\Cache;
use Cake\ORM\TableRegistry;

class ContentService
{
    /**
     * Obtener contenido completo de una sección
     */
    public function getSectionContent(string $slug): ?array
    {
        $cacheKey = "content_section_{$slug}";
        
        // Intentar obtener del caché
        if ($cached = Cache::read($cacheKey)) {
            return $cached;
        }

        $contentSections = TableRegistry::getTableLocator()->get('ContentSections');
        $section = $contentSections->find()
            ->where(['slug' => $slug, 'is_active' => true])
            ->contain([
                'ContentBlocks' => [
                    'sort' => ['ContentBlocks.sort_order' => 'ASC']
                ],
                'ContentImages'
            ])
            ->first();

        if (!$section) {
            return null;
        }

        $data = $this->_formatSectionContent($section);

        // Guardar en caché por 1 hora
        Cache::write($cacheKey, $data, '1 hour');

        return $data;
    }

    /**
     * Obtener todo el contenido (para Astro build)
     */
    public function getAllSectionsContent(): array
    {
        $cacheKey = 'content_all';
        
        if ($cached = Cache::read($cacheKey)) {
            return $cached;
        }

        $contentSections = TableRegistry::getTableLocator()->get('ContentSections');
        $sections = $contentSections->find()
            ->where(['is_active' => true])
            ->orderBy(['sort_order' => 'ASC'])
            ->contain([
                'ContentBlocks' => ['sort' => ['sort_order' => 'ASC']],
                'ContentImages'
            ])
            ->toArray();

        $data = [];
        foreach ($sections as $section) {
            $data[$section->slug] = $this->_formatSectionContent($section);
        }

        Cache::write($cacheKey, $data, '1 hour');

        return $data;
    }

    /**
     * Formatear contenido de sección para API
     */
    private function _formatSectionContent($section): array
    {
        $blocks = [];

        foreach ($section->content_blocks as $block) {
            $blocks[$block->block_key] = [
                'type' => $block->block_type,
                'content' => $block->content,
                'metadata' => $block->metadata,
            ];
        }

        return [
            'id' => $section->id,
            'slug' => $section->slug,
            'title' => $section->title,
            'metadata' => $section->metadata,
            'blocks' => $blocks,
            'images' => array_map(function($img) {
                return [
                    'id' => $img->id,
                    'url' => $img->file_path,
                    'alt' => $img->alt_text,
                    'dimensions' => $img->dimensions,
                ];
            }, $section->content_images),
        ];
    }
}
```

---

## Panel Administrativo

### Estructura de Vistas

```html
<!-- templates/Admin/Content/index.php -->
<div class="admin-content-list">
    <h1>Administrar Contenido</h1>
    
    <div class="sections-grid">
        <?php foreach ($contentSections as $section): ?>
            <div class="section-card">
                <h3><?= $section->title ?></h3>
                <p><?= $section->description ?></p>
                <div class="card-actions">
                    <a href="<?= $this->Url->build(['action' => 'edit', $section->id]) ?>" 
                       class="btn btn-primary">
                        Editar
                    </a>
                    <a href="<?= $this->Url->build(['action' => 'history', $section->id]) ?>" 
                       class="btn btn-secondary">
                        Historial
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
```

```html
<!-- templates/Admin/Content/edit.php -->
<div class="admin-content-editor">
    <h1>Editar: <?= $section->title ?></h1>
    
    <?= $this->Form->create($section, ['type' => 'post']) ?>
    
    <div class="editor-container">
        <?php foreach ($section->content_blocks as $block): ?>
            <fieldset class="content-block">
                <legend><?= $block->block_key ?></legend>
                
                <?php if ($block->block_type === 'wysiwyg'): ?>
                    <!-- Editor WYSIWYG (TinyMCE, Quill, etc) -->
                    <textarea name="content_blocks[<?= $block->id ?>][content]" 
                              class="wysiwyg-editor">
                        <?= $block->content ?>
                    </textarea>
                
                <?php elseif ($block->block_type === 'textarea'): ?>
                    <textarea name="content_blocks[<?= $block->id ?>][content]" 
                              rows="6" 
                              class="form-control">
                        <?= $block->content ?>
                    </textarea>
                
                <?php elseif ($block->block_type === 'image'): ?>
                    <div class="image-upload">
                        <input type="file" name="image_<?= $block->id ?>" 
                               class="image-input" accept="image/*">
                        <img src="<?= $block->metadata['url'] ?? '#' ?>" 
                             alt="<?= $block->metadata['alt'] ?? '' ?>"
                             class="preview-image">
                    </div>
                
                <?php else: ?>
                    <input type="text" 
                           name="content_blocks[<?= $block->id ?>][content]" 
                           value="<?= $block->content ?>"
                           class="form-control">
                <?php endif; ?>
            </fieldset>
        <?php endforeach; ?>
    </div>
    
    <div class="form-group">
        <label for="change-reason">Motivo del cambio:</label>
        <input type="text" 
               name="reason" 
               id="change-reason" 
               placeholder="Descripción del cambio (opcional)"
               class="form-control">
    </div>
    
    <div class="form-actions">
        <?= $this->Form->button('Guardar Cambios', ['class' => 'btn btn-success']) ?>
        <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>

<script>
    // Inicializar editores WYSIWYG
    document.querySelectorAll('.wysiwyg-editor').forEach(editor => {
        tinymce.init({
            selector: '.wysiwyg-editor',
            plugins: ['link', 'image', 'code'],
            toolbar: 'undo redo | styleselect | bold italic | link image | code'
        });
    });
</script>
```

---

## Frontend Astro

### Estrategia de Carga de Contenido

#### Opción 1: Build-time (Recomendado para SEO)

```astro
// src/pages/index.astro
---
import { getStaticPaths, getStaticProps } from '../api/content';
import Bienvenida from '../components/landing/Bienvenida.astro';

// En build time, obtener todo el contenido
const allContent = await fetch('http://localhost:3000/api/v1/content')
    .then(res => res.json());

// Compartir con componentes
import { setContext } from 'astro:context';
setContext({ content: allContent });
---

<html>
  <head>
    <!-- SEO dinámico basado en metadata -->
    <title>{allContent.bienvenida?.metadata?.seo_title}</title>
    <meta name="description" content={allContent.bienvenida?.metadata?.seo_description} />
    <meta property="og:image" content={allContent.bienvenida?.metadata?.og_image} />
  </head>
  <body>
    <Bienvenida content={allContent.bienvenida} />
  </body>
</html>
```

#### Opción 2: Runtime (Con ISR/Revalidación)

```astro
// src/pages/index.astro
---
import Bienvenida from '../components/landing/Bienvenida.astro';

// En runtime, obtener contenido con caché
let content = null;
try {
    const response = await fetch('http://localhost:3000/api/v1/content/bienvenida', {
        headers: {
            'Cache-Control': 'public, max-age=3600'
        }
    });
    content = await response.json();
} catch (error) {
    console.error('Error loading content:', error);
    // Fallback a contenido estático si la API falla
}
---

<html>
  <head>
    <title>{content?.metadata?.seo_title || 'Jyza Clínica'}</title>
    <meta name="description" content={content?.metadata?.seo_description} />
  </head>
  <body>
    {content ? (
        <Bienvenida content={content} />
    ) : (
        <Bienvenida content={staticFallback} />
    )}
  </body>
</html>
```

### Componente Actualizado: Bienvenida.astro

```astro
---
// src/components/landing/Bienvenida.astro
interface Props {
  content?: {
    blocks: {
      titulo?: { content: string };
      descripcion?: { content: string };
      cta_text?: { content: string };
      cta_url?: { content: string };
      badge_text?: { content: string };
      direccion?: { content: string };
      horario?: { content: string };
    };
    images: Array<{
      id: number;
      url: string;
      alt: string;
    }>;
  };
}

const { content } = Astro.props;

// Datos por defecto (fallback)
const fallback = {
  titulo: 'Tu Salud Femenina en las Mejores Manos de Huánuco',
  descripcion: 'Clínica especializada en ginecología y obstetricia...',
  ctaText: 'Agendar Cita por WhatsApp',
  ctaUrl: 'https://wa.me/51961295024',
  badgeText: 'CITAS DISPONIBLES ESTA SEMANA',
};

// Extraer contenido o usar fallback
const titulo = content?.blocks?.titulo?.content || fallback.titulo;
const descripcion = content?.blocks?.descripcion?.content || fallback.descripcion;
const ctaText = content?.blocks?.cta_text?.content || fallback.ctaText;
const ctaUrl = content?.blocks?.cta_url?.content || fallback.ctaUrl;
const badgeText = content?.blocks?.badge_text?.content || fallback.badgeText;
---

<section class="hero">
  <div class="hero-background">
    <div class="hero-gradient"></div>
    <picture>
      <source media="(max-width: 1024px)" srcset="./herofondot.webp" />
      <img 
        src="./herofondo.webp" 
        alt="Clínica Ginecología Huánuco" 
        loading="eager" 
        width="1920" 
        height="1080" 
      />
    </picture>
  </div>

  <div class="hero-container">
    <!-- Contenido dinámico -->
    <div class="hero-content">
      <div class="hero-badge">
        <span class="badge-icon"></span>
        <span class="badge-text">{badgeText}</span>
      </div>
      
      <h1 class="hero-title" set:html={titulo} />
      
      <p class="hero-description" set:html={descripcion} />
      
      <div class="hero-actions">
        <a href={ctaUrl} class="btn-primary" target="_blank" rel="noopener">
          <img src="iconBtn.webp" alt="icono" width="20" height="20">
          {ctaText}
        </a>
      </div>
    </div>
  </div>
</section>

<style>
  .hero { /* estilos */ }
  .hero-title { /* estilos */ }
  .hero-description { /* estilos */ }
</style>
```

### Hook de Utilidad: useContent.ts

```typescript
// src/hooks/useContent.ts
export interface ContentBlock {
  type: 'text' | 'textarea' | 'wysiwyg' | 'image' | 'video' | 'json';
  content: string;
  metadata?: Record<string, any>;
}

export interface SectionContent {
  id: number;
  slug: string;
  title: string;
  metadata: Record<string, any>;
  blocks: Record<string, ContentBlock>;
  images: Array<{
    id: number;
    url: string;
    alt: string;
    dimensions?: { width: number; height: number };
  }>;
}

/**
 * Obtener contenido de una sección
 */
export async function getSectionContent(
  slug: string,
  baseUrl: string = import.meta.env.PUBLIC_API_URL
): Promise<SectionContent | null> {
  try {
    const response = await fetch(`${baseUrl}/api/v1/content/${slug}`, {
      headers: {
        'Accept': 'application/json',
      },
      // Cache nativo del navegador
      cache: 'default',
    });

    if (!response.ok) {
      console.error(`Error loading content: ${response.status}`);
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error('Error fetching content:', error);
    return null;
  }
}

/**
 * Obtener todo el contenido (para pregenerar en build)
 */
export async function getAllContent(
  baseUrl: string = import.meta.env.PUBLIC_API_URL
): Promise<Record<string, SectionContent> | null> {
  try {
    const response = await fetch(`${baseUrl}/api/v1/content`, {
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      return null;
    }

    return await response.json();
  } catch (error) {
    console.error('Error fetching all content:', error);
    return null;
  }
}

/**
 * Extraer bloque específico
 */
export function getBlockContent(
  content: SectionContent | null,
  blockKey: string,
  fallback: string = ''
): string {
  return content?.blocks?.[blockKey]?.content || fallback;
}

/**
 * Obtener primera imagen
 */
export function getFirstImage(content: SectionContent | null) {
  return content?.images?.[0] || null;
}
```

---

## Escalabilidad

### Agregar Nuevas Secciones

**Sin cambios en base de datos ni código backend.** Solo ejecutar SQL:

```sql
-- 1. Crear sección
INSERT INTO content_sections (slug, title, description, sort_order)
VALUES ('nosotros', 'Quiénes Somos', 'Información sobre la clínica', 2);

-- 2. Agregar bloques
INSERT INTO content_blocks (section_id, block_key, block_type, content)
VALUES 
  (2, 'titulo', 'text', 'Quiénes Somos'),
  (2, 'descripcion', 'wysiwyg', '<p>Contenido aquí...</p>'),
  (2, 'team_count', 'text', '15 Profesionales'),
  (2, 'team_description', 'textarea', 'Descripción del equipo...');
```

### Estructura JSON Flexible

Los bloques pueden ser de cualquier tipo:

```json
{
  "blocks": {
    "titulo": { "type": "text", "content": "..." },
    "descripcion": { "type": "wysiwyg", "content": "..." },
    "equipo": { "type": "json", "content": "[{\"nombre\": \"...\", \"especialidad\": \"...\"}]" },
    "video": { "type": "video", "content": "https://youtube.com/..." },
    "imagen_hero": { "type": "image", "content": "123" }
  }
}
```

---

## Seguridad y Buenas Prácticas

### 1. Autenticación y Autorización

```php
// src/Policy/ContentPolicy.php
<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class ContentPolicy
{
    public function canEdit(IdentityInterface $identity, $resource)
    {
        // Solo admin o editor con permiso específico
        return $identity->rol === 1 || 
               $identity->hasPermission('content.edit');
    }

    public function canPublish(IdentityInterface $identity, $resource)
    {
        return $identity->rol === 1;
    }

    public function canRestore(IdentityInterface $identity, $resource)
    {
        return $identity->rol === 1;
    }
}
```

### 2. Validación de Entrada

```php
// En ContentBlocksTable
public function validationDefault(Validator $validator): Validator
{
    // Sanitizar HTML en campos WYSIWYG
    $validator->add('content', 'sanitize', [
        'rule' => function($value, $context) {
            if ($context['data']['block_type'] === 'wysiwyg') {
                return strip_tags($value, '<p><br><strong><em><ul><li><ol>');
            }
            return true;
        }
    ]);

    // Validar URLs
    $validator->add('content', 'url', [
        'rule' => 'url',
        'message' => 'URL inválida',
        'when' => function($context) {
            return $context['data']['block_type'] === 'video';
        }
    ]);

    return $validator;
}
```

### 3. Rate Limiting (API)

```php
// En AppController
public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);

    // Rate limiting para API
    if ($this->request->getPath() === '/api/v1/content') {
        $ip = $this->request->clientIp();
        $cacheKey = "ratelimit_{$ip}";
        $count = cache($cacheKey) ?? 0;

        if ($count > 100) { // 100 requests por minuto
            throw new \Cake\Http\Exception\TooManyRequestsException();
        }

        cache($cacheKey, $count + 1, '+1 minute');
    }
}
```

### 4. CORS Seguro

```php
// En ContentController
public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);

    $allowedOrigins = [
        'https://jyza.com',
        'https://www.jyza.com',
        'http://localhost:3000', // desarrollo
    ];

    $origin = $this->request->getHeaderLine('Origin');

    if (in_array($origin, $allowedOrigins)) {
        $this->response = $this->response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
            ->withHeader('Access-Control-Max-Age', '3600');
    }
}
```

### 5. Caché Multicapa

```php
// src/Service/CacheService.php
<?php
namespace App\Service;

use Cake\Cache\Cache;

class CacheService
{
    // Caché en capas:
    // 1. Redis (si está disponible) - 1 hora
    // 2. Archivo - 1 hora
    // 3. Navegador/CDN - 1 hora

    public function getCachedContent($key)
    {
        // Intentar Redis primero
        try {
            $cached = Cache::read($key, 'redis');
            if ($cached !== null) {
                return $cached;
            }
        } catch (\Exception $e) {
            // Si falla, continuar con archivo
        }

        // Fallback a archivo
        $cached = Cache::read($key, 'file');
        return $cached;
    }

    public function invalidateSection($slug)
    {
        $key = "content_section_{$slug}";
        Cache::delete($key, 'redis');
        Cache::delete($key, 'file');
        // CDN purge si es necesario
    }
}
```

### 6. Logging y Auditoría

```php
// Registrar todos los cambios
public function edit($id = null)
{
    if ($this->request->is(['post', 'put'])) {
        $userId = $this->Authentication->getIdentity()->id;
        $changes = $this->_getChanges($section, $this->request->getData());

        // Log de auditoría
        $this->getTableLocator()->get('AuditLogs')->save(
            $this->getTableLocator()->get('AuditLogs')->newEntity([
                'entity_type' => 'ContentSection',
                'entity_id' => $id,
                'action' => 'update',
                'user_id' => $userId,
                'changes' => json_encode($changes),
                'ip_address' => $this->request->clientIp(),
            ])
        );
    }
}
```

### 7. SEO

```astro
---
// src/components/SEO.astro
interface Props {
  content: {
    metadata?: {
      seo_title?: string;
      seo_description?: string;
      og_image?: string;
      canonical?: string;
    };
    slug?: string;
  };
}

const { content } = Astro.props;
const title = content?.metadata?.seo_title || 'Jyza Clínica';
const description = content?.metadata?.seo_description || 'Clínica especializada en ginecología...';
const ogImage = content?.metadata?.og_image || '/og-default.png';
const canonical = content?.metadata?.canonical || `https://jyza.com/${content?.slug}`;
---

<head>
  <title>{title}</title>
  <meta name="description" content={description} />
  <meta property="og:title" content={title} />
  <meta property="og:description" content={description} />
  <meta property="og:image" content={ogImage} />
  <meta property="og:type" content="website" />
  <link rel="canonical" href={canonical} />
  <meta name="robots" content="index, follow" />
</head>
```

---

## Resumen de Implementación

### Fase 1: Configuración Base (1-2 días)
1. ✅ Crear tablas en BD
2. ✅ Crear Models, Controllers, Services
3. ✅ Configurar rutas API
4. ✅ Implementar autenticación

### Fase 2: Panel Administrativo (2-3 días)
1. ✅ Vistas de edición
2. ✅ Upload de imágenes
3. ✅ Editor WYSIWYG
4. ✅ Historial de versiones

### Fase 3: Frontend Astro (1-2 días)
1. ✅ Hooks de obtención de datos
2. ✅ Componentes dinámicos
3. ✅ SEO optimizado
4. ✅ Caché y fallbacks

### Fase 4: Optimización (1 día)
1. ✅ Rate limiting
2. ✅ Compresión de imágenes
3. ✅ Monitoreo
4. ✅ Documentación

---

## Conclusión

Esta arquitectura proporciona:

- **Escalabilidad**: Agregar nuevas secciones sin cambios de código
- **Seguridad**: Autenticación, validación, caché
- **Rendimiento**: Múltiples capas de caché, CDN ready
- **Mantenibilidad**: Versionado, auditoría, rollback
- **SEO**: Metadatos dinámicos, sitemap automático
- **Experiencia**: Editor intuitivo, preview en tiempo real

Implementando esta solución, podrás mantener contenido actualizado desde el panel administrativo sin necesidad de redeploys, manteniendo excelente performance y SEO. 🚀

# ✅ Checklist de Implementación

## Preparación
- [ ] Leer completamente `ARQUITECTURA_CMS.md`
- [ ] Leer completamente `GUIA_IMPLEMENTACION.md`
- [ ] Entender la estructura: Backend (CakePHP) + Frontend (Astro) + BD (MySQL)
- [ ] Hacer backup de la BD actual

## Fase 1: Base de Datos (30 minutos)

### 1.1 Crear Tablas
- [ ] Ejecutar migración: `./bin/cake migrations migrate`
- [ ] Verificar tablas creadas: 
  - [ ] `content_sections`
  - [ ] `content_blocks`
  - [ ] `content_versions`
  - [ ] `content_images`
  - [ ] `content_cache`
  - [ ] `audit_logs`

### 1.2 Cargar Datos Iniciales
- [ ] Ejecutar seed: `mysql -u root jyza_autoadministrable < database/seed_content.sql`
- [ ] Verificar en PHPMyAdmin que existen las secciones iniciales

### 1.3 Verificar Datos
```sql
SELECT * FROM content_sections;
SELECT * FROM content_blocks WHERE section_id = 1;
```

## Fase 2: Backend CakePHP (1 hora)

### 2.1 Copiar Archivos

**Models (Table):**
- [ ] `src/Model/Table/ContentSectionsTable.php`
- [ ] `src/Model/Table/ContentBlocksTable.php`
- [ ] `src/Model/Table/ContentVersionsTable.php`
- [ ] `src/Model/Table/ContentImagesTable.php`

**Models (Entity):**
- [ ] `src/Model/Entity/ContentSection.php`
- [ ] `src/Model/Entity/ContentBlock.php`
- [ ] `src/Model/Entity/ContentVersion.php`

**Services:**
- [ ] `src/Service/ContentService.php`
- [ ] `src/Service/ImageService.php`

**Controllers:**
- [ ] `src/Controller/Api/V1/ContentController.php`
- [ ] `src/Controller/Admin/ContentController.php`

### 2.2 Configurar Rutas
- [ ] Abrir `config/routes.php`
- [ ] Agregar rutas de `CONFIG_ROUTES_API.php`
- [ ] Guardar archivo

### 2.3 Crear Directorio de Uploads
```bash
mkdir -p webroot/uploads/content
chmod 755 webroot/uploads/content
```
- [ ] Directorio creado y con permisos correctos

### 2.4 Probar API

Ejecutar en terminal:
```bash
curl http://localhost:3000/api/v1/content/bienvenida
```

Resultado esperado:
```json
{
  "id": 1,
  "slug": "bienvenida",
  "blocks": {...},
  "images": []
}
```

- [ ] API retorna contenido JSON

## Fase 3: Frontend Astro (45 minutos)

### 3.1 Instalar Dependencias
```bash
cd jyza
npm install
```
- [ ] Dependencias instaladas sin errores

### 3.2 Configurar Variables de Entorno
- [ ] Crear `.env.local` en `jyza/`
- [ ] Agregar: `PUBLIC_API_URL=http://localhost:3000`
- [ ] Agregar: `PUBLIC_DEBUG=false`

### 3.3 Copiar Archivos

**Hook:**
- [ ] `src/hooks/useContent.ts`

**Componentes:**
- [ ] Reemplazar `src/components/landing/Bienvenida.astro` con `Bienvenida.astro.nuevo`
- [ ] Reemplazar `src/pages/index.astro` con `index.astro.nuevo`

### 3.4 Probar Localmente
```bash
npm run dev
```
- [ ] Abre `http://localhost:3000`
- [ ] [ ] Página carga sin errores
- [ ] [ ] Contenido aparece dinámicamente
- [ ] [ ] Abre consola (F12) y verifica que no hay errores

### 3.5 Verificar Funcionamiento

En el navegador:
- [ ] Título "Tu Salud Femenina en las Mejores Manos de Huánuco" aparece
- [ ] Badge "CITAS DISPONIBLES ESTA SEMANA" aparece
- [ ] Botones de acción son clickables
- [ ] Información de ubicación y horarios visible
- [ ] Sin errores en consola (F12 > Console)

## Fase 4: Panel Administrativo (1 hora)

### 4.1 Crear Vistas

**Listar secciones:**
- [ ] `templates/Admin/Content/index.php` creado
- [ ] Muestra tabla con secciones

**Editar contenido:**
- [ ] `templates/Admin/Content/edit.php` creado
- [ ] Formulario editable para cada bloque

**Historial:**
- [ ] `templates/Admin/Content/history.php` creado
- [ ] Muestra historial de cambios

### 4.2 Agregar Editor WYSIWYG
- [ ] Incluir TinyMCE o similar en layout
- [ ] Configurar editores para campos WYSIWYG

### 4.3 Probar Panel Admin
```
Acceder a: http://localhost:3000/admin/content
(Necesita estar autenticado como admin)
```

- [ ] Panel carga correctamente
- [ ] Muestra lista de secciones
- [ ] Puedo editar contenido
- [ ] Cambios se guardan en BD

### 4.4 Verificar Cambios en Frontend
1. Editar texto en admin (ej: cambiar título)
2. Guardar
3. Actualizar sitio frontend
4. [ ] Cambio aparece automáticamente

## Fase 5: Testing Completo (30 minutos)

### 5.1 API Testing

**Obtener sección específica:**
```bash
curl http://localhost:3000/api/v1/content/bienvenida
```
- [ ] Retorna JSON válido

**Obtener todo:**
```bash
curl http://localhost:3000/api/v1/content
```
- [ ] Retorna todas las secciones

**CORS:**
```bash
curl -H "Origin: http://localhost:3000" http://localhost:3000/api/v1/content/bienvenida
```
- [ ] Encabezados CORS presentes

### 5.2 Frontend Testing

**Build-time:**
```bash
npm run build
```
- [ ] Build completa sin errores
- [ ] Archivos generados en `dist/`

**Contenido estático:**
```bash
npm run preview
```
- [ ] Contenido precompilado funciona

**Sin API disponible:**
1. Apagar servidor CakePHP
2. Refrescar página Astro
3. [ ] Fallback a contenido por defecto funciona

### 5.3 Performance

- [ ] Cargar en Chrome DevTools > Lighthouse
- [ ] [ ] Score verde en Desktop (>90)
- [ ] [ ] Score verde en Mobile (>80)

### 5.4 SEO

- [ ] Titles dinámicos aparecen
- [ ] Meta descriptions presentes
- [ ] Open Graph tags correctos
- [ ] Canonical links presentes
- [ ] JSON-LD estructurado

## Fase 6: Seguridad (30 minutos)

### 6.1 Autenticación
- [ ] Solo admin puede acceder a `/admin/content`
- [ ] Usuarios no autenticados no pueden editar
- [ ] API pública es read-only

### 6.2 Validación
- [ ] Campos requeridos validados
- [ ] Formatos correctos (URLs, emails, etc)
- [ ] HTML sanitizado en WYSIWYG

### 6.3 Rate Limiting
- [ ] Implementar en API pública
- [ ] Máximo X requests por minuto

### 6.4 CORS
- [ ] Configurado solo para dominios conocidos
- [ ] Métodos limitados (GET, POST, etc)

## Fase 7: Documentación (15 minutos)

- [ ] README.md actualizado
- [ ] Instrucciones de setup claras
- [ ] Variables de entorno documentadas
- [ ] Troubleshooting incluido

## Fase 8: Deployment (depende de tu hosting)

### Si usas Vercel (Astro):
- [ ] Conectar repo a Vercel
- [ ] Configurar PUBLIC_API_URL
- [ ] Deploy automático habilitado

### Si usas Netlify (Astro):
- [ ] Conectar repo a Netlify
- [ ] Build command: `npm run build`
- [ ] Publish directory: `dist`
- [ ] PUBLIC_API_URL configurado

### Backend (CakePHP):
- [ ] Hosting con PHP 8.2+
- [ ] MySQL 8.0+ disponible
- [ ] Ejecutar migraciones en producción
- [ ] Variables de entorno configuradas
- [ ] Caché habilitado para mejor rendimiento

## Testing Post-Deployment

### En Producción
- [ ] API responde desde `https://api.jyza.com`
- [ ] Frontend carga desde `https://jyza.com`
- [ ] Contenido dinámico funciona
- [ ] Admin accesible solo con credenciales
- [ ] Imágenes se sirven desde CDN (si aplica)
- [ ] SSL/HTTPS activos
- [ ] No hay errores en logs

### Verificación Final
```bash
# Backend
curl https://api.jyza.com/api/v1/content/bienvenida

# Frontend
curl https://jyza.com

# Google PageSpeed
https://pagespeed.web.dev/?url=https://jyza.com
```

- [ ] Todo funciona en producción

## Problema? Troubleshooting

### API retorna 404
- [ ] ¿Existen datos en `content_sections`?
- [ ] ¿El slug es correcto?
- [ ] ¿Las rutas están configuradas?
- [ ] Ver: `logs/debug.log`

### Astro no carga contenido
- [ ] ¿PUBLIC_API_URL en .env.local?
- [ ] ¿API backend corriendo?
- [ ] ¿CORS habilitado?
- [ ] Ver: Console del navegador (F12)

### Caché viejo
```bash
./bin/cake cache clear_all
npm run build
```

### Base de datos
- [ ] ¿Conexión a MySQL correcta?
- [ ] ¿Base de datos jyza_autoadministrable existe?
- [ ] Ver: PHPMyAdmin

## Próximos Pasos

Una vez completado:

1. **Agregar más secciones** (Nosotros, Servicios, etc)
   - Usar el mismo patrón que Bienvenida
   - Crear componentes Astro similares
   - No necesitas cambiar código backend

2. **Mejorar Admin** 
   - Agregar drag-drop para reordenar
   - Previsualización en tiempo real
   - Más tipos de campos

3. **Optimizar**
   - Implementar Redis para caché
   - CDN para imágenes
   - Lazy loading avanzado

4. **Monitoreo**
   - Alertas de errores
   - Análisis de rendimiento
   - Logs centralizados

## Checklist Final

- [ ] Base de datos: ✅ Tablas creadas y datos iniciales
- [ ] Backend: ✅ Modelos, servicios, controladores, rutas
- [ ] Frontend: ✅ Componentes, hooks, páginas
- [ ] Admin: ✅ Panel funcional, edición de contenido
- [ ] Testing: ✅ API, frontend, performance, SEO
- [ ] Seguridad: ✅ Autenticación, validación, CORS
- [ ] Documentación: ✅ README, ejemplos, FAQ
- [ ] Deployment: ✅ Producción lista

## 🎉 ¡Listo!

Felicidades! Tu CMS autoadministrable está:
- ✅ Completamente funcional
- ✅ Escalable para futuras secciones
- ✅ Optimizado para SEO
- ✅ Seguro y bien documentado
- ✅ Preparado para producción

**Tiempo total estimado**: 4-5 horas

---

**Última actualización**: Mayo 31, 2026

Para problemas o preguntas, revisa `EJEMPLOS_Y_FAQ.md`

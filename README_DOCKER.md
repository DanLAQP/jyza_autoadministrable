# 🐳 Proyecto JYZA - Dockerizado

Bienvenido. Este proyecto está completamente dockerizado. Todo lo que necesitas (MySQL, CakePHP, Node/Astro) viene en containers Docker.

---

## 🚀 Inicio Rápido (2 minutos)

### Requisito único: Docker Desktop

[Descargar Docker Desktop](https://www.docker.com/products/docker-desktop)

### Iniciar

```bash
# Opción 1: Makefile (RECOMENDADO)
make up

# Opción 2: Docker-compose
docker-compose up -d

# Opción 3: Script (Linux/Mac)
bash docker-start.sh
```

### Acceder

- **Frontend**: http://localhost:4321
- **Backend**: http://localhost:8000
- **Base de datos**: http://localhost:8080 (PhpMyAdmin)

---

## 📚 Documentación

Elige por dónde empezar:

### 👉 Para Impaciosos (5 min)
**Lee**: [`DOCKER_QUICKSTART.md`](DOCKER_QUICKSTART.md)
- Paso a paso visual
- Comandos esenciales
- Solución de problemas rápida

### 🏗️ Para Entender la Arquitectura (10 min)
**Lee**: [`DOCKER_ARCHITECTURE.md`](DOCKER_ARCHITECTURE.md)
- Diagramas ASCII
- Flujo de funcionamiento
- Volúmenes y networking
- Escalabilidad futura

### 📖 Para Guía Completa (30 min)
**Lee**: [`DOCKER.md`](DOCKER.md)
- Todos los servicios detallados
- Todos los comandos
- Configuración avanzada
- Troubleshooting completo

### ⚡ Para Referencia Rápida
**Usa**: [`Makefile`](Makefile)
```bash
make help    # Ver todos los comandos
make up      # Iniciar
make logs    # Ver logs
```

---

## 📦 Qué está Dockerizado

| Componente | Tecnología | Container | Puerto |
|-----------|-----------|-----------|--------|
| Base de Datos | MySQL 8.0 | `jyza-mysql` | 3306 |
| Backend Admin | CakePHP 5 | `jyza-admin` | 8000 |
| Frontend Web | Astro + Node | `jyza-frontend-dev` | 4321 |
| Admin BD | PhpMyAdmin | `jyza-phpmyadmin` | 8080 |

---

## 🗂️ Archivos Docker Creados

### Configuración Principal
- **`docker-compose.yml`** - Orquestra todos los servicios
- **`Makefile`** - Comandos abreviados (recomendado usar)
- **`docker-start.sh`** - Script de inicio automático

### Dockerfiles
- **`jyza_autoadministrable/Dockerfile`** - Imagen de CakePHP
- **`jyza/Dockerfile`** - Imagen de Astro (producción con Nginx)
- **`jyza/Dockerfile.dev`** - Imagen de Astro (desarrollo)

### Variables de Entorno
- **`.env.docker`** - Configuración de desarrollo
- **`.env.docker.production`** - Configuración de producción

### Documentación
- **`DOCKER_QUICKSTART.md`** - ⭐ Empieza aquí
- **`DOCKER.md`** - Guía completa
- **`DOCKER_ARCHITECTURE.md`** - Diagramas y arquitectura
- **`DOCKER_SETUP.txt`** - Resumen de configuración
- **`README_DOCKER.md`** - Este archivo

---

## ⚡ Comandos Esenciales

### Gestión Básica

```bash
make up              # Iniciar servicios
make down            # Parar servicios
make restart         # Reiniciar
make ps              # Ver estado
```

### Logs

```bash
make logs            # Todos los logs
make logs-admin      # Logs del backend
make logs-frontend   # Logs del frontend
```

### Acceso a Containers

```bash
make shell-admin     # Bash en CakePHP
make shell-frontend  # Shell en Astro
make shell-db        # MySQL CLI
```

### Base de Datos

```bash
make backup-db       # Respaldar BD
make restore-db FILE=backups/archivo.sql  # Restaurar
```

---

## 🌐 Accesos

### Local (desde tu navegador)

| Servicio | URL |
|----------|-----|
| Frontend Astro | http://localhost:4321 |
| Backend CakePHP | http://localhost:8000 |
| PhpMyAdmin | http://localhost:8080 |

### Credenciales BD

- **Host**: localhost (desde tu máquina) o `mysql` (desde containers)
- **Puerto**: 3306
- **Usuario**: `jyza_user`
- **Contraseña**: `jyza_password`
- **Base de datos**: `jyza_autoadministrable`

---

## 💾 Datos Persistentes

La base de datos se guarda automáticamente en un volumen Docker llamado `mysql_data`.

```bash
# Los datos persisten incluso después de:
docker-compose down

# Solo se pierden si ejecutas:
docker-compose down -v  # ⚠️ ¡CUIDADO!
```

### Respaldar BD

```bash
# Crear backup
make backup-db
# Genera: backups/jyza_YYYYMMDD_HHMMSS.sql

# Restaurar backup
make restore-db FILE=backups/jyza_20260605_120000.sql
```

---

## 🔄 Desarrollo en Vivo

Los cambios en código se reflejan instantáneamente:

### Frontend (Astro)
```bash
# Los cambios en ./jyza/src aparecen al refrescar
# (El servidor Astro recarga automáticamente)
```

### Backend (CakePHP)
```bash
# Los cambios en ./jyza_autoadministrable aparecen instantáneamente
# (PHP sirve cambios directamente)
```

Si algo no funciona:
```bash
docker-compose restart jyza-frontend-dev
docker-compose restart jyza-admin
```

---

## 🏗️ Arquitectura

```
Tu Máquina
    │
    ├─→ http://localhost:4321    ──→ Astro Frontend
    │                                 ↓ (API calls)
    ├─→ http://localhost:8000    ──→ CakePHP Backend
    │                                 ↓ (queries)
    ├─→ http://localhost:3306    ──→ MySQL DB
    │
    └─→ http://localhost:8080    ──→ PhpMyAdmin

Internamente (Docker Network):
    jyza-frontend-dev → jyza-admin:8000
    jyza-admin → mysql:3306
```

---

## 🚢 Producción

### Cambios necesarios

1. **Actualizar `.env.docker.production`**
   ```env
   DB_PASSWORD=contraseña_segura
   SITE_URL=https://tudominio.com
   DEBUG=false
   ```

2. **Configurar SSL/HTTPS**
   - Usar certificados Let's Encrypt
   - Nginx como reverse proxy

3. **Configurar dominio**
   - Apuntar DNS a tu servidor
   - Configurar firewall

4. **Backups automáticos**
   - Programar `make backup-db` diariamente

---

## ❓ Preguntas Frecuentes

**P: ¿Necesito XAMPP o instalar cosas?**
R: No, Docker lo hace todo automáticamente.

**P: ¿Se pierden los datos?**
R: No, están en un volumen persistente. Más seguro que XAMPP.

**P: ¿Puedo cambiar los puertos?**
R: Sí, edita `docker-compose.yml` en la sección `ports:`.

**P: ¿Es más lento?**
R: No, Docker es muy eficiente. Similar a XAMPP.

**P: ¿Funciona en producción?**
R: Sí, es la forma estándar de desplegar aplicaciones hoy.

**P: ¿Y en otra máquina?**
R: Solo necesita Docker. Funciona igual en Windows, Mac, Linux.

---

## 🆘 Si Algo No Funciona

### 1. Verificar que Docker está corriendo
```bash
docker ps
```

### 2. Ver logs
```bash
docker-compose logs
# O por servicio:
docker-compose logs jyza-admin
```

### 3. Reiniciar servicio específico
```bash
docker-compose restart jyza-admin
docker-compose restart jyza-frontend-dev
docker-compose restart mysql
```

### 4. Limpiar y empezar de cero
```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### 5. Más ayuda
- Leer: [`DOCKER.md`](DOCKER.md) - Sección Troubleshooting
- Ver logs: `docker-compose logs -f`
- Ejecutar: `make help`

---

## 📋 Checklist Antes de Iniciar

- [ ] Docker Desktop instalado y abierto
- [ ] Puerto 3306 libre (o cambiar en docker-compose.yml)
- [ ] Puerto 8000 libre
- [ ] Puerto 4321 libre
- [ ] Puerto 8080 libre

---

## 📚 Referencias

- [Docker Docs](https://docs.docker.com/)
- [Docker Compose Docs](https://docs.docker.com/compose/)
- [CakePHP Docs](https://book.cakephp.org/)
- [Astro Docs](https://docs.astro.build/)

---

## 🎯 Próximos Pasos

1. **Lee** [`DOCKER_QUICKSTART.md`](DOCKER_QUICKSTART.md) (5 min)
2. **Ejecuta** `make up` o `docker-compose up -d`
3. **Abre** http://localhost:4321
4. **Disfruta** desarrollando sin preocupaciones de instalación

---

## 📄 Otros Archivos Importantes

- **`docker-compose.yml`** - Configuración de servicios
- **`Makefile`** - Comandos útiles
- **`DOCKER_QUICKSTART.md`** - Guía rápida
- **`DOCKER.md`** - Documentación completa
- **`DOCKER_ARCHITECTURE.md`** - Diagramas

---

**Última actualización**: 2026-06-05  
**Versión Docker**: 3.8  
**Estado**: ✅ Listo para usar

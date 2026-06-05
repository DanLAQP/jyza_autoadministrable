# 🐳 Guía de Docker - JYZA

Este proyecto está dockerizado completamente. Contiene tres servicios principales:

## 📋 Estructura de Servicios

### 1. **MySQL** (Base de Datos)
- **Container**: `jyza-mysql`
- **Puerto**: 3306
- **Usuario**: `jyza_user`
- **Contraseña**: `jyza_password`
- **Base de Datos**: `jyza_autoadministrable`
- **Volumen**: `mysql_data` (persistente)

### 2. **Backend - CakePHP** (Panel Administrativo)
- **Container**: `jyza-admin`
- **Puerto**: 8000
- **URL**: http://localhost:8000
- **Ruta**: `/jyza_autoadministrable`
- **Volumen**: Montaje en tiempo real para desarrollo

### 3. **Frontend - Astro** (Sitio Público)
- **Container**: `jyza-frontend-dev` (Desarrollo)
- **Container**: `jyza-frontend` (Producción)
- **Puerto Dev**: 4321
- **Puerto Prod**: 5174
- **URLs**:
  - Desarrollo: http://localhost:4321
  - Producción: https://ginecologiajyza.pe

### 4. **PhpMyAdmin** (Administración de BD)
- **Container**: `jyza-phpmyadmin`
- **Puerto**: 8080
- **URL**: http://localhost:8080

---

## 🚀 Inicio Rápido

### Opción 1: Script automático (Linux/Mac)
```bash
bash docker-start.sh
```

### Opción 2: Comandos manuales

#### Construir imágenes
```bash
docker-compose build
```

#### Iniciar todos los servicios
```bash
docker-compose up -d
```

#### Ver logs en tiempo real
```bash
docker-compose logs -f
```

#### Detener servicios
```bash
docker-compose down
```

---

## 📦 Estructura de Archivos Docker

```
jyza_autoadministrable/
├── docker-compose.yml          # Configuración de todos los servicios
├── Dockerfile.dev              # Para desarrollo de Astro
├── .dockerignore               # Archivos a ignorar en Docker
├── .env.docker                 # Variables de entorno (desarrollo)
├── .env.docker.production      # Variables de entorno (producción)
├── DOCKER.md                   # Esta guía
├── docker-start.sh             # Script de inicio
├── jyza/
│   ├── Dockerfile              # Dockerfile de producción (Astro)
│   ├── Dockerfile.dev          # Dockerfile de desarrollo (Astro)
│   ├── .dockerignore
│   └── [proyecto Astro]
├── jyza_autoadministrable/
│   ├── Dockerfile              # Dockerfile de CakePHP
│   ├── .dockerignore
│   └── [proyecto CakePHP]
└── database/
    └── jyza_autoadministrable.sql  # Script de inicialización BD
```

---

## 🔧 Configuración

### Variables de Entorno

**Archivo**: `.env.docker`

```env
# Database
DB_HOST=mysql
DB_PORT=3306
DB_NAME=jyza_autoadministrable
DB_USER=jyza_user
DB_PASSWORD=jyza_password

# Frontend
SITE_URL=http://localhost:4321
API_URL=http://jyza-admin:8000

# Backend
APP_NAME=JYZA
DEBUG=true
```

### Para Producción

Actualiza `.env.docker.production` con:
- URLs de producción
- Contraseñas seguras
- DEBUG=false

---

## 🎯 Comandos Útiles

### Gestión de Servicios

```bash
# Iniciar servicios específicos
docker-compose up -d mysql jyza-admin

# Reiniciar un servicio
docker-compose restart jyza-admin

# Verificar estado de servicios
docker-compose ps

# Eliminar todo (cuidado con datos!)
docker-compose down -v
```

### Acceso a Containers

```bash
# Entrar en el container de CakePHP
docker-compose exec jyza-admin bash

# Entrar en el container de Astro
docker-compose exec jyza-frontend-dev sh

# Entrar en MySQL
docker-compose exec mysql mysql -u jyza_user -p
```

### Logs

```bash
# Ver logs de todos los servicios
docker-compose logs

# Ver logs de un servicio específico
docker-compose logs jyza-admin

# Seguir logs en tiempo real (últimas 50 líneas)
docker-compose logs -f --tail=50 jyza-frontend-dev
```

---

## 💾 Persistencia de Datos

### Base de Datos
- **Volumen**: `mysql_data`
- Los datos persisten incluso si eliminas los containers
- **Ubicación en host**: `/var/lib/docker/volumes/jyza-mysql/_data`

### Para respaldar la BD:
```bash
docker-compose exec mysql mysqldump -u jyza_user -p jyza_autoadministrable > backup.sql
```

### Para restaurar:
```bash
docker-compose exec -T mysql mysql -u jyza_user -p jyza_autoadministrable < backup.sql
```

---

## 🌐 Configuración de Red

Los servicios se comunican a través de la red `jyza_network`:
- `jyza-admin` puede acceder a `mysql` como `mysql:3306`
- `jyza-frontend-dev` puede acceder a `jyza-admin` como `jyza-admin:8000`

### Desde tu máquina local:
- MySQL: `localhost:3306`
- Backend: `localhost:8000`
- Frontend: `localhost:4321`
- PhpMyAdmin: `localhost:8080`

---

## 🔐 Seguridad en Producción

### Cambios necesarios antes de desplegar:

1. **Actualizar contraseñas** en `.env.docker.production`
2. **Cambiar `DEBUG=false`** en CakePHP
3. **Usar HTTPS** con certificados SSL
4. **No exponer puertos de BD** públicamente
5. **Usar secrets de Docker** en lugar de variables de entorno

---

## 🐛 Troubleshooting

### "Connection refused" en el frontend
**Problema**: El frontend no puede conectar con el backend
**Solución**: 
```bash
docker-compose ps  # Verificar que jyza-admin esté corriendo
docker-compose logs jyza-admin  # Ver errores del backend
```

### Puerto ya está en uso
```bash
# En Windows
netstat -ano | findstr :4321
taskkill /PID <PID> /F

# En Linux/Mac
lsof -i :4321
kill -9 <PID>
```

### MySQL no inicia
```bash
# Verificar logs
docker-compose logs mysql

# Reiniciar y limpiar
docker-compose down -v
docker-compose up -d mysql
```

### Cambios en código no se reflejan
**Solución**: Los volúmenes están configurados, pero a veces necesitas:
```bash
docker-compose restart jyza-frontend-dev
```

---

## 📚 Recursos Adicionales

- [Docker Docs](https://docs.docker.com/)
- [Docker Compose Docs](https://docs.docker.com/compose/)
- [Astro Docs](https://docs.astro.build/)
- [CakePHP Docs](https://book.cakephp.org/)

---

## 👥 Soporte

Si tienes problemas:
1. Verifica que Docker Desktop esté corriendo
2. Revisa los logs: `docker-compose logs`
3. Reconstruye las imágenes: `docker-compose build --no-cache`
4. Limpia todo y empieza de cero: `docker-compose down -v && docker-compose up -d`

---

**Última actualización**: 2026-06-05

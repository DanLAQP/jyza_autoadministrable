# 🚀 Docker Quick Start - JYZA

## ¿Qué es Docker?

Docker empaqueta tu aplicación con todas sus dependencias en **containers** aislados. En lugar de instalar MySQL, PHP, Node en tu máquina, Docker lo hace automáticamente en containers.

---

## 📦 ¿Qué está dockerizado?

| Servicio | Stack | Container | Puerto |
|----------|-------|-----------|--------|
| **Base de Datos** | MySQL 8.0 | `jyza-mysql` | 3306 |
| **Backend Admin** | CakePHP 5 | `jyza-admin` | 8000 |
| **Frontend Web** | Astro + Node | `jyza-frontend-dev` | 4321 |
| **Admin BD** | PhpMyAdmin | `jyza-phpmyadmin` | 8080 |

---

## ⚡ Inicio en 3 pasos

### 1️⃣ Verificar Docker está instalado

```bash
docker --version
docker-compose --version
```

Si no lo tienes: [Descargar Docker Desktop](https://www.docker.com/products/docker-desktop)

### 2️⃣ Iniciar servicios

```bash
# En la carpeta raíz del proyecto
docker-compose up -d

# O si prefieres ver los logs
docker-compose up
```

### 3️⃣ Acceder a los servicios

Abre en tu navegador:
- **Frontend**: http://localhost:4321
- **Backend Admin**: http://localhost:8000
- **Base de Datos**: http://localhost:8080 (PhpMyAdmin)

---

## 🎯 Primeros pasos

### Verificar que todo funciona

```bash
# Ver estado de los servicios
docker-compose ps

# Debería mostrar 4 servicios "Up"
```

### Explorar los containers

```bash
# Entrar en MySQL y ejecutar comandos SQL
docker-compose exec mysql mysql -u jyza_user -p
# Contraseña: jyza_password

# Entrar en el backend
docker-compose exec jyza-admin bash

# Ver logs del frontend
docker-compose logs -f jyza-frontend-dev
```

### Gestionar la BD desde UI

Abre: http://localhost:8080
- Usuario: `jyza_user`
- Contraseña: `jyza_password`
- Base de datos: `jyza_autoadministrable`

---

## 📝 Archivos Clave

```
Proyecto/
├── docker-compose.yml       ← Configuración principal
├── DOCKER.md               ← Guía completa
├── DOCKER_ARCHITECTURE.md  ← Diagramas y arquitectura
├── Makefile                ← Comandos abreviados
├── .env.docker             ← Variables de desarrollo
├── .env.docker.production  ← Variables de producción
│
├── jyza_autoadministrable/
│   ├── Dockerfile          ← Imagen de CakePHP
│   └── .dockerignore
│
├── jyza/
│   ├── Dockerfile          ← Imagen de Astro (prod)
│   ├── Dockerfile.dev      ← Imagen de Astro (dev)
│   └── .dockerignore
│
└── database/
    └── jyza_autoadministrable.sql  ← Script inicial BD
```

---

## 🛠️ Comandos Comunes

### Con Makefile (Recomendado)

```bash
make up              # Iniciar servicios
make down            # Parar servicios
make restart         # Reiniciar
make logs            # Ver logs
make shell-admin     # Acceso a CakePHP
make logs-frontend   # Logs del frontend
make backup-db       # Respaldar BD
```

### Sin Makefile (docker-compose directo)

```bash
docker-compose up -d                      # Iniciar
docker-compose down                       # Parar
docker-compose logs -f                    # Logs
docker-compose exec jyza-admin bash       # Acceso
docker-compose restart jyza-frontend-dev  # Reiniciar un servicio
docker-compose ps                         # Estado
```

---

## 💾 Datos Persistentes

### Base de Datos
Los datos en MySQL se guardan en el volumen `mysql_data` y **persisten aunque borres los containers**.

```bash
# Ver volúmenes
docker volume ls

# Limpiar TODO (incluyendo datos!) - ⚠️ CUIDADO
docker-compose down -v
```

### Respaldar BD
```bash
docker-compose exec mysql mysqldump -u jyza_user -p jyza_autoadministrable > backup.sql
```

### Restaurar BD
```bash
docker-compose exec -T mysql mysql -u jyza_user -p jyza_autoadministrable < backup.sql
```

---

## 🔗 URLs Importantes

| Servicio | URL | Credenciales |
|----------|-----|--------------|
| Frontend | http://localhost:4321 | — |
| Backend Admin | http://localhost:8000 | Tus usuarios CakePHP |
| PhpMyAdmin | http://localhost:8080 | `jyza_user` / `jyza_password` |
| MySQL | localhost:3306 | `jyza_user` / `jyza_password` |

---

## 🐛 Solucionar Problemas

### "Connection refused" en frontend
```bash
docker-compose logs jyza-admin  # Ver errores del backend
docker-compose restart jyza-admin
```

### Puerto en uso
```bash
# Linux/Mac
lsof -i :4321
kill -9 <PID>

# Windows
netstat -ano | findstr :4321
taskkill /PID <PID> /F
```

### MySQL no inicia
```bash
docker-compose down -v  # Limpia datos
docker-compose up -d mysql
docker-compose logs mysql
```

### Cambios en código no aparecen
```bash
docker-compose restart jyza-frontend-dev
# O reconstruir todo
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

---

## 🚢 Pasar a Producción

1. **Actualizar `.env.docker.production`**
   ```env
   DEBUG=false
   DB_PASSWORD=contraseña_super_segura
   SITE_URL=https://ginecologiajyza.pe
   ```

2. **Reconstruir con variables de producción**
   ```bash
   docker-compose --env-file .env.docker.production up -d
   ```

3. **Configurar dominio y SSL**
   - Apuntar DNS a tu servidor
   - Usar Nginx como reverse proxy
   - Certificados SSL (Let's Encrypt)

---

## 📚 Más Documentación

- **Guía completa**: Ver `DOCKER.md`
- **Arquitectura**: Ver `DOCKER_ARCHITECTURE.md`
- **Help Makefile**: `make help`

---

## ✨ Tips Útiles

```bash
# Reconstruir una imagen específica
docker-compose build jyza-admin

# Ver uso de recursos
docker stats

# Ejecutar comando en container sin entrar
docker-compose exec jyza-admin ls -la

# Seguir logs en tiempo real
docker-compose logs -f jyza-frontend-dev

# Eliminar imágenes sin usar
docker image prune

# Limpiar todo (containers, networks, etc.)
docker system prune -a
```

---

## 🎓 Conceptos Clave

- **Image**: Plantilla, como un "programa instalable"
- **Container**: Instancia en ejecución de una image
- **Volume**: Almacenamiento persistente
- **Network**: Conexión entre containers
- **docker-compose**: Orquesta múltiples containers

---

## ❓ Preguntas Frecuentes

**P: ¿Necesito instalar MySQL en mi máquina?**
R: No, Docker lo instala en el container.

**P: ¿Se pierden los datos cuando apago los servicios?**
R: No, están en el volumen `mysql_data`.

**P: ¿Puedo cambiar puertos?**
R: Sí, en `docker-compose.yml` donde dice `"8000:8000"`.

**P: ¿Es más lento que XAMPP?**
R: Muy similar, Docker es bastante eficiente.

**P: ¿Puedo usar esto en producción?**
R: Sí, pero con configuraciones de seguridad adicionales.

---

**Última actualización**: 2026-06-05
**Versión Docker Compose**: 3.8

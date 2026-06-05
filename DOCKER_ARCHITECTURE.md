# 🏗️ Arquitectura Docker - JYZA

## 📐 Diagrama de la Arquitectura

```
┌─────────────────────────────────────────────────────────────────┐
│                         TU MÁQUINA LOCAL                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │          DOCKER NETWORK: jyza_network                    │  │
│  │                                                           │  │
│  │  ┌─────────────────┐  ┌──────────────┐  ┌────────────┐  │  │
│  │  │  MYSQL:3306     │  │ CAKEPHP:8000 │  │ ASTRO:4321 │  │  │
│  │  │  (jyza-mysql)   │  │(jyza-admin)  │  │ (jyza-fe)  │  │  │
│  │  │                 │  │              │  │            │  │  │
│  │  │ ┌─────────────┐ │  │ ┌──────────┐ │  │ ┌────────┐ │  │  │
│  │  │ │ jyza_auto   │ │  │ │ Panel    │ │  │ │ Sitio  │ │  │  │
│  │  │ │ ministra    │ │  │ │ Admin    │ │  │ │ Público│ │  │  │
│  │  │ │ ble         │ │  │ │          │ │  │ │        │ │  │  │
│  │  │ └─────────────┘ │  │ └──────────┘ │  │ └────────┘ │  │  │
│  │  │                 │  │              │  │            │  │  │
│  │  │ Volumen:        │  │ Volumen:     │  │ Volumen:   │  │  │
│  │  │ mysql_data      │  │ /var/www/app │  │ /app       │  │  │
│  │  └─────────────────┘  └──────────────┘  └────────────┘  │  │
│  │         ▲                    │              │             │  │
│  │         │    Conexión BD     │              │             │  │
│  │         └────────────────────┘              │             │  │
│  │                                    API Connection          │  │
│  │                                    (http://jyza-admin:80) │  │
│  │                                             │             │  │
│  │         ┌─────────────────────────────────┘             │  │
│  │         │                                               │  │
│  │  ┌──────▼──────────┐                                   │  │
│  │  │ PHPMYADMIN:8080 │                                   │  │
│  │  │  (jyza-phpmyadmin)                                  │  │
│  │  │                 │                                   │  │
│  │  │  Admin BD       │                                   │  │
│  │  └─────────────────┘                                   │  │
│  │                                                           │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Puertos mapeados a tu máquina:                                │
│  ├── http://localhost:3306    (MySQL)                         │
│  ├── http://localhost:8000    (CakePHP Admin)                 │
│  ├── http://localhost:4321    (Astro Frontend)                │
│  └── http://localhost:8080    (PhpMyAdmin)                    │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Flujo de Comunicación

### Desarrollo Local

```
Usuario (Browser)
    │
    ├─→ http://localhost:4321
    │   ↓
    │   ┌─────────────────────┐
    │   │ Frontend (Astro)    │
    │   │ npm run dev         │
    │   └──────┬──────────────┘
    │          │
    │          │ API Request
    │          ├─→ http://jyza-admin:8000/api/...
    │          │   ↓
    │          │ ┌────────────────────────┐
    │          │ │ Backend (CakePHP)      │
    │          │ │ php -S 0.0.0.0:8000    │
    │          │ └─────────┬──────────────┘
    │          │           │
    │          │           │ Query DB
    │          │           ├─→ mysql:3306
    │          │           │   ↓
    │          │           │ ┌──────────────┐
    │          │           │ │ MySQL DB     │
    │          │           │ └──────────────┘
    │          │           │   ↓ Respuesta
    │          │ ←─────────┘
    │          │ Response JSON
    │ ←────────┘
    │
    ├─→ http://localhost:8000
    │   ↓
    │   ┌─────────────────────┐
    │   │ Admin Panel         │
    │   │ CakePHP             │
    │   └─────────────────────┘
    │
    └─→ http://localhost:8080
        ↓
        ┌─────────────────────┐
        │ PhpMyAdmin          │
        │ Manage DB           │
        └─────────────────────┘
```

### Producción (con Nginx)

```
Visitante (Browser)
    │
    ├─→ https://ginecologiajyza.pe
    │   ↓
    │   ┌──────────────┐
    │   │ Nginx        │
    │   │ (Frontend)   │
    │   └──────┬───────┘
    │          │ Serve Static
    │          ├─→ dist/ (HTML, CSS, JS)
    │          │
    │          │ API calls
    │          ├─→ https://api.ginecologiajyza.pe
    │          │   ↓
    │          │ ┌────────────────────┐
    │          │ │ Backend (CakePHP)  │
    │          │ │ (en otro servidor) │
    │          │ └────────────────────┘
    │
    └─→ https://api.ginecologiajyza.pe
        ↓
        ┌────────────────────┐
        │ CakePHP Backend    │
        │ (production)       │
        └────────────────────┘
```

---

## 📦 Volúmenes y Persistencia

```
LOCAL FILESYSTEM                    DOCKER CONTAINERS

jyza_autoadministrable/
├── database/                       MySQL Container
│   └── jyza_autoadministrable.sql → /docker-entrypoint-initdb.d/
│
├── jyza_autoadministrable/         CakePHP Container
│   ├── src/                        → /var/www/app/
│   ├── webroot/
│   ├── config/
│   └── ...
│
└── jyza/                           Astro Container
    ├── src/                        → /app/
    ├── public/
    ├── package.json
    └── ...

VOLÚMENES PERSISTENTES:
mysql_data                          MySQL Data
└── Ubicación: /var/lib/docker/volumes/mysql_data/_data
```

---

## 🔌 Puertos y Mapeo

```
Puerto Local → Container  │  Servicio
─────────────────────────┼──────────────────
3306         → 3306      │  MySQL
8000         → 8000      │  CakePHP (Dev)
4321         → 4321      │  Astro (Dev)
5174         → 5174      │  Nginx (Prod)
8080         → 80        │  PhpMyAdmin
```

---

## 🌐 Red Docker (jyza_network)

Los containers se comunican por nombre de container:

```
jyza-frontend-dev → http://jyza-admin:8000/api/...
                 └→ Resuelve automáticamente a 172.XX.X.X

jyza-admin → mysql:3306
          └→ Resuelve automáticamente a 172.XX.X.X
```

---

## 📊 Ciclo de Vida

### Startup (Inicio)

```
1. docker-compose up -d
   │
   ├─→ Crear network jyza_network
   │
   ├─→ Crear y iniciar jyza-mysql
   │   └─→ Ejecutar init.sql (crear tabla, datos)
   │   └─→ Volumen mysql_data se vincula
   │
   ├─→ Crear y iniciar jyza-admin (depende de mysql)
   │   └─→ composer install (si no existe vendor/)
   │   └─→ php -S 0.0.0.0:8000
   │
   └─→ Crear e iniciar jyza-frontend-dev
       └─→ npm install (si no existe node_modules/)
       └─→ npm run dev --host
```

### Shutdown (Parada)

```
1. docker-compose down
   │
   ├─→ Detener containers
   ├─→ Remover containers
   ├─→ Remover red
   │
   └─→ Volúmenes persisten (a menos que uses -v)
```

---

## 🔐 Variables de Entorno

```
.env.docker (DESARROLLO)
├── DB_HOST=mysql (resuelto en red Docker)
├── DB_USER=jyza_user
├── DB_PASSWORD=jyza_password
├── API_URL=http://jyza-admin:8000
└── SITE_URL=http://localhost:4321

.env.docker.production (PRODUCCIÓN)
├── DB_HOST=db.servidor.com
├── DB_USER=usuario_seguro
├── DB_PASSWORD=contraseña_segura
├── API_URL=https://api.ginecologiajyza.pe
└── SITE_URL=https://ginecologiajyza.pe
```

---

## 🚀 Escalabilidad

### Actual (Single Server)

```
Todo en un servidor:
┌────────────────────────────────┐
│      Un servidor Docker        │
├────────────────────────────────┤
│ MySQL  │ CakePHP  │ Astro      │
└────────────────────────────────┘
```

### Futura (Multi-Server)

```
Posible configuración escalada:
┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
│  DB Server       │  │ Backend Server   │  │ Frontend Server  │
├──────────────────┤  ├──────────────────┤  ├──────────────────┤
│ MySQL Cluster    │  │ CakePHP + Nginx  │  │ Astro + Nginx    │
│ Replicación      │  │ Load Balancer    │  │ CDN              │
└──────────────────┘  └──────────────────┘  └──────────────────┘
         ▲                    ▲                      ▲
         └────────────────────┴──────────────────────┘
         Comunicación interna con SSL/TLS
```

---

## 📈 Recursos

### Requerimientos mínimos

- **RAM**: 4 GB
- **CPU**: 2 cores
- **Disk**: 10 GB (incluyendo volúmenes)

### Recomendado para producción

- **RAM**: 8 GB
- **CPU**: 4 cores
- **Disk**: 50 GB SSD
- **Ancho de banda**: 100 Mbps+

---

## 🔄 Actualización de Servicios

```
Cambiar versión de MySQL:
1. Editar docker-compose.yml: mysql:8.0 → mysql:8.1
2. docker-compose down
3. docker-compose up -d mysql
```

---

**Creado**: 2026-06-05

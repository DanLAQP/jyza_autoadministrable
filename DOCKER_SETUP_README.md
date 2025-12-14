# CIFAA Docker MySQL Setup

## 🐳 Docker Configuration Completed

This project has been successfully migrated from XAMPP MySQL to **Docker MySQL 8.0** to replace the corrupted database.

---

## 📋 System Overview

### **Containers Running**
- **MySQL 8.0**: Port `3307` (to avoid conflict with XAMPP)
- **phpMyAdmin**: Port `8080` (Web UI for database management)

### **Database Credentials**
- **Database Name**: `cifaa`
- **Host**: `localhost:3307`
- **Username**: `cifaa_user`
- **Password**: `cifaa_pass`
- **Root Password**: `rootpass` (for phpMyAdmin)

---

## 🔐 Test User Credentials

### **Administrator**
- Username: `admin`
- Password: `admin`
- Role: `1` (Administrator)
- DNI: `12345678`

### **Docente (Teacher)**
- Username: `docente`
- Password: `docente`
- Role: `2` (Teacher)
- DNI: `87654321`

### **Estudiante (Student)**
- Username: `estudiante`
- Password: `estudiante`
- Role: `3` (Student)
- DNI: `11223344`

---

## 🗃️ Database Schema

### **Tables Created** ✅
All tables with applied migrations:

1. **users** - User accounts with roles (admin/docente/estudiante)
2. **cursos** - Courses created by teachers
3. **modulos** - Course modules
4. **lecciones** - Module lessons
5. **contenidos_leccion** - Lesson contents (text/video/pdf)
6. **inscripciones** - Student enrollments (pendiente/aprobada/rechazada)
7. **certificados** - Course completion certificates with PDF storage
8. **sessions** - CakePHP session storage
9. **phinxlog** - Migration tracking

### **Applied Migrations** ✅
- `20251208071001` - AddStatusToInscripciones
- `20251212051347` - AddDniToUsers
- `20251212053233` - CreateCertificados
- `20251214003559` - AddArchivoPdfToCertificados

---

## 🚀 Quick Start Commands

### **Start Docker Services**
```powershell
cd c:\xampp\htdocs\cifa_cake\plantillaCake
docker-compose up -d
```

### **Stop Docker Services**
```powershell
docker-compose down
```

### **View Container Status**
```powershell
docker ps
```

### **View MySQL Logs**
```powershell
docker logs cifaa_mysql
```

### **Access MySQL CLI**
```powershell
docker exec -it cifaa_mysql mysql -ucifaa_user -pcifaa_pass cifaa
```

---

## 🌐 Access Points

### **CakePHP Application**
```
http://localhost/cifa_cake/plantillaCake/cifaa/
```

### **phpMyAdmin (Database GUI)**
```
http://localhost:8080
```
- Server: `mysql`
- Username: `root`
- Password: `rootpass`

---

## 📦 Sample Data Included

### **Courses**
1. **Introducción a Python** - Basic Python course
2. **Java para Principiantes** - Java fundamentals

### **Modules & Lessons**
- Python course has 2 modules with 4 lessons
- Sample lesson contents (text and video types)

### **Enrollments**
- Student `estudiante` enrolled in Python course (approved, 25% progress)
- Student `estudiante` pending enrollment in Java course

---

## 🔧 Configuration Files

### **docker-compose.yml**
Defines MySQL 8.0 and phpMyAdmin containers with networking and volumes.

### **database/init/01_schema.sql**
Complete database schema with all migrations applied:
- All table structures
- Foreign key constraints
- Indexes for performance

### **database/init/02_data.sql**
Initial data:
- 3 test users (admin, docente, estudiante)
- 2 sample courses
- Sample modules, lessons, and contents
- Migration tracking records

### **config/app_local.php**
Updated database connection:
- Port changed from `3306` to `3307`
- Credentials updated to Docker MySQL user

---

## ⚠️ Important Notes

### **File Uploads**
All existing file uploads in `webroot/uploads/` are preserved:
- `uploads/cursos/` - Course thumbnail images
- `uploads/lecciones/` - Lesson content files
- `uploads/certificados/` - Generated certificate PDFs

### **Security Salt**
The original security salt is **preserved** to maintain password compatibility:
```
d6607c6e6128ded59627bf3cedec3ec49c3191ef235d61df7f61ce612cca2535
```

### **Port Conflict**
Docker MySQL uses port `3307` to avoid conflict with XAMPP's MySQL on `3306`.

### **Data Persistence**
MySQL data is stored in Docker volume `plantillacake_mysql_data` for persistence across container restarts.

---

## 🧪 Verification Steps

### **1. Check Containers Running**
```powershell
docker ps
```
Should show `cifaa_mysql` and `cifaa_phpmyadmin` containers.

### **2. Verify Database Tables**
```powershell
docker exec cifaa_mysql mysql -ucifaa_user -pcifaa_pass cifaa -e "SHOW TABLES;"
```

### **3. Verify Test Users**
```powershell
docker exec cifaa_mysql mysql -ucifaa_user -pcifaa_pass cifaa -e "SELECT id, username, rol FROM users;"
```

### **4. Test Login**
Navigate to: `http://localhost/cifa_cake/plantillaCake/cifaa/users/login`
- Try logging in with: `admin` / `admin`
- Try logging in with: `docente` / `docente`
- Try logging in with: `estudiante` / `estudiante`

---

## 🐛 Troubleshooting

### **Docker Not Starting**
```powershell
# Start Docker Desktop manually
Start-Process "C:\Program Files\Docker\Docker\Docker Desktop.exe"
# Wait 30 seconds, then start containers
docker-compose up -d
```

### **Port Already in Use**
If port 3307 or 8080 is taken, edit `docker-compose.yml`:
```yaml
ports:
  - "3308:3306"  # Change 3307 to 3308
  - "8081:80"    # Change 8080 to 8081
```
Then update `config/app_local.php` to match.

### **Can't Connect to Database**
```powershell
# Check if MySQL is ready
docker logs cifaa_mysql | Select-String "ready for connections"
# Restart containers if needed
docker-compose restart
```

### **Lost Data After Reboot**
Docker volumes persist data. To completely reset:
```powershell
docker-compose down -v  # WARNING: Deletes all data
docker-compose up -d
```

---

## 📝 Next Steps

1. ✅ Docker containers are running
2. ✅ Database schema created with all migrations
3. ✅ Test users created with simple passwords
4. ✅ Sample course data loaded
5. 🔄 Test login functionality through web browser
6. 🔄 Verify certificate generation still works
7. 🔄 Test admin matriculation feature
8. 🔄 Verify file uploads work correctly

---

## 🎯 Migration Summary

### **What Was Changed**
- ✅ Created Docker Compose configuration
- ✅ Generated fresh database with corrected schema
- ✅ Applied all 4 migrations from code
- ✅ Created 3 test users with simple passwords (admin/admin, etc.)
- ✅ Updated CakePHP config to use Docker MySQL (port 3307)
- ✅ Preserved security salt for password compatibility
- ✅ Loaded sample course data for testing

### **What Was Preserved**
- ✅ All file uploads in `webroot/uploads/`
- ✅ Security salt for existing password hashes
- ✅ Complete database structure with foreign keys
- ✅ All migrations tracked in phinxlog
- ✅ CakePHP configuration files

---

**🎉 Docker MySQL migration completed successfully!**

**Database Status**: ✅ Running on `localhost:3307`  
**phpMyAdmin**: ✅ Available at `http://localhost:8080`  
**Test Users**: ✅ admin/admin, docente/docente, estudiante/estudiante

You can now access the application and test all functionality with the new Docker database.

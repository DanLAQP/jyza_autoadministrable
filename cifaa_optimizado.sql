-- ========================================
-- CIFAA - Base de Datos Limpia para XAMPP
-- Exportado desde Docker: 2025-12-13 22:33:50
-- Compatible con: MySQL 5.7+ / MariaDB 10.3+
-- Codificación: UTF-8 (utf8mb4_unicode_ci)
-- Caracteres especiales corregidos
-- ========================================

-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: cifaa
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `certificados`
--

DROP TABLE IF EXISTS `certificados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `curso_id` int NOT NULL,
  `horas` int NOT NULL DEFAULT '0',
  `fecha_emision` date NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `archivo_pdf` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Ruta relativa del archivo PDF (uploads/certificados/...)',
  `estado` enum('activo','anulado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'activo' COMMENT 'activo (valido) o anulado (revocado)',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_certificados_codigo` (`codigo`),
  KEY `idx_certificados_user_id` (`user_id`),
  KEY `idx_certificados_curso_id` (`curso_id`),
  KEY `idx_certificados_estado` (`estado`),
  CONSTRAINT `certificados_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `certificados_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificados`
--

LOCK TABLES `certificados` WRITE;
/*!40000 ALTER TABLE `certificados` DISABLE KEYS */;
INSERT INTO `certificados` (`id`, `user_id`, `curso_id`, `horas`, `fecha_emision`, `codigo`, `archivo_pdf`, `estado`, `created`, `modified`) VALUES (1,3,4,40,'2025-12-13','CER-2025-0003-0004-E1FDDE','uploads\\certificados\\certificado_CER-2025-0003-0004-E1FDDE.pdf','activo','2025-12-13 21:10:51','2025-12-13 21:10:51');
/*!40000 ALTER TABLE `certificados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenidos_leccion`
--

DROP TABLE IF EXISTS `contenidos_leccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contenidos_leccion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `leccion_id` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'texto/video/pdf',
  `contenido` text COLLATE utf8mb4_general_ci,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Ruta relativa de archivo (uploads/...)',
  `posicion` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `leccion_id` (`leccion_id`),
  CONSTRAINT `contenidos_leccion_ibfk_1` FOREIGN KEY (`leccion_id`) REFERENCES `lecciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenidos_leccion`
--

LOCK TABLES `contenidos_leccion` WRITE;
/*!40000 ALTER TABLE `contenidos_leccion` DISABLE KEYS */;
INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES (1,1,'texto','<h2>Qué es Python?</h2><p>Python es un lenguaje de programación de alto nivel, interpretado y de propósito general. Fue creado por Guido van Rossum en 1991.</p><h3>Características principales:</h3><ul><li>Sintaxis simple y legible</li><li>Multiparadigma (orientado a objetos, funcional, imperativo)</li><li>Gran cantidad de librerías</li><li>Comunidad activa y soporte</li></ul>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(2,2,'texto','<h2>Instalación de Python</h2><p>Para comenzar a programar en Python, necesitas instalarlo en tu sistema operativo.</p><h3>Windows:</h3><ol><li>Descarga desde python.org</li><li>Ejecuta el instalador</li><li>Marca \"Add Python to PATH\"</li><li>Click en Install Now</li></ol><h3>Verificar instalación:</h3><code>python --version</code>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(3,3,'texto','<h2>Hola Mundo!</h2><p>El tradicional primer programa:</p><pre><code>print(\"Hola Mundo!\")</code></pre><p>Este simple comando imprime un mensaje en pantalla.</p>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(4,4,'texto','<h2>Variables</h2><p>Una variable es un contenedor para almacenar datos.</p><pre><code>nombre = \"Juan\"\nedad = 25\naltura = 1.75</code></pre><p>Python asigna automáticamente el tipo de dato.</p>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(5,5,'texto','<h2>Números</h2><p>Python maneja diferentes tipos numéricos:</p><ul><li><strong>int:</strong> Números enteros (10, -5, 0)</li><li><strong>float:</strong> Números decimales (3.14, -2.5)</li><li><strong>complex:</strong> Números complejos (1+2j)</li></ul><h3>Operaciones:</h3><pre><code>suma = 5 + 3\nresta = 10 - 4\nmultiplicacion = 6 * 7\ndivision = 20 / 4</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(6,6,'texto','<h2>Strings (Cadenas)</h2><p>Las cadenas son secuencias de caracteres:</p><pre><code>texto = \"Hola Python\"\nmultilinea = \"\"\"Este es\nun texto\nmultilinea\"\"\"</code></pre><h3>Operaciones con strings:</h3><pre><code>concatenar = \"Hola\" + \" \" + \"Mundo\"\nrepetir = \"Python \" * 3\nmayusculas = texto.upper()</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(7,7,'texto','<h2>Estructura Básica HTML</h2><p>Todo documento HTML tiene la siguiente estructura:</p><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html lang=\"es\"&gt;\n&lt;head&gt;\n  &lt;meta charset=\"UTF-8\"&gt;\n  &lt;title&gt;Mi Página&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n  &lt;h1&gt;Hola Mundo!&lt;/h1&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(8,8,'texto','<h2>Etiquetas Esenciales</h2><h3>Encabezados:</h3><pre><code>&lt;h1&gt;Título Principal&lt;/h1&gt;\n&lt;h2&gt;Subtítulo&lt;/h2&gt;</code></pre><h3>Párrafos e imágenes:</h3><pre><code>&lt;p&gt;Este es un párrafo&lt;/p&gt;\n&lt;img src=\"imagen.jpg\" alt=\"Descripción\"&gt;</code></pre><h3>Enlaces:</h3><pre><code>&lt;a href=\"https://ejemplo.com\"&gt;Click aquí&lt;/a&gt;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(9,9,'texto','<h2>Formularios</h2><p>Los formularios permiten capturar información del usuario:</p><pre><code>&lt;form action=\"/enviar\" method=\"post\"&gt;\n  &lt;label&gt;Nombre:&lt;/label&gt;\n  &lt;input type=\"text\" name=\"nombre\"&gt;\n  \n  &lt;label&gt;Email:&lt;/label&gt;\n  &lt;input type=\"email\" name=\"email\"&gt;\n  \n  &lt;button type=\"submit\"&gt;Enviar&lt;/button&gt;\n&lt;/form&gt;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(10,10,'texto','<h2>Selectores CSS</h2><h3>Selector de elemento:</h3><pre><code>p { color: blue; }</code></pre><h3>Selector de clase:</h3><pre><code>.destacado { font-weight: bold; }</code></pre><h3>Selector de ID:</h3><pre><code>#titulo { font-size: 24px; }</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(11,11,'texto','<h2>Box Model</h2><p>Todo elemento HTML es una caja con:</p><ul><li><strong>Content:</strong> El contenido</li><li><strong>Padding:</strong> Espacio interno</li><li><strong>Border:</strong> Borde</li><li><strong>Margin:</strong> Espacio externo</li></ul><pre><code>.caja {\n  width: 300px;\n  padding: 20px;\n  border: 2px solid black;\n  margin: 10px;\n}</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(12,12,'texto','<h2>Flexbox</h2><p>Sistema de diseño flexible para layouts:</p><pre><code>.contenedor {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  gap: 20px;\n}</code></pre><h3>Grid Layout:</h3><pre><code>.grid {\n  display: grid;\n  grid-template-columns: 1fr 1fr 1fr;\n  gap: 10px;\n}</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(13,13,'texto','<h2>Qué es Java?</h2><p>Java es un lenguaje de programación orientado a objetos, desarrollado por Sun Microsystems en 1995.</p><h3>Características:</h3><ul><li>Multiplataforma (Write Once, Run Anywhere)</li><li>Orientado a Objetos</li><li>Robusto y Seguro</li><li>Alto rendimiento</li></ul><h3>Primer programa:</h3><pre><code>public class HolaMundo {\n  public static void main(String[] args) {\n    System.out.println(\"Hola Mundo!\");\n  }\n}</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(14,14,'texto','<h2>Variables en Java</h2><p>Java es un lenguaje fuertemente tipado:</p><pre><code>int edad = 25;\ndouble precio = 19.99;\nString nombre = \"Juan\";\nboolean activo = true;</code></pre><h3>Tipos primitivos:</h3><ul><li>byte, short, int, long</li><li>float, double</li><li>char</li><li>boolean</li></ul>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(15,15,'texto','<h2>Estructuras de Control</h2><h3>Condicionales:</h3><pre><code>if (edad >= 18) {\n  System.out.println(\"Mayor de edad\");\n} else {\n  System.out.println(\"Menor de edad\");\n}</code></pre><h3>Bucles:</h3><pre><code>for (int i = 0; i &lt; 10; i++) {\n  System.out.println(i);\n}\n\nwhile (contador &lt; 5) {\n  contador++;\n}</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(16,16,'texto','<h2>Clases y Objetos</h2><p>Una clase es un molde para crear objetos:</p><pre><code>public class Persona {\n  private String nombre;\n  private int edad;\n  \n  public Persona(String nombre, int edad) {\n    this.nombre = nombre;\n    this.edad = edad;\n  }\n  \n  public void saludar() {\n    System.out.println(\"Hola, soy \" + nombre);\n  }\n}</code></pre><h3>Crear objetos:</h3><pre><code>Persona p1 = new Persona(\"Ana\", 30);\np1.saludar();</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(17,17,'texto','<h2>Herencia</h2><p>Permite crear clases basadas en otras:</p><pre><code>public class Estudiante extends Persona {\n  private String carrera;\n  \n  public Estudiante(String nombre, int edad, String carrera) {\n    super(nombre, edad);\n    this.carrera = carrera;\n  }\n}</code></pre><h3>Polimorfismo:</h3><p>Un objeto puede tomar muchas formas:</p><pre><code>Persona p = new Estudiante(\"Luis\", 20, \"Ingeniería\");</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(18,18,'texto','<h2>Interfaces</h2><p>Definen un contrato que las clases deben cumplir:</p><pre><code>public interface Dibujable {\n  void dibujar();\n  void borrar();\n}\n\npublic class Circulo implements Dibujable {\n  public void dibujar() {\n    System.out.println(\"Dibujando círculo\");\n  }\n  \n  public void borrar() {\n    System.out.println(\"Borrando círculo\");\n  }\n}</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(19,19,'texto','<h2>Qué es una Base de Datos?</h2><p>Una base de datos es una colección organizada de información estructurada.</p><h3>MySQL</h3><p>Sistema de gestión de bases de datos relacional más popular del mundo.</p><h3>Crear una base de datos:</h3><pre><code>CREATE DATABASE mi_empresa;\nUSE mi_empresa;</code></pre><h3>Crear una tabla:</h3><pre><code>CREATE TABLE empleados (\n  id INT PRIMARY KEY AUTO_INCREMENT,\n  nombre VARCHAR(100),\n  edad INT,\n  salario DECIMAL(10,2)\n);</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(20,20,'texto','<h2>CRUD: Create, Read, Update, Delete</h2><h3>INSERT (Crear):</h3><pre><code>INSERT INTO empleados (nombre, edad, salario)\nVALUES (\"Juan Pérez\", 30, 3500.00);</code></pre><h3>SELECT (Leer):</h3><pre><code>SELECT * FROM empleados;</code></pre><h3>UPDATE (Actualizar):</h3><pre><code>UPDATE empleados\nSET salario = 4000.00\nWHERE id = 1;</code></pre><h3>DELETE (Eliminar):</h3><pre><code>DELETE FROM empleados WHERE id = 1;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(21,21,'texto','<h2>Filtros y Ordenamiento</h2><h3>WHERE (Filtrar):</h3><pre><code>SELECT * FROM empleados\nWHERE edad &gt; 25;</code></pre><h3>ORDER BY (Ordenar):</h3><pre><code>SELECT * FROM empleados\nORDER BY salario DESC;</code></pre><h3>LIMIT (Limitar):</h3><pre><code>SELECT * FROM empleados\nLIMIT 10;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(22,22,'texto','<h2>JOINS</h2><p>Permiten combinar datos de múltiples tablas:</p><h3>INNER JOIN:</h3><pre><code>SELECT e.nombre, d.nombre AS departamento\nFROM empleados e\nINNER JOIN departamentos d ON e.depto_id = d.id;</code></pre><h3>LEFT JOIN:</h3><pre><code>SELECT e.nombre, d.nombre\nFROM empleados e\nLEFT JOIN departamentos d ON e.depto_id = d.id;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(23,23,'texto','<h2>Funciones de Agregación</h2><h3>COUNT:</h3><pre><code>SELECT COUNT(*) FROM empleados;</code></pre><h3>SUM, AVG:</h3><pre><code>SELECT SUM(salario), AVG(salario)\nFROM empleados;</code></pre><h3>GROUP BY:</h3><pre><code>SELECT depto_id, COUNT(*) as total\nFROM empleados\nGROUP BY depto_id;</code></pre><h3>HAVING:</h3><pre><code>SELECT depto_id, AVG(salario)\nFROM empleados\nGROUP BY depto_id\nHAVING AVG(salario) &gt; 3000;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(24,24,'texto','<h2>Triggers</h2><p>Código que se ejecuta automáticamente:</p><pre><code>CREATE TRIGGER antes_insertar\nBEFORE INSERT ON empleados\nFOR EACH ROW\nBEGIN\n  SET NEW.fecha_registro = NOW();\nEND;</code></pre><h3>Procedimientos Almacenados:</h3><pre><code>DELIMITER //\nCREATE PROCEDURE aumentar_salario(IN emp_id INT, IN porcentaje DECIMAL)\nBEGIN\n  UPDATE empleados\n  SET salario = salario * (1 + porcentaje/100)\n  WHERE id = emp_id;\nEND//\nDELIMITER ;</code></pre>',NULL,1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(25,25,'imagen','imagen de arreglos con objetos combinado s','uploads/contenidos_leccion/1765680472_693e255872958.png',1,'2025-12-13 21:47:52','2025-12-13 21:47:52'),(26,26,'imagen','python mid sera dictado por admin 011','uploads/contenidos_leccion/1765680706_693e264267e20.png',1,'2025-12-13 21:51:46','2025-12-13 21:51:46');
/*!40000 ALTER TABLE `contenidos_leccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cursos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL COMMENT 'ID del docente creador',
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `miniatura` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Ruta relativa de imagen (uploads/...)',
  `nivel` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'basico/intermedio/avanzado',
  `categoria` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'borrador' COMMENT 'borrador/publicado',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursos`
--

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES (1,2,'Python desde Cero','Aprende Python desde los fundamentos hasta proyectos reales. Incluye programación orientada a objetos, manejo de archivos y bases de datos.','uploads/cursos/python.jpg','basico','Programaci├│n','activo','2025-12-14 01:39:27','2025-12-14 01:39:27'),(2,2,'Desarrollo Web: HTML & CSS','Domina los fundamentos del desarrollo web frontend. Aprende a crear sitios web modernos y responsivos con HTML5 y CSS3.','uploads/cursos/html.png','basico','Desarrollo Web','activo','2025-12-14 01:39:27','2025-12-14 01:39:27'),(3,2,'Java: Programaci├│n Orientada a Objetos','Aprende Java desde los fundamentos hasta la POO avanzada. Incluye herencia, polimorfismo, interfaces y patrones de diseño.','uploads/cursos/java.png','intermedio','Programaci├│n','activo','2025-12-14 01:39:27','2025-12-14 01:39:27'),(4,2,'Bases de Datos: MySQL Avanzado','Domina MySQL desde lo básico hasta consultas avanzadas. Incluye diseño de BD, normalización, joins, triggers y procedimientos almacenados.','uploads/cursos/1765676802_693e170221ce7.png','intermedio','Bases de Datos','activo','2025-12-14 01:39:27','2025-12-13 20:46:42'),(5,1,'c++ expertos','c+= avanzado ','uploads/cursos/1765680776_693e268820533.png','intermedio','curso c++ bajo nivel','activo','2025-12-13 21:52:56','2025-12-13 21:52:56');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripciones`
--

DROP TABLE IF EXISTS `inscripciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `curso_id` int NOT NULL,
  `progreso` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente' COMMENT 'pendiente/aprobada/rechazada',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `curso_id` (`curso_id`),
  CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripciones`
--

LOCK TABLES `inscripciones` WRITE;
/*!40000 ALTER TABLE `inscripciones` DISABLE KEYS */;
INSERT INTO `inscripciones` (`id`, `usuario_id`, `curso_id`, `progreso`, `created`, `modified`, `estado`) VALUES (3,3,1,100,'2025-12-14 01:39:27','2025-12-13 20:53:15','aprobada'),(4,3,2,0,'2025-12-14 01:39:27','2025-12-13 20:53:21','aprobada'),(5,3,3,0,'2025-12-13 21:03:22','2025-12-13 21:03:22','aprobada'),(6,3,4,0,'2025-12-13 21:05:31','2025-12-13 21:05:31','aprobada');
/*!40000 ALTER TABLE `inscripciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecciones`
--

DROP TABLE IF EXISTS `lecciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `modulo_id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_contenido` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'texto' COMMENT 'texto/video/pdf',
  `posicion` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `modulo_id` (`modulo_id`),
  CONSTRAINT `lecciones_ibfk_1` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecciones`
--

LOCK TABLES `lecciones` WRITE;
/*!40000 ALTER TABLE `lecciones` DISABLE KEYS */;
INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES (1,1,'Lecci├│n 1: Qué├⌐ es Python?','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(2,1,'Lecci├│n 2: Instalaci├│n y configuraci├│n','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(3,1,'Lección 3: Mi primer programa','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(4,2,'Lecci├│n 1: Variables en Python','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(5,2,'Lecci├│n 2: N├║meros y operaciones','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(6,2,'Lección 3: Cadenas de texto (strings)','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(7,3,'Lecci├│n 1: Estructura HTML','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(8,3,'Lección 2: Etiquetas esenciales','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(9,3,'Lección 3: Formularios HTML','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(10,4,'Lecci├│n 1: Selectores CSS','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(11,4,'Lección 2: Box Model (Modelo de Caja)','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(12,4,'Lección 3: Flexbox y Grid','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(13,5,'Lecci├│n 1: Introducci├│n a Java','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(14,5,'Lección 2: Variables y tipos de datos','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(15,5,'Lección 3: Estructuras de control','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(16,6,'Lección 1: Clases y Objetos','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(17,6,'Lección 2: Herencia y Polimorfismo','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(18,6,'Lección 3: Interfaces y Abstracción','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(19,7,'Lecci├│n 1: Introducci├│n a las Bases de Datos','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(20,7,'Lección 2: Operaciones CRUD básicas','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(21,7,'Lección 3: Consultas con WHERE y ORDER BY','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(22,8,'Lección 1: JOINS y Relaciones','texto',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(23,8,'Lección 2: Funciones de Agregación','texto',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(24,8,'Lección 3: Triggers y Procedimientos','texto',3,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(25,2,'Manejo de objetos con arreglos','texto',4,'2025-12-13 21:46:34','2025-12-13 21:46:34'),(26,9,'iniciando con interfaces python mid','texto',1,'2025-12-13 21:51:17','2025-12-13 21:51:17');
/*!40000 ALTER TABLE `lecciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `curso_id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `posicion` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `curso_id` (`curso_id`),
  CONSTRAINT `modulos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES (1,1,'M├│dulo 1: Introducci├│n a Python',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(2,1,'M├│dulo 2: Variables y Tipos de Datos',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(3,2,'M├│dulo 1: HTML B├ísico',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(4,2,'M├│dulo 2: CSS - Dise├▒o y Estilos',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(5,3,'M├│dulo 1: Fundamentos de Java',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(6,3,'M├│dulo 2: POO -  Programaci├│n Orientada a Objetos',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(7,4,'M├│dulo 1: SQL B├ísico',1,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(8,4,'M├│dulo 2: SQL Avanzado',2,'2025-12-14 01:39:27','2025-12-14 01:39:27'),(9,1,'modulo 3 : python nivel medio',3,'2025-12-13 21:50:57','2025-12-13 21:50:57');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phinxlog`
--

DROP TABLE IF EXISTS `phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phinxlog` (
  `version` bigint NOT NULL,
  `migration_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phinxlog`
--

LOCK TABLES `phinxlog` WRITE;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20251208071001,'AddStatusToInscripciones','2025-12-14 01:25:05','2025-12-14 01:25:05',0),(20251212051347,'AddDniToUsers','2025-12-14 01:25:05','2025-12-14 01:25:05',0),(20251212053233,'CreateCertificados','2025-12-14 01:25:05','2025-12-14 01:25:05',0),(20251214003559,'AddArchivoPdfToCertificados','2025-12-14 01:25:05','2025-12-14 01:25:05',0);
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data` text COLLATE utf8mb4_general_ci,
  `expires` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES ('cuvbd0ki5hs2kt170g9th8nn4o','Config|a:1:{s:4:\"time\";i:1765680938;}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:8:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:60:\"$2y$10$7YmxNmus7fSjss9NmwPQL.Sf1aBML7q/gbpGaJaLc1SjZ6AeWXzAy\";s:3:\"rol\";i:1;s:3:\"dni\";s:8:\"12345678\";s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:8:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:3:\"dni\";i:5;s:7:\"created\";i:6;s:8:\"modified\";i:7;s:6:\"estado\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:7:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:3:\"dni\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}Flash|a:0:{}',1765695338),('vtnghqo5e6fmev34jukaea56q1','Config|a:1:{s:4:\"time\";i:1765678450;}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:8:{s:2:\"id\";i:3;s:8:\"username\";s:10:\"estudiante\";s:8:\"password\";s:60:\"$2y$10$oAAQDI6qdwbbFvQSKCuH3./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe\";s:3:\"rol\";i:3;s:3:\"dni\";s:8:\"11223344\";s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:8:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:3:\"dni\";i:5;s:7:\"created\";i:6;s:8:\"modified\";i:7;s:6:\"estado\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:7:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:3:\"dni\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}',1765692850);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` int NOT NULL COMMENT '1=admin, 2=docente, 3=estudiante',
  `dni` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00000000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'activo' COMMENT 'activo/inactivo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `rol`, `dni`, `created`, `modified`, `estado`) VALUES (1,'admin','$2y$10$7YmxNmus7fSjss9NmwPQL.Sf1aBML7q/gbpGaJaLc1SjZ6AeWXzAy',1,'12345678','2025-12-14 01:25:05','2025-12-14 01:25:05','activo'),(2,'docente','$2y$10$/kr1QKqxna.AI20AOL/TxOxLhC5DjlntVwJ524vKI1.FCwwCbKIv6',2,'87654321','2025-12-14 01:25:05','2025-12-14 01:25:05','activo'),(3,'estudiante','$2y$10$oAAQDI6qdwbbFvQSKCuH3./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe',3,'11223344','2025-12-14 01:25:05','2025-12-14 01:25:05','activo'),(4,'juan_perez','\\./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe',3,'12345678','2025-12-14 01:55:12','2025-12-14 01:55:12','activo'),(5,'maria_lopez','\\./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe',3,'87654321','2025-12-14 01:55:12','2025-12-14 01:55:12','activo'),(6,'carlos_ruiz','\\./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe',3,'45678901','2025-12-14 01:55:12','2025-12-14 01:55:12','activo'),(7,'ana_garcia','\\./9VAeoAv7Oi0dgnAWlEPFS.zR9o9zPe',3,'23456789','2025-12-14 01:55:12','2025-12-14 01:55:12','activo');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-14  3:32:44

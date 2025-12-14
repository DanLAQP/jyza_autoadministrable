-- ============================================
-- DATOS COMPLETOS: 4 CURSOS CON TODO SU CONTENIDO
-- Estructura: Cursos -> Módulos -> Lecciones -> Contenidos
-- Codificación UTF-8 para caracteres especiales
-- ============================================

SET NAMES utf8mb4;
SET CHARACTER_SET_CLIENT = utf8mb4;
SET CHARACTER_SET_CONNECTION = utf8mb4;
SET CHARACTER_SET_RESULTS = utf8mb4;

-- Limpiar datos previos (mantener estructura intacta)
DELETE FROM contenidos_leccion;
DELETE FROM lecciones;
DELETE FROM modulos;
DELETE FROM cursos;

-- ============================================
-- CURSO 1: PYTHON DESDE CERO
-- ============================================
INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES
(1, 2, 'Python desde Cero', 'Aprende Python desde los fundamentos hasta proyectos reales. Incluye programación orientada a objetos, manejo de archivos y bases de datos.', 'uploads/cursos/python.jpg', 'basico', 'Programación', 'publicado', NOW(), NOW());

-- Módulo 1: Introducción a Python
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'Módulo 1: Introducción a Python', 1, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'Lección 1: ¿Qué es Python?', 'texto', 1, NOW(), NOW()),
(2, 1, 'Lección 2: Instalación y configuración', 'texto', 2, NOW(), NOW()),
(3, 1, 'Lección 3: Mi primer programa', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(1, 1, 'texto', '<h2>¿Qué es Python?</h2><p>Python es un lenguaje de programación de alto nivel, interpretado y de propósito general. Fue creado por Guido van Rossum en 1991.</p><h3>Características principales:</h3><ul><li>Sintaxis simple y legible</li><li>Multiparadigma (orientado a objetos, funcional, imperativo)</li><li>Gran cantidad de librerías</li><li>Comunidad activa y soporte</li></ul>', NULL, 1, NOW(), NOW()),
(2, 2, 'texto', '<h2>Instalación de Python</h2><p>Para comenzar a programar en Python, necesitas instalarlo en tu sistema operativo.</p><h3>Windows:</h3><ol><li>Descarga desde python.org</li><li>Ejecuta el instalador</li><li>Marca "Add Python to PATH"</li><li>Click en Install Now</li></ol><h3>Verificar instalación:</h3><code>python --version</code>', NULL, 1, NOW(), NOW()),
(3, 3, 'texto', '<h2>¡Hola Mundo!</h2><p>El tradicional primer programa:</p><pre><code>print("¡Hola Mundo!")</code></pre><p>Este simple comando imprime un mensaje en pantalla.</p>', NULL, 1, NOW(), NOW());

-- Módulo 2: Variables y Tipos de Datos
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(2, 1, 'Módulo 2: Variables y Tipos de Datos', 2, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(4, 2, 'Lección 1: Variables en Python', 'texto', 1, NOW(), NOW()),
(5, 2, 'Lección 2: Números y operaciones', 'texto', 2, NOW(), NOW()),
(6, 2, 'Lección 3: Cadenas de texto (strings)', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(4, 4, 'texto', '<h2>Variables</h2><p>Una variable es un contenedor para almacenar datos.</p><pre><code>nombre = "Juan"\nedad = 25\naltura = 1.75</code></pre><p>Python asigna automáticamente el tipo de dato.</p>', NULL, 1, NOW(), NOW()),
(5, 5, 'texto', '<h2>Números</h2><p>Python maneja diferentes tipos numéricos:</p><ul><li><strong>int:</strong> Números enteros (10, -5, 0)</li><li><strong>float:</strong> Números decimales (3.14, -2.5)</li><li><strong>complex:</strong> Números complejos (1+2j)</li></ul><h3>Operaciones:</h3><pre><code>suma = 5 + 3\nresta = 10 - 4\nmultiplicacion = 6 * 7\ndivision = 20 / 4</code></pre>', NULL, 1, NOW(), NOW()),
(6, 6, 'texto', '<h2>Strings (Cadenas)</h2><p>Las cadenas son secuencias de caracteres:</p><pre><code>texto = "Hola Python"\nmultilinea = """Este es\nun texto\nmultilinea"""</code></pre><h3>Operaciones con strings:</h3><pre><code>concatenar = "Hola" + " " + "Mundo"\nrepetir = "Python " * 3\nmayusculas = texto.upper()</code></pre>', NULL, 1, NOW(), NOW());

-- ============================================
-- CURSO 2: DESARROLLO WEB HTML & CSS
-- ============================================
INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES
(2, 2, 'Desarrollo Web: HTML & CSS', 'Domina los fundamentos del desarrollo web frontend. Aprende a crear sitios web modernos y responsivos con HTML5 y CSS3.', 'uploads/cursos/html.png', 'basico', 'Desarrollo Web', 'publicado', NOW(), NOW());

-- Módulo 1: HTML Básico
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(3, 2, 'Módulo 1: HTML Básico', 1, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(7, 3, 'Lección 1: Estructura HTML', 'texto', 1, NOW(), NOW()),
(8, 3, 'Lección 2: Etiquetas esenciales', 'texto', 2, NOW(), NOW()),
(9, 3, 'Lección 3: Formularios HTML', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(7, 7, 'texto', '<h2>Estructura Básica HTML</h2><p>Todo documento HTML tiene la siguiente estructura:</p><pre><code>&lt;!DOCTYPE html&gt;\n&lt;html lang="es"&gt;\n&lt;head&gt;\n  &lt;meta charset="UTF-8"&gt;\n  &lt;title&gt;Mi Página&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n  &lt;h1&gt;¡Hola Mundo!&lt;/h1&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre>', NULL, 1, NOW(), NOW()),
(8, 8, 'texto', '<h2>Etiquetas Esenciales</h2><h3>Encabezados:</h3><pre><code>&lt;h1&gt;Título Principal&lt;/h1&gt;\n&lt;h2&gt;Subtítulo&lt;/h2&gt;</code></pre><h3>Párrafos e imágenes:</h3><pre><code>&lt;p&gt;Este es un párrafo&lt;/p&gt;\n&lt;img src="imagen.jpg" alt="Descripción"&gt;</code></pre><h3>Enlaces:</h3><pre><code>&lt;a href="https://ejemplo.com"&gt;Click aquí&lt;/a&gt;</code></pre>', NULL, 1, NOW(), NOW()),
(9, 9, 'texto', '<h2>Formularios</h2><p>Los formularios permiten capturar información del usuario:</p><pre><code>&lt;form action="/enviar" method="post"&gt;\n  &lt;label&gt;Nombre:&lt;/label&gt;\n  &lt;input type="text" name="nombre"&gt;\n  \n  &lt;label&gt;Email:&lt;/label&gt;\n  &lt;input type="email" name="email"&gt;\n  \n  &lt;button type="submit"&gt;Enviar&lt;/button&gt;\n&lt;/form&gt;</code></pre>', NULL, 1, NOW(), NOW());

-- Módulo 2: CSS Estilos
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(4, 2, 'Módulo 2: CSS - Diseño y Estilos', 2, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(10, 4, 'Lección 1: Selectores CSS', 'texto', 1, NOW(), NOW()),
(11, 4, 'Lección 2: Box Model (Modelo de Caja)', 'texto', 2, NOW(), NOW()),
(12, 4, 'Lección 3: Flexbox y Grid', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(10, 10, 'texto', '<h2>Selectores CSS</h2><h3>Selector de elemento:</h3><pre><code>p { color: blue; }</code></pre><h3>Selector de clase:</h3><pre><code>.destacado { font-weight: bold; }</code></pre><h3>Selector de ID:</h3><pre><code>#titulo { font-size: 24px; }</code></pre>', NULL, 1, NOW(), NOW()),
(11, 11, 'texto', '<h2>Box Model</h2><p>Todo elemento HTML es una caja con:</p><ul><li><strong>Content:</strong> El contenido</li><li><strong>Padding:</strong> Espacio interno</li><li><strong>Border:</strong> Borde</li><li><strong>Margin:</strong> Espacio externo</li></ul><pre><code>.caja {\n  width: 300px;\n  padding: 20px;\n  border: 2px solid black;\n  margin: 10px;\n}</code></pre>', NULL, 1, NOW(), NOW()),
(12, 12, 'texto', '<h2>Flexbox</h2><p>Sistema de diseño flexible para layouts:</p><pre><code>.contenedor {\n  display: flex;\n  justify-content: center;\n  align-items: center;\n  gap: 20px;\n}</code></pre><h3>Grid Layout:</h3><pre><code>.grid {\n  display: grid;\n  grid-template-columns: 1fr 1fr 1fr;\n  gap: 10px;\n}</code></pre>', NULL, 1, NOW(), NOW());

-- ============================================
-- CURSO 3: JAVA PROGRAMACIÓN ORIENTADA A OBJETOS
-- ============================================
INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES
(3, 2, 'Java: Programación Orientada a Objetos', 'Aprende Java desde los fundamentos hasta la POO avanzada. Incluye herencia, polimorfismo, interfaces y patrones de diseño.', 'uploads/cursos/java.png', 'intermedio', 'Programación', 'publicado', NOW(), NOW());

-- Módulo 1: Fundamentos de Java
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(5, 3, 'Módulo 1: Fundamentos de Java', 1, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(13, 5, 'Lección 1: Introducción a Java', 'texto', 1, NOW(), NOW()),
(14, 5, 'Lección 2: Variables y tipos de datos', 'texto', 2, NOW(), NOW()),
(15, 5, 'Lección 3: Estructuras de control', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(13, 13, 'texto', '<h2>¿Qué es Java?</h2><p>Java es un lenguaje de programación orientado a objetos, desarrollado por Sun Microsystems en 1995.</p><h3>Características:</h3><ul><li>Multiplataforma (Write Once, Run Anywhere)</li><li>Orientado a Objetos</li><li>Robusto y Seguro</li><li>Alto rendimiento</li></ul><h3>Primer programa:</h3><pre><code>public class HolaMundo {\n  public static void main(String[] args) {\n    System.out.println("¡Hola Mundo!");\n  }\n}</code></pre>', NULL, 1, NOW(), NOW()),
(14, 14, 'texto', '<h2>Variables en Java</h2><p>Java es un lenguaje fuertemente tipado:</p><pre><code>int edad = 25;\ndouble precio = 19.99;\nString nombre = "Juan";\nboolean activo = true;</code></pre><h3>Tipos primitivos:</h3><ul><li>byte, short, int, long</li><li>float, double</li><li>char</li><li>boolean</li></ul>', NULL, 1, NOW(), NOW()),
(15, 15, 'texto', '<h2>Estructuras de Control</h2><h3>Condicionales:</h3><pre><code>if (edad >= 18) {\n  System.out.println("Mayor de edad");\n} else {\n  System.out.println("Menor de edad");\n}</code></pre><h3>Bucles:</h3><pre><code>for (int i = 0; i &lt; 10; i++) {\n  System.out.println(i);\n}\n\nwhile (contador &lt; 5) {\n  contador++;\n}</code></pre>', NULL, 1, NOW(), NOW());

-- Módulo 2: Programación Orientada a Objetos
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(6, 3, 'Módulo 2: POO - Programación Orientada a Objetos', 2, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(16, 6, 'Lección 1: Clases y Objetos', 'texto', 1, NOW(), NOW()),
(17, 6, 'Lección 2: Herencia y Polimorfismo', 'texto', 2, NOW(), NOW()),
(18, 6, 'Lección 3: Interfaces y Abstracción', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(16, 16, 'texto', '<h2>Clases y Objetos</h2><p>Una clase es un molde para crear objetos:</p><pre><code>public class Persona {\n  private String nombre;\n  private int edad;\n  \n  public Persona(String nombre, int edad) {\n    this.nombre = nombre;\n    this.edad = edad;\n  }\n  \n  public void saludar() {\n    System.out.println("Hola, soy " + nombre);\n  }\n}</code></pre><h3>Crear objetos:</h3><pre><code>Persona p1 = new Persona("Ana", 30);\np1.saludar();</code></pre>', NULL, 1, NOW(), NOW()),
(17, 17, 'texto', '<h2>Herencia</h2><p>Permite crear clases basadas en otras:</p><pre><code>public class Estudiante extends Persona {\n  private String carrera;\n  \n  public Estudiante(String nombre, int edad, String carrera) {\n    super(nombre, edad);\n    this.carrera = carrera;\n  }\n}</code></pre><h3>Polimorfismo:</h3><p>Un objeto puede tomar muchas formas:</p><pre><code>Persona p = new Estudiante("Luis", 20, "Ingeniería");</code></pre>', NULL, 1, NOW(), NOW()),
(18, 18, 'texto', '<h2>Interfaces</h2><p>Definen un contrato que las clases deben cumplir:</p><pre><code>public interface Dibujable {\n  void dibujar();\n  void borrar();\n}\n\npublic class Circulo implements Dibujable {\n  public void dibujar() {\n    System.out.println("Dibujando círculo");\n  }\n  \n  public void borrar() {\n    System.out.println("Borrando círculo");\n  }\n}</code></pre>', NULL, 1, NOW(), NOW());

-- ============================================
-- CURSO 4: BASES DE DATOS CON MySQL
-- ============================================
INSERT INTO `cursos` (`id`, `usuario_id`, `titulo`, `descripcion`, `miniatura`, `nivel`, `categoria`, `estado`, `created`, `modified`) VALUES
(4, 2, 'Bases de Datos: MySQL Avanzado', 'Domina MySQL desde lo básico hasta consultas avanzadas. Incluye diseño de BD, normalización, joins, triggers y procedimientos almacenados.', 'uploads/cursos/bd.jpg', 'intermedio', 'Bases de Datos', 'publicado', NOW(), NOW());

-- Módulo 1: SQL Básico
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(7, 4, 'Módulo 1: SQL Básico', 1, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(19, 7, 'Lección 1: Introducción a las Bases de Datos', 'texto', 1, NOW(), NOW()),
(20, 7, 'Lección 2: Operaciones CRUD básicas', 'texto', 2, NOW(), NOW()),
(21, 7, 'Lección 3: Consultas con WHERE y ORDER BY', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(19, 19, 'texto', '<h2>¿Qué es una Base de Datos?</h2><p>Una base de datos es una colección organizada de información estructurada.</p><h3>MySQL</h3><p>Sistema de gestión de bases de datos relacional más popular del mundo.</p><h3>Crear una base de datos:</h3><pre><code>CREATE DATABASE mi_empresa;\nUSE mi_empresa;</code></pre><h3>Crear una tabla:</h3><pre><code>CREATE TABLE empleados (\n  id INT PRIMARY KEY AUTO_INCREMENT,\n  nombre VARCHAR(100),\n  edad INT,\n  salario DECIMAL(10,2)\n);</code></pre>', NULL, 1, NOW(), NOW()),
(20, 20, 'texto', '<h2>CRUD: Create, Read, Update, Delete</h2><h3>INSERT (Crear):</h3><pre><code>INSERT INTO empleados (nombre, edad, salario)\nVALUES ("Juan Pérez", 30, 3500.00);</code></pre><h3>SELECT (Leer):</h3><pre><code>SELECT * FROM empleados;</code></pre><h3>UPDATE (Actualizar):</h3><pre><code>UPDATE empleados\nSET salario = 4000.00\nWHERE id = 1;</code></pre><h3>DELETE (Eliminar):</h3><pre><code>DELETE FROM empleados WHERE id = 1;</code></pre>', NULL, 1, NOW(), NOW()),
(21, 21, 'texto', '<h2>Filtros y Ordenamiento</h2><h3>WHERE (Filtrar):</h3><pre><code>SELECT * FROM empleados\nWHERE edad &gt; 25;</code></pre><h3>ORDER BY (Ordenar):</h3><pre><code>SELECT * FROM empleados\nORDER BY salario DESC;</code></pre><h3>LIMIT (Limitar):</h3><pre><code>SELECT * FROM empleados\nLIMIT 10;</code></pre>', NULL, 1, NOW(), NOW());

-- Módulo 2: SQL Avanzado
INSERT INTO `modulos` (`id`, `curso_id`, `titulo`, `posicion`, `created`, `modified`) VALUES
(8, 4, 'Módulo 2: SQL Avanzado', 2, NOW(), NOW());

INSERT INTO `lecciones` (`id`, `modulo_id`, `titulo`, `tipo_contenido`, `posicion`, `created`, `modified`) VALUES
(22, 8, 'Lección 1: JOINS y Relaciones', 'texto', 1, NOW(), NOW()),
(23, 8, 'Lección 2: Funciones de Agregación', 'texto', 2, NOW(), NOW()),
(24, 8, 'Lección 3: Triggers y Procedimientos', 'texto', 3, NOW(), NOW());

INSERT INTO `contenidos_leccion` (`id`, `leccion_id`, `tipo`, `contenido`, `archivo`, `posicion`, `created`, `modified`) VALUES
(22, 22, 'texto', '<h2>JOINS</h2><p>Permiten combinar datos de múltiples tablas:</p><h3>INNER JOIN:</h3><pre><code>SELECT e.nombre, d.nombre AS departamento\nFROM empleados e\nINNER JOIN departamentos d ON e.depto_id = d.id;</code></pre><h3>LEFT JOIN:</h3><pre><code>SELECT e.nombre, d.nombre\nFROM empleados e\nLEFT JOIN departamentos d ON e.depto_id = d.id;</code></pre>', NULL, 1, NOW(), NOW()),
(23, 23, 'texto', '<h2>Funciones de Agregación</h2><h3>COUNT:</h3><pre><code>SELECT COUNT(*) FROM empleados;</code></pre><h3>SUM, AVG:</h3><pre><code>SELECT SUM(salario), AVG(salario)\nFROM empleados;</code></pre><h3>GROUP BY:</h3><pre><code>SELECT depto_id, COUNT(*) as total\nFROM empleados\nGROUP BY depto_id;</code></pre><h3>HAVING:</h3><pre><code>SELECT depto_id, AVG(salario)\nFROM empleados\nGROUP BY depto_id\nHAVING AVG(salario) &gt; 3000;</code></pre>', NULL, 1, NOW(), NOW()),
(24, 24, 'texto', '<h2>Triggers</h2><p>Código que se ejecuta automáticamente:</p><pre><code>CREATE TRIGGER antes_insertar\nBEFORE INSERT ON empleados\nFOR EACH ROW\nBEGIN\n  SET NEW.fecha_registro = NOW();\nEND;</code></pre><h3>Procedimientos Almacenados:</h3><pre><code>DELIMITER //\nCREATE PROCEDURE aumentar_salario(IN emp_id INT, IN porcentaje DECIMAL)\nBEGIN\n  UPDATE empleados\n  SET salario = salario * (1 + porcentaje/100)\n  WHERE id = emp_id;\nEND//\nDELIMITER ;</code></pre>', NULL, 1, NOW(), NOW());

-- Inscripciones de ejemplo
INSERT INTO `inscripciones` (`usuario_id`, `curso_id`, `progreso`, `estado`, `created`, `modified`) VALUES
(3, 1, 25, 'aprobada', NOW(), NOW()),
(3, 2, 0, 'pendiente', NOW(), NOW());

COMMIT;

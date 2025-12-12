
CREATE TABLE `users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activo'
);

CREATE TABLE `cursos` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `miniatura` varchar(255) DEFAULT NULL,
  `nivel` varchar(50) DEFAULT 'basico',
  `categoria` varchar(255) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'borrador',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
);

CREATE TABLE `inscripciones` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `usuario_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `progreso` int(11) DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente'
);

CREATE TABLE `modulos` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `curso_id` int(11) NOT NULL,
    `titulo` varchar(255) NOT NULL,
    `posicion` int(11) NOT NULL DEFAULT 0,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL
);

CREATE TABLE `lecciones` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `modulo_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipo_contenido` varchar(50) DEFAULT 'texto',
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
);

CREATE TABLE `contenidos_leccion` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `leccion_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `contenido` text DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `posicion` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
);

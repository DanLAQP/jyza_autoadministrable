-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2026 a las 23:24:32
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jyza_autoadministrable`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content_blocks`
--

CREATE TABLE `content_blocks` (
  `id` int(11) UNSIGNED NOT NULL,
  `section_id` int(11) UNSIGNED NOT NULL,
  `block_key` varchar(100) NOT NULL,
  `block_type` varchar(50) NOT NULL DEFAULT 'text',
  `content` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `content_blocks`
--

INSERT INTO `content_blocks` (`id`, `section_id`, `block_key`, `block_type`, `content`, `metadata`, `sort_order`, `is_active`, `created`, `modified`) VALUES
(3, 1, 'descripcion', 'textarea', 'Clínica especializada en ginecología y obstetricia con más de 10 años cuidando la salud integral de la mujer. Tecnología avanzada y atención personalizada', NULL, 3, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(4, 1, 'badge_text', 'text', 'CITAS DISPONIBLES ESTA SEMANA', NULL, 4, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(5, 1, 'cta_button_text', 'text', 'Agendar Cita por WhatsApp', NULL, 5, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(6, 1, 'cta_button_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20cita', NULL, 6, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(7, 1, 'cta_secundario_text', 'text', 'Ver servicios', NULL, 7, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(8, 1, 'ubicacion', 'text', 'Jr. Dos de Mayo 1600 - Parque Amarilis, Huánuco', NULL, 8, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(9, 1, 'horarios', 'text', 'Lunes a Domingo: 8:00 am - 9:00 pm', NULL, 9, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(10, 1, 'telefono', 'text', '+51 961 295 024', NULL, 10, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(11, 1, 'seo_title', 'text', 'Clínica Ginecología Huánuco | Especialistas en Salud Femenina', NULL, 11, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(12, 1, 'seo_description', 'text', 'Clínica de ginecología y obstetricia en Huánuco. Más de 10 años de experiencia. Tecnología avanzada y atención personalizada para la salud de la mujer.', NULL, 12, 1, '2026-05-31 12:35:50', '2026-06-05 15:32:52'),
(13, 1, 'ubicacion_detail', 'text', 'Parque Amarilis, Huanuco', NULL, 13, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(14, 1, 'horarios_detail', 'text', '8:00 am - 9:00 pm', NULL, 14, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(15, 1, 'club_button_label', 'text', 'Únete', NULL, 15, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(16, 1, 'club_button_title', 'text', 'Club JYZA', NULL, 16, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(17, 1, 'club_button_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20inscribirme%20al%20Club%20JYZA', NULL, 17, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(18, 1, 'club_button_aria', 'text', 'Inscríbete al Club JYZA por WhatsApp', NULL, 18, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(19, 1, 'hero_background_image', 'image', '82', NULL, 19, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(20, 1, 'hero_background_mobile_image', 'image', '83', NULL, 20, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(21, 1, 'logo_image', 'image', '84', NULL, 21, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(22, 1, 'logo_mobile_image', 'image', '85', NULL, 22, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(23, 1, 'button_icon_image', 'image', '86', NULL, 23, 1, '2026-05-31 13:21:20', '2026-06-05 15:32:52'),
(62, 10, 'section_label', 'text', 'Por qué elegirnos', NULL, 1, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(63, 10, 'titulo', 'text', 'Tu Bienestar es Nuestra Prioridad', NULL, 2, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(64, 10, 'descripcion', 'textarea', 'En JYZA combinamos experiencia médica, tecnología de vanguardia y un trato humano excepcional para brindarte la mejor atención ginecológica.', NULL, 3, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(65, 10, 'stat_1_number', 'text', '10+', '{\"label\":\"Años de experiencia\"}', 4, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(66, 10, 'stat_2_number', 'text', '10,000+', '{\"label\":\"Pacientes atendidos\"}', 5, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(67, 10, 'stat_3_number', 'text', '98%', '{\"label\":\"Satisfacción\"}', 6, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(68, 10, 'stat_4_number', 'text', '100%', '{\"label\":\"Atención personalizada\"}', 7, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(69, 10, 'feature_1_text', 'text', 'Equipos de ultrasonido 5D de última generación.', NULL, 8, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(70, 10, 'feature_2_text', 'text', 'Laboratorio clínico especializado.', NULL, 9, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(71, 10, 'feature_3_text', 'text', 'Instalaciones modernas con ambiente cálido y relajado.', NULL, 10, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:52'),
(72, 10, 'img_1', 'image', '87', NULL, 11, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:53'),
(73, 10, 'img_2', 'image', '88', NULL, 12, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:53'),
(74, 10, 'img_3', 'image', '89', NULL, 13, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:53'),
(75, 10, 'img_4', 'image', '90', NULL, 14, 1, '2026-06-04 22:36:56', '2026-06-05 15:36:53'),
(112, 11, 'section_label', 'text', 'Conoce a Nuestros Especialistas', NULL, 1, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(113, 11, 'titulo_parte1', 'text', 'Profesionales Dedicados', NULL, 2, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(114, 11, 'titulo_parte2', 'text', 'a tu Cuidado y Bienestar', NULL, 3, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(115, 11, 'descripcion', 'textarea', 'Nuestro equipo médico está liderado por especialistas con una profunda vocación de servicio. Conoce a los profesionales que te acompañarán en cada etapa.', NULL, 4, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(116, 11, 'doctor1_image', 'image', '91', NULL, 5, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(117, 11, 'doctor1_name', 'text', 'Dr. Jesús Zvi Caycho Cabrera', NULL, 6, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(118, 11, 'doctor1_specialty', 'text', 'Ginecólogo y Obstetra', NULL, 7, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(119, 11, 'doctor1_description_1', 'textarea', 'Con una sólida formación y años de experiencia, el Dr. Caycho lidera el Consultorio Ginecológico JYZA con la misión de ofrecer un cuidado de la salud femenina que sea a la vez profesional, tecnológico y profundamente humano.', NULL, 8, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(120, 11, 'doctor1_description_2', 'textarea', 'Su compromiso es escucharte, entenderte y ofrecerte las mejores soluciones para tu bienestar.', NULL, 9, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(121, 11, 'doctor1_stats_number', 'text', '5000', NULL, 10, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(122, 11, 'doctor1_stats_label', 'text', 'pacientes satisfechos', NULL, 11, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(123, 11, 'doctor1_rating', 'text', '4.9/5', NULL, 12, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(124, 11, 'doctor1_quote', 'text', 'En JYZA te queremos sana', NULL, 13, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(125, 11, 'doctor1_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20con%20el%20Dr.%20Jesus', NULL, 14, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(126, 11, 'doctor2_image', 'image', '92', NULL, 15, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(127, 11, 'doctor2_name', 'text', 'Dra. Tello Rodriguez Esther', NULL, 16, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(128, 11, 'doctor2_specialty', 'text', 'Ginecología y Obstetricia · CMP 066060 · RNE 052295', NULL, 17, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(129, 11, 'doctor2_description_1', 'textarea', 'Su misión es acompañar a las mujeres en cada etapa de su vida, desde la adolescencia hasta la menopausia, brindando un espacio de atención segura y atención médica de vanguardia.', NULL, 18, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(130, 11, 'doctor2_description_2', 'textarea', 'Con una formación académica de alto nivel y un enfoque humano, la Dra. Tello ofrece a cada paciente un cuidado integral en ginecología, priorizando la confianza, el respeto y el bienestar femenino.', NULL, 19, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(131, 11, 'doctor2_stats_number', 'text', '3000', NULL, 20, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(132, 11, 'doctor2_stats_label', 'text', 'pacientes satisfechas', NULL, 21, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(133, 11, 'doctor2_rating', 'text', '4.9/5', NULL, 22, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(134, 11, 'doctor2_quote', 'text', 'Mi prioridad es que te sientas cómoda y en control de tu salud.', NULL, 23, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(135, 11, 'doctor2_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20con%20la%20Dra.%20Tello', NULL, 24, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(136, 11, 'team1_image', 'image', '93', NULL, 25, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(137, 11, 'team1_name', 'text', 'Dr. Jhony Carrera Araujo', NULL, 26, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(138, 11, 'team1_specialty', 'text', 'Médico Ginecólogo Oncólogo', NULL, 27, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(139, 11, 'team1_description', 'textarea', 'Experto en alta complejidad oncológica y técnicas quirúrgicas de vanguardia para la salud femenina.', NULL, 28, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(140, 11, 'team2_image', 'image', '94', NULL, 29, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(141, 11, 'team2_name', 'text', 'Obst. Jennifer Cervantes Cabrera Xd', NULL, 30, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(142, 11, 'team2_specialty', 'text', 'Psicoprofilaxis Obstétrica · COP 35627', NULL, 31, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(143, 11, 'team2_description', 'textarea', 'Acompañamiento humano y profesional durante la gestación, parto y postparto integral.', NULL, 32, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(144, 11, 'team3_image', 'image', '95', NULL, 33, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(145, 11, 'team3_name', 'text', 'Psi. Sheyla Quispe Durán', NULL, 34, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(146, 11, 'team3_specialty', 'text', 'Psicóloga Especializada', NULL, 35, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(147, 11, 'team3_description', 'textarea', 'Especialista en salud mental femenina y bienestar emocional en todas las etapas de la vida.', NULL, 36, 1, '2026-06-04 22:59:31', '2026-06-05 15:38:44'),
(148, 11, 'doctor1_tiktok_url', 'text', 'https://www.tiktok.com/@jyza.ginecologia', NULL, 15, 1, '2026-06-04 23:07:42', '2026-06-05 15:38:44'),
(149, 11, 'doctor1_facebook_url', 'text', 'https://www.facebook.com/jyza.cmeg', NULL, 16, 1, '2026-06-04 23:07:42', '2026-06-05 15:38:44'),
(150, 11, 'doctor1_instagram_url', 'text', 'https://www.instagram.com/consultorio_ginecologico_jyza', NULL, 17, 1, '2026-06-04 23:07:42', '2026-06-05 15:38:44'),
(151, 11, 'doctor2_tiktok_url', 'text', 'https://www.tiktok.com/@jyza.ginecologia', NULL, 25, 1, '2026-06-04 23:07:42', '2026-06-05 15:38:44'),
(152, 11, 'doctor2_facebook_url', 'text', 'https://www.facebook.com/jyza.cmeg', NULL, 26, 1, '2026-06-04 23:07:42', '2026-06-05 15:38:44'),
(153, 11, 'doctor2_instagram_url', 'text', 'https://www.instagram.com/consultorio_ginecologico_jyza', NULL, 27, 1, '2026-06-04 23:07:42', '2026-06-05 15:38:44'),
(154, 13, 'section_label', 'text', 'Especialidades', NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(155, 13, 'titulo_parte1', 'text', 'Conoce Nuestros', NULL, 2, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(156, 13, 'titulo_parte2', 'text', 'Servicios Integrales', NULL, 3, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(157, 13, 'descripcion', 'textarea', 'Brindamos un amplio portafolio de servicios especializados para cuidar tu salud integral.', NULL, 4, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(158, 13, 'service1_icon', 'image', '96', NULL, 5, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(159, 13, 'service1_title', 'text', 'Ginecología Integral', NULL, 6, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(160, 13, 'service1_subtitle', 'text', 'Cuidado completo de tu salud ginecológica.', NULL, 7, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(161, 13, 'service1_detail_1', 'text', 'Salud Femenina', NULL, 8, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(162, 13, 'service1_detail_2', 'text', 'Diagnóstico Integral', NULL, 9, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(163, 13, 'service1_detail_3', 'text', 'Control Ginecológico', NULL, 10, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(164, 13, 'service1_detail_4', 'text', 'Tratamiento Personalizado', NULL, 11, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(165, 13, 'service1_carousel_image', 'image', '97', NULL, 12, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(166, 13, 'service1_carousel_label', 'text', 'Tecnología de alta resolución xD', NULL, 13, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(167, 13, 'service1_carousel_title', 'text', 'Cuidado Preventivo y Diagnóstico Preciso', NULL, 14, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(168, 13, 'service1_carousel_tag1', 'text', 'Ecografía especializada', NULL, 15, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(169, 13, 'service1_carousel_tag2', 'text', 'Laboratorio clínico propio', NULL, 16, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(170, 13, 'service2_icon', 'image', '98', NULL, 17, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(171, 13, 'service2_title', 'text', 'Obstetricia y Atención Prenatal', NULL, 18, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(172, 13, 'service2_subtitle', 'text', 'Acompañamiento en cada etapa de tu embarazo.', NULL, 19, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(173, 13, 'service2_detail_1', 'text', 'Embarazo Seguro', NULL, 20, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(174, 13, 'service2_detail_2', 'text', 'Ecografía Obstétrica', NULL, 21, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(175, 13, 'service2_detail_3', 'text', 'Parto por Cesárea', NULL, 22, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(176, 13, 'service2_detail_4', 'text', 'Monitoreo Fetal', NULL, 23, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(177, 13, 'service2_carousel_image', 'image', '99', NULL, 24, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(178, 13, 'service2_carousel_label', 'text', 'Ecografía prenatal en ambiente cálido', NULL, 25, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(179, 13, 'service2_carousel_title', 'text', 'Cuidamos a Mamá y Bebé', NULL, 26, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(180, 13, 'service2_carousel_tag1', 'text', 'Ecografía Doppler', NULL, 27, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(181, 13, 'service2_carousel_tag2', 'text', 'Detección de riesgo precoz', NULL, 28, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(182, 13, 'service3_icon', 'image', '100', NULL, 29, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(183, 13, 'service3_title', 'text', 'Prevención y Oncología Ginecológica', NULL, 30, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(184, 13, 'service3_subtitle', 'text', 'Detección temprana de cáncer cervicouterino.', NULL, 31, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(185, 13, 'service3_detail_1', 'text', 'VPH', NULL, 32, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(186, 13, 'service3_detail_2', 'text', 'Papanicolaou', NULL, 33, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(187, 13, 'service3_detail_3', 'text', 'Colposcopía', NULL, 34, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(188, 13, 'service3_detail_4', 'text', 'Prevención: Salud Cervical', NULL, 35, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(189, 13, 'service3_carousel_image', 'image', '101', NULL, 36, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(190, 13, 'service3_carousel_label', 'text', 'Detección que Salva Vidas', NULL, 37, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(191, 13, 'service3_carousel_title', 'text', 'Prevención y Oncología Ginecológica', NULL, 38, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(192, 13, 'service3_carousel_tag1', 'text', 'Prueba molecular de VPH', NULL, 39, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(193, 13, 'service3_carousel_tag2', 'text', 'Biopsias dirigidas', NULL, 40, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(194, 13, 'service4_icon', 'image', '102', NULL, 41, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(195, 13, 'service4_title', 'text', 'Fertilidad y Salud Reproductiva', NULL, 42, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(196, 13, 'service4_subtitle', 'text', 'Tecnología avanzada para tu proyecto de vida.', NULL, 43, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(197, 13, 'service4_detail_1', 'text', 'Tratamiento de Infertilidad', NULL, 44, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(198, 13, 'service4_detail_2', 'text', 'Reserva Ovárica', NULL, 45, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(199, 13, 'service4_detail_3', 'text', 'Monitoreo Folicular', NULL, 46, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(200, 13, 'service4_detail_4', 'text', 'Perfil Hormonal', NULL, 47, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(201, 13, 'service4_carousel_image', 'image', '103', NULL, 48, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(202, 13, 'service4_carousel_label', 'text', 'Tu Camino a la Maternidad', NULL, 49, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(203, 13, 'service4_carousel_title', 'text', 'Fertilidad y Salud Reproductiva', NULL, 50, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(204, 13, 'service4_carousel_tag1', 'text', 'Perfil AMH - FSH - LH', NULL, 51, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(205, 13, 'service4_carousel_tag2', 'text', 'Monitoreo ovulatorio', NULL, 52, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(206, 13, 'service5_icon', 'image', '104', NULL, 53, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(207, 13, 'service5_title', 'text', 'Ginecología Funcional y Estética', NULL, 54, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(208, 13, 'service5_subtitle', 'text', 'Bienestar íntimo y calidad de vida femenina.', NULL, 55, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(209, 13, 'service5_detail_1', 'text', 'Láser CO2', NULL, 56, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(210, 13, 'service5_detail_2', 'text', 'Hifu Vaginal', NULL, 57, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(211, 13, 'service5_detail_3', 'text', 'Rejuvenecimiento Vaginal', NULL, 58, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(212, 13, 'service5_detail_4', 'text', 'Incontinencia Urinaria', NULL, 59, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(213, 13, 'service5_carousel_image', 'image', '105', NULL, 60, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(214, 13, 'service5_carousel_label', 'text', 'Tecnología Regenerativa Avanzada', NULL, 61, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(215, 13, 'service5_carousel_title', 'text', 'Ginecología Funcional y Estética', NULL, 62, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(216, 13, 'service5_carousel_tag1', 'text', 'Ambulatorio y mínimamente invasivo', NULL, 63, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(217, 13, 'service5_carousel_tag2', 'text', 'Recuperación rápida y progresiva', NULL, 64, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(218, 13, 'service6_icon', 'image', '106', NULL, 65, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(219, 13, 'service6_title', 'text', 'Cirugía Ginecológica y Soporte Diagnóstico', NULL, 66, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(220, 13, 'service6_subtitle', 'text', 'Intervenciones precisas con tecnología de vanguardia.', NULL, 67, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(221, 13, 'service6_detail_1', 'text', 'Cirugía Laparoscópica', NULL, 68, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(222, 13, 'service6_detail_2', 'text', 'Histerectomía', NULL, 69, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(223, 13, 'service6_detail_3', 'text', 'Miomectomía', NULL, 70, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(224, 13, 'service6_detail_4', 'text', 'Cesárea', NULL, 71, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(225, 13, 'service6_carousel_image', 'image', '107', NULL, 72, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(226, 13, 'service6_carousel_label', 'text', 'Seguridad y Precisión Quirúrgica', NULL, 73, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(227, 13, 'service6_carousel_title', 'text', 'Cirugía Ginecológica y Soporte Diagnóstico', NULL, 74, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(228, 13, 'service6_carousel_tag1', 'text', 'Sala equipada y anestesia segura', NULL, 75, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(229, 13, 'service6_carousel_tag2', 'text', 'Seguimiento hospitalario y estudio patológico', NULL, 76, 1, '2026-06-04 23:14:02', '2026-06-05 15:41:16'),
(290, 15, 'section_label', 'text', 'Paquetes Promocionales', NULL, 1, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(291, 15, 'titulo_parte1', 'text', 'Nuestros Paquetes ', NULL, 2, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(292, 15, 'titulo_parte2', 'text', 'Pensados para Ti', NULL, 3, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(293, 15, 'paquete1_image', 'image', '113', NULL, 4, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(294, 15, 'paquete1_badge', 'text', '', NULL, 5, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(295, 15, 'paquete1_title', 'text', 'Paquete Chequeo Completo q', NULL, 6, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(296, 15, 'paquete1_description', 'textarea', 'Ideal para la detección y prevención de cáncer de cuello uterino y evaluación completa de mamas.', NULL, 7, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(297, 15, 'paquete1_item_1', 'text', 'Consulta Ginecológica', NULL, 8, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(298, 15, 'paquete1_item_2', 'text', 'Ecografía Transvaginal', NULL, 9, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(299, 15, 'paquete1_item_3', 'text', 'Ecografía de Mama', NULL, 10, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(300, 15, 'paquete1_item_4', 'text', 'Colposcopía y Papanicolau', NULL, 11, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(301, 15, 'paquete1_item_5', 'text', 'Reevaluación gratuita de resultados', NULL, 12, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(302, 15, 'paquete1_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20para%20chequeo%20completo', NULL, 13, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(303, 15, 'paquete1_button_text', 'text', 'Agendar Chequeo Completo', NULL, 14, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(304, 15, 'paquete2_image', 'image', '114', NULL, 15, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(305, 15, 'paquete2_badge', 'text', 'MÁS POPULAR', NULL, 16, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(306, 15, 'paquete2_title', 'text', 'Paquete Control Mujer', NULL, 17, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(307, 15, 'paquete2_description', 'textarea', '¿Presentas flujo vaginal excesivo o mal olor? Este paquete es para ti.', NULL, 18, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(308, 15, 'paquete2_item_1', 'text', 'Consulta Ginecológica', NULL, 19, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(309, 15, 'paquete2_item_2', 'text', 'Ecografía Transvaginal', NULL, 20, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(310, 15, 'paquete2_item_3', 'text', 'Papanicolau', NULL, 21, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(311, 15, 'paquete2_item_4', 'text', 'Cultivo de secreción y Ph vaginal', NULL, 22, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(312, 15, 'paquete2_item_5', 'text', 'Reevaluación gratuita de resultados', NULL, 23, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(313, 15, 'paquete2_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20para%20control%20mujer', NULL, 24, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(314, 15, 'paquete2_button_text', 'text', 'Agendar Control Mujer', NULL, 25, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(315, 15, 'paquete3_image', 'image', '115', NULL, 26, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(316, 15, 'paquete3_badge', 'text', '', NULL, 27, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(317, 15, 'paquete3_title', 'text', 'Paquete PrevenITS', NULL, 28, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(318, 15, 'paquete3_description', 'textarea', 'Tu tranquilidad es lo primero. Descarta las Infecciones de Transmisión Sexual más comunes.', NULL, 29, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(319, 15, 'paquete3_item_1', 'text', 'Descarte de VIH', NULL, 30, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(320, 15, 'paquete3_item_2', 'text', 'Descarte de Sífilis', NULL, 31, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(321, 15, 'paquete3_item_3', 'text', 'Descarte de Hepatitis B', NULL, 32, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(322, 15, 'paquete3_item_4', 'text', 'Descarte de Gonorrea', NULL, 33, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(323, 15, 'paquete3_item_5', 'text', 'Descarte de Tricomoniasis y Candidiasis', NULL, 34, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(324, 15, 'paquete3_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta%20para%20PrevenITS', NULL, 35, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(325, 15, 'paquete3_button_text', 'text', 'Agendar PrevenITS', NULL, 36, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(326, 15, 'paquete4_image', 'image', '116', NULL, 37, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(327, 15, 'paquete4_badge', 'text', '', NULL, 38, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(328, 15, 'paquete4_title', 'text', 'Programa de Maternidad', NULL, 39, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(329, 15, 'paquete4_description', 'textarea', 'Elige el plan de control prenatal que mejor se adapte a tu embarazo.', NULL, 40, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(330, 15, 'paquete4_item_1', 'text', 'Plan Bronce', NULL, 41, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(331, 15, 'paquete4_item_2', 'text', 'Plan Plata', NULL, 42, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(332, 15, 'paquete4_item_3', 'text', 'Plan Oro', NULL, 43, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(333, 15, 'paquete4_item_4', 'text', '', NULL, 44, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(334, 15, 'paquete4_item_5', 'text', '', NULL, 45, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(335, 15, 'paquete4_whatsapp_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20consultar%20sobre%20los%20planes%20de%20maternidad', NULL, 46, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(336, 15, 'paquete4_button_text', 'text', 'Consultar sobre Planes', NULL, 47, 1, '2026-06-04 23:31:42', '2026-06-05 15:56:24'),
(337, 16, 'section_badge', 'text', 'TESTIMONIOS xD', NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(338, 16, 'titulo_parte1', 'text', 'Lo que Dicen s', NULL, 2, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(339, 16, 'titulo_parte2', 'text', 'Nuestras Pacientes', NULL, 3, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(340, 16, 'descripcion', 'textarea', 'Opiniones reales de nuestras redes sociales sobre la calidez y el profesionalismo que nos define.', NULL, 4, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(341, 16, 'cta_button_url', 'text', 'https://www.facebook.com/jyza.cmeg', NULL, 5, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(342, 16, 'testimonio1_avatar', 'image', '117', NULL, 6, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(343, 16, 'testimonio1_name', 'text', 'Marianela A.', NULL, 7, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(344, 16, 'testimonio1_tag', 'text', 'Paciente verificada', NULL, 8, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(345, 16, 'testimonio1_text', 'textarea', '\"100% recomendado. En el Consultorio Ginecológico JYZA me atendieron de lo mejor, muchas gracias 🥺🥺\"', NULL, 9, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(346, 16, 'testimonio1_likes', 'text', '124', NULL, 10, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(347, 16, 'testimonio1_featured', 'text', '', NULL, 11, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(348, 16, 'testimonio2_avatar', 'image', '118', NULL, 12, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(349, 16, 'testimonio2_name', 'text', 'Kharitto P.', NULL, 13, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(350, 16, 'testimonio2_tag', 'text', 'Paciente', NULL, 14, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(351, 16, 'testimonio2_text', 'textarea', '\"100% garantizado y con excelente atención de principio a fin 🙏🏼\"', NULL, 15, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(352, 16, 'testimonio2_likes', 'text', '', NULL, 16, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(353, 16, 'testimonio2_featured', 'text', '', NULL, 17, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(354, 16, 'testimonio3_avatar', 'image', '119', NULL, 18, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(355, 16, 'testimonio3_name', 'text', 'Cori D. R.', NULL, 19, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(356, 16, 'testimonio3_tag', 'text', 'Paciente verificada', NULL, 20, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(357, 16, 'testimonio3_text', 'textarea', '\"El mejor Dr. Jesús Caycho. Top 1.\"', NULL, 21, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(358, 16, 'testimonio3_likes', 'text', '11', NULL, 22, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(359, 16, 'testimonio3_featured', 'text', '', NULL, 23, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(360, 16, 'testimonio4_avatar', 'image', '120', NULL, 24, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(361, 16, 'testimonio4_name', 'text', 'Fiorella B.', NULL, 25, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(362, 16, 'testimonio4_tag', 'text', 'Paciente embarazo de alto riesgo', NULL, 26, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(363, 16, 'testimonio4_text', 'textarea', '\" Siempre estaré muy agradecida por cómo cuidaron de mí y de mi bebé en un momento muy difícil de mi embarazo de riesgo. Gracias por todo su apoyo, ahora mi bebé ya cumplió un año gracias a Dios ❤️🙏\"', NULL, 27, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(364, 16, 'testimonio4_likes', 'text', '', NULL, 28, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(365, 16, 'testimonio4_featured', 'text', 'featured', NULL, 29, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(366, 16, 'testimonio5_avatar', 'image', '121', NULL, 30, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(367, 16, 'testimonio5_name', 'text', 'Angélica M. A. M. F.', NULL, 31, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(368, 16, 'testimonio5_tag', 'text', 'Paciente postoperatoria', NULL, 32, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(369, 16, 'testimonio5_text', 'textarea', '\"Muchas gracias doctores, mi recuperación está siendo exitosa hasta el momento.\"', NULL, 33, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(370, 16, 'testimonio5_likes', 'text', '', NULL, 34, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(371, 16, 'testimonio5_featured', 'text', '', NULL, 35, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(372, 16, 'testimonio6_avatar', 'image', '122', NULL, 36, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(373, 16, 'testimonio6_name', 'text', 'Leydi J.', NULL, 37, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(374, 16, 'testimonio6_tag', 'text', 'Paciente', NULL, 38, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(375, 16, 'testimonio6_text', 'textarea', '\"100% recomendado, excelente atención.\"', NULL, 39, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(376, 16, 'testimonio6_likes', 'text', '', NULL, 40, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(377, 16, 'testimonio6_featured', 'text', '', NULL, 41, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(378, 16, 'testimonio7_avatar', 'image', '123', NULL, 42, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(379, 16, 'testimonio7_name', 'text', 'Daniela D. S.', NULL, 43, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(380, 16, 'testimonio7_tag', 'text', 'Paciente', NULL, 44, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(381, 16, 'testimonio7_text', 'textarea', '\"Súper recomendado. 🤗🤗 Excelente atención!\"', NULL, 45, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(382, 16, 'testimonio7_likes', 'text', '', NULL, 46, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(383, 16, 'testimonio7_featured', 'text', '', NULL, 47, 1, '2026-06-04 23:38:40', '2026-06-05 16:00:02'),
(384, 16, 'testimonio8_avatar', 'image', '', NULL, 48, 1, '2026-06-05 00:23:50', '2026-06-05 16:00:02'),
(385, 16, 'testimonio8_name', 'text', 'Paciente Anónima', NULL, 49, 1, '2026-06-05 00:23:50', '2026-06-05 16:00:02'),
(386, 16, 'testimonio8_tag', 'text', 'Paciente', NULL, 50, 1, '2026-06-05 00:23:50', '2026-06-05 16:00:02'),
(387, 16, 'testimonio8_text', 'textarea', '\"Puntualidad y limpieza impecable. Sin duda el mejor consultorio ginecológico.\"', NULL, 51, 1, '2026-06-05 00:23:50', '2026-06-05 16:00:02'),
(388, 16, 'testimonio8_likes', 'text', '', NULL, 52, 1, '2026-06-05 00:23:50', '2026-06-05 16:00:02'),
(389, 16, 'testimonio8_featured', 'text', '', NULL, 53, 1, '2026-06-05 00:23:50', '2026-06-05 16:00:02'),
(390, 17, 'section_badge', 'text', '¡Agenda tu Cita Online!', NULL, 1, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(391, 17, 'titulo_parte1', 'text', 'Agenda tu Cita en', NULL, 2, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(392, 17, 'titulo_parte2', 'text', '3 Simples Pasos', NULL, 3, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(393, 17, 'servicio_1', 'text', 'Ginecología Integral', NULL, 4, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(394, 17, 'servicio_2', 'text', 'Obstetricia y Atención Prenatal', NULL, 5, 0, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(395, 17, 'servicio_3', 'text', 'Prevención y Oncología Ginecológica', NULL, 6, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(396, 17, 'servicio_4', 'text', 'Fertilidad y Salud Reproductiva', NULL, 7, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(397, 17, 'servicio_5', 'text', 'Ginecología Funcional y Estética', NULL, 8, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(398, 17, 'servicio_6', 'text', 'Cirugía ginecológica y obstétrica', NULL, 9, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(399, 17, 'especialista_1', 'text', 'Dr. Jesús CaychoO', NULL, 10, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(400, 17, 'especialista_2', 'text', 'Doctora Tello', NULL, 11, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(401, 17, 'paso1_titulo', 'text', '¿Qué necesitas y con quién?', NULL, 12, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(402, 17, 'paso1_subtitulo', 'text', 'Selecciona el servicio y especialistas', NULL, 13, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(403, 17, 'paso2_titulo', 'text', 'Elige la Fecha y Hora', NULL, 14, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(404, 17, 'paso2_subtitulo', 'text', 'Los días disponibles aparecen en color morado', NULL, 15, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(405, 17, 'paso3_titulo', 'text', 'Confirma tus Datos', NULL, 16, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(406, 17, 'paso3_subtitulo', 'text', 'Ingresa tu información para la cita', NULL, 17, 1, '2026-06-05 00:35:33', '2026-06-05 16:07:58'),
(407, 17, 'servicio_7', 'text', 'servicio 7 funciona', NULL, 18, 0, '2026-06-05 00:55:01', '2026-06-05 16:07:58'),
(408, 17, 'especialista_3', 'text', 'funcionara?', NULL, 19, 0, '2026-06-05 00:55:46', '2026-06-05 16:07:58'),
(409, 17, 'solo', 'text', 'solos', NULL, 20, 0, '2026-06-05 00:56:39', '2026-06-05 16:07:58'),
(410, 18, 'titulo', 'text', '¿Lista para agendar tu consulta?', NULL, 1, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(411, 18, 'descripcion', 'textarea', 'Nuestro equipo está listo para atenderte. Agenda tu cita en línea o llámanos directamente. Primera consulta con 20% de descuento.', NULL, 2, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(412, 18, 'cta_button_text', 'text', 'Agendar Consulta', NULL, 3, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(413, 18, 'cta_button_url', 'text', 'https://wa.me/51961295024?text=Hola,%20deseo%20agendar%20una%20consulta', NULL, 4, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(414, 18, 'telefono_numero', 'text', '961 295 024', NULL, 5, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(415, 18, 'telefono_url', 'text', 'tel:+51961295024', NULL, 6, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(416, 18, 'horarios_titulo', 'text', 'Horarios de Atención', NULL, 7, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(417, 18, 'horario_1_dia', 'text', 'Lunes a Domingo', NULL, 8, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(418, 18, 'horario_1_horas', 'text', '8 am - 9 pm', NULL, 9, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(419, 18, 'horario_2_dia', 'text', 'Atencion personalizada', NULL, 10, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(420, 18, 'horario_2_horas', 'text', '100%', NULL, 11, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(421, 18, 'direccion', 'textarea', 'Jirón Dos de Mayo 1600 con Pedro Puelles, esquina del Parque Amarilis, Huánuco', NULL, 12, 1, '2026-06-05 01:02:11', '2026-06-05 16:01:36'),
(427, 19, 'section_label', 'text', 'Cómo Llegar', NULL, 1, 1, '2026-06-05 01:11:59', '2026-06-05 16:04:05'),
(428, 19, 'titulo', 'text', 'Encuéntranos', NULL, 2, 1, '2026-06-05 01:11:59', '2026-06-05 16:04:05'),
(429, 19, 'titulo_highlight_word', 'text', 'Fácilmente', NULL, 3, 1, '2026-06-05 01:11:59', '2026-06-05 16:04:05'),
(430, 19, 'subtitulo', 'textarea', 'Estamos en una zona céntrica y accesible para tu comodidad.', NULL, 4, 1, '2026-06-05 01:11:59', '2026-06-05 16:04:05'),
(431, 19, 'map_url', 'textarea', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3930.1069284256373!2d-76.24007962408443!3d-9.925052106035078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91a7c326047a94db%3A0x9861c485037915b!2sConsultorio%20Ginecol%C3%B3gico%20JYZA!5e0!3m2!1ses!2spe!4v1774586756495!5m2!1ses!2spe', NULL, 5, 1, '2026-06-05 01:11:59', '2026-06-05 16:04:05'),
(432, 20, 'stat_1_number', 'text', '10', NULL, 1, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(433, 20, 'stat_1_symbol', 'text', '+', NULL, 2, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(434, 20, 'stat_1_label', 'text', 'Años de Experiencia', NULL, 3, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(435, 20, 'stat_2_number', 'text', '5000', NULL, 4, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(436, 20, 'stat_2_symbol', 'text', '+', NULL, 5, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(437, 20, 'stat_2_label', 'text', 'Pacientes Atendidos', NULL, 6, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(438, 20, 'stat_3_number', 'text', '98', NULL, 7, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(439, 20, 'stat_3_symbol', 'text', '%', NULL, 8, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(440, 20, 'stat_3_label', 'text', 'Satisfacción', NULL, 9, 1, '2026-06-05 01:25:12', '2026-06-05 16:04:50'),
(501, 14, 'section_badge', 'text', 'Red de Convenios Activos', NULL, 0, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(502, 14, 'titulo_parte1', 'text', 'Cuida de los Tuyos Ahorrando', NULL, 1, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(503, 14, 'titulo_parte2', 'text', 'con el Club JYZA', NULL, 2, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(504, 14, 'descripcion', 'textarea', 'El club JYZA es una comunidad exclusiva de pacientes que acceden a los mejores beneficios en nuestro establecimiento y el diferentes centros de Huánuco, solo debes de presentar tu tarjeta que te identifica como miembro', NULL, 3, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(505, 14, 'convenio_1_image', 'image', '108', NULL, 4, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(506, 14, 'convenio_1_category', 'text', 'Ginecología', NULL, 5, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(507, 14, 'convenio_1_category_color', 'text', 'cat-gine', NULL, 6, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(508, 14, 'convenio_1_tag', 'text', 'Fundador', NULL, 7, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(509, 14, 'convenio_1_tag_color', 'text', 'tag-fundador', NULL, 8, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(510, 14, 'convenio_1_name', 'text', 'Consultorio Ginecológico JYZA', NULL, 9, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(511, 14, 'convenio_1_specialty', 'text', 'Jr dos de mayo 1600 con Pedro Puelles · 961 295 024', NULL, 10, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(512, 14, 'convenio_1_description_1', 'textarea', 'Centro especializado en el cuidado integral de la salud femenina. Somos los fundadores del Club JYZA, comprometidos con tu bienestar en cada etapa de tu vida.', NULL, 11, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(513, 14, 'convenio_1_description_2', 'textarea', 'Atención ginecológica con tecnología de vanguardia, trato cálido y enfoque en la salud preventiva y curativa de la mujer.', NULL, 12, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(514, 14, 'convenio_1_quote', 'text', 'En JYZA te queremos sana', NULL, 13, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(515, 14, 'convenio_1_benefit', 'text', '10% de descuento en todos nuestros servicios', NULL, 14, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(516, 14, 'convenio_1_benefit_color', 'text', 'pill-purple', NULL, 15, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(517, 14, 'convenio_1_facebook_url', 'text', 'https://www.facebook.com/jyza.cmeg', NULL, 16, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(518, 14, 'convenio_1_instagram_url', 'text', 'https://www.instagram.com/consultorio_ginecologico_jyza', NULL, 17, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(519, 14, 'convenio_2_image', 'image', '109', NULL, 18, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(520, 14, 'convenio_2_category', 'text', 'Pediatría', NULL, 19, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(521, 14, 'convenio_2_category_color', 'text', 'cat-ped', NULL, 20, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(522, 14, 'convenio_2_tag', 'text', 'Alianza', NULL, 21, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(523, 14, 'convenio_2_tag_color', 'text', 'tag-alianza', NULL, 22, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(524, 14, 'convenio_2_name', 'text', 'Centro Pediátrico Rositas', NULL, 23, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(525, 14, 'convenio_2_specialty', 'text', 'Jr. Mayro 250 – Huánuco · +51 952 468 349', NULL, 24, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(526, 14, 'convenio_2_description_1', 'textarea', 'Brindamos atención pediátrica especializada con calidad, calidez y compromiso con la salud de los niños de Huánuco.', NULL, 25, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(527, 14, 'convenio_2_description_2', 'textarea', 'Un espacio pensado para que los más pequeños reciban la mejor atención médica en un ambiente seguro y acogedor.', NULL, 26, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(528, 14, 'convenio_2_quote', 'text', 'Porque cada niño merece lo mejor', NULL, 27, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(529, 14, 'convenio_2_benefit', 'text', '20% de descuento en la consulta pediátrica', NULL, 28, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(530, 14, 'convenio_2_benefit_color', 'text', 'pill-amber', NULL, 29, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(531, 14, 'convenio_2_facebook_url', 'text', 'https://www.facebook.com/profile.php?id=61563956279816', NULL, 30, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(532, 14, 'convenio_2_instagram_url', 'text', '', NULL, 31, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(533, 14, 'convenio_3_image', 'image', '110', NULL, 32, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(534, 14, 'convenio_3_category', 'text', 'Odontología', NULL, 33, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(535, 14, 'convenio_3_category_color', 'text', 'cat-odonto', NULL, 34, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(536, 14, 'convenio_3_tag', 'text', 'Convenio', NULL, 35, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(537, 14, 'convenio_3_tag_color', 'text', 'tag-convenio', NULL, 36, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(538, 14, 'convenio_3_name', 'text', 'Clínica Dental Cabanillas', NULL, 37, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(539, 14, 'convenio_3_specialty', 'text', 'Jr. Aguilar 339 – Huánuco · 988 129 696', NULL, 38, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(540, 14, 'convenio_3_description_1', 'textarea', 'Brindamos atención odontológica integral con profesionalismo, tecnología y un trato cálido para cuidar tu sonrisa.', NULL, 39, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(541, 14, 'convenio_3_description_2', 'textarea', 'Desde limpiezas preventivas hasta tratamientos de alta complejidad, con equipos modernos y especialistas comprometidos con tu salud bucal.', NULL, 40, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(542, 14, 'convenio_3_quote', 'text', 'Tu sonrisa es nuestra especialidad', NULL, 41, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(543, 14, 'convenio_3_benefit', 'text', 'Evaluación odontológica gratuita', NULL, 42, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(544, 14, 'convenio_3_benefit_color', 'text', 'pill-green', NULL, 43, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(545, 14, 'convenio_3_facebook_url', 'text', 'https://www.facebook.com/Clinica.Cabanillas', NULL, 44, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(546, 14, 'convenio_3_instagram_url', 'text', 'https://www.instagram.com/dental.cabanillas', NULL, 45, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(547, 14, 'convenio_4_image', 'image', '111', NULL, 46, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(548, 14, 'convenio_4_category', 'text', 'Estética', NULL, 47, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(549, 14, 'convenio_4_category_color', 'text', 'cat-estim', NULL, 48, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(550, 14, 'convenio_4_tag', 'text', 'Bienestar', NULL, 49, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(551, 14, 'convenio_4_tag_color', 'text', 'tag-bienest', NULL, 50, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(552, 14, 'convenio_4_name', 'text', 'Baby Shark Spa', NULL, 51, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(553, 14, 'convenio_4_specialty', 'text', 'Jr. Constitución 482 – Huánuco · +51 954 763 133', NULL, 52, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(554, 14, 'convenio_4_description_1', 'textarea', 'Especialistas en estimulación temprana, promoviendo el desarrollo físico, cognitivo y emocional del bebé en un ambiente seguro y lúdico.', NULL, 53, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(555, 14, 'convenio_4_description_2', 'textarea', 'Un espacio pensado para que los padres acompañen a sus hijos en sus primeras etapas de aprendizaje, fortaleciendo vínculos y potenciando sus habilidades.', NULL, 54, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(556, 14, 'convenio_4_quote', 'text', 'Cada pequeño logro, un gran paso', NULL, 55, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(557, 14, 'convenio_4_benefit', 'text', '10% de descuento en el paquete de estimulación temprana', NULL, 56, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(558, 14, 'convenio_4_benefit_color', 'text', 'pill-purple', NULL, 57, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(559, 14, 'convenio_4_facebook_url', 'text', 'https://www.facebook.com/profile.php?id=61571776081114', NULL, 58, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(560, 14, 'convenio_4_instagram_url', 'text', 'https://www.instagram.com/baby_sharkspa', NULL, 59, 1, '2026-06-05 02:05:17', '2026-06-05 15:54:09'),
(561, 14, 'convenio_5_name', 'text', 'Qp Secure Solutions Sac', NULL, 61, 0, '2026-06-05 02:17:54', '2026-06-05 15:54:09'),
(562, 14, 'convenio_5_image', 'image', '112', NULL, 62, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(563, 14, 'convenio_5_category', 'text', 'TI', NULL, 63, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(564, 14, 'convenio_5_category_color', 'text', 'cat-estim', NULL, 64, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(565, 14, 'convenio_5_tag', 'text', 'Software', NULL, 65, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(566, 14, 'convenio_5_tag_color', 'text', 'tag-fundador', NULL, 66, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(567, 14, 'convenio_5_specialty', 'text', 'TI/ Software', NULL, 67, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(568, 14, 'convenio_5_description_1', 'textarea', 'Somos una empresa especializada en desarrollo de aplicaciones móviles Android y soluciones web autoadministrables, enfocada en crear productos digitales escalables, seguros y adaptados a las necesidades de cada cliente.', NULL, 68, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(569, 14, 'convenio_5_description_2', 'textarea', 'Nuestro equipo combina innovación tecnológica con experiencia en diseño de sistemas', NULL, 69, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(570, 14, 'convenio_5_quote', 'text', 'Innovación móvil y web para un mundo conectado.', NULL, 70, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(571, 14, 'convenio_5_benefit', 'text', 'Asesoría personalizada', NULL, 71, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(572, 14, 'convenio_5_benefit_color', 'text', 'pill-purple', NULL, 72, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(573, 14, 'convenio_5_facebook_url', 'text', 'https://www.facebook.com/QPSecureSolutions', NULL, 73, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(574, 14, 'convenio_5_instagram_url', 'text', 'https://www.instagram.com/qpsecuresolutions/', NULL, 74, 0, '2026-06-05 02:22:58', '2026-06-05 15:54:09'),
(575, 1, 'titulo_parte1', 'text', 'Tu Salud Femenina en las', NULL, 24, 1, '2026-06-05 03:06:27', '2026-06-05 15:32:52'),
(576, 1, 'titulo_parte2', 'text', 'Mejores Manos', NULL, 25, 1, '2026-06-05 03:06:27', '2026-06-05 15:32:52'),
(577, 1, 'titulo_parte3', 'text', 'de Huánuco', NULL, 26, 1, '2026-06-05 03:06:27', '2026-06-05 15:32:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content_cache`
--

CREATE TABLE `content_cache` (
  `id` int(11) UNSIGNED NOT NULL,
  `section_slug` varchar(255) NOT NULL,
  `cache_data` text DEFAULT NULL,
  `etag` varchar(100) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content_images`
--

CREATE TABLE `content_images` (
  `id` int(11) UNSIGNED NOT NULL,
  `section_id` int(11) UNSIGNED DEFAULT NULL,
  `block_id` int(11) UNSIGNED DEFAULT NULL,
  `original_filename` varchar(255) NOT NULL,
  `stored_filename` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `dimensions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dimensions`)),
  `alt_text` varchar(500) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `content_images`
--

INSERT INTO `content_images` (`id`, `section_id`, `block_id`, `original_filename`, `stored_filename`, `file_path`, `file_size`, `mime_type`, `dimensions`, `alt_text`, `title`, `uploaded_by`, `is_active`, `created`, `modified`) VALUES
(1, 1, 19, 'File (8).jpg', 'img_6a1cc49265c4c7.63405940.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a1cc49265c4c7.63405940.jpg', 83673, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-05-31 18:30:26', '2026-05-31 18:30:26'),
(2, 1, 21, 'File (8).jpg', 'img_6a1cce898dad08.84344027.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a1cce898dad08.84344027.jpg', 83673, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-05-31 19:12:57', '2026-05-31 19:12:57'),
(3, 1, 22, 'vidaplusLogo-removebg-preview.png', 'img_6a1cce89911ea5.83704468.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a1cce89911ea5.83704468.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-05-31 19:12:57', '2026-05-31 19:12:57'),
(4, 1, 23, 'xd.jpg', 'img_6a1cce89922a38.77196259.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a1cce89922a38.77196259.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-05-31 19:12:57', '2026-05-31 19:12:57'),
(5, 1, 19, 'File (8).jpg', 'img_6a1ce0f9f37a61.38132747.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a1ce0f9f37a61.38132747.jpg', 83673, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-05-31 20:31:38', '2026-05-31 20:31:38'),
(6, 1, 20, 'vidaplusLogo-removebg-preview.png', 'img_6a1ce0fa182082.46039068.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a1ce0fa182082.46039068.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-05-31 20:31:38', '2026-05-31 20:31:38'),
(15, 10, NULL, 'imag1.webp', 'imag1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/imag1.webp', NULL, 'image/webp', NULL, 'Doctor con equipo médico', 'Doctor con equipo médico', 1, 1, '2026-06-04 22:17:54', '2026-06-04 22:47:53'),
(16, 10, NULL, 'imag2.webp', 'imag2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/imag2.webp', NULL, 'image/webp', NULL, 'Equipo quirúrgico', 'Equipo quirúrgico', 1, 1, '2026-06-04 22:17:54', '2026-06-04 22:47:53'),
(17, 10, NULL, 'imag3.webp', 'imag3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/imag3.webp', NULL, 'image/webp', NULL, 'Sala de operaciones', 'Sala de operaciones', 1, 1, '2026-06-04 22:17:54', '2026-06-04 22:47:53'),
(18, 10, NULL, 'imag4.webp', 'imag4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/imag4.webp', NULL, 'image/webp', NULL, 'Doctor en cirugía', 'Doctor en cirugía', 1, 1, '2026-06-04 22:17:54', '2026-06-04 22:47:53'),
(20, 10, 72, 'logo_boleta.png', 'img_6a2247ab825935.72302655.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2247ab825935.72302655.png', 94486, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 22:51:07', '2026-06-04 22:51:07'),
(21, 10, 73, 'vidaplusLogo-removebg-preview.png', 'img_6a2247cb45c1d9.07954290.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2247cb45c1d9.07954290.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 22:51:39', '2026-06-04 22:51:39'),
(22, 10, 74, 'xd.jpg', 'img_6a2247cb489951.70717815.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2247cb489951.70717815.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 22:51:39', '2026-06-04 22:51:39'),
(23, 10, 75, '706257095_122100317865328021_5634504334298627192_n.jpg', 'img_6a2247cb49e323.49228049.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2247cb49e323.49228049.jpg', 202501, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 22:51:39', '2026-06-04 22:51:39'),
(29, 11, NULL, 'equipo1.webp', 'equipo1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 22:59:31', '2026-06-05 05:25:07'),
(30, 11, NULL, 'equipo2.webp', 'equipo2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo2.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 22:59:31', '2026-06-05 05:25:07'),
(31, 11, NULL, 'equipo3.webp', 'equipo3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo3.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 22:59:31', '2026-06-05 05:25:07'),
(32, 11, NULL, 'equipo4.webp', 'equipo4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo4.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 22:59:31', '2026-06-05 05:25:07'),
(33, 11, NULL, 'equipo5.webp', 'equipo5.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/equipo5.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 22:59:31', '2026-06-05 05:25:07'),
(34, 11, 116, 'vidaplusLogo-removebg-preview.png', 'img_6a224aba728394.61137735.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a224aba728394.61137735.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:04:10', '2026-06-05 05:25:07'),
(35, 11, 126, 'File (8).jpg', 'img_6a224c3192aa38.66537113.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a224c3192aa38.66537113.jpg', 83673, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 23:10:25', '2026-06-05 05:25:07'),
(36, 11, 136, 'xd.jpg', 'img_6a224c319c37e9.76654872.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a224c319c37e9.76654872.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 23:10:25', '2026-06-05 05:25:07'),
(37, 11, 140, 'ej4_examen.png', 'img_6a224c31a114d9.10081187.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a224c31a114d9.10081187.png', 28442, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:10:25', '2026-06-05 05:25:07'),
(38, 11, 144, 'ej5_examen.png', 'img_6a224c31a49c22.00211917.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a224c31a49c22.00211917.png', 61689, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:10:25', '2026-06-05 05:25:07'),
(39, 13, NULL, 'icono1.webp', 'icono1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(40, 13, NULL, 'especialidad1.webp', 'especialidad1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(41, 13, NULL, 'icono2.webp', 'icono2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono2.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(42, 13, NULL, 'especialidad2.webp', 'especialidad2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad2.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(43, 13, NULL, 'icono3.webp', 'icono3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono3.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(44, 13, NULL, 'especialidad3.webp', 'especialidad3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad3.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(45, 13, NULL, 'icono4.webp', 'icono4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono4.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(46, 13, NULL, 'especialidad4.webp', 'especialidad4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad4.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(47, 13, NULL, 'icono5.webp', 'icono5.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono5.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(48, 13, NULL, 'especialidad5.webp', 'especialidad5.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad5.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(49, 13, NULL, 'icono6.webp', 'icono6.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/icono6.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(50, 13, NULL, 'especialidad6.webp', 'especialidad6.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/especialidad6.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(51, 13, 158, 'vidaplusLogo-removebg-preview.png', 'img_6a224dfdac7748.79893032.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a224dfdac7748.79893032.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:18:05', '2026-06-04 23:18:05'),
(52, 13, 165, 'xd.jpg', 'img_6a224e28c3bb79.60529454.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a224e28c3bb79.60529454.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 23:18:48', '2026-06-04 23:18:48'),
(53, 14, NULL, 'jyzaicon_1.webp', 'jyzaicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/jyzaicon_1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:21:15', '2026-06-04 23:21:15'),
(54, 14, NULL, 'rositasicon_1.webp', 'rositasicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/rositasicon_1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:21:15', '2026-06-04 23:21:15'),
(55, 14, NULL, 'cabanillasicon_1.webp', 'cabanillasicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/cabanillasicon_1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:21:15', '2026-06-04 23:21:15'),
(56, 14, NULL, 'sharkicon_1.webp', 'sharkicon_1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/sharkicon_1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:21:15', '2026-06-04 23:21:15'),
(57, 14, NULL, 'vidaplusLogo-removebg-preview.png', 'img_6a22503581d428.63300903.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a22503581d428.63300903.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:27:33', '2026-06-04 23:27:33'),
(58, 14, NULL, 'xd.jpg', 'img_6a2250358adc78.97448424.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2250358adc78.97448424.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 23:27:33', '2026-06-04 23:27:33'),
(59, 14, NULL, 'vidaplusLogo-removebg-preview.png', 'img_6a225035937c34.03966878.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a225035937c34.03966878.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:27:33', '2026-06-04 23:27:33'),
(60, 14, NULL, 'store_logo_1776876681304.png', 'img_6a2250359a89c5.88514653.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2250359a89c5.88514653.png', 138901, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:27:33', '2026-06-04 23:27:33'),
(61, 15, NULL, 'paquete1.webp', 'paquete1.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete1.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:31:42', '2026-06-04 23:31:42'),
(62, 15, NULL, 'paquete2.webp', 'paquete2.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete2.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:31:42', '2026-06-04 23:31:42'),
(63, 15, NULL, 'paquete3.webp', 'paquete3.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete3.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:31:42', '2026-06-04 23:31:42'),
(64, 15, NULL, 'paquete4.webp', 'paquete4.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/paquete4.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:31:42', '2026-06-04 23:31:42'),
(65, 15, 293, 'vidaplusLogo-removebg-preview.png', 'img_6a22520a3816f3.02318088.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a22520a3816f3.02318088.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:35:22', '2026-06-04 23:35:22'),
(66, 15, 304, 'xd.jpg', 'img_6a22520a3fa1d2.31622374.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a22520a3fa1d2.31622374.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 23:35:22', '2026-06-04 23:35:22'),
(67, 15, 315, 'anaranjadop.png', 'img_6a22520a466506.03953257.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a22520a466506.03953257.png', 216698, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-04 23:35:22', '2026-06-04 23:35:22'),
(68, 15, 326, 'ej9_examen_sol.jpeg', 'img_6a22520a4cc839.51334431.jpeg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a22520a4cc839.51334431.jpeg', 49736, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-04 23:35:22', '2026-06-04 23:35:22'),
(69, 16, NULL, 'marianela.webp', 'marianela.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/marianela.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(70, 16, NULL, 'karito.webp', 'karito.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/karito.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(71, 16, NULL, 'cori.webp', 'cori.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/cori.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(72, 16, NULL, 'fiorella.webp', 'fiorella.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/fiorella.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(73, 16, NULL, 'angelica.webp', 'angelica.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/angelica.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(74, 16, NULL, 'leydi.webp', 'leydi.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/leydi.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(75, 16, NULL, 'daniela.webp', 'daniela.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/daniela.webp', NULL, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(76, 14, 505, 'logo_boleta.png', 'img_6a227811b9d512.09149388.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a227811b9d512.09149388.png', 94486, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-05 02:17:37', '2026-06-05 02:17:37'),
(77, 14, 562, 'xd.jpg', 'img_6a22796c2fd5f1.24756014.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a22796c2fd5f1.24756014.jpg', 169955, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-05 02:23:24', '2026-06-05 02:23:24'),
(78, 13, 170, 'File (8).jpg', 'img_6a2292cb079464.09547103.jpg', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2292cb079464.09547103.jpg', 83673, 'image/jpeg', NULL, NULL, NULL, 1, 1, '2026-06-05 04:11:39', '2026-06-05 04:11:39'),
(79, 13, 177, 'pedraza_ortodoncia_150 (1).png', 'img_6a2292cb0d5c78.61063199.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2292cb0d5c78.61063199.png', 1381164, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-05 04:11:39', '2026-06-05 04:11:39'),
(80, 11, 140, 'logo_boleta.png', 'img_6a22a2de73f7f1.75211979.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a22a2de73f7f1.75211979.png', 94486, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-05 05:20:14', '2026-06-05 05:25:07'),
(81, 11, 126, 'vidaplusLogo-removebg-preview.png', 'img_6a22a39b5ede11.71395171.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/webroot/uploads/content/img_6a22a39b5ede11.71395171.png', 120940, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-05 05:23:23', '2026-06-05 05:25:07'),
(82, 1, 19, 'herofondo.webp', 'img_6a2332386c7643.12446844.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2332386c7643.12446844.webp', 60570, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:31:52', '2026-06-05 15:31:52'),
(83, 1, 20, 'herofondot.webp', 'img_6a2332386f38f2.80837656.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2332386f38f2.80837656.webp', 42246, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:31:52', '2026-06-05 15:31:52'),
(84, 1, 21, 'logoJiza.webp', 'img_6a233238704e12.27706655.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a233238704e12.27706655.webp', 3542, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:31:52', '2026-06-05 15:31:52'),
(85, 1, 22, 'logoJiza.webp', 'img_6a23323871ad03.56248028.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23323871ad03.56248028.webp', 3542, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:31:52', '2026-06-05 15:31:52'),
(86, 1, 23, 'iconBtn.webp', 'img_6a23323872ce51.74657719.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23323872ce51.74657719.webp', 1366, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:31:52', '2026-06-05 15:31:52'),
(87, 10, 72, 'imag1.webp', 'img_6a233364f368d8.13668856.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a233364f368d8.13668856.webp', 9944, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:36:53', '2026-06-05 15:36:53'),
(88, 10, 73, 'imag2.webp', 'img_6a233365024cc1.56808541.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a233365024cc1.56808541.webp', 11642, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:36:53', '2026-06-05 15:36:53'),
(89, 10, 74, 'imag3.webp', 'img_6a233365037003.25851774.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a233365037003.25851774.webp', 12478, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:36:53', '2026-06-05 15:36:53'),
(90, 10, 75, 'imag4.webp', 'img_6a233365049f05.67194419.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a233365049f05.67194419.webp', 11492, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:36:53', '2026-06-05 15:36:53'),
(91, 11, 116, 'equipo1.webp', 'img_6a2333d47553f5.30876076.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2333d47553f5.30876076.webp', 11152, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:38:44', '2026-06-05 15:38:44'),
(92, 11, 126, 'equipo2.webp', 'img_6a2333d47c0e57.73089742.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2333d47c0e57.73089742.webp', 11962, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:38:44', '2026-06-05 15:38:44'),
(93, 11, 136, 'equipo3.webp', 'img_6a2333d4826628.53789928.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2333d4826628.53789928.webp', 11326, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:38:44', '2026-06-05 15:38:44'),
(94, 11, 140, 'equipo4.webp', 'img_6a2333d4864f87.10514477.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2333d4864f87.10514477.webp', 11934, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:38:44', '2026-06-05 15:38:44'),
(95, 11, 144, 'equipo5.webp', 'img_6a2333d488f9b5.10551021.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2333d488f9b5.10551021.webp', 9894, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:38:44', '2026-06-05 15:38:44'),
(96, 13, 158, 'icono1.webp', 'img_6a23346c2aa4e5.59628722.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c2aa4e5.59628722.webp', 1206, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(97, 13, 165, 'especialidad1.webp', 'img_6a23346c302982.01928581.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c302982.01928581.webp', 39148, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(98, 13, 170, 'icono2.webp', 'img_6a23346c335040.05410840.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c335040.05410840.webp', 2010, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(99, 13, 177, 'especialidad2.webp', 'img_6a23346c370ff2.78505361.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c370ff2.78505361.webp', 32442, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(100, 13, 182, 'icono3.webp', 'img_6a23346c39ea46.64375119.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c39ea46.64375119.webp', 2532, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(101, 13, 189, 'especialidad3.webp', 'img_6a23346c3df327.73597490.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c3df327.73597490.webp', 27654, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(102, 13, 194, 'icono4.webp', 'img_6a23346c411c79.70953100.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c411c79.70953100.webp', 2118, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(103, 13, 201, 'especialidad4.webp', 'img_6a23346c457764.34587021.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c457764.34587021.webp', 16870, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(104, 13, 206, 'icono5.webp', 'img_6a23346c485607.19045014.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c485607.19045014.webp', 1742, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(105, 13, 213, 'especialidad5.webp', 'img_6a23346c4c0326.15106225.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c4c0326.15106225.webp', 20536, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(106, 13, 218, 'icono6.webp', 'img_6a23346c4f9300.51001532.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c4f9300.51001532.webp', 1588, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(107, 13, 225, 'especialidad6.webp', 'img_6a23346c534960.60379079.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23346c534960.60379079.webp', 41656, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:41:16', '2026-06-05 15:41:16'),
(108, 14, 505, 'jyzaicon_1.webp', 'img_6a23367b1d34d6.29057624.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23367b1d34d6.29057624.webp', 8392, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:50:03', '2026-06-05 15:50:03'),
(109, 14, 519, 'rositasicon_1.webp', 'img_6a23367b266684.73081497.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23367b266684.73081497.webp', 10644, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:50:03', '2026-06-05 15:50:03'),
(110, 14, 533, 'cabanillasicon_1.webp', 'img_6a23367b2ebfc5.25865570.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23367b2ebfc5.25865570.webp', 9882, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:50:03', '2026-06-05 15:50:03'),
(111, 14, 547, 'sharkicon_1.webp', 'img_6a23367b361a41.39811850.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23367b361a41.39811850.webp', 10248, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:50:03', '2026-06-05 15:50:03'),
(112, 14, 562, 'Recurso 8 (1).png', 'img_6a23367b3d4920.22289504.png', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a23367b3d4920.22289504.png', 68058, 'image/png', NULL, NULL, NULL, 1, 1, '2026-06-05 15:50:03', '2026-06-05 15:50:03'),
(113, 15, 293, 'paquete1.webp', 'img_6a2337e0e376c4.45458156.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2337e0e376c4.45458156.webp', 764888, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:56:00', '2026-06-05 15:56:00'),
(114, 15, 304, 'paquete2.webp', 'img_6a2337e0eb6ec7.77134459.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2337e0eb6ec7.77134459.webp', 726030, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:56:00', '2026-06-05 15:56:00'),
(115, 15, 315, 'paquete3.webp', 'img_6a2337e0f0cb49.84795335.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2337e0f0cb49.84795335.webp', 826844, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:56:00', '2026-06-05 15:56:00'),
(116, 15, 326, 'paquete4.webp', 'img_6a2337e1025139.90764692.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2337e1025139.90764692.webp', 982970, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 15:56:01', '2026-06-05 15:56:01'),
(117, 16, 342, 'marianela.webp', 'img_6a2338d26be785.32973212.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d26be785.32973212.webp', 1062, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02'),
(118, 16, 348, 'karito.webp', 'img_6a2338d2714949.47226464.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d2714949.47226464.webp', 926, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02'),
(119, 16, 354, 'cori.webp', 'img_6a2338d274c628.56287602.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d274c628.56287602.webp', 1196, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02'),
(120, 16, 360, 'fiorella.webp', 'img_6a2338d2783704.81329853.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d2783704.81329853.webp', 1100, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02'),
(121, 16, 366, 'angelica.webp', 'img_6a2338d27b9396.99448357.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d27b9396.99448357.webp', 684, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02'),
(122, 16, 372, 'leydi.webp', 'img_6a2338d27fd363.05107006.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d27fd363.05107006.webp', 1010, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02'),
(123, 16, 378, 'daniela.webp', 'img_6a2338d2836087.24136736.webp', 'http://localhost/jyza_autoadministrable/jyza_autoadministrable/uploads/content/img_6a2338d2836087.24136736.webp', 1030, 'image/webp', NULL, NULL, NULL, 1, 1, '2026-06-05 16:00:02', '2026-06-05 16:00:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content_sections`
--

CREATE TABLE `content_sections` (
  `id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `content_sections`
--

INSERT INTO `content_sections` (`id`, `slug`, `title`, `description`, `metadata`, `is_active`, `sort_order`, `created_by`, `created`, `modified`) VALUES
(1, 'bienvenida', 'Sección Bienvenida', 'Hero/Bienvenida de la clínica', '{\"seo_title\": \"Clínica Ginecología Huánuco | Especialistas en Salud Femenina\", \"seo_description\": \"Clínica de ginecología y obstetricia en Huánuco. Más de 10 años de experiencia.\", \"og_image\": \"/og-bienvenida.png\", \"canonical\": \"https://jyza.com\"}', 1, 1, 1, '2026-05-31 12:35:50', '2026-05-31 12:35:50'),
(10, 'porqueelegirnos', 'Por Qué Elegirnos', 'Sección que muestra los beneficios y razones para elegir JYZA', NULL, 1, 2, 1, '2026-06-04 22:17:54', '2026-06-04 22:17:54'),
(11, 'especialistas', 'Especialistas', 'Sección de especialistas médicos', NULL, 1, 6, NULL, '2026-06-04 22:59:14', '2026-06-04 22:59:31'),
(13, 'especialidades', 'Especialidades', 'Sección de especialidades y servicios', NULL, 1, 5, NULL, '2026-06-04 23:14:02', '2026-06-04 23:14:02'),
(14, 'clubjyza', 'Club JYZA', 'Sección de convenios y club JYZA', NULL, 1, 7, NULL, '2026-06-04 23:21:15', '2026-06-04 23:21:15'),
(15, 'paquetes', 'Paquetes', 'Sección de paquetes promocionales', NULL, 1, 8, NULL, '2026-06-04 23:31:42', '2026-06-04 23:31:42'),
(16, 'testimonios', 'Testimonios', 'Sección de testimonios de pacientes', NULL, 1, 9, NULL, '2026-06-04 23:38:40', '2026-06-04 23:38:40'),
(17, 'citas', 'Citas', 'Sección de agendamiento de citas', NULL, 1, 10, NULL, '2026-06-05 00:35:33', '2026-06-05 00:35:33'),
(18, 'agendamiento', 'Agendamiento', 'Sección de agendamiento de citas', NULL, 1, 8, NULL, '2026-06-05 01:02:11', '2026-06-05 01:02:11'),
(19, 'comollegar', 'Cómo Llegar', 'Sección de ubicación y mapa', NULL, 1, 9, NULL, '2026-06-05 01:06:50', '2026-06-05 01:06:50'),
(20, 'indicadores', 'Indicadores', 'Sección de indicadores y estadísticas', NULL, 1, 10, NULL, '2026-06-05 01:25:12', '2026-06-05 01:25:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `content_versions`
--

CREATE TABLE `content_versions` (
  `id` int(11) UNSIGNED NOT NULL,
  `block_id` int(11) NOT NULL,
  `content_before` text DEFAULT NULL,
  `content_after` text DEFAULT NULL,
  `change_type` varchar(50) NOT NULL DEFAULT 'updated',
  `changed_by` int(11) NOT NULL,
  `change_reason` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20260531000000, 'CreateContentTables', '2026-05-31 12:14:52', '2026-05-31 12:14:52', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `data` text DEFAULT NULL,
  `expires` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES
('elr838dpt1mtk48e6igjncf961', 'Config|a:1:{s:4:\"time\";i:1780694645;}Auth|O:21:\"App\\Model\\Entity\\User\":13:{s:10:\"\0*\0_fields\";a:9:{s:2:\"id\";i:1;s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:60:\"$2y$10$pASpJPc9Lh8VEplQx0iZmOXL89ZFvkfKrW/53tQuKXa/ZSSjX2/aC\";s:3:\"rol\";i:1;s:3:\"dni\";s:8:\"12345678\";s:7:\"created\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-14 01:25:05.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:8:\"modified\";O:18:\"Cake\\I18n\\DateTime\":3:{s:4:\"date\";s:26:\"2025-12-17 22:29:45.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:12:\"America/Lima\";}s:6:\"estado\";s:6:\"activo\";s:7:\"nombres\";s:0:\"\";}s:12:\"\0*\0_original\";a:0:{}s:18:\"\0*\0_originalFields\";a:9:{i:0;s:2:\"id\";i:1;s:8:\"username\";i:2;s:8:\"password\";i:3;s:3:\"rol\";i:4;s:3:\"dni\";i:5;s:7:\"created\";i:6;s:8:\"modified\";i:7;s:6:\"estado\";i:8;s:7:\"nombres\";}s:10:\"\0*\0_hidden\";a:1:{i:0;s:8:\"password\";}s:11:\"\0*\0_virtual\";a:0:{}s:9:\"\0*\0_dirty\";a:0:{}s:7:\"\0*\0_new\";b:0;s:10:\"\0*\0_errors\";a:0:{}s:11:\"\0*\0_invalid\";a:0:{}s:14:\"\0*\0_accessible\";a:8:{s:8:\"username\";b:1;s:8:\"password\";b:1;s:3:\"rol\";b:1;s:6:\"estado\";b:1;s:7:\"created\";b:1;s:8:\"modified\";b:1;s:7:\"nombres\";b:1;s:3:\"dni\";b:1;}s:17:\"\0*\0_registryAlias\";s:5:\"Users\";s:18:\"\0*\0_hasBeenVisited\";b:0;s:23:\"\0*\0requireFieldPresence\";b:0;}Flash|a:0:{}', 1780709045);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` int(11) NOT NULL COMMENT '1=admin, 2=docente, 3=estudiante',
  `dni` varchar(20) NOT NULL DEFAULT '00000000',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'activo' COMMENT 'activo/inactivo',
  `nombres` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rol`, `dni`, `created`, `modified`, `estado`, `nombres`) VALUES
(1, 'admin', '$2y$10$pASpJPc9Lh8VEplQx0iZmOXL89ZFvkfKrW/53tQuKXa/ZSSjX2/aC', 1, '12345678', '2025-12-14 01:25:05', '2025-12-17 22:29:45', 'activo', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_type` (`entity_type`,`entity_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created` (`created`);

--
-- Indices de la tabla `content_blocks`
--
ALTER TABLE `content_blocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_id_2` (`section_id`,`block_key`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `block_type` (`block_type`);

--
-- Indices de la tabla `content_cache`
--
ALTER TABLE `content_cache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_slug` (`section_slug`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Indices de la tabla `content_images`
--
ALTER TABLE `content_images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stored_filename` (`stored_filename`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `block_id` (`block_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indices de la tabla `content_sections`
--
ALTER TABLE `content_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `is_active` (`is_active`),
  ADD KEY `created_by` (`created_by`);

--
-- Indices de la tabla `content_versions`
--
ALTER TABLE `content_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_id` (`block_id`),
  ADD KEY `changed_by` (`changed_by`),
  ADD KEY `created` (`created`);

--
-- Indices de la tabla `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `content_blocks`
--
ALTER TABLE `content_blocks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=578;

--
-- AUTO_INCREMENT de la tabla `content_cache`
--
ALTER TABLE `content_cache`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `content_images`
--
ALTER TABLE `content_images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `content_sections`
--
ALTER TABLE `content_sections`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `content_versions`
--
ALTER TABLE `content_versions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `content_blocks`
--
ALTER TABLE `content_blocks`
  ADD CONSTRAINT `content_blocks_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `content_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `content_images`
--
ALTER TABLE `content_images`
  ADD CONSTRAINT `content_images_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `content_sections` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `content_images_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `content_blocks` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `content_images_ibfk_3` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `content_sections`
--
ALTER TABLE `content_sections`
  ADD CONSTRAINT `content_sections_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

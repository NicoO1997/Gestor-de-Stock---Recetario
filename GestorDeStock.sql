-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para stock
CREATE DATABASE IF NOT EXISTS `stock` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `stock`;

-- Volcando estructura para tabla stock.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla stock.doctrine_migration_versions: ~12 rows (aproximadamente)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20240910000000', '2024-09-10 15:33:04', 14),
	('DoctrineMigrations\\Version20240910145607', '2024-09-10 14:56:12', 150),
	('DoctrineMigrations\\Version20240910152048', '2024-09-10 15:24:17', 45),
	('DoctrineMigrations\\Version20240910152421', '2024-09-10 15:33:04', 2),
	('DoctrineMigrations\\Version20240912152811', '2024-09-12 15:28:20', 18),
	('DoctrineMigrations\\Version20240912155953', '2024-09-12 17:59:58', 128),
	('DoctrineMigrations\\Version20240912201846', '2024-09-12 20:18:52', 17),
	('DoctrineMigrations\\Version20240912202118', '2024-09-12 20:21:26', 11),
	('DoctrineMigrations\\Version20240913203343', NULL, NULL),
	('DoctrineMigrations\\Version20240913203548', '2024-09-13 20:36:55', 3),
	('DoctrineMigrations\\Version20241028202847', '2024-10-28 20:28:56', 20),
	('DoctrineMigrations\\Version20241029201709', '2024-10-29 21:17:17', 132);

-- Volcando estructura para tabla stock.maquinaria
CREATE TABLE IF NOT EXISTS `maquinaria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cantidad` int NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anios_uso` int DEFAULT NULL,
  `ultimo_service` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.maquinaria: ~6 rows (aproximadamente)
INSERT INTO `maquinaria` (`id`, `cantidad`, `nombre`, `marca`, `descripcion`, `imagen`, `anios_uso`, `ultimo_service`) VALUES
	(32, 1, 'Tractor 6E', 'John Deere', 'Tractor ideal para todo lo que necesita en el campo: tecnología, innovación y comodidad.', '6744b3e7b6b26.avif', 1, '2024-07-11 16:30:00'),
	(33, 1, 'Tractor 6J', 'John Deere', 'Motor agrícola John Deere de 6,8L y 6 cilindros de 170 hp. Transmisión PowrQuad con 16 marchas de avance y 16 de retroceso. Chasis de acero de diseño integral. Sistema Caster-action de inclinación de rueda (12º). Equipado de fábrica con sistema de gerenciamiento agrícola ATI ready. Opcional de rodado simple o dual', '6744b480012bb.avif', 1, '2024-02-27 19:30:00'),
	(34, 2, 'Cosechadora Serie S550', 'John Deere', 'Motor John Deere Power Tech 6,8 L, 275 hp. Trilla y separación mediante rotor (Diámetro: 610mm, Longitud del rotor:3130mm). Capacidad de tolva: 8800 L. Velocidad de descarga 78 L/s (aproximadamente en 2 min.)', '6744b4df2977c.avif', 1, '2023-06-06 08:50:00'),
	(35, 1, 'Cosechadora de Caña CH570', 'John Deere', 'Control automático de altura de cortador base. Aumento de la capacidad operativa y un menor consumo de combustible – Econoflow. Mejor capacidad de servicio para un mantenimiento aún más rápido. Comodidad y simplicidad operacional.', '6744b58e7f4aa.avif', 1, '2023-03-06 09:00:00'),
	(36, 1, 'Sembradora 1770NT', 'John Deere', 'Disponible en 5 unidades de hilera MaxEmerge™ de 56 l o 106 l (1,6 bu o 3 bu) Opción de insecticida para 56 l (1,6 bu). Configuraciones de 4, 6 y 8 hileras', '6744b5f1bdd30.jpg', 1, '2023-03-20 09:00:00'),
	(37, 1, 'Sembradora Case IH Early Riser 1245', 'CASE', 'Transición de un ancho operativo de 40 pies a 12 pies para transporte, con opciones de 12, 16 y 24 filas, junto con espaciado de 15", 20" o 30".', '6744b69d2c733.jpg', 1, '2022-09-25 09:00:00');

-- Volcando estructura para tabla stock.maquinaria_receta
CREATE TABLE IF NOT EXISTS `maquinaria_receta` (
  `maquinaria_id` int NOT NULL,
  `receta_id` int NOT NULL,
  PRIMARY KEY (`maquinaria_id`,`receta_id`),
  KEY `IDX_FD58504FAA2E8BF` (`maquinaria_id`),
  KEY `IDX_FD58504F54F853F8` (`receta_id`),
  CONSTRAINT `FK_FD58504F54F853F8` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FD58504FAA2E8BF` FOREIGN KEY (`maquinaria_id`) REFERENCES `maquinaria` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.maquinaria_receta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla stock.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.messenger_messages: ~0 rows (aproximadamente)

-- Volcando estructura para tabla stock.receta
CREATE TABLE IF NOT EXISTS `receta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B093494EA76ED395` (`user_id`),
  CONSTRAINT `FK_B093494EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.receta: ~3 rows (aproximadamente)
INSERT INTO `receta` (`id`, `descripcion`, `nombre`, `user_id`) VALUES
	(33, 'Tractor John Deere 6120E con 118 hp y transmisión 12F/12R PowrReverser™, compatible con agricultura de precisión.', 'Tractor 6E', NULL),
	(34, 'Eficientes sistemas hidráulicos, de transmisión y electrónicos que permiten facilidad de mantenimiento.', 'Tractor 6J', NULL),
	(35, 'Sistema de cosecha más moderno de trilla, separación y limpieza, por su gran capacidad de tolva y velocidad de descarga, con una longitud del tubo 6,6m. Compatible con plataformas de 30 pies.', 'Cosechadora Serie S550', NULL);

-- Volcando estructura para tabla stock.receta_repuesto
CREATE TABLE IF NOT EXISTS `receta_repuesto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `receta_id` int NOT NULL,
  `repuesto_id` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E70625C54F853F8` (`receta_id`),
  KEY `IDX_6E70625C4C3B689E` (`repuesto_id`),
  CONSTRAINT `FK_6E70625C4C3B689E` FOREIGN KEY (`repuesto_id`) REFERENCES `repuestos` (`id`),
  CONSTRAINT `FK_6E70625C54F853F8` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.receta_repuesto: ~26 rows (aproximadamente)
INSERT INTO `receta_repuesto` (`id`, `receta_id`, `repuesto_id`, `cantidad`) VALUES
	(126, 33, 25, 1),
	(127, 33, 26, 1),
	(128, 33, 27, 1),
	(129, 33, 28, 1),
	(130, 33, 32, 1),
	(131, 33, 33, 1),
	(132, 33, 35, 1),
	(152, 35, 25, 1),
	(153, 35, 26, 1),
	(154, 35, 27, 1),
	(155, 35, 28, 1),
	(156, 35, 29, 1),
	(157, 35, 30, 1),
	(158, 35, 31, 1),
	(159, 35, 32, 1),
	(160, 35, 33, 1),
	(161, 35, 34, 1),
	(162, 35, 35, 1),
	(163, 35, 36, 1),
	(164, 34, 25, 1),
	(165, 34, 26, 1),
	(166, 34, 27, 1),
	(167, 34, 28, 3),
	(168, 34, 33, 1),
	(169, 34, 34, 1),
	(170, 34, 35, 1);

-- Volcando estructura para tabla stock.repuestos
CREATE TABLE IF NOT EXISTS `repuestos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `stock_minimo` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.repuestos: ~12 rows (aproximadamente)
INSERT INTO `repuestos` (`id`, `nombre`, `descripcion`, `cantidad`, `stock_minimo`) VALUES
	(25, 'Motor', 'Corazón de la cosechadora', 7, 7),
	(26, 'Caja de cambios', 'Permite gestionar el esfuerzo del motor distribuyendolo en distintas transmisiones.', 5, 3),
	(27, 'Dirección', 'Repuesto mecánico que permite direccionar el vehiculo.', 5, 4),
	(28, 'Toma de fuerza', 'Potenciador de la cosechadora.', 5, 5),
	(29, 'Sistema de recolección', 'Permite el rastrillaje de granos a la hora de llevarse a cabo la cosecha.', 6, 8),
	(30, 'Sistema de trilla', 'Permite realizar la limpieza de los granos cuando se encuentran en el cóncavo.', 5, 4),
	(31, 'Sistema de transporte de grano', 'Permite distribuir el grano dentro de la cosechadora según sea necesario.', 7, 8),
	(32, 'Sistema de control', 'Conjunto de sensores, cables, interruptores y módulos de control que se manejan desde la parte electrónica de la máquina.', 4, 2),
	(33, 'Chasis', 'Estructura metálica principal con vigas, soportes y refuerzos.', 6, 8),
	(34, 'Sistema hidráulico', 'Compuesto por bombas hidráulicas, válvulas hidráulicas, mangueras, tubos hidráulicos, filtros y despósito de aceite hidráulico.', 4, 4),
	(35, 'Sistema de protección y seguridad', 'Compuesto por extintores de incendios, barras de protección, señales de advertencia e interruptores de emergencia.', 8, 5),
	(36, 'Sistema de limpieza', 'Compuesto por cepillos de limpieza, mangueras de aire comprimido, cubiertas de protección contra polvo y sistema de aspiración.', 5, 6);

-- Volcando estructura para tabla stock.repuestos_receta
CREATE TABLE IF NOT EXISTS `repuestos_receta` (
  `repuestos_id` int NOT NULL,
  `receta_id` int NOT NULL,
  PRIMARY KEY (`repuestos_id`,`receta_id`),
  KEY `IDX_D52AF928F08A380E` (`repuestos_id`),
  KEY `IDX_D52AF92854F853F8` (`receta_id`),
  CONSTRAINT `FK_D52AF92854F853F8` FOREIGN KEY (`receta_id`) REFERENCES `receta` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D52AF928F08A380E` FOREIGN KEY (`repuestos_id`) REFERENCES `repuestos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.repuestos_receta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla stock.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.user: ~9 rows (aproximadamente)
INSERT INTO `user` (`id`, `direccion`, `password`, `nombre`, `apellido`, `telefono`, `email`, `roles`) VALUES
	(1, NULL, '$2y$13$upqwr7kjyMgmsB07NFv2TeYZiFx9.L4kiRufC7r4P6Jwuq2iLePwO', NULL, NULL, NULL, 'nicol4cho1997@gmail.com', '[]'),
	(2, NULL, '$2y$13$KKMZL8UwvgKDMHA3jUC8XuPkKHtS9SLemJ8EbWpegzt4H5Q9vkAZu', NULL, NULL, NULL, 'nico123@gmail.com', '[]'),
	(5, NULL, '$2y$13$DzInyclfdH12o2lPI.QPcuQ7TOybhJJs9.FvWlVHXZOHwGME9.SSW', NULL, NULL, NULL, 'nico123@hotmail.com', '[]'),
	(6, NULL, '$2y$13$XdSk33jqDCcv6XNsITfhrex1sSv2Li9Mt5G.m/Wp9THCCcz28WAFm', NULL, NULL, NULL, 'nicoO@gmail.com', '[]'),
	(7, NULL, '$2y$13$wQ/VTurNHGMzkW6RKLrbRetx5fST5HMrTufg1DeHzj3G6hoxD8juq', NULL, NULL, NULL, 'nico390494@gmail.com', '[]'),
	(8, NULL, '$2y$13$DvsAatR2DjRiPspmRBrFw.8SekHbJ2dgWdAhC6Gk.QEAJOr5/ZJMm', NULL, NULL, NULL, 'nico@hotmail.com', '[]'),
	(9, NULL, '$2y$13$V26k7/mj2icu0zZXu5NXOeosCSB1SWvFznEwh49EcQ/Cr63XsPHr.', NULL, NULL, NULL, 'nico1234@gmail.com', '[]'),
	(10, NULL, '$2y$13$NcPXT6isxtuawVVcaAlyBue0QLk.VA4LAy2iOMN8r1j1Ql3vYtzbC', NULL, NULL, NULL, 'herman@gmail.com', '[]'),
	(11, NULL, '$2y$13$bzRPWMZZxdAXEgVjp0QgFuq3eAMVqyZOyU1F3lTQpYEY8ZlvCfLdm', NULL, NULL, NULL, 'hernan@gmail.com', '[]');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

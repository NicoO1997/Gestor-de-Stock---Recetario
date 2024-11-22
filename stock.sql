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
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla stock.doctrine_migration_versions: ~8 rows (aproximadamente)
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
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anios_uso` int DEFAULT NULL,
  `ultimo_service` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.maquinaria: ~2 rows (aproximadamente)
INSERT INTO `maquinaria` (`id`, `cantidad`, `nombre`, `marca`, `descripcion`, `imagen`, `anios_uso`, `ultimo_service`) VALUES
	(15, 17, 'liggerini', 'alu', 'we', '67267b8fdc3e3.jpeg?v=1730575247', 2, NULL),
	(30, 2, 'Holanda', 'asddas', 'asdasdasdas', NULL, 2, NULL);

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
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B093494EA76ED395` (`user_id`),
  CONSTRAINT `FK_B093494EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.receta: ~3 rows (aproximadamente)
INSERT INTO `receta` (`id`, `descripcion`, `nombre`, `user_id`) VALUES
	(25, 'xd', 'xd', NULL),
	(26, 'OGTHJOTOJYHO', 'OGHJNOHJMO', NULL),
	(32, 'Nico', 'NICO', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.receta_repuesto: ~8 rows (aproximadamente)
INSERT INTO `receta_repuesto` (`id`, `receta_id`, `repuesto_id`, `cantidad`) VALUES
	(103, 32, 18, 24),
	(104, 32, 19, 23),
	(105, 32, 21, 22),
	(117, 26, 15, 2),
	(118, 26, 18, 3),
	(119, 26, 19, 4),
	(120, 25, 3, 5),
	(121, 25, 15, 6);

-- Volcando estructura para tabla stock.repuestos
CREATE TABLE IF NOT EXISTS `repuestos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `stock_minimo` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.repuestos: ~7 rows (aproximadamente)
INSERT INTO `repuestos` (`id`, `nombre`, `descripcion`, `cantidad`, `stock_minimo`) VALUES
	(3, 'asdfasdasdas', 'asdasdasdas', 17, 23),
	(15, 'ASDASDASD', 'ASDASDASDASD', 14, 12),
	(18, 'asdfgh3', '123435', 2, 2),
	(19, 'PIFNGHJMOPIKNLBFGLKJBGF', 'pikodnmfghbnpkbgfdpkndfgbpklgdfb', 23, 11),
	(20, 'AHOLA', 'HOLA', 2, 2),
	(21, 'PROBANDO', 'PROBANDO', 23, 5);

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
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla stock.user: ~7 rows (aproximadamente)
INSERT INTO `user` (`id`, `direccion`, `password`, `nombre`, `apellido`, `telefono`, `email`, `roles`) VALUES
	(1, NULL, '$2y$13$upqwr7kjyMgmsB07NFv2TeYZiFx9.L4kiRufC7r4P6Jwuq2iLePwO', NULL, NULL, NULL, 'nicol4cho1997@gmail.com', '[]'),
	(2, NULL, '$2y$13$KKMZL8UwvgKDMHA3jUC8XuPkKHtS9SLemJ8EbWpegzt4H5Q9vkAZu', NULL, NULL, NULL, 'nico123@gmail.com', '[]'),
	(5, NULL, '$2y$13$DzInyclfdH12o2lPI.QPcuQ7TOybhJJs9.FvWlVHXZOHwGME9.SSW', NULL, NULL, NULL, 'nico123@hotmail.com', '[]'),
	(6, NULL, '$2y$13$XdSk33jqDCcv6XNsITfhrex1sSv2Li9Mt5G.m/Wp9THCCcz28WAFm', NULL, NULL, NULL, 'nicoO@gmail.com', '[]'),
	(7, NULL, '$2y$13$wQ/VTurNHGMzkW6RKLrbRetx5fST5HMrTufg1DeHzj3G6hoxD8juq', NULL, NULL, NULL, 'nico390494@gmail.com', '[]'),
	(8, NULL, '$2y$13$DvsAatR2DjRiPspmRBrFw.8SekHbJ2dgWdAhC6Gk.QEAJOr5/ZJMm', NULL, NULL, NULL, 'nico@hotmail.com', '[]'),
	(9, NULL, '$2y$13$V26k7/mj2icu0zZXu5NXOeosCSB1SWvFznEwh49EcQ/Cr63XsPHr.', NULL, NULL, NULL, 'nico1234@gmail.com', '[]');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

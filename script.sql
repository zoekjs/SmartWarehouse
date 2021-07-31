-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.4.12-MariaDB-log - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para smartwarehouse
CREATE DATABASE IF NOT EXISTS `smartwarehouse` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `smartwarehouse`;

-- Volcando estructura para tabla smartwarehouse.category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.client
CREATE TABLE IF NOT EXISTS `client` (
  `rut_client` varchar(9) NOT NULL,
  `id_country` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rut_client`),
  KEY `fk_country_client` (`id_country`),
  CONSTRAINT `fk_country_client` FOREIGN KEY (`id_country`) REFERENCES `country` (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.commune
CREATE TABLE IF NOT EXISTS `commune` (
  `id_commune` int(11) NOT NULL,
  `id_region` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_commune`),
  KEY `fk_region_commune` (`id_region`),
  CONSTRAINT `fk_region_commune` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.country
CREATE TABLE IF NOT EXISTS `country` (
  `id_country` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.egress
CREATE TABLE IF NOT EXISTS `egress` (
  `id_egress` int(11) NOT NULL,
  `rut_user` varchar(9) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_egress`),
  KEY `fk_user_egress` (`rut_user`),
  CONSTRAINT `fk_user_egress` FOREIGN KEY (`rut_user`) REFERENCES `users` (`rut_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.ingress
CREATE TABLE IF NOT EXISTS `ingress` (
  `id_ingress` int(11) NOT NULL,
  `rut_user` varchar(9) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_ingress`),
  KEY `fk_status_ingress` (`id_status`),
  KEY `fk_user_ingress` (`rut_user`),
  CONSTRAINT `fk_status_ingress` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`),
  CONSTRAINT `fk_user_ingress` FOREIGN KEY (`rut_user`) REFERENCES `users` (`rut_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.ingress_provider
CREATE TABLE IF NOT EXISTS `ingress_provider` (
  `id_ingress_rut_provider` int(11) NOT NULL AUTO_INCREMENT,
  `rut_provider` varchar(9) DEFAULT NULL,
  `id_ingress` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_ingress_rut_provider`),
  KEY `fk_ingress_provider` (`rut_provider`),
  KEY `fk_ingress_provider2` (`id_ingress`),
  CONSTRAINT `fk_ingress_provider` FOREIGN KEY (`rut_provider`) REFERENCES `provider` (`rut_provider`),
  CONSTRAINT `fk_ingress_provider2` FOREIGN KEY (`id_ingress`) REFERENCES `ingress` (`id_ingress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.log
CREATE TABLE IF NOT EXISTS `log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(150) DEFAULT NULL,
  `rut_user` varchar(9) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.money
CREATE TABLE IF NOT EXISTS `money` (
  `id_money` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_money`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.payment_method
CREATE TABLE IF NOT EXISTS `payment_method` (
  `id_payment` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_payment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.payment_status
CREATE TABLE IF NOT EXISTS `payment_status` (
  `id_payment_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_payment_status`),
  KEY `id_payment_status` (`id_payment_status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.product
CREATE TABLE IF NOT EXISTS `product` (
  `id_product` varchar(50) NOT NULL,
  `id_category` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_product`),
  KEY `fk_category_product` (`id_category`),
  CONSTRAINT `fk_category_product` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.product_egress
CREATE TABLE IF NOT EXISTS `product_egress` (
  `id_product_egress` int(11) NOT NULL AUTO_INCREMENT,
  `id_egress` int(11) DEFAULT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_product_egress`),
  KEY `fk_product_egress` (`id_egress`),
  KEY `fk_product_egress2` (`id_product`),
  CONSTRAINT `fk_product_egress` FOREIGN KEY (`id_egress`) REFERENCES `egress` (`id_egress`),
  CONSTRAINT `fk_product_egress2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.product_ingress
CREATE TABLE IF NOT EXISTS `product_ingress` (
  `id_product_ingress` int(11) NOT NULL AUTO_INCREMENT,
  `id_ingress` int(11) DEFAULT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_product_ingress`),
  KEY `fk_product_ingress` (`id_ingress`),
  KEY `fk_product_ingress2` (`id_product`),
  CONSTRAINT `fk_product_ingress` FOREIGN KEY (`id_ingress`) REFERENCES `ingress` (`id_ingress`),
  CONSTRAINT `fk_product_ingress2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.product_purchase_order
CREATE TABLE IF NOT EXISTS `product_purchase_order` (
  `id_product_purchase_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_purchase_order` int(11) DEFAULT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `total` float DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_product_purchase_order`),
  KEY `fk_product_puchase_order` (`id_purchase_order`),
  KEY `fk_product_puchase_order2` (`id_product`),
  CONSTRAINT `fk_product_puchase_order` FOREIGN KEY (`id_purchase_order`) REFERENCES `purchase_order` (`id_purchase_order`),
  CONSTRAINT `fk_product_puchase_order2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.product_quotation
CREATE TABLE IF NOT EXISTS `product_quotation` (
  `id_product_quotation` int(11) NOT NULL AUTO_INCREMENT,
  `id_quotation` int(11) DEFAULT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_product_quotation`),
  KEY `fk_product_quotation` (`id_quotation`),
  KEY `fk_product_quotation2` (`id_product`),
  CONSTRAINT `fk_product_quotation` FOREIGN KEY (`id_quotation`) REFERENCES `quotation` (`id_quotation`),
  CONSTRAINT `fk_product_quotation2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.provider
CREATE TABLE IF NOT EXISTS `provider` (
  `rut_provider` varchar(10) NOT NULL,
  `id_country` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rut_provider`),
  KEY `fk_country_provider` (`id_country`),
  CONSTRAINT `fk_country_provider` FOREIGN KEY (`id_country`) REFERENCES `country` (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.provider_commune
CREATE TABLE IF NOT EXISTS `provider_commune` (
  `id_provider_commune` int(11) NOT NULL AUTO_INCREMENT,
  `id_commune` int(11) DEFAULT NULL,
  `rut_provider` varchar(9) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_provider_commune`),
  KEY `fk_provider_commune` (`id_commune`),
  KEY `fk_provider_commune2` (`rut_provider`),
  CONSTRAINT `fk_provider_commune` FOREIGN KEY (`id_commune`) REFERENCES `commune` (`id_commune`),
  CONSTRAINT `fk_provider_commune2` FOREIGN KEY (`rut_provider`) REFERENCES `provider` (`rut_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.provider_product
CREATE TABLE IF NOT EXISTS `provider_product` (
  `id_provider_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` varchar(50) DEFAULT NULL,
  `rut_provider` varchar(9) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_provider_product`),
  KEY `fk_provider_product` (`id_product`),
  KEY `fk_provider_product2` (`rut_provider`),
  CONSTRAINT `fk_provider_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`),
  CONSTRAINT `fk_provider_product2` FOREIGN KEY (`rut_provider`) REFERENCES `provider` (`rut_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.provider_region
CREATE TABLE IF NOT EXISTS `provider_region` (
  `id_provider_region` int(11) NOT NULL AUTO_INCREMENT,
  `id_region` int(11) DEFAULT NULL,
  `rut_provider` varchar(9) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_provider_region`),
  KEY `fk_provider_region` (`id_region`),
  KEY `fk_provider_region2` (`rut_provider`),
  CONSTRAINT `fk_provider_region` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`),
  CONSTRAINT `fk_provider_region2` FOREIGN KEY (`rut_provider`) REFERENCES `provider` (`rut_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.purchase_order
CREATE TABLE IF NOT EXISTS `purchase_order` (
  `id_purchase_order` int(11) NOT NULL AUTO_INCREMENT,
  `id_payment_status` int(11) NOT NULL DEFAULT 0,
  `id_payment` int(11) NOT NULL,
  `rut_user` varchar(9) NOT NULL,
  `id_money` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `rut_provider` varchar(9) NOT NULL,
  `date` datetime DEFAULT NULL,
  `neto` float DEFAULT NULL,
  `iva` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `observation` varchar(150) DEFAULT NULL,
  `observation_payment` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reason` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_purchase_order`),
  KEY `fk_status_purchase_order` (`id_status`),
  KEY `fk_money_purchase_order` (`id_money`),
  KEY `fk_user_purchase_order` (`rut_user`),
  KEY `fk_provider_purchase_order` (`rut_provider`),
  KEY `fk_payment_method_purchase_order` (`id_payment`),
  KEY `id_payment_status` (`id_payment_status`),
  CONSTRAINT `fk_money_purchase_order` FOREIGN KEY (`id_money`) REFERENCES `money` (`id_money`),
  CONSTRAINT `fk_payment_method_purchase_order` FOREIGN KEY (`id_payment`) REFERENCES `payment_method` (`id_payment`),
  CONSTRAINT `fk_payment_status` FOREIGN KEY (`id_payment_status`) REFERENCES `payment_status` (`id_payment_status`),
  CONSTRAINT `fk_provider_purchase_order` FOREIGN KEY (`rut_provider`) REFERENCES `provider` (`rut_provider`),
  CONSTRAINT `fk_status_purchase_order` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`),
  CONSTRAINT `fk_user_purchase_order` FOREIGN KEY (`rut_user`) REFERENCES `users` (`rut_user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.quotation
CREATE TABLE IF NOT EXISTS `quotation` (
  `id_quotation` int(11) NOT NULL,
  `id_money` int(11) DEFAULT NULL,
  `rut_user` varchar(9) DEFAULT NULL,
  `rut_client` varchar(9) DEFAULT NULL,
  `commentary` varchar(150) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_quotation`),
  KEY `fk_client_quotation` (`rut_client`),
  KEY `fk_money_quotation` (`id_money`),
  KEY `fk_user_quotation` (`rut_user`),
  CONSTRAINT `fk_client_quotation` FOREIGN KEY (`rut_client`) REFERENCES `client` (`rut_client`),
  CONSTRAINT `fk_money_quotation` FOREIGN KEY (`id_money`) REFERENCES `money` (`id_money`),
  CONSTRAINT `fk_user_quotation` FOREIGN KEY (`rut_user`) REFERENCES `users` (`rut_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.region
CREATE TABLE IF NOT EXISTS `region` (
  `id_region` int(11) NOT NULL,
  `id_country` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_region`),
  KEY `fk_country_region` (`id_country`),
  CONSTRAINT `fk_country_region` FOREIGN KEY (`id_country`) REFERENCES `country` (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.status
CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.type_document
CREATE TABLE IF NOT EXISTS `type_document` (
  `id_type_document` int(11) NOT NULL AUTO_INCREMENT,
  `id_ingress` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_type_document`),
  KEY `fk_ingress_type_document` (`id_ingress`),
  CONSTRAINT `fk_ingress_type_document` FOREIGN KEY (`id_ingress`) REFERENCES `ingress` (`id_ingress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla smartwarehouse.users
CREATE TABLE IF NOT EXISTS `users` (
  `rut_user` varchar(9) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rut_user`),
  KEY `fk_roles_users` (`role_id`),
  CONSTRAINT `fk_roles_users` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


-- Volcando estructura para tabla smartwarehouse.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


-- Volcando estructura para tabla smartwarehouse.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id_tag` varchar(120) NOT NULL,
  `id_product` varchar(50) DEFAULT NULL,
  `enable` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tag`),
  KEY `fk_id_product` (`id_product`),
  CONSTRAINT `fk_id_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


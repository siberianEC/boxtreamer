-- Adminer 4.8.1 MySQL 8.0.29-0ubuntu0.22.04.3 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `boxtreamer` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `boxtreamer`;

DROP TABLE IF EXISTS `ArchivoTransaccion`;
CREATE TABLE `ArchivoTransaccion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` int NOT NULL,
  `id_tipo` int NOT NULL,
  `archivo` varchar(300) NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ArchivoTransaccionDetalle`;
CREATE TABLE `ArchivoTransaccionDetalle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `archivoTransaccion` int NOT NULL,
  `idCliente` int NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `archivoTransaccion` (`archivoTransaccion`),
  CONSTRAINT `ArchivoTransaccionDetalle_ibfk_1` FOREIGN KEY (`archivoTransaccion`) REFERENCES `ArchivoTransaccion` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `archivos`;
CREATE TABLE `archivos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `archivos` (`id`, `nombre`, `descripcion`, `estado`, `fecha`) VALUES
(1,	'cierre.mp3',	'Cerrar el comisariato',	1,	'2018-12-07 17:55:10'),
(2,	'hate.mp3',	'',	2,	'2018-09-19 00:22:05'),
(3,	'publi.mp3',	'',	1,	'2018-09-18 18:34:58'),
(6,	'pan.mp3',	'El pan está listo',	1,	'2018-09-18 18:33:25'),
(7,	'IevanPolkka-HatsuneMiku10hours.mp3',	'bnm',	1,	'2018-09-18 21:35:21');

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grupo` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cliente` (`id`, `grupo`, `nombre`, `ip`, `estado`, `fecha`) VALUES
(1,	1,	'test',	'192.168.1.205',	1,	'2018-09-06 21:41:46'),
(3,	2,	'test',	'452',	0,	'2018-09-03 16:00:52'),
(4,	3,	'a1',	'192.168.1.4',	0,	'2018-09-06 21:29:26'),
(5,	4,	'personal',	'192.168.1.203',	1,	'2018-09-07 01:37:23'),
(6,	4,	'test2',	'192.168.1.204',	1,	'2018-09-11 18:39:45');

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `datos` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `configuracion` (`id`, `nombre`, `datos`, `fecha`) VALUES
(1,	'ip_address',	'10.21.123.228/27',	'2022-08-23 18:01:16'),
(2,	'ip_dns1',	'172.18.10.110',	'2018-10-10 16:12:02'),
(3,	'ip_dns2',	'172.18.10.111',	'2018-10-10 16:12:02'),
(4,	'ip_gateway',	'10.21.123.225',	'2022-08-23 18:01:16'),
(5,	'ip_netmask',	'255.255.255.0',	'2022-06-15 16:52:18'),
(6,	'ruta',	'/var/www/html/assets/media/',	'2018-08-17 20:21:50'),
(10,	'volumen',	'800',	'2018-09-12 01:21:06'),
(11,	'reproduciendo ahora',	'',	'2022-09-16 01:46:58'),
(12,	'licencia',	'THWYR-Y553Q-71V7H-L8KLL',	'2022-06-16 04:20:54');

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `grupo` (`id`, `nombre`, `estado`, `fecha`) VALUES
(1,	'guayas',	1,	'2018-09-06 22:56:01'),
(2,	'aasd',	0,	'2018-09-04 16:43:01'),
(3,	'aaa3',	0,	'2018-09-06 20:07:26'),
(4,	'quito',	1,	'2018-09-07 01:37:12');

DROP TABLE IF EXISTS `programacion`;
CREATE TABLE `programacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prioridad` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_ini` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `dias` varchar(100) NOT NULL,
  `repeticiones` varchar(10) NOT NULL DEFAULT '1',
  `volumen` int NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `OrderByMaster` int NOT NULL DEFAULT '0',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `programacion` (`id`, `prioridad`, `nombre`, `fecha_ini`, `fecha_fin`, `dias`, `repeticiones`, `volumen`, `estado`, `OrderByMaster`, `fecha`) VALUES
(1,	1,	'http://10.11.7.56:8000/stream',	'1996-08-23 06:00:00',	'2996-08-23 23:59:59',	'0',	'999999999',	80,	1,	0,	'2022-09-06 22:11:19');

DROP TABLE IF EXISTS `programacionMaster`;
CREATE TABLE `programacionMaster` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` int NOT NULL,
  `id_tipo` int NOT NULL,
  `prioridad` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_ini` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `dias` varchar(100) NOT NULL,
  `repeticiones` varchar(10) NOT NULL DEFAULT '1',
  `volumen` int NOT NULL,
  `estado` int NOT NULL DEFAULT '1',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` int NOT NULL DEFAULT '1',
  `user` varchar(60) NOT NULL,
  `pass` varchar(300) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `tipo`, `user`, `pass`, `fecha`) VALUES
(1,	1,	'admin',	'7853d8ab26bae21fcb39fddc54eb7917497e129f',	'2018-09-12 00:12:58'),
(2,	2,	'master',	'40bd001563085fc35165329ea1ff5c5ecbdbbeef',	'2018-08-31 18:45:58'),
(3,	3,	'panaderia',	'85ba025d28da28e09d723d222efc486e89e7ee12',	'2018-10-10 05:00:33');

-- 2022-09-16 02:06:42

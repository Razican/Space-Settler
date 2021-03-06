-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-06-2012 a las 17:05:08
-- Versión del servidor: 5.5.24
-- Versión de PHP: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `space-settler`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_admin`
--
-- Creación: 16-04-2012 a las 17:56:11
-- Última actualización: 16-04-2012 a las 17:56:11
--

DROP TABLE IF EXISTS `sps_admin`;
CREATE TABLE IF NOT EXISTS `sps_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` char(40) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `authlevel` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_bodies`
--
-- Creación: 16-04-2012 a las 17:56:11
-- Última actualización: 16-04-2012 a las 17:56:11
--

DROP TABLE IF EXISTS `sps_bodies`;
CREATE TABLE IF NOT EXISTS `sps_bodies` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `star` mediumint(8) unsigned NOT NULL,
  `position` tinyint(2) unsigned DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `terrestrial` tinyint(1) unsigned NOT NULL,
  `double_planet` tinyint(1) NOT NULL,
  `planet` bigint(20) unsigned DEFAULT NULL,
  `mass` bigint(17) unsigned NOT NULL,
  `radius` int(8) unsigned NOT NULL,
  `density` mediumint(7) unsigned NOT NULL,
  `distance` mediumint(8) unsigned NOT NULL,
  `habitable` tinyint(1) unsigned NOT NULL,
  `water` smallint(5) unsigned NOT NULL,
  `owner` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_sessions`
--
-- Creación: 13-06-2012 a las 21:33:34
--

DROP TABLE IF EXISTS `sps_sessions`;
CREATE TABLE IF NOT EXISTS `sps_sessions` (
  `session_id` char(32) NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `user_data` text,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_stars`
--
-- Creación: 17-06-2012 a las 15:03:27
-- Última actualización: 17-06-2012 a las 15:03:27
--

DROP TABLE IF EXISTS `sps_stars`;
CREATE TABLE IF NOT EXISTS `sps_stars` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `galaxy` tinyint(3) unsigned NOT NULL,
  `system` mediumint(6) unsigned NOT NULL,
  `orbit` smallint(5) unsigned NOT NULL,
  `type` char(1) NOT NULL,
  `mass` smallint(5) unsigned NOT NULL,
  `radius` smallint(5) unsigned NOT NULL,
  `density` bigint(20) unsigned NOT NULL,
  `luminosity` bigint(20) unsigned NOT NULL,
  `temperature` mediumint(7) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_support`
--
-- Creación: 12-06-2012 a las 09:29:34
--

DROP TABLE IF EXISTS `sps_support`;
CREATE TABLE IF NOT EXISTS `sps_support` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` tinytext NOT NULL,
  `replies` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_users`
--
-- Creación: 17-06-2012 a las 15:04:32
--

DROP TABLE IF EXISTS `sps_users`;
CREATE TABLE IF NOT EXISTS `sps_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `reg_email` varchar(50) NOT NULL,
  `validation` char(15) DEFAULT NULL,
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `last_ip` varchar(45) NOT NULL,
  `reg_ip` varchar(45) NOT NULL,
  `register_time` int(10) unsigned NOT NULL,
  `homeworld` mediumint(8) unsigned NOT NULL,
  `last_active` int(10) unsigned NOT NULL,
  `hibernating` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `skin` varchar(15) NOT NULL DEFAULT 'default',
  `warnings` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ban_finish` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `validation` (`validation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-02-2012 a las 18:09:53
-- Versión del servidor: 5.1.58
-- Versión de PHP: 5.3.6-13ubuntu3.6

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
-- Estructura de tabla para la tabla `sps_aks`
--
-- Creación: 03-12-2011 a las 15:47:22
--

DROP TABLE IF EXISTS `sps_aks`;
CREATE TABLE IF NOT EXISTS `sps_aks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `participant` text,
  `fleet` text,
  `arrival` int(11) DEFAULT NULL,
  `star` smallint(5) unsigned DEFAULT NULL,
  `planet` tinyint(2) DEFAULT NULL,
  `planet_type` tinyint(1) DEFAULT NULL,
  `invited` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_alliances`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_alliances`;
CREATE TABLE IF NOT EXISTS `sps_alliances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `tag` varchar(8) DEFAULT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `web` varchar(100) DEFAULT NULL,
  `text` text,
  `image` varchar(150) DEFAULT NULL,
  `request` text,
  `request_waiting` text,
  `request_notallow` tinyint(3) NOT NULL DEFAULT '0',
  `owner_range` varchar(32) DEFAULT NULL,
  `ranks` text,
  `members` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_banned`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_banned`;
CREATE TABLE IF NOT EXISTS `sps_banned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `who` varchar(32) NOT NULL DEFAULT '',
  `reason` text NOT NULL,
  `who2` varchar(32) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `longer` int(11) NOT NULL DEFAULT '0',
  `author` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  KEY `ID` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_bodies`
--
-- Creación: 21-01-2012 a las 18:39:07
-- Última actualización: 12-02-2012 a las 16:07:57
--

DROP TABLE IF EXISTS `sps_bodies`;
CREATE TABLE IF NOT EXISTS `sps_bodies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `star` int(8) unsigned NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=360314 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_errors`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_errors`;
CREATE TABLE IF NOT EXISTS `sps_errors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(32) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(32) NOT NULL DEFAULT 'unknown',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_fleets`
--
-- Creación: 03-12-2011 a las 15:47:59
--

DROP TABLE IF EXISTS `sps_fleets`;
CREATE TABLE IF NOT EXISTS `sps_fleets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL DEFAULT '0',
  `mission` int(11) NOT NULL DEFAULT '0',
  `amount` bigint(21) NOT NULL DEFAULT '0',
  `array` text,
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `start_star` smallint(5) unsigned NOT NULL DEFAULT '0',
  `start_planet` tinyint(2) NOT NULL DEFAULT '0',
  `start_type` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `end_stay` int(11) NOT NULL DEFAULT '0',
  `end_star` smallint(5) unsigned NOT NULL DEFAULT '0',
  `end_planet` tinyint(2) NOT NULL DEFAULT '0',
  `end_type` int(10) NOT NULL DEFAULT '0',
  `target_obj` tinyint(2) NOT NULL DEFAULT '0',
  `resource_metal` bigint(20) unsigned NOT NULL DEFAULT '0',
  `resource_crystal` bigint(20) unsigned NOT NULL DEFAULT '0',
  `resource_deuterium` bigint(20) unsigned NOT NULL DEFAULT '0',
  `resource_darkmatter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `target_owner` int(11) NOT NULL DEFAULT '0',
  `group` varchar(15) NOT NULL DEFAULT '0',
  `mess` int(11) NOT NULL DEFAULT '0',
  `time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_friends`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_friends`;
CREATE TABLE IF NOT EXISTS `sps_friends` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL DEFAULT '0',
  `owner` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(3) NOT NULL DEFAULT '0',
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_messages`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_messages`;
CREATE TABLE IF NOT EXISTS `sps_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL DEFAULT '0',
  `sender` int(11) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `from` varchar(32) DEFAULT NULL,
  `subject` text,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_moons`
--
-- Creación: 08-01-2012 a las 12:04:40
-- Última actualización: 08-01-2012 a las 12:04:40
--

DROP TABLE IF EXISTS `sps_moons`;
CREATE TABLE IF NOT EXISTS `sps_moons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distance` int(10) NOT NULL,
  `radius` int(8) NOT NULL,
  `mass` bigint(12) NOT NULL,
  `planet` int(10) NOT NULL,
  `habitable` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_notes`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_notes`;
CREATE TABLE IF NOT EXISTS `sps_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_plugins`
--
-- Creación: 08-01-2012 a las 12:04:40
-- Última actualización: 08-01-2012 a las 12:04:40
--

DROP TABLE IF EXISTS `sps_plugins`;
CREATE TABLE IF NOT EXISTS `sps_plugins` (
  `plugin` varchar(32) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plugin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_rw`
--
-- Creación: 08-01-2012 a las 12:04:40
-- Última actualización: 08-01-2012 a las 12:04:40
--

DROP TABLE IF EXISTS `sps_rw`;
CREATE TABLE IF NOT EXISTS `sps_rw` (
  `owners` varchar(255) NOT NULL,
  `rid` varchar(72) NOT NULL,
  `raport` text NOT NULL,
  `a_zestrzelona` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `rid` (`rid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_sessions`
--
-- Creación: 16-10-2011 a las 14:39:50
--

DROP TABLE IF EXISTS `sps_sessions`;
CREATE TABLE IF NOT EXISTS `sps_sessions` (
  `session_id` char(32) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
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
-- Creación: 21-01-2012 a las 18:39:07
-- Última actualización: 21-01-2012 a las 18:40:05
--

DROP TABLE IF EXISTS `sps_stars`;
CREATE TABLE IF NOT EXISTS `sps_stars` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `galaxy` tinyint(3) unsigned NOT NULL,
  `system` mediumint(6) unsigned NOT NULL,
  `type` char(1) NOT NULL,
  `mass` smallint(5) unsigned NOT NULL,
  `radius` smallint(5) unsigned NOT NULL,
  `luminosity` bigint(19) unsigned NOT NULL,
  `temperature` mediumint(7) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100013 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_statpoints`
--
-- Creación: 25-11-2011 a las 17:46:09
--

DROP TABLE IF EXISTS `sps_statpoints`;
CREATE TABLE IF NOT EXISTS `sps_statpoints` (
  `id_owner` int(10) unsigned NOT NULL DEFAULT '0',
  `id_ally` int(10) unsigned NOT NULL DEFAULT '0',
  `stat_type` tinyint(2) NOT NULL DEFAULT '0',
  `stat_code` int(10) unsigned NOT NULL DEFAULT '0',
  `tech_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `tech_old_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `tech_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tech_count` int(10) unsigned NOT NULL DEFAULT '0',
  `build_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `build_old_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `build_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `build_count` int(10) unsigned NOT NULL DEFAULT '0',
  `defs_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `defs_old_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `defs_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `defs_count` int(10) unsigned NOT NULL DEFAULT '0',
  `fleet_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `fleet_old_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `fleet_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fleet_count` int(10) unsigned NOT NULL DEFAULT '0',
  `total_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `total_old_rank` int(10) unsigned NOT NULL DEFAULT '0',
  `total_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `total_count` int(10) unsigned NOT NULL DEFAULT '0',
  `stat_date` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `TECH` (`tech_points`),
  KEY `BUILDS` (`build_points`),
  KEY `DEFS` (`defs_points`),
  KEY `FLEET` (`fleet_points`),
  KEY `TOTAL` (`total_points`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_users`
--
-- Creación: 12-02-2012 a las 18:58:43
--

DROP TABLE IF EXISTS `sps_users`;
CREATE TABLE IF NOT EXISTS `sps_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `reg_email` varchar(50) NOT NULL,
  `validation` char(15) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `last_ip` int(10) unsigned NOT NULL,
  `reg_ip` int(10) unsigned NOT NULL,
  `register_time` int(10) unsigned NOT NULL,
  `last_active` int(10) unsigned NOT NULL,
  `darkmatter` int(10) unsigned NOT NULL DEFAULT '0',
  `hibernating` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `warnings` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ban_finish` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `validation` (`validation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

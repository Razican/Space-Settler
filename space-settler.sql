-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-08-2011 a las 15:09:53
-- Versión del servidor: 5.1.54
-- Versión de PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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
-- Creación: 26-08-2011 a las 16:57:34
--

DROP TABLE IF EXISTS `sps_aks`;
CREATE TABLE IF NOT EXISTS `sps_aks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `participant` text,
  `fleet` text,
  `arrival` int(11) DEFAULT NULL,
  `galaxy` tinyint(1) DEFAULT NULL,
  `system` smallint(3) DEFAULT NULL,
  `planet` tinyint(2) DEFAULT NULL,
  `planet_type` tinyint(1) DEFAULT NULL,
  `invited` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `sps_aks`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_alliances`
--
-- Creación: 29-08-2011 a las 15:57:02
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

--
-- Volcar la base de datos para la tabla `sps_alliances`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_banned`
--
-- Creación: 29-08-2011 a las 16:00:57
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

--
-- Volcar la base de datos para la tabla `sps_banned`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_config`
--
-- Creación: 22-08-2011 a las 18:04:47
-- Última actualización: 22-08-2011 a las 18:04:47
--

DROP TABLE IF EXISTS `sps_config`;
CREATE TABLE IF NOT EXISTS `sps_config` (
  `config_name` varchar(32) NOT NULL DEFAULT '',
  `config_value` text NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `sps_config`
--

INSERT INTO `sps_config` (`config_name`, `config_value`) VALUES
('VERSION', '0.0.0'),
('users_amount', '1'),
('moderation', '1,0,0,1,1;1,1,0,1,1;1;'),
('game_speed', '2500'),
('fleet_speed', '2500'),
('resource_multiplier', '1'),
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('initial_fields', '163'),
('COOKIE_NAME', 'SpaceSettler'),
('game_name', 'Space Settler'),
('game_disable', '1'),
('close_reason', '¡En este momento el servidor se encuentra cerrado!'),
('metal_basic_income', '20'),
('crystal_basic_income', '10'),
('deuterium_basic_income', '0'),
('energy_basic_income', '0'),
('BuildLabWhileRun', '0'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '1'),
('LastSettedPlanetPos', '1'),
('noobprotection', '1'),
('noobprotectiontime', '5000'),
('noobprotectionmulti', '5'),
('forum_url', 'http://www.razican.com/'),
('adm_attack', '0'),
('debug', '0'),
('lang', 'spanish'),
('stat', '1'),
('stat_level', '2'),
('stat_last_update', '1313777014'),
('stat_settings', '1000'),
('stat_amount', '25'),
('stat_update_time', '15'),
('stat_flying', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_errors`
--
-- Creación: 22-08-2011 a las 21:39:44
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

--
-- Volcar la base de datos para la tabla `sps_errors`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_fleets`
--
-- Creación: 22-08-2011 a las 21:39:34
--

DROP TABLE IF EXISTS `sps_fleets`;
CREATE TABLE IF NOT EXISTS `sps_fleets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL DEFAULT '0',
  `mission` int(11) NOT NULL DEFAULT '0',
  `amount` bigint(21) NOT NULL DEFAULT '0',
  `array` text,
  `start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `start_galaxy` tinyint(1) NOT NULL DEFAULT '0',
  `start_system` smallint(3) NOT NULL DEFAULT '0',
  `start_planet` tinyint(2) NOT NULL DEFAULT '0',
  `start_type` int(11) NOT NULL DEFAULT '0',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `end_stay` int(11) NOT NULL DEFAULT '0',
  `end_galaxy` tinyint(1) NOT NULL DEFAULT '0',
  `end_system` smallint(3) NOT NULL DEFAULT '0',
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

--
-- Volcar la base de datos para la tabla `sps_fleets`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_friends`
--
-- Creación: 22-08-2011 a las 21:38:01
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

--
-- Volcar la base de datos para la tabla `sps_friends`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_galaxy`
--
-- Creación: 22-08-2011 a las 21:37:47
--

DROP TABLE IF EXISTS `sps_galaxy`;
CREATE TABLE IF NOT EXISTS `sps_galaxy` (
  `galaxy` tinyint(1) NOT NULL DEFAULT '0',
  `system` smallint(3) NOT NULL DEFAULT '0',
  `planet` tinyint(2) NOT NULL DEFAULT '0',
  `planet_id` int(11) NOT NULL DEFAULT '0',
  `metal` bigint(20) unsigned NOT NULL DEFAULT '0',
  `crystal` bigint(20) unsigned NOT NULL DEFAULT '0',
  `moon_id` int(11) NOT NULL DEFAULT '0',
  `moon` tinyint(2) NOT NULL DEFAULT '0',
  KEY `galaxy` (`galaxy`),
  KEY `system` (`system`),
  KEY `planet` (`planet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `sps_galaxy`
--

INSERT INTO `sps_galaxy` (`galaxy`, `system`, `planet`, `planet_id`, `metal`, `crystal`, `moon_id`, `moon`) VALUES
(1, 1, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_messages`
--
-- Creación: 22-08-2011 a las 21:37:20
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

--
-- Volcar la base de datos para la tabla `sps_messages`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_notes`
--
-- Creación: 22-08-2011 a las 21:36:59
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

--
-- Volcar la base de datos para la tabla `sps_notes`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_planets`
--
-- Creación: 29-08-2011 a las 15:44:13
--

DROP TABLE IF EXISTS `sps_planets`;
CREATE TABLE IF NOT EXISTS `sps_planets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT 'Planeta Principal',
  `id_owner` int(11) DEFAULT NULL,
  `id_level` int(11) DEFAULT NULL,
  `galaxy` tinyint(1) NOT NULL DEFAULT '0',
  `system` smallint(3) NOT NULL DEFAULT '0',
  `planet` tinyint(2) NOT NULL DEFAULT '0',
  `last_update` int(11) DEFAULT NULL,
  `planet_type` int(11) NOT NULL DEFAULT '1',
  `destroyed` int(11) NOT NULL DEFAULT '0',
  `b_building` int(11) NOT NULL DEFAULT '0',
  `b_building_id` text NOT NULL,
  `b_tech` int(11) NOT NULL DEFAULT '0',
  `b_tech_id` int(11) NOT NULL DEFAULT '0',
  `b_hangar` int(11) NOT NULL DEFAULT '0',
  `b_hangar_id` text NOT NULL,
  `b_hangar_plus` int(11) NOT NULL DEFAULT '0',
  `image` varchar(32) NOT NULL DEFAULT 'normaltempplanet01',
  `diameter` int(11) NOT NULL DEFAULT '12800',
  `points` bigint(20) DEFAULT '0',
  `ranks` bigint(20) DEFAULT '0',
  `field_current` int(11) NOT NULL DEFAULT '0',
  `field_max` int(11) NOT NULL DEFAULT '163',
  `temp_min` int(3) NOT NULL DEFAULT '-17',
  `temp_max` int(3) NOT NULL DEFAULT '23',
  `metal` double(132,8) NOT NULL DEFAULT '0.00000000',
  `metal_perhour` int(11) NOT NULL DEFAULT '0',
  `metal_max` bigint(20) DEFAULT '100000',
  `crystal` double(132,8) NOT NULL DEFAULT '0.00000000',
  `crystal_perhour` int(11) NOT NULL DEFAULT '0',
  `crystal_max` bigint(20) DEFAULT '100000',
  `deuterium` double(132,8) NOT NULL DEFAULT '0.00000000',
  `deuterium_perhour` int(11) NOT NULL DEFAULT '0',
  `deuterium_max` bigint(20) DEFAULT '100000',
  `energy_used` int(11) NOT NULL DEFAULT '0',
  `energy_max` bigint(20) NOT NULL DEFAULT '0',
  `metal_mine` int(10) unsigned NOT NULL DEFAULT '0',
  `crystal_mine` int(10) unsigned NOT NULL DEFAULT '0',
  `deuterium_sintetizer` int(10) unsigned NOT NULL DEFAULT '0',
  `solar_plant` int(10) unsigned NOT NULL DEFAULT '0',
  `fusion_plant` int(10) unsigned NOT NULL DEFAULT '0',
  `robot_factory` int(10) unsigned NOT NULL DEFAULT '0',
  `nano_factory` int(10) unsigned NOT NULL DEFAULT '0',
  `hangar` int(10) unsigned NOT NULL DEFAULT '0',
  `metal_store` int(10) unsigned NOT NULL DEFAULT '0',
  `crystal_store` int(10) unsigned NOT NULL DEFAULT '0',
  `deuterium_store` int(10) unsigned NOT NULL DEFAULT '0',
  `laboratory` int(10) unsigned NOT NULL DEFAULT '0',
  `terraformer` int(10) unsigned NOT NULL DEFAULT '0',
  `ally_deposit` int(10) unsigned NOT NULL DEFAULT '0',
  `silo` int(10) unsigned NOT NULL DEFAULT '0',
  `small_ship_cargo` bigint(20) unsigned NOT NULL DEFAULT '0',
  `big_ship_cargo` bigint(20) unsigned NOT NULL DEFAULT '0',
  `light_hunter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `heavy_hunter` bigint(20) unsigned NOT NULL DEFAULT '0',
  `crusher` bigint(20) unsigned NOT NULL DEFAULT '0',
  `battle_ship` bigint(20) unsigned NOT NULL DEFAULT '0',
  `colonizer` bigint(20) unsigned NOT NULL DEFAULT '0',
  `recycler` bigint(20) unsigned NOT NULL DEFAULT '0',
  `spy_sonde` bigint(20) unsigned NOT NULL DEFAULT '0',
  `bomber_ship` bigint(20) unsigned NOT NULL DEFAULT '0',
  `solar_satelit` bigint(20) unsigned NOT NULL DEFAULT '0',
  `destructor` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dearth_star` bigint(20) unsigned NOT NULL DEFAULT '0',
  `battleship` bigint(20) unsigned NOT NULL DEFAULT '0',
  `supernova` bigint(20) unsigned NOT NULL DEFAULT '0',
  `missile_launcher` bigint(20) unsigned NOT NULL DEFAULT '0',
  `small_laser` bigint(20) unsigned NOT NULL DEFAULT '0',
  `big_laser` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gauss_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ionic_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `buster_canyon` bigint(20) unsigned NOT NULL DEFAULT '0',
  `small_protection_shield` tinyint(1) NOT NULL DEFAULT '0',
  `planet_protector` tinyint(1) NOT NULL DEFAULT '0',
  `big_protection_shield` tinyint(1) NOT NULL DEFAULT '0',
  `interceptor_missile` int(10) unsigned NOT NULL DEFAULT '0',
  `interplanetary_missile` int(10) unsigned NOT NULL DEFAULT '0',
  `metal_mine_percent` int(11) NOT NULL DEFAULT '10',
  `crystal_mine_percent` int(11) NOT NULL DEFAULT '10',
  `deuterium_sintetizer_percent` int(11) NOT NULL DEFAULT '10',
  `solar_plant_percent` int(11) NOT NULL DEFAULT '10',
  `fusion_plant_percent` int(11) NOT NULL DEFAULT '10',
  `solar_satelit_percent` int(11) NOT NULL DEFAULT '10',
  `lunar_base` bigint(21) NOT NULL DEFAULT '0',
  `phalanx` bigint(21) NOT NULL DEFAULT '0',
  `jumpgate` bigint(21) NOT NULL DEFAULT '0',
  `last_jump_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `sps_planets`
--

INSERT INTO `sps_planets` (`id`, `name`, `id_owner`, `id_level`, `galaxy`, `system`, `planet`, `last_update`, `planet_type`, `destroyed`, `b_building`, `b_building_id`, `b_tech`, `b_tech_id`, `b_hangar`, `b_hangar_id`, `b_hangar_plus`, `image`, `diameter`, `points`, `ranks`, `field_current`, `field_max`, `temp_min`, `temp_max`, `metal`, `metal_perhour`, `metal_max`, `crystal`, `crystal_perhour`, `crystal_max`, `deuterium`, `deuterium_perhour`, `deuterium_max`, `energy_used`, `energy_max`, `metal_mine`, `crystal_mine`, `deuterium_sintetizer`, `solar_plant`, `fusion_plant`, `robot_factory`, `nano_factory`, `hangar`, `metal_store`, `crystal_store`, `deuterium_store`, `laboratory`, `terraformer`, `ally_deposit`, `silo`, `small_ship_cargo`, `big_ship_cargo`, `light_hunter`, `heavy_hunter`, `crusher`, `battle_ship`, `colonizer`, `recycler`, `spy_sonde`, `bomber_ship`, `solar_satelit`, `destructor`, `dearth_star`, `battleship`, `supernova`, `missile_launcher`, `small_laser`, `big_laser`, `gauss_canyon`, `ionic_canyon`, `buster_canyon`, `small_protection_shield`, `planet_protector`, `big_protection_shield`, `interceptor_missile`, `interplanetary_missile`, `metal_mine_percent`, `crystal_mine_percent`, `deuterium_sintetizer_percent`, `solar_plant_percent`, `fusion_plant_percent`, `solar_satelit_percent`, `lunar_base`, `phalanx`, `jumpgate`, `last_jump_time`) VALUES
(1, 'Planeta Principal', 1, NULL, 1, 1, 1, 1313777105, 1, 0, 0, '0', 0, 0, 0, '', 0, 'normaltempplanet02', 12750, 0, 0, 0, 163, 47, 87, 8379.37777778, 20, 1000000, 4439.68888891, 10, 1000000, 500.00000000, 0, 1000000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10, 10, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_plugins`
--
-- Creación: 22-08-2011 a las 20:56:06
-- Última actualización: 22-08-2011 a las 20:56:06
--

DROP TABLE IF EXISTS `sps_plugins`;
CREATE TABLE IF NOT EXISTS `sps_plugins` (
  `plugin` varchar(32) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plugin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `sps_plugins`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_rw`
--
-- Creación: 22-08-2011 a las 18:00:36
-- Última actualización: 22-08-2011 a las 18:00:36
-- Última revisión: 22-08-2011 a las 18:00:36
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

--
-- Volcar la base de datos para la tabla `sps_rw`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_sessions`
--
-- Creación: 29-08-2011 a las 12:43:45
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

--
-- Volcar la base de datos para la tabla `sps_sessions`
--

INSERT INTO `sps_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('123b6971e7d2606492ae9be9bd4954d7', '1270', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/534.30 (KHTML, like Gecko) Ubuntu/11.04 Chromium/12.0.742.112 Chrome/12.0.742.', 1314394985, NULL),
('25bfa9517988f17f29b2705a5a14d712', '1270', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314308876, 'a:3:{s:7:"user_id";s:1:"1";s:14:"current_planet";s:1:"1";s:9:"logged_in";b:1;}'),
('3492e8f5f02e14a29ef5525c56b6b3eb', '1270', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314305866, 'a:2:{s:8:"username";s:5:"admin";s:9:"logged_in";b:1;}'),
('55d131bdb6b07c5d62ae635468a1bf3d', '1270', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314308334, 'a:3:{s:7:"user_id";s:1:"1";s:14:"current_planet";s:1:"1";s:9:"logged_in";b:1;}'),
('64a4e468fff2e04bd9df9724d1ae7775', '1270', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314442338, NULL),
('8c7dc3f3e2f56aab46cb5c811bcb2a32', '1270', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314373328, NULL),
('c67a4ac05042a8e2d849a904af720a26', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314627487, 'a:2:{s:18:"flash:old:referrer";N;s:18:"flash:new:referrer";N;}'),
('c9fcdeb750f313ca5b265b3daea5113b', '1270', 'Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20100101 Firefox/6.0', 1314308938, 'a:3:{s:7:"user_id";s:1:"1";s:14:"current_planet";s:1:"1";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_statpoints`
--
-- Creación: 22-08-2011 a las 21:50:49
--

DROP TABLE IF EXISTS `sps_statpoints`;
CREATE TABLE IF NOT EXISTS `sps_statpoints` (
  `id_owner` int(11) NOT NULL DEFAULT '0',
  `id_ally` int(11) NOT NULL DEFAULT '0',
  `stat_type` tinyint(2) NOT NULL DEFAULT '0',
  `stat_code` int(11) NOT NULL DEFAULT '0',
  `tech_rank` int(11) NOT NULL DEFAULT '0',
  `tech_old_rank` int(11) NOT NULL DEFAULT '0',
  `tech_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tech_count` int(11) NOT NULL DEFAULT '0',
  `build_rank` int(11) NOT NULL DEFAULT '0',
  `build_old_rank` int(11) NOT NULL DEFAULT '0',
  `build_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `build_count` int(11) NOT NULL DEFAULT '0',
  `defs_rank` int(11) NOT NULL DEFAULT '0',
  `defs_old_rank` int(11) NOT NULL DEFAULT '0',
  `defs_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `defs_count` int(11) NOT NULL DEFAULT '0',
  `fleet_rank` int(11) NOT NULL DEFAULT '0',
  `fleet_old_rank` int(11) NOT NULL DEFAULT '0',
  `fleet_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `fleet_count` int(11) NOT NULL DEFAULT '0',
  `total_rank` int(11) NOT NULL DEFAULT '0',
  `total_old_rank` int(11) NOT NULL DEFAULT '0',
  `total_points` bigint(20) unsigned NOT NULL DEFAULT '0',
  `total_count` int(11) NOT NULL DEFAULT '0',
  `stat_date` int(11) NOT NULL DEFAULT '0',
  KEY `TECH` (`tech_points`),
  KEY `BUILDS` (`build_points`),
  KEY `DEFS` (`defs_points`),
  KEY `FLEET` (`fleet_points`),
  KEY `TOTAL` (`total_points`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `sps_statpoints`
--

INSERT INTO `sps_statpoints` (`id_owner`, `id_ally`, `stat_type`, `stat_code`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`, `stat_date`) VALUES
(1, 0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 1313777014);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sps_users`
--
-- Creación: 29-08-2011 a las 17:03:43
--

DROP TABLE IF EXISTS `sps_users`;
CREATE TABLE IF NOT EXISTS `sps_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `reg_email` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `authlevel` tinyint(4) NOT NULL DEFAULT '0',
  `planet_id` int(11) NOT NULL DEFAULT '0',
  `galaxy` tinyint(1) NOT NULL DEFAULT '0',
  `system` smallint(3) NOT NULL DEFAULT '0',
  `planet` tinyint(2) NOT NULL DEFAULT '0',
  `last_ip` int(10) unsigned NOT NULL,
  `reg_ip` int(10) unsigned NOT NULL,
  `register_time` int(10) unsigned NOT NULL,
  `onlinetime` int(10) unsigned NOT NULL,
  `dpath` varchar(255) NOT NULL DEFAULT '',
  `design` tinyint(4) NOT NULL DEFAULT '1',
  `noipcheck` tinyint(4) NOT NULL DEFAULT '1',
  `planet_sort` tinyint(1) NOT NULL DEFAULT '0',
  `planet_sort_order` tinyint(1) NOT NULL DEFAULT '0',
  `espionage_probes` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `settings_tooltiptime` tinyint(4) NOT NULL DEFAULT '5',
  `settings_fleetactions` tinyint(4) NOT NULL DEFAULT '0',
  `settings_allylogo` tinyint(4) NOT NULL DEFAULT '0',
  `settings_esp` tinyint(4) NOT NULL DEFAULT '1',
  `settings_wri` tinyint(4) NOT NULL DEFAULT '1',
  `settings_bud` tinyint(4) NOT NULL DEFAULT '1',
  `settings_mis` tinyint(4) NOT NULL DEFAULT '1',
  `settings_rep` tinyint(4) NOT NULL DEFAULT '0',
  `urlaubs_modus` tinyint(4) NOT NULL DEFAULT '0',
  `urlaubs_until` int(11) NOT NULL DEFAULT '0',
  `db_deaktjava` bigint(19) NOT NULL DEFAULT '0',
  `new_message` int(11) NOT NULL DEFAULT '0',
  `fleet_shortcut` text,
  `b_tech_planet` int(11) NOT NULL DEFAULT '0',
  `spy_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `computer_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `military_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `defence_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `shield_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `energy_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `hyperspace_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `combustion_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `impulse_motor_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `hyperspace_motor_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `laser_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `ionic_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `buster_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `intergalactic_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `expedition_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `graviton_tech` int(10) unsigned NOT NULL DEFAULT '0',
  `ally_id` int(11) NOT NULL DEFAULT '0',
  `ally_name` varchar(32) DEFAULT NULL,
  `ally_request` int(11) NOT NULL DEFAULT '0',
  `ally_request_text` text,
  `ally_register_time` int(11) NOT NULL DEFAULT '0',
  `ally_rank_id` int(11) NOT NULL DEFAULT '0',
  `current_moon` int(11) NOT NULL DEFAULT '0',
  `rpg_geologist` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_admiral` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_engineer` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_technocrat` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_spy` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_constructor` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_scientific` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_commander` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_storekeeper` int(10) unsigned NOT NULL DEFAULT '0',
  `darkmatter` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_defender` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_destroyer` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_general` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_bunker` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_raider` int(10) unsigned NOT NULL DEFAULT '0',
  `rpg_emperor` int(10) unsigned NOT NULL DEFAULT '0',
  `banned` int(11) DEFAULT NULL,
  `ban_finish` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `sps_users`
--

INSERT INTO `sps_users` (`id`, `username`, `password`, `email`, `reg_email`, `name`, `authlevel`, `planet_id`, `galaxy`, `system`, `planet`, `last_ip`, `reg_ip`, `register_time`, `onlinetime`, `dpath`, `design`, `noipcheck`, `planet_sort`, `planet_sort_order`, `espionage_probes`, `settings_tooltiptime`, `settings_fleetactions`, `settings_allylogo`, `settings_esp`, `settings_wri`, `settings_bud`, `settings_mis`, `settings_rep`, `urlaubs_modus`, `urlaubs_until`, `db_deaktjava`, `new_message`, `fleet_shortcut`, `b_tech_planet`, `spy_tech`, `computer_tech`, `military_tech`, `defence_tech`, `shield_tech`, `energy_tech`, `hyperspace_tech`, `combustion_tech`, `impulse_motor_tech`, `hyperspace_motor_tech`, `laser_tech`, `ionic_tech`, `buster_tech`, `intergalactic_tech`, `expedition_tech`, `graviton_tech`, `ally_id`, `ally_name`, `ally_request`, `ally_request_text`, `ally_register_time`, `ally_rank_id`, `current_moon`, `rpg_geologist`, `rpg_admiral`, `rpg_engineer`, `rpg_technocrat`, `rpg_spy`, `rpg_constructor`, `rpg_scientific`, `rpg_commander`, `rpg_storekeeper`, `darkmatter`, `rpg_defender`, `rpg_destroyer`, `rpg_general`, `rpg_bunker`, `rpg_raider`, `rpg_emperor`, `banned`, `ban_finish`) VALUES
(1, 'admin', '8cb2237d0679ca88db6464eac60da96345513964', 'admin@example.com', 'admin@example.com', '', 3, 1, 1, 1, 1, 2130706433, 2130706433, 1313067961, 1313777105, '', 1, 1, 0, 0, 1, 5, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);

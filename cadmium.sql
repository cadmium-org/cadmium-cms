-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2015 at 02:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cadmium_dist`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(32) NOT NULL,
  `value` varchar(512) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `position` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `link` varchar(512) NOT NULL,
  `text` varchar(256) NOT NULL,
  `target` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `position`, `link`, `text`, `target`) VALUES
(1, 0, 0, '/page-1', 'Page 1', 0),
(2, 0, 1, '/page-2', 'Page 2', 0),
(3, 0, 2, '/page-3', 'page 3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `title` varchar(256) NOT NULL,
  `contents` text NOT NULL,
  `description` varchar(256) NOT NULL DEFAULT '',
  `keywords` varchar(256) NOT NULL DEFAULT '',
  `robots_index` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `robots_follow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time_created` int(10) unsigned NOT NULL DEFAULT '0',
  `time_modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `access` (`access`),
  KEY `name` (`name`),
  KEY `title` (`title`(255)),
  KEY `user_id` (`user_id`),
  KEY `time_created` (`time_created`),
  KEY `time_modified` (`time_modified`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `access`, `name`, `title`, `contents`, `description`, `keywords`, `robots_index`, `robots_follow`, `user_id`, `time_created`, `time_modified`) VALUES
(1, 0, 0, 'main', 'Главная', '<p>Welcome! This is demo site, powered by <strong>Cadmium CMS</strong>.</p>\n\n<p>Admin panel is <a href="/admin">here</a>.</p>\n\n<p><a href="http://cadmium-cms.com" target="_blank">Cadmium CMS official website</a></p>\n\n<p><a href="http://cadmium-cms.com/documentation" target="_blank">Official documentation</a></p>', '', '', 1, 1, 1, 4294967295, 1435679918),
(2, 0, 0, 'page-1', 'Page 1', '<p>This is demo page.</p>', '', '', 1, 1, 1, 4294967295, 1435586070),
(3, 0, 0, 'page-2', 'Page 2', '<p>This is demo page.</p>', '', '', 1, 1, 1, 4294967295, 4294967295),
(4, 0, 0, 'page-3', 'Page 3', '<p>This is demo page.</p>', '', '', 1, 1, 1, 4294967295, 4294967295);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rank` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(16) NOT NULL,
  `email` varchar(128) NOT NULL,
  `auth_key` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_name` varchar(32) NOT NULL DEFAULT '',
  `last_name` varchar(32) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `city` varchar(32) NOT NULL DEFAULT '',
  `country` varchar(2) NOT NULL DEFAULT '',
  `timezone` varchar(64) NOT NULL DEFAULT '',
  `time_registered` int(10) unsigned NOT NULL DEFAULT '0',
  `time_logged` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`),
  KEY `time_registered` (`time_registered`),
  KEY `time_logged` (`time_logged`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `rank`, `name`, `email`, `auth_key`, `password`, `first_name`, `last_name`, `sex`, `city`, `country`, `timezone`, `time_registered`, `time_logged`) VALUES
(1, 2, 'admin', 'admin@site.com', 's7Okny74UtQvHrXD5FS8cbOpmrNAMk4q2HA9B1QY', 'b7bb1b6a7245dcf54d44e1c6bba69fb6aef2454f', '', '', 0, '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_secrets`
--

CREATE TABLE IF NOT EXISTS `users_secrets` (
  `id` int(10) unsigned NOT NULL,
  `code` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `ip` (`ip`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` int(10) unsigned NOT NULL,
  `code` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `ip` (`ip`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

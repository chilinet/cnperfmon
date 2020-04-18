-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Apr 2020 um 13:13
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `cnperfmon`
--
CREATE DATABASE IF NOT EXISTS `cnperfmon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_german2_ci;
USE `cnperfmon`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cnperf_cmd`
--

DROP TABLE IF EXISTS `cnperf_cmd`;
CREATE TABLE IF NOT EXISTS `cnperf_cmd` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `cmdtype` text CHARACTER SET armscii8 NOT NULL,
  `command` varchar(200) CHARACTER SET armscii8 NOT NULL,
  `active` tinyint(1) NOT NULL,
  `scheduled` int(1) NOT NULL,
  PRIMARY KEY (`id`,`sort`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Daten für Tabelle `cnperf_cmd`
--

INSERT INTO `cnperf_cmd` (`id`, `sort`, `cmdtype`, `command`, `active`, `scheduled`) VALUES
(30, 1, 'iperf3', 'iperf3 -c %value1% -J', 1, 0),
(30, 2, 'iperf3', 'iperf3 -c %value1% -J -u', 1, 0),
(30, 3, 'iperf', 'iperf -c $value2 -j', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cnperf_inventory`
--

DROP TABLE IF EXISTS `cnperf_inventory`;
CREATE TABLE IF NOT EXISTS `cnperf_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `macaddress` varchar(30) CHARACTER SET ascii NOT NULL,
  `hostname` varchar(50) CHARACTER SET ascii NOT NULL,
  `status` int(11) NOT NULL,
  `value1` varchar(50) CHARACTER SET ascii DEFAULT NULL,
  `value2` varchar(50) CHARACTER SET ascii DEFAULT NULL,
  `ipaddress` varchar(15) CHARACTER SET ascii NOT NULL,
  `create_dttm` datetime NOT NULL,
  `lastupd_dttm` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hostname` (`hostname`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cnperf_results`
--

DROP TABLE IF EXISTS `cnperf_results`;
CREATE TABLE IF NOT EXISTS `cnperf_results` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `cmdid` int(11) NOT NULL AUTO_INCREMENT,
  `cmdtype` varchar(50) COLLATE utf8mb4_german2_ci NOT NULL,
  `command` varchar(255) COLLATE utf8mb4_german2_ci NOT NULL,
  `result` longtext COLLATE utf8mb4_german2_ci NOT NULL,
  `cmd_dttm` datetime NOT NULL,
  PRIMARY KEY (`cmdid`,`sort`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

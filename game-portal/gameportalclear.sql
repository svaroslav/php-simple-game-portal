-- --------------------------------------------------------
-- Hostitel:                     127.0.0.1
-- Verze serveru:                5.7.11 - MySQL Community Server (GPL)
-- OS serveru:                   Win32
-- HeidiSQL Verze:               9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportování struktury databáze pro
CREATE DATABASE IF NOT EXISTS `game-portal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci */;
USE `game-portal`;

-- Exportování struktury pro tabulka game-portal.achievmenty
CREATE TABLE IF NOT EXISTS `achievmenty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uzivatel` int(11) NOT NULL,
  `id_achievment` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.aktuality
CREATE TABLE IF NOT EXISTS `aktuality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uzivatel` int(11) NOT NULL,
  `datum` date NOT NULL,
  `nazev` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `text` varchar(4096) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.aplikace
CREATE TABLE IF NOT EXISTS `aplikace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `display_nazev` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `file_img` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `href` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL,
  `popis` varchar(512) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazev` (`nazev`),
  UNIQUE KEY `file_img` (`file_img`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.komentare
CREATE TABLE IF NOT EXISTS `komentare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uzivatel` int(11) NOT NULL,
  `id_prispevek` int(11) NOT NULL,
  `datum` date NOT NULL,
  `text` varchar(1024) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.prihlasovani
CREATE TABLE IF NOT EXISTS `prihlasovani` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_uzivatel` int(11) NOT NULL,
  `prihlaseni-odhlaseni` varchar(8) COLLATE utf8mb4_czech_ci NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.typ_achievment
CREATE TABLE IF NOT EXISTS `typ_achievment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aplikace` int(11) NOT NULL,
  `nazev` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `pocet_xp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.typ_uctu
CREATE TABLE IF NOT EXISTS `typ_uctu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro tabulka game-portal.uzivatele
CREATE TABLE IF NOT EXISTS `uzivatele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `heslo` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `id_typ_uctu` int(11) NOT NULL,
  `jmeno` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `datum_narozeni` date NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  `telefon` int(11) NOT NULL,
  `file_img` varchar(64) COLLATE utf8mb4_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `id_typ_uctu` (`id_typ_uctu`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Export dat nebyl vybrán.
-- Exportování struktury pro pohled game-portal.view_uspechy
-- Vytváření dočasné tabulky Pohledu pro omezení dopadu chyb
CREATE TABLE `view_uspechy` (
	`username` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_czech_ci',
	`pocet` BIGINT(21) NOT NULL,
	`soucet` DECIMAL(32,0) NULL
) ENGINE=MyISAM;

-- Exportování struktury pro pohled game-portal.view_uspechy
-- Odebírání dočasné tabulky a vytváření struktury Pohledu
DROP TABLE IF EXISTS `view_uspechy`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_uspechy` AS select `uzivatele`.`username` AS `username`,count(`typ_achievment`.`nazev`) AS `pocet`,sum(`typ_achievment`.`pocet_xp`) AS `soucet` from ((`uzivatele` join `typ_achievment`) join `achievmenty`) where ((`uzivatele`.`id` = `achievmenty`.`id_uzivatel`) and (`typ_achievment`.`id` = `achievmenty`.`id_achievment`)) group by `achievmenty`.`id_uzivatel`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

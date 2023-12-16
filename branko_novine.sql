-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2023 at 08:12 PM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `branko_novine`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

DROP TABLE IF EXISTS `komentari`;
CREATE TABLE IF NOT EXISTS `komentari` (
  `id_komentara` int NOT NULL AUTO_INCREMENT,
  `citalac` varchar(50) NOT NULL,
  `id_vesti` int NOT NULL,
  `sadrzaj` varchar(200) NOT NULL,
  `datum_vreme` datetime DEFAULT CURRENT_TIMESTAMP,
  `broj_pozitivnih` int NOT NULL DEFAULT '0',
  `broj_negativnih` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_komentara`),
  KEY `fk_komentari_vest1_idx` (`id_vesti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `id_korisnika` int NOT NULL AUTO_INCREMENT,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(400) NOT NULL,
  `uloga` varchar(20) NOT NULL,
  `ime_prezime` varchar(70) NOT NULL,
  PRIMARY KEY (`id_korisnika`),
  UNIQUE KEY `id_korisnika_UNIQUE` (`id_korisnika`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id_korisnika`, `korisnicko_ime`, `lozinka`, `uloga`, `ime_prezime`) VALUES
(1, 'pera', 'd8795f0d07280328f80e59b1e8414c49', 'glavni urednik', 'Petar Petrović');

-- --------------------------------------------------------

--
-- Table structure for table `novinar_rubrika`
--

DROP TABLE IF EXISTS `novinar_rubrika`;
CREATE TABLE IF NOT EXISTS `novinar_rubrika` (
  `id_novinara` int NOT NULL,
  `id_rubrike` int NOT NULL,
  KEY `fk_novinar_rubrika_korisnici1_idx` (`id_novinara`),
  KEY `fk_novinar_rubrika_rubrika1_idx` (`id_rubrike`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rubrika`
--

DROP TABLE IF EXISTS `rubrika`;
CREATE TABLE IF NOT EXISTS `rubrika` (
  `id_rubrike` int NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) NOT NULL,
  PRIMARY KEY (`id_rubrike`),
  UNIQUE KEY `id_rubrike_UNIQUE` (`id_rubrike`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rubrika`
--

INSERT INTO `rubrika` (`id_rubrike`, `naziv`) VALUES
(1, 'Politika'),
(2, 'Sport'),
(3, 'Crna Hronika'),
(4, 'Zabava'),
(5, 'Zvezde'),
(6, 'Svet');

-- --------------------------------------------------------

--
-- Table structure for table `tagovi`
--

DROP TABLE IF EXISTS `tagovi`;
CREATE TABLE IF NOT EXISTS `tagovi` (
  `id_taga` int NOT NULL AUTO_INCREMENT,
  `id_vesti` int NOT NULL,
  `sadrzaj` varchar(50) NOT NULL,
  PRIMARY KEY (`id_taga`),
  KEY `fk_tagovi_vest1_idx` (`id_vesti`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `urednik_rubrika`
--

DROP TABLE IF EXISTS `urednik_rubrika`;
CREATE TABLE IF NOT EXISTS `urednik_rubrika` (
  `id_urednika` int NOT NULL,
  `id_rubrike` int NOT NULL,
  KEY `fk_urednik_rubrika_korisnici1_idx` (`id_urednika`),
  KEY `fk_urednik_rubrika_rubrika1_idx` (`id_rubrike`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vest`
--

DROP TABLE IF EXISTS `vest`;
CREATE TABLE IF NOT EXISTS `vest` (
  `id_vesti` int NOT NULL AUTO_INCREMENT,
  `naslov` varchar(200) NOT NULL,
  `sadrzaj` mediumtext NOT NULL,
  `id_rubrike` int NOT NULL,
  `status` varchar(30) NOT NULL,
  `datum_vreme_objave` datetime DEFAULT NULL,
  `id_novinara` int NOT NULL,
  `broj_pozitivnih` int NOT NULL DEFAULT '0',
  `broj_negativnih` int NOT NULL DEFAULT '0',
  `id_urednika` int NOT NULL,
  PRIMARY KEY (`id_vesti`),
  UNIQUE KEY `id_vesti_UNIQUE` (`id_vesti`),
  KEY `fk_vest_korisnici1_idx` (`id_novinara`),
  KEY `fk_vest_rubrika1_idx` (`id_rubrike`),
  KEY `fk_vest_korisnici2_idx` (`id_urednika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `fk_komentari_vest1` FOREIGN KEY (`id_vesti`) REFERENCES `vest` (`id_vesti`);

--
-- Constraints for table `novinar_rubrika`
--
ALTER TABLE `novinar_rubrika`
  ADD CONSTRAINT `fk_novinar_rubrika_korisnici1` FOREIGN KEY (`id_novinara`) REFERENCES `korisnici` (`id_korisnika`),
  ADD CONSTRAINT `fk_novinar_rubrika_rubrika1` FOREIGN KEY (`id_rubrike`) REFERENCES `rubrika` (`id_rubrike`);

--
-- Constraints for table `tagovi`
--
ALTER TABLE `tagovi`
  ADD CONSTRAINT `fk_tagovi_vest1` FOREIGN KEY (`id_vesti`) REFERENCES `vest` (`id_vesti`);

--
-- Constraints for table `urednik_rubrika`
--
ALTER TABLE `urednik_rubrika`
  ADD CONSTRAINT `fk_urednik_rubrika_korisnici1` FOREIGN KEY (`id_urednika`) REFERENCES `korisnici` (`id_korisnika`),
  ADD CONSTRAINT `fk_urednik_rubrika_rubrika1` FOREIGN KEY (`id_rubrike`) REFERENCES `rubrika` (`id_rubrike`);

--
-- Constraints for table `vest`
--
ALTER TABLE `vest`
  ADD CONSTRAINT `fk_vest_korisnici1` FOREIGN KEY (`id_novinara`) REFERENCES `korisnici` (`id_korisnika`),
  ADD CONSTRAINT `fk_vest_korisnici2` FOREIGN KEY (`id_urednika`) REFERENCES `korisnici` (`id_korisnika`),
  ADD CONSTRAINT `fk_vest_rubrika1` FOREIGN KEY (`id_rubrike`) REFERENCES `rubrika` (`id_rubrike`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

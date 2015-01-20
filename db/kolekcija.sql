-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2012 at 07:02 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kolekcija`
--

-- --------------------------------------------------------

--
-- Table structure for table `filmovi`
--

CREATE TABLE IF NOT EXISTS `filmovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(255) NOT NULL,
  `id_zanr` int(11) NOT NULL,
  `godina` int(11) NOT NULL,
  `trajanje` int(11) NOT NULL,
  `slika` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_zanr` (`id_zanr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Popis filmova' AUTO_INCREMENT=28 ;

--
-- Dumping data for table `filmovi`
--

INSERT INTO `filmovi` (`id`, `naslov`, `id_zanr`, `godina`, `trajanje`, `slika`) VALUES
(18, 'Antitrust', 11, 2001, 109, 'antitrust_2001.jpg'),
(19, 'Firewall', 11, 2006, 105, 'firewall_2006.jpg'),
(20, 'Hackers', 1, 1995, 107, 'hackers_1995.jpg'),
(21, 'Operation Swordfish', 1, 2001, 99, 'operation_swordfish_2001.jpg'),
(22, 'Operation Takedown', 4, 2000, 92, 'operation_takedown_2000.jpg'),
(23, 'Pirates of Silicon Valley', 5, 1999, 95, 'pirates_of_silicone_valley_1999.jpg'),
(24, 'The Social Network', 5, 2010, 120, 'the_social_network_2010.jpg'),
(25, 'Tron', 9, 1982, 96, 'tron_1982.jpg'),
(26, 'Tron Legacy', 9, 2010, 125, 'tron_legacy_2010.jpg'),
(27, 'War Games', 11, 1983, 114, 'war_games_1983.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `zanr`
--

CREATE TABLE IF NOT EXISTS `zanr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Popis žanrova' AUTO_INCREMENT=12 ;

--
-- Dumping data for table `zanr`
--

INSERT INTO `zanr` (`id`, `naziv`) VALUES
(1, 'akcijski'),
(2, 'pustolovni'),
(3, 'komedija'),
(4, 'kriminalistički'),
(5, 'drama'),
(6, 'povijesni'),
(7, 'horor'),
(8, 'mjuzikl'),
(9, 'SF'),
(10, 'ratni'),
(11, 'triler');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `filmovi`
--
ALTER TABLE `filmovi`
  ADD CONSTRAINT `filmovi_ibfk_1` FOREIGN KEY (`id_zanr`) REFERENCES `zanr` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

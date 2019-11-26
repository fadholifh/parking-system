-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2014 at 02:41 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `parkir`
--

DROP TABLE IF EXISTS `parkir`;
CREATE TABLE IF NOT EXISTS `parkir` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `nopol` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `masuk` time NOT NULL,
  `keluar` time DEFAULT NULL,
  `lama_parkir` mediumint(9) DEFAULT NULL,
  `biaya` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id`, `nopol`, `tanggal`, `masuk`, `keluar`, `lama_parkir`, `biaya`) VALUES
(39, 'RI 1', '2014-07-13', '00:04:31', '17:05:17', 17, '18000'),
(40, 'AA 5863 JF', '2014-07-25', '11:45:08', '11:45:36', 0, '1000');

--
-- Triggers `parkir`
--
DROP TRIGGER IF EXISTS `parkir`;
DELIMITER //
CREATE TRIGGER `parkir` BEFORE INSERT ON `parkir`
 FOR EACH ROW begin
	set new.tanggal = now();
	set new.masuk = now();
end
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

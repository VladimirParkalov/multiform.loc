-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2014 at 09:30 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nahr_5`
--

-- --------------------------------------------------------

--
-- Table structure for table `horoskop`
--

CREATE TABLE IF NOT EXISTS `horoskop` (
  `LP` int(11) NOT NULL AUTO_INCREMENT,
  `Sex` varchar(11) NOT NULL,
  `Name` text NOT NULL,
  `BDate` date NOT NULL,
  `zodiac` varchar(255) NOT NULL,
  `Voievodeship` text NOT NULL,
  `email` text NOT NULL,
  `checkbox` tinyint(1) NOT NULL,
  PRIMARY KEY (`LP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 19, 2015 at 10:03 PM
-- Server version: 10.0.15-MariaDB-log
-- PHP Version: 5.6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `AFK`
--

-- --------------------------------------------------------

--
-- Table structure for table `CONVERSATION`
--

CREATE TABLE IF NOT EXISTS `CONVERSATION` (
  `IDCONV` int(11) NOT NULL,
  `IDUSER` int(11) NOT NULL,
  `CONTENT` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `EVENT`
--

CREATE TABLE IF NOT EXISTS `EVENT` (
  `ORGANISATEUR` int(11) NOT NULL,
  `IDEVENT` int(11) NOT NULL,
  `TYPE` varchar(15) NOT NULL,
  `DESC` varchar(140) NOT NULL,
  `IMG` varchar(300) NOT NULL,
  `DATE` date NOT NULL,
  `LIEU` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `GROUP`
--

CREATE TABLE IF NOT EXISTS `GROUP` (
  `IDGROUP` int(11) NOT NULL,
  `IDADMIN` int(11) NOT NULL,
  `IDGROUPDESC` int(11) NOT NULL,
  `NAME` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `INSCRITGROUPE`
--

CREATE TABLE IF NOT EXISTS `INSCRITGROUPE` (
  `IDGROUP` int(11) NOT NULL,
  `IDUSER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `INTEREST`
--

CREATE TABLE IF NOT EXISTS `INTEREST` (
  `IDINTEREST` int(11) NOT NULL,
  `INTERESTNAME` varchar(20) NOT NULL,
  `IDINTERESTDESC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LISTAMIS`
--

CREATE TABLE IF NOT EXISTS `LISTAMIS` (
  `IDLIST` int(11) NOT NULL,
  `IDUSER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGE`
--

CREATE TABLE IF NOT EXISTS `MESSAGE` (
  `IDMESSAGE` int(11) NOT NULL,
  `CONTENU` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGEGROUPE`
--

CREATE TABLE IF NOT EXISTS `MESSAGEGROUPE` (
  `IDGROUPE` int(11) NOT NULL,
  `IDMESSAGE` varchar(64) NOT NULL,
  `TIME` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGEREAD`
--

CREATE TABLE IF NOT EXISTS `MESSAGEREAD` (
  `IDMESSAGE` int(11) NOT NULL,
  `READ` tinyint(1) NOT NULL,
  `IDUSER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PARTICIPEVENT`
--

CREATE TABLE IF NOT EXISTS `PARTICIPEVENT` (
  `IDEVENT` int(11) NOT NULL,
  `IDUSER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
`ID` int(11) NOT NULL,
  `PSEUDO` varchar(14) NOT NULL,
  `EMAIL` varchar(28) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL,
  `NOM` varchar(30) NOT NULL,
  `PRENOM` varchar(30) NOT NULL,
  `CIVILITE` varchar(5) NOT NULL,
  `IDLISTAMIS` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`ID`, `PSEUDO`, `EMAIL`, `PASSWORD`, `NOM`, `PRENOM`, `CIVILITE`, `IDLISTAMIS`) VALUES
(1, 'a', 'a', '$2y$10$GAMlS8SWIZT4b4YB6TKrke/SMVWrnG.KzQ7ooCTUCpqpzY3pZbyjK', 'a', 'a', 'a', 0),
(2, 'b', 'b', '$2y$10$BEYwd2U3.p1uny/SbH07geK6ewobJGmcj7xh6fQIMs4TMfkrrC5kO', 'b', 'b', 'b', 0);

-- --------------------------------------------------------

--
-- Table structure for table `USERSINTEREST`
--

CREATE TABLE IF NOT EXISTS `USERSINTEREST` (
  `ID` int(11) NOT NULL,
  `IDINTEREST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `EVENT`
--
ALTER TABLE `EVENT`
 ADD PRIMARY KEY (`IDEVENT`);

--
-- Indexes for table `GROUP`
--
ALTER TABLE `GROUP`
 ADD PRIMARY KEY (`IDGROUP`);

--
-- Indexes for table `INTEREST`
--
ALTER TABLE `INTEREST`
 ADD PRIMARY KEY (`IDINTEREST`,`INTERESTNAME`);

--
-- Indexes for table `MESSAGE`
--
ALTER TABLE `MESSAGE`
 ADD PRIMARY KEY (`IDMESSAGE`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `pseudo` (`PSEUDO`);

--
-- Indexes for table `USERSINTEREST`
--
ALTER TABLE `USERSINTEREST`
 ADD PRIMARY KEY (`ID`,`IDINTEREST`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

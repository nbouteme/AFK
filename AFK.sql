-- phpMyAdmin SQL Dump
-- version 4.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 25, 2015 at 09:32 PM
-- Server version: 10.0.15-MariaDB-log
-- PHP Version: 5.6.5

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
  `IDEVENT` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `EVENT`
--

INSERT INTO `EVENT` (`ORGANISATEUR`, `IDEVENT`) VALUES
(7, 2),
(7, 3);

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
  `INTERESTNAME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `INTEREST`
--

INSERT INTO `INTEREST` (`IDINTEREST`, `INTERESTNAME`) VALUES
(0, 'Anime');

-- --------------------------------------------------------

--
-- Table structure for table `LISTAMIS`
--

CREATE TABLE IF NOT EXISTS `LISTAMIS` (
  `IDA` int(11) NOT NULL,
  `IDB` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LISTAMIS`
--

INSERT INTO `LISTAMIS` (`IDA`, `IDB`) VALUES
(8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGE`
--

CREATE TABLE IF NOT EXISTS `MESSAGE` (
  `IDMESSAGE` int(11) NOT NULL,
  `LU` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MESSAGEGROUPE`
--

CREATE TABLE IF NOT EXISTS `MESSAGEGROUPE` (
  `IDGROUPE` int(11) NOT NULL,
  `IDMESSAGE` varchar(64) NOT NULL,
  `TIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP
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

--
-- Dumping data for table `PARTICIPEVENT`
--

INSERT INTO `PARTICIPEVENT` (`IDEVENT`, `IDUSER`) VALUES
(2, 6),
(3, 6),
(3, 8);

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
  `IDLISTAMIS` int(11) NOT NULL,
  `ISADMIN` tinyint(1) DEFAULT '0',
  `NBMESSNONLU` int(11) DEFAULT NULL,
  `VALID` tinyint(1) NOT NULL DEFAULT '0',
  `AFKFOR` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`ID`, `PSEUDO`, `EMAIL`, `PASSWORD`, `NOM`, `PRENOM`, `CIVILITE`, `IDLISTAMIS`, `ISADMIN`, `NBMESSNONLU`, `VALID`, `AFKFOR`) VALUES
(6, 'ko', 'ko@ko.de', '$2y$10$UIOb9.mUX2/7fbOR0Om4Ze/EU08.Bu/HiTiU5bVxMNgMJ8E4bh/H6', 'ko', 'ko', '1', 0, NULL, NULL, 0, 0),
(7, 'na', 'nabil.boutemeur@gmail.com', '$2y$10$H6zAWJheafZyqi1o4WehTuiNTSBDPUgqZrqItJgriYnqe7RnnuB36', 'na', 'na', '1', 0, NULL, NULL, 1, 20150125192851),
(8, 'sa', 'sa@jhkl.com', '$2y$10$jrJBrg4CdmB/JTWc51T3debY9p7oZksVhNB4/neQIZvr6fgzLVKzG', 'sa', 'sa', '1', 0, 0, NULL, 0, 20150125184309),
(9, 'jk', 'jk@kl', '$2y$10$Q2BTlmn2bLlsLRHWa4sR9uU6G8nQ3mES/EVOiEI1sReVojJl/o12O', 'jk', 'jk', '1', 0, 0, NULL, 0, 0),
(10, 'sdfsafdsf', 'sonia.boutemeur@gmail.com', '$2y$10$lUVEe7LwesKsA8Dlc5DkSu7WxPFS6o6cERABQneFmwsrT/95l.oM6', 'sdfsdf', 'sdfsdf', '1', 0, 0, NULL, 0, 0),
(11, 'lkjhl', 'mirai@kuriyama.moe', '$2y$10$NcYERknBseUu1kGVtQ83AOvrqWvzApG6BN2rR/ZZcIlcDzhZ0Fux6', 'jkhh', 'kjhlk', '1', 0, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `USERSINTEREST`
--

CREATE TABLE IF NOT EXISTS `USERSINTEREST` (
  `ID` int(11) NOT NULL,
  `IDINTEREST` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USERSINTEREST`
--

INSERT INTO `USERSINTEREST` (`ID`, `IDINTEREST`) VALUES
(7, 0);

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
-- Indexes for table `LISTAMIS`
--
ALTER TABLE `LISTAMIS`
  ADD PRIMARY KEY (`IDA`,`IDB`);

--
-- Indexes for table `MESSAGE`
--
ALTER TABLE `MESSAGE`
  ADD PRIMARY KEY (`IDMESSAGE`);

--
-- Indexes for table `PARTICIPEVENT`
--
ALTER TABLE `PARTICIPEVENT`
  ADD PRIMARY KEY (`IDEVENT`,`IDUSER`);

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
-- AUTO_INCREMENT for table `EVENT`
--
ALTER TABLE `EVENT`
  MODIFY `IDEVENT` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `INTEREST`
--
ALTER TABLE `INTEREST`
  MODIFY `IDINTEREST` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

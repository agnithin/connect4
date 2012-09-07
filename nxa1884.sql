-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2011 at 10:36 AM
-- Server version: 5.1.54
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nxa1884`
--

-- --------------------------------------------------------

--
-- Table structure for table `c4board`
--

CREATE TABLE IF NOT EXISTS `c4board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gameId` int(11) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  `col` int(11) DEFAULT NULL,
  `player` varchar(45) DEFAULT NULL,
  `pieceId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=248 ;

--
-- Dumping data for table `c4board`
--

INSERT INTO `c4board` (`id`, `gameId`, `row`, `col`, `player`, `pieceId`) VALUES
(236, 44, 3, 5, '1', 'piece_1|7'),
(237, 45, 6, 6, '0', 'piece_0|0'),
(238, 45, 6, 5, '1', 'piece_1|1'),
(239, 45, 6, 4, '0', 'piece_0|2'),
(240, 45, 5, 4, '1', 'piece_1|3'),
(241, 45, 6, 3, '0', 'piece_0|4'),
(242, 45, 5, 3, '1', 'piece_1|5'),
(243, 45, 6, 2, '0', 'piece_0|6'),
(244, 45, 4, 3, '1', 'piece_1|7'),
(245, 45, 5, 2, '0', 'piece_0|8'),
(246, 45, 4, 2, '1', 'piece_1|9'),
(247, 45, 6, 1, '0', 'piece_0|10'),
(235, 44, 5, 3, '0', 'piece_0|6'),
(234, 44, 4, 5, '1', 'piece_1|5'),
(230, 44, 6, 5, '1', 'piece_1|1'),
(231, 44, 6, 3, '0', 'piece_0|0'),
(232, 44, 5, 5, '1', 'piece_1|3'),
(233, 44, 6, 4, '0', 'piece_0|4'),
(229, 44, 6, 6, '0', 'piece_0|0'),
(228, 42, 6, 3, '0', 'piece_0|6'),
(227, 42, 5, 4, '1', 'piece_1|5'),
(226, 42, 6, 4, '0', 'piece_0|4'),
(225, 42, 5, 5, '1', 'piece_1|3'),
(224, 42, 6, 5, '0', 'piece_0|2'),
(223, 42, 5, 6, '1', 'piece_1|1'),
(222, 42, 6, 6, '0', 'piece_0|0'),
(218, 34, 6, 5, '1', 'piece_1|0');

-- --------------------------------------------------------

--
-- Table structure for table `c4chat`
--

CREATE TABLE IF NOT EXISTS `c4chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(45) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `timestamp` varchar(45) DEFAULT NULL,
  `gameId` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `c4chat`
--

INSERT INTO `c4chat` (`id`, `userId`, `message`, `timestamp`, `gameId`) VALUES
(67, 'abc', 'test', '2011-05-19 15:29:00', 0),
(68, 'abc', 'asdf', '2011-05-19 15:29:03', 0),
(69, 'abc', 'asdf', '2011-05-19 15:29:08', 0),
(70, 'abc', 'adsf', '2011-05-19 15:29:11', 0),
(71, 'abc', 'hjhj', '2011-05-19 15:29:17', 0),
(72, 'abc', 'ytr', '2011-05-19 15:29:21', 0),
(73, 'abc', ',mnb', '2011-05-19 15:29:26', 0),
(74, 'abc', 'nbvcx', '2011-05-19 17:19:07', 0),
(75, 'asd', 'vcx', '2011-05-19 17:30:26', 0),
(76, 'asd', 'zdsf', '2011-05-19 17:32:08', 0),
(77, 'asd', 'jksdfg', '2011-05-19 17:32:24', 0),
(78, 'asd', 'sdfgs', '2011-05-19 17:32:24', 0),
(79, 'asd', 'sdfg', '2011-05-19 17:32:25', 0),
(80, 'asd', 'asdf', '2011-05-19 19:33:49', 0),
(81, 'asd', 'sadf', '2011-05-20 03:14:59', 0),
(82, 'asd', 'ytr', '2011-05-20 03:15:04', 0),
(83, 'asd', 'test', '2011-05-20 03:39:55', 0),
(84, 'asd', 'hey sucker', '2011-05-20 03:41:34', 41),
(85, 'asd', 'asdfafadsfa af adsf adf', '2011-05-20 03:41:45', 41),
(86, 'asd', 'woohoo', '2011-05-20 03:42:11', 0),
(87, 'asd', 'fdssdf', '2011-05-20 03:42:21', 41),
(88, 'abc', 'hey sucker', '2011-05-20 03:44:45', 42),
(89, 'asd', 'u loose', '2011-05-20 03:45:01', 42),
(90, 'abc', 'all bugs fixed!!', '2011-05-20 03:58:57', 0),
(91, 'asd', 'sdafasdsafaf', '2011-05-20 04:09:24', 44),
(92, 'asd', 'asdf', '2011-05-20 04:09:25', 44),
(93, 'asd', 'sadf', '2011-05-20 04:09:27', 44),
(94, 'asd', 'asdf', '2011-05-20 04:09:29', 44),
(95, 'asd', 'asdf', '2011-05-20 04:09:30', 44),
(96, 'asd', 'sdf', '2011-05-20 04:09:32', 44),
(97, 'asd', 'dsfg', '2011-05-20 04:09:33', 44),
(98, 'asd', 'dsfg', '2011-05-20 04:09:35', 44),
(99, 'asd', 'fdsh', '2011-05-20 04:09:38', 44),
(100, 'asd', 'xvzc', '2011-05-20 04:09:41', 44),
(101, 'abc', 'jhngb', '2011-05-20 04:09:47', 44),
(102, 'abc', 'dsf', '2011-05-20 04:09:49', 44),
(103, 'abc', 'kmujnh', '2011-05-20 04:09:52', 44),
(104, 'abc', 'sdf', '2011-05-20 04:10:54', 44),
(105, 'abc', 'vdfx', '2011-05-20 04:10:55', 44),
(106, 'abc', 'xcvb', '2011-05-20 04:10:57', 44),
(107, 'abc', 'hf g', '2011-05-20 04:10:59', 44),
(108, 'abc', 'fcbvxcb', '2011-05-20 04:11:01', 44),
(109, 'abc', 'cxv', '2011-05-20 04:11:04', 44),
(110, 'abc', 'xcvb', '2011-05-20 04:11:05', 44),
(111, 'abc', 'xbv', '2011-05-20 04:11:07', 44),
(112, 'abc', 'xcvb', '2011-05-20 04:11:08', 44),
(113, 'abc', 'xcvb', '2011-05-20 04:11:09', 44),
(114, 'abc', 'xcvb', '2011-05-20 04:11:10', 44),
(115, 'abc', 'xvcb', '2011-05-20 04:11:11', 44),
(116, 'abc', 'xcvb', '2011-05-20 04:11:14', 44),
(117, 'abc', 'xcb', '2011-05-20 04:11:16', 44),
(118, 'abc', 'uuu', '2011-05-20 04:11:18', 44),
(119, 'abc', 'uu', '2011-05-20 04:11:21', 44);

-- --------------------------------------------------------

--
-- Table structure for table `c4game`
--

CREATE TABLE IF NOT EXISTS `c4game` (
  `gameId` int(11) NOT NULL AUTO_INCREMENT,
  `player1` varchar(45) DEFAULT NULL,
  `player2` varchar(45) DEFAULT NULL,
  `whoseTurn` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`gameId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `c4game`
--

INSERT INTO `c4game` (`gameId`, `player1`, `player2`, `whoseTurn`, `status`) VALUES
(45, 'abc', 'asd', '1', 3),
(44, 'abc', 'asd', '0', 4),
(43, 'abc', 'asd', '0', 5),
(42, 'asd', 'abc', '1', 3),
(41, 'asd', 'www', '0', 5),
(39, 'abc', 'www', '0', 3),
(24, 'asd', 'abc', '1', 2),
(35, 'asd', 'abc', '0', 4),
(36, 'asd', 'www', '1', 5),
(37, 'abc', 'www', '0', 5),
(40, 'abc', 'www', '0', 5),
(38, 'abc', 'www', '0', 5);

-- --------------------------------------------------------

--
-- Table structure for table `c4users`
--

CREATE TABLE IF NOT EXISTS `c4users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `c4users`
--

INSERT INTO `c4users` (`Id`, `Name`, `Password`, `Email`, `Status`) VALUES
(1, 'abc', 'a9993e364706816aba3e25717850c26c9cd0d89d', NULL, '1'),
(2, 'asd', 'f10e2821bbbea527ea02200352313bc059445190', NULL, '0'),
(3, 'www', 'c50267b906a652f2142cfab006e215c9f6fdc8a0', NULL, '0');

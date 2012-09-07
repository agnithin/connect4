-- Table structure for table `checkers_games`
-- 

CREATE TABLE `checkers_games` (
  `game_id` int(10) NOT NULL auto_increment,
  `whoseTurn` int(1) NOT NULL default '0',
  `player0_name` varchar(255) NOT NULL default '',
  `player0_pieceID` text,
  `player0_boardI` varchar(255) default NULL,
  `player0_boardJ` varchar(255) default NULL,
  `player1_name` varchar(255) NOT NULL default '',
  `player1_pieceID` text,
  `player1_boardI` varchar(255) default NULL,
  `player1_boardJ` varchar(255) default NULL,
  `last_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`game_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- 
-- Dumping data for table `checkers_games`
-- 

INSERT INTO `checkers_games` VALUES (38, 0, 'Dan', NULL, NULL, NULL, 'Fred', NULL, NULL, NULL, '0000-00-00 00:00:00');
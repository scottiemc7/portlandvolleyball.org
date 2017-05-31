# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.12)
# Database: scratch
# Generation Time: 2017-05-31 18:49:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`username`, `password`)
VALUES
  ('pva_admin','b25272a0622b7f21571b9e3fef8b9243');

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `tm` time NOT NULL DEFAULT '00:00:00',
  `link` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table games
# ------------------------------------------------------------

DROP TABLE IF EXISTS `games`;

CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` date NOT NULL DEFAULT '0000-00-00',
  `tm` varchar(10) NOT NULL DEFAULT '',
  `gym` int(11) NOT NULL DEFAULT '0',
  `court` varchar(10) NOT NULL DEFAULT '',
  `home` int(11) NOT NULL DEFAULT '0',
  `visitor` int(11) NOT NULL DEFAULT '0',
  `edited` tinyint(4) NOT NULL DEFAULT '0',
  `ref` smallint(6) NOT NULL DEFAULT '0',
  `hscore1` tinyint(4) DEFAULT NULL,
  `vscore1` tinyint(4) DEFAULT NULL,
  `hscore2` tinyint(4) DEFAULT NULL,
  `vscore2` tinyint(4) DEFAULT NULL,
  `hscore3` tinyint(4) DEFAULT NULL,
  `vscore3` tinyint(4) DEFAULT NULL,
  `hmp` decimal(5,1) DEFAULT '0.0',
  `vmp` decimal(5,1) DEFAULT '0.0',
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;

INSERT INTO `games` (`id`, `dt`, `tm`, `gym`, `court`, `home`, `visitor`, `edited`, `ref`, `hscore1`, `vscore1`, `hscore2`, `vscore2`, `hscore3`, `vscore3`, `hmp`, `vmp`, `notes`)
VALUES
  (23538,'2116-06-22','6:30',24,'',1509,1510,0,16,16,21,18,21,15,7,0.5,3.0,''),
  (23539,'2116-06-22','7:30',24,'',1511,1516,0,16,21,5,21,8,15,13,4.5,0.0,''),
  (23540,'2116-06-22','6:30',24,'',1512,1513,0,16,20,22,17,21,13,15,0.0,4.5,''),
  (23541,'2116-06-22','7:30',24,'',1514,1515,0,16,12,21,12,21,5,15,0.0,4.5,''),
  (23542,'2116-06-29','6:30',24,'',1516,1514,0,16,15,21,20,22,14,16,0.0,4.5,''),
  (23543,'2116-06-29','7:30',24,'',1513,1509,0,16,21,19,11,21,13,15,0.5,4.0,''),
  (23544,'2116-06-29','6:30',24,'',1515,1511,0,16,21,19,21,11,15,12,4.5,0.0,''),
  (23545,'2116-06-29','7:30',24,'',1510,1512,0,16,21,10,21,17,15,8,4.5,0.0,''),
  (23546,'2116-07-06','6:30',24,'',1509,1512,0,16,17,21,21,15,12,15,0.5,4.0,''),
  (23547,'2116-07-06','7:30',24,'',1511,1514,0,16,21,6,21,7,15,12,4.5,0.0,''),
  (23548,'2116-07-06','6:30',24,'',1513,1510,0,16,18,21,15,21,10,15,0.0,4.5,''),
  (23549,'2116-07-06','7:30',24,'',1516,1515,0,16,17,21,4,21,13,15,0.0,4.5,''),
  (23550,'2116-07-13','6:30',24,'',1514,1513,0,16,19,21,17,21,6,15,0.0,4.5,''),
  (23551,'2116-07-13','7:30',24,'',1515,1509,0,16,17,21,23,21,15,9,4.0,0.5,''),
  (23552,'2116-07-13','6:30',24,'',1510,1516,0,16,21,9,21,15,15,10,4.5,0.0,''),
  (23553,'2116-07-13','7:30',24,'',1512,1511,0,16,15,21,21,19,6,15,0.5,4.0,''),
  (23554,'2116-06-20','6:30',24,'',1486,1518,0,17,21,15,21,14,15,7,4.5,0.0,''),
  (23555,'2116-06-20','7:30',24,'',1518,1487,0,17,16,21,9,21,15,6,0.5,4.0,'Is there any way to put the ref\'s name instead of brentwood on the match ? it would help sort out the teams.  Norm'),
  (23556,'2116-06-20','6:30',24,'',1487,1488,0,15,20,22,21,14,15,9,4.0,0.5,''),
  (23557,'2116-06-20','7:30',24,'',1488,410,0,15,10,21,21,17,15,17,0.5,4.0,''),
  (23558,'2116-06-20','6:30',24,'',410,1489,0,16,12,21,16,21,15,8,0.5,4.0,''),
  (23559,'2116-06-20','7:30',24,'',1489,1490,0,16,21,11,24,22,15,6,4.5,0.0,''),
  (23560,'2116-06-20','6:30',24,'',1490,1491,0,0,19,21,9,21,14,16,0.0,4.5,'Queen Bees defeat Quad Squad 21-19 ,21-9 ,16-14'),
  (23561,'2116-06-20','7:30',24,'',1491,1378,0,0,21,14,21,6,15,12,4.5,0.0,'Queen Bees defeat Smack that pass 21-14 ,21-6 ,15-12'),
  (23562,'2116-06-20','6:30',24,'',1378,1493,0,8,21,17,24,22,13,15,4.0,0.5,''),
  (23563,'2116-06-20','7:30',24,'',1493,1492,0,8,21,9,21,6,15,10,4.5,0.0,''),
  (23564,'2116-06-20','6:30',24,'',1492,1494,0,18,14,25,13,25,15,17,0.0,4.5,''),
  (23565,'2116-06-20','7:30',24,'',1494,1495,0,18,21,16,21,18,12,15,4.0,0.5,''),
  (23566,'2116-06-20','6:30',24,'',1495,1496,0,13,23,21,21,15,12,15,4.0,0.5,''),
  (23567,'2116-06-20','7:30',24,'',1496,1517,0,13,17,21,15,21,6,15,0.0,4.5,''),
  (23568,'2116-06-27','6:30',24,'',1488,1486,0,15,12,21,11,21,8,15,0.0,4.5,''),
  (23569,'2116-06-27','7:30',24,'',1486,1494,0,15,21,5,21,12,14,16,4.0,0.5,''),
  (23570,'2116-06-27','6:30',24,'',1489,1378,0,0,21,12,22,20,15,12,4.5,0.0,'Mavens                   21  22  15\r\nSmack That Pass   12  20  12'),
  (23571,'2116-06-27','7:30',24,'',1378,1488,0,0,21,17,21,14,15,9,4.5,0.0,'Smack That Pass  21  21  15\r\nGrassyass             17  14  9'),
  (23572,'2116-06-27','6:30',24,'',1493,1518,0,16,18,21,18,21,12,15,0.0,4.5,''),
  (23573,'2116-06-27','7:30',24,'',1518,1490,0,16,21,16,18,21,15,9,4.0,0.5,''),
  (23574,'2116-06-27','6:30',24,'',1490,1487,0,18,14,21,15,21,8,15,0.0,4.5,''),
  (23575,'2116-06-27','7:30',24,'',1487,1493,0,18,21,14,21,16,15,3,4.5,0.0,''),
  (23576,'2116-06-27','6:30',24,'',1491,410,0,13,21,17,21,17,15,7,4.5,0.0,''),
  (23577,'2116-06-27','7:30',24,'',1517,1491,0,13,15,21,21,23,2,15,0.0,4.5,''),
  (23578,'2116-06-27','6:30',24,'',1517,1492,0,8,21,15,21,10,15,12,4.5,0.0,''),
  (23579,'2116-06-27','7:30',24,'',1492,1495,0,8,12,21,6,21,6,15,0.0,4.5,''),
  (23580,'2116-06-27','6:30',24,'',1494,1492,0,0,16,21,16,21,15,9,0.5,4.0,'Grass Stains      16  16  15\r\nOther Team        21  21   9'),
  (23581,'2116-06-27','7:30',24,'',1443,410,0,0,12,21,16,21,8,15,0.0,4.5,'Other Team       12  16   8\r\nLollipop Girls     21  21  15'),
  (23582,'2116-07-11','6:30',24,'',1486,1490,0,54,21,16,21,13,15,12,4.5,0.0,''),
  (23583,'2116-07-11','7:30',24,'',1305,1486,0,54,8,21,18,21,9,15,0.0,4.5,''),
  (23584,'2116-07-11','6:30',24,'',1489,1491,0,15,17,21,21,18,15,6,4.0,0.5,''),
  (23585,'2116-07-11','7:30',24,'',1491,1487,0,15,23,21,21,14,15,10,4.5,0.0,''),
  (23586,'2116-07-11','6:30',24,'',1488,1493,0,18,0,15,21,17,17,21,0.5,4.0,''),
  (23587,'2116-07-11','7:30',24,'',1496,1488,0,18,21,19,21,10,15,6,4.5,0.0,''),
  (23588,'2116-07-11','6:30',24,'',410,1378,0,13,21,11,24,22,15,9,4.5,0.0,''),
  (23589,'2116-07-11','7:30',24,'',1493,1489,0,13,14,21,15,21,16,14,0.5,4.0,''),
  (23590,'2116-07-11','6:30',24,'',1518,1494,0,16,21,16,21,19,15,6,4.5,0.0,''),
  (23591,'2116-07-11','7:30',24,'',1490,410,0,16,18,21,9,21,15,10,0.5,4.0,''),
  (23592,'2116-07-11','6:30',24,'',1487,1495,0,8,22,20,21,15,15,9,4.5,0.0,''),
  (23593,'2116-07-11','7:30',24,'',1495,1518,0,8,21,8,21,16,15,13,4.5,0.0,''),
  (23594,'2116-07-11','6:30',24,'',1492,1496,0,17,25,17,25,13,15,8,4.5,0.0,''),
  (23595,'2116-07-11','7:30',24,'',1378,1492,0,17,25,11,25,10,15,8,4.5,0.0,''),
  (23596,'2116-07-18','6:30',24,'',1378,1486,0,18,20,22,21,18,10,15,0.5,4.0,''),
  (23597,'2116-07-18','7:30',24,'',1486,1489,0,18,17,21,21,18,9,15,0.5,4.0,''),
  (23598,'2116-07-18','6:30',24,'',1491,1518,0,54,21,17,21,15,15,8,4.5,0.0,''),
  (23599,'2116-07-18','7:30',24,'',1518,1378,0,54,21,14,21,11,15,8,4.5,0.0,''),
  (23600,'2116-07-18','6:30',24,'',1490,1488,0,15,21,17,21,13,15,7,4.5,0.0,''),
  (23601,'2116-07-18','7:30',24,'',1488,1491,0,15,7,21,12,21,13,15,0.0,4.5,''),
  (23602,'2116-07-18','6:30',24,'',410,1493,0,13,21,8,21,8,15,10,4.5,0.0,''),
  (23603,'2116-07-18','7:30',38,'',1493,1490,0,13,15,21,22,24,13,15,0.0,4.5,''),
  (23604,'2116-07-18','6:30',24,'',1489,1487,0,16,21,13,19,21,15,10,4.0,0.5,''),
  (23605,'2116-07-18','7:30',24,'',1487,410,0,16,19,21,19,21,15,12,0.5,4.0,''),
  (23606,'2116-07-18','6:30',24,'',1496,1495,0,17,21,15,9,21,10,15,0.5,4.0,''),
  (23607,'2116-07-18','7:30',24,'',1494,1492,0,17,14,21,21,11,15,5,4.0,0.5,''),
  (23608,'2116-07-18','6:30',24,'',1517,1494,0,8,21,8,20,22,15,7,4.0,0.5,''),
  (23609,'2116-07-18','7:30',24,'',1495,1517,0,8,16,21,15,21,15,10,0.5,4.0,''),
  (23610,'2116-06-21','6:30',24,'',1519,1498,0,15,13,21,21,17,7,15,0.5,4.0,''),
  (23611,'2116-06-21','7:30',24,'',1498,1501,0,15,22,24,26,24,9,15,0.5,4.0,''),
  (23612,'2116-06-21','6:30',24,'',1499,1500,0,0,15,21,17,21,14,15,0.0,4.5,'Grassias!           15  17  14\r\nHop Heads        21  21  15'),
  (23613,'2116-06-21','7:30',24,'',1500,1503,0,0,8,21,19,21,15,12,0.5,4.0,'Hop Heads         8  19  15\r\nVolleybrawlers  21  21  12'),
  (23614,'2116-06-21','6:30',24,'',1501,1502,0,51,19,21,21,18,15,5,4.0,0.5,''),
  (23615,'2116-06-21','7:30',24,'',1502,1519,0,51,22,20,21,15,12,15,4.0,0.5,''),
  (23616,'2116-06-21','6:30',24,'',1503,1504,0,57,16,21,21,19,15,12,3.0,0.5,''),
  (23617,'2116-06-21','7:30',24,'',1504,1499,0,57,21,18,21,18,15,17,4.0,0.5,''),
  (23618,'2116-06-21','6:30',24,'',1505,1506,0,17,12,21,13,21,16,14,0.5,4.0,''),
  (23619,'2116-06-21','7:30',24,'',1506,1507,0,17,21,7,21,12,15,10,4.5,0.0,''),
  (23620,'2116-06-21','6:30',24,'',1507,1508,0,0,21,8,23,21,15,10,4.5,0.0,'Grasshoppers    21  23  15\r\niSpike                  8   21  10'),
  (23621,'2116-06-21','7:30',24,'',1508,1505,0,0,22,21,21,11,14,16,4.0,0.5,''),
  (23623,'2116-06-27','6:30',24,'JILL',1495,1520,1,57,5,21,8,21,4,15,0.0,4.5,''),
  (23624,'2116-06-27','7:30',24,'',1520,1489,1,57,23,21,22,20,15,9,4.5,0.0,''),
  (23625,'2116-07-11','6:30',24,'JILL',1520,1494,1,57,21,10,21,4,15,9,4.5,0.0,''),
  (23626,'2116-07-11','7:30',24,'JILL',1494,1520,1,57,5,21,6,21,4,15,0.0,4.5,'This matchup of a top level A vs.a B team wasn\'t fun for either team.'),
  (23627,'2116-07-18','6:30',24,'JILL',1492,1520,1,57,11,21,9,21,11,15,0.0,4.5,'Another lopsided mismatch.'),
  (23628,'2116-07-18','7:30',24,'JILL',1520,1492,1,57,21,5,21,12,15,9,4.5,0.0,'Extremely mismatched'),
  (23629,'2116-06-28','6:30',24,'KIM',1519,1500,0,0,17,21,11,21,10,15,0.0,4.5,'Hopheads              21   21   15\r\nfluorescent Balls   17   11   10'),
  (23630,'2116-06-28','7:30',24,'KIM',1504,1519,0,0,19,21,20,22,12,15,0.0,4.5,'Whatever                19   20   12\r\nfluorescent Balls      21   22   15'),
  (23631,'2116-06-28','6:30',24,'JILL',1498,1503,0,57,17,21,23,21,15,12,4.0,0.5,''),
  (23633,'2116-06-28','7:30',24,'JILL',1502,1498,0,57,21,9,21,17,17,19,4.0,0.5,''),
  (23634,'2116-06-28','6:30',24,'',1499,1502,0,0,17,21,17,21,13,15,0.0,4.5,'Rhombus   21   21   15\r\nGrassias    17   17   13'),
  (23635,'2116-06-28','7:30',24,'JIM',1500,1501,0,0,20,22,24,26,8,15,0.0,4.5,'PVA Allstars   22   26   15\r\nHopheads      20   24   8'),
  (23636,'2116-06-28','6:30',24,'LISA',1501,1504,0,0,21,19,19,21,15,12,4.0,0.5,'Whatever          19   21   12\r\nPVA Allstars       21   19   15'),
  (23637,'2116-06-28','7:30',24,'LISA',1503,1499,0,0,13,21,11,21,10,15,0.0,4.5,'Volleybrawlers   13   11   10\r\nGrassias            21   21   15'),
  (23638,'2116-06-28','6:30',24,'NORM',1505,1507,0,17,17,21,17,21,15,13,0.5,4.0,''),
  (23639,'2116-06-28','7:30',24,'NORM',1506,1505,0,17,21,18,16,21,15,7,4.0,0.5,''),
  (23640,'2116-06-28','6:30',24,'',1506,1508,0,0,21,17,21,18,15,10,4.5,0.0,''),
  (23641,'2116-06-28','7:30',24,'',1508,1507,0,0,19,21,21,13,15,13,4.0,0.5,'Ispike                19   21   15\r\nGrasshoppers   21   13   13'),
  (23642,'2116-07-05','6:30',24,'LISA',1498,1504,0,0,9,21,15,21,9,15,0.0,4.5,''),
  (23643,'2116-07-05','7:30',24,'LISA',1504,1502,0,0,17,21,16,21,11,15,0.0,4.5,'Rhombus.        21   21   15\r\nWhatever.        17   16   11'),
  (23644,'2116-07-05','6:30',24,'KIM',1502,1500,0,51,21,19,21,23,19,17,4.0,0.5,''),
  (23645,'2116-07-05','7:30',24,'KIM',1500,1498,0,51,23,21,21,15,15,9,4.5,0.0,''),
  (23646,'2116-07-05','6:30',24,'JILL',1501,1503,0,57,21,13,21,15,15,5,4.5,0.0,''),
  (23647,'2116-07-05','7:30',24,'JILL',1503,1519,0,57,17,21,11,21,15,13,0.5,4.0,''),
  (23648,'2116-07-05','6:30',24,'JIM',1505,1508,0,54,25,23,21,15,15,10,4.5,0.0,''),
  (23649,'2116-07-05','7:30',24,'JIM',1508,1506,0,54,21,19,15,21,14,16,0.5,4.0,''),
  (23650,'2116-07-05','6:30',24,'NORM',1519,1499,0,17,21,15,21,14,15,8,4.5,0.0,''),
  (23651,'2116-07-05','7:30',24,'NORM',1499,1501,0,17,9,21,12,21,8,15,0.0,4.5,''),
  (23652,'2116-07-05','6:30',24,'',1507,1506,0,13,21,18,12,21,15,13,3.0,1.5,''),
  (23653,'2116-07-05','7:30',24,'',1507,1505,0,13,21,18,18,21,15,6,4.0,0.5,''),
  (23654,'2116-07-12','6:30',24,'',1507,1508,0,13,24,22,21,12,15,11,4.5,0.0,''),
  (23655,'2116-07-12','7:30',24,'',1508,1498,0,13,9,21,8,21,13,15,0.0,4.5,''),
  (23656,'2116-07-12','6:30',24,'NORM',1501,1519,0,17,21,17,21,10,15,6,4.5,0.0,''),
  (23657,'2116-07-12','7:30',24,'NORM',1519,1505,0,17,21,8,21,16,15,5,4.5,0.0,''),
  (23658,'2116-07-12','6:30',24,'JIM',1498,1499,0,54,21,16,17,21,16,14,4.0,0.5,''),
  (23659,'2116-07-12','7:30',24,'JIM',1499,1507,0,54,21,8,21,9,15,5,4.5,0.0,''),
  (23660,'2116-07-12','6:30',24,'KIM',1504,1500,0,51,18,21,14,21,11,15,0.0,4.5,''),
  (23661,'2116-07-12','7:30',24,'KIM',1501,1500,0,51,21,18,21,15,16,14,4.5,0.0,''),
  (23662,'2116-07-12','6:30',24,'LISA',1502,1503,0,15,21,19,21,14,9,15,4.0,0.5,''),
  (23663,'2116-07-12','7:30',24,'LISA',1506,1502,0,15,21,14,13,21,8,15,0.5,4.0,''),
  (23664,'2116-07-12','6:30',24,'JILL',1505,1506,0,57,21,18,9,21,0,15,0.5,4.0,'BASJHR was late.  Forfeited third.'),
  (23665,'2116-07-12','7:30',24,'JILL',1504,1503,0,57,14,21,14,21,15,13,0.5,4.0,''),
  (23666,'2116-07-20','6:30',24,'',1509,1511,0,16,21,19,13,21,15,17,0.5,4.0,''),
  (23667,'2116-07-20','7:30',24,'',1514,1510,0,16,16,21,12,21,6,15,0.0,4.5,''),
  (23668,'2116-07-20','6:30',24,'',1515,1512,0,16,21,18,21,5,15,5,4.5,0.0,'Should have been WOOP WOOP against MR TEAM.\r\n\r\nWOOP WOOP        21     21     15\r\n\r\nMR TEAM             18      5       5'),
  (23669,'2116-07-20','7:30',24,'',1513,1516,0,16,21,0,21,0,15,0,4.5,0.0,'FALCONS were a no show'),
  (23670,'2116-07-27','6:30',24,'',1510,1515,0,16,22,20,21,18,15,9,4.5,0.0,''),
  (23671,'2116-07-27','7:30',24,'',1516,1509,0,16,0,21,0,21,0,15,0.0,4.5,''),
  (23672,'2116-07-27','6:30',24,'',1512,1514,0,16,19,21,21,16,15,13,4.0,0.5,''),
  (23673,'2116-07-27','7:30',24,'',1511,1513,0,16,21,19,24,22,17,15,4.5,0.0,''),
  (23674,'2116-08-03','6:30',24,'',1510,1511,0,16,16,21,21,15,7,15,0.5,4.0,''),
  (23675,'2116-08-03','7:30',24,'',1514,1509,0,16,20,22,7,21,17,15,0.5,4.0,'SHOULD BE SNOB KNOB INSTEAD OF EGGS & SAUSAGE'),
  (23676,'2116-08-03','6:30',24,'',1513,1515,0,16,20,22,9,21,14,16,0.0,4.5,''),
  (23677,'2116-08-03','7:30',24,'',1512,1516,0,16,21,13,15,21,15,8,4.0,0.5,''),
  (23679,'2116-08-10','6:30',24,'',1516,1511,0,16,21,12,22,24,7,15,0.5,4.0,''),
  (23680,'2116-08-10','7:30',24,'',1510,1509,0,16,21,16,21,17,15,9,4.5,0.0,''),
  (23681,'2116-08-10','6:30',24,'',1515,1514,0,16,21,7,21,16,15,12,4.5,0.0,''),
  (23682,'2116-08-10','7:30',38,'',1513,1512,0,16,14,21,21,10,15,5,4.0,0.5,''),
  (23683,'2116-07-19','6:30',24,'',1498,1519,0,17,21,18,14,21,15,13,3.0,1.5,''),
  (23684,'2116-07-19','7:30',24,'',1501,1498,0,17,21,18,21,10,15,11,4.5,0.0,''),
  (23685,'2116-07-19','6:30',24,'',1500,1499,0,15,14,21,21,14,15,12,4.0,0.5,''),
  (23686,'2116-07-19','7:30',24,'',1507,1500,0,15,10,21,17,21,21,23,0.0,4.5,''),
  (23687,'2116-07-19','6:30',24,'',1502,1501,0,57,21,18,21,12,12,15,4.0,0.5,''),
  (23688,'2116-07-19','7:30',24,'',1519,1502,0,57,15,21,18,21,11,15,0.0,4.5,''),
  (23689,'2116-07-19','6:30',24,'',1504,1503,0,54,21,18,22,20,15,9,4.5,0.0,''),
  (23690,'2116-07-19','7:30',24,'',1508,1504,0,54,9,21,14,21,6,15,0.0,4.5,''),
  (23691,'2116-07-19','6:30',24,'',1507,1506,0,51,21,18,21,7,15,8,4.5,0.0,''),
  (23692,'2116-07-19','7:30',24,'',1506,1503,0,51,21,19,21,17,6,15,3.0,1.5,''),
  (23693,'2116-07-19','6:30',24,'',1505,1508,0,56,15,21,21,11,5,15,0.5,4.0,''),
  (23694,'2116-07-19','7:30',24,'',1499,1505,0,56,21,11,21,16,15,12,4.5,0.0,''),
  (23695,'2116-07-26','6:30',24,'Norm',1500,1519,0,17,21,14,21,10,15,11,4.5,0.0,''),
  (23696,'2116-07-26','7:30',24,'Norm',1501,1500,0,17,21,11,21,18,15,12,4.5,0.0,''),
  (23697,'2116-07-26','6:30',24,'Lisa W',1503,1498,0,15,21,9,12,21,4,15,0.5,4.0,''),
  (23698,'2116-07-26','7:30',24,'Lisa W',1519,1504,0,15,23,21,15,21,15,11,3.0,0.5,''),
  (23699,'2116-07-26','6:30',24,'Jill',1502,1499,0,57,21,14,19,21,15,0,4.0,0.5,''),
  (23700,'2116-07-26','7:30',24,'Jill',1498,1502,0,57,8,21,17,21,13,15,0.0,4.5,''),
  (23701,'2116-07-26','6:30',24,'Lisa K',1504,1501,0,54,14,21,16,21,16,18,0.0,4.5,''),
  (23702,'2116-07-26','7:30',24,'Lisa K',1499,1503,0,54,21,16,19,21,15,8,4.0,0.5,''),
  (23703,'2116-07-26','6:30',24,'Kim',1505,1507,0,51,20,22,21,9,7,15,1.5,3.0,''),
  (23704,'2116-07-26','7:30',24,'Kim',1506,1505,0,51,12,21,16,21,15,13,0.5,4.0,''),
  (23705,'2116-07-26','6:30',24,'Scott',1506,1508,0,56,21,18,16,21,7,15,0.5,4.0,''),
  (23706,'2116-07-26','7:30',24,'Scott',1508,1507,0,56,21,19,19,21,12,15,0.5,4.0,''),
  (23707,'2116-08-02','6:30',24,'Norm',1504,1498,0,17,21,18,21,18,13,15,4.0,0.5,''),
  (23708,'2116-08-02','7:30',24,'Norm',1502,1504,0,17,13,21,21,15,15,13,3.0,0.5,''),
  (23709,'2116-08-02','6:30',24,'Lisa W',1500,1502,0,15,21,18,17,21,10,15,0.5,4.0,''),
  (23710,'2116-08-02','7:30',24,'Lisa W',1498,1500,0,15,16,21,19,21,15,10,0.5,4.0,''),
  (23711,'2116-08-02','6:30',24,'Jill',1503,1501,0,57,8,21,13,21,10,15,0.0,4.5,''),
  (23712,'2116-08-02','7:30',24,'Jill',1519,1503,0,57,13,21,21,23,16,14,0.5,4.0,''),
  (23713,'2116-08-02','6:30',24,'Lisa K',1499,1519,0,54,21,14,21,12,15,13,4.5,0.0,''),
  (23714,'2116-08-02','7:30',24,'Lisa K',1501,1499,0,54,21,11,20,22,15,11,4.0,0.5,''),
  (23715,'2116-08-02','6:30',24,'Kim',1505,1508,0,51,11,21,21,13,15,17,0.5,4.0,''),
  (23716,'2116-08-02','7:30',24,'Kim',1508,1506,0,51,21,16,21,12,10,15,4.0,0.5,''),
  (23717,'2116-08-02','6:30',24,'Scott',1507,1506,0,56,21,19,12,21,15,4,4.0,0.5,''),
  (23718,'2116-08-02','7:30',24,'Scott',1507,1505,0,56,21,17,21,12,13,15,4.0,0.5,''),
  (23719,'2116-08-09','6:30',24,'Norm',1519,1501,0,17,9,21,7,21,9,15,0.0,4.5,''),
  (23720,'2116-08-09','7:30',24,'Norm',1503,1500,0,17,11,21,14,21,8,15,0.0,4.5,''),
  (23721,'2116-08-09','6:30',24,'Lisa W',1499,1498,0,15,21,18,24,22,14,16,4.0,0.5,''),
  (23722,'2116-08-09','7:30',24,'Lisa W',1501,1498,0,15,21,16,21,16,15,5,4.5,0.0,''),
  (23723,'2116-08-09','6:30',24,'Jill',1500,1504,0,57,21,18,18,21,15,9,4.0,0.5,''),
  (23724,'2116-08-09','7:30',24,'Jill',1499,1504,0,57,21,18,22,20,12,15,4.0,0.5,''),
  (23725,'2116-08-09','6:30',24,'Lisa K',1503,1502,0,54,11,21,13,21,8,15,0.0,4.5,''),
  (23726,'2116-08-09','7:30',24,'Lisa K',1502,1519,0,54,21,19,21,14,15,5,4.5,0.0,''),
  (23727,'2116-08-09','6:30',24,'Kim',1505,1506,0,51,21,16,21,11,10,15,4.0,0.5,''),
  (23728,'2116-08-09','7:30',24,'Kim',1506,1507,0,51,21,9,21,17,10,15,4.0,0.5,''),
  (23729,'2116-08-09','6:30',24,'Scott',1507,1508,0,56,21,15,21,8,15,6,4.5,0.0,''),
  (23730,'2116-08-09','7:30',24,'Scott',1508,1505,0,56,21,16,11,21,9,15,0.5,4.0,''),
  (23731,'2116-07-25','6:30',24,'Pam',1521,1525,0,18,21,14,21,13,15,10,4.5,0.0,''),
  (23732,'2116-07-25','7:30',24,'Pam',1525,1524,0,18,7,21,13,21,7,15,0.0,4.5,''),
  (23733,'2116-07-25','6:30',24,'Lisa K',1522,1523,0,54,19,21,21,17,10,15,0.5,4.0,''),
  (23734,'2116-07-25','7:30',24,'Lisa K',1526,1522,0,54,12,21,21,17,7,15,0.5,4.0,''),
  (23735,'2116-07-25','6:30',24,'Lisa W',1524,1526,0,15,16,21,17,21,15,10,0.5,4.0,''),
  (23736,'2116-07-25','7:30',24,'Lisa W',1523,1521,0,15,11,21,21,18,10,15,0.5,4.0,''),
  (23737,'2116-07-25','6:30',24,'Karen',1487,1518,0,13,21,14,21,6,15,4,4.5,0.0,''),
  (23738,'2116-07-25','7:30',24,'Karen',1528,1529,0,13,14,21,18,21,15,7,0.5,4.0,''),
  (23739,'2116-07-25','6:30',24,'Marty',1529,1530,0,16,21,14,21,14,12,15,4.0,0.5,''),
  (23740,'2116-07-25','7:30',24,'Marty',1530,1531,0,16,21,15,21,13,15,13,4.5,0.0,''),
  (23741,'2116-07-25','6:30',24,'Norm',1531,1532,0,17,11,21,21,12,15,13,4.0,0.5,''),
  (23743,'2116-07-25','6:30',24,'Jill',1492,1494,0,57,19,21,11,21,12,15,0.0,4.5,''),
  (23744,'2116-07-25','7:30',24,'Jill',1494,1495,0,57,15,21,21,19,14,16,0.5,4.0,''),
  (23745,'2116-07-25','6:30',24,'Andy',1495,1492,0,0,16,21,21,13,15,5,4.0,0.5,'Healthy Hits.    16    21.   15\r\nOther Team.      21.   13.    5\r\n'),
  (23746,'2116-07-25','7:30',24,'Andy',1443,1492,0,0,19,21,19,21,15,10,1.5,3.0,'Other Team.   19.   19.    15\r\nFembots.         21.    21.    10'),
  (23747,'2116-08-01','6:30',24,'Pam',1525,1529,1,18,18,21,19,21,13,15,0.0,4.5,''),
  (23748,'2116-08-01','7:30',24,'Pam',1525,1490,1,18,21,6,21,11,14,16,4.0,0.5,''),
  (23749,'2116-08-01','6:30',24,'Lisa K',1528,1531,0,54,21,18,21,12,17,15,4.5,0.0,''),
  (23750,'2116-08-01','7:30',24,'Lisa K',1532,1528,0,54,17,21,22,24,9,15,0.0,4.5,''),
  (23751,'2116-08-01','6:30',24,'Lisa W',1530,1532,0,15,21,12,15,21,16,14,4.0,0.5,''),
  (23752,'2116-08-01','7:30',24,'Lisa W',1531,1529,0,15,11,21,9,21,1,15,0.0,4.5,''),
  (23753,'2116-08-01','6:30',24,'Karen',1521,1522,0,13,22,24,21,14,15,9,4.0,0.5,''),
  (23754,'2116-08-01','7:30',24,'Karen',1522,1527,1,13,15,21,21,18,15,9,4.0,0.5,''),
  (23755,'2116-08-01','6:30',24,'Marty',1523,1524,0,16,21,17,6,21,15,9,3.0,1.5,''),
  (23756,'2116-08-01','7:30',24,'Marty',1524,1521,0,16,21,15,16,21,15,3,4.0,0.5,''),
  (23757,'2116-08-01','6:30',24,'Norm',1527,1526,1,17,18,21,21,18,15,12,4.0,0.5,''),
  (23758,'2116-08-01','7:30',24,'Norm',1526,1523,0,17,19,21,17,21,11,15,0.0,4.5,''),
  (23759,'2116-08-01','6:30',24,'Jill',1492,1495,0,56,19,21,13,21,7,15,0.0,4.5,''),
  (23760,'2116-08-01','7:30',24,'Jill',1494,1492,0,56,21,19,21,13,15,7,4.5,0.0,''),
  (23761,'2116-08-01','6:30',24,'Andy',1494,1496,0,8,21,19,21,23,8,15,0.5,4.0,''),
  (23762,'2116-08-01','7:30',24,'Andy',1496,1495,0,8,21,19,14,21,10,15,0.5,4.0,''),
  (23763,'2116-08-08','6:30',24,'Pam',1495,1494,0,18,14,21,17,21,15,8,0.5,4.0,''),
  (23768,'2116-08-08','7:30',24,'Lisa K',1496,1494,0,54,16,21,11,21,14,16,0.0,4.5,''),
  (23765,'2116-08-08','7:30',24,'Pam',1495,1492,0,18,21,8,21,18,15,7,4.5,0.0,''),
  (23767,'2116-08-08','6:30',24,'Lisa K',1492,1496,0,54,21,14,12,21,15,9,4.0,0.5,''),
  (23769,'2116-08-08','6:30',24,'Lisa W',1525,1531,0,15,21,0,21,0,15,0,4.5,0.0,'Takillias didn\'t show for match so forfeited all 3 sets'),
  (23770,'2116-08-08','7:30',24,'Lisa W',1532,1531,0,15,21,0,21,0,15,0,4.5,0.0,'Takillias no show for 2nd match. '),
  (23771,'2116-08-08','6:30',24,'Karen',1528,1530,0,13,15,21,17,21,14,16,0.0,4.5,''),
  (23772,'2116-08-08','7:30',24,'Karen',1528,1525,0,13,14,21,23,21,15,17,0.5,4.0,''),
  (23773,'2116-08-08','6:30',24,'Marty',1529,1532,0,16,21,12,21,12,15,11,4.5,0.0,''),
  (23774,'2116-08-08','7:30',24,'Marty',1530,1529,0,16,12,21,21,19,11,15,0.5,4.0,''),
  (23775,'2116-08-08','6:30',24,'Norm',1526,1521,0,17,19,21,10,21,11,15,0.0,4.5,''),
  (23776,'2116-08-08','7:30',24,'Norm',1526,1524,0,17,21,17,21,18,15,12,4.5,0.0,''),
  (23777,'2116-08-08','6:30',24,'Jill',1522,1524,0,57,21,19,21,18,15,10,4.5,0.0,''),
  (23778,'2116-08-08','7:30',24,'Jill',1527,1521,0,57,12,21,7,21,15,13,0.5,4.0,''),
  (23779,'2116-08-08','6:30',24,'Andy',1523,1527,0,8,21,10,21,10,15,4,4.5,0.0,''),
  (23780,'2116-08-08','7:30',24,'Andy',1523,1522,0,8,21,15,22,20,15,13,4.5,0.0,''),
  (23781,'2116-08-15','6:30',24,'Pam',1521,1523,0,18,21,12,14,21,19,17,4.0,0.5,''),
  (23782,'2116-08-15','7:30',24,'Pam',1522,1521,0,18,17,21,21,14,15,6,4.0,0.5,''),
  (23783,'2116-08-15','6:30',24,'Lisa K',1522,1526,0,54,16,21,16,21,17,15,0.5,4.0,''),
  (23784,'2116-08-15','7:30',24,'Lisa K',1526,1527,0,54,20,22,21,8,15,7,4.0,0.5,''),
  (23785,'2116-08-15','6:30',24,'Lisa W',1524,1527,0,15,21,15,22,20,15,7,4.5,0.0,''),
  (23786,'2116-08-15','7:30',24,'Lisa W',1524,1523,0,15,13,21,21,18,10,15,0.5,4.0,''),
  (23787,'2116-08-15','6:30',24,'Karen',1492,1494,0,13,15,21,15,21,15,13,0.5,4.0,''),
  (23788,'2116-08-15','7:30',24,'Karen',1494,1495,0,13,18,21,11,21,15,13,0.5,4.0,''),
  (23789,'2116-08-15','6:30',24,'Marty',1495,1496,0,16,21,17,21,16,15,5,4.5,0.0,''),
  (23790,'2116-08-15','7:30',24,'Marty',1496,1492,0,16,21,14,21,15,15,10,4.5,0.0,''),
  (23791,'2116-08-15','6:30',24,'Norm',1529,1528,0,17,11,21,12,21,13,15,0.0,4.5,''),
  (23792,'2116-08-15','7:30',24,'Norm',1529,1525,0,17,21,14,23,21,15,8,4.5,0.0,''),
  (23793,'2116-08-15','6:30',24,'Jill',1531,1530,0,57,13,21,22,20,15,17,0.5,4.0,'Yellow card Quad Squad setter-julie.  Unrelenting question of referees calls.  '),
  (23794,'2116-08-15','7:30',24,'Jill',1531,1528,0,57,22,20,7,21,12,15,0.5,4.0,''),
  (23795,'2116-08-15','6:30',24,'Andy',1525,1532,0,8,15,21,17,21,17,15,0.5,4.0,''),
  (23796,'2116-08-15','7:30',24,'Andy',1532,1530,0,8,25,23,21,10,5,15,4.0,0.5,''),
  (23797,'2116-07-25','7:30',24,'',1488,1487,0,17,21,15,7,21,10,15,0.5,4.0,''),
  (23798,'2116-08-16','6:30',24,'',1501,1499,0,15,21,14,21,23,8,15,0.5,4.0,'Grassias   17   21   15    \r\nRhombus    21   16   10  '),
  (23799,'2116-08-16','6:30',24,'',1502,1500,0,51,21,12,21,10,0,0,4.0,0.0,'PVA                21   21\r\nHop Heads     14.  14'),
  (23800,'2116-08-16','6:30',24,'',1507,1505,0,17,21,14,21,13,0,0,4.0,0.0,'grasshopper def east of eden 21-18  24-22  for first'),
  (23801,'2116-08-16','6:30',24,'',1506,1508,0,57,21,6,21,15,0,0,4.0,0.0,''),
  (23802,'2116-08-17','6:30',24,'',1515,1513,0,16,21,15,21,19,0,0,4.0,0.0,'EGGS & SAUSAGE     21     23\r\n\r\nWOOP WOOP           15     21\r\n\r\nEGGS & SAUSAGE WINS SAND QUADS'),
  (23803,'2116-08-17','6:30',24,'',1510,1511,0,13,21,12,19,21,11,15,1.5,3.0,''),
  (23804,'2116-08-22','6:30',24,'Norm',1495,1492,0,17,NULL,NULL,NULL,NULL,NULL,NULL,0.0,0.0,NULL),
  (23805,'2116-08-22','6:30',24,'Jill',1494,1496,0,57,NULL,NULL,NULL,NULL,NULL,NULL,0.0,0.0,NULL),
  (23806,'2116-08-22','6:30',24,'Lisa W',1521,1526,0,15,NULL,NULL,NULL,NULL,NULL,NULL,0.0,0.0,NULL),
  (23807,'2116-08-22','6:30',24,'Marty',1523,1522,0,16,NULL,NULL,NULL,NULL,NULL,NULL,0.0,0.0,NULL),
  (23808,'2116-08-22','6:30',24,'Pam',1529,1532,0,18,NULL,NULL,NULL,NULL,NULL,NULL,0.0,0.0,NULL),
  (23809,'2116-08-22','6:30',24,'Karen',1528,1530,0,13,NULL,NULL,NULL,NULL,NULL,NULL,0.0,0.0,NULL);

/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gyms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gyms`;

CREATE TABLE `gyms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(200) NOT NULL DEFAULT '',
  `map` varchar(200) DEFAULT NULL,
  `directions` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `gyms` WRITE;
/*!40000 ALTER TABLE `gyms` DISABLE KEYS */;

INSERT INTO `gyms` (`id`, `name`, `address`, `map`, `directions`)
VALUES
  (9,'East Portland Community Center','SE 106th and SE Stark','http://maps.google.com/maps?q=SE+106th+and+SE+Stark,+Portland,+OR','Take I-205 to the Washington-Stark Exit. Turn east on Washington, get into the right-hand lane, and go to 106th. Turn right, and the community center is two blocks ahead, on the left.\r\n        '),
  (47,'To be Determined','','','You will have a game scheduled this night I just need to find a location!'),
  (42,'BYE','','','If you see this next to your team for the week you do not have a game.'),
  (43,'Cancelled','','',''),
  (18,'Montavilla Community Center','8219 NE Glisan','http://www.mapquest.com/maps/map.adp?country=US&addtohistory=&address=8219+NE+Glisan&city=portland&state=or&zipcode=&homesubmit=Get+Map','From I-84 east take the 82nd Ave exit. Turn left at the light at 82nd, and go south. The community center is on the corner of 82nd and Glisan, and the parking lot entrance is on 82nd, north of Glisan.\r\n        '),
  (22,'St. Johns Community Center','8427 N Central','http://www.mapquest.com/maps/map.adp?country=US&addtohistory=&address=8427+N+Central&city=portland&state=or&zipcode=&homesubmit=Get+Map','From I-5 north take the Lombard West exit. Follow Lombard to Leavitt (this is several miles from I-5). Turn right on Leavitt. Go 2 blocks. The street dead-ends at the front door of the Community Center. <br><br>From I-405 (Fremont Bridge), follow US Hwy 30 (St. Helens Hwy) 4+ miles to the St. Johns Bridge Exit (a left-turn exit). Turn left, go up the hill and over the bridge. Stay in the right lane, go straight ahead, through the first stoplight, to the second stoplight (Lombard). Turn right, go one block to Leavitt and turn left, and the community center is two blocks straight ahead.'),
  (49,'Milwaukie High School Aux Gym','11300 SE 23rd Ave','http://www.mapquest.com/maps/map.adp?searchtype=address&formtype=search&countryid=250&addtohistory=&country=US&address=11300+SE+23rd+Ave&city=Milwaukie&state=or&zipcode=&historyid=&submit=Get+Map','Same as MHS Main gym just the little gym.'),
  (23,'Lents Park','SE 92nd / Holgate','http://www.mapquest.com/maps/map.adp?country=US&addtohistory=&address=92nd+and+Holgate&city=portland&state=or&zipcode=&homesubmit=Get+Map','From Powell, go South on 82nd.  Turn left on Holgate.  Park is on your right, at the corner of 92nd and Holgate.\r\n        \r\n        '),
  (24,'Brentwood Park','SE 60th & SE Duke','http://maps.google.com/maps?q=SE+60th+and+SE+Duke,+Portland,+OR','From Powell, go South on 52nd.  Turn left at Duke, and go to the stop sign by the Dairy Queen (60th Ave.)  Go right, park is on your left.\r\n        \r\n        '),
  (30,'Milwaukie High School Main Gym','11300 SE 23rd Ave','http://www.mapquest.com/maps/map.adp?searchtype=address&formtype=search&countryid=250&addtohistory=&country=US&address=11300+SE+23rd+Ave&city=Milwaukie&state=or&zipcode=&historyid=&submit=Get+Map','From I205 take the OR-224 exit toward Milwaukie.  Turn LEFT onto SE 82md Dr/OR-224 continue on to follow OR-224.  Turn LEFT onto SE Oak St.  Turn RIGHT onto SE Washington ST.  Turn LEFT onto SE 23rd Ave.     '),
  (50,'Charles Jordan Community Center','9009 N Foss Ave','http://maps.yahoo.com/;_ylc=X3oDMTExNmIycG51BF9TAzI3MTYxNDkEc2VjA2ZwLWJ1dHRvbgRzbGsDbGluaw--#mvt=m&gid1=21947024&q1=9009%20N%20Foss%20Ave%20%20Portland,%20OR%2097230&trf=0&lon=-122.710397&lat=45.58677','Formally known as University Park Community Center.\r\n\r\nTake I-5 North to exit #305B/Lombard ST. West.  Turn Right on N Chautaugua BLVD.  Turn Left on N Willis BLVD.  Turn Right on N Foss Ave.  503-823-3631'),
  (38,'Beaverton Courts','14523 SW Millikan Way, Beaverton','http://maps.google.com/maps?q=14523+SW+Millikan+Way,+Beaverton+OR','Drive West on US-26 toward Beaverton.  Take the Murray Blvd Exit (Exit 67).  Turn Left onto NW Murray Rd., it will turn into SW Murray Blvd.  Turn Left onto SW Millikan.  The building is on the left so at the first driveway on Millikan turn left.  There is no sign posted saying this is the gym.'),
  (39,'Parkrose High School','12003 NE Shaver, Portland','http://www.mapquest.com/maps/map.adp?searchtype=address&country=US&addtohistory=&searchtab=home&address=12003+NE+Shaver+Street&city=portland&state=or&zipcode=','From downtown, take I-84 east to the 122nd Ave exit.  Turn right at the stoplight, go north to the light at Shaver, and turn left.  The school is ahead on the right.<br><br>From Gresham, take I-84 west to the 181st exit.  Turn right, and take 181st/Airport Way to 122nd.  Turn left, and go to Shaver.  Turn right, and the school is ahead on the right.<br><br>From Vancouver, take I-205 south to the Airport Way exit.  Take Airport Way east to 122nd.  Turn right and go to Shaver.  Turn right, and the school is ahead on the right.'),
  (52,'Delta Park','N Denver Ave & Martin Luther King Jr Blvd','http://maps.yahoo.com/;_ylc=X3oDMTExNmIycG51BF9TAzI3MTYxNDkEc2VjA2ZwLWJ1dHRvbgRzbGsDbGluaw--#mvt=m&lat=35.042721&lon=-85.299667&zoom=15&q1=N%20Denver%20Ave%20%26%20Martin%20Luther%20King%20Jr%20Blvd','These sand courts are located in the softball/soccer complex.'),
  (53,'PCC Sylvania','12000 SW 49th Ave  Portland, OR  97219','http://www.mapquest.com/maps?city=Portland&state=OR&address=12000+SW+49th+Ave+&zipcode=97219','From I-5 SB, exit at Capitol Hwy Exit\r\nMake two circular right hand-turns until headed SOUTH on Capitol Hwy.\r\nCapitol Hwy turns into SW 49th Avenue..continue southbd.\r\nAt PCC Sylvania Sign (about 3/4 - 1 mile from Barbur) turn right into campus.\r\nAt first tee, turn right.\r\nAt stop sign (about 1 short block) turn left.\r\nGo to the end of this street (thru 1 stop sign).\r\nAt this tee, turn left.\r\nThis little street dead ends into Parking Lot 12.  Players will need to purchase a parking pass to park in *any* PCC parking lot. Passes can be purchased at the kiosk located in lot 11. The cost is $2 per pass and the pass is good for two hours ($3 for 3 hours). If you do not have a pass on your dashboard, you may be assessed a $20 ticket. PVA is not responsible for any tickets issued.\r\nThe gym building is adjacent, south.\r\nGym is on second floor.'),
  (57,'Eastmoreland Courts','3015 SE Berkeley Place','http://www.mapquest.com/#d57253eed0e0d7fdc9a8fff8','Gym #503-653-0820\r\n'),
  (56,'Valley View Gym','11501 SE Sunnyside Road  97015','http://maps.yahoo.com/#q=11501+SE+Sunnyside+Rd%2C+Clackamas%2C+OR++97015-9305&conf=1&start=1&lat=45.43351&lon=-122.544983&zoom=16&mvt=m&trf=0&tt=','Take exit #14 (SUNNYSIDE RD./SUNNYBROOK BLVD. toward SUNNYSIDE RD. WEST/SUNNYSIDE RD. EAST/CLACKAMAS PROMENADE/BORING/SUNNYBROOK BLVD) Take a Left off of the exit.  Head East on Sunnyside Road.  Make a U-Turn at SE 117TH AVE onto SE SUNNYSIDE RD.  Remember you are looking for a Church that also has a school.');

/*!40000 ALTER TABLE `gyms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table home_page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `home_page`;

CREATE TABLE `home_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `article` longtext NOT NULL,
  `storycolumn` tinyint(4) NOT NULL DEFAULT '1',
  `dtm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `priority` int(11) NOT NULL DEFAULT '9',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `home_page` WRITE;
/*!40000 ALTER TABLE `home_page` DISABLE KEYS */;

INSERT INTO `home_page` (`id`, `title`, `article`, `storycolumn`, `dtm`, `priority`)
VALUES
  (336,'Waivers','Managers:  Please have every player on your team fill out and sign a waiver.  For individual players, waivers are valid for the year Fall 2015 to Summer 2016.  If a new player joins your team, please have the player fill out and return a waiver.  New waivers will be required for all players for the Fall 2016 season.\r\n<ul>\r\n<li>The waiver can also be downloaded <a href=\"waiver.pdf\">submit your waiver</a>.</li>\r\n<li>You can return signed waivers either by mail to Portland Volleyball Association PO Box 92122 Portland, OR 97292</li>\r\n<li><b>OR</b> by scanning and emailing to <script language=\"javascript\">\r\ngetMailto(\'waiver\', \'portlandvolleyball.org\')\r\n</script></li>\r\n<li>If you have not yet filled out a waiver, please return the signed waivers prior to your next match.</li>\r\n</ul>',1,'2015-09-21 16:19:04',9),
  (339,'Unaffiliated Players','We have created a Facebook group for Managers and Free Agents to hook up, if you haven\'t joined you can do so today! Here\'s the link: <a href=\"https://www.facebook.com/groups/portlandvolleyballassociation\">Portland Volleyball Association Managers &amp; Free Agents</a>',1,'2015-09-21 16:21:13',6),
  (344,'Rosters','Thank you to all the teams that have submitted rosters.  Please <a href=\"roster.php\">submit your roster</a> if you have not yet done so.<p />  Rosters are required to be submitted each season.',1,'2014-01-16 11:30:09',9),
  (350,'PCC Parking Update','Dear Managers,\r\n\r\nStarting May 5, 2014 players will need to purchase a parking pass to park in *any* PCC parking lot.  Passes can be purchased at the kiosk located in lot 11.  The cost is $2 per pass and the pass is good for two hours ($3 for 3 hours).  If you do not have a pass on your dashboard, you may be assessed a $20 ticket. PVA is not responsible for any tickets issued.\r\n\r\nPCC has a couple of drive-through payment stations on the way down from the top entrance. If you go in the top and turn right, heading down to the gym, the payment stations are on your right and you can pay from your car before you park. I always strongly recommend people doing that, as it allows you to get your pass before parking and you don\'t have to park and then walk to a payment station, hoping the ticket giver doesn\'t give you a ticket in the meantime.\r\n\r\n\r\nThanks,\r\nPVA Board',1,'2015-09-03 09:54:16',5),
  (358,'Fall 2016 Registration OPEN Now','Fall 2016\r\n<li>You can now register for Fall Season \r\n<li>You can view the flyer <a href=\" http://portlandvolleyball.org/flyers/flyer_fall16.pdf\r\n\">HERE</a></li>\r\n<li>Register here <a href=\"/register.php\">REGISTER</a></li>\r\n<li>League play will start the week of September 12, 2016.</li>\r\n<li>Please note, the summer leagues are there in the drop down however only the indoor leagues are available to register for, there is a glitch and this is the only way we could do it.</li>\r\n\r\n</ul>\r\n\r\nQuestions??? send an email to Michelle at <script language=\"javascript\">\r\ngetMailto(\'info\', \'portlandvolleyball.org\')\r\n</script>',1,'2016-08-08 18:43:51',9),
  (365,'Player Eligibility Decision','<p>Dear Managers and Referees,</p>\r\n\r\n<p>This email follows up on the February 13, 2015 email regarding player eligibility and whether an 18 year old player in high school may participate in PVA leagues. At the February 25, 2015 meeting of the PVA Board, the members of the board discussed and voted on this issue. Following a lengthy and wide-ranging discussion, we ultimately voted to make PVA more inclusive and include high school players who are at least 18 years of age.</p>\r\n\r\n<p>The historic rule text provided the following eligibility criteria:</p>\r\n<p style=\"margin-left: 20px;\"><em>Players must be eighteen (18) years of age and not enrolled in high school. Anyone who has graduated at the age of 17 will be allowed to participate.</em></p>\r\n\r\n<p>The rule has been updated to reflect the PVA Board vote as follows:</p>\r\n<p style=\"margin-left: 20px;\"><em>Players must be at least eighteen (18) years of age.</em></p>\r\n\r\n<p>The PVA website has been updated to reflect this change.</p>\r\n\r\n<p>Thank you to those of you who brought this issue to our attention and to those of you who provided comments.</p>\r\n\r\n<p>Regards,<br>\r\nPVA Board</p>\r\n',1,'2015-09-03 09:54:27',6),
  (369,'Milwaukie High School Parking Update','Heads up everyone, just in from the Milwaukie High School AD and Pam. We can no longer park at the Catholic church across the street from Milwaukie. If you do, you risk being towed! Please spread the word!!!\r\n',1,'2015-09-03 09:54:09',7),
  (374,'Referees','Portland Volleyball Association, is currently looking for referees for their Fall indoor leagues. Previous refereeing experience is preferred but not required. Players can make excellent referees so think about doing it on your off days if you play. We are looking for referees on Monday, Tuesday, Wednesday and Thursday evenings. Great job for college students. Must be 18 years old. Start times are as early as 6:45 PM, end as late as 10:00 PM. Matches are at various gyms in the Portland Metro Area.',1,'2016-08-08 17:14:56',9),
  (375,'2015 Fall Managers Meeting Notes','<p>\r\n  Thanks to everyone who attended the Fall 2015 Managers Meeting! Here are the\r\n  main takeaways:\r\n</p>\r\n<ul>\r\n  <li><em>Membership Requirements</em> - The PVA Board clarified registration\r\n  and membership requirements. An individual player is granted membership and\r\n  eligibility to play in PVA leagues when they are part of a properly\r\n  registered team. Proper registration must be completed and requires the\r\n  following:\r\n    <ol>\r\n      <li>Payment of team fee</li>\r\n      <li>Completed team roster</li>\r\n      <li>Completed and signed waiver for each player on the roster. Each\r\n      player must complete and sign a waiver once per fiscal year--September\r\n      1st to August 31st.</li>\r\n      <li><strong>New: <em>Email address for each player on the roster</em></strong></li>\r\n    </ol>\r\n  </li>\r\n\r\n  <li><em>Bylaws</em> - The PVA Board presented proposed amendments to the PVA\r\n  Bylaws. The managers present voted to approve the amended PVA Bylaws which have\r\n  been posted on the website on the <a href=\"rules.php\">Rules &amp; Regs</a>\r\n  page.</li>\r\n\r\n  <li><em>Ghost Player Rule</em> - The PVA Board presented a proposal to consider\r\n  implementation of the \"ghost player\" rule in coed leagues for\r\n  situations where a team needs to play with three men and two women. Feedback\r\n  from the managers was mostly positive and the board plans to vote on formally\r\n  adopting this rule during the next PVA Board meeting. Note that until that vote\r\n  occurs, the rules are updated, and teams and referees are notified, the old\r\n  exemption rule is still in place. That means for now, teams may only play\r\n  with three men and two women once during a season. Stay tuned for an update\r\n  on this issue that will become effective for the Winter Season.</li>\r\n</ul>\r\n</p>\r\n  <em>Regarding the collection of email addresses:</em>\r\n  The amended PVA Bylaws provide membership and voting rights to each individual\r\n  PVA player rather than only team managers. This change was made to conform the\r\n  PVA Bylaws to applicable state and federal law governing 501(c)(7) non-profit\r\n  athletic associations. To effect this change, PVA must collect names and email\r\n  addresses for every player in order to provide notice of any elections and to\r\n  provide an opportunity for every player to vote. PVA will be modifying the roster\r\n  submission form in the future to include a place to submit player email addresses,\r\n  but for now they may be submitted on the waivers in the field provided. Note that\r\n  all communication with teams outside of required messages to all members regarding\r\n  voting will still go through the team manager.\r\n</p>',1,'2015-09-25 12:06:57',9),
  (377,'2016 Winter Schedules','Schedules are going up for the Winter season.  Please keep checking back for updates.',1,'2015-12-31 13:11:12',9),
  (378,'Coed Ghost Player Rule','<p>The PVA Board has voted to do away with the old exemption rule which allowed a coed team to play with three men and two women <em>only once a season</em>, and instead to adopt the Ghost Player Rule as discussed at the Fall managers meeting. The rule is effective as of the beginning of Winter season and is stated as follows:</p>\r\n\r\n<p><strong>Ghost Player Rule</strong></p>\r\n\r\n<p>This rule automatically goes into effect for a coed team any time that team chooses, or is forced by circumstance, to play with only five players, and those players consist of three men and two women.</p>\r\n \r\n<p>The team playing with three men and two women must leave a space in their lineup where the missing woman should be. If the missing woman would be in the front row, there would be only two front row players for that rotation. When the missing woman would normally serve, the serve goes to the opposing team, like a side-Â­out but without any point awarded.</p>',1,'2016-01-11 14:37:59',9),
  (379,'PCC Divider','\r\n\r\n\r\nAfter experimenting with leaving the divider up and getting feedback from teams, the board has decided that it is better to leave it down to minimize balls coming on to other courts. The rule regarding the divider is that the play is dead if the ball touches the divider. A player attempting to play the ball may attempt to move the divider in order to make the play, but no one else may.\r\n',1,'2016-01-29 15:21:21',9),
  (380,'Winter 2016 Playoffs','Winter 2016 Playoffs\r\n<ul>\r\n<li><b>Women&#39;s A1</b> Spike Heels</li>\r\n<li><b>Women&#39;s A2</b> Fantastic Six </li>\r\n<li><b>Women&#39;s B</b> Floor Burn</li>\r\n<li><b>Women&#39;s BB</b> Chickaboom</li>\r\n<li><b>Women&#39;s AA</b> Hot Spicy Ballz </li>\r\n<li><b>Women&#39;s A</b> Sneaker Wave</li>\r\n<li><b>Coed A</b> Down and Dirty Diggers </li>\r\n<li><b>Coed B1</b> 2 Legit 2 Hit </li>\r\n<li><b>Coed B2</b> East of Eden  </li>\r\n<li><b>Coed C</b> Mudsharks </li>\r\n<li><b>Coed A Thursday</b> PVA All-Stars</li>\r\n<li><b>Coed B Thursday</b> Net 2.0  </li>\r\n\r\n</ul>',1,'2016-04-01 07:03:31',9),
  (382,'Spring 2016 Playoffs','Spring 2016 Playoffs\r\n<ul>\r\n<li><b>Women&#39;s A1</b> Volley Parton</li>\r\n<li><b>Women&#39;s A2</b> Balls </li>\r\n<li><b>Women&#39;s B</b> Floor Burn</li>\r\n<li><b>Women&#39;s BB</b> Youve Been Served </li>\r\n<li><b>Women&#39;s AA</b> Will Work for Sets</li>\r\n<li><b>Women&#39;s A</b> Sneaker Wave </li>\r\n<li><b>Coed A</b> Business Time </li>\r\n<li><b>Coed B1</b> Yo Diggity Dog  </li>\r\n<li><b>Coed B2</b> Spiked Punch W </li>\r\n<li><b>Coed C</b> Balls Deep</li>\r\n<li><b>Coed A Thursday</b> Off on the Court</li>\r\n<li><b>Coed B Thursday</b> Empire Spikes Back </li>\r\n\r\n</ul>',1,'2016-07-14 22:58:37',9),
  (383,'Summer Volleyball Schedules','I&#39;m posting the Summer schedules, please keep checking back for more updates.  If there is question of rain the day you play for GRASS leagues ONLY, please check the website/Facebook after 4:30 PM.  Sand leagues play rain or shine!  Thanks!',1,'2016-06-16 14:03:30',9),
  (384,'Summer Playoffs','Summer 2016 Playoffs\r\n<ul>\r\n<li><b>Women&#39;s A1</b> 8/22 Brentwood Grass 6:30 & 7:30 PM</li>\r\n<li><b>Women&#39;s A2</b>8/22 Brentwood Grass 6:30 & 7:30 PM </li>\r\n<li><b>Women&#39;s B</b>8/22 Brentwood Grass 6:30 & 7:30 PM</li>\r\n<li><b>Grass Coed A</b> Grassias!</li>\r\n<li><b>Grass Coed B</b> Grasshoppers</li>\r\n<li><b>Sand Quads</b> 8/17 Brentwood Sand 6:30 & 7:30 PM</li>\r\n\r\n</ul>',1,'2016-08-17 08:32:17',9);

/*!40000 ALTER TABLE `home_page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table leagues
# ------------------------------------------------------------

DROP TABLE IF EXISTS `leagues`;

CREATE TABLE `leagues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `cap` tinyint(4) NOT NULL DEFAULT '8',
  `night` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `leagues` WRITE;
/*!40000 ALTER TABLE `leagues` DISABLE KEYS */;

INSERT INTO `leagues` (`id`, `name`, `active`, `cap`, `night`)
VALUES
  (19,'Womens A Tuesday',1,8,'Tuesday'),
  (20,'Womens A2 Monday',1,6,'Monday'),
  (102,'Coed Grass Quads A',1,8,'Tuesday'),
  (24,'Coed B 1 Wednesday',1,6,'Wednesday'),
  (25,'Coed C Wednesday',1,8,'Wednesday'),
  (119,'Womens A2 Grass 4s',0,8,''),
  (108,'Coed B Thursday',1,6,'Thursday'),
  (88,'Womens A1 Monday',1,6,'Monday'),
  (107,'Coed A Thursday Doubleheaders',1,8,'Thursday'),
  (114,'Womens AA Tuesday',1,8,'Tuesday'),
  (78,'Coed A Wednesday',1,8,'Wednesday'),
  (82,'Womens BB Monday',1,6,'Monday'),
  (113,'Sand Quads',1,8,'Wednesday'),
  (96,'Womens B Grass 4s',1,8,'Monday'),
  (106,'Womens A Grass 4s',1,8,'Monday'),
  (118,'Womens A1 Grass 4s',0,8,''),
  (110,'Womens B Monday',1,6,'Monday'),
  (120,'Coed B 2 Wednesday',1,6,'Wednesday'),
  (117,'Coed Grass Quads B',1,8,'Tuesday'),
  (121,'Women\'s A1 Grass 4s',1,6,'Monday'),
  (122,'Women\'s A2 Grass 4s',1,6,'Monday');

/*!40000 ALTER TABLE `leagues` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table linkage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `linkage`;

CREATE TABLE `linkage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(200) NOT NULL DEFAULT '',
  `linktext` varchar(55) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `linkage` WRITE;
/*!40000 ALTER TABLE `linkage` DISABLE KEYS */;

INSERT INTO `linkage` (`id`, `link`, `linktext`, `description`)
VALUES
  (11,'http://www.eastbay.com','Eastbay.com','Looking for a good price on a Tachikara volleyball?  This company has the SV-5W gold for $39.99 + shipping.  This is the lowest price I can find on the web.\r\n'),
  (14,'http://www.pacnova.com/','Pacnova.com','Looking for outdoor volleyball information?  This is the place for leagues, tournaments and pro events.'),
  (23,'http://www.columbiaempirevolleyball.com/','Columbia Empire Volleyball Association','They offer tournaments and adult leagues.  They also have youth programs.'),
  (25,'http://www.oregonamateursports.org/','State Games of Oregon','Outdoor grass tournament at Brentwood Park. Grass reverse quads is on Sunday, July 14.');

/*!40000 ALTER TABLE `linkage` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table logos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logos`;

CREATE TABLE `logos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `filename` varchar(55) NOT NULL DEFAULT '',
  `comments` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `logos` WRITE;
/*!40000 ALTER TABLE `logos` DISABLE KEYS */;

INSERT INTO `logos` (`id`, `name`, `filename`, `comments`)
VALUES
  (1,'Roland Lee','roland_lee.gif',''),
  (2,'Sarah Bagley','sarah_bagley.gif',''),
  (3,'Mark Black','mark_black.gif',''),
  (4,'Kao Vue','kao_vue.jpg',''),
  (5,'Angela Brummett','angela_brummett.jpg',''),
  (6,'Janwyn Toy','janwyn_toy_1.jpg',''),
  (7,'Janwyn Toy','janwyn_toy_2.jpg',''),
  (8,'Janwyn Toy','janwyn_toy_3.jpg',''),
  (9,'Adam Sirkin','adam_sirkin.jpg','');

/*!40000 ALTER TABLE `logos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table logovotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `logovotes`;

CREATE TABLE `logovotes` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `ip` varchar(55) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table refs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `refs`;

CREATE TABLE `refs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(40) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `fname` varchar(40) NOT NULL DEFAULT '',
  `lname` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uname` (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `refs` WRITE;
/*!40000 ALTER TABLE `refs` DISABLE KEYS */;

INSERT INTO `refs` (`id`, `uname`, `password`, `fname`, `lname`)
VALUES
  (8,'waylon','Password1','Waylon','Dalton'),
  (9,'dan','Password1','Justine','Henderson'),
  (12,'abdullah','Password1','Abdullah','Lang'),
  (13,'marcus','Password1','Marcus','Cruz'),
  (15,'thalia','Password1','Thalia','Cobb'),
  (16,'mathias','Password1','Mathias','Little'),
  (17,'eddie','Password1','Eddie','Randolph'),
  (18,'angela','Password1','Angela','Walker'),
  (43,'marc','Password1','Marc','Nolan'),
  (21,'adriel','Password1','Adriel','Osborne'),
  (55,'avah','Password1','Avah','Sandell'),
  (44,'sterling','Password1','Sterling','Lyons'),
  (36,'rafael','Password1','Rafael','Gibbs'),
  (56,'jadiel','Password1','Jadiel','Austin'),
  (41,'janessa','Password1','Janessa','Lawson'),
  (57,'laurel','Password1','Laurel','Nash'),
  (54,'jordan','Password1','Jordan','Roach'),
  (46,'damari','Password1','Damari','Cole'),
  (51,'eric','Password1','Eric ','Edwards');

/*!40000 ALTER TABLE `refs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table registration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registration`;

CREATE TABLE `registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamName` varchar(100) NOT NULL DEFAULT '',
  `mgrName` varchar(55) NOT NULL DEFAULT '',
  `mgrPhone` varchar(20) NOT NULL DEFAULT '',
  `mgrPhone2` varchar(20) DEFAULT NULL,
  `mgrEmail` varchar(55) NOT NULL DEFAULT '',
  `mgrEmail2` varchar(55) DEFAULT NULL,
  `altName` varchar(55) DEFAULT NULL,
  `altPhone` varchar(20) DEFAULT NULL,
  `altPhone2` varchar(20) DEFAULT NULL,
  `altEmail` varchar(55) DEFAULT NULL,
  `league` smallint(6) NOT NULL DEFAULT '0',
  `league2` smallint(6) DEFAULT NULL,
  `league_old` varchar(20) NOT NULL DEFAULT '',
  `addr1` varchar(55) NOT NULL DEFAULT '',
  `addr2` varchar(55) DEFAULT NULL,
  `city` varchar(55) NOT NULL DEFAULT '',
  `state` char(2) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `comments` mediumtext,
  `night` varchar(25) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `newOld` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;

INSERT INTO `registration` (`id`, `teamName`, `mgrName`, `mgrPhone`, `mgrPhone2`, `mgrEmail`, `mgrEmail2`, `altName`, `altPhone`, `altPhone2`, `altEmail`, `league`, `league2`, `league_old`, `addr1`, `addr2`, `city`, `state`, `zip`, `comments`, `night`, `paid`, `newOld`)
VALUES
  (3699,'Down and Dirty Diggers','Chris Whytock','2068981652','','cwhytock@gmail.com','ertigger@cox.net','','','','',107,107,'','1910 NE Knott St','','Portland','OR','97212','Our team manager was and will remain Erin Bellignham, I just don\'t have her information handy for signup',NULL,0,'Returning team'),
  (3700,'Court Jesters','David Rueck','5037303631','','drueck@gmail.com','drueck@gmail.com','','','','',107,107,'','9462 SE Harney Ct','','Portland','OR','97266','',NULL,0,'Returning team'),
  (3701,'The bald and the beautiful','Meghan Mulkey ','5034909202','','Meghanmulkey@gmail.com','','','','','',107,78,'','8646 SW 9th ave','','Portland ','OR','97219','',NULL,0,'New team'),
  (3702,'Whatever','Ronda Johnson','5037503120','5037503120','Rbjcats@comcast.net','','Carrie Putsch','','5032679195','Carrie.putsch@gmail.com',107,107,'','16511 Carnegie Ave','','Lake Oswego','OR','97035','I\'ll pay at board meeting',NULL,0,'Returning team'),
  (3703,'Floor Burn','Kristie Hopkins','503-737-9943','','coachkristie10@gmail.com','','','','','',20,110,'','2926 SE 71st Ave','','Portland','OR','97206','I think A2 is the next level up from B? If not, we would like to go up a level. ',NULL,0,'Returning team'),
  (3704,'Lollipop Girls','Ronda Johnson','5037503120','5036757469','rbjcats@comcast.net','','Carrie Putsch','5032679195','','c.putsch@gmail.com',19,114,'','16511 Carnegie Ave.','','Lake Oswego','OR','97035','We are going to try A this season.',NULL,0,'Returning team'),
  (3705,'Red Hots','Genevieve Leineweber','5033674162','','gleineweb@gmail.com','','','','','',88,20,'','3451 SE Ankeny St','','Portland','OR','97214','Same manager, same team name',NULL,0,'Returning team'),
  (3706,'Healthy Hits','Marie Benedetti','503.830.7213','','marie.benedetti@vigor.net','','','','','',82,88,'','4604 SE 45th Ave','','Portland','OR','97206','Will mail check',NULL,0,'Returning team'),
  (3707,'Net 2.0','Josh Bremer','720-635-1035','720-635-1032','joshua.bremer@gmail.com','','Gloria Bremer','','303-819-6027','gloria.s.bremer@gmail.com',108,108,'','3204 NE 62nd Ave','','Portland','OR','97213','',NULL,0,'Returning team'),
  (3708,'Spiked Punch','Jordan Giboney','5035026160','','jordangiboney@gmail.com','','','','','',114,114,'','132 NE 44th Ave','','Portland ','OR','97213','Returning team for women\'s AA league on tuesday nights.',NULL,0,'Returning team'),
  (3709,'Dig This!','Sheri Bauer','503-504-2765','','Sherilhancock@gmail.com','','','','','',88,20,'','10608 NW Tudor Lane','','Portland','OR','97229','',NULL,0,'Returning team'),
  (3710,'Motorboat','Stephanie Nass','5037548639','5037548639','VB05racer17@comcast.net','stephanie.gross17@gmail.com','Sarah Slaughter','5734247566','','seslaugh@alumni.unca.edu',88,107,'','580 SE 2nd Ave.','','Canby','OR','97013','Played as Motorboat for all of the 2015-2016 season. :)',NULL,0,'Returning team'),
  (3711,'Nip Lash','Mindy Montgomery','5033073719','','mindy@cianmontgomery.com','','','','','',19,19,'','9538 NW Roseway Ave','','Portland','OR','97231','',NULL,0,'Returning team'),
  (3712,'The Guidettes','Teri Jones','503-819-5542','503-819-5542','wascowoman@gmail.com','littlebighorn2010@gmail.com','Sabrina Jones','','','sbjones333@gmail.com',82,110,'','19338 Silverfox Pkwy','','Oregon City','OR','97045-7264','',NULL,0,'New team'),
  (3713,'High Fives','Jackie Ostroff','8162690392','','jackieostroff@gmail.com','','','','','',24,120,'','8730 N Foss Ave','','Portland','OR','97203','Previous manager was Hayley Purdy who is taking the season off. ',NULL,0,'Returning team'),
  (3714,'A & L Bombers','Brenda Fleming-Wilkes','503 780-5607','','brendafleming44@hotmail.com','','Terry Wilkes','','503 421-6122','terwilkes10@hotmail.com',25,25,'','2045 SE 130th Ave','','Portland','OR','97233','',NULL,0,'Returning team'),
  (3715,'Booya','Samantha Kocher','(971) 221-5624','','samantha.kocher@comcast.net','samantha.kocher@comcast.net','','','','',24,120,'','1390 Beverly Drive','','Gladstone','Or','97027','Skittles',NULL,0,'New team'),
  (3716,'Spike heels','Anna bar','5032602368','','Annabarmd@me.com','','','','','',88,20,'','636 SE Andover pl','','Portland','Or','97202','',NULL,0,'Returning team'),
  (3717,'Serv-ivors','Brandi bazurto','360-253-6533','360-253-6533','Bbazurto@gmail.com','','','','','',82,82,'','15815 NE 43rd way','','Vancouver','Wa','98682','',NULL,0,'Returning team'),
  (3718,'You\'ve Been Served','Rachel Cummings','406-207-4815','','rachel.cummings@mossadams.com','','','','','',88,20,'','9394 SW Fast Pl','','Tigard','OR','97223','',NULL,0,'Returning team'),
  (3719,'You\'ve Been Served','Rachel Cummings','4062074815','','rachel.cummings@mossadams.com','','','','','',107,107,'','9394 SW Fast Pl','','Tigard','OR','97223','',NULL,0,'Returning team'),
  (3720,'Kiss My Pass','Chavienne Gruber / Crystal Steinmueller','6122375965','','chavienne@gmail.com','chavienne@gmail.com','','','csteiny10@aol.com','',110,82,'','2207 NE 9th Ave','','Portland','OR','97212-4009','Hi, we would prefer to be in Tuesday B, but it wasn\'t an option in the drop down? Is it full? Also, I am signing the team up because Crystal is out of the country. She mentioned we have a credit due to our team from last fall. Could you tell me how much we owe after the credit is applied and the I will send payment. Thank you!',NULL,0,'Returning team'),
  (3721,'Mavens','Laurie Rule','503-679-7691','503-760-3477','lrule@advocateswest.org','orrule@comcast.net','Ami Opal','503-548-8353','','doctorami@yewmedicine.com',114,19,'','7326 SE 27th Ave','','Portland','OR','97202','',NULL,0,'Returning team'),
  (3722,'Dirty Half Dozen','Dave Stainsby','503-655-6004 ext 191','503-970-9997','dstainsby@benchmade.com','','Brooke Walker','503-496-1852','503-317-5224','bwalker@benchmade.com',25,25,'','300 Beavercreek Rd','','Oregon City','OR','97045','',NULL,0,'Returning team'),
  (3723,'Gangta Pair\'a Dice','Rachel Cummings','4062074815','','rachel.cummings@mossadams.com','','','','','',24,120,'','9394 SW Fast Pl','','Tigard','OR','97223','',NULL,0,'Returning team'),
  (3724,'PVA All-Stars','Shawn Busse','541-941-9920','','shawn@kinesisinc.com','','','','','',107,107,'','5936 NE Mason St.','','Portland','OR','97218','',NULL,0,'Returning team'),
  (3725,'Gangsta Pair\'a Dice','Rachel Cummings','4062074815','','rachel.cummings@mossadams.com','','','','','',24,120,'','9394 SW Fast Pl','','Tigard','OR','97223','',NULL,0,'Returning team'),
  (3726,'Over the net','Jill brown','5033475843','','Bbbrownjam@aol.com','Jbrown@nwceilinglifts.com','','','','',82,107,'','18389 s Norman rd ','','Oregon city ','Or','','',NULL,0,'Returning team'),
  (3727,'Panda Panda Panda','Cincy Lee','6147832545','6147832545','chlee316@gmail.com','chlee316@gmail.com','','','','',19,114,'','603 SE 46th Ave','','Portland','OR','97215','Pandas and Giraffes and Set for Life',NULL,0,'Returning team'),
  (3728,'Vertically Challenged','Packy Flynn','360-773-5785','','padraic_flynn@hotmail.com','','Jim Dewson','','','jdewson@gmail.com',25,25,'','15402 NE 47th Circle','','Vancouver','WA','98682','',NULL,0,'New team'),
  (3729,'Volley Llamas','Jeff Correa','503-539-6872','','Jeffcorrea21@gmail.com','','Stacy Vonderahe ','503-547-4331','','',108,107,'','12473 SE Bari Ave ','','Happy Valley','OR','97086','',NULL,0,'Returning team'),
  (3730,'Empire Spikes Back','Eric Anderson','8015579792','','Ike4life14@yahoo.com','','','','','',108,108,'','17175 SW Meinecke Rd','','Sherwood','OR','97140','',NULL,0,'Returning team'),
  (3731,'Spiked Punch','Gina Bjorvik','5033318543','5033318543','gembjorvik@yahoo.com','','','','','',24,120,'','3042 NE 24th Avenue','','Portland','OR','97212','',NULL,0,'Returning team'),
  (3732,'Vital Force','Hilary Sandell','6307818851','','hilary.sandell@gmail.com','','','','','',88,20,'','1517 SE Haig St','','Portland ','OR','97202','same name, same manager! ',NULL,0,'Returning team'),
  (3733,'Balls','Melanie Althaus','503-708-6194','','Mcalthaus@gmail.com','Lazocc@yahoo.com','','','','',20,88,'','3745 Sw Water Ave ','Apt 302','Portland','Or','97239','',NULL,0,'Returning team'),
  (3734,'Balls','Melanie Althaus','503-708-6194','','Mcalthaus@gmail.com','Lazocc@yahoo.com','','','','',20,88,'','3745 Sw Water Ave ','Apt 302','Portland','Or','97239','',NULL,0,'Returning team'),
  (3735,'East of Eden','John Charles','503-459-3727','','john@cascadepolicy.org','','','','','',24,120,'','4850 SW Scholls Ferry, Suite 103','','Portland','OR','97225','',NULL,0,'Returning team'),
  (3736,'Falcons','Sylvia Peterson-Perry','5034905503','','sylvia.petersonperry@gmail.com','','','','','',108,25,'','2749 SE 33rd Pl','','Portland','OR','97202','We played Sand Quads this summer but are new to the indoor leagues.',NULL,0,'New team'),
  (3737,'Becky\'s All-Star Jazz Hands Reviews','Jim Lieblick','5033138817','','jim.lieblick@gmail.com','jim.lieblick@gmail.com','','','','',120,78,'','11955 Southwest Blakeney Street','','Beaverton','OR','97008','',NULL,0,'Returning team'),
  (3738,'LADYBALLS ','Mari Paulus','503-502-9340','','maripaulus@comcast.net','','','','','',46,39,'','636 SE 49th','','Portland','OR','97215','','',0,'Returning team'),
  (3739,'The Good Mod','Brenda Miller','503 206-6919','503 367-7300','Brenda@thegoodmod.com','hello@thegoodmod.com','Spencer Staley','503 206-6919','503 317-7009','Spencer@thegoodmod.com',25,120,'','1313 W Burnside, 4th Floor','','Portland','OR','97209','',NULL,0,'New team');

/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table registration_leagues
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registration_leagues`;

CREATE TABLE `registration_leagues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `night` varchar(9) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `registration_leagues` WRITE;
/*!40000 ALTER TABLE `registration_leagues` DISABLE KEYS */;

INSERT INTO `registration_leagues` (`id`, `name`, `night`, `active`)
VALUES
  (4,'Coed B','Thursday',1),
  (10,'Women\'s B','Monday',1),
  (14,'Women\'s BB','Monday',1),
  (15,'Women\'s 4\'s grass A','Monday',0),
  (16,'Reverse coed 4\'s grass A','Tuesday',1),
  (18,'Sand Quads','Wednesday',0),
  (19,'Coed 6\'s sand','Thursday',0),
  (20,'Reverse coed doubles grass','Thursday',0),
  (45,'Women\'s A2 Grass 4\'s','Monday',0),
  (24,'Women\'s A','Wednesday',0),
  (25,'Women\'s 4\'s grass B','Monday',0),
  (26,'Reverse coed 4\'s grass B','Tuesday',0),
  (44,'Coed C','Wednesday',1),
  (46,'Women\'s A1','Monday',1),
  (43,'Coed B','Wednesday',1),
  (31,'Women\'s A1 Grass 4\'s','Monday',0),
  (47,'Women\'s A2','Monday',1),
  (37,'Women\'s A','Tuesday',1),
  (42,'Women\'s AA','Tuesday',1),
  (39,'Coed A','Wednesday',1),
  (40,'Coed A Doubleheaders','Thursday',1);

/*!40000 ALTER TABLE `registration_leagues` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table registration_leagues2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registration_leagues2`;

CREATE TABLE `registration_leagues2` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `night` varchar(9) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `registration_leagues2` WRITE;
/*!40000 ALTER TABLE `registration_leagues2` DISABLE KEYS */;

INSERT INTO `registration_leagues2` (`id`, `name`, `night`, `active`)
VALUES
  (1,'Coed A','Wednesday',1),
  (2,'Coed A West','Thursday',1),
  (3,'Coed B','Wednesday',1),
  (4,'Coed B','Thursday',1),
  (5,'Coed C','Wednesday',1),
  (6,'Coed C','Thursday',1),
  (7,'Coed D','Wednesday',1),
  (8,'Women\'s AA','Tuesday',1),
  (9,'Women\'s A','Tuesday',1),
  (10,'Women\'s B','Monday',1),
  (11,'Women\'s C','Monday',1),
  (12,'Men\'s A','Tuesday',1),
  (13,'Men\'s B','Tuesday',1),
  (14,'Women\'s BB','Monday',1),
  (15,'Women\'s 4\'s grass A','Monday',0),
  (16,'Reverse coed 4\'s grass A','Tuesday',0),
  (17,'Coed 6\'s grass','Wednesday',0),
  (18,'Coed 4\'s sand','Wednesday',0),
  (19,'Coed 6\'s sand','Thursday',0),
  (20,'Reverse coed doubles grass','Thursday',0),
  (21,'Women\'s C','Tuesday',0),
  (22,'Coed C2','Thursday',0),
  (23,'Coed C2','Wednesday',0),
  (24,'Women\'s A','Monday',1),
  (25,'Women\'s 4\'s grass B','Monday',0),
  (26,'Reverse coed 4\'s grass B','Tuesday',0),
  (32,'Reverse coed 4\'s indoor','Wednesday',0),
  (27,'Women\'s A-E','Tuesday',0),
  (28,'Women\'s A-W','Tuesday',0),
  (33,'Coed 6\'s indoor','Thursday',0),
  (29,'Coed 40/45','Wednesday',0),
  (30,'Women\'s A','Tuesday',0),
  (31,'Women\'s B','Tuesday',1),
  (34,'Coed A East','Thursday',1);

/*!40000 ALTER TABLE `registration_leagues2` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table registration2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `registration2`;

CREATE TABLE `registration2` (
  `id` int(11) NOT NULL,
  `teamName` varchar(100) NOT NULL DEFAULT '',
  `mgrName` varchar(55) NOT NULL DEFAULT '',
  `mgrPhone` varchar(20) NOT NULL DEFAULT '',
  `mgrPhone2` varchar(20) DEFAULT NULL,
  `mgrEmail` varchar(55) NOT NULL DEFAULT '',
  `mgrEmail2` varchar(55) DEFAULT NULL,
  `altName` varchar(55) DEFAULT NULL,
  `altPhone` varchar(20) DEFAULT NULL,
  `altPhone2` varchar(20) DEFAULT NULL,
  `altEmail` varchar(55) DEFAULT NULL,
  `league` smallint(6) NOT NULL DEFAULT '0',
  `league2` smallint(6) DEFAULT NULL,
  `league_old` varchar(20) NOT NULL DEFAULT '',
  `addr1` varchar(55) NOT NULL DEFAULT '',
  `addr2` varchar(55) DEFAULT NULL,
  `city` varchar(55) NOT NULL DEFAULT '',
  `state` char(2) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `comments` mediumtext,
  `night` varchar(25) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `registration2` WRITE;
/*!40000 ALTER TABLE `registration2` DISABLE KEYS */;

INSERT INTO `registration2` (`id`, `teamName`, `mgrName`, `mgrPhone`, `mgrPhone2`, `mgrEmail`, `mgrEmail2`, `altName`, `altPhone`, `altPhone2`, `altEmail`, `league`, `league2`, `league_old`, `addr1`, `addr2`, `city`, `state`, `zip`, `comments`, `night`, `paid`)
VALUES
  (2195,'Healthy Hits','Chihiro Aber','503 481 3335','','chihiro14@hotmail.com','','','','','',10,0,'','2110 Alpine Dr','','West Linn','OR','97068','','',1),
  (2196,'A & L Bombers','Brenda Fleming-Wilkes','503 421-6122','503 257-1068','bfleming@ronorthert.com','brendafleming44@hotmail.com','Terry Wilkes','','','',7,0,'','2045 SE 130th Ave','','Portland','OR','97233-1417','I would like to register a team for fall - Co-ed on Wednesdays \"D\" League','',1),
  (2197,'Floor Burn','Kristie Janssen','503-737-9943','','kristie@injurylaworegon.com','','','','','',10,14,'','2926 SE 71st Ave','','PORTLAND','OR','97206','We will be sending in the full amount ($400) on Monday August 15th. ','',1),
  (2198,'Game On','Jill Emmert-Tricarico','5033070142','5033070142','jillemmerttricarico@gmail.com','drkrista@openmindmedicine.com','Krista Emmert-Tricarico','','','',9,24,'','1743 NE Junior St','','Portland','OR','97211','','',1),
  (2200,'Flying Pie','Rick TIpton','503-721-6472','503-281-7567','tipton28@comcast.net','tipton28@comcast.net','','503-704-3614','503-704-3614','Rick.L.Tipton@kp.org',1,3,'','3520 NE US Grant Place','','Portland','OR','97212','','',1),
  (2201,'Set for Life','Cincy Lee','614-783-2545','','chlee316@gmail.com','','','','','',8,9,'','603 SE 46th Ave','','Portland','OR','97215','','',1),
  (2202,'Too Setsy','Krista Patchin','360-601-8154','','mkpatchin@hotmail.com','','','','','',24,14,'','17403 NE Cole Witter Rd.','','Battle Ground','WA','98604','','',1),
  (2203,'Dinks & Drinks','Susan Wold','503.452.3668','503.936.7551','susanwold@hotmail.com','swold@heery.com','Erin Danielson','503.313.4100 ','','etdanielson@comcast.net',14,24,'','10135 SW 50th ','','Portland','OR','97219','','',1),
  (2204,'Ditry Sets','Natalie Dickinson','503-780-1100','','nattled@hotmail.com','','','','','',24,8,'','730 NW 20th Ave. #101','','Portland','OR','97209','','',1),
  (2205,'I\'d Hit That','Melissa OBrien','503-753-6683','','melobrien75@hotmail.com','','','','','',14,10,'','5403 NE 26th Avenue','','Portland','OR','97211','','',1),
  (2206,'Net Gain','Cathy Merz','5037152220','5034754942','catherinemerz@aol.com','cathy.merz@donnamcarlson.com','Sheri Bauer','5035042765','5037473360','',8,9,'','5607 SW Westdale Dr','','Portland','OR','97221','Would like to remian in same league as Badgers','',1),
  (2207,'Floor Play','Jason Pavelka','503-810-0588','','easytosendcards@yahoo.com','easytosendcards@yahoo.com','Sam Cheek','817-564-6922','','trojansam@gmail.com',6,4,'','PO Box 68326','','Portland','OR','97268','','',1),
  (2208,'Whatever','Jeff Putsch','503-267-5480','','jdputsch@comcast.net','jdputsch@comcast.net','Carrie Putsch','','503-267-9195','carrie@cnj.homeip.net',34,0,'','2686 NE 6th Place ','','Portland','OR','97212','','',1),
  (2209,'Lollipop Girls','Ronda Johnson','503-750-3120','503-675-7469','Rbjcats@comcast.net','','Carrie Putsch','503-267-9195','','carrie@cnj.homeip.net',8,9,'','16511 SW Carnegie Ave','','Lake Oswego','OR','97035','I\'ll get the check in the mail','',1),
  (2210,'Volley Llamas','Jeff Correa','503-539-6872','','jeffcorrea21@gmail.cm','jcorrea@usapears.com','','','','',6,6,'','196 SE Spokane St.','#207','Portland','OR','97202','Because of other commitments, this is the only day that we can play.  Thanks!','',1),
  (2211,'MY BAD','MARTY DAVIS','503-453-7432','','MARTYDOG3@COMCAST.NET','','','','','',34,0,'','3325 NE 43RD AVE','','PORTLAND','OR','97213','','',1),
  (2212,'Mintonettes','Kate Brundage','585-329-0818','','kathleen_brundage@yahoo.com','kathleen.brundage@va.gov','','','','',10,0,'','3825 N Longview Ave','','portland','','97227','','',1),
  (2213,'Served Hot','Kristen Ashurex','9715339463','','kristen.ashurex@gmail.com','','Maren Schultz','','','m.zielonyschultz@gmail.com',14,10,'','28910 SW Ravenna Loop','Apt 302','Wilsonville','OR','97070','','',1),
  (2214,'One Hit Wonders','Kristen Ashurex','9715339463','','kristen.ashurex@gmail.com','','Kristin Palmer','','','kristin.palmer@ymail.com',31,9,'','28910 SW Ravenna Loop','Apt 302','Wilsonville','OR','','','',1),
  (2215,'Mavens','Laurie Rule','503 679-7691','503 760-3477','lrule@advocateswest.org','orrule@comcast.net','Jenni Peters','','858 395-5023','jethomson13@hotmail.com',8,9,'','7326 SE 27th Ave','','Portland','OR','97202','','',1),
  (2216,'The Meatballs','Sarah Hollingsworth','503-449-3287','Same','shollingsworth@woodburnsd.org','saritabear@hotmail.com','Jeff Berard','','503-704-0592','jeff.berard@comcast.net',4,0,'','725 E. Hereford St.','','Gladstone','Or','97027','I\'ve been playing Women\'s AA on Tuesdays for years but am new to Coed. I assume it is six players, not four, correct?','',1),
  (2217,'Dig This','Scott Rosenthal','503-922-9564','503-922-9564','scottr128@yahoo.com','','Liz Shatzer','503-758-5659','503-758-5659','e_shatzer@yahoo.com',2,34,'','2201 NE 58th Ave','','Portland','OR','97213','If there are going to be 2 Thurs night A leagues we would like to play in the \"weaker\" of the 2 divisions.  Not sure if that is east or west.','',1),
  (2218,'All Together Now','Shannon Van Horn','503-866-8012','','shandale_1972@hotmail.com','shandale_1972@hotmail.com','Stefanie Linch','5035458914','','shandale_1972@hotmail.com',9,0,'','10920 NE Hancock Street','','Portland','OR','97220','','',1),
  (2219,'Over the Net','Debbie Whitehead','503-913-5684','503-252-7815','debbiew_17@msn.com','debbiew@multnomah.edu','Lynne Piazza','503-504-7170','','',14,24,'','8432 NE Broadway','','Portland','OR','97220','','',1),
  (2220,'On the Floor','Carrie Maxwell','503-285-1643','971-563-0516','cmaxwell_1972@hotmail.com','carriefayemax_9722q.com','Shannon Van Horn','503-866-8012','503-866-8012','shandale_1972@hotmail.com',24,10,'','7059 N. Borthwick Avenue','','Portland','OR','97217-1615','If there is anyway to play at Central Catholic (have a freshman there this year) and could help with set up and clean-up.','',1),
  (2221,'Diggin\' It','Suzy Minne','503-723-7026','503-723-7026','suzyminne@q.com','danminne@live.com','','','','',6,4,'','17311 Holly Ln','','Oregon City','OR','97045','We all live in the Oregon City area, so if there is a chance to keep our games on this end of Portland that would be GREAT!! :)  Thanks!','',1),
  (2222,'PVA All Stars','Shawn Busse','541-941-9920','','shawn@kinesisinc.com','','','','','',34,2,'','5936 NE Mason St.','','Portland','OR','97218','Hi Michelle,\r\n\r\nI\'ve assembled a new team (Formerly \'Kinesis\'). It\'s definitely an \"A\" league team (all very experienced/competitive players). I\'m assuming that COED A - East is the league with the best teams. If this is the wrong league, please contact me.\r\n\r\nThanks!\r\nShawn','',1),
  (2223,'Serve-ivors','Kim Blahnik','360-513-3105','','kimmieb7@yahoo.com','','','','','',14,9,'','3204 SE 196th Ave','','Camas','WA','98607','','',1),
  (2224,'Mo Diggity','Jessica Bruce','206-718-0108','','JessicaLynneBruce@gmail.com','brucejl@comcast.net','Tyler Gassaway','','503-807-1828','tjgassaw@yahoo.com',1,34,'','1010 Netzel St. ','','Oregon City','OR','97045','','',1),
  (2225,'SPIKERS','Fred Wallis','503-329-1737','','fsbholly@aol.com','','','','503-238-1916','',6,0,'','1530.S.E. Holly ST.','','Portland','OR','97214','','',1),
  (2226,'Block Heads','Hannah May','541-231-6090','','hannahrosemay@gmail.com','hannah_may@ziba.com','','','','',34,2,'','6912 N Armour Street','','Portland','OR','97203','What is the difference between East and West? We would like the league that plays mostly around the downtown area (Southwest comm center, st johns, Milwaukee). I don\'t remember what we were in the Spring...','',1),
  (2227,'Dahlias','Carolyn Garnett','5038805397','','cgarnett00@yahoo.com','','Val Jones','3602417786','','',24,9,'','3505 Fairview Way','','West Linn','OR','97068','','',1),
  (2228,'Passing Fancy','Emily Gabler','503 756-8630','','Gabler@OHSU.edu','','Stephanie BleckmanN','503 998-7938','','Stephanie.bleckmann@nike.com',24,0,'','3403 NE 13th Ave.','','Portland','Or','97212','Michelle,\r\nOur team won our B league championship last spring. We would like to play Women\'s A league this fall. We were supposed to be given an opportunity to move up a level last season but due to last minute schedule','',1),
  (2234,'Spiked Punch','Mike Otis','503.781.3638','','cptnsandbr@aol.com','','','','','',3,5,'','51737 SE 9th St','','Scappoose','OR','97056','I believe we are a low B or high C coed team','',1),
  (2235,'Dig It','Lindsey Phelps','503-218-2526','208-250-6920','lindseyphelps24@yahoo.com','lphelps@crkt.com','Annie Klug','503-310-4512','503-310-4512','annieklug@gmail.com',9,8,'','8900 SW Sweek Dr. #926','','Tualatin','OR','97062','Please apply the summer credit to our fall fees. Thank you!','',1),
  (2236,'Vertically Challenged','Packy Flynn','360-773-5785','','padraic_flynn@hotmail.com','flynnpac@parkrose.k12.or.us','Jim Dewson','','503-236-8392','jdewson@gmail.com',5,0,'','15402 NE 47th Circle','','Vancouver','WA','98682','','',1),
  (2230,'Hop Heads','Gary Rule','503-230-5424','503-760-3477','orrule@comcast.net','gary.rule@noaa.gov','Laurie Rule','503-914-6388','','lrule@advocateswest.org',34,2,'','7326 SE 27th Avenue','','Portland','OR','97202','I don\'t remember if we were in Coed A West or East last time. Not sure what the difference is but we are an A-level team and want to play the best teams.','',1),
  (2231,'Six Shots','Stefanie Reel','503-522-9579','','reelstef@gmail.com','','','','','',14,24,'','9001 NW Skyline blvd.','','Portland','OR','','','',1),
  (2232,'Notorious D.I.G.','Chris Whytock','2068981652','','cwhytock@gmail.com','cwhytock@gmail.com','','','','',34,2,'','325 NE Graham St #12','','Portland','OR','97212','','',1),
  (2233,'Fed Up','Tara Watanathai','443-226-8452','','alohatara@gmail.com','','Jim Malloy','503-552-5243','503-358-8596','jtmalloy13@gmail.com',6,4,'','C/O FBI','1500 SW 1st Avenue, Suite 400','Portland','OR','97201','','',1),
  (2237,'Block of Seagulls','Jen Braun','503 231 3625','503 333 4289','jenbraunrocks@yahoo.com','','','503 231 5050','','',5,0,'','18025 se Stephens St','','Portland','or','97233','','',1),
  (2238,'One Track Mind','Adrienne Nicoll','3603340310','3603340310','tallpeople@me.com','adriennenicoll@gmail.com','','','','',8,24,'','2304 NW 209th St.','','Ridgefield','WA','98642','','',1),
  (2239,'Mudsharks','Cindy Keegan','503-282-7087','','c.keegan@comcast.net','','','','','',5,0,'','1715NE 49th','','Portland','OR','97213','','',1),
  (2240,'Air Dink','Yuen Chin','503-254-9359','','ebeanie529@aol.com','','','','','',7,0,'','14520 NE Shaver','','Portland','OR','97230','','',1),
  (2241,'Yes Yes','Paul Crenna','503-969-7736','','paulcrenna@comcast.net','pcrenna@geopacificeng.com','','','','',4,0,'','12021 Orchard Hill Way','','Lake Oswego','OR','97035','','',1),
  (2242,'Dig HITS','Mike Merz','503 423 9459','503 897 6848','mike.merz@cigna.com','','','','','',3,0,'','5607 sw westdale dr','','port','or','97221','We want to continue in the same league we have played in for a dozen years, thanks, Mike','',1),
  (2243,'Bumpin Ugly','Ingrid Jensen','(503) 797-5824','','ingrid.jensen@fredmeyer.com','','Jaime Kraushaar','','503-310-9289','jaime.kraushaar@gmail.com',10,10,'','12844 SW Boones Ferry Rd','','Lake Oswego ','OR','97035','','',1),
  (2244,'Fish Sticks','Shannon Wolcott','503-816-6594','','shannon.wolcott@gmail.com','','Marci Gibson','503-984-1831','','marcigibson_cnt@yahoo.com',9,24,'','13555 SW Salal Ct','','Beaverton','OR','97008','','',1),
  (2245,'WildCatheters','Jerome Susi','9715335521','','jsusi@linfield.edu','','Lindsey Chow','','5034598045','lichow@linfield.edu',6,4,'','2215 NW Northrup Ave','92A','Portland','OR','97210','','',1),
  (2247,'Spirits Willing','John Chapman','503-657-8288','503-475-6210','John.p.chapman@kcc.com','','John Rawlins','503-866-6855','503-245-3742','John.rawlins@igrafx.com',4,0,'','7768 SE Clackamas Rd.','','Milwaukie','OR','97267','If Coed B Thursday is not open, need to discuss next option. Thanks.','',1),
  (2248,'The Rickrollers','Derek Musashe','407-927-2746','','dmusashe@gmail.com','','Caitlin Corcoran','','805-689-8580','caitydid57@gmail.com',1,0,'','0610 SW Nevada St','Apt C','Portland','OR','97219','','',1),
  (2249,'Cupcakin\' It','Gloria Garcia ','5036192156','','Glogarcia05@yahoo.com','','','','','',31,11,'','7607 N Fessenden','','Portland','Or','97203','','',1),
  (2250,'Ace to the Face','Whitney Stevens','541-517-4231','541-517-4231','info@blissstudio.net','alynn21@aol.com','Dawn Schott','541-954-3250','503-563-5212','dawnrick1@comcast.net',11,10,'','10903 SW 55th Ave','','Portland','OR','97219','','',1),
  (2251,'Kiss Our Aces','Molly Hendler ','4156094995','4156094995','mollyrhendler@gmail.com','mollyrhendler@gmail.com','Kaitlin Ogilvie','(209) 380-5260','(209) 380-5260','Kaitlinogilvie@gmail.com',9,31,'','4263 SE Belmlont #301','','Portland','OR','97215','','',1),
  (2252,'Black Sunshine','Sheryl Dopps','5039985619','Same','dopps6@gmail.com','','Laurie Ramos','','3602815845','leibchenwa@yahoo.com',10,14,'','4129 SE 162nd CT','','Vancouver, WA','wa','98683','','',1),
  (2253,'Block Party','Heidie Massie','(971) 645-3972','(503) 663-1100','bhmassie55@hotmail.com','heidie@bamboorivermarketing.com','Brian Massie','(503) 312-7689','(503) 663-1100','brian@massiehd.com',7,5,'','5672 SE Chase Loop','','Gresham','OR','97080','All women have played volleyball in high school but that was 20 years ago!  So it has been a long time but most of us are good with the basics.  Thinking D would be a good league to start and maybe bump up to C if needed or possible?  Thanks!','',1),
  (2254,'Net2O','Tom Jones','503-245-3117','','tbmsjones@comcast.net','','','','','',4,6,'','4911 SW Iowa Street','','Portland','OR','97221','','',1),
  (2255,'Slippery When Set','Michael Weaver','5038967321','5038967321','michael@portlandplayhouse.org','mikeweaver78@gmail.com','','5038967321','5038967321','michael@portlandplayhouse.org',3,0,'','4307 N. Commercial Ave.','','Portland','OR','97217','','',1),
  (2256,'Beer and Fries','Stan Tamiyasu','503 647 5041','','stamiyasu@msn.com','','','503 332 3819','','',2,34,'','27365 NW Dorland Rd','','North Plains','OR','97133','','',1),
  (2257,'Baby Got Backset','Karen Gorretta','360-713-0765','360-546-0348','kgorretta@clearaccess.com','','Teri Calcagno','','','tcalcagno@centralcatholichigh.org',10,14,'','2401 NW 115th St','','Vancouver','WA','98685','','',1),
  (2258,'You\'ve Been Served','Paula Dunham','503-750-6807','same','psjohnson2354@hotmail.com','','Sarah Hovdey','','406-370-0490','shovdey@gmail.com',24,24,'','2613 NE 59th Ave.','','Portland','OR','97213','I am unable to attend the manager\'s meeting on August 17 but have been playing in the league for many years.','',1),
  (2259,'Set it sister, spike it!','Mindy Montgomery','5033890523','','mindy@mindyx.com','','','','','',31,10,'','9538 NW Roseway ','','Portland','OR','97231','','',1),
  (2260,'Diggin Dirty','Corinne Lazo','5038697470','','lazocc@yahoo.com','','5037086194','','','',14,0,'','1639 SE Knapp Street','','Portland','Or','97206','','',1),
  (2261,'The Average Jills','Lindsey Minnema','616-308-7023','','lminnema@gmail.com','','','','','',14,0,'','925 NW Hoyt St. #101','','Portland','OR','97209','','',1),
  (2262,'Brown Chicken Brown Cow','Bob Schatz','503 235-8585','503 260-7286','bob@allusaarchitecture.com','','','','','',3,0,'','2118 SE Division street','','Portland','OR','97202','','',1),
  (2263,'Way Out','Christine Cvitanich','971 678-9505','503-775-9714','chriscvitanich@hotmail.com','ccvitani@mesd.k12.or.us','Mattye Dahl','503-808-6412','503-952-6125','chriscvitanich@hotmail.com',9,24,'','3735 SE Lambert St','','Portland','OR','97202','','',1),
  (2264,'Wilson\'s Worst Nightmare','Ed Anderson','971-221-7523','971-221-7523','ed.anderson@nwea.org','eanderson74@gmail.com','Eddie Martinez','','503-961-2733','eddie.martinez@nwea.org',7,5,'','8639 SW Iroquois Dr','','Tualatin','OR','97062','','',1),
  (2265,'Crush','Christin Bryk','503.209.1275','503.267.4558','bryk9c@yahoo.com','christinb@landscapeeast.com','Dana Lockhart','503.867.1329','','',9,8,'','7206 N Kerby Ave.','','Portland ','OR','97217','I put the check in the mail this evening.  Hope Tuesday\'s aren\'t full yet.  Thanks:)','',1),
  (2266,'Smokin\' Aces','Kelsey Prenger','971-506-1858','503-283-4601','kprenger@hotmail.com','','','503-968-7939','','',11,10,'','1542 N Wygant St','','Portland','or','97217','','',1),
  (2267,'Phelps Pham','Rachel Phelps','503-349-2799','','Rachelandsteveforever@gmail.com','','Lyle  Phelps','971-570-0930','','lylecil@hotmail.com',4,0,'','12706 SE 110th ct.','','Clackamas','OR','97015',' ','',1),
  (2268,'Angry Birds','Nicole Nelson','971-242-9524','971-242-9524','volleynik1@yahoo.com','','Brandyce Nelson','503-704-5343','503-704-5343','brandx1983@hotmail.com',31,9,'','6242 SE 29th Way','','Gresham','OR','97080','','',1),
  (2269,'Red Hots','Jill Hertel','503-804-9300','503-804-9300','hertelj@juno.com','jhertel@fgsd.k12.or.us','Joanna DePeralta','503-797-9848','503-475-8917','joanna.deperalta@trailblazers.com',8,0,'','1388 SE 70th Avenue','','Hillsboro','OR','97123','','',1),
  (2270,'I\'D HIT THAT','Stacy Towell','503-708-6724','','stacytowell@gmail.com','','','','','',24,9,'','10548 NE Davis','','Portland','OR','97220','','',1),
  (2271,'Orville Ready Blockers','Jeff Correa','503-539-6872','','Jeffcorrea21@gmail.com','Jcorrea@usapears.com','','','','',13,13,'','196 SE Spokane St. #207','','Portland','OR','97202','','',1),
  (2272,'Top Gun','Mark Giesmann','503-568-6862','','mgiesmann@hntb.com','mgoose27@yahoo.com','','503-205-4150','','',2,34,'','12120 SW McKay Ct','','Beaverton','OR','97008','','',1),
  (2273,'Joy of Sets','Kelly Clifton','443.622.1266','','kelly.j.clifton@gmail.com','','Kristi Currans','','','curransk@gmail.com ',31,31,'','1431 SW Park Ave. #610','','Portland','OR','97201','','',1),
  (2274,'Flugtag','Bill Fussell','503.381.0699','','william_fussell@yahoo.com','','','','','',4,0,'','22737 W Bluff Ct','','West Linn','OR','','','',1),
  (2275,'Fuse','Steve Erickson','503.307.4086','','steve_erickson@comcast.net','','','503.797.1595','','',3,4,'','1415 NE 17th Av','','Portland','OR','97232','Sorry about the late registration.  Emailed the team 2 weeks ago and 3 people responded today.   Ugggghhhh.. Thanks for your patience.','',1),
  (2276,'Grumpy Old Men','Mike Vixie','503-225-5476','503-287-1977','mevixie@earthlink.net','michael.vixie@regence.com','','','','',13,31,'','1411 NE 47th Ave','','Portland','OR','97213','','',1),
  (2277,'beta blockers','terri hoos','503 309 9895','503 234 8098','mikanter@comcast.net','teresa.hoos@va.gov','Anna Brones','253 651 2020','','anna.brones@gmail.com',10,31,'','6005 SE 20th Ave','','Portland','or','97202','','',1),
  (2278,'A & J Awesome Team, Great Job!','Amanda Grassman','503-347-2773','','grassman.a@gmail.com','grass1719@gmail.com','','','','',1,0,'','13020 SW 17th Street','','Beaverton','OR','97008','','',1),
  (2279,'East of Eden','John Charles','503/242-0900','503-459-3727','john@cascadepolicy.org','','','','','',13,12,'','4850 SW Scholls Ferry, #103','','Portland','OR','97225','','',1),
  (2280,'Belmar Beach','John Charles','503/242-0900','503-459-3727','john@cascadepolicy.org','','','','','',2,0,'','4850 SW Scholls Ferry, #103','','Portland','OR','97225','I think this was our league last Spring; it was a good, competitive league for us.','',1),
  (2281,'Off the Wall','Larry Kiggans','503 758-7573','503 558-9107','lkiggans@indepak.com','otalways@aol.com','Rick Bennett','','503 266-3376','spokesandstitches@yahoo.com',6,4,'','15330 SE Anderson Rd','','Damascus','OR','97089','check is in the mail','',1),
  (2282,'Scared Hitless','Jennifer Ford','503-860-6481','','jzea33@hotmail.com','','','','','',8,9,'','13774 SE 115th Ave','','Clackamas','OR','97015','Would like to continue to play in the Women\'s top league.  Thank you.','',1),
  (2283,'Blue Sky','Roland Chadburn','503-880-9510','','rolandchadburn@comcast.net','','Cathy Merz','503-475-4942','','',1,2,'','7265 SW 76th Avenue','','Portland','OR','97223','','',1),
  (2284,'Trend setters','Melissa Yi','5037506572','','jayoungyi@yahoo.com','jayoungyi@gmail.com','','','','',8,8,'','941 NW Naito Parkway #116','','Portland','Or','97209','','',1),
  (2285,'Kinetics','Joyce Schwer','503-658-5354','503-869-1851','jptk_schwer@msn.com','','','','','',5,6,'','15960 SE Bel Air Dr.','','Damascus','OR','97089','','',1),
  (2286,'Benchmade Knife Company','Jason Bills','503 655 6004','','jlbills@benchmade.com','','Kathy Delaplain','503 655 6004','','',7,0,'','300 Beavercreek Rd','','Oregon City','OR','','','',1),
  (2287,'Beer \'n Tots ','Karen Dutton','503.816.0735','','karendutton16@gmail.com','','Stephanie Williams','stephaniewilliams201','503.784.0468','',9,0,'','1515 SE 22nd Ave #7','','Portland','OR','97214','','',1),
  (2289,'Kiss My Pass','Leah Ray','360','','leahray.od@gmail.com','','','','','',31,0,'','1','','Battleground','WA','98630','I picked up a check from her today in BG.','',1),
  (2290,'Lovely Lady Bumps','Lani Farnworth','503-703-9493','','lani@lanifarnworth.com','','Denise Ransome','denise@52ltd.com','','',31,0,'','4557 NE 33rd AVE','','Portland','OR','97211','','',1);

/*!40000 ALTER TABLE `registration2` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table team_members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `team_members`;

CREATE TABLE `team_members` (
  `teamid` int(11) NOT NULL DEFAULT '0',
  `firstName` varchar(50) NOT NULL DEFAULT '',
  `lastName` varchar(50) NOT NULL DEFAULT '',
  `addedBy` varchar(255) NOT NULL DEFAULT '',
  `dateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shirtSize` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table team_members2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `team_members2`;

CREATE TABLE `team_members2` (
  `teamid` int(11) NOT NULL DEFAULT '0',
  `firstName` varchar(50) NOT NULL DEFAULT '',
  `lastName` varchar(50) NOT NULL DEFAULT '',
  `addedBy` varchar(255) NOT NULL DEFAULT '',
  `dateAdded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shirtSize` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table teams
# ------------------------------------------------------------

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `league` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;

INSERT INTO `teams` (`id`, `name`, `league`)
VALUES
  (1511,'Eggs & Sausage',113),
  (1499,'Grassias!',102),
  (1510,'Down & Dirty Diggers',113),
  (410,'Lollipop Girls',106),
  (1507,'Grasshoppers',117),
  (457,'BYE',0),
  (1523,'Mavens',121),
  (1486,'Bumping Ballers',106),
  (1504,'Whatever 4',102),
  (1505,'Becky\'s All-Star Jazz Hands Review',117),
  (1506,'East of Eden',117),
  (1503,'Volleybrawlers',102),
  (1496,'Other Team',96),
  (1500,'Hop Heads',102),
  (1378,'Smack That Pass',106),
  (1508,'iSpike',117),
  (1509,'2 Legit 2 Hit SAND',113),
  (1521,'Shin-Digs A1',121),
  (1517,'Balls',106),
  (1529,'Smack That Pass',122),
  (1530,'Quad Squad',122),
  (1531,'Takillias',122),
  (1532,'Grassyass',122),
  (1501,'PVA All Stars',102),
  (1512,'Mr. Team',113),
  (1520,'Shin-Digs',106),
  (1498,'Grass Happy',102),
  (1502,'Rhombus',102),
  (1513,'Sets on the Sand',113),
  (1514,'Snob Nob',113),
  (1515,'Woop Woop',113),
  (1516,'Falcons',113),
  (1487,'The Empire Spikes Back',106),
  (1488,'Grassyass',106),
  (1489,'Mavens',106),
  (1490,'Quad Squad',106),
  (1491,'Queen Bees',106),
  (1518,'Dig This',106),
  (1519,'Fluorescent Balls',102),
  (1524,'Bumping Ballers',121),
  (1525,'Balls',122),
  (1526,'Lollipop Girls',121),
  (1527,'The Empire Spikes Back A1',121),
  (1528,'Dig This A2',122),
  (1302,'Playoffs',0),
  (1522,'Queen Bees',121),
  (1492,'Fembots',96),
  (1493,'Takillas',106),
  (1494,'Grass Stain',96),
  (1495,'Healthy Hits',96);

/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vars
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vars`;

CREATE TABLE `vars` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `vars` WRITE;
/*!40000 ALTER TABLE `vars` DISABLE KEYS */;

INSERT INTO `vars` (`name`, `value`)
VALUES
  ('reg_fee','500'),
  ('reg_latefee','25'),
  ('reg_deadline','8/25/2116'),
  ('reg_latedeadline','9/5/2116'),
  ('reg_season','Fall, 2116'),
  ('reg_payPalFee','14.80'),
  ('reg_isSummer','0'),
  ('reg_doublesFee','70'),
  ('reg_sandFee','175');

/*!40000 ALTER TABLE `vars` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

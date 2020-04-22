# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: singing-contest
# Generation Time: 2020-04-22 09:26:54 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table contest_contestants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contest_contestants`;

CREATE TABLE `contest_contestants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `contest_score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_contest_contest_contestants_contest_id` (`contest_id`),
  KEY `fk_contest_contest_contestants_contestant_id` (`contestant_id`),
  CONSTRAINT `fk_contest_contest_contestants_contest_id` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  CONSTRAINT `fk_contest_contest_contestants_contestant_id` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table contest_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contest_history`;

CREATE TABLE `contest_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL,
  `contestant_id` int(11) NOT NULL,
  `contest_score` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_contest_contest_history_contest_id` (`contest_id`),
  KEY `fk_contest_contest_history_contestant_id` (`contestant_id`),
  CONSTRAINT `fk_contest_contest_history_contest_id` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  CONSTRAINT `fk_contest_contest_history_contestant_id` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table contest_judges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contest_judges`;

CREATE TABLE `contest_judges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) DEFAULT NULL,
  `judge_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contest_contest_judges_contest_id` (`contest_id`),
  KEY `fk_judges_contest_judges_contest_id` (`judge_id`),
  CONSTRAINT `fk_contest_contest_judges_contest_id` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  CONSTRAINT `fk_judges_contest_judges_contest_id` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table contestants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contestants`;

CREATE TABLE `contestants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table contestants_genre_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contestants_genre_info`;

CREATE TABLE `contestants_genre_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contestant_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contestants_contestants_genre_info_contest_id` (`contestant_id`),
  KEY `fk_genre_contestants_genre_info_genre_id` (`genre_id`),
  CONSTRAINT `fk_contestants_contestants_genre_info_contest_id` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`),
  CONSTRAINT `fk_genre_contestants_genre_info_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table contests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contests`;

CREATE TABLE `contests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completion_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contests` WRITE;
/*!40000 ALTER TABLE `contests` DISABLE KEYS */;

INSERT INTO `contests` (`id`, `date_created`, `completion_status`)
VALUES
	(163,'2020-04-22 09:34:14',1),
	(164,'2020-04-22 09:34:18',1),
	(165,'2020-04-22 09:34:21',1),
	(166,'2020-04-22 09:34:23',1),
	(167,'2020-04-22 09:34:26',1),
	(168,'2020-04-22 09:34:31',1),
	(169,'2020-04-22 09:48:44',1),
	(170,'2020-04-22 10:21:11',0);

/*!40000 ALTER TABLE `contests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table genre
# ------------------------------------------------------------

DROP TABLE IF EXISTS `genre`;

CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;

INSERT INTO `genre` (`id`, `genre`)
VALUES
	(1,'Rock'),
	(2,'Country'),
	(3,'Pop'),
	(4,'Disco'),
	(5,'Jazz'),
	(6,'The Blues');

/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table judges
# ------------------------------------------------------------

DROP TABLE IF EXISTS `judges`;

CREATE TABLE `judges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judge_type` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `judges` WRITE;
/*!40000 ALTER TABLE `judges` DISABLE KEYS */;

INSERT INTO `judges` (`id`, `judge_type`)
VALUES
	(1,'random'),
	(2,'honest'),
	(3,'mean'),
	(4,'rock'),
	(5,'friendly');

/*!40000 ALTER TABLE `judges` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table performances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `performances`;

CREATE TABLE `performances` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contestant_id` int(11) DEFAULT NULL,
  `round_id` int(11) DEFAULT NULL,
  `score` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contestants_performances_contestant_id` (`contestant_id`),
  CONSTRAINT `fk_contestants_performances_contestant_id` FOREIGN KEY (`contestant_id`) REFERENCES `contestants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table rounds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rounds`;

CREATE TABLE `rounds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `completion_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

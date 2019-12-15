-- MySQL dump 10.17  Distrib 10.3.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: book-jack
-- ------------------------------------------------------
-- Server version	10.3.18-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(45) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comic`
--

DROP TABLE IF EXISTS `comic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comic` (
  `comic_id` varchar(45) NOT NULL,
  `comic_title` varchar(45) NOT NULL,
  `comic_saga` varchar(45) NOT NULL,
  `comic_start_date` datetime NOT NULL,
  `comid_end_data` datetime NOT NULL,
  `comic_editor` varchar(45) NOT NULL,
  `comic_image_url` varchar(200) DEFAULT NULL,
  `comic_volume` int(11) DEFAULT NULL,
  `comic_synopsis` text NOT NULL,
  PRIMARY KEY (`comic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comic_has_author`
--

DROP TABLE IF EXISTS `comic_has_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comic_has_author` (
  `comic_comic_id` varchar(45) NOT NULL,
  `author_author_id` int(11) NOT NULL,
  PRIMARY KEY (`comic_comic_id`,`author_author_id`),
  KEY `fk_comic_has_author_author1_idx` (`author_author_id`),
  KEY `fk_comic_has_author_comic_idx` (`comic_comic_id`),
  CONSTRAINT `fk_comic_has_author_author1` FOREIGN KEY (`author_author_id`) REFERENCES `author` (`author_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comic_has_author_comic` FOREIGN KEY (`comic_comic_id`) REFERENCES `comic` (`comic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manga`
--

DROP TABLE IF EXISTS `manga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manga` (
  `manga_id` varchar(45) NOT NULL,
  `manga_title` varchar(45) NOT NULL,
  `manga_status` varchar(45) NOT NULL,
  `manga_iamge_url` varchar(200) DEFAULT NULL,
  `manga_volumes` int(11) DEFAULT NULL,
  `manga_chapters` int(11) DEFAULT NULL,
  `manga_start_date` datetime NOT NULL,
  `manga_end_date` datetime NOT NULL,
  `manga_synopsis` text NOT NULL,
  PRIMARY KEY (`manga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manga_genre`
--

DROP TABLE IF EXISTS `manga_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manga_genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(45) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manga_has_author`
--

DROP TABLE IF EXISTS `manga_has_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manga_has_author` (
  `manga_manga_id` varchar(45) NOT NULL,
  `author_author_id` int(11) NOT NULL,
  PRIMARY KEY (`manga_manga_id`,`author_author_id`),
  KEY `fk_manga_has_author_author1_idx` (`author_author_id`),
  KEY `fk_manga_has_author_manga1_idx` (`manga_manga_id`),
  CONSTRAINT `fk_manga_has_author_author1` FOREIGN KEY (`author_author_id`) REFERENCES `author` (`author_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_manga_has_author_manga1` FOREIGN KEY (`manga_manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manga_has_genre`
--

DROP TABLE IF EXISTS `manga_has_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manga_has_genre` (
  `manga_manga_id` varchar(45) NOT NULL,
  `genre_genre_id` int(11) NOT NULL,
  PRIMARY KEY (`manga_manga_id`,`genre_genre_id`),
  KEY `fk_manga_has_genre_genre1_idx` (`genre_genre_id`),
  KEY `fk_manga_has_genre_manga1_idx` (`manga_manga_id`),
  CONSTRAINT `fk_manga_has_genre_genre1` FOREIGN KEY (`genre_genre_id`) REFERENCES `manga_genre` (`genre_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_manga_has_genre_manga1` FOREIGN KEY (`manga_manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novel`
--

DROP TABLE IF EXISTS `novel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novel` (
  `novel_id` varchar(45) NOT NULL,
  `novel_title` varchar(45) NOT NULL,
  `novel_editor` varchar(45) NOT NULL,
  `novel_synopsis` text NOT NULL,
  `novel_pages` int(11) NOT NULL,
  `novel_image_url` varchar(200) NOT NULL,
  `novel_publication_date` datetime NOT NULL,
  PRIMARY KEY (`novel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novel_genre`
--

DROP TABLE IF EXISTS `novel_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novel_genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(45) NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novel_has_author`
--

DROP TABLE IF EXISTS `novel_has_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novel_has_author` (
  `novel_novel_id` varchar(45) NOT NULL,
  `author_author_id` int(11) NOT NULL,
  PRIMARY KEY (`novel_novel_id`,`author_author_id`),
  KEY `fk_novel_has_author_author1_idx` (`author_author_id`),
  KEY `fk_novel_has_author_novel1_idx` (`novel_novel_id`),
  CONSTRAINT `fk_novel_has_author_author1` FOREIGN KEY (`author_author_id`) REFERENCES `author` (`author_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_novel_has_author_novel1` FOREIGN KEY (`novel_novel_id`) REFERENCES `novel` (`novel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novel_has_novel_genre`
--

DROP TABLE IF EXISTS `novel_has_novel_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novel_has_novel_genre` (
  `novel_novel_id` varchar(45) NOT NULL,
  `novel_genre_genre_id` int(11) NOT NULL,
  PRIMARY KEY (`novel_novel_id`,`novel_genre_genre_id`),
  KEY `fk_novel_has_novel_genre_novel_genre1_idx` (`novel_genre_genre_id`),
  KEY `fk_novel_has_novel_genre_novel1_idx` (`novel_novel_id`),
  CONSTRAINT `fk_novel_has_novel_genre_novel1` FOREIGN KEY (`novel_novel_id`) REFERENCES `novel` (`novel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_novel_has_novel_genre_novel_genre1` FOREIGN KEY (`novel_genre_genre_id`) REFERENCES `novel_genre` (`genre_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `table1`
--

DROP TABLE IF EXISTS `table1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table1` (
  `user_user_id` int(11) NOT NULL,
  `manga_manga_id` varchar(45) NOT NULL,
  `comic_comic_id` varchar(45) NOT NULL,
  `novel_novel_id` varchar(45) NOT NULL,
  KEY `fk_table1_user1_idx` (`user_user_id`),
  KEY `fk_table1_manga1_idx` (`manga_manga_id`),
  KEY `fk_table1_comic1_idx` (`comic_comic_id`),
  KEY `fk_table1_novel1_idx` (`novel_novel_id`),
  CONSTRAINT `fk_table1_comic1` FOREIGN KEY (`comic_comic_id`) REFERENCES `comic` (`comic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_manga1` FOREIGN KEY (`manga_manga_id`) REFERENCES `manga` (`manga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_novel1` FOREIGN KEY (`novel_novel_id`) REFERENCES `novel` (`novel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `user_nickname` varchar(45) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_salt` varchar(64) NOT NULL,
  `user_profil_picture` longblob DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-15 20:52:29

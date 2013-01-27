-- MySQL dump 10.13  Distrib 5.1.44, for apple-darwin10.2.0 (i386)
--
-- Host: localhost    Database: apmgr
-- ------------------------------------------------------
-- Server version	5.1.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `rentalQuestions`
--

DROP TABLE IF EXISTS `rentalQuestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rentalQuestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(30) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Questions for the rental application form regarding how did ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rentalQuestions`
--

LOCK TABLES `rentalQuestions` WRITE;
/*!40000 ALTER TABLE `rentalQuestions` DISABLE KEYS */;
INSERT INTO `rentalQuestions` (`id`, `question`, `dateCreated`, `dateUpdated`) VALUES (1,'whereyourefered','2010-06-23 22:30:50','2010-06-23 22:30:50'),(2,'didYouFindUs','2010-06-23 22:32:00',NULL);
/*!40000 ALTER TABLE `rentalQuestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rentalAnswers`
--

DROP TABLE IF EXISTS `rentalAnswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rentalAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` text NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Answers for the rental application how did you find us table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rentalAnswers`
--

LOCK TABLES `rentalAnswers` WRITE;
/*!40000 ALTER TABLE `rentalAnswers` DISABLE KEYS */;
INSERT INTO `rentalAnswers` (`id`, `answer`, `dateCreated`, `dateUpdated`) VALUES (1,'yes','2010-06-23 22:34:14',NULL),(2,'no','2010-06-23 22:34:14',NULL),(3,'internetSite','2010-06-23 22:34:14',NULL),(4,'stoppedBy','2010-06-23 22:34:35',NULL),(5,'newsPaper','2010-06-23 22:45:21',NULL),(6,'rentalPublication','2010-06-23 22:45:41',NULL),(7,'other','2010-06-23 22:45:51',NULL);
/*!40000 ALTER TABLE `rentalAnswers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-06-23 23:08:56

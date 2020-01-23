-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: openemr
-- ------------------------------------------------------
-- Server version	5.5.32

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
-- Table structure for table `form_textimporter_controls`
--
USE `openemr`;
DROP TABLE IF EXISTS `form_textimporter_controls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_textimporter_controls` (
  `textImporterControlId` int(11) NOT NULL DEFAULT '1',
  `textboxId` varchar(45) DEFAULT NULL,
  `pageName` varchar(45) DEFAULT NULL,
  `controlHeading` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`textImporterControlId`),
  UNIQUE KEY `idform_textimporter_controls_UNIQUE` (`textImporterControlId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_textimporter_controls`
--

LOCK TABLES `form_textimporter_controls` WRITE;
/*!40000 ALTER TABLE `form_textimporter_controls` DISABLE KEYS */;
INSERT INTO `form_textimporter_controls` VALUES (1,'thistextbox2','prognosis/view.html','single dropdownlist example'),(2,'textbox1','prognosis/view.html','second single dropdownlist example'),(3,'textbox3','prognosis/view.html','patients under provider id x, dependent second list example'),(4,'textbox4','prognosis/view.html','treament plans within 90 days, independent second list example'),(5,'problem_1','itp_cmh/new.php','Problem 1'),(6,'goal_1','itp_cmh/new.php','Goal 1');
/*!40000 ALTER TABLE `form_textimporter_controls` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-20 13:59:06

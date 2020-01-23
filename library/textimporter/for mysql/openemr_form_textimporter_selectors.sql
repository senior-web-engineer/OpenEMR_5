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
-- Table structure for table `form_textimporter_selectors`
--
USE `openemr`;
DROP TABLE IF EXISTS `form_textimporter_selectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_textimporter_selectors` (
  `textImporterSelectorId` int(11) NOT NULL DEFAULT '1',
  `textImporterControlId` int(11) NOT NULL DEFAULT '0',
  `selectorLabel` varchar(1000) DEFAULT NULL,
  `valueField` varchar(100) DEFAULT NULL,
  `dataField` varchar(100) DEFAULT NULL,
  `whereField` varchar(1000) DEFAULT NULL,
  `fromTable` varchar(1000) DEFAULT NULL,
  `sortOrder` int(11) DEFAULT '1',
  `control` varchar(20) DEFAULT 'dropdownlist',
  `rememberId` int(11) DEFAULT '0',
  `getParentId` int(11) DEFAULT '1',
  `setLimit` int(11) DEFAULT '25',
  `orderByField` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`textImporterSelectorId`),
  UNIQUE KEY `idform_textImporter_selectors_UNIQUE` (`textImporterSelectorId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_textimporter_selectors`
--

LOCK TABLES `form_textimporter_selectors` WRITE;
/*!40000 ALTER TABLE `form_textimporter_selectors` DISABLE KEYS */;
INSERT INTO `form_textimporter_selectors` VALUES (1,1,'indiv treat plan','id','problem_1',NULL,'openemr.form_individualized_treatment_plan_cmh',1,'dropdownlist',0,0,25,NULL),(2,2,'soap subjective','id','subjective',NULL,'openemr.form_soap_pirc',1,'dropdownlist',0,0,25,NULL),(3,3,'insurance co','id','name','freeb_type = %2$s','openemr.insurance_companies',1,'dropdownlist',0,0,25,NULL),(4,3,'subsc last name','id','subscriber_lname','provider = %1$s','openemr.insurance_data',2,'dropdownlist',0,1,25,NULL),(5,4,'get problem1','tp.id','tp.problem_1',' f.deleted = 0 and f.formdir = \'individualized_treatment_plan_cmh\' and f.pid = %2$s and datediff(curdate(),fe.date) <= 600 ','openemr.forms AS f inner join openemr.form_encounter AS fe on f.encounter = fe.encounter LEFT JOIN form_individualized_treatment_plan_cmh AS tp ON tp.id = f.form_id ',1,'singleselector',0,0,1,'fe.date desc'),(6,4,'problem2','tp.id','tp.problem_2',' f.deleted = 0 and f.formdir = \'individualized_treatment_plan_cmh\' and f.pid = %2$s and datediff(curdate(),fe.date) <= 600','openemr.forms AS f inner join openemr.form_encounter AS fe on f.encounter = fe.encounter LEFT JOIN form_individualized_treatment_plan_cmh AS tp ON tp.id = f.form_id ',2,'singleselector',0,0,1,'fe.date desc'),(7,4,'problem3','tp.id','tp.problem_3',' f.deleted = 0 and f.formdir = \'individualized_treatment_plan_cmh\' and f.pid = %2$s and datediff(curdate(),fe.date) <= 600','openemr.forms AS f inner join openemr.form_encounter AS fe on f.encounter = fe.encounter LEFT JOIN form_individualized_treatment_plan_cmh AS tp ON tp.id = f.form_id ',3,'singleselector',0,0,1,'fe.date desc'),(8,5,'Select Library','groupid','Description',NULL,'openemr.lib_problemgroup',1,'dropdownlist',1,0,25,NULL),(9,5,'Select Problem','problemnumber','Description','GroupID = %3$s','openemr.lib_problem ',2,'dropdownlist',0,1,NULL,NULL),(10,0,'Select Library','groupid','Description','GroupID = %3$s','openemr.lib_problemgroup',1,'dropdownlist',1,0,25,NULL),(11,6,'Select Prolbem','problemnumber','Description','GroupID = %3$s','openemr.lib_problem ',2,'dropdownlist',0,1,NULL,NULL),(12,6,'Select Goal','GoalNumber','Description','GroupID = %3$s and problemnumber = %1$s','openemr.lib_goal',3,'dropdownlist',0,1,25,NULL);
/*!40000 ALTER TABLE `form_textimporter_selectors` ENABLE KEYS */;
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

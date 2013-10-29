-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: fucher
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.04.2-log

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
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `idReceita` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `idMedida` int(11) NOT NULL,
  KEY `idReceita` (`idReceita`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`idReceita`) REFERENCES `produto` (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (44,1,3,4),(44,10,40,1),(44,200,4,5),(44,1,3,4),(44,10,4,1),(44,200,4,5),(56,1,3,4),(56,10,3,2),(60,20,40,2),(60,200,43,5);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;

--
-- Table structure for table `medida`
--

DROP TABLE IF EXISTS `medida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medida` (
  `_id` int(11) NOT NULL,
  `nome` varchar(15) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medida`
--

/*!40000 ALTER TABLE `medida` DISABLE KEYS */;
/*!40000 ALTER TABLE `medida` ENABLE KEYS */;

--
-- Table structure for table `modo`
--

DROP TABLE IF EXISTS `modo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modo` (
  `idReceita` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `descricao` text NOT NULL,
  KEY `idReceita` (`idReceita`),
  CONSTRAINT `modo_ibfk_1` FOREIGN KEY (`idReceita`) REFERENCES `produto` (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modo`
--

/*!40000 ALTER TABLE `modo` DISABLE KEYS */;
INSERT INTO `modo` VALUES (44,1,'Esquentar a agua ate ferver.'),(44,2,'Colocar o ovo na Agua.'),(44,3,'Esperar 5 minutos.'),(56,1,'ferva'),(56,2,'cozinhe'),(56,3,'sirva'),(60,1,'Coloque em um copo.'),(60,2,'Misture.'),(60,3,'Beba.');
/*!40000 ALTER TABLE `modo` ENABLE KEYS */;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `descricao` text,
  `rate` float NOT NULL DEFAULT '0',
  `tipo` int(11) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`_id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (3,'Ovo de galinha','ovo branco',0,1,0,NULL),(4,'Agua','Agua',0,1,0,NULL),(37,'Farinha de trigo',NULL,0,1,NULL,NULL),(38,'Oleo',NULL,0,1,NULL,NULL),(39,'Fermento',NULL,0,1,NULL,NULL),(40,'Chocolate em po',NULL,0,1,NULL,NULL),(41,'Clara',NULL,0,1,NULL,NULL),(42,'Gema',NULL,0,1,NULL,NULL),(43,'Leite',NULL,0,1,NULL,NULL),(44,'prato do everton','',0,2,1,1),(56,'sobremesa','',3,2,2,2),(60,'nova receita','',0,2,3,1);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;

--
-- Table structure for table `receita`
--

DROP TABLE IF EXISTS `receita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receita` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `rate` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receita`
--

/*!40000 ALTER TABLE `receita` DISABLE KEYS */;
INSERT INTO `receita` VALUES (1,'Primeirã receita OnLine','Qualquer descrição serve.',3.5),(2,'Segunda receita online','',0);
/*!40000 ALTER TABLE `receita` ENABLE KEYS */;

--
-- Table structure for table `reg_user`
--

DROP TABLE IF EXISTS `reg_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reg_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reg_user`
--

/*!40000 ALTER TABLE `reg_user` DISABLE KEYS */;
INSERT INTO `reg_user` VALUES (1,'thur','Arthur','123');
/*!40000 ALTER TABLE `reg_user` ENABLE KEYS */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'thur','c338ce344c914d44429e8541e439b83a',''),(2,'everton','202cb962ac59075b964b07152d234b70','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

--
-- Dumping routines for database 'fucher'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-22  3:19:53

-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: sistem_inventory
-- ------------------------------------------------------
-- Server version 	5.7.34
-- Date: Fri, 03 Feb 2023 06:45:29 +0700

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
-- Table structure for table `coa`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ket` varchar(50) NOT NULL,
  `biaya` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coa`
--

LOCK TABLES `coa` WRITE;
/*!40000 ALTER TABLE `coa` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `coa` VALUES (1,'GELAR',260),(2,'CUTTING',300);
/*!40000 ALTER TABLE `coa` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `coa` with 2 row(s)
--

--
-- Table structure for table `colors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `color` (`color`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `colors` VALUES (63,'1 WHITE'),(60,'12 ROSE'),(61,'36 CARAMEL'),(57,'40 ALMOND'),(59,'52 MAUVE'),(62,'64 GREEN WOOD'),(56,'67 AQUA BLUE'),(58,'72 PLUM'),(54,'76 SAGE GREEN'),(55,'9 PEACH'),(51,'ABU'),(95,'ABU TUA'),(78,'ALMOND'),(69,'ANGGUR'),(36,'ARMY'),(76,'AVOCADO'),(154,'AVOCADO XL'),(38,'BATA'),(45,'BEIGE'),(73,'BISCUIT'),(70,'BLACK'),(79,'BROKEN WHITE'),(71,'BUTTER'),(94,'CLEAN WHITE'),(49,'COKLAT'),(42,'COKSU'),(107,'COPRA'),(96,'CREAM'),(112,'DARK SALMON'),(46,'DENIM'),(48,'DUSTY'),(74,'DUSTY PINK'),(64,'DUSTY ROSE'),(115,'FLAMINGO'),(67,'GREY'),(68,'HIJAU OLIVE'),(33,'HITAM'),(89,'HJ OLIVE'),(105,'HJ TKD'),(116,'HONEY'),(111,'IVORY'),(97,'KIWI'),(40,'KUBUS'),(81,'KUBUS GELAP'),(65,'LATTE'),(53,'LILAC'),(155,'LOVISH'),(34,'MAROON'),(152,'MAROON L'),(72,'MATCHA'),(50,'MILO'),(37,'MINT'),(44,'MOCCA'),(110,'MOSS'),(35,'NAVY'),(99,'NUDE'),(153,'NUDE M'),(43,'OCEAN'),(100,'ORCHID'),(82,'OXBLOOD'),(41,'PINK VARIO'),(47,'PURPLE'),(39,'SALMON'),(98,'SILVER'),(75,'TARO'),(52,'TWO TONE'),(101,'WALNUT'),(66,'WARDAH'),(151,'YELLOWFISH'),(113,'YELLOWISH');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `colors` with 70 row(s)
--

--
-- Table structure for table `cutting`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cutting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `model_id` int(11) DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qty` int(11) DEFAULT NULL,
  `berat` float DEFAULT NULL,
  `sisa` int(11) NOT NULL DEFAULT '0',
  `biaya_gelar1` int(11) DEFAULT NULL,
  `biaya_gelar2` int(11) DEFAULT NULL,
  `biaya_cutting` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `harga_gelar` int(11) DEFAULT '0',
  `harga_cutting` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `gelar1` int(11) DEFAULT NULL,
  `gelar2` int(11) DEFAULT NULL,
  `pic` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cutting`
--

LOCK TABLES `cutting` WRITE;
/*!40000 ALTER TABLE `cutting` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `cutting` VALUES (2,2,65,'2022-12-19 05:42:57',10,100,0,2600,2600,3000,8200,260,300,1,4,7,5),(3,3,78,'2022-12-19 05:49:20',2,50,0,520,520,600,1640,260,300,1,4,7,4),(13,4,73,'2022-12-20 05:54:44',5,50,0,1300,1300,1500,4100,260,300,1,3,5,4),(14,7,NULL,'2022-12-23 09:52:15',NULL,NULL,0,NULL,NULL,NULL,NULL,260,300,1,NULL,NULL,NULL),(15,2,NULL,'2022-12-23 09:52:32',NULL,NULL,0,NULL,NULL,NULL,NULL,260,300,1,NULL,NULL,NULL),(16,2,NULL,'2022-12-23 09:53:50',50,NULL,0,13000,13000,15000,41000,260,300,1,NULL,NULL,NULL),(17,2,NULL,'2022-12-26 04:43:47',NULL,NULL,0,NULL,NULL,NULL,NULL,260,300,1,NULL,NULL,NULL),(18,2,NULL,'2022-12-26 04:43:58',5,NULL,0,1300,1300,1500,4100,260,300,1,NULL,NULL,NULL),(19,12,69,'2022-12-26 04:46:56',10,NULL,0,2600,2600,3000,8200,260,300,1,3,7,2),(21,12,73,'2022-12-31 06:14:00',5,NULL,0,1300,1300,1500,4100,260,300,1,4,5,3);
/*!40000 ALTER TABLE `cutting` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `cutting` with 10 row(s)
--

--
-- Table structure for table `det_tim_gelar`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_tim_gelar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tim_gelar_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_tim_gelar`
--

LOCK TABLES `det_tim_gelar` WRITE;
/*!40000 ALTER TABLE `det_tim_gelar` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `det_tim_gelar` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `det_tim_gelar` with 0 row(s)
--

--
-- Table structure for table `gudang`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gudang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gudang` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gudang`
--

LOCK TABLES `gudang` WRITE;
/*!40000 ALTER TABLE `gudang` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `gudang` VALUES (1,'GESIT'),(2,'LOVISH');
/*!40000 ALTER TABLE `gudang` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `gudang` with 2 row(s)
--

--
-- Table structure for table `history_stok`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size` varchar(11) DEFAULT NULL,
  `jenis` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_stok`
--

LOCK TABLES `history_stok` WRITE;
/*!40000 ALTER TABLE `history_stok` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `history_stok` VALUES (1,78,113,'1','create',6,1,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(2,65,113,'1','create',9,1,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(3,65,113,NULL,'in',1,1,'2022-12-19 05:57:54','2022-12-19 05:57:54'),(4,65,113,NULL,'in',1,1,'2022-12-19 05:57:55','2022-12-19 05:57:55'),(5,65,113,NULL,'in',1,1,'2022-12-19 05:57:56','2022-12-19 05:57:56'),(6,65,113,NULL,'in',1,1,'2022-12-19 05:57:57','2022-12-19 05:57:57'),(7,65,113,NULL,'in',1,1,'2022-12-19 05:57:58','2022-12-19 05:57:58'),(8,65,113,NULL,'in',1,1,'2022-12-19 05:57:59','2022-12-19 05:57:59'),(9,65,113,NULL,'reject',1,1,'2022-12-19 05:59:40','2022-12-19 05:59:40'),(10,65,113,NULL,'reject',1,1,'2022-12-19 05:59:45','2022-12-19 05:59:45'),(11,65,113,NULL,'reject',1,1,'2022-12-19 05:59:50','2022-12-19 05:59:50'),(12,65,113,NULL,'reject',1,1,'2022-12-19 06:02:04','2022-12-19 06:02:04'),(13,65,151,NULL,'penjualan',1,1,'2022-12-19 06:59:52','2022-12-19 06:59:52'),(14,80,34,NULL,'penjualan',1,1,'2022-12-19 06:59:52','2022-12-19 06:59:52'),(15,86,46,NULL,'penjualan',1,1,'2022-12-19 06:59:52','2022-12-19 06:59:52'),(60,65,113,NULL,'pengiriman',1,1,'2022-12-19 07:23:31','2022-12-19 07:23:31'),(61,65,113,NULL,'pengiriman',1,1,'2022-12-19 07:23:33','2022-12-19 07:23:33'),(62,65,113,NULL,'retur',1,1,'2022-12-19 07:26:19','2022-12-19 07:26:19'),(63,65,113,NULL,'retur',1,1,'2022-12-19 07:26:19','2022-12-19 07:26:19'),(64,65,34,NULL,'reject',1,1,'2022-12-21 03:07:38','2022-12-21 03:07:38'),(65,65,34,NULL,'reject',1,1,'2022-12-21 03:18:47','2022-12-21 03:18:47'),(66,65,34,NULL,'reject',1,1,'2022-12-21 03:19:47','2022-12-21 03:19:47'),(67,65,34,NULL,'reject',1,1,'2022-12-21 03:21:55','2022-12-21 03:21:55'),(68,65,34,NULL,'reject',1,1,'2022-12-21 03:22:06','2022-12-21 03:22:06'),(69,65,34,NULL,'reject',1,1,'2022-12-21 03:22:38','2022-12-21 03:22:38'),(70,65,34,NULL,'reject',1,1,'2022-12-21 03:24:49','2022-12-21 03:24:49'),(71,65,34,NULL,'reject',1,1,'2022-12-21 03:28:37','2022-12-21 03:28:37'),(72,65,34,NULL,'reject',1,1,'2022-12-21 03:30:18','2022-12-21 03:30:18'),(73,65,34,NULL,'reject',1,1,'2022-12-21 03:32:25','2022-12-21 03:32:25'),(74,65,34,NULL,'reject',1,1,'2022-12-21 03:35:30','2022-12-21 03:35:30'),(75,65,34,NULL,'reject',1,1,'2022-12-21 03:40:04','2022-12-21 03:40:04'),(76,65,34,NULL,'reject',1,1,'2022-12-21 03:40:13','2022-12-21 03:40:13'),(77,65,34,NULL,'reject',1,1,'2022-12-21 03:43:58','2022-12-21 03:43:58'),(78,78,113,'1','create',6,1,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(79,78,113,NULL,'in',1,1,'2022-12-21 04:07:08','2022-12-21 04:07:08'),(80,69,107,'S','create',10,1,'2022-12-26 05:22:22','2022-12-26 05:22:22'),(81,69,107,'M','create',10,1,'2022-12-26 05:22:22','2022-12-26 05:22:22'),(82,69,107,'S','create',2,1,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(83,69,107,'M','create',2,1,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(84,69,107,'L','create',2,1,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(85,69,107,'XL','create',2,1,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(86,69,107,'XXL','create',2,1,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(111,65,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(112,65,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(113,65,151,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(114,69,107,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(115,78,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(116,80,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(117,86,46,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:13','2022-12-28 03:45:13'),(118,65,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(119,65,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(120,65,151,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(121,69,107,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(122,78,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(123,80,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(124,86,46,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:45:22','2022-12-28 03:45:22'),(125,65,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(126,65,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(127,65,151,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(128,69,107,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(129,78,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(130,80,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(131,86,46,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:46:04','2022-12-28 03:46:04'),(132,65,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(133,65,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(134,65,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(135,65,113,NULL,'sisa_pengiriman',6,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(136,65,113,NULL,'sisa_pengiriman',-2,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(137,65,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(138,65,113,NULL,'sisa_pengiriman',2,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(139,65,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(140,65,151,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(141,65,151,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(142,69,107,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(143,69,107,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(144,78,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(145,78,113,NULL,'sisa_pengiriman',1,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(146,78,113,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(147,80,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(148,80,34,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(149,86,46,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(150,86,46,NULL,'sisa_pengiriman',0,1,'2022-12-28 03:47:46','2022-12-28 03:47:46'),(151,65,34,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(152,65,34,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(153,65,113,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(154,65,113,NULL,'sisa_pengiriman',6,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(155,65,113,NULL,'sisa_pengiriman',-2,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(156,65,113,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(157,65,113,NULL,'sisa_pengiriman',2,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(158,65,113,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(159,65,151,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(160,65,151,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(161,69,107,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(162,69,107,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(163,78,113,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(164,78,113,NULL,'sisa_pengiriman',1,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(165,78,113,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(166,80,34,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(167,80,34,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(168,86,46,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(169,86,46,NULL,'sisa_pengiriman',0,0,'2022-12-28 03:48:42','2022-12-28 03:48:42'),(170,44,152,NULL,'penjualan',1,0,'2022-12-30 06:38:10','2022-12-30 06:38:10'),(171,44,153,NULL,'penjualan',1,0,'2022-12-30 06:38:10','2022-12-30 06:38:10'),(172,44,154,NULL,'penjualan',1,0,'2022-12-30 06:38:10','2022-12-30 06:38:10'),(173,73,107,NULL,'create',5,0,'2022-12-31 06:52:26','2022-12-31 06:52:26'),(174,73,107,NULL,'create',5,0,'2022-12-31 06:53:06','2022-12-31 06:53:06'),(175,73,107,NULL,'create',5,0,'2022-12-31 06:54:01','2022-12-31 06:54:01');
/*!40000 ALTER TABLE `history_stok` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `history_stok` with 107 row(s)
--

--
-- Table structure for table `jahit_vendors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jahit_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jahit_vendors`
--

LOCK TABLES `jahit_vendors` WRITE;
/*!40000 ALTER TABLE `jahit_vendors` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `jahit_vendors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `jahit_vendors` with 0 row(s)
--

--
-- Table structure for table `log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` text,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `media` varchar(50) NOT NULL DEFAULT 'BROWSER',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `log` with 0 row(s)
--

--
-- Table structure for table `logs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `logs` VALUES (1,'Menambahkan data kain baru (4 113) Sebanyak 10 roll',6,'2022-12-19 05:38:41'),(2,'Menghapus data kain (TYB YELLOWISH)',6,'2022-12-19 05:39:43'),(3,'Menambahkan produk baru (TOP SCRUNCHIE YELLOWISH) sebanyak 6. ',6,'2022-12-19 05:54:15'),(4,'Menambahkan produk baru (TOP SORAYA YELLOWISH) sebanyak 9. ',6,'2022-12-19 05:55:44'),(5,'Menghapus data produk (TOP SCRUNCHIE YELLOWISH)',6,'2022-12-19 05:56:27'),(6,'Menghapus data produk (TOP SORAYA YELLOWISH)',11,'2022-12-19 07:15:08'),(7,'Menghapus data produk (TOP SORAYA YELLOWISH)',11,'2022-12-20 05:58:40'),(8,'Menghapus data produk (TOP SORAYA YELLOWISH)',11,'2022-12-20 05:58:46'),(9,'Menghapus data produk (TOP SORAYA YELLOWISH)',11,'2022-12-20 05:58:51'),(10,'Menambahkan produk baru (TOP SCRUNCHIE YELLOWISH) sebanyak 6. ',6,'2022-12-21 04:05:17'),(11,'Menghapus data kain (DNTL YELLOWISH)',6,'2022-12-26 04:45:21'),(12,'Menghapus data kain (VOAL YELLOWISH)',6,'2022-12-26 04:45:24'),(13,'Menghapus data kain (TYB YELLOWISH)',6,'2022-12-26 04:45:27'),(14,'Menghapus data kain (TYB YELLOWISH)',6,'2022-12-26 04:45:31'),(15,'Menghapus data kain (TYB YELLOWISH)',6,'2022-12-26 04:45:34'),(16,'Menghapus data kain (TYB YELLOWISH)',6,'2022-12-26 04:45:37'),(17,'Menghapus data kain (TYB YELLOWISH)',6,'2022-12-26 04:45:40'),(18,'Menambahkan data kain baru (4 110) Sebanyak 1 roll',6,'2022-12-26 04:45:59'),(19,'Menghapus data kain (TYB MOSS)',6,'2022-12-26 04:46:30'),(20,'Menambahkan data kain baru (4 107) Sebanyak 1 roll',6,'2022-12-26 04:46:48'),(21,'Menambahkan produk baru (TOP TANIA COPRA) sebanyak 10. ',6,'2022-12-26 05:24:27'),(22,'Menambahkan produk baru ( BANDANA COPRA) sebanyak 5. ',6,'2022-12-31 06:52:26'),(23,'Menambahkan produk baru ( BANDANA COPRA) sebanyak 5. ',6,'2022-12-31 06:53:06'),(24,'Menambahkan produk baru ( BANDANA COPRA) sebanyak 5. ',6,'2022-12-31 06:54:01'),(25,'Menghapus data produk (TOP SORAYA YELLOWISH)',6,'2023-01-24 10:15:07'),(26,'Menambahkan data kain baru (4 115) Sebanyak 1 roll',6,'2023-02-02 22:43:32'),(27,'Menghapus data kain (VOAL COPRA)',6,'2023-02-02 23:03:48');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `logs` with 27 row(s)
--

--
-- Table structure for table `material_patterns`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_patterns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `user_id_in` int(11) DEFAULT NULL,
  `user_id_out` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_patterns`
--

LOCK TABLES `material_patterns` WRITE;
/*!40000 ALTER TABLE `material_patterns` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `material_patterns` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `material_patterns` with 0 row(s)
--

--
-- Table structure for table `material_types`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_types`
--

LOCK TABLES `material_types` WRITE;
/*!40000 ALTER TABLE `material_types` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `material_types` VALUES (1,'BTRY',51000),(2,'DNTL',53000),(3,'RYN',19500),(4,'TYB',18500),(5,'SHKL',23000),(6,'VOAL',8500);
/*!40000 ALTER TABLE `material_types` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `material_types` with 6 row(s)
--

--
-- Table structure for table `material_vendors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(50) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_vendors`
--

LOCK TABLES `material_vendors` WRITE;
/*!40000 ALTER TABLE `material_vendors` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `material_vendors` VALUES (1,'MATAHARI PO',NULL),(2,'MATAHARI NON PO',NULL),(3,'MATAHARI RAYON',NULL),(4,'MATAHARI TOYOBO',NULL),(5,'MATAHARI SHAKILA',NULL),(6,'ALIBABA',NULL),(7,'BMJ',NULL),(8,'KARUNIA',NULL),(9,'MATAHARI PO TEMEN PA WINDRA',NULL),(10,'DFASHION',NULL);
/*!40000 ALTER TABLE `material_vendors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `material_vendors` with 10 row(s)
--

--
-- Table structure for table `materials`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` varchar(50) NOT NULL,
  `material_type` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `weight` float NOT NULL,
  `roll` int(11) NOT NULL DEFAULT '1',
  `qrcode` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `price` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL DEFAULT '1',
  `tgl_cutting` timestamp NULL DEFAULT NULL,
  `gelar1` int(11) DEFAULT NULL,
  `gelar2` int(11) DEFAULT NULL,
  `pic_cutting` int(11) NOT NULL,
  `vendor_pola` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `materials` VALUES (13,'M-UDW9522',2,8,112,400,1,NULL,1,18500,6,1,NULL,NULL,NULL,0,0,'2023-02-02 22:43:32',NULL);
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `materials` with 1 row(s)
--

--
-- Table structure for table `models`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `harga_jahit` int(11) DEFAULT NULL,
  `hpp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_name` (`model_name`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `models` VALUES (1,'LOVISH','KULOT','AMARA',8500,65000),(2,'LOVISH','TUNIK','BELLA',0,29500),(3,'LOVISH','TUNIK','DIRA',6500,27000),(4,'LOVISH','TUNIK','FIDIA',8000,40000),(5,'LOVISH','TUNIK','GIYA',9000,50000),(6,'LOVISH','DRESS','KAMILA',9000,48000),(7,'LOVISH','DRESS','KAMIYA',0,50000),(8,'LOVISH','TUNIK','KARINA',7500,38000),(9,'LOVISH','DRESS','KEYSHA',9000,50000),(10,'LOVISH','TUNIK','LALA TOP',7500,33000),(11,'LOVISH','TUNIK','LOLITA',7500,40000),(12,'LOVISH','DRESS','LOVA',18000,80000),(13,'LOVISH','TUNIK','LUNA',6500,37500),(14,'LOVISH','TUNIK','MECCA',6500,33000),(15,'LOVISH','TUNIK','MINDSET',0,35000),(16,'LOVISH','TUNIK','NESYA',6500,37500),(17,'LOVISH','DRESS','NOLA',10500,65000),(18,'LOVISH','TUNIK','SAKURA',10500,42000),(19,'LOVISH','DRESS','SENA',8500,48000),(20,'LOVISH','ONE SET','VINA',12000,72000),(21,'LOVISH','ONE SET','ZOLA',12000,72000),(22,'LOVISH','TUNIK','ZIYA',7000,34000),(23,'LOVISH','TUNIK','MOZA',8500,37000),(24,'LOVISH','TUNIK','RANIA',7500,37000),(25,'LOVISH','TUNIK','LILI',7500,43000),(26,'LOVISH','TUNIK','AMIRA',6500,30000),(27,'LOVISH','TUNIK','RAYA',7500,33000),(28,'LOVISH','TUNIK','ASTER',7000,36500),(29,'LOVISH','','SETELAN ANAK',5000,20000),(30,'LOVISH','','PERBAIKAN REJECT',2000,0),(31,'LOVISH','','PERBAIKAN',0,0),(32,'LOVISH','TOP','JASMINE',7500,36000),(33,'LOVISH','DRESS','AULIA',6000,36500),(34,'LOVISH','HOMEDRESS','NADA',7500,38000),(35,'LOVISH','TUNIK','LAURA',8000,36500),(36,'BASUNDARI','TOP','OLIVIA',41000,110000),(37,'BASUNDARI','SHIRT','SELENA',38000,110000),(38,'LOVISH','TOP','SABILA',9000,42000),(39,'LOVISH','TOP','VIOLA',7500,36000),(40,'LOVISH','TUNIK','SAFA',7000,40000),(41,'LOVISH','HOMEDRESS','BESTARI',8500,54000),(42,'LOVISH','TOP','MAHIKA',8000,36500),(44,'ODELIA','VOAL','ELIAH',1750,16500),(45,'ODELIA','PASHMINA','NOURA',2250,16000),(46,'ODELIA','VOAL','HANANIA',5000,21000),(47,'EMIKA','TUNIK','SYAHNA',12000,46000),(48,'ODELIA','JERSEY BERGO','NEIRA',4000,20000),(49,'ODELIA','CRINCLE BERGO','LAYNA',4500,27000),(50,'EMIKA','TUNIK','KENARI',8000,35000),(51,'ODELIA','SCARF','LORA',1500,15000),(52,'ODELIA','VOAL','LEVIA',2000,20000),(53,'ODELIA','SHAWL','KEMARA',2000,19000),(54,'','','HULYA',0,40000),(55,'EMIKA','TOP','ELGA',9000,40000),(56,'EMIKA','TOP','ZAFIRA',10000,40000),(57,'LOVISH','TOP','SAFIRA',10000,40000),(58,'EMIKA','TOP','YOURA',11500,45000),(59,'BASUNDARI','','GAYATRI',0,25000),(60,'','','ULTRASONIC',1500,0),(61,'','','LABEL',200,0),(62,'','','CUTTING KERUDUNG',250,0),(63,'','','LASER CUT',3000,0),(64,'EMIKA','TOP','SAVITA',7500,45000),(65,'LOVISH','TOP','SORAYA',7500,33000),(66,'BASUNDARI','','DEWANI',0,115000),(67,'BASUNDARI','','DAYLE',0,25000),(68,'LOVISH','TOP','DELIA',6500,35000),(69,'LOVISH','TOP','TANIA',8500,36000),(70,'LOVISH','TOP','SARAH',8500,36000),(71,'','','JAHIT TEPI',3000,0),(72,'ODELIA','','BANDANA SET',0,36000),(73,'ODELIA','','BANDANA',0,15000),(74,'ODELIA','','KAOS KAKI',0,20000),(75,'ODELIA','VOAL','NESSA',0,22000),(76,'LOVISH','TOP','YUNITA REG',15000,35000),(77,'LOVISH','TOP','YUNITA JUM',15000,35000),(78,'ODELIA','TOP','SCRUNCHIE',2000,4000),(79,'','','VOAL',NULL,NULL);
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `models` with 78 row(s)
--

--
-- Table structure for table `penjualan_reject`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penjualan_reject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reject_id` int(11) NOT NULL,
  `hpp` int(11) DEFAULT NULL,
  `qr` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `tanggal_jual` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan_reject`
--

LOCK TABLES `penjualan_reject` WRITE;
/*!40000 ALTER TABLE `penjualan_reject` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `penjualan_reject` VALUES (1,15,500000,NULL,2,'2022-12-19 13:00:54'),(2,13,NULL,NULL,1,NULL),(3,14,NULL,NULL,1,NULL),(4,13,NULL,NULL,1,NULL),(5,30,NULL,NULL,1,NULL),(6,31,NULL,NULL,1,NULL),(7,32,NULL,NULL,1,NULL),(8,34,NULL,NULL,1,NULL),(9,34,NULL,NULL,1,NULL),(10,34,NULL,NULL,1,NULL),(11,34,NULL,NULL,1,NULL),(12,33,NULL,NULL,1,NULL),(13,33,NULL,NULL,1,NULL),(14,33,NULL,NULL,1,NULL),(15,33,NULL,NULL,1,NULL),(16,33,NULL,NULL,1,NULL);
/*!40000 ALTER TABLE `penjualan_reject` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `penjualan_reject` with 16 row(s)
--

--
-- Table structure for table `pola`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cutting_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `tgl_ambil` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `jumlah_pola` int(11) NOT NULL,
  `tgl_setor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jumlah_setor` int(11) NOT NULL,
  `reject` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pola`
--

LOCK TABLES `pola` WRITE;
/*!40000 ALTER TABLE `pola` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `pola` VALUES (6,3,4,'2022-12-23 08:19:00',2,'2022-12-23 08:47:08',0,0,0,0,0,1),(8,2,1,'2022-12-23 08:34:00',10,'2022-12-23 08:47:08',0,0,0,0,0,1),(9,13,1,'2022-12-23 08:41:00',5,'2022-12-23 08:47:08',0,0,0,0,0,1),(12,3,4,'2022-12-23 08:19:00',2,'2022-12-23 08:48:00',9,1,-8,2000,18000,2),(13,19,1,'2022-12-26 04:47:00',10,'2022-12-26 04:47:36',0,0,0,0,0,1),(14,19,1,'2022-12-26 04:47:00',10,'2022-12-26 04:47:00',10,0,0,8500,85000,2),(15,20,1,'2022-12-31 05:44:00',10,'2022-12-31 05:46:20',0,0,0,0,0,1),(16,21,1,'2022-12-31 06:14:00',5,'2022-12-31 06:14:28',0,0,0,0,0,1),(17,21,1,'2022-12-31 06:14:00',5,'2022-12-31 06:35:00',5,0,0,0,0,2);
/*!40000 ALTER TABLE `pola` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `pola` with 9 row(s)
--

--
-- Table structure for table `product_barcodes`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_barcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qrcode` text,
  `status` enum('1','2','3','0','4','5','6') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_barcodes`
--

LOCK TABLES `product_barcodes` WRITE;
/*!40000 ALTER TABLE `product_barcodes` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `product_barcodes` VALUES (7,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFAElEQVR4nO3dMW7DMBAAwSjw/7/slClShAhEXJaaqQ1bkrVgdbjr/X5/AE2f0xcA/J2AIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIey1+7rqurddxhvXJkB3Pc8dcyvp1zt77eRafpxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFsdRpp3Xm7WiqTQzvMXmflKa27/V1yAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhN0/jbRudkfO7KTLeTuHKs9zh8F7dwJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRNTiOxYnZu6bztRIdxAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhJlGOoe5pQdyAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhE1OIz15fqVy767zn3MCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCE3T+NtL5N58kqe4xmdyN5l37lBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCLseu1SmYsdEjj/9GE5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw1Wmkypaa2Q09lT1G62xRWjH4lJzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh908jVfbunHdH5/Ef/coJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9pq+gCWzm28qu5Eqdvybld1d6+xGgvMJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2Oo00o6ZmPOmfCozRufN7uyw4627nRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFsdRppx7xFYtoj9Ovrz7MyiTX71u1w+687gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwq7Z4YzHshdqymFTU05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw1Wmk2f1AFeeNdp034TT7JtuNBHwTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsNft3/jkiZwnq+xGmp1buv0pOYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMLun0Zad9iWmk12PKXZe5/93w97nk5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawyWmkJ3vyRM7sFqUd3zl4R05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYw00j/3Xk7nGbnlnZ8p91IwF8IGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2OQ0UmXOZtbsJqEdKneUuE4nMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2P3TSOszHKzYsfVnx6/PfueOX19/noNzS05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawq7JQB/jJCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIewLZgoNhcD11eYAAAAASUVORK5CYII=','5','2022-12-19 05:55:44','2022-12-19 05:55:44'),(8,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE/klEQVR4nO3dQY7bQAwAwTjw/7/sHHNcxpDA9KjqvLClWTfmRPD1+Xx+AU2/tx8A+J6AIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIew//7vV63focZ5hPhtxxnnfMpcyfc/fdzzM8TzcwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYdBpp7rxdLZXJoTvsPmfllOYu/y25gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwq6fRprb3ZGzO+ly3s6hynneYfHd3cAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGb00hM7M4tnbed6DBuYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMNNI5zC39EBuYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsM1ppCfPr1Te3XP+59zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh108jzbfpPFllj9HubiS/pR+5gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwl6PXSpTccdEjn/6MdzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh02mkypaa3Q09lT1Gc7YoTSyekhsYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHstN1I520S2p3y2VV598XndANDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRdP4103gTJXGWP0a7Knq05u5GAbwgYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYe/sBRnYnnHY/c/7u50357Er8ltzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhm7uRdu3uMZpb3LvzT+749vM2SNmNBPwlYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYddPIzFhzmbLYVNTbmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrD38O8qG492zedXKpuZztu3dMe3z13+nG5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw6TTS3HnLlnbngSrnWdmNtDsHdvkpuYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMKun0aaM+UzUZnymatse5pbPHk3MIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2OY00pM9eSJnd77qjs9cfCM3MIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmGmkc+xO+dzx7ZXPtBsJ+IaAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEbU4jLc5whJx3SrtTU3OJ53QDQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEXT+NNJ/hYGL3PO+Ys9mdMbpji9Li3JIbGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7HXe6h14DjcwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawP0TzGXNgRYnNAAAAAElFTkSuQmCC','5','2022-12-19 05:55:44','2022-12-19 05:55:44'),(9,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFA0lEQVR4nO3dUW4iMRQF0TBi/1tmlpCXyJZT7nO+UaAJJX9d+fX5fL6Apn+nPwDwewKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHsPXzd6/Xa+jnusGMZMv/mK+/utzQx/D6dwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdM10tx9d7XsWM+cXeRU9kB+S99yAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhK1fI82d3cScXbpUbhKq7IEe+y05gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwk6ukZ6scjsRf5wTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhzBrpjB236Vg4PZATGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7OQaaccip+Lscmj+zc8/59n/5mN/S05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw9WskN/SstWM5VHHfEy3nBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCHs99lKZ+1TuW2IhJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9h0jXTfLTX33TlUeaIdn/O+vznkBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCDt5N9J9K5+5yzYxm3iibzmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC3I30vcqzn32is3ugs7ulg9+nExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIew9fF1lw7Hj3e979rnKvVD3bcuGnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGNu5Hu25rcd4/Rjo1R5dnnln9LTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDpGom1zu5sKputucr9Vcs/pxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHsPXzdffuVHXZsYnZsjCp3I+1497nEUM8JDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQNl0jzSU2HD/y2KXL1+kV2n0Lp7nhEzmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC1q+R5hJrj03OLpx2rHzu22wlFk5OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsJNrJCYqtyjNVVZoOzZby/+bTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjBrpL8usYn5kcodTokdmBMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs5BopsfYIOXvnUMXZX93yLZQTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbP0aySbmlB33A+149x0qNx4tf3cnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2MsFRdDlBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPYf4U0Bf6W56i8AAAAASUVORK5CYII=','2','2022-12-19 05:55:44','2022-12-19 05:55:44'),(10,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFB0lEQVR4nO3dQW4bMRQFQSvQ/a/sLLMxYDoY4rvJqnWQ8UhqcPXA1+fn5wfQ9Gf6DwD+n4AhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAh7L/671+u19e84w/oyZMfnefPTz7P4eTqBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCVtdI6867q8V2Z4rf0recwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYc+vkdbN7mxmly7r71658WjWtb8lJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jkGokVO3ZLlafzLScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYNdI5diyHbIx+OScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY5Brp5qXL7Luv75bWzb7Rtb8lJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jza6QdS5fz7LjHaPb/3MFv6VtOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsNe1l8pUzC5y/Dx+OScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY6t1IlVtqdqxnzrvHqPIp7Xj6DoPfkRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs3ruRztsDrZt993XnPf3x790JDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9vwa6bxbamafPvtG6xLbnR89fQdrJOAfAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCFtdI1UWJNde9TTusJXPR+SNnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHv6T9gSeXOoZuXWNfugWY5gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwlbvRuJZs6up81R+xo9/705gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw1TXSzUuXddduYjY9fdbsDswaCc4nYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYe/H/8fKImfd7HpmcOnyo6fPfu/XrqacwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYc+vkdbNrj3OW01V3mjHFmrHairxeTqBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCJtdIN9uxnknc5fMx/e6zT3984eQEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIs0b67XZsjGZXPusq7z54i5ITGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbHKNNLjhCNnxKc3ubCr3QiV+n05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw59dIO3YhrJj95GcXTrO7pXWPv7sTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7JW4AAb4khMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYXyVjEIi0I0jSAAAAAElFTkSuQmCC','2','2022-12-19 05:55:44','2022-12-19 05:55:44'),(11,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFCElEQVR4nO3dQW7cMBQFQSvw/a/sXCCA6YDEd1NV68AzmqjB1QOfr6+vD6Dpz/QXAP6fgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCPtc/HfP8xz9HndYX4ac+D3f/On3Wfw9ncAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGra6R1993VYrszxbv0LScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY/jXSutmdzezSZf3ZKzcezXrtu+QEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm1wjseLEbqny6XzLCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEGaNdI8TyyEbo1/OCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEDa5Rnrz0mX22dd3S+tmn+i175ITGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbP8a6cTS5T4n7jGa/ZsneJe+5QSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAh7XnupTMXsIsfr8cs5gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwlbvRqrcUnNiPXPfPUaVX+nEp58w+H/kBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCFtdI6277zadE080+zcry6HZdynxJjuBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCnu2Ti8rShb3u20KdsP2JnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGra6T7FiSV73nCfc/+2idyAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhH0Ofvbs2iOxNfkRT7TXiSfazgkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2ejcSe83e9lS5w2ld5TXefseYExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWz1bqT79isnrG9iKsuhyo1Hr113OYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMJW10jrKrfUrKsssbbfu3Pob55QWU1t5wSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAjbv0Zad9+tP7MqT3RiC3ViNZX4PZ3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhk2ukN5u9c2h2BzZ7h9NlN0g5gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwqyRfrvZW39OrHzWnfibiY3ROicwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY5BppcMMRMns3UuXTZ3dLg5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh+9dIJ3Yhb5a4oedj+nvO7pbWbX92JzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9iTuAAG+CcnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsL9RjAeLp3SncAAAAABJRU5ErkJggg==','2','2022-12-19 05:55:44','2022-12-19 05:55:44'),(12,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFBElEQVR4nO3dQWokSRBFwalB97+y+gINcpoIXC/TbC1UylI+YvWJz/f3939A0//bfwDw7wQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY1/DnPp/P1b/jGebLkBvf55s//XmG36cTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbLpGmnveXS22O1u8Sz9yAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhJ1fI83t7mx2ly7zZ6/ceLTrte+SExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWxzjcTEjd1S5dP5kRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHMGuk5biyHbIx+OScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY5hrpzUuX3Wef75bmdp/ote+SExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIez8GunG0uV5btxjtPs7b/Au/cgJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9nntpTIVu4scr8cv5wSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAib3o1UuaXmxnrmefcYVb6lG59+w+L/yAkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBB2/m6kyiqlcuvP83Y2Pv3gpzuBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCNtdIc7vLIU808bw7nG44/kROYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsOkaqbJfufHpN7jD6azX7pacwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYV/Dn9tdDu163nLohtfugXY5gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwqZ3I3HW8zZbuyqv8fFlmxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFsukaynpnY3cTc+B8978ajud37wKyR4PkEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7Ov4b6zcUjO3u545fptO6NPnXruacgJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMISdXyPN7a49KqupGzf0VJZD8ye68eyJN8QJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQtrlGerMbS6wbK58bbiyHdndLizswJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5g10nNUVj5zlc3W4i1KTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDNNdLihiPkxre0u7PZXU3NJd5PJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9j5NdKNXQi/3+7CaXe3NHf82Z3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhn8QFMMBfOYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIT9ARynCojNNfFaAAAAAElFTkSuQmCC','2','2022-12-19 05:55:44','2022-12-19 05:55:44'),(13,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE/0lEQVR4nO3dQW7bQBBFwSjw/a/sLL0x4I7BQeuRVevAEhU+zOpjXp+fn3+Apr/bXwD4PQFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBD2Mfx3r9fr6Pe4h/ky5MTv+eRPv5/h7+kEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm66R5u53V4vtzhbv0o+cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdevkeZ2dza7S5f5s1duPNr12HfJCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELa5RmLixG6p8un8yAkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBBmjXQfJ5ZDNkZvzgkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2uUZ68tJl99nnu6W53Sd67LvkBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCLt+jXRi6XI/J+4x2v2bJ3iXfuQEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIez32UpmK3UWO1+PNOYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMKmdyNVbqk5sZ653z1GlV/pxKefsPh/5ASGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAib3o1UWSOdUNkYnbD7PSufvsgJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQdv0a6cn37lQ2Rifc7w6nOXcjAb8hYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYZt3IyXunvkvlZ1NZeUzV/k9rZGALwKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2uUaaq6xn7rev2rW7r0pwAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhE3XSFzryfcYnVB5jd2NBHwRMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsMbdSBW7m5jKbU+Vd2n+7Iu/vBMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs4/K/WLmlZm53PbO7Mdq9w2nusaspJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9j1a6S53bVHZTW1e0PPCSee6MRqKvGGOIEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMI210hPtrueqdz2VNktLd4g5QSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAizRnp3J5ZDuyufucqzL96i5ASGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAjbXCMtbjhCKvcDze3eTjSXeD+dwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdevkU7sQp6s8nvuLpx2d0tzlz+7ExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIeyVuAAG+JYTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2D96wROL0Vq/1wAAAABJRU5ErkJggg==','0','2022-12-19 05:55:44','2022-12-19 05:55:44'),(14,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFA0lEQVR4nO3dQW7bQBBFwTDI/a/sXCCAOgYH7UdWrQNTUvgwq4+5vr6+fgFNv7c/APB9AoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIezP8N9d13X0czzDfBly4vd889OfZ/h7OoEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMKma6S5593VYruzxbv0kRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs/jXS3O7OZnfpMv/ulRuPdr32XXICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEba6RmDixW6o8nY+cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdZIz3FiOWRj9MM5gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwjbXSG9euux+9/luaW73G732XXICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCE3b9GOrF0eZ4T9xjt/s0TvEsfOYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMKu114qU7G7yPF6/HBOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsOndSJVbak6sZ553j1HlVzrx9BMW/4+cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdM10vMWJM/bA1U+5+7T5xK/pxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHsGs4jdrc7FbvrmbkTv3xiu/NfT59zNxLwHQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBA2vRvphMp2Z9eJ7U5l5bP73RNrOScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY9G6kN9tdpVTuHDrhed/odk5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawzbuRKio3CVWe/ma376ucwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdO7kexXJnZ3S5VblCrv0onf8/anO4EhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMLuvxvpxH5lV2U9M1fZLc29djXlBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCLt/jTS3u/Z43mqq4sQW6sRqKvGGOIEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMI210hvtrvEqjy9sltavEHKCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEGaN9Ea7K5+5E38zsTGacwJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRtrpEWNxwhJ9YzJ54+t3s70Vzi/XQCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCE3b9GOrEL4efbvUlod7c0d/t3dwJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRdiQtggH9yAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCPsLgb0EkaT+zfgAAAAASUVORK5CYII=','0','2022-12-19 05:55:44','2022-12-19 05:55:44'),(15,2,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFFklEQVR4nO3dQU7kQBBFQTzi/ldmLjASycil5NkRa9SNwU+1+qrr6+vrA2j6s/0LAP9PwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhH0Of+66rqO/xzPMlyEn/p5v/vbnGf49ncAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHTNdLc8+5qsd3Z4l36lhMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs/jXS3O7OZnfpMn/2yo1Hu177LjmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCNtdITJzYLVW+nW85gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwqyRnuPEcsjG6JdzAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhG2ukd68dNl99vluaW73iV77LjmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC7l8jnVi6PM+Je4x2P/ME79K3nMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHXay+Vqdhd5Hg9fjknMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2PRupMotNSfWM8+7x6jyVzrx7Scs/o+cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYdM10tyJZcauE+uZ3c+sLId2b2ZK3AvlBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCLt/jTS3u/Z47W06P7J7h9PciW9PrKacwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYZtrpBMq253dlc/us5/4zPkTPezuLicwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYtXitS+WOnOd9e0XidqJdTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDNu5F2FySv3a98RG79eaTb91VOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsOkayX5lYr5wqmyhTvyeJ96l5910NeQEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIu/9upMrOZm53iXX7bTo/+skT335CZTV1OycwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY/Wukud21x/NWUxUntlC7m61FTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDNNdKbnVhiJe7y+TizHNrdLS3eIOUEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIs0Z6o92Vz9yJz0xsjOacwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYZtrpMUNR0jlfqC53duJ5hLvpxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs/jXSiV3Im1W2O7sLp91nn7v92Z3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhV+ICGOCfnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGML+AumlBKCIHgYOAAAAAElFTkSuQmCC','0','2022-12-19 05:55:44','2022-12-19 05:55:44'),(37,11,'data:image/png;base64,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','1','2022-12-21 04:05:17','2022-12-21 04:05:17'),(38,11,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFmUlEQVR4nO3cS25sNxAFQbeh/W9ZHmhsNWHR9SqvIqYCdPuX4OSAr8/Pz7+Apr//9AsA/jsBQ5iAIUzAECZgCBMwhAkYwgQMYQKGsI/v//x6vWZex0InG7Vbn8/kHm7yNZ88a/JzLvr+83ECQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9mYLfaJ4r2Vxw3zLrdd8a+d8S/G7+Pnv0AkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYhS30icl7fbfdsTy5PZ70O7fH52Y+HycwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhQ1vo32xyL71tB36iuKnewwkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYLfQKk/cV2zA/iRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawoS30U3ezJ+9r8l7oW886+T+T7+uWba/n55zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEXdhCT95pvM3k9njbjnfb+/qdv0MnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYW+20Nv2t9tM7oEn/882fof/xgkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY6/uV6bbd7OQdwtvuPb5l23d6onh39MzvxwkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYmy30tccs299uu4d52176llvf+7YN/B5OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwi7cC73tzt5b++RbWtvaL8/bDH8p/sbcCw2PJWAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQN3QtdtG0PvO1u7Ul7tsfnz5r5P05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCHriFLm6GJ/e3t0xuj2/Zds/5z5/lBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIezj5/9i2770RPGe4Vu2baonTW7O3QsNvCFgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEXbgXungP8zbb7iIufqeTO+fJz8cWGh5LwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCHtzL/TkdvSpdxGf2Ha39rZnbdtm77nn3AkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYhXuhJxW32cXXfMu2DXORe6HhsQQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw2BZ6m2375Fvb48m7mrd9Pq0inMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIR9fP/n33yv78kmdtuO90Rr6/tl2z3eJ2bu+nYCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9mYLfeKp29pJt7a+k+/rqXdHt96XExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrALW+gT2za6Rbc+w8k7lk9s26XfMrOXdgJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBA2tIV+qm0b72176W13LJ88a9vr+Z4TGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMFvo/92tO5aLu+viXvrErU31z1+PExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrChLfStDepTzexmd5p875PPmtmTO4EhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAi7sIWevK/4qbZtfbdts7fdC72HExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDX89ah8Hs4gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIewfJX2UePnnHV0AAAAASUVORK5CYII=','1','2022-12-21 04:05:17','2022-12-21 04:05:17'),(39,11,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFi0lEQVR4nO3cQW7bMBRF0brI/recrqAyUTO/vNI50xaREvuCkwe+vr+/fwFNv//3CwD/TsAQJmAIEzCECRjCBAxhAoYwAUOYgCHs6/qfX6/XzHscaNdGbfJveNddne/h3ziBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIe7OFXlHc3xb3ySvvvPJ/Vt5n199n8rvxzO+hExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrANW+gVxe3xLn73a5PvfL/PwgkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY0Bb6rk67h3nSabvrZ3ICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQZgudMbmp3vUse+mf5gSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFsaAt9103saXc+73qfXe982l76ft9DJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEbttCTW9/T7Nr6nrY9Pu33WvHM76ETGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsNf9bso9zeTdyLv2wJPv4xv4CScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhb+6FPm1bu2LyfuDiZnjyXujTds7F7/M1JzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEb7oU+7d5jz/rc5Gb4yb/755zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEDd0LveKu2+Ndz5rc6E6+z4rT7s0+hxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawN1voXZtY2+NznrVicuc86bQ7qD/nBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIezNFnrF5Nb3tJ8z+awn75x3fcdO29t/zgkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYmy30aTve05512h3Up+2cJ3+vu96/ff0sJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGFD90KvKN7VvOtZu/6Gz9wDr/+c+3ECQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQtmELvUtxW3vaRve0Z638fSY/ixUrzzpnd+0EhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7HW9IC3ugU9z2u7a53XttG32NScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhb7bQXNu1GS5+CsXfvbg5v/45TmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMK+rv/Z/cAz3Od8bfIe5tZn4QSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHszRZ6xZPvNF6xazf75D3w5HfsnJ3zCicwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhG7bQK07bHk8+65zd7LrJ3+u0v8/kDvzz76oTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsKEt9JNN7maL9zDvcto7z3zuTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMJsoX/caXdir7zPzJ3GZz5rl5ltthMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawoS30aXf27nLafc6T90JP7orvt2He9SwnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYRu20JM71aLT9tK77Hrn037OLjO7dCcwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhr7ve2AxP4ASGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawP4xphcPwkBHMAAAAAElFTkSuQmCC','1','2022-12-21 04:05:17','2022-12-21 04:05:17'),(40,11,'data:image/png;base64,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','1','2022-12-21 04:05:17','2022-12-21 04:05:17'),(41,11,'data:image/png;base64,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','1','2022-12-21 04:05:17','2022-12-21 04:05:17'),(42,11,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFgElEQVR4nO3cMW4bQRBFQdPQ/a8sB45FLsxBu9+yKjWwWpN8mORjHt/f37+Apt//+wWAfydgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9vX8nx+Px8x7LHRlo3bl87nr1u3Ub+PU53xXzz8fJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEvttBXFLe+xW3t5Duf+k4nfxuf+Tt0AkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEHZgC31Fccd7yqm7oyfvqS5uxa+43+/QCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jQFprnTm2YT/nkvXSLExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjBb6LfcdTO8bZvNT5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEDW2h77qb3bZzPvU5T268t9133eIEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7MAWetseeJvJXfGp+5wnn3PKZ/4OncAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQ97ndTbtHkHcvb9tK8wwkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYi3uhJze6V0ze/bttx7vtHuZtindZX/H8nZ3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEHbgX+q73DG97n1O2bX2vcN/1T5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEHdhCX/ozy3aqd90DT9p2Z/ikPfeTO4EhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAj7ev8Re3ahfxV316f2wNveedvmfNv7vM8JDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2IEt9OQmdttzrijunIuKO/D3fxtOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwh7P15indrOn9sCTJv/vrf3t9b+1zbbP8H1OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwl5soSfZHr//tyZt+5y3mSnLCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9iiLfQVrTt7/5rc8W7bb1+xbU++beP9/DlOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwl5sobfdx7vtDuHiRveKu95lPcm90MALAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ1jsXuhttt2xfMW2fXLxDuo9z3ECQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQFrsXetK2O5+3mbyDunhv9sz37gSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs6/1HfPKOd8/9wPPPmVT8jc28sxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawA1voKya3tdt2s3fdOZ/6W3fdXbsXGnhBwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBvaQt/Vtt3szP727N8q7uT3fF9OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwmyhM05thrfdC73tOVfs2aU7gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCHs8X2NO3jM8adu29pQ9G915276LU9wLDbclYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhB24F/quG9RJp7bHk9/Ftj35tu36zPs4gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCHtxLzSwmRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC/gDsVZqNhOXS+AAAAABJRU5ErkJggg==','2','2022-12-21 04:05:17','2022-12-21 04:05:17'),(79,48,NULL,'1','2022-12-26 05:22:22','2022-12-26 05:22:22'),(80,48,NULL,'1','2022-12-26 05:22:22','2022-12-26 05:22:22'),(81,49,NULL,'1','2022-12-26 05:22:22','2022-12-26 05:22:22'),(82,49,NULL,'1','2022-12-26 05:22:22','2022-12-26 05:22:22'),(83,50,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFAUlEQVR4nO3dQW4jMQwAwcwi//+y9wnRBiNwW6o6B7E9doMngs/n8/kCmv5MvwHg9wQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY9+LfPc+z9X2cYX0zZMfz3LGXsv4+Zz/7eRafpwkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2uo207rxbLbObQzfv7vgt/cgEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIe38bad3sns3spsvszSFbPu8afJ4mMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2OQ2Eu+yt3QhExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIcw20v9ux9UfO0bHMIEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMImt5Fu3om5+bPvcO3zNIEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMLe30baccvnPOtPaX3PpvI/1/kt/cgEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIe649KlOxYyPHl34MExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWz1NlLlSs3shZ7KHaMdbr6iNPi9m8AQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGr20izezbrZi8JVXa21lW2pq7dAzOBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCVreRZtlwOknlO5r91S0ygSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwp7XFylmd3fWVW7kDG66fE1/ovNefd3i+zSBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC3t9G+ofXPm7X5LxXP2x3Z5PBK0omMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2Pfga89ukMy++nlmd6EqXv/sJjCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jqbaTZyzcV523P7HDeFSW3kYDfEDCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrD3byOdt5Ezuz0ze0lox6vPvs8d3+bgb94EhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIe38bad15N3JmHbZn89XZxBpkAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhE1uI91sx57N7O7ODpVrT4NP3gSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAizjXSOyh2jWTue0uCTN4EhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMImt5EqF3pmzW75rH9HlTtGhzGBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC3t9GqtzIqbj54lFlw2lwa8oEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIe649KgMHMIEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIT9Bbv0B4iadysnAAAAAElFTkSuQmCC','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(84,50,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE+ElEQVR4nO3dQY7bMBQFwSiY+1/ZOYKJAYmfpqrWQcaW1eDqgc/n8/kDNP2d/gDA7wkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawn8V/9zzP0c9xh/VlyH3P883f/YTF5+kEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIW10jrbvvrpbKeua+PZB36SsnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2P410rrZTczs0uXEcujE86zsgV77LjmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCJtdI7DW7cKrsli7jBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCLNGmjG78jmxW2KEExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWxyjeQ2nb1OLJwqv1Hlc27nBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCNu/RnKbzk1m73DyLn3lBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCHtee6nMrMrOxuvxn3MCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCErd6NNLueqdy7c992p7KaWnfZu+QEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAI2383UmW3tP45Z//P+8w+pctWaE5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw/Xcjze5sbIym3PfkE7+mExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWx1jXRiQbJu9o6cynrmvm90wmW3ZzmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCJu9Gmt0trf/1E59z3exfr2yMKhu47ZzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhT2JycZ/XrmfGJW48WucEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIW10jzd7QU3FiD3TfrVQn3Pd+Lj5PJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jP9v/xvht6TixdZtczld/IU/rKCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELZ/jbTuzVuT2VuUZq1/9xO3PVXur1rkBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCJtcI7HX7L6qsoU6sRwafPJOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMGukGSe2O7M3CVXuHDrx5Ad/TScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY5Bpp9i6fN3OL0l6DWygnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2P410n1bk4r77luqfKNBTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDHBUXQ5QSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBD2D0AZ/n+xP9MvAAAAAElFTkSuQmCC','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(85,51,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFCElEQVR4nO3dQW4bMRBFwUzg+1/ZOYIbxhCdR1WtDUsa6YGrDz7f399/gKa/228A+D0BQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9jX8u+d5jr6PO8yXIfc9z0/+7CcMn6cTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbLpGmrvvrpbKeua+PZDf0o+cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYe+vkeZ2NzG7S5cTy6ETz7OyB/rY35ITGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbHONxLt2F06V3dJlnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHWSDt2Vz4ndkuscAJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRtrpHcpvOuEwunyndUeZ+vcwJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIS9v0Zym85Ndu9w8lv6kRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs+dhLZXZVdjZ+Hv85JzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9j0bqTd9Uzl3p37tjuV1dTcZb8lJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9h0jXTCfBdy3xZq1+4nmn+bleXQ3OufyAkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBA2XSNVFjmV/UrlfZ549RMrtBPPM/GbdwJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRt3o20uzWZO7Ge2V0OzVW+o7ndLdTr/9MJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9v4aaXe/srvyqdz6M1fZGFXur3qdExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIexJTC7u87HrmXWJG4/mnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHTNdLunUMV9932NLe7hao8pbnh83QCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEfb3+H++7oefE0sXdSBO7G6PE83QCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEvb9Gmvvkrcn81StbqLn5Zz/xlHbvr3r91Z3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhm2skJu5b5Ow68ZQWl21OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMGukHZXl0O4i58T7rNw1NfxETmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDNNdLijTIsqtyiNLe4hXICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEvb9Gum9rcp/dm4Q++dVf5wSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAh7XFAEXU5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh/wDD0fJ8UFL/fAAAAABJRU5ErkJggg==','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(86,51,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE+0lEQVR4nO3dMW4bQRBFQdHQ/a9Mhw7VNjhov9mqWJC4Sz1M9DGv9/v9BTT92v4AwL8TMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYd/Dn3u9Xkc/xx3my5AT7/PELmX+OXef/T7D9+kEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm66R5u67q2V3OfTk7Y7/pR85gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwj6/Rprb3dnsLl127xyy8vmsxffpBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCNtcI/FZdksP5ASGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAizRvrfnbj1x8boGk5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawzTXSkzcxT372Ex77Pp3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhn18jnbjL5z7ztzTf2VR+55z/pR85gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwl6PvVSm4sQix5d+DScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY9G6kyi01uzf0VO4xOuHJtygtfu9OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsOka6YTKcqiyBzqhspra3YEtcgJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIS9hpOLys6mcu9OYuny1dnuPPb/0wkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBA2XSP9xW+03Rmo3AtVuceo8tfnhp/TCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPb5NdIJ9+1s5naf/bLtziGLKzQnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDWGONdJ/KHqiyr9q1+OadwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYd/Dn9u9+aZivp65b2N0wn3P7m4k4A8BQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm96NdN99NnOefWL32XfXcovP7gSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAib3o10wmMXJIfcd5PQ7hYqcR+YExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWxzjfRkuzubyhJrd2M0/+uL36YTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhzBqJz0jcJPR13brLCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELa5Rqrc0MNE5R6jyziBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCPr9GqtyRc5/5IufEyufE915ZOC2uppzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhr8deKgMXcAJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAj7DWviCnYS6KSCAAAAAElFTkSuQmCC','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(87,52,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE+UlEQVR4nO3dwW0jMRQFwZ2F809ZDsGEQeK7OVVnw5JGavD0wOfz+fwDmv5PvwHg9wQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY1+LfPc9z9H3cYX0Zct/zfPNnP2HxeTqBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCVtdI6+67q6WynrlvD+S39CMnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2P410rrZTczs0uXEcujE86zsgV77W3ICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCETa6R2Gt24VTZLV3GCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEGaNNGN25XNit8QIJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jkGsltOnudWDhVvqPK+9zOCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELZ/jeQ2nZvM3uHkt/QjJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jz2ktlZlV2Nn4ef5wTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbPVupNn1TOXenfu2O5XV1LrLfktOYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsP13I60vM2Z3IZXl0H2rqcovZJY1EtxPwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwlbvRjphdhdy321Ps05sjGZ3S4nvyAkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2uka6b2tywvonqnz2yvtcN/v73P4/ncAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGTdyOd2K/MLkjWVV69sjGafUqDnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGFPYnJxn9euZ8Ylbjxa5wSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAhbXSOdWM/cZ3YPNPsdvfmzn7D4PJ3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhX9v/43039JxYupy4TceT3yvxPJ3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh+9dI6968NXnzTUIn9lUn1l3rBl/dCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEDa5RmKvyiJn1mW3UjmBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCrJFmzG53Trx65c6hE5998Hk6gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwibXSIM3yoTM7mzefIvSusHvyAkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2f41039Zk1uzGyKv/cU5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawxwVF0OUEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9g1um/WCyB96jQAAAABJRU5ErkJggg==','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(88,52,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFCElEQVR4nO3dQY4TQRBFQYy4/5WHJTtIUJeSVx2xHo3ttp9q9VWfr6+vb0DT9+03APw7AUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPZj+Hefz+fo+7jDfBly4nme2KXM3+fuZ7/P8Hk6gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwqZrpLn77mrZXQ69ebvjt/RHTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDn10hzuzub3aXL7p1DVj7PWnyeTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDNNRLPslt6IScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYNdL/7sStPzZG13ACQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEba6R3ryJefNnP+G1z9MJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9vwa6cRdPveZP6X5zqbyP+f8lv7ICQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPZ57aUyFScWOb70aziBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCpncjVW6p2b2hp3KP0QlvvkVp8Xt3AkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhE3XSLubmPtevXI7UWU1VfmOHv+fTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDpGumEyk1CJ9YzlbumTqjcjZS4E8sJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQNl0j3bfI2d3EVO5GmnvzLUqLnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGfx2cxb16lVBZOle9obnfdtfgLcQJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQ9v0ZiorIHquyrdi0+eScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYj+Hf7d58UzFfz9y3MTrhvs/ubiTgFwFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAibrpHmKkuXuTcvsU7cY7R739JlCycnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2PNrpLndlc99q6m5ExujE3bfZ2KF5gSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAjbXCO92WU39ByyuzGav/riasoJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQZo3E7yTuB/orJxZOizswJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jmGum+u3xO2H1Ku6++eOdQhRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs+TXSfbfp7DqxyNn9n3MnNkaV5znkBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCPu89lIZuIATGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2E9xMQeUa7ToOAAAAABJRU5ErkJggg==','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(89,53,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE/0lEQVR4nO3dQW7cMBQFwSjw/a88PoKZgMR3U1VrwzOW1eDqgc/n8/kDNP2d/gLA/xMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhX4s/9zzP0e9xh/VlyH3P881/+wmLz9MJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQtrpGWnffXS2V9cx9eyDv0o+cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYfvXSOtmNzGzS5cTy6ETz7OyB3rtu+QEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm1wjsdfswqmyW7qMExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIcwaacbsyufEbokRTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDJNZLbdPY6sXCq/I8q33M7JzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9j+NZLbdG4ye4eTd+lHTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDntZfKzKrsbLwev5wTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbPVupNn1TOXenfu2O5XV1LrL3iUnMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2Ooaad3sImd9FzL7Pe/bLa2b/R9dtqtzAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhD3b5xEntib33dCz7sRTml35zP5FlffT3UhwPwFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAhbvRvpxN6isjU5obKvqjzPdZdt4JzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh++9Gqhi8z+afVL7nCbN7oMQNUk5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw966RZt1351DFZTdyOYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMJW10izt9RUVO5GOmF2NfXap+QEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAI+9r+G++7y+fE0qVyQ8/symf20xNvshMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFs/xpp3Zu3JpWbhGa3ULOfvm7w053AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhk2skVpzYbFXuRjphdjW1nRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHMGmnG7MpnduG0bvYOp3WDz9MJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQNrlGGrxRhkH33bc0uIVyAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhO1fI923NXmzEzub2XuMZj99OycwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY44Ii6HICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAI+wblXu+Id18RqQAAAABJRU5ErkJggg==','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(90,53,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE+0lEQVR4nO3dQW4bMRQFQU2Q+19ZOUAWJgISP82pWhuWNFKDqwc+3+/3AzT9mn4DwL8TMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYb8X/+55nqPv4w7ry5ATz/PELmX9fc5+9vssPk8nMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2Ooaad19d7XMLofevN3xW/qRExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIWz/Gmnd7M5mdukye+eQlc9eg8/TCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEDa5RmIvu6UXcgJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRZI/3vTtz6Y2N0DScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY5BrpzZuYN3/2E177PJ3AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh+9dIJ+7yuc/6U1rf2VT+5zq/pR85gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwp7XXipTcWKR40u/hhMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFs9W6kyi01szf0VO4xOuHNtygNfu9OYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGsNU10pt3NrOffVbl26z8Prd/705gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoaw1TXSutmdTWW39GaVu5Fm/6e7keB+AoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELZ/jVS5+ea+V5/lFqURTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrBncEiRWHt8OjubEyqf6LWbLScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY/ruR1lUWJLPv88Sru3Nor8EllhMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFsdY1Uuctn1vp6ZvbOoTevfCqffZETGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbP/dSJetPT7TS6zZ3dIJs7c9XbZwcgJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMITtXyOtq6x8Zp14SpVFzvr7nH31QU5gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawyTXSm1WWWJX3ue7EwmlwNeUEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIs0a6x+xtT4mbhD5nntLgk3cCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCETa6RZtcz7FW5x+gyTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrD9a6TKHTkVlZ3Nie+9snAaXE05gSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwp7K2AX4mxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPYHwa9/oLo4wIEAAAAAElFTkSuQmCC','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(91,54,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFCElEQVR4nO3dQW7cMBQFQSuY+1/ZuUCAMAGJ76aq1sZYHqvB1QOf7+/vL6Dp1/QDAP9PwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhH0Wf+55nqPPcYf1Zcj693niM0+oPGfF4vfpBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCFtdI627766WE+uZyrc0+5yVb2nd9nfJCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELZ/jbSucpfPCbMLp/tuJ3rtu+QEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm1wjMeXEbum+e4wSnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHWSD/diZWPjdE1nMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGTa6Q3L11O3E50QmW39Np3yQkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2f400u56pOLHymf3ME7xLf+UEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIe157qcybnVj5eJFGOIEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMJW10iVW2pObGLuu3No1uz/6ITB+6ucwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYZ/tn3jfImdwa/JP7ltNVTZGg5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhk3cjzW5iKoucym7phPv2VevcjQT3EzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDVNdKR3x3ZmlQWOetmF06zKjddLXICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEfaYfYMnsLqSymjrBrVR7bX+XnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGTa6TZO4fWzT5n5V6o+5ZD6wb/dicwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY6hqpcpfPrPVNTGXlM3sr1Qmzf9H2z3QCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCE7b8bqbJKWWeJNWV2D5T4vzuBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC9q+R1s2uPSqrqcvWM1/TtxOtS7whTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDJNdKbnVgOzd4kdOIzK3u1wX2VExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIcwa6aeb3e6cWCPZGG3kBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCJtcIw1uOK5UuXNo3X1LrO2cwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYfvXSJWly5vZLU3ZvnByAkOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhD2JC2CAP3ICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAI+w0l4Qd5m/xEvwAAAABJRU5ErkJggg==','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(92,54,'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFBUlEQVR4nO3dQU4kMRQFQWrE/a/MXGAkzMjWJ10RawRNdaW8evLz9fX1ATT9mf4AwP8TMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYZ+LP/c8z9HPcYf1Zcj68zzxO0+ofM6KxefpBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCFtdI627766WE+uZylOa/ZyVp7Ru+7vkBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCNu/RlpXucvnhNmF0323E732XXICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCETa6RmHJit3TfPUYJTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjBrpN/uxMrHxugaTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDJNdKbly4nbic6obJbeu275ASGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAjbv0aaXc9UnFj5zP7OE7xL33ICQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEPa+9VObNTqx8vEgjnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGGra6TKLTUnNjH33Tk0a/Y7OmHw/ionMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFD2P67kSo7m/t2S5WVT2WzNfs5rZHgfgKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBD2ufhz922MKv/Rutnl0KwT33viDXECQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCENe5GStxS86O/Xln5rEtsdz6u+zadwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYZN3I83uQip35MxuYirf+wmzz3PxrzuBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC9t+NxIrEvTs/MrsYm31Kg5stJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jk3Uj3Wd/EvHljNGv2P9r+O53AECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhq2ukdZVVyrrZJdZ9e6B1s3ugxALPCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAELZ/jbRudu1x33anorKvSrwhTmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrDJNdKbvXmRU7md6MTn3P48ncAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHWSG80u4WyMdrICQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEDa5Rpq99Yffb/YWpcT76QSGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAjbv0aavfnmPidu6Jld+ZxQ+Y+2L5ycwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYU/iAhjgn5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjC/gKHPwGCWheDPwAAAABJRU5ErkJggg==','1','2022-12-26 05:24:27','2022-12-26 05:24:27'),(93,55,NULL,'1','2022-12-31 06:52:26','2022-12-31 06:52:26'),(94,55,NULL,'1','2022-12-31 06:52:26','2022-12-31 06:52:26'),(95,55,NULL,'1','2022-12-31 06:52:26','2022-12-31 06:52:26'),(96,55,NULL,'1','2022-12-31 06:52:26','2022-12-31 06:52:26'),(97,55,NULL,'1','2022-12-31 06:52:26','2022-12-31 06:52:26'),(98,56,NULL,'1','2022-12-31 06:53:06','2022-12-31 06:53:06'),(99,56,NULL,'1','2022-12-31 06:53:06','2022-12-31 06:53:06'),(100,56,NULL,'1','2022-12-31 06:53:06','2022-12-31 06:53:06'),(101,56,NULL,'1','2022-12-31 06:53:06','2022-12-31 06:53:06'),(102,56,NULL,'1','2022-12-31 06:53:06','2022-12-31 06:53:06');
/*!40000 ALTER TABLE `product_barcodes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_barcodes` with 39 row(s)
--

--
-- Table structure for table `product_logs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `status` enum('1','2','3','4','5','0') DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_logs`
--

LOCK TABLES `product_logs` WRITE;
/*!40000 ALTER TABLE `product_logs` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `product_logs` VALUES (1,1,0,'2',6,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(2,2,0,'2',6,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(3,3,0,'2',6,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(4,4,0,'2',6,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(5,5,0,'2',6,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(6,6,0,'2',6,'2022-12-19 05:54:15','2022-12-19 05:54:15'),(7,7,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(8,8,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(9,9,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(10,10,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(11,11,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(12,12,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(13,13,1,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(14,14,0,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(15,15,1,'2',6,'2022-12-19 05:55:44','2022-12-19 05:55:44'),(16,7,1,'2',0,'2022-12-19 05:57:54','2022-12-19 05:57:54'),(17,8,1,'2',0,'2022-12-19 05:57:55','2022-12-19 05:57:55'),(18,9,1,'2',0,'2022-12-19 05:57:56','2022-12-19 05:57:56'),(19,10,1,'2',0,'2022-12-19 05:57:57','2022-12-19 05:57:57'),(20,11,1,'2',0,'2022-12-19 05:57:58','2022-12-19 05:57:58'),(21,12,1,'2',0,'2022-12-19 05:57:59','2022-12-19 05:57:59'),(22,16,0,'2',11,'2022-12-19 07:05:09','2022-12-19 07:05:09'),(23,17,0,'2',11,'2022-12-19 07:05:09','2022-12-19 07:05:09'),(24,18,0,'2',11,'2022-12-19 07:05:09','2022-12-19 07:05:09'),(25,7,1,'5',0,'2022-12-19 07:23:31','2022-12-19 07:23:31'),(26,8,1,'5',0,'2022-12-19 07:23:33','2022-12-19 07:23:33'),(27,7,1,'4',0,'2022-12-19 07:26:19','2022-12-19 07:26:19'),(28,8,1,'4',0,'2022-12-19 07:26:19','2022-12-19 07:26:19'),(29,19,0,'2',11,'2022-12-20 05:57:37','2022-12-20 05:57:37'),(30,20,0,'2',11,'2022-12-20 05:57:37','2022-12-20 05:57:37'),(31,21,0,'2',11,'2022-12-20 05:57:37','2022-12-20 05:57:37'),(32,22,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(33,23,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(34,24,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(35,25,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(36,26,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(37,27,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(38,28,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(39,29,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(40,30,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(41,31,1,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(42,32,1,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(43,33,1,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(44,34,1,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(45,35,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(46,36,0,'2',11,'2022-12-20 05:59:01','2022-12-20 05:59:01'),(47,37,0,'2',6,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(48,38,0,'2',6,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(49,39,0,'2',6,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(50,40,0,'2',6,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(51,41,0,'2',6,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(52,42,0,'2',6,'2022-12-21 04:05:17','2022-12-21 04:05:17'),(53,42,1,'2',0,'2022-12-21 04:07:08','2022-12-21 04:07:08'),(54,43,0,'2',11,'2022-12-21 04:16:53','2022-12-21 04:16:53'),(55,44,0,'2',11,'2022-12-21 04:16:53','2022-12-21 04:16:53'),(56,45,0,'2',11,'2022-12-21 04:16:53','2022-12-21 04:16:53'),(57,46,0,'2',11,'2022-12-21 04:17:32','2022-12-21 04:17:32'),(58,47,0,'2',11,'2022-12-21 04:17:32','2022-12-21 04:17:32'),(59,48,0,'2',11,'2022-12-21 04:17:32','2022-12-21 04:17:32'),(60,49,0,'2',11,'2022-12-21 04:20:01','2022-12-21 04:20:01'),(61,50,0,'2',11,'2022-12-21 04:20:01','2022-12-21 04:20:01'),(62,51,0,'2',11,'2022-12-21 04:20:01','2022-12-21 04:20:01'),(63,52,0,'2',11,'2022-12-21 04:20:45','2022-12-21 04:20:45'),(64,53,0,'2',11,'2022-12-21 04:20:45','2022-12-21 04:20:45'),(65,54,0,'2',11,'2022-12-21 04:20:45','2022-12-21 04:20:45'),(66,55,0,'2',11,'2022-12-21 04:21:02','2022-12-21 04:21:02'),(67,56,0,'2',11,'2022-12-21 04:21:02','2022-12-21 04:21:02'),(68,57,0,'2',11,'2022-12-21 04:21:02','2022-12-21 04:21:02'),(69,58,0,'2',11,'2022-12-21 04:21:38','2022-12-21 04:21:38'),(70,59,0,'2',11,'2022-12-21 04:21:38','2022-12-21 04:21:38'),(71,60,0,'2',11,'2022-12-21 04:21:38','2022-12-21 04:21:38'),(72,61,0,'2',11,'2022-12-21 04:24:07','2022-12-21 04:24:07'),(73,62,0,'2',11,'2022-12-21 04:24:07','2022-12-21 04:24:07'),(74,63,0,'2',11,'2022-12-21 04:24:07','2022-12-21 04:24:07'),(75,64,0,'2',11,'2022-12-21 04:24:36','2022-12-21 04:24:36'),(76,65,0,'2',11,'2022-12-21 04:24:36','2022-12-21 04:24:36'),(77,66,0,'2',11,'2022-12-21 04:24:36','2022-12-21 04:24:36'),(78,67,0,'2',11,'2022-12-21 04:25:17','2022-12-21 04:25:17'),(79,68,0,'2',11,'2022-12-21 04:25:17','2022-12-21 04:25:17'),(80,69,0,'2',11,'2022-12-21 04:25:17','2022-12-21 04:25:17'),(81,70,0,'2',11,'2022-12-21 04:26:03','2022-12-21 04:26:03'),(82,71,0,'2',11,'2022-12-21 04:26:03','2022-12-21 04:26:03'),(83,72,0,'2',11,'2022-12-21 04:26:03','2022-12-21 04:26:03'),(84,73,0,'2',11,'2022-12-21 04:27:06','2022-12-21 04:27:06'),(85,74,0,'2',11,'2022-12-21 04:27:06','2022-12-21 04:27:06'),(86,75,0,'2',11,'2022-12-21 04:27:06','2022-12-21 04:27:06'),(87,76,0,'2',11,'2022-12-21 04:31:55','2022-12-21 04:31:55'),(88,77,0,'2',11,'2022-12-21 04:31:55','2022-12-21 04:31:55'),(89,78,0,'2',11,'2022-12-21 04:31:55','2022-12-21 04:31:55'),(90,79,0,'2',6,'2022-12-26 05:22:22','2022-12-26 05:22:22'),(91,80,0,'2',6,'2022-12-26 05:22:22','2022-12-26 05:22:22'),(92,81,0,'2',6,'2022-12-26 05:22:22','2022-12-26 05:22:22'),(93,82,0,'2',6,'2022-12-26 05:22:22','2022-12-26 05:22:22'),(94,83,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(95,84,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(96,85,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(97,86,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(98,87,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(99,88,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(100,89,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(101,90,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(102,91,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(103,92,0,'2',6,'2022-12-26 05:24:27','2022-12-26 05:24:27'),(104,93,0,'2',6,'2022-12-31 06:52:26','2022-12-31 06:52:26'),(105,94,0,'2',6,'2022-12-31 06:52:26','2022-12-31 06:52:26'),(106,95,0,'2',6,'2022-12-31 06:52:26','2022-12-31 06:52:26'),(107,96,0,'2',6,'2022-12-31 06:52:26','2022-12-31 06:52:26'),(108,97,0,'2',6,'2022-12-31 06:52:26','2022-12-31 06:52:26'),(109,98,0,'2',6,'2022-12-31 06:53:06','2022-12-31 06:53:06'),(110,99,0,'2',6,'2022-12-31 06:53:06','2022-12-31 06:53:06'),(111,100,0,'2',6,'2022-12-31 06:53:06','2022-12-31 06:53:06'),(112,101,0,'2',6,'2022-12-31 06:53:06','2022-12-31 06:53:06'),(113,102,0,'2',6,'2022-12-31 06:53:06','2022-12-31 06:53:06'),(114,103,0,'2',6,'2022-12-31 06:54:01','2022-12-31 06:54:01'),(115,104,0,'2',6,'2022-12-31 06:54:01','2022-12-31 06:54:01'),(116,105,0,'2',6,'2022-12-31 06:54:01','2022-12-31 06:54:01'),(117,106,0,'2',6,'2022-12-31 06:54:01','2022-12-31 06:54:01'),(118,107,0,'2',6,'2022-12-31 06:54:01','2022-12-31 06:54:01'),(119,108,0,'2',11,'2023-01-02 10:42:48','2023-01-02 10:42:48'),(120,109,0,'2',11,'2023-01-02 10:44:56','2023-01-02 10:44:56');
/*!40000 ALTER TABLE `product_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_logs` with 120 row(s)
--

--
-- Table structure for table `product_types`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_name` (`product_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `product_types` VALUES (2,'TOP'),(3,'TUNIK');
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_types` with 2 row(s)
--

--
-- Table structure for table `products`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color_id` int(8) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `price` int(30) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `size` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `qrcode` text,
  `hpp_jual` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pola_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `products` VALUES (2,113,NULL,NULL,9,NULL,1,NULL,211212,NULL,65,6,NULL,'2022-12-19 12:55:44','2022-12-19 12:55:44'),(3,0,NULL,0,0,NULL,2,NULL,NULL,NULL,87,11,NULL,'2022-12-19 14:04:57','2022-12-19 14:04:57'),(7,151,NULL,33000,1,NULL,2,NULL,NULL,NULL,65,11,NULL,'2022-12-20 12:57:37','2022-12-20 12:57:37'),(10,34,NULL,33000,15,NULL,2,NULL,NULL,NULL,65,11,NULL,'2022-12-20 12:59:01','2022-12-20 12:59:01'),(11,113,NULL,NULL,6,NULL,1,NULL,4000,NULL,78,6,NULL,'2022-12-21 11:05:17','2022-12-21 11:05:17'),(12,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:16:53','2022-12-21 11:16:53'),(13,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:16:53','2022-12-21 11:16:53'),(14,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:16:53','2022-12-21 11:16:53'),(15,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:17:32','2022-12-21 11:17:32'),(16,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:17:32','2022-12-21 11:17:32'),(17,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:17:32','2022-12-21 11:17:32'),(18,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:20:01','2022-12-21 11:20:01'),(19,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:20:01','2022-12-21 11:20:01'),(20,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:20:01','2022-12-21 11:20:01'),(21,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:20:45','2022-12-21 11:20:45'),(22,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:20:45','2022-12-21 11:20:45'),(23,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:20:45','2022-12-21 11:20:45'),(24,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:21:02','2022-12-21 11:21:02'),(25,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:21:02','2022-12-21 11:21:02'),(26,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:21:02','2022-12-21 11:21:02'),(27,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:21:38','2022-12-21 11:21:38'),(28,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:21:38','2022-12-21 11:21:38'),(29,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:21:38','2022-12-21 11:21:38'),(30,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:24:07','2022-12-21 11:24:07'),(31,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:24:07','2022-12-21 11:24:07'),(32,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:24:07','2022-12-21 11:24:07'),(33,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:24:36','2022-12-21 11:24:36'),(34,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:24:36','2022-12-21 11:24:36'),(35,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:24:36','2022-12-21 11:24:36'),(36,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:25:17','2022-12-21 11:25:17'),(37,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:25:17','2022-12-21 11:25:17'),(38,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:25:17','2022-12-21 11:25:17'),(39,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:26:03','2022-12-21 11:26:03'),(40,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:26:03','2022-12-21 11:26:03'),(41,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:26:03','2022-12-21 11:26:03'),(42,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:27:06','2022-12-21 11:27:06'),(43,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:27:06','2022-12-21 11:27:06'),(44,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:27:06','2022-12-21 11:27:06'),(45,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:31:55','2022-12-21 11:31:55'),(46,99,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:31:55','2022-12-21 11:31:55'),(47,76,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2022-12-21 11:31:55','2022-12-21 11:31:55'),(48,107,NULL,NULL,2,'S',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:22:22','2022-12-26 12:22:22'),(49,107,NULL,NULL,2,'M',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:22:22','2022-12-26 12:22:22'),(50,107,NULL,NULL,2,'S',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:24:27','2022-12-26 12:24:27'),(51,107,NULL,NULL,2,'M',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:24:27','2022-12-26 12:24:27'),(52,107,NULL,NULL,2,'L',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:24:27','2022-12-26 12:24:27'),(53,107,NULL,NULL,2,'XL',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:24:27','2022-12-26 12:24:27'),(54,107,NULL,NULL,2,'XXL',1,NULL,36000,NULL,69,6,NULL,'2022-12-26 12:24:27','2022-12-26 12:24:27'),(55,107,NULL,NULL,5,NULL,1,NULL,15000,NULL,73,6,NULL,'2022-12-31 13:52:26','2022-12-31 13:52:26'),(56,107,NULL,16000,5,NULL,1,NULL,16000,NULL,73,6,NULL,'2022-12-31 13:53:06','2022-12-31 13:53:06'),(58,34,NULL,16500,1,NULL,2,NULL,NULL,NULL,44,11,NULL,'2023-01-02 17:42:48','2023-01-02 17:42:48'),(59,34,NULL,16500,1,'L',2,NULL,NULL,NULL,44,11,NULL,'2023-01-02 17:44:56','2023-01-02 17:44:56');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `products` with 52 row(s)
--

--
-- Table structure for table `reject`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `category` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reject`
--

LOCK TABLES `reject` WRITE;
/*!40000 ALTER TABLE `reject` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `reject` VALUES (1,13,1,'noda perbaikan permanent','2022-12-19 05:59:40',NULL,3),(2,14,1,'jahit permanent','2022-12-19 05:59:45',NULL,3),(3,15,1,'permanent','2022-12-19 05:59:50',NULL,1),(5,30,1,'jahit permanent','2022-12-21 03:07:38',NULL,3),(6,31,1,'noda perbaikan','2022-12-21 03:18:47',NULL,2),(8,32,1,'noda perbaikan','2022-12-21 03:21:55',NULL,2),(9,32,1,'permanent','2022-12-21 03:22:06',NULL,1),(18,33,1,'noda perbaikan','2022-12-21 03:43:58',NULL,2);
/*!40000 ALTER TABLE `reject` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `reject` with 8 row(s)
--

--
-- Table structure for table `scan_so`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scan_so` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scan_so`
--

LOCK TABLES `scan_so` WRITE;
/*!40000 ALTER TABLE `scan_so` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `scan_so` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `scan_so` with 0 row(s)
--

--
-- Table structure for table `selling_vendors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `selling_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `selling_vendors`
--

LOCK TABLES `selling_vendors` WRITE;
/*!40000 ALTER TABLE `selling_vendors` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `selling_vendors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `selling_vendors` with 0 row(s)
--

--
-- Table structure for table `sellings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL DEFAULT 'LOVISH',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hpp_jual` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellings`
--

LOCK TABLES `sellings` WRITE;
/*!40000 ALTER TABLE `sellings` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `sellings` VALUES (1,2,65,151,NULL,1,'LOVISH','2022-12-19 06:59:52',NULL,3),(2,2,80,34,NULL,1,'LOVISH','2022-12-19 06:59:52',NULL,3),(3,NULL,86,46,NULL,1,'ODELIA','2022-12-19 06:59:52',NULL,3),(4,NULL,44,34,NULL,1,'LOVISH','2022-12-21 04:31:55',NULL,3),(5,NULL,44,99,NULL,1,'LOVISH','2022-12-21 04:31:55',NULL,3),(6,NULL,44,76,NULL,1,'LOVISH','2022-12-21 04:31:55',NULL,3),(7,NULL,44,152,'L',1,'LOVISH','2022-12-30 06:38:10',NULL,3),(8,NULL,44,153,'M',1,'LOVISH','2022-12-30 06:38:10',NULL,3),(9,NULL,44,154,'XL',1,'LOVISH','2022-12-30 06:38:10',NULL,3);
/*!40000 ALTER TABLE `sellings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `sellings` with 9 row(s)
--

--
-- Table structure for table `shipping_details`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_details`
--

LOCK TABLES `shipping_details` WRITE;
/*!40000 ALTER TABLE `shipping_details` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `shipping_details` VALUES (1,1,7),(2,1,8);
/*!40000 ALTER TABLE `shipping_details` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `shipping_details` with 2 row(s)
--

--
-- Table structure for table `shippings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shippings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `box_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resi` varchar(50) DEFAULT NULL,
  `qrcode` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resi` (`resi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shippings`
--

LOCK TABLES `shippings` WRITE;
/*!40000 ALTER TABLE `shippings` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `shippings` VALUES (1,'BOX-WBF4552','2022-12-19 07:23:28','2022-12-19 07:23:28','1159586991',NULL,1,0);
/*!40000 ALTER TABLE `shippings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `shippings` with 1 row(s)
--

--
-- Table structure for table `size`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cutting_id` int(11) DEFAULT NULL,
  `s` int(11) DEFAULT NULL,
  `m` int(11) DEFAULT NULL,
  `l` int(11) DEFAULT NULL,
  `xl` int(11) DEFAULT NULL,
  `xxl` int(11) DEFAULT NULL,
  `nosize` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `size`
--

LOCK TABLES `size` WRITE;
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `size` VALUES (4,19,2,2,2,2,2,NULL),(5,20,NULL,NULL,NULL,NULL,NULL,1),(6,21,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `size` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `size` with 3 row(s)
--

--
-- Table structure for table `so_replace`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `so_replace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `so_replace`
--

LOCK TABLES `so_replace` WRITE;
/*!40000 ALTER TABLE `so_replace` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `so_replace` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `so_replace` with 0 row(s)
--

--
-- Table structure for table `supplier_vendors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vendor` (`vendor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_vendors`
--

LOCK TABLES `supplier_vendors` WRITE;
/*!40000 ALTER TABLE `supplier_vendors` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `supplier_vendors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `supplier_vendors` with 0 row(s)
--

--
-- Table structure for table `tim_cutting`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tim_cutting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tim_cutting`
--

LOCK TABLES `tim_cutting` WRITE;
/*!40000 ALTER TABLE `tim_cutting` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `tim_cutting` VALUES (1,'NANA'),(2,'BUDI'),(3,'BEBE'),(4,'MOJAHIT'),(5,'MB'),(6,'ALTEX');
/*!40000 ALTER TABLE `tim_cutting` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `tim_cutting` with 6 row(s)
--

--
-- Table structure for table `tim_gelar`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tim_gelar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tim_gelar`
--

LOCK TABLES `tim_gelar` WRITE;
/*!40000 ALTER TABLE `tim_gelar` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `tim_gelar` VALUES (1,'NANA'),(2,'BUDI'),(3,'DIAN'),(4,'ADUL'),(5,'EWOK'),(6,'IHSAN'),(7,'FIKRI'),(8,'DADAN'),(9,'YUSUF');
/*!40000 ALTER TABLE `tim_gelar` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `tim_gelar` with 9 row(s)
--

--
-- Table structure for table `transactions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement-id` varchar(50) DEFAULT NULL,
  `settlement-start-date` varchar(50) DEFAULT NULL,
  `settlement-end-date` varchar(50) DEFAULT NULL,
  `total-amount` float DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `transaction-type` varchar(50) DEFAULT NULL,
  `order-id` varchar(50) DEFAULT NULL,
  `merchant-order-id` varchar(50) DEFAULT NULL,
  `adjustment-id` varchar(50) DEFAULT NULL,
  `shipment-id` varchar(50) DEFAULT NULL,
  `marketplace-name` varchar(50) DEFAULT NULL,
  `amount-type` varchar(50) DEFAULT NULL,
  `amount-description` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `fulfillment-id` varchar(50) DEFAULT NULL,
  `posted-date` date DEFAULT NULL,
  `posted-date-time` varchar(50) DEFAULT NULL,
  `order-item-code` varchar(50) DEFAULT NULL,
  `merchant-order-item-id` varchar(50) DEFAULT NULL,
  `merchant-adjustment-item-id` varchar(50) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `quantity-purchased` int(11) DEFAULT NULL,
  `promotion-id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `transactions` with 0 row(s)
--

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  `username` varchar(55) NOT NULL,
  `password` text NOT NULL,
  `role` enum('administrator','gudang_1','gudang_2','') NOT NULL,
  `accessibility` text,
  `photo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `users` VALUES (1,'admin','admin','$2y$10$PtOhVUMdrxXXMxa2ADilkOfTZopbEKMyv/UoS6nUi5A93dJ43/hbi','administrator',NULL,NULL),(6,'Gesit','gesit','$2y$10$XtqMCWbwjZ44Wi7GqOZl8.0XTljKBsAjTQl4HqoWqKiz6VZOEGouO','gudang_1','[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\"]',NULL),(11,'Gudang','gudang','$2y$10$GShNNckH7H4WMs2Z4hPIm.mJXpxsKc0Or/xlFzLHf16LuOBIOiYse','gudang_2','[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `users` with 3 row(s)
--

--
-- Table structure for table `vendor_pola`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor_pola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_pola`
--

LOCK TABLES `vendor_pola` WRITE;
/*!40000 ALTER TABLE `vendor_pola` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `vendor_pola` VALUES (1,'AR'),(2,'IP'),(3,'GF'),(4,'YD'),(5,'NN'),(6,'WD'),(7,'BB'),(8,'DS'),(9,'MOJAHIT');
/*!40000 ALTER TABLE `vendor_pola` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `vendor_pola` with 9 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Fri, 03 Feb 2023 06:45:30 +0700

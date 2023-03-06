-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: u1738102_smi
-- ------------------------------------------------------
-- Server version 	10.5.17-MariaDB-cll-lve
-- Date: Fri, 03 Feb 2023 13:55:30 +0700

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
  `roll` int(11) NOT NULL DEFAULT 1,
  `qrcode` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `price` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL DEFAULT 1,
  `tgl_cutting` timestamp NULL DEFAULT NULL,
  `gelar1` int(11) DEFAULT NULL,
  `gelar2` int(11) DEFAULT NULL,
  `pic_cutting` int(11) NOT NULL,
  `vendor_pola` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `materials` with 0 row(s)
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `logs` with 0 row(s)
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
-- Table structure for table `product_logs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `status` enum('1','2','3','4','5','0') DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_logs`
--

LOCK TABLES `product_logs` WRITE;
/*!40000 ALTER TABLE `product_logs` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `product_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_logs` with 0 row(s)
--

--
-- Table structure for table `so_replace`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `so_replace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
-- Table structure for table `product_barcodes`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_barcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qrcode` text DEFAULT NULL,
  `status` enum('1','2','3','0','4','5','6') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_barcodes`
--

LOCK TABLES `product_barcodes` WRITE;
/*!40000 ALTER TABLE `product_barcodes` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `product_barcodes` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `product_barcodes` with 0 row(s)
--

--
-- Table structure for table `log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `accessibility` text DEFAULT NULL,
  `photo` text DEFAULT NULL,
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
-- Table structure for table `shipping_details`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_details`
--

LOCK TABLES `shipping_details` WRITE;
/*!40000 ALTER TABLE `shipping_details` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `shipping_details` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `shipping_details` with 0 row(s)
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
  `qr` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `tanggal_jual` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penjualan_reject`
--

LOCK TABLES `penjualan_reject` WRITE;
/*!40000 ALTER TABLE `penjualan_reject` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `penjualan_reject` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `penjualan_reject` with 0 row(s)
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

--
-- Table structure for table `pola`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cutting_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `tgl_ambil` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jumlah_pola` int(11) NOT NULL,
  `tgl_setor` timestamp NOT NULL DEFAULT current_timestamp(),
  `jumlah_setor` int(11) NOT NULL,
  `reject` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pola`
--

LOCK TABLES `pola` WRITE;
/*!40000 ALTER TABLE `pola` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `pola` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `pola` with 0 row(s)
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
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_stok`
--

LOCK TABLES `history_stok` WRITE;
/*!40000 ALTER TABLE `history_stok` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `history_stok` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `history_stok` with 0 row(s)
--

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
-- Table structure for table `material_patterns`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_patterns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `user_id_in` int(11) DEFAULT NULL,
  `user_id_out` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
INSERT INTO `colors` VALUES (63,'1 WHITE'),(60,'12 ROSE'),(61,'36 CARAMEL'),(57,'40 ALMOND'),(59,'52 MAUVE'),(62,'64 GREEN WOOD'),(56,'67 AQUA BLUE'),(58,'72 PLUM'),(54,'76 SAGE GREEN'),(55,'9 PEACH'),(51,'ABU'),(95,'ABU TUA'),(78,'ALMOND'),(69,'ANGGUR'),(36,'ARMY'),(76,'AVOCADO'),(38,'BATA'),(45,'BEIGE'),(73,'BISCUIT'),(70,'BLACK'),(79,'BROKEN WHITE'),(71,'BUTTER'),(94,'CLEAN WHITE'),(49,'COKLAT'),(42,'COKSU'),(107,'COPRA'),(96,'CREAM'),(112,'DARK SALMON'),(46,'DENIM'),(48,'DUSTY'),(74,'DUSTY PINK'),(64,'DUSTY ROSE'),(115,'FLAMINGO'),(67,'GREY'),(68,'HIJAU OLIVE'),(33,'HITAM'),(89,'HJ OLIVE'),(105,'HJ TKD'),(116,'HONEY'),(111,'IVORY'),(97,'KIWI'),(40,'KUBUS'),(81,'KUBUS GELAP'),(65,'LATTE'),(53,'LILAC'),(155,'LOVISH'),(34,'MAROON'),(72,'MATCHA'),(50,'MILO'),(37,'MINT'),(44,'MOCCA'),(110,'MOSS'),(35,'NAVY'),(99,'NUDE'),(43,'OCEAN'),(100,'ORCHID'),(82,'OXBLOOD'),(41,'PINK VARIO'),(47,'PURPLE'),(39,'SALMON'),(98,'SILVER'),(75,'TARO'),(52,'TWO TONE'),(101,'WALNUT'),(66,'WARDAH'),(151,'YELLOWFISH'),(113,'YELLOWISH');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `colors` with 67 row(s)
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
-- Table structure for table `cutting`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cutting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `model_id` int(11) DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) DEFAULT NULL,
  `berat` float DEFAULT NULL,
  `sisa` int(11) NOT NULL DEFAULT 0,
  `biaya_gelar1` int(11) DEFAULT NULL,
  `biaya_gelar2` int(11) DEFAULT NULL,
  `biaya_cutting` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `harga_gelar` int(11) DEFAULT 0,
  `harga_cutting` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `gelar1` int(11) DEFAULT NULL,
  `gelar2` int(11) DEFAULT NULL,
  `pic` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cutting`
--

LOCK TABLES `cutting` WRITE;
/*!40000 ALTER TABLE `cutting` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `cutting` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `cutting` with 0 row(s)
--

--
-- Table structure for table `scan_so`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scan_so` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1,
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
-- Table structure for table `shippings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shippings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `box_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resi` varchar(50) DEFAULT NULL,
  `qrcode` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resi` (`resi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shippings`
--

LOCK TABLES `shippings` WRITE;
/*!40000 ALTER TABLE `shippings` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `shippings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `shippings` with 0 row(s)
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hpp_jual` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellings`
--

LOCK TABLES `sellings` WRITE;
/*!40000 ALTER TABLE `sellings` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `sellings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `sellings` with 0 row(s)
--

--
-- Table structure for table `reject`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `category` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reject`
--

LOCK TABLES `reject` WRITE;
/*!40000 ALTER TABLE `reject` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `reject` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `reject` with 0 row(s)
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
  `qty` int(11) NOT NULL DEFAULT 1,
  `size` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `qrcode` text DEFAULT NULL,
  `hpp_jual` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pola_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `products` with 0 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Fri, 03 Feb 2023 13:55:30 +0700

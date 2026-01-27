-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: finalproject_app
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'arenold','Doctor@gmail.com',NULL,'$2y$12$Jj3QD1gIa1KxJCyCI.5daewh.81pWifGGiWChkVDZXqPmIUHXhkJu',NULL,'2026-01-12 20:18:53','2026-01-12 20:53:21','Doctor','active'),(7,'Game','Admin@gmail.com',NULL,'$2y$12$HyPohyOG8YQ6eSGGNTbna.6pnbwkRoIKZ3Jn.7fs8HeYQEnGplbVG',NULL,'2026-01-12 20:28:08','2026-01-12 20:53:05','admin','active'),(8,'GOD','Staff@gmail.com',NULL,'$2y$12$TscjTBpo9gB2LUwWNUNgPOSHF.E5CAqrosoM3xfmbBSvboMac1r4e',NULL,'2026-01-12 20:30:48','2026-01-12 20:53:01','Staff','active'),(9,'GameStoreBot','patient@2gmail.com',NULL,'$2y$12$6Tx87kpNN7zfnusaMK7w3O6xHkVkDKjUSfituv0.YdPWMTbG8daIa',NULL,'2026-01-12 20:31:20','2026-01-12 20:52:55','Patient','active'),(10,'God','Doctor2@gmail.com',NULL,'$2y$12$EetSWqm9.uo6oamzIWeo/ObLw41XYzWRvzuUK7AbU3Kbe98SwsseO',NULL,'2026-01-19 20:22:34','2026-01-19 20:22:34','Doctor','active'),(11,'Luck','Doctor3@gmail.com',NULL,'$2y$12$Q2V0Tfw2RVCC01zfhSqeku6f6lU593PE5RhbpjOBAV1N0FkJCpkdS',NULL,'2026-01-19 20:23:09','2026-01-19 20:23:09','Doctor','active');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-27 12:32:38

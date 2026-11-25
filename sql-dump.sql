/*M!999999\- enable the sandbox mode */
-- MariaDB dump 10.19-11.7.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gestion_afiliados
-- ------------------------------------------------------
-- Server version	8.0.30
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;

/*!40103 SET TIME_ZONE='+00:00' */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `afiliados`
--
DROP TABLE IF EXISTS `afiliados`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `afiliados` (
    `nombres` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
    `aPaterno` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
    `aMaterno` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
    `curp` varchar(18) COLLATE utf8mb4_spanish_ci NOT NULL,
    `cveElector` varchar(18) COLLATE utf8mb4_spanish_ci NOT NULL,
    `domicilio` text COLLATE utf8mb4_spanish_ci NOT NULL,
    `seccion` varchar(5) COLLATE utf8mb4_spanish_ci NOT NULL,
    `ineVigencia` int NOT NULL,
    `casilla` varchar(15) CHARACTER
    SET
      utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
      `numLista` int DEFAULT NULL,
      `idPromotor` int NOT NULL,
      `idUsuario` int NOT NULL,
      `fechaRegistro` datetime NOT NULL,
      `estado` int DEFAULT '1',
      `fechaUpdate` datetime DEFAULT NULL,
      `fotoIne` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
      PRIMARY KEY (`curp`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `afiliados`
--
LOCK TABLES `afiliados` WRITE;

/*!40000 ALTER TABLE `afiliados` DISABLE KEYS */;

INSERT INTO
  `afiliados`
VALUES
  (
    'ROBERTO CARLOS',
    'CARDONA',
    'DOMINGUEZ',
    'DOCR000415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0435',
    2027,
    'BASICA',
    NULL,
    1,
    1,
    '2026-11-22 12:55:47',
    1,
    NULL,
    'docs/DOCR000415MDFRRN09.png'
  ),
  (
    'LOURDES',
    'GOMEZ',
    'HERNÁNDEZ',
    'HEGL900415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0434',
    2027,
    'BASICA',
    NULL,
    5,
    1,
    '2026-11-22 12:54:25',
    1,
    NULL,
    'docs/HEGL900415MDFRRN09.png'
  ),
  (
    'HUMBERTO',
    'LORENZO',
    'HERNÁNDEZ',
    'HELH810415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0433',
    2027,
    'CONTIGUA 1',
    NULL,
    5,
    1,
    '2026-11-22 13:39:40',
    1,
    NULL,
    'docs/HELH810415MDFRRN09.png'
  ),
  (
    'GORGONIO',
    'PEREZ',
    'HERNÁNDEZ',
    'HEPG780415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0434',
    2027,
    'CONTIGUA 1',
    NULL,
    6,
    1,
    '2026-11-22 12:43:52',
    1,
    NULL,
    'docs/HEPG780415MDFRRN09.png'
  ),
  (
    'PEDRO',
    'PEREZ',
    'MENDEZ',
    'MEPP870415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0434',
    2027,
    'CONTIGUA 1',
    NULL,
    2,
    1,
    '2026-11-22 12:40:32',
    1,
    NULL,
    'docs/MEPP870415MDFRRN09.jpeg'
  ),
  (
    'BRENDA',
    'RAMIREZ',
    'PEREZ',
    'PEBM880415MDFRTO10',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0435',
    2027,
    'CONTIGUA 2',
    NULL,
    6,
    1,
    '2026-11-22 12:38:36',
    1,
    NULL,
    'docs/PEBM880415MDFRTO10.jpeg'
  ),
  (
    'JESUS',
    'PEREZ',
    'MENDEZ',
    'PEMJ960415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0433',
    2027,
    'CONTIGUA 1',
    NULL,
    1,
    1,
    '2026-11-22 12:53:35',
    1,
    NULL,
    'docs/PEMJ960415MDFRRN09.jpeg'
  ),
  (
    'JOSE',
    'TORRES',
    'PEREZ',
    'PETJ880415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0435',
    2027,
    'CONTIGUA 2',
    NULL,
    2,
    1,
    '2026-11-22 12:41:37',
    1,
    NULL,
    'docs/PETJ880415MDFRRN09.jpeg'
  ),
  (
    'MARÍA ELENA',
    'RODRÍGUEZ',
    'HERNÁNDEZ',
    'ROHM880415MDFRRH09',
    'RDHEMR88041509M300',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0433',
    2027,
    'CONTIGUA 2',
    NULL,
    1,
    1,
    '2026-11-22 12:35:17',
    1,
    NULL,
    'docs/ROHM880415MDFRRH09.jpeg'
  ),
  (
    'MARÍA JOSE',
    'RODRÍGUEZ',
    'HERNÁNDEZ',
    'ROHM880415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0434',
    2027,
    'CONTIGUA 2',
    NULL,
    1,
    1,
    '2026-11-22 12:33:17',
    1,
    NULL,
    'docs/ROHM880415MDFRRN09.jpeg'
  ),
  (
    'MARIO ANTONIO',
    'LOPEZ',
    'RODRIGUEZ',
    'ROLM740415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0433',
    2027,
    'CONTIGUA 1',
    NULL,
    2,
    1,
    '2026-11-22 12:52:19',
    1,
    NULL,
    'docs/ROLM740415MDFRRN09.png'
  ),
  (
    'ROSARIO',
    'BARRIENTOS',
    'TORRES',
    'TOBR880415MDFRRN09',
    'RDHEMR88041509M200',
    'AV. INSURGENTES SUR 1602, CRÉDITO CONSTRUCTOR, BENITO JUÁREZ, CIUDAD DE MÉXICO, C.P. 03940',
    '0435',
    2027,
    'BASICA',
    NULL,
    2,
    1,
    '2026-11-22 12:49:24',
    1,
    NULL,
    'docs/TOBR880415MDFRRN09.png'
  );

/*!40000 ALTER TABLE `afiliados` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `promotores`
--
DROP TABLE IF EXISTS `promotores`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `promotores` (
    `idPromotor` int NOT NULL AUTO_INCREMENT,
    `nombres` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
    `aPaterno` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
    `aMaterno` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
    `fechaRegistro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `idUsuario` int NOT NULL,
    `estado` int DEFAULT '1',
    `telefono` varchar(10) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
    PRIMARY KEY (`idPromotor`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_spanish_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotores`
--
LOCK TABLES `promotores` WRITE;

/*!40000 ALTER TABLE `promotores` DISABLE KEYS */;

INSERT INTO
  `promotores`
VALUES
  (
    1,
    'EVER',
    'LOPEZ',
    'MARTINEZ',
    '2026-11-21 22:13:34',
    1,
    1,
    '9921098775'
  ),
  (
    2,
    'JESUS MANUEL',
    'PEREZ',
    'GOMEZ',
    '2026-11-22 09:38:07',
    1,
    1,
    '9921088977'
  ),
  (
    5,
    'DAIRA JARENNY',
    'LOPEZ',
    'GOMEZ',
    '2026-11-22 10:24:21',
    1,
    1,
    '9182736450'
  ),
  (
    6,
    'CECILA',
    'SANTOS',
    'MENDOZA',
    '2026-11-22 10:37:02',
    1,
    1,
    '9182736450'
  );

/*!40000 ALTER TABLE `promotores` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--
DROP TABLE IF EXISTS `usuarios`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!40101 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `usuarios` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Clave de promotor ej. PM-0104 o usuario',
    `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rol` enum ('admin', 'promotor', 'supervisor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'promotor',
    `estado` tinyint (1) NOT NULL DEFAULT '1',
    `creado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `actualizado_el` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `usuario` (`usuario`),
    UNIQUE KEY `email` (`email`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--
LOCK TABLES `usuarios` WRITE;

/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO
  `usuarios`
VALUES
  (
    1,
    'ever2812@gmail.com',
    'Ever Lopez',
    'ever2812@gmail.com',
    '$2y$10$9YBAQVkzspz/Q7jtRQvwD.vmgazSv6IiqOgolexyPgIhP.s0CHAuG',
    'admin',
    1,
    '2026-11-10 20:44:10',
    '2026-11-10 20:44:10'
  );

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Dumping routines for database 'gestion_afiliados'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-11-25 17:55:05
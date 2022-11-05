-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 5.7.33 - MySQL Community Server (GPL)
-- OS Server:                    Win64
-- HeidiSQL Versi:               11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- membuang struktur untuk table jwt.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel jwt.user: ~4 rows (lebih kurang)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `created_at`, `password`, `email`, `name`, `role`) VALUES
	(8, '2022-11-04 04:03:01', '$2y$10$UxVSWW3Olk8KYbhbtlsrwuoxDW4E.lGYAOGPcjlFVNF5zRPBiKPxC', 'oman@gmail.com', 'oman surahman', 'admin');
INSERT INTO `user` (`id_user`, `created_at`, `password`, `email`, `name`, `role`) VALUES
	(18, '2022-11-05 01:21:17', '$2y$10$klTGXqAROJl.bpR.YLyCtuIJbvL6Lf2/zOZaIdtzHOstAme8bfzBC', 'rohmandedeh27@gmail.com', 'Abdul rohman', 'admin');
INSERT INTO `user` (`id_user`, `created_at`, `password`, `email`, `name`, `role`) VALUES
	(20, '2022-11-05 01:43:07', '$2y$10$fyZ3qcZubOXJABbivx3E0Ohyr5hraeQEIgfgxpZrP3pInEbBzAFT2', 'jujun@gmail.com', 'jujun', 'user');
INSERT INTO `user` (`id_user`, `created_at`, `password`, `email`, `name`, `role`) VALUES
	(21, '2022-11-05 01:43:27', '$2y$10$79eWRCLTqQurGUJKbIez2un16EJ8OOCw8cBYfp47Ata4v4jzJjOaq', 'udin2@gmail.com', 'udin samsudiiin', 'user');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.4.28-MariaDB : Database - web_si
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `barang` */

CREATE DATABASE /*!32312 IF NOT EXISTS*/`web_si_usr` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `web_si_usr`;

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `foto` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `barang` */

insert  into `barang`(`id`,`nama`,`harga`,`jumlah`,`keterangan`,`foto`) values (1,'Indomie Goreng',2500,50,'Indomie Seleraku','indomie-mi-goreng-special_detail_094906814 (1).png'),(2,'Sari Roti Kismis',5000,100,'Roti Single','roti_tawar_raisin1.jpg'),(3,'Susu Ultra',5000,100,'Susu UHT','e31f03c4-8216-425d-8279-b7cee6e75cf8.jpg'),(4,'Dji Sam Soe Refill',20000,24,'Ududnya Orang NU','dji-sam-soe-234-premium-12-285587.jpg'),(8,'test barang',555,1000,'123','1c.png');

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `ongkir` double DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi` */

insert  into `transaksi`(`id`,`username`,`total_harga`,`alamat`,`ongkir`,`status`,`created_by`,`created_date`) values (1,'danny',12500,NULL,NULL,NULL,'danny','2023-06-19 05:00:43');

/*Table structure for table `transaksi_detail` */

DROP TABLE IF EXISTS `transaksi_detail`;

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `subtotal_harga` double DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaksi_detail` */

insert  into `transaksi_detail`(`id`,`id_transaksi`,`id_barang`,`jumlah`,`diskon`,`subtotal_harga`,`created_by`,`created_date`) values (1,1,1,1,0,2500,'danny','2023-06-19 05:00:43'),(2,1,2,1,0,5000,'danny','2023-06-19 05:00:43'),(3,1,3,1,0,5000,'danny','2023-06-19 05:00:43');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`role`,`password`) values (1,'danny','Super Admin','ac43724f16e9241d990427ab7c8f4228'),(2,'oka','Admin','ac43724f16e9241d990427ab7c8f4228'),(3,'ratmana','User','ac43724f16e9241d990427ab7c8f4228');

/* Procedure structure for procedure `sp_ins_transaksi` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_ins_transaksi` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ins_transaksi`(
    IN p_username VARCHAR(255),
    IN p_total_harga DECIMAL(10, 2),
    IN p_id_barang INT,
    IN p_jumlah INT,
    IN p_diskon DECIMAL(10, 2),
    IN p_created_by VARCHAR(255)
    )
BEGIN
	    -- Variabel untuk menyimpan ID transaksi yang baru saja disimpan
	    DECLARE v_id_transaksi INT;
	    -- Insert data ke tabel transaksi
	    INSERT INTO transaksi (username, total_harga, created_by, created_date)
	    VALUES (p_username, p_total_harga, p_created_by, NOW());
	    -- Mendapatkan ID transaksi yang baru saja disimpan
	    SET v_id_transaksi = LAST_INSERT_ID();
	    -- Insert data ke tabel transaksi_detail
	    INSERT INTO transaksi_detail (id_transaksi, id_barang, jumlah, diskon, subtotal_harga, created_by, created_date)
	    VALUES (v_id_transaksi, p_id_barang, p_jumlah, p_diskon, (p_jumlah * (SELECT harga FROM barang WHERE id = p_id_barang) - p_diskon), p_created_by, NOW());
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

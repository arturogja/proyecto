/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.3.23-MariaDB-log : Database - db_proyecto
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_proyecto` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_proyecto`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `second_last_name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`last_name`,`second_last_name`,`phone`,`email`,`password`,`created_at`,`deleted_at`) values (1,'Pedro','Doe','Smith','1234567890','john.doe@example.com','$2b$12$YxiAM.gynMxpfKb8ZPSjZeFVEDbH9gcjDvTJucbni2jHvg2NWmb4G','2024-01-01 10:00:00',NULL),(2,'Jane','Smith','Taylor','0987654321','jane.smith@example.com','$2b$12$YxiAM.gynMxpfKb8ZPSjZeFVEDbH9gcjDvTJucbni2jHvg2NWmb4G','2024-01-02 12:00:00',NULL),(4,'Arturo','Guillen','Jimenez','2281900810','arturo.gja@hotmail.com','$2b$12$YxiAM.gynMxpfKb8ZPSjZeFVEDbH9gcjDvTJucbni2jHvg2NWmb4G','2024-11-08 14:09:19',NULL),(5,'EDUARDO','CRUZ','FERNANDEZ','2281923334','alturo2803@gmail.com','$2b$12$YxiAM.gynMxpfKb8ZPSjZeFVEDbH9gcjDvTJucbni2jHvg2NWmb4G','2024-11-08 14:27:40',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

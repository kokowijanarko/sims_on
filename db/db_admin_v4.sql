/*
SQLyog Ultimate v10.41 
MySQL - 5.5.5-10.1.9-MariaDB : Database - db_admin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `db_admin`;

/*Table structure for table `cash_order` */

DROP TABLE IF EXISTS `cash_order`;

CREATE TABLE `cash_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(100) DEFAULT NULL,
  `order_custommer_name` varchar(100) DEFAULT NULL,
  `order_address` text,
  `order_contact` char(20) DEFAULT NULL,
  `order_email` varchar(100) DEFAULT NULL,
  `order_date_order` date DEFAULT NULL,
  `order_date_design` date DEFAULT NULL,
  `order_date_take` date DEFAULT NULL,
  `order_down_payment` int(11) DEFAULT NULL,
  `order_cash_minus` int(11) DEFAULT NULL,
  `order_amount` int(11) DEFAULT NULL,
  `order_payment_way` tinyint(4) DEFAULT NULL COMMENT '0 = nota order, 1 = nota pelunasan',
  `order_status` tinyint(4) DEFAULT NULL,
  `order_type` tinyint(1) DEFAULT NULL,
  `insert_user_id` int(11) DEFAULT NULL,
  `insert_timestamp` timestamp NULL DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `insert_user_id` (`insert_user_id`),
  CONSTRAINT `cash_order_ibfk_1` FOREIGN KEY (`insert_user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order` */

/*Table structure for table `cash_order_detail` */

DROP TABLE IF EXISTS `cash_order_detail`;

CREATE TABLE `cash_order_detail` (
  `orderdetail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orderdetail_order_id` int(100) DEFAULT NULL,
  `orderdetail_product_id` int(11) DEFAULT NULL,
  `orderdetail_quantity` int(11) DEFAULT NULL,
  `orderdetail_desc` text,
  `orderdetail_user_id` int(11) DEFAULT NULL,
  `orderdetail_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderdetail_id`),
  KEY `orderdetail_order_id` (`orderdetail_order_id`),
  KEY `orderdetail_product_id` (`orderdetail_product_id`),
  KEY `orderdetail_user_id` (`orderdetail_user_id`),
  CONSTRAINT `cash_order_detail_ibfk_1` FOREIGN KEY (`orderdetail_order_id`) REFERENCES `cash_order` (`order_id`),
  CONSTRAINT `cash_order_detail_ibfk_2` FOREIGN KEY (`orderdetail_product_id`) REFERENCES `inv_inventory` (`inv_id`),
  CONSTRAINT `cash_order_detail_ibfk_3` FOREIGN KEY (`orderdetail_user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order_detail` */

/*Table structure for table `inv_inventory` */

DROP TABLE IF EXISTS `inv_inventory`;

CREATE TABLE `inv_inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_name` varchar(100) DEFAULT NULL,
  `inv_type_id` int(11) DEFAULT NULL,
  `inv_category_id` int(11) DEFAULT NULL,
  `inv_price` int(11) DEFAULT NULL,
  `inv_stock` int(11) DEFAULT NULL,
  `inv_desc` text,
  PRIMARY KEY (`inv_id`),
  KEY `inv_type_id` (`inv_type_id`),
  KEY `inv_category_id` (`inv_category_id`),
  CONSTRAINT `inv_inventory_ibfk_1` FOREIGN KEY (`inv_type_id`) REFERENCES `inv_ref_inventory_type` (`type_id`),
  CONSTRAINT `inv_inventory_ibfk_2` FOREIGN KEY (`inv_category_id`) REFERENCES `inv_ref_inventory_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `inv_inventory` */

insert  into `inv_inventory`(`inv_id`,`inv_name`,`inv_type_id`,`inv_category_id`,`inv_price`,`inv_stock`,`inv_desc`) values (2,'Kaos sablon warna',1,1,34000,122,'ceking adjah'),(3,'Kaos Sablon Emas dua',2,1,800000,23,'cek cek'),(5,'Mug Mug Mboh',3,2,65000,23,'adasdasd'),(6,'Kaos Pin A',4,1,3400000,12,'asdasdasd'),(8,'Gantungan Kunci aja',4,3,65000,42,'adasdasd');

/*Table structure for table `inv_ref_inventory_category` */

DROP TABLE IF EXISTS `inv_ref_inventory_category`;

CREATE TABLE `inv_ref_inventory_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `category_code` char(5) DEFAULT NULL,
  `category_desc` text,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `inv_ref_inventory_category` */

insert  into `inv_ref_inventory_category`(`category_id`,`category_name`,`category_code`,`category_desc`) values (1,'Kaos','K',NULL),(2,'Mug','Mg',NULL),(3,'Gantungan Kunci','GK',NULL),(4,'Pin','PN',NULL);

/*Table structure for table `inv_ref_inventory_type` */

DROP TABLE IF EXISTS `inv_ref_inventory_type`;

CREATE TABLE `inv_ref_inventory_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) DEFAULT NULL,
  `type_code` char(5) DEFAULT NULL,
  `type_category_id` int(11) DEFAULT NULL,
  `type_desc` text,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `inv_ref_inventory_type` */

insert  into `inv_ref_inventory_type`(`type_id`,`type_name`,`type_code`,`type_category_id`,`type_desc`) values (1,'sablon warna','SW',1,NULL),(2,'Sablon Emas','SE',1,NULL),(3,'Mug Mboh','MB',2,NULL),(4,'Pin A','PNA',3,NULL),(5,'Pin B','PNB',3,NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_full_name` varchar(100) DEFAULT NULL,
  `user_username` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_level_id` int(11) DEFAULT NULL,
  `user_desc` text,
  `user_photo_path` text,
  `user_photo_name` varchar(100) DEFAULT NULL,
  `user_last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_level_id` (`user_level_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_level_id`) REFERENCES `user_ref_level` (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`user_full_name`,`user_username`,`user_password`,`user_email`,`user_level_id`,`user_desc`,`user_photo_path`,`user_photo_name`,`user_last_login`) values (1,'root','root','63a9f0ea7bb98050796b649e85481845','surya@sur.ya',NULL,'',NULL,'root-1.jpeg','2016-09-28 23:09:04'),(2,'admin','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.admin',2,NULL,NULL,NULL,'2016-09-27 02:05:35'),(3,'cashier','cashier','6ac2470ed8ccf204fd5ff89b32a355cf','cashier.cash.ier',3,'',NULL,'cashier-3.jpeg','2016-08-04 20:07:20'),(5,'Lele','lele','69bfc4ef467b367e3515cdcf693e65db','lele',3,'asdasdasdas',NULL,'Lele-3.jpeg','2016-07-08 12:09:06'),(6,'cek','cek','6ab97dc5c706cfdc425ca52a65d97b0d','cek@cek.com',3,'',NULL,'cek-3.jpeg',NULL);

/*Table structure for table `user_ref_level` */

DROP TABLE IF EXISTS `user_ref_level`;

CREATE TABLE `user_ref_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(100) DEFAULT NULL,
  `level_desc` text,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `user_ref_level` */

insert  into `user_ref_level`(`level_id`,`level_name`,`level_desc`) values (1,'root',NULL),(2,'admin',NULL),(3,'cashier',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

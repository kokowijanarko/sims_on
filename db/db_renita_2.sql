/*
SQLyog Ultimate v10.41 
MySQL - 5.6.17 : Database - db_renita
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_renita` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_renita`;

/*Table structure for table `inv_ref_inventory_category` */

DROP TABLE IF EXISTS `inv_ref_inventory_category`;

CREATE TABLE `inv_ref_inventory_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `category_code` char(5) DEFAULT NULL,
  `category_desc` text,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `inv_ref_inventory_category` */

insert  into `inv_ref_inventory_category`(`category_id`,`category_name`,`category_code`,`category_desc`) values (1,'Keramik','KR',NULL),(2,'Mug','MG',NULL),(3,'Gantungan Kunci','GK',NULL),(4,'Pin','PN',NULL),(5,'Jam','JK',NULL),(6,'Poster','PT',NULL),(7,'Pulpen','PL',NULL),(8,'Bantal','BN',NULL);

/*Table structure for table `inv_ref_inventory_type` */

DROP TABLE IF EXISTS `inv_ref_inventory_type`;

CREATE TABLE `inv_ref_inventory_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) DEFAULT NULL,
  `type_code` char(5) DEFAULT NULL,
  `type_category_id` int(11) DEFAULT NULL,
  `type_desc` text,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `inv_ref_inventory_type` */

insert  into `inv_ref_inventory_type`(`type_id`,`type_name`,`type_code`,`type_category_id`,`type_desc`) values (2,'Keramik Digital','KRD',1,NULL),(3,'Mug Digital','MGD',2,NULL),(4,'Pin Glossy','PNA',4,NULL),(5,'Pin Doff','PNB',4,NULL),(6,'Jam Dinding','JD',5,NULL),(7,'Jam Keramik','JK',5,NULL),(8,'Pulpen Digital','PTD',7,NULL);

/*Table structure for table `user_ref_level` */

DROP TABLE IF EXISTS `user_ref_level`;

CREATE TABLE `user_ref_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(100) DEFAULT NULL,
  `level_desc` text,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user_ref_level` */

insert  into `user_ref_level`(`level_id`,`level_name`,`level_desc`) values (1,'root',NULL),(2,'admin',NULL),(3,'cashier',NULL),(4,'owner',NULL);

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
  PRIMARY KEY (`user_id`),
  KEY `user_level_id` (`user_level_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_level_id`) REFERENCES `user_ref_level` (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`user_full_name`,`user_username`,`user_password`,`user_email`,`user_level_id`,`user_desc`,`user_photo_path`,`user_photo_name`) values (1,'root','root','63a9f0ea7bb98050796b649e85481845','root@root.id',1,'',NULL,'root-1.jpeg'),(2,'admin','admin','21232f297a57a5a743894a0e4a801fc3','admin@admin.admin',2,'',NULL,'admin-2.jpeg'),(3,'Renita Juliansasi','rere','c7911af3adbd12a035b289556d96470a','juliantrere@yahoo.com',3,'',NULL,'Renita Juliansasi-3.jpeg'),(4,'owner','owner','72122ce96bfec66e2396d2e25225d70a','',4,'',NULL,'owner-4.jpeg');

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
  `order_retur` int(11) DEFAULT NULL,
  `insert_user_id` int(11) DEFAULT NULL,
  `insert_timestamp` timestamp NULL DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `insert_user_id` (`insert_user_id`),
  CONSTRAINT `cash_order_ibfk_1` FOREIGN KEY (`insert_user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order` */

insert  into `cash_order`(`order_id`,`order_code`,`order_custommer_name`,`order_address`,`order_contact`,`order_email`,`order_date_order`,`order_date_design`,`order_date_take`,`order_down_payment`,`order_cash_minus`,`order_amount`,`order_payment_way`,`order_status`,`order_type`,`order_retur`,`insert_user_id`,`insert_timestamp`,`update_user_id`,`update_timestamp`) values (3,'INV.1/04/Oct/2016','rere','jogja','0987-6543-21','rere@yahoo.com','2016-10-04','2016-10-04','2016-10-10',0,0,65000,0,0,NULL,NULL,1,'2016-10-04 02:24:19',NULL,NULL),(4,'INV.1/06/Oct/2016','andi','jogja','0987-6543-21','andi.maniez@yahoo.com','2016-10-06','2016-10-06','2016-10-10',40000,0,38000,0,1,NULL,10000,1,'2016-10-06 16:44:33',1,'2016-10-06 16:52:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `inv_inventory` */

insert  into `inv_inventory`(`inv_id`,`inv_name`,`inv_type_id`,`inv_category_id`,`inv_price`,`inv_stock`,`inv_desc`) values (2,'Keramik 20x20',2,1,27000,20,''),(8,'Pin 4,4',4,4,4000,200,''),(9,'Jam Imut',6,5,48000,19,'untuk warna frame jam dicek dulu '),(10,'Mug Putih Standar',3,2,25000,200,''),(11,'Jam Kitchen',6,5,48000,20,'Frame hanya tersedia warna putih dan hitam'),(12,'Jam Besar',6,5,65000,15,'warna frame mix');

/*Table structure for table `cash_order_detail` */

DROP TABLE IF EXISTS `cash_order_detail`;

CREATE TABLE `cash_order_detail` (
  `orderdetail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orderdetail_order_id` int(100) DEFAULT NULL,
  `orderdetail_product_id` int(11) DEFAULT NULL,
  `orderdetail_quantity` int(11) DEFAULT NULL,
  `orderdetail_desc` text,
  PRIMARY KEY (`orderdetail_id`),
  KEY `orderdetail_order_id` (`orderdetail_order_id`),
  KEY `orderdetail_product_id` (`orderdetail_product_id`),
  CONSTRAINT `cash_order_detail_ibfk_1` FOREIGN KEY (`orderdetail_order_id`) REFERENCES `cash_order` (`order_id`),
  CONSTRAINT `cash_order_detail_ibfk_2` FOREIGN KEY (`orderdetail_product_id`) REFERENCES `inv_inventory` (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order_detail` */

insert  into `cash_order_detail`(`orderdetail_id`,`orderdetail_order_id`,`orderdetail_product_id`,`orderdetail_quantity`,`orderdetail_desc`) values (3,3,8,1,''),(4,4,9,1,'warna frame merah');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

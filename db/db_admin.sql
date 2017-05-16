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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_admin` /*!40100 DEFAULT CHARACTER SET latin1 */;

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
  `order_payment_way` tinyint(4) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `insert_user_id` int(11) DEFAULT NULL,
  `insert_timestamp` timestamp NULL DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order` */

insert  into `cash_order`(`order_id`,`order_code`,`order_custommer_name`,`order_address`,`order_contact`,`order_email`,`order_date_order`,`order_date_design`,`order_date_take`,`order_down_payment`,`order_cash_minus`,`order_amount`,`order_payment_way`,`order_status`,`insert_user_id`,`insert_timestamp`,`update_user_id`,`update_timestamp`) values (2,'INV.1/25/Jun/2016','koko','alamat koko','0998676436434','koko@ko.ko','2016-06-25','2016-06-25','2016-06-06',127,465000,3465000,0,0,1,'2016-06-25 21:09:58',NULL,NULL),(3,'INV.2/25/Jun/2016','Lele','alamt Lele','09874565436','lele@le.le','2016-06-25','2016-06-26','2016-06-06',2000000,1960000,3960000,0,0,1,'2016-06-25 21:25:57',NULL,NULL);

/*Table structure for table `cash_order_detail` */

DROP TABLE IF EXISTS `cash_order_detail`;

CREATE TABLE `cash_order_detail` (
  `orderdetail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orderdetail_order_id` varchar(100) DEFAULT NULL,
  `orderdetail_product_id` int(11) DEFAULT NULL,
  `orderdetail_quantity` int(11) DEFAULT NULL,
  `orderdetail_desc` text,
  `orderdetail_user_id` int(11) DEFAULT NULL,
  `orderdetail_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderdetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order_detail` */

insert  into `cash_order_detail`(`orderdetail_id`,`orderdetail_order_id`,`orderdetail_product_id`,`orderdetail_quantity`,`orderdetail_desc`,`orderdetail_user_id`,`orderdetail_timestamp`) values (1,'2',8,1,'',NULL,'2016-06-26 02:09:58'),(2,'2',6,1,'',NULL,'2016-06-26 02:09:58'),(3,'3',6,1,'',NULL,'2016-06-26 02:25:58'),(4,'3',9,1,'',NULL,'2016-06-26 02:25:58');

/*Table structure for table `cash_user` */

DROP TABLE IF EXISTS `cash_user`;

CREATE TABLE `cash_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_full_name` varchar(100) DEFAULT NULL,
  `user_username` varchar(100) DEFAULT NULL,
  `user_pass` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_desc` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cash_user` */

/*Table structure for table `cus_customer` */

DROP TABLE IF EXISTS `cus_customer`;

CREATE TABLE `cus_customer` (
  `custommer_id` int(11) NOT NULL AUTO_INCREMENT,
  `custommer_full_name` varchar(200) DEFAULT NULL,
  `custommer_prefix` int(11) DEFAULT NULL,
  `custommer_address` text,
  `custommer_phone_number` varchar(15) DEFAULT NULL,
  `custommer_email` varchar(100) DEFAULT NULL,
  `custommer_insert_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `custommer_insert_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`custommer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cus_customer` */

/*Table structure for table `cus_ref_grade_type` */

DROP TABLE IF EXISTS `cus_ref_grade_type`;

CREATE TABLE `cus_ref_grade_type` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(100) DEFAULT NULL,
  `grade_code` char(5) DEFAULT NULL,
  `grade_discount` int(11) DEFAULT NULL,
  `grade_desc` text,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cus_ref_grade_type` */

insert  into `cus_ref_grade_type`(`grade_id`,`grade_name`,`grade_code`,`grade_discount`,`grade_desc`) values (1,'Biasa','BS',0,NULL),(2,'Silver','SL',5,NULL),(3,'Gold','GL',10,NULL),(4,'Platinum','PL',20,NULL);

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
  KEY `inv_category_id` (`inv_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `inv_inventory` */

insert  into `inv_inventory`(`inv_id`,`inv_name`,`inv_type_id`,`inv_category_id`,`inv_price`,`inv_stock`,`inv_desc`) values (2,'Kaos sablon warna',1,1,34000,123,'ceking adjah'),(3,'Kaos Sablon Emas dua',2,1,800000,23,'cek cek'),(5,'Mug Mug Mboh',3,2,65000,23,'adasdasd'),(6,'Kaos Pin A',4,1,3400000,12,'asdasdasd'),(7,'Mug Sablon Emas',2,2,80000,450,'ceking'),(8,'Gantungan Kunci aja',4,3,65000,42,'adasdasd'),(9,'Kaos sablon warna',1,1,560000,12,'ceking ceking cok');

/*Table structure for table `inv_mass_price` */

DROP TABLE IF EXISTS `inv_mass_price`;

CREATE TABLE `inv_mass_price` (
  `massprice_id` int(11) NOT NULL AUTO_INCREMENT,
  `massprice_inv_id` int(11) DEFAULT NULL,
  `massprice_range_start` int(11) DEFAULT NULL,
  `massprice_range_end` int(11) DEFAULT '9999999',
  `massprice_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`massprice_id`),
  KEY `massprice_inv_id` (`massprice_inv_id`),
  CONSTRAINT `inv_mass_price_ibfk_1` FOREIGN KEY (`massprice_inv_id`) REFERENCES `inv_inventory` (`inv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `inv_mass_price` */

insert  into `inv_mass_price`(`massprice_id`,`massprice_inv_id`,`massprice_range_start`,`massprice_range_end`,`massprice_price`) values (1,2,13,50,30000),(2,2,51,100,28000),(3,2,101,300,25000),(4,2,301,9999999,20000),(5,8,51,100,6500),(6,8,101,300,5000),(26,8,301,400,4500);

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

/*Table structure for table `public_preferences` */

DROP TABLE IF EXISTS `public_preferences`;

CREATE TABLE `public_preferences` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `transition_page` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `public_preferences` */

insert  into `public_preferences`(`id`,`transition_page`) values (1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

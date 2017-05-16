/*
SQLyog Ultimate v10.41 
MySQL - 5.6.17 : Database - db_admin
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
  `order_payment_way` tinyint(4) DEFAULT NULL COMMENT '0 = nota order, 1 = nota pelunasan',
  `order_status` tinyint(4) DEFAULT NULL,
  `order_type` tinyint(1) DEFAULT NULL,
  `insert_user_id` int(11) DEFAULT NULL,
  `insert_timestamp` timestamp NULL DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `insert_user_id` (`insert_user_id`),
  KEY `update_user_id` (`update_user_id`),
  CONSTRAINT `cash_order_ibfk_1` FOREIGN KEY (`insert_user_id`) REFERENCES `user` (`user_id`),
  CONSTRAINT `cash_order_ibfk_2` FOREIGN KEY (`update_user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order` */

insert  into `cash_order`(`order_id`,`order_code`,`order_custommer_name`,`order_address`,`order_contact`,`order_email`,`order_date_order`,`order_date_design`,`order_date_take`,`order_down_payment`,`order_cash_minus`,`order_amount`,`order_payment_way`,`order_status`,`order_type`,`insert_user_id`,`insert_timestamp`,`update_user_id`,`update_timestamp`) values (2,'INV.1/25/Jun/2016','koko','alamat koko','0998676436434','koko@ko.ko','2016-06-25','2016-06-25','2016-06-06',127,0,3465000,0,1,NULL,1,'2016-06-25 21:09:58',1,'2016-06-29 23:16:06'),(3,'INV.2/25/Jun/2016','Lele','alamt Lele','09874565436','lele@le.le','2016-06-25','2016-06-26','2016-06-06',2000000,0,3960000,0,1,NULL,1,'2016-06-25 21:25:57',1,'2016-06-29 23:22:08'),(4,'INV.1/04/Aug/2016','otong','jln.otong','0977986097','','2016-08-04','2016-08-07','2016-08-08',10000000,0,13600000,0,1,NULL,1,'2016-08-04 20:51:28',1,'2016-08-04 20:52:24'),(5,'INV.1/04/Aug/2016','otong 2','adas','986','','2016-08-04','2016-08-07','2016-08-08',0,0,650000,0,1,NULL,1,'2016-08-04 20:54:05',NULL,NULL),(6,'INV.1/25/Aug/2016','surya wijanarko','jalan petung','03420395098','koko@ko.ko','2016-08-25','2016-08-26','2016-08-08',500000,0,936000,1,1,NULL,1,'2016-08-25 08:08:57',1,'2016-08-25 08:12:11'),(7,'INV.1/15/Sep/2016','','','','','2016-09-15','2016-09-14','2016-09-09',50000,15000,65000,0,0,NULL,1,'2016-09-15 18:53:45',NULL,NULL),(8,'INV.1/28/Sep/2016','suci','dijalan yang benar','89726514162','suci@ajah.id','2016-09-28','2016-09-29','2016-09-09',0,0,40000,3,1,NULL,1,'2016-09-28 15:39:20',NULL,NULL),(9,'INV.1/28/Sep/2016','adaaja','ada aja deh ','123456','adaaja@id','2016-09-28','2016-09-29','2016-10-10',0,0,476000,1,1,NULL,1,'2016-09-28 15:46:10',NULL,NULL),(10,'INV.1/28/Sep/2016','adri','jogja','0897654321','adri@yahoo.com','2016-09-28','2016-10-01','2016-10-10',500000,300000,800000,0,0,NULL,1,'2016-09-28 17:36:10',NULL,NULL),(11,'INV.2/28/Sep/2016','adri','jogja','0989876766','','2016-09-28','2016-09-29','2016-10-10',0,0,32000,1,1,NULL,1,'2016-09-29 00:00:47',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `cash_order_detail` */

insert  into `cash_order_detail`(`orderdetail_id`,`orderdetail_order_id`,`orderdetail_product_id`,`orderdetail_quantity`,`orderdetail_desc`,`orderdetail_user_id`,`orderdetail_timestamp`) values (1,'2',8,1,'',NULL,'2016-06-26 02:09:58'),(2,'2',6,1,'',NULL,'2016-06-26 02:09:58'),(3,'3',6,1,'',NULL,'2016-06-26 02:25:58'),(4,'3',9,1,'',NULL,'2016-06-26 02:25:58'),(5,'4',6,4,'ceking',NULL,'2016-08-05 01:51:28'),(6,'5',8,10,'',NULL,'2016-08-05 01:54:05'),(7,'6',7,10,'ceking',NULL,'2016-08-25 13:08:57'),(8,'6',2,4,'ceking xxx',NULL,'2016-08-25 13:08:57'),(9,'7',5,1,'Cek',NULL,'2016-09-15 23:53:45'),(10,'8',10,10,'',NULL,'2016-09-28 20:39:20'),(11,'9',2,14,'',NULL,'2016-09-28 20:46:10'),(12,'10',3,1,'',NULL,'2016-09-28 22:36:10'),(13,'11',10,8,'',NULL,'2016-09-29 05:00:47');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `inv_inventory` */

insert  into `inv_inventory`(`inv_id`,`inv_name`,`inv_type_id`,`inv_category_id`,`inv_price`,`inv_stock`,`inv_desc`) values (2,'Kaos sablon warna',1,1,34000,123,'ceking adjah'),(3,'Kaos Sablon Emas dua',2,1,800000,23,'cek cek'),(5,'Mug Mug Mboh',3,2,65000,23,'adasdasd'),(7,'Mug Sablon Emas',2,2,80000,450,'ceking'),(8,'Gantungan Kunci aja',4,3,65000,42,'adasdasd'),(10,'Pin 4,4',4,4,4000,7,''),(11,'',5,4,6000,20,'');

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

insert  into `inv_ref_inventory_type`(`type_id`,`type_name`,`type_code`,`type_category_id`,`type_desc`) values (1,'sablon warna','SW',1,NULL),(2,'Sablon Emas','SE',1,NULL),(3,'Mug Mboh','MB',2,NULL),(4,'Pin Glossy','PNA',4,NULL),(5,'Pin Doff','PNB',4,NULL);

/*Table structure for table `public_preferences` */

DROP TABLE IF EXISTS `public_preferences`;

CREATE TABLE `public_preferences` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `transition_page` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `public_preferences` */

insert  into `public_preferences`(`id`,`transition_page`) values (1,0);

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
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`user_id`,`user_full_name`,`user_username`,`user_password`,`user_email`,`user_level_id`,`user_desc`,`user_photo_path`,`user_photo_name`,`user_last_login`) values (1,'root','root','63a9f0ea7bb98050796b649e85481845','root@root.id',1,'sdaasdasd\r\n',NULL,'root-1.jpeg','2016-09-28 23:58:44'),(13,'Rifqi Hasnud','rifqi','21232f297a57a5a743894a0e4a801fc3','admin@admin.com',2,'',NULL,'Rifqi Hasnud-2.jpeg','2016-09-28 16:49:45'),(14,'renjul','rere','bd134207f74532a8b094676c4a2ca9ed','juliantrere@yahoo.com',3,'',NULL,'renjul-3.jpeg','2016-09-28 23:03:51'),(15,'Nafisah Ulfanuri Fitri Nurrasta','nafisah','4502911686e1eccf8b5154cf5466ea65','nafisah@yahoo.com',3,'',NULL,'Nafisah Ulfanuri Fitri Nurrasta-3.jpeg',NULL),(16,'Arvinda Azka Annisa','vinda','472b0fa7e71bc6d4f438333b1f0decd3','arvinda@yahoo.com',3,'',NULL,'Arvinda Azka Annisa-3.jpeg',NULL),(17,'Khairina','rina','3aea9516d222934e35dd30f142fda18c','rinakhai@yahoo.com',3,'',NULL,'Khairina-3.jpeg',NULL),(18,'Putty Brilianty','puty','fd35821537620834e0f1036d175d1445','putty@yahoo.com',3,'',NULL,'Putty Brilianty-3.jpeg',NULL);

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

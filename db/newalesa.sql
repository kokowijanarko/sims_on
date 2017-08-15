/*
SQLyog Ultimate v10.41 
MySQL - 5.5.5-10.1.9-MariaDB : Database - newalesa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `newalesa_v2`;

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id_cust` int(10) NOT NULL,
  `nama_cust` varchar(30) DEFAULT NULL,
  `alamat_cust` varchar(50) DEFAULT NULL,
  `nohp_cust` char(15) DEFAULT NULL,
  PRIMARY KEY (`id_cust`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `customer` */

insert  into `customer`(`id_cust`,`nama_cust`,`alamat_cust`,`nohp_cust`) values (0,'',NULL,NULL),(1,'Nedyowarti','Jl.Raya Junggo No.52 Rt.05 Rw.09 Desa Junggo, Kelu','085641577623'),(2,'Fery KIswanto','RS. Elizabeth, Jl WR Supratman No.2, Situbondo','089657890765'),(3,'Ibu Lia','Laladon Gede RT.05 RW.04 No.69 (Belakang Terminal ','081223765423'),(4,'dela','Perum Bukit Indihiang Permai Blok G, No 4, Indihia','0822202217689'),(5,'Diati Mulyawati','Jl. Raya Banjaran BLK 201 Rt 07/11, Rengascondong ','0897909876544'),(6,'wati','Dusun Banir Rt 001/004, Desa Purwajaya Kec. Tempur','087777908654'),(8,'musrifah hasan','Ponpes Al Falah, Jl Pesantren RT 3/7 Tinggarjaya J','08837820965'),(9,'Rizkika AZ','Jl Letjen Suprapto gg 2/2 Kebonsari, Sumbersari, J','081243579873'),(10,'emy rosana','Jl. Stasiun No 6 (Toko Pempek), , Kota Bumi Lampun','082211210120'),(11,'kiki bunda nisa','Perum Langensari Indah Blok E No 1 RT 8 RW 4, Lang','087765990001'),(12,'hj hasny','UD Restu Ilahi, Jl Timor Raya KM 28 Oesao, Kupang','085643455553'),(13,'hesty andriana putri','Kampus ARTO Citra Intan Persada Banjarmasin, Jl Pe','085643843900'),(14,'ita abu bakar','Grogol Rt 02/Rw 01, Desa Tritunggal, Babat, Lamong','087778321500'),(15,'wenny','Jl Bedeng No 22 RT 03/06 Kutoarjo, , Purworejo','081390002760');

/*Table structure for table `detail_pembelian` */

DROP TABLE IF EXISTS `detail_pembelian`;

CREATE TABLE `detail_pembelian` (
  `id_beli` int(10) DEFAULT NULL,
  `id_prod` int(10) DEFAULT NULL,
  `harga_beli` int(10) DEFAULT NULL,
  `harga_jual` int(10) DEFAULT NULL,
  `jml_brg` int(10) DEFAULT NULL,
  KEY `id_beli` (`id_beli`),
  KEY `id_prod` (`id_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detail_pembelian` */

insert  into `detail_pembelian`(`id_beli`,`id_prod`,`harga_beli`,`harga_jual`,`jml_brg`) values (1,6,300000,360000,10),(2,3,120000,180000,40),(3,13,200000,250000,25),(4,5,120000,180000,70),(5,0,70000,75000,50);

/*Table structure for table `detail_penjualan` */

DROP TABLE IF EXISTS `detail_penjualan`;

CREATE TABLE `detail_penjualan` (
  `id_penj` int(10) DEFAULT NULL,
  `id_prod` int(10) DEFAULT NULL,
  `jml_jual` int(10) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  KEY `id_penj` (`id_penj`),
  KEY `id_prod` (`id_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detail_penjualan` */

insert  into `detail_penjualan`(`id_penj`,`id_prod`,`jml_jual`,`total`) values (111,6,3,500000),(113,3,5,800000),(112,1,2,125000);

/*Table structure for table `pembelian` */

DROP TABLE IF EXISTS `pembelian`;

CREATE TABLE `pembelian` (
  `id_beli` int(10) NOT NULL AUTO_INCREMENT,
  `id_sup` int(10) DEFAULT NULL,
  `id_user` int(10) DEFAULT NULL,
  `tgl_beli` date DEFAULT NULL,
  PRIMARY KEY (`id_beli`),
  KEY `id_sup` (`id_sup`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `pembelian` */

insert  into `pembelian`(`id_beli`,`id_sup`,`id_user`,`tgl_beli`) values (1,1,2,'2017-08-02'),(2,4,2,'2017-08-02'),(3,2,2,'2017-08-02'),(4,5,2,'2017-08-03'),(5,0,1,'2017-08-01');

/*Table structure for table `penjualan` */

DROP TABLE IF EXISTS `penjualan`;

CREATE TABLE `penjualan` (
  `id_penj` int(10) NOT NULL AUTO_INCREMENT,
  `kode_invoice` varchar(100) NOT NULL,
  `id_user` int(10) DEFAULT NULL,
  `id_cust` int(10) DEFAULT NULL,
  `tgl_trans` date DEFAULT NULL,
  `biaya_kirim` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `ttl_byr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_penj`),
  KEY `id_user` (`id_user`),
  KEY `id_cust` (`id_cust`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

/*Data for the table `penjualan` */

insert  into `penjualan`(`id_penj`,`kode_invoice`,`id_user`,`id_cust`,`tgl_trans`,`biaya_kirim`,`diskon`,`ttl_byr`) values (111,'INV.1/03/Oct/2016',1,1,'2017-08-01',20000,5000,85000),(112,'INV.2/03/Oct/2016',1,2,'2017-08-01',5000,0,250000),(113,'INV.3/03/Oct/2016',3,4,'2017-08-01',23000,15000,233000);

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `id_prod` int(10) NOT NULL AUTO_INCREMENT,
  `nama_prod` varchar(30) DEFAULT NULL,
  `jenis_prod` enum('1','2') DEFAULT NULL COMMENT '1=gamin, 2=jilbab',
  `harga` int(11) DEFAULT NULL,
  `stok` int(3) DEFAULT NULL,
  PRIMARY KEY (`id_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `produk` */

insert  into `produk`(`id_prod`,`nama_prod`,`jenis_prod`,`harga`,`stok`) values (1,'aazeen syari2','1',57000,30),(2,'abrina','1',67000,45),(3,'adelia','1',78000,55),(4,'adelia set','1',34000,50),(5,'alma','1',56000,70),(6,'alodya shandy','1',55000,25),(7,'althaf','1',89000,70),(8,'althaf sale','1',123000,30),(9,'aminah khimar','2',54000,40),(10,'anasya','1',43000,40),(11,'anasya set','1',90000,30),(12,'andrea','1',99000,30),(13,'angela','1',87000,25),(14,'aoreena','1',78000,50),(15,'aprilia','1',78000,65),(16,'armela','1',34000,30),(17,'armela syari','1',190000,43),(18,'atalie syari','1',230000,35),(19,'avanty','1',235000,40),(20,'ayesya syari','1',54000,45),(21,'2tone 2loop','2',56000,50),(25,'ceking','2',900000,99);

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_sup` int(10) NOT NULL AUTO_INCREMENT,
  `nama_sup` varchar(30) DEFAULT NULL,
  `alamat_sup` varchar(50) DEFAULT NULL,
  `nohp_sup` int(15) DEFAULT NULL,
  PRIMARY KEY (`id_sup`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `supplier` */

insert  into `supplier`(`id_sup`,`nama_sup`,`alamat_sup`,`nohp_sup`) values (1,'flow idea','jakarta',758937586),(2,'qiara','jakarta',567843789),(3,'shandi','jakrta selatan',3467378),(4,'agoest hanggono','malang',46538923),(5,'dichta','solo surakarta',3239828),(6,'kalena','surakarta SOLO',873654829);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(30) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat_user` varchar(50) DEFAULT NULL,
  `jenis_kel` enum('laki-laki','perempuan') DEFAULT NULL,
  `nohp_user` int(15) DEFAULT NULL,
  `level` enum('1','2','3') DEFAULT NULL COMMENT '1=root, 2=admin, 3=owner',
  `password` varchar(100) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id_user`,`nama_user`,`tgl_lahir`,`alamat_user`,`jenis_kel`,`nohp_user`,`level`,`password`,`photo`) values (1,'admin','2017-08-07','yogyakarta rt 5 rt 5 ','laki-laki',2147483647,'2','21232f297a57a5a743894a0e4a801fc3','admin-2.jpeg'),(2,'owner','2017-08-14','jambon','perempuan',897274837,'3','72122ce96bfec66e2396d2e25225d70a',NULL),(3,'admin1','2017-08-22','bantul','perempuan',676546889,'2','e00cf25ad42683b3df678c61f42c6bda',NULL),(4,'root','2017-08-06','adasdas','laki-laki',NULL,'1','63a9f0ea7bb98050796b649e85481845','root-1.jpeg');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

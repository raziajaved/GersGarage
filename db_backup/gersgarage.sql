/*
SQLyog Enterprise - MySQL GUI v8.02 RC
MySQL - 5.5.5-10.4.21-MariaDB : Database - gersgarage
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`gersgarage` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `gersgarage`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `admin` varchar(255) NOT NULL,
  `password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(`admin`,`password`) values ('admin','1234');

/*Table structure for table `bookings` */

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `BID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) DEFAULT NULL,
  `VID` int(11) DEFAULT NULL,
  `booking_type` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `mechanic` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`BID`),
  KEY `FK_bookings` (`VID`),
  KEY `FK_bookings_2` (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `bookings` */

insert  into `bookings`(`BID`,`UID`,`VID`,`booking_type`,`description`,`booking_date`,`status`,`mechanic`,`cost`,`timestamp`) values (19,1,15,NULL,'qwdefsdfasdf','2022-01-26',3,'Noah Byrne','362','2022-01-21 02:25:13');

/*Table structure for table `parts` */

DROP TABLE IF EXISTS `parts`;

CREATE TABLE `parts` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `BID` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PID`),
  KEY `FK_parts` (`BID`),
  CONSTRAINT `FK_parts` FOREIGN KEY (`BID`) REFERENCES `bookings` (`BID`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4;

/*Data for the table `parts` */

insert  into `parts`(`PID`,`BID`,`name`,`cost`) values (50,19,'AC EVAPORATOR','21.99'),(51,19,'HOOD INSULATION','4.99'),(52,19,'HOOD W/GRILL','65.99'),(53,19,'SPEEDOMETER-DIGITAL','23.99'),(54,19,'AC COMPRESSOR','32.99'),(55,19,'AC EVAPORATOR','21.99'),(56,19,'HOOD INSULATION','4.99'),(57,19,'HOOD W/GRILL','65.99');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `password` varchar(16) NOT NULL,
  `email` varchar(60) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`UID`,`fname`,`lname`,`password`,`email`,`mobile`,`address`) values (1,'Razia','Javed','123','razia@gmail.com','1546654545','fdxdsdfgsdf');

/*Table structure for table `vehicle` */

DROP TABLE IF EXISTS `vehicle`;

CREATE TABLE `vehicle` (
  `VID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT '',
  `make` varchar(255) DEFAULT '',
  `licence_details` varchar(255) DEFAULT '',
  `engine_type` varchar(255) DEFAULT '',
  PRIMARY KEY (`VID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `vehicle` */

insert  into `vehicle`(`VID`,`UID`,`type`,`make`,`licence_details`,`engine_type`) values (15,1,'MotorBike','Cadillac','sddfed','Petrol');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

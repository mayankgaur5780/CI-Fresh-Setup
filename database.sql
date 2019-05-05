/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.0.38-MariaDB-0ubuntu0.16.04.1 : Database - ci_fresh_setup
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ci_fresh_setup` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `ci_fresh_setup`;

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0.Inactive, 1.Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_roles` */

insert  into `admin_roles`(`id`,`name`,`status`,`created_at`,`updated_at`) values 
(1,'Super Admin',1,'2019-04-13 14:21:45','2019-04-13 14:21:45'),
(2,'Admin',1,'2019-04-14 13:21:00','2019-05-04 21:21:35');

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0.Inactive, 1.Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`role_id`,`name`,`profile_image`,`dial_code`,`mobile`,`email`,`password`,`hash`,`status`,`created_at`,`updated_at`) values 
(1,1,'Admin','4bdf72add5c6013579cddcefab9226fd.png','91','01236547890','test@test.com','26f1a0e3ff9e6bf663bc452443b23a22eedd78fad3306540a11ee79f1d893bb537d8b6867c3b2af4ed2c6b56f37efdce8ca8a411e60ac7bc793fe774dc3be8be','f6fa704dbc0b4cebc02dd7fa3fb4eda2',1,'2019-04-13 14:56:06','2019-05-05 22:56:09');

/*Table structure for table `navigations` */

DROP TABLE IF EXISTS `navigations`;

CREATE TABLE `navigations` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(10) unsigned DEFAULT NULL,
  `display_order` int(4) DEFAULT '0',
  `action_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0.Inactive, 1.Active',
  `show_in_menu` tinyint(1) DEFAULT '1' COMMENT '0.No, 1.Yes',
  `show_in_permission` tinyint(1) DEFAULT '1' COMMENT '0.No, 1.Yes',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `navigations_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `navigations` */

insert  into `navigations`(`id`,`name`,`icon`,`parent_id`,`display_order`,`action_path`,`status`,`show_in_menu`,`show_in_permission`,`created_at`,`updated_at`) values 
(1,'Dashboard','fa fa-dashboard',NULL,1,'admin/dashboard',1,1,1,'2019-04-13 14:23:35','2019-05-04 21:46:32'),
(4,'Manage Roles','fa fa-cog',NULL,2,'admin/roles',1,1,1,'2019-04-14 12:32:24','2019-05-04 22:27:52'),
(5,'Manage Navigation','fa fa-tasks',NULL,3,'admin/navigation',1,1,1,'2019-04-14 12:33:04','2019-04-14 12:33:04'),
(6,'Manage Admins','fa fa-users',NULL,4,'admin/admins',1,1,1,'2019-05-05 12:35:58','2019-05-05 19:49:48'),
(7,'Manage Users','fa fa-users',NULL,5,'admin/users',1,1,1,'2019-05-05 12:37:17','2019-05-05 12:37:17');

/*Table structure for table `role_permissions` */

DROP TABLE IF EXISTS `role_permissions`;

CREATE TABLE `role_permissions` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(10) unsigned DEFAULT NULL,
  `navigation_id` bigint(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `navigation_id` (`navigation_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`navigation_id`) REFERENCES `navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_permissions` */

insert  into `role_permissions`(`id`,`role_id`,`navigation_id`,`created_at`,`updated_at`) values 
(4,1,1,'2019-05-04 21:27:09','2019-05-04 21:27:09');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0.Inactive, 1.Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

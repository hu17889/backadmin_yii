/*
SQLyog Ultimate v9.20 
MySQL - 5.5.34-0ubuntu0.12.04.1 : Database - backadmin
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`backadmin` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `backadmin`;

/*Table structure for table `m-action` */

DROP TABLE IF EXISTS `m-action`;

CREATE TABLE `m-action` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '路由id',
  `aname` varchar(20) NOT NULL DEFAULT '' COMMENT '路由名称',
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '路由信息,例如/main/user/list',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 非菜单 1 一级菜单 2 二级菜单',
  `first_menu` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '若未二级菜单，此处存所属的一级菜单id',
  `menusort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '菜单排序，大值排前列',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`),
  UNIQUE KEY `aname` (`aname`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

/*Data for the table `m-action` */

insert  into `m-action`(`aid`,`aname`,`route`,`is_menu`,`first_menu`,`menusort`,`update_time`) values (1,'编辑用户','/main/user/edit',0,-1,0,'2013-08-01 21:51:28'),(2,'用户列表','/main/user/list',2,56,0,'2013-08-01 21:51:28'),(3,'编辑角色','/main/role/edit',0,-1,0,'2013-08-01 21:51:28'),(4,'角色列表','/main/role/list',2,56,0,'2013-08-01 21:51:28'),(5,'编辑路由','/main/action/edit',0,-1,0,'2013-08-01 21:51:28'),(6,'路由列表','/main/action/list',2,56,0,'2013-08-01 21:51:28'),(68,'用户列表ajax','/main/user/listajax',0,0,0,'2014-02-08 13:33:37'),(49,'删除用户','/main/user/del',0,-1,0,'2013-09-14 14:43:40'),(55,'用户首页','/main/user/index',0,-1,0,'2014-01-16 16:54:02'),(56,'系统功能','/main/index',1,-1,0,'2014-01-20 18:12:16'),(57,'删除路由','/main/action/del',0,-1,0,'2014-01-24 11:45:38'),(64,'路由列表ajax','/main/action/listajax',0,0,0,'2014-02-08 13:26:48'),(65,'角色列表ajax','/main/role/listajax',0,0,0,'2014-02-08 13:29:18'),(66,'删除角色','/main/role/del',0,0,0,'2014-02-08 13:29:51'),(69,'欢迎页','/site/index',1,0,100,'2014-08-17 02:41:05');

/*Table structure for table `m-role` */

DROP TABLE IF EXISTS `m-role`;

CREATE TABLE `m-role` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `rname` varchar(20) NOT NULL DEFAULT '' COMMENT '角色名称',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`),
  UNIQUE KEY `name` (`rname`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `m-role` */

insert  into `m-role`(`rid`,`rname`,`update_time`) values (1,'admin','2013-08-01 21:51:28');

/*Table structure for table `m-role-action` */

DROP TABLE IF EXISTS `m-role-action`;

CREATE TABLE `m-role-action` (
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '路由id',
  `menu_pos` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '无用',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `m-role-action` */

insert  into `m-role-action`(`rid`,`aid`,`menu_pos`,`update_time`) values (1,69,0,'2014-08-17 03:19:00'),(1,57,0,'2014-08-17 03:19:00'),(1,5,0,'2014-08-17 03:19:00'),(1,64,0,'2014-08-17 03:19:00'),(1,66,0,'2014-08-17 03:19:00'),(1,3,0,'2014-08-17 03:19:00'),(1,65,0,'2014-08-17 03:19:00'),(1,49,0,'2014-08-17 03:19:00'),(1,1,0,'2014-08-17 03:19:00'),(1,55,0,'2014-08-17 03:19:00'),(1,68,0,'2014-08-17 03:19:00'),(1,56,0,'2014-08-17 03:19:00'),(1,6,0,'2014-08-17 03:19:00'),(1,4,0,'2014-08-17 03:19:00'),(1,2,0,'2014-08-17 03:19:00');

/*Table structure for table `m-user` */

DROP TABLE IF EXISTS `m-user`;

CREATE TABLE `m-user` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `uname` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名称',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `pwd` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`uname`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

/*Data for the table `m-user` */

insert  into `m-user`(`uid`,`uname`,`email`,`pwd`,`rid`,`update_time`) values (1,'admin','admin@backadmin.com','21232f297a57a5a743894a0e4a801fc3',1,'2013-08-01 21:51:28');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*
SQLyog Ultimate v8.32 
MySQL - 5.6.21-log : Database - dianying1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dianying1` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dianying1`;

/*Table structure for table `dy_admin` */

DROP TABLE IF EXISTS `dy_admin`;

CREATE TABLE `dy_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(36) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `dy_admin` */

insert  into `dy_admin`(`id`,`name`,`password`) values (1,'admin','5b53006c0c4ad904d5873830385e6cb8');

/*Table structure for table `dy_domain` */

DROP TABLE IF EXISTS `dy_domain`;

CREATE TABLE `dy_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layer` int(1) NOT NULL COMMENT '层级',
  `url` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `look` int(1) DEFAULT '0',
  `lanjie_time` varchar(20) DEFAULT NULL,
  `qiyong_time` int(11) DEFAULT '0' COMMENT '启用时间',
  `auto_chack_time` int(12) DEFAULT NULL,
  `checked` int(11) DEFAULT NULL COMMENT '标识此URL有没有检测通过，只用于检测此域名是否配置到正确的服务器，或者七牛域名是否是生效的。-1:无效域名,0正在检测,1:有效域名',
  `check_ret` varchar(1024) DEFAULT NULL COMMENT '检测失败原因',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qidong_type` int(1) NOT NULL DEFAULT '0' COMMENT '0 手动 1 定时任务启动',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`type`,`look`),
  KEY `layer` (`layer`),
  KEY `qiyong_time` (`qiyong_time`),
  KEY `layer_2` (`layer`),
  KEY `url` (`url`),
  KEY `type` (`type`),
  KEY `ix_type_layer` (`type`,`layer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dy_domain` */

/*Table structure for table `dy_order` */

DROP TABLE IF EXISTS `dy_order`;

CREATE TABLE `dy_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gid` int(5) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `orderid` varchar(30) NOT NULL COMMENT '订单号',
  `money` varchar(10) NOT NULL,
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `s_time` int(20) NOT NULL COMMENT '请求时间',
  `e_time` int(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 未支付 1已支付',
  `info` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '支付信息',
  PRIMARY KEY (`id`),
  UNIQUE KEY `orderid` (`orderid`),
  KEY `id` (`id`,`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dy_order` */

/*Table structure for table `dy_push` */

DROP TABLE IF EXISTS `dy_push`;

CREATE TABLE `dy_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `where` text,
  `time` int(10) DEFAULT NULL COMMENT '时间',
  `info` text COMMENT '推送内容',
  `num` int(11) DEFAULT NULL COMMENT '多少人',
  `etime` int(11) DEFAULT NULL COMMENT '结束时间',
  `status` int(1) DEFAULT '0' COMMENT '0开始 1结束',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dy_push` */

/*Table structure for table `dy_push_log` */

DROP TABLE IF EXISTS `dy_push_log`;

CREATE TABLE `dy_push_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(5) NOT NULL COMMENT '推送id',
  `openid` varchar(32) CHARACTER SET gbk NOT NULL,
  `time` int(14) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dy_push_log` */

/*Table structure for table `dy_site` */

DROP TABLE IF EXISTS `dy_site`;

CREATE TABLE `dy_site` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `valus` varchar(255) CHARACTER SET utf8 COLLATE utf8_estonian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `dy_site` */

insert  into `dy_site`(`id`,`name`,`valus`) values (1,'YUNWEI_TEL','18361130555'),(2,'CPS_API_URL','http://1.haooda.com/'),(3,'PAY_API_URL','http://pay4.njsdw.cn/PayApi/wechatqr'),(4,'WEB_NAME','C内测平台'),(5,'AUTO_PUSH_TIME',''),(6,'PAY_API_URL2','http://pay4.xjchangyuan.com/PayApi/wechatqr'),(7,'PAY_API_URL3','http://pay4.hnchenyang.com/PayApi/wechatqr');

/*Table structure for table `dy_task` */

DROP TABLE IF EXISTS `dy_task`;

CREATE TABLE `dy_task` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_icelandic_ci DEFAULT NULL,
  `lasttime` int(12) NOT NULL COMMENT '上次时间',
  `thistime` int(12) NOT NULL COMMENT '本次执行时间',
  `status` int(1) NOT NULL COMMENT '0空闲 1执行',
  `chacktime` int(11) NOT NULL COMMENT '检查周期分钟',
  `overtime` int(12) DEFAULT '30' COMMENT '超时时间单位分钟',
  `consuming` varchar(12) NOT NULL COMMENT '执行耗时',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `dy_task` */

insert  into `dy_task`(`id`,`name`,`info`,`lasttime`,`thistime`,`status`,`chacktime`,`overtime`,`consuming`) values (2,'ChackPayUrl','检查支付网址',1477412942,1477413121,0,2,1,'0'),(3,'ChackIndexUrl','检查电影网址',1477412942,1477413122,0,2,10,'3');

/*Table structure for table `dy_user` */

DROP TABLE IF EXISTS `dy_user`;

CREATE TABLE `dy_user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `gid` int(5) NOT NULL DEFAULT '0' COMMENT '公众号id',
  `follow` int(1) NOT NULL DEFAULT '1' COMMENT '是否关注',
  `user_name` varchar(88) DEFAULT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `sex` int(1) DEFAULT '1',
  `openid` varchar(30) NOT NULL,
  `vip` int(1) NOT NULL DEFAULT '0' COMMENT '是否vip',
  `vip_time` int(20) NOT NULL COMMENT '加入vip事件',
  `reg_time` int(20) NOT NULL COMMENT '注册事件',
  `login_time` int(20) NOT NULL COMMENT '登录时间',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

/*Data for the table `dy_user` */

/*Table structure for table `dy_useroff` */

DROP TABLE IF EXISTS `dy_useroff`;

CREATE TABLE `dy_useroff` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `uid` int(5) NOT NULL,
  `time` int(12) NOT NULL,
  `switch` int(1) NOT NULL COMMENT '1开始分享 0 关闭',
  `overtime` int(4) NOT NULL COMMENT '超时时间 分钟',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dy_useroff` */

/*Table structure for table `dy_weixin` */

DROP TABLE IF EXISTS `dy_weixin`;

CREATE TABLE `dy_weixin` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `k` int(3) NOT NULL COMMENT '键值',
  `info` text NOT NULL COMMENT '配置',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`k`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `dy_weixin` */

insert  into `dy_weixin`(`id`,`k`,`info`) values (7,1,'{\"name\":\"\\u89c6\\u4fe1\\u6295\\u8d44\",\"app_id\":\"wx03458487f46dc166\",\"secret\":\"8bcf28fe43e0594ecd44904ad0ac0f20\",\"token\":\"dd5e6ac6404490c29e8156c5224594c7\",\"url\":\"www.baidu.com\"}');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

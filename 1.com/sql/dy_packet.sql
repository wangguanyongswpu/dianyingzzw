/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : dianying1

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-03-15 13:55:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dy_packet
-- ----------------------------
DROP TABLE IF EXISTS `dy_packet`;
CREATE TABLE `dy_packet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) DEFAULT NULL COMMENT '别名',
  `domain_id` varchar(100) DEFAULT NULL COMMENT '该组域名集合',
  `web_type` tinyint(1) DEFAULT '0' COMMENT '站点：1-疯狂赚，2-悦涩吧，3-凌晨影院',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

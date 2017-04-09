/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : dianying

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-03-13 18:57:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dy_paydomain`
-- ----------------------------
DROP TABLE IF EXISTS `dy_paydomain`;
CREATE TABLE `dy_paydomain` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '支付域名id',
  `paydomain` varchar(60) NOT NULL COMMENT '支付域名',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态  0备用1启用2取消',
  `sys` tinyint(3) NOT NULL COMMENT '支付系统   1疯狂赚2悦涩吧3凌晨影院',
  `server` varchar(20) NOT NULL COMMENT '服务器属性',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_paydomain
-- ----------------------------
INSERT INTO `dy_paydomain` VALUES ('5', 'www.xxx.com', '1', '3', '');
INSERT INTO `dy_paydomain` VALUES ('3', 'www.taobao.com', '1', '1', '');
INSERT INTO `dy_paydomain` VALUES ('4', 'www.baidu.com', '0', '2', '');
INSERT INTO `dy_paydomain` VALUES ('6', 'www.xxx1.com', '0', '1', '');
INSERT INTO `dy_paydomain` VALUES ('7', 'www.eee.com', '0', '3', '');
INSERT INTO `dy_paydomain` VALUES ('8', 'www.rrrr.ocom', '0', '3', '');
INSERT INTO `dy_paydomain` VALUES ('9', 'www.ppp.com', '1', '2', '');

-- ----------------------------
-- Table structure for `dy_payinfer`
-- ----------------------------
DROP TABLE IF EXISTS `dy_payinfer`;
CREATE TABLE `dy_payinfer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `infer` varchar(20) NOT NULL COMMENT '接口名称',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0备用1启用2取消',
  `sys` tinyint(3) NOT NULL COMMENT '平台号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dy_payinfer
-- ----------------------------
INSERT INTO `dy_payinfer` VALUES ('3', 'wechatqr', '1', '1');
INSERT INTO `dy_payinfer` VALUES ('4', 'jjz', '0', '1');
INSERT INTO `dy_payinfer` VALUES ('5', 'qwe', '0', '2');
INSERT INTO `dy_payinfer` VALUES ('6', 'erer', '3', '3');
INSERT INTO `dy_payinfer` VALUES ('7', 'sdrf', '1', '2');
INSERT INTO `dy_payinfer` VALUES ('8', 'qweq', '0', '2');
INSERT INTO `dy_payinfer` VALUES ('9', 'tutyu', '1', '3');

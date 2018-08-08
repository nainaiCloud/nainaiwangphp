/*
Navicat MySQL Data Transfer

Source Server         : 127
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : nn_dev

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-08-08 15:38:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `order_notice`
-- ----------------------------
DROP TABLE IF EXISTS `order_notice`;
CREATE TABLE `order_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL COMMENT '要通知的offer ID',
  `auto_notice` int(2) NOT NULL DEFAULT '0' COMMENT '1:已通知',
  PRIMARY KEY (`id`),
  UNIQUE KEY `full` (`auto_notice`,`offer_id`,`id`) USING BTREE
) ENGINE=MEMORY AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



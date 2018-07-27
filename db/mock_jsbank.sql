/*
Navicat MySQL Data Transfer

Source Server         : 127
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : nn_dev

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-27 17:54:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mock_jsbank`
-- ----------------------------
DROP TABLE IF EXISTS `mock_jsbank`;
CREATE TABLE `mock_jsbank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OP_ACCT_NO_32` varchar(100) NOT NULL COMMENT '账号',
  `TX_AMT` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `OP_CUST_NAME` varchar(30) CHARACTER SET utf8 NOT NULL COMMENT '开户名',
  `TX_LOG_NO` varchar(100) NOT NULL COMMENT '银行流水号',
  `TX_DT` date NOT NULL COMMENT '交易日期',
  `TX_TM` time NOT NULL COMMENT '交易时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mock_jsbank
-- ----------------------------

ALTER TABLE `product_offer`  ADD COLUMN `accept_area_code`  varchar(6) NOT NULL COMMENT '交收地址代码' ;
ALTER TABLE `product_offer`
MODIFY COLUMN `accept_day`  varchar(20) NOT NULL COMMENT '交收时间' AFTER `accept_area`;

ALTER TABLE `products`
ADD COLUMN `produce_address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产地地址' ;

ALTER TABLE `product_offer`
ADD COLUMN `jingjia_deposit`  decimal(12,2) NOT NULL DEFAULT 0 COMMENT '竞价保证金' AFTER `accept_area_code`;

ALTER TABLE `product_offer`
ADD COLUMN `views`  int(11) NOT NULL DEFAULT 0 COMMENT '围观次数' AFTER `jingjia_deposit`;
ALTER TABLE `product_offer`
ADD COLUMN `auto_notice`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '自动通知' AFTER `views`;

ALTER TABLE `product_offer`
ADD INDEX `end_time` (`end_time`, `auto_notice`) USING BTREE;

ALTER TABLE `product_offer`
ADD COLUMN `pay_days`  tinyint(5) NOT NULL COMMENT '成交后多少天完成缴纳货款' AFTER `auto_notice`;



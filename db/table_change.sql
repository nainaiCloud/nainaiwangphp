
ALTER TABLE `admin_check`
MODIFY COLUMN `admin_names`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `admin_id`

ALTER TABLE `order_sell`
ADD COLUMN `del`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '1:��ɾ��' AFTER `o_lock`;
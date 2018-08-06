
-- ----------------------------
-- Procedure structure for `createDepositOrder`
-- ----------------------------
DROP PROCEDURE IF EXISTS `createDepositOrder`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createDepositOrder`(IN `offerId` int,IN `buyer_id` int,IN `buyNum` decimal,IN `pay_times` int,IN `payDeposit` decimal,IN `payWay` tinyint)
BEGIN
	#Routine body goes here...
  DECLARE modeId INT(2);
       DECLARE orderNo VARCHAR(20);
       DECLARE totalAmt DECIMAL(15,2) ;
       DECLARE contractStatus INT(2);
       DECLARE random INT(2);
       DECLARE orderTime VARCHAR(20);
       DECLARE orderPrice DECIMAL(12,2);
       DECLARE offerUserId INT(11);
       SELECT price,mode,user_id INTO orderPrice,modeId,offerUserId FROM product_offer   WHERE id=offerId;
       SET totalAmt = orderPrice * buyNum;
         SET contractStatus=3;/*等待买家支付*/
       SET random =  FLOOR(0 + (RAND() * 99));
      SET orderNo = CONCAT(FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y%m%d%H%i%s') ,  random );
      SET orderTime = FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H:%i:%s') ;
       INSERT INTO order_sell 
       (
           offer_id,
           offer_user_id,
           mode,
           order_no,
           num,
           amount,/*总金额*/
           user_id,
           pay_deposit,/*支付订金金额*/
           buyer_deposit_payment,
           contract_status,
           invoice,
           create_time,
           price_unit
           )  
           VALUES  
           (
               offerId,
              offerUserId,
              modeId,/*生成*/
               orderNo,/*生成*/
               buyNum,/*参数*/
               totalAmt,/*生成*/
               buyer_id,/*参数*/
               0,/*参数*/
               payWay,/*参数*/
               contractStatus,/*生成*/
               1,/*默认值1*/
               orderTime,
               orderPrice
               );
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `createFreeOrder`
-- ----------------------------
DROP PROCEDURE IF EXISTS `createFreeOrder`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createFreeOrder`(IN `offerId` int,IN `buyer_id` int,IN `buyNum` decimal,IN `pay_times` int,IN `payDeposit` decimal,IN `payWay` tinyint)
BEGIN
	#Routine body goes here...
  DECLARE modeId INT(2);
       DECLARE orderNo VARCHAR(20);
       DECLARE totalAmt DECIMAL(15,2) ;
       DECLARE contractStatus INT(2);
       DECLARE random INT(2);
       DECLARE orderTime VARCHAR(20);
       DECLARE orderPrice DECIMAL(12,2);
       DECLARE offerUserId INT(11);
       SELECT price,mode,user_id INTO orderPrice,modeId,offerUserId FROM product_offer   WHERE id=offerId;
       SET totalAmt = orderPrice * buyNum;
         SET contractStatus=3;/*等待买方支付*/
       SET random =  FLOOR(0 + (RAND() * 99));
      SET orderNo = CONCAT(FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y%m%d%H%i%s') ,  random );
      SET orderTime = FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H:%i:%s') ;
       INSERT INTO order_sell 
       (
           offer_id,
           offer_user_id,
           mode,
           order_no,
           num,
           amount,/*总金额*/
           user_id,
           pay_deposit,/*支付订金金额*/
           buyer_deposit_payment,
           contract_status,
           invoice,
           create_time,
           price_unit
           )  
           VALUES  
           (
               offerId,
              offerUserId,
              modeId,/*生成*/
               orderNo,/*生成*/
               buyNum,/*参数*/
               totalAmt,/*生成*/
               buyer_id,/*参数*/
               0,/*参数*/
               payWay,/*参数*/
               contractStatus,/*生成*/
               1,/*默认值1*/
               orderTime,
               orderPrice
               );

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `createStoreOrder`
-- ----------------------------
DROP PROCEDURE IF EXISTS `createStoreOrder`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `createStoreOrder`(IN `offerId` INT(11) UNSIGNED, IN `buyer_id` INT(11) UNSIGNED, IN `buyNum` DECIMAL(15,2) UNSIGNED, IN `pay_times` TINYINT(2) UNSIGNED, IN `payDeposit` DECIMAL(15,2) UNSIGNED, IN `payWay` TINYINT(2))
    NO SQL
    DETERMINISTIC
BEGIN
       DECLARE modeId INT(2);
       DECLARE orderNo VARCHAR(20);
       DECLARE totalAmt DECIMAL(15,2) ;
       DECLARE contractStatus INT(2);
       DECLARE random INT(2);
       DECLARE orderTime VARCHAR(20);
        DECLARE orderPrice DECIMAL(12,2);
       DECLARE offerUserId INT(11);
       SELECT price,mode,user_id INTO orderPrice,modeId ,offerUserId FROM product_offer   WHERE id=offerId;
       SET totalAmt = orderPrice * buyNum;

       SET contractStatus=3;/*等待支付尾款*/

       SET random =  FLOOR(0 + (RAND() * 99));
      SET orderNo = CONCAT(FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y%m%d%H%i%s') ,  random );
      SET orderTime = FROM_UNIXTIME(UNIX_TIMESTAMP(), '%Y-%m-%d %H:%i:%s') ;
       INSERT INTO order_sell 
       (
           offer_id,
           offer_user_id,
           mode,
           order_no,
           num,
           amount,/*总金额*/
           user_id,
           pay_deposit,/*支付订金金额*/
           buyer_deposit_payment,
           contract_status,
           invoice,
           create_time,
           price_unit
           )  
           VALUES  
           (
               offerId,
              offerUserId,
              modeId,/*生成*/
               orderNo,/*生成*/
               buyNum,/*参数*/
               totalAmt,/*生成*/
               buyer_id,/*参数*/
               0,/*参数*/
               payWay,/*参数*/
               contractStatus,/*生成*/
               1,/*默认值1*/
               orderTime,
               orderPrice
               );
               

END
;;
DELIMITER ;


-- ----------------------------
-- Procedure structure for `xinJingjiaHandle`
-- 非由其他报盘转的竞价报盘在阶段时间结束时执行的过程
-- 不分阶段了，只有一个阶段
-- ----------------------------
DROP PROCEDURE IF EXISTS `xinJingjiaHandle`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `xinJingjiaHandle`(IN `offerID` int,OUT `return_status` int)
BEGIN
	#非由其他报盘转的竞价报盘在结束时间执行的过程
  DECLARE baojia_user INT(11) default 0;#当前报价的用户
  DECLARE mode_id   INT(11) ;#报盘模式
  DECLARE offer_num DECIMAL(15,2);#报盘数量
  DECLARE max_price DECIMAL(15,2);#报价最高价
  DECLARE baojia_id INT(11);#价格最高的报价id

  DECLARE offer_status INT(2) default 1;#报盘状态

  #获取状态为正常且id为offer_id的竞价报盘的竞价阶段id
  select `mode`,max_num INTO mode_id ,offer_num FROM product_offer where id = offerID AND sub_mode=1 AND `status`=1;
  start TRANSACTION;

   #生成订单要重新获取最新的报价数据
   SELECT user_id ,price,id INTO baojia_user,max_price,baojia_id FROM product_jingjia WHERE `offer_id`=offerID ORDER BY price desc LIMIT 1;

   IF baojia_user>0 THEN  #生成订单

        SET offer_status=6;

        UPDATE product_jingjia SET win=1 WHERE id=baojia_id LIMIT 1;
        UPDATE product_offer SET status=offer_status,price=max_price,sell_num=offer_num  WHERE id=offerID;

        IF mode_id=4 THEN
         CALL  createStoreOrder(offerID,baojia_user, offer_num,1,0,1);
        ELSEIF mode_id=2 THEN
          CALL  createDepositOrder(offerID,baojia_user, offer_num,1,0,1);
        ELSEIF mode_id=1 THEN
          CALL createFreeOrder(offerID,baojia_user, offer_num,1,0,1);
        END IF;
        set return_status=6;
   ELSE  #报盘改成已过期
       SET offer_status=5;
       UPDATE product_offer SET `status`=offer_status WHERE id=offerID;
       set return_status=5;
   END IF;


  COMMIT;


END
;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `jingjiaHandle`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `jingjiaHandle`(IN `offerid` int,IN `userid` int,IN `maxprice` decimal)
BEGIN
  DECLARE selected_user INT default 0;
    DECLARE offer_status INT(11);
    DECLARE old_offer_id INT(11);
    DECLARE maxnum DECIMAL(15,2);
    DECLARE max_price DECIMAL(15,2);
    DECLARE mode_id INT(11);
    DECLARE offerStatus TINYINT(2);
    IF userid>0  THEN
     SET selected_user = userid;
     SET max_price = maxprice;
     ELSE
      start TRANSACTION;/*传入的用户id为0时开启事务,因为userid>0时是客户端程序调用的，客户端程序有事务*/
      SELECT   user_id ,price INTO selected_user,max_price  from product_jingjia  WHERE offer_id=offerid order by price desc limit 1;
    END IF;
   /*获取旧报盘和报盘数量,报盘模式*/
      SELECT old_offer,max_num ,mode,status  INTO old_offer_id,maxnum,mode_id,offerStatus FROM product_offer WHERE id=offerid;
      /*判断商品剩余量，只有在剩余大于0的时候才操作*/
    IF offerStatus=1 THEN
            IF selected_user>0  THEN
               SET offer_status= 6;
               UPDATE product_jingjia SET win=1 WHERE offer_id=offerid AND user_id=selected_user ORDER BY price desc LIMIT 1;
               UPDATE product_offer SET status=offer_status,price=max_price,sell_num=maxnum  WHERE id=offerid;

              /*调用生成订单的程序,出入参数依次是报盘id,买方id,购买数量，支付类型（全款、订金），支付金额，支付方式*/
              IF mode_id=4 THEN
               CALL  createStoreOrder(offerid,selected_user, maxnum,1,0,1);
              ELSEIF mode_id=2 THEN
                CALL  createDepositOrder(offerid,selected_user, maxnum,1,0,1);
              ELSEIF mode_id=1 THEN
                CALL createFreeOrder(offerid,selected_user, maxnum,1,0,1);
               END IF;
            ELSE
                SET offer_status=5;

                  UPDATE product_offer SET max_num=max_num +   maxnum WHERE id=old_offer_id;
                  #如果报盘未过期，改为正常状态
                  UPDATE product_offer SET `status`=1  WHERE id=old_offer_id AND NOW() < expire_time;
                  #如果报盘已过期，改为过期状态
                  UPDATE product_offer SET `status`=5  WHERE id=old_offer_id AND NOW() >= expire_time;
                  UPDATE product_offer SET status=offer_status ,max_num=0 WHERE id=offerid;
            END IF;
    END IF;




    IF userid=0 THEN
       commit;
    END IF;
END
;;
DELIMITER ;

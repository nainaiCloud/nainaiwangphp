<?php
namespace admintool;

/**
* 导出的下载字段数据配置
*/
class Downconfig 
{
     
     public static function getConfig($type){
          $config = array();
          switch ($type) {
            case 'Acc':
                $config = array('username' => '用户名', 'mobile' => '手机号', 'amount' => '总金额', 'fund' => '可用资金', 'freeze' => '冻结资金');
                break;
            case 'Credit':
                $config = array('username' => '用户名', 'mobile' => '手机号', 'credit' => '信誉保证金');
                break;
           case 'user_bank':
                $config = array('username' => '用户名', 'true_name' => '姓名', 'bank_name' => '开户银行', 'card_type' => '银行卡类型', 'identify_no' => '身份证号', 'status_text' => '状态');
                break;
            case 'withdraw_request':
                $config = array('username' => '用户名', 'mobile' => '手机号', 'request_no' => '订单号', 'amount' => '金额', 'status_text' => '状态', 'create_time' => '时间');
                break;
            case 'recharge_orderline':
                $config = array('username' => '用户名', 'order_no' => '订单号', 'amount' => '金额','pay_type'=>'充值方式', 'status_text' => '状态', 'create_time' => '时间');
                break;
              case 'recharge_orderoff':
                $config = array('username' => '用户名', 'order_no' => '订单号', 'amount' => '金额', 'status_text' => '状态', 'create_time' => '时间');
                break;
          }
          return $config;
     }
}
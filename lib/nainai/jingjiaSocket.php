<?php
/**
 * User: weipinglee
 * Date: 2018/7/14
 * Time: 15:41
 */

/**
 * 欠缺：
 * 1.定时关闭长时间未发送心跳的连接
 * 2.清除时间结束的offer_id
 */
namespace nainai;

require_once dirname(__DIR__)."/vendor/autoload.php";

use \Workerman\Worker;
use Nette\Utils\Json;
use Workerman\Lib\Timer;
use \nainai\offer\jingjiaOffer;
class jingjiaSocket
{
    protected $worker= null;

    //记录每个报盘下面的连接id,有新报价时给相应连接发送信息
    protected $offerData = array();//array(offer_id=>array(connection_id,,,,),...)

    protected $db = null;

    protected $offerObj = null;


    private function connectMysql(){
        if($this->db!=null){
            $this->db->closeConnection();
        }
        $db_config = \Library\tool::getConfig(array('database','master'));
        $this->db = new \Workerman\MySQL\Connection($db_config['host'], '3306', $db_config['user'], $db_config['password'], $db_config['database']);

    }
    public function __construct()
    {
        $this->worker = new Worker();
        $this->connectMysql();
        $this->offerObj = new jingjiaOffer();
        $this->worker->onWorkerStart = function ($worker){
            echo "Worker starting...\n";
            syslog::info("命令行程序启动 ");

            //每个一个小时重新生成db连接
            Timer::add(3600,function()use($worker){
                $this->connectMysql();
                syslog::info("命令行mysql重新连接");
            });
            //定时检查竞价订单，有新订单生成，通知买卖方
            Timer::add(5, function()use($worker){
                try{
                    //查找内存表order_notice中未通知的竞价报盘
                    $offer = $this->db->select('offer_id')->from('order_notice')->where("auto_notice=0 ")->query();
                    if(!empty($offer)){
                        $offerIds = array();
                         foreach($offer as $item){
                             $offerIds[]=$item['offer_id'];
                         }
                        $this->db->update('order_notice')->cols(array('auto_notice'=>1))->where("offer_id in (".join($offerIds,',').")")->query();
                       // $offerObj = new jingjiaOffer();
                        foreach($offer as $item){
                            $this->offerObj->endNotice($item['offer_id']);
                            syslog::info("jingjia ".$item['offer_id']." 结束 , 给卖方买方发送短信");
                            echo "jingjia ".$item['offer_id']." has come to end , send message to users \n";

                        }


                    }
                  
                }catch(\Exception $e){
                    $this->connectMysql();
                }

            });
        };


    }

    public function run(){
        Worker::runAll();
    }




}
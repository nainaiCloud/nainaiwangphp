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

    public function __construct()
    {
        $this->worker = new Worker("http://localhost:89");

        $db_config = \Library\tool::getConfig(array('database','master'));
        $this->db = new \Workerman\MySQL\Connection($db_config['host'], '3306', $db_config['user'], $db_config['password'], $db_config['database']);

        $this->worker->onWorkerStart = function ($worker){
            echo "Worker starting...\n";
            //定时检查每个连接发送包的时间，长时间未发送则close
//            Timer::add(1, function()use($worker){
//                $time_now = time();
//                foreach($worker->connections as $connection) {
//                    // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
//                    if (empty($connection->lastMessageTime)) {
//                        $connection->lastMessageTime = $time_now;
//                        continue;
//                    }
//                    // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
//                    if ($time_now - $connection->lastMessageTime > 50) {
//                        $connection->close();
//                    }
//                   // echo count($worker->connections);
//                    print_r($this->offerData);
//                }
//            });

            //定时检查竞价订单，有新订单生成，通知买卖方
            Timer::add(5, function()use($worker){
                //查找最近1分钟内结束的竞价offer
                $offer = $this->db->select('offer_id')->from('order_notice')->where("auto_notice=0 ")->query();
                if(!empty($offer)){
                    $offerIds = array();
                     foreach($offer as $item){
                         $offerIds[]=$item['offer_id'];
                     }
                    $this->db->update('order_notice')->cols(array('auto_notice'=>1))->where("offer_id in (".join($offerIds,',').")")->query();

                    foreach($offer as $item){
                        $jingjiaOffer = new jingjiaOffer();
                        $jingjiaOffer->endNotice($item['offer_id']);
                        echo "jingjia ".$item['offer_id']." has come to end , send message to users \n";
                    }
                }

            });
        };




    }

    /**
     *
     */
    public function receiveMessage(){

        /**
         * 接受json，格式{cookie:'',type:'',data:{操作的数据}}，type可取值list,baojia(报价）
         * @param $connection
         * @param $data
         * @throws \Nette\Utils\JsonException
         */
//        $this->worker->onMessage = function($connection, $data)
//        {
//
//            try{
//                $data = Json::decode($data,true);
//
//                //鉴权，如果未登录，关闭连接，返回json
//                $user_id = 0;
//                if(!isset($data['cookie']) || !$user_id=$this->checkLogin($data['cookie'])){
//                    $returnJson = Json::encode(array('success'=>0,'info'=>'请先登录再进行操作'));
//                    $connection->send($returnJson);
//                }else{//已经登陆，可以进行操作了
//                    $connection->user_id=$user_id;
//                    $connection->lastMessageTime = time();
//                    if(!isset($data['type']) ){
//                        $returnJson = Json::encode(array('success'=>0,'info'=>'数据传输错误'));
//                        $connection->send($returnJson);
//                    }else{
//                        switch($data['type']){
//                            case 'list' : {//获取所有报价
//                                $offer_id = isset($data['data']['offer_id']) ? $data['data']['offer_id'] : 0;
//                                if(!in_array($connection->id,$this->offerData[$offer_id])){
//                                    $this->offerData[$offer_id][] = $connection->id;
//                                }
//                                $connection->offer_id = $offer_id;
//                                $baojiaData = $this->allBaojia($offer_id);
//                                $connection->send(Json::encode($baojiaData));
//                            };
//                            break;
//
//                            case 'baojia':{//
//                                $offer_id = isset($data['data']['offer_id']) ? $data['data']['offer_id'] : 0;
//                                $price = isset($data['data']['price']) ? $data['data']['price'] : 0;
//                                $jingjiaObj = new JingjiaOffer();
//                                $baojiaRes = $jingjiaObj->baojia($offer_id,$price,$connection->user_id);
//                                //$baojiaRes = array('success'=>1,'info'=>'123');
//                                $connection->send(Json::encode($baojiaRes));//发送报价结果
//                                if($baojiaRes['success']==1){//报价成功，给其他用户发送
//                                    $allBaojia = Json::encode($this->allBaojia($offer_id));
//                                    foreach($this->offerData[$offer_id] as $connID){
//                                        if(isset($this->worker->connections[$connID])){
//                                            $this->worker->connections[$connID]->send($allBaojia);
//                                        }
//
//                                    }
//                                }
//
//                            } ;
//                            break;
//
//                            case 'heart' : {
//                                $send = array('heart'=>1);
//                                $connection->send(Json::encode($send));
//                            };
//                            break;
//                        }
//
//                    }
//
//                }
//
//
//            }catch(\Exception $e){
//                $returnJson = Json::encode(array('success'=>0,'info'=>$e->getMessage()));
//                $connection->send($returnJson);
//            }
//
//
//        };
    }

    public function run(){
        //某个连接关闭时，清除这个连接在offerData中的数据，也就不在给他
//        $this->worker->onClose = function ($connection){
//            if(!empty($this->offerData)){
//                foreach($this->offerData as $offer_id=>$item){
//                    if(!empty($item)) {
//                        foreach ($item as $key => $conn) {
//                            if ($connection->id == $conn) {
//                                unset($this->offerData[$offer_id][$key]);
//                            }
//                        }
//                    }
//                    if(empty($this->offerData[$offer_id])){
//                        unset($this->offerData[$offer_id]);
//                    }
//                }
//            }
//        };
        Worker::runAll();
    }


    /**
     * 检验是否登陆，若登陆返回用户id
     * @param $cookie
     * @return int 登陆的用户id
     */
    private function checkLogin($cookie){
        $loginData = $this->db->select('session_data')->from('user_session')->where('session_id=:cookie and UNIX_TIMESTAMP()<session_expire')
            ->bindValue('cookie',$cookie)->row();
        //print_r($loginData);
        if(isset($loginData['session_data'])){//登陆有效
            $data = unserialize($loginData['session_data']);
            return $data['user_id'];

        }else{
            return 0;
        }

    }

    private function allBaojia($offer_id){
        $sql = "select j.*,u.true_name from product_jingjia as j left join user as u on j.user_id=u.id where j.offer_id=".$offer_id;
        $data = $this->db->query($sql);
        return $data;
    }

}
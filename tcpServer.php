<?php

use \Workerman\Worker;
use Nette\Utils\Json;
require_once __DIR__."/lib/vendor/autoload.php";

$worker = new Worker("websocket://localhost:89");


$worker->onWorkerStart = function ($connection){
    echo "Worker starting...\n";
};


$worker->onConnect = function ($conn){
    echo 'IP:'.$conn->getRemoteIp().'������';
};

//

$offerData = array(

);//array(offer_id=>array(count=>,baojia=>array(),conns=>array()),...)
$worker->onWorkerStart =function ($worker){
    //
};
$worker->onMessage = function($connection, $data)
{

    try{
        $data = Json::decode($data,true);
        //��Ȩ�����δ��¼��û��offer_id�������ر����ӣ�����json

        //����ѵ�¼��
        $connection->offer_id = $data['offer_id'];
        echo $connection->offer_id;
        global $offerData;
        if(!isset($offerData[$data['offer_id']])){//�ñ��̳������ӣ���ʼ������
            $offerData[$data['offer_id']] = array('count'=>0,'baojia'=>array(),'conns'=>array());
        }
        if(!in_array($connection->id,$offerData[$data['offer_id']]['conns'])){
            $offerData[$data['offer_id']]['conns'][] = $connection->id;
        }
        //��ȡ�������ݸ��򷽷��ͣ�֮���б仯�ٷ���


        $connection->send(Json::encode($baojia));
        print_r($regOffer);
        $connection->send($data['cookie']);
    }catch(\Exception $e){
        echo $e->getMessage();
    }

    //$connection->send('123qwe');
    //echo $data;
};

foreach($regOffer as $offer_id=>$conn){
    if(!empty($conn)){
        //��ѯoffer_id�ľ��۱���

    }
}

function allBaojia($offer_id){
    $db = new \Workerman\MySQL\Connection('localhost', '3306', 'root', '123456', 'nn_dev');
    $sql = "select j.*,u.true_name from product_jingjia as j left join user as u on j.user_id=u.id where j.offer_id=".$offer_id;
    $data = $db->query($sql);
    return $data;
}

function
// ����worker
Worker::runAll();
?>

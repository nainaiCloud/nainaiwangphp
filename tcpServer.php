<?php

use \Workerman\Worker;
use Nette\Utils\Json;
require_once __DIR__."/lib/vendor/autoload.php";

$worker = new Worker("websocket://localhost:89");


$worker->onWorkerStart = function ($connection){
    echo "Worker starting...\n";
    //��ʱ���ÿ�����ӷ��Ͱ���ʱ�䣬��ʱ��δ������close
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
        //���򷽷�����ʱ�ı������ݣ�֮���б仯�ٷ���
        $connection->send(Json::encode($offerData[$data['offer_id']]['baojia']));


    }catch(\Exception $e){
        echo $e->getMessage();
    }

    //$connection->send('123qwe');
    //echo $data;
};

//��ѯ
if(!empty($offerData)){
    foreach($offerData as $offer_id=>$item){
        $new = baojiaCount($offer_id);
        global $worker;
        global $offerData;
        if($new){//���±���
            $newBaojia = allBaojia($offer_id);
            $offerData[$offer_id]['baojia']=$newBaojia;
            if(!empty($item['conn'])){
                foreach($item['conn'] as $conn){//��ÿ�����ӷ����±�������
                    $worker->connections[$conn]->send(Json::encode($newBaojia));
                }
            }

        }
    }
}

$db = new \Workerman\MySQL\Connection('localhost', '3306', 'root', '123456', 'nn_dev');

function allBaojia($offer_id){
    global $db;
    $sql = "select j.*,u.true_name from product_jingjia as j left join user as u on j.user_id=u.id where j.offer_id=".$offer_id;
    $data = $db->query($sql);
    return $data;
}

function baojiaCount($offer_id){
    global $db;
    global $offerData;
    $count = $db->select("count(id) as num")->from('product_jingjia')
        ->where('offer_id:offer_id')->bindValues(array('offer_id'=>$offer_id))->single();
    if($count>$offerData[$offer_id]['count']){
        $offerData[$offer_id]['count']=$count;
        return true;
    }else{
        return false;
    }
}
// ����worker
Worker::runAll();
?>

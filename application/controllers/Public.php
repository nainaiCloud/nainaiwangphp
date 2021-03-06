<?php
/**
 * 交易中心不需要登录的控制器公共类
 */
use \Library\url;
use \nainai\offer\product;
class PublicController extends \Yaf\Controller_Abstract{

     public $login;

     public function init(){
          $this->getView()->setLayout('layout');
         $right = new \Library\checkRight();
         $isLogin = $right->checkLogin();
         if($isLogin){
             $this->login = \Library\session::get('login');
             $messObj=new \nainai\message($this->login['user_id']);
             $mess=$messObj->getCountMessage();
             $this->getView()->assign('mess',$mess);
             $login = 1;
         }
         else
             $login = 0;
          //获取所有分类
          $cacheObj = new \Library\cache\Cache(array('type'=>'m','expire'=>3600));
          if($res=$cacheObj->get('allCateData')){
               $res = unserialize($res);
          }
          else{
               $productModel=new product();
               $res=$productModel->getAllCat();
               $res = array_slice($res,0,6);
               $cacheObj->set('allCateData',serialize($res));
          }

          $this->getView()->assign('catList',$res);
       //   $frdLink = new \nainai\system\friendlyLink();
          //获取帮助
          $helpModel=new \nainai\system\help();
          $helpList=$helpModel->getHelplist();
          $this->getView()->assign('helpList2',$helpList);
          //获得服务列表
          $fuwuList=\nainai\SiteHelp::getFuwuList();
          $this->getView()->assign('fuwuList',$fuwuList);
          //获取友情链接
          $frdLinkModel= new \nainai\system\friendlyLink();
          $frdLinkList=$frdLinkModel->getFrdLink(20);
          $this->getView()->assign('frdLinkList',$frdLinkList);

          
          $model = new \nainai\system\DealSetting();
          $deal = $model->getsetting();
          $this->getView()->assign('deal', $deal);
          $this->getView()->assign('login',$login);

     }



     protected function success($info = '操作成功！',$redirect = ''){
          if(isset($redirect)){
               $redirect = str_replace('%','||',urlencode($redirect));
          }
          
          $this->redirect(url::createUrl("/Oper/success?info={$info}&redirect={$redirect}"));
     }

     protected function error($info = '操作失败！',$redirect = ''){

          if(isset($redirect)){
               $redirect = str_replace('%','||',urlencode($redirect));
          }
          $this->redirect(url::createUrl("/Oper/error?info={$info}&redirect={$redirect}"));
     }

     protected function confirm($info = '确认此项操作？',$redirect = ''){

          if(isset($redirect)){
               $redirect = str_replace('%','||',urlencode($redirect));
          }
          $this->redirect(url::createUrl("/Oper/confirm?info={$info}&redirect={$redirect}"));
     }

}
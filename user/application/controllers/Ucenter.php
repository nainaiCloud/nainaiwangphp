<?php
/**
 * 用户中心
 * User: weipinglee
 * Date: 2016/3/4 0004
 * Time: 上午 9:35
 */
use \Library\checkRight;
use \Library\photoupload;
use \Library\json;
use \Library\url;
use \Library\safe;
use \Library\Thumb;
use \Library\tool;
class UcenterController extends Yaf\Controller_Abstract {


    public function init(){
        $right = new checkRight();
        $right->checkLogin($this);//未登录自动跳到登录页
        $this->getView()->setLayout('ucenter');
    }
    /**
     * 个人中心首页
     */
    public function indexAction(){

    }

    /**
     * 基本信息修改
     */
    public function infoAction(){
        $user_id = $this->user_id;
        $userModel = new userModel();
        if($this->user_type==0){
            $user_data = $userModel->getPersonInfo($user_id);
            if($user_data['birth']==0)$user_data['birth'] = '';
            if($user_data['head_photo']!='')
                $user_data['head_photo_thumb'] = Thumb::get($user_data['head_photo'],180,180);
            if($user_data['identify_front']!='')
             $user_data['identify_front_thumb'] = Thumb::get($user_data['identify_front'],180,180);
            if($user_data['identify_back']!='')
            $user_data['identify_back_thumb'] = Thumb::get($user_data['identify_back'],180,180);

        }
        else{
            $user_data = $userModel->getCompanyInfo($user_id);
            if($user_data['head_photo']!='')
                $user_data['head_photo_thumb'] = Thumb::get($user_data['head_photo'],180,180);
            if($user_data['cert_bl']!='')
                $user_data['cert_bl_thumb'] = Thumb::get($user_data['cert_bl'],180,180);
            if($user_data['cert_oc']!='')
                $user_data['cert_oc_thumb'] = Thumb::get($user_data['cert_oc'],180,180);
            if($user_data['cert_tax']!='')
                $user_data['cert_tax_thumb'] = Thumb::get($user_data['cert_tax'],180,180);

        }

        $this->getView()->assign('user',$user_data);
        $this->getView()->assign('type',$this->user_type);
        $this->getView()->assign('id',$user_id);


    }

    /**
     * 修改密码页面
     *
     */
    public function passwordAction(){
        $this->getView()->assign('id',$this->user_id);
    }

    /**
     * 修改密码动作
     */
    public function chgPassAction(){
        $user_id = $this->user_id;
        $pass = array('old_pass'=>$_POST['old_pass'],'password'=>$_POST['new_pass'],'repassword'=>$_POST['new_repass']);

        $userModel = new userModel();
        $res = $userModel->changePass($pass,$user_id);
        if(isset($res['success']) && $res['success']==1){

            $this->redirect('info');
        }
        else{
            echo $res['info'];
        }
        return false;
    }



    /**
     * ajax上传图片
     * @return bool
     */
    public function uploadAction(){

            //调用文件上传类
            $photoObj = new photoupload();
            $photoObj->setThumbParams(array(180,180));
            $photo = current($photoObj->uploadPhoto());

            if($photo['flag'] == 1)
            {
                $result = array(
                    'flag'=> 1,
                    'img' => $photo['img'],
                    'thumb'=> $photo['thumb'][1]
                );
            }
            else
            {
                $result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
            }
            echo JSON::encode($result);

        return false;
    }

    /**
     * 修改用户信息
     */
    public function personUpdateAction(){
        if(!IS_POST || !isset($_POST['id'])){
            $this->redirect('index');
            return false;
        }

        $userData['user_id'] = safe::filterPost('id','int');
        if($this->user_id == $userData['user_id']){
            $userData['username'] = safe::filterPost('username');
            $userData['email'] = safe::filterPost('email','email');
            $userData['head_photo'] = tool::setImgApp(safe::filterPost('imgfile3'));
            $personData['true_name'] = safe::filterPost('true_name');
            $personData['sex'] = safe::filterPost('sex','int',0);
            $personData['birth'] = safe::filterPost('birth','date');
            $personData['education'] = safe::filterPost('education','int');
            $personData['qq'] = safe::filterPost('qq');
            $personData['zhichen'] = safe::filterPost('zhichen');
            $personData['identify_no'] = safe::filterPost('identify_no');
            $personData['identify_front'] = tool::setImgApp(safe::filterPost('imgfile1'));
            $personData['identify_back'] = tool::setImgApp(safe::filterPost('imgfile2'));

            $um = new userModel();
            $res = $um->personUpdate($userData,$personData);
            if(isset($res['success']) && ($res['success']==1 || $res['success']==2)){
                if($res['success']==1){//数据发生变化，更改认证状态
                    $certObj = new \nainai\certificate();
                    $certObj->certInit($this->user_id);
                }
                $this->redirect('info');
            }
            else{
                echo $res['info'];
            }

        }
        return false;
    }

    /**
     * 修改企业用户信息
     */
    public function companyUpdateAction(){
        if(!IS_POST || !isset($_POST['id']))
            $this->redirect('index');
        $userData['user_id'] = $_POST['id'];
        if($this->user_id == $userData['user_id']){
            $userData['username'] = safe::filterPost('username');
            $userData['email'] = safe::filterPost('email','email');
            $userData['head_photo'] = tool::setImgApp(safe::filterPost('imgfile4'));

            $companyData['company_name'] = safe::filterPost('company_name');
            $companyData['area'] = safe::filterPost('area','/\d{4,6}/');
            $companyData['address'] = safe::filterPost('address');
            $companyData['category'] = safe::filterPost('category','int');
            $companyData['nature'] = safe::filterPost('nature','int');
            $companyData['legal_person'] = safe::filterPost('legal_person');
            $companyData['reg_fund'] = safe::filterPost('reg_fund','float');
            $companyData['contact'] = safe::filterPost('contact');
            $companyData['contact_duty'] = safe::filterPost('contact_duty','int');
            $companyData['contact_phone'] = safe::filterPost('contact_phone','/^\d+$/');
            $companyData['check_taker'] = safe::filterPost('check_taker');
            $companyData['check_taker_phone'] = safe::filterPost('check_taker_phone','/^\d+$/');
            $companyData['check_taker_add'] = safe::filterPost('check_taker_add');
            $companyData['deposit_bank'] = safe::filterPost('deposit_bank');
            $companyData['bank_acc'] =safe::filterPost('bank_acc','/^\d+$/');
            $companyData['tax_no'] = safe::filterPost('tax_no');
            $companyData['qq'] = safe::filterPost('qq','/^\d{4,20}$/');
            $companyData['cert_bl'] = tool::setImgApp(safe::filterPost('imgfile1'));
            $companyData['cert_oc'] = tool::setImgApp(safe::filterPost('imgfile2'));
            $companyData['cert_tax'] = tool::setImgApp(safe::filterPost('imgfile3'));

            //  print_r($personData);exit;
            $um = new userModel();
            $res = $um->companyUpdate($userData,$companyData);

            if(isset($res['success']) && ($res['success']==1 || $res['success']==2)){
                if($res['success']==1){//数据发生变化，更改认证状态
                    $certObj = new \nainai\certificate();
                    $certObj->certInit($this->user_id);
                }
                $this->redirect('info');
            }
            else{
                echo $res['info'];
            }

        }
        return false;
    }

    /**
     * 交易商认证页面
     */
    public function dealCertAction(){

        $user_id = $this->user_id;
        $cert = new \nainai\certificate();
        $res = $cert->getCertShow($user_id,'deal');//获取显示数据
        $this->getView()->assign('cert',$res);

    }
    /**
     * 仓库认证
     */
    public function storeCertAction(){
        $user_id = $this->user_id;
        $cert = new \nainai\certificate();
        $res = $cert->getCertShow($user_id,'store');//获取显示数据
        $this->getView()->assign('cert',$res);
    }


    /**
     *交易商认证处理
     *
     */
    public function doDealCertAction(){

        if(IS_AJAX){
            $user_id = $this->user_id;
            $cert = new \nainai\certificate();
            if(!empty($res = $cert->checkUserInfo($user_id,$this->user_type))){//用户信息不完整
                $res['return']=Url::createUrl('/ucenter/info');
                echo JSON::encode($res);
                exit;
            }
            else if($res=$cert->certDealApply($user_id)) {//提交成功
                echo JSON::encode(Tool::getSuccInfo());
                exit;
            }
            else{
               echo JSON::decode(Tool::getSuccInfo(0,'系统繁忙，稍后再试',Url::createUrl('/ucenter/dealCert')));
                exit;
            }
        }
        return false;

    }

    /**
     * 仓储认证处理
     * @return bool
     */
    public function doStoreCertAction(){
        if(IS_AJAX){
            $user_id = $this->user_id;
            $cert = new \nainai\certificate();
            $store_id = intval($_POST['store']);
            if(!empty($res = $cert->checkUserInfo($user_id,$this->user_type))){//用户信息不完整
                $res['return']=Url::createUrl('/ucenter/info');
                echo JSON::encode($res);
                exit;
            }
            else if($res=$cert->certStoreApply($user_id,$store_id)) {//提交成功

                echo JSON::encode(Tool::getSuccInfo());
                exit;
            }
            else{
                echo JSON::decode(Tool::getSuccInfo(0,'系统繁忙，稍后再试',Url::createUrl('/ucenter/dealCert')));
                exit;
            }
        }
        return false;
    }

    /**
     * 添加子账户页面
     */
    public function subAccAction(){

        $arr = $this->getRequest()->getParams();print_r($arr);
        $uid = safe::filter($arr['uid'],'int','');
        $user_data = array(
            'id'      => $uid,
            'username'=>'',
            'email'   => '',
            'mobile'  => '',
            'head_photo' => '',
            'status'     => 1,

        );
        if($uid){

            $userModel = new UserModel();
            $user_data = $userModel->getUserInfo($uid,$this->user_id);

            if(empty($user_data))
                $this->redirect('subAccList');
            if($user_data['head_photo']!='')
            $user_data['head_photo_thumb'] = Thumb::get($user_data['head_photo'],180,180);
        }


        $this->getView()->assign('user',$user_data);

    }



    /**
     * 子账户添加处理
     */
    public function doSubAccAction(){
        if(IS_POST){
            $data = array();
            $data['user_id'] = safe::filterPost('id','int',0);
            $data['pid'] = $this->user_id;
            $data['username'] = safe::filterPost('username');
            $data['mobile'] = safe::filterPost('mobile','/^\d+$/');
            $data['email']    = safe::filterPost('email','email');
            $data['password'] = safe::filterPost('password','/^\S{6,20}$/');
            $data['repassword'] = safe::filterPost('repassword','/^\S{6,20}$/');
            $data['head_photo'] = tool::setImgApp(safe::filterPost('imgfile1'));
            $data['status']     = safe::filterPost('status','int');
            $userModel = new UserModel();
            if($data['user_id']==0)//新增子账户
                 $res = $userModel->subAccReg($data);
            else{//更新子账户
                if($data['password'] == ''){//账户密码为空则不修改密码
                    unset($data['password']);
                    unset($data['repassword']);
                }

                $res = $userModel->subAccUpdate($data);
            }

            if(isset($res['success']) && $res['success']==1){
                $this->redirect('subAccList');
            }
            else echo $res['info'];
        }
        return false;
    }





}
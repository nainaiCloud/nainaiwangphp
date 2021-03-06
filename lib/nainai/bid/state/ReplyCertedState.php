<?php
/**
 * @copyright (c) 2017 nainaiwang.com
 * @file stateBase.php
 * @brief �б��ʼ����
 * @author weipinglee
 * @date 2017-6-5
 * @version 1.0
 */

namespace nainai\bid\state;


class replyCertedState extends stateBase
{
    public function init($args)
    {
        return $this->errInfo;
    }

     public function release($pay_type)
     {
         return $this->errInfo;
     }

     public function verify($status,$mess='')
     {
         return $this->errInfo;
     }

     public function bidRerelease($data){
         return $this->errInfo;
     }

     public function bidCancle(){
         return $this->errInfo;
     }

     public function bidClose(){
         return $this->errInfo;
     }

     public function replyCreate(){
         return $this->errInfo;
     }

     public function replyUploadCerts($reply_user_id,$certs){
         return $this->errInfo;
     }

    public function replySubmitCert()
    {
        return $this->errInfo;
    }

     public function replyCertsVerify($status)
     {
         $newStatus = $status==1 ? self::REPLY_CERT_VERIFYSUCC : self::REPLY_CERT_VERIFYFAIL;
         $this->bidObj->setReplyStatus($this->replyID,$newStatus);
         return $this->bidObj->getSuccInfo();
     }

 public function replyCertAdd($reply_id,$cert)
 {
     return $this->errInfo;
 }

 public function replyCertDel($cert_id,$reply_id){
     $this->bidObj->beginTrans();
     $this->bidObj->delReplyCerts($cert_id);
     $this->bidObj->setReplyStatus($reply_id,self::REPLY_CREATE);
     return $this->bidObj->commit();
 }



 public function replyDocUpload($upload){
     return $this->errInfo;
 }
     public function replyPaydocFee($pay_type){
         return $this->errInfo;
     }

     public function replySubmitPackage($data,$upload){
         return $this->errInfo;
     }

    public function bidStop()
    {
        return $this->errInfo;
    }

    public function bidComment($content,$user_id)
    {
        return $this->errInfo;
    }

    public function rebackReplyBail($bid_id){
        return $this->errInfo;
    }
}
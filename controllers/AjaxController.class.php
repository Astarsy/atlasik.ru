<?php
class AjaxController extends AbstractController{
    // A AJAX request controller
    public function messagesMethod(){
        // Returns array of messages for user_id as json string
        $args=AppController::getInstance()->getArgsNum();
        if(!isset($args[0]))exit;
        $uid=Utils::clearUInt($args[0]);
        $res=ShopDB::getInstance()->getMessages($uid);
        $jstr=json_encode($res);
        print $jstr;
        exit;
    }

    public function getMsgHeadersMethod(){
        $uid=$this->getUser()->id;
        if(null===$uid){
            $res=ShopDB::getInstance()->getLastMsgHeaders();
        }else{
            $res=ShopDB::getInstance()->getUserMsgHeaders($uid);
        }
        $jstr=json_encode($res);
        print $jstr;
        exit;
    }
}
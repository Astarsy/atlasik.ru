<?php
class AjaxController extends AbstractController{
    // A AJAX request controller

    public function getMessagesMethod(){
        // Returns array of messages for user_id as json string form N-th record
        $args=AppController::getInstance()->getArgsNum();
        if(!isset($args[0]))exit;
        $uid=Utils::clearUInt($args[0]);
        $messages_count=0;
        if(isset($args[1]))$messages_count=Utils::clearUInt($args[1]);
        $msgs=ShopDB::getInstance()->getMessages($uid,$messages_count);
        $jstr=json_encode($msgs);
        print $jstr;
        exit;
    }

    public function getHeadersMethod(){
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
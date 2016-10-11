<?php
class AjaxController{
    // A AJAX request controller
    public function messagesMethod(){
        // Returns array of messages for user as json string
        $args=AppController::getInstance()->getArgsNum();
        if(!isset($args[0]))return;
        $uid=Utils::clearUInt($args[0]);
        $res=ShopDB::getInstance()->getMessages($uid);
        $jstr=json_encode($res);
        print $jstr;
    }
}
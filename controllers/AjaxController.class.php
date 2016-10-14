<?php
class AjaxController extends AbstractController{
    // A AJAX request controller

    public function reactMessagesMethod(){
        // Returns array of messages for user_id as json string with pagination
        $args=AppController::getInstance()->getArgsNum();
        if(!isset($args[0]))exit;
        $uid=Utils::clearUInt($args[0]);
        $page=$count=$messages_on_page=0;
        if(isset($args[1]))$page=Utils::clearUInt($args[1]);
        $msgs=ShopDB::getInstance()->getMessages($uid,$page,$count,$messages_on_page);
        $res=array('cur_page'=>$page,'messages_count'=>$count,'messages_on_page'=>$messages_on_page,'messages'=>$msgs);
        //print '<pre>';var_dump($res);exit;
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
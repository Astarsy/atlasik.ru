<?php
class AbstractController{
	
    public function errorMethod(){
        // Отображает текстовое сообщение по номеру- errors.id
        $fc=AppController::getInstance();
        $this->title='Ошибочка... ';
        $args=$fc->getArgsNum();
        $eid=$args[0]??2;
        $eid=Utils::clearUInt($eid);
        $this->error=$this->_db->getErrorById($eid);
        $fc->setContent($fc->render('default/error.twig.html',array('this'=>$this,)));
    }
}
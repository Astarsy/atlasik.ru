<?php
class DefaultController{
    // Контроллер поумолчанию, выводит основной контент.
    // Не наследует BaseController, т.к. не нужна проверка прав.
    // Использует собственный провайдер БД- ShopDB
    public function __construct(){
        $this->_host=$_SERVER['SERVER_NAME'];
        $this->_db=new ShopDB();
        $this->_logger=new Logger();
    }
    public function Method(){
        // Главная Витрина
        $fc=AppController::getInstance();
        $this->title='Ткани '.$_SERVER['HTTP_HOST'];
        $fc->setContent($fc->render('default/index.twig.html',array('this'=>$this,)));
    }
    public function errorMethod(){
        // Отображает текстовое сообщение по номеру- errors.id
        $fc=AppController::getInstance();
        $this->title='Ошибочка... ';
        $args=$fc->getArgsNum();
        $eid=Utils::clearUInt($args[0])??1;
        $this->error=$this->_db->getErrorById($eid);
        $fc->setContent($fc->render('default/error.twig.html',array('this'=>$this,)));
    }
}
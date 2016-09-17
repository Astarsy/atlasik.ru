<?php
class CabinetController extends BaseController{
    // Контроллер Кабинета Пользоваталя
    // Права для зарег. п-лей
    public function __construct(){
    	parent::__construct();
    	$this->cabinet=new Cabinet();//нужен для правильного создания формы
    }
    public function Method(){
        $fc=AppController::getInstance();
        $this->title='Личный кабинет';

        $fc->setContent($fc->render('cabinet/default.twig.html',array('this'=>$this,)));
    }
}
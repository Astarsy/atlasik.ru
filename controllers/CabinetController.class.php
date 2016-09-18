<?php
class CabinetController extends PermitController{
    // Контроллер Кабинета Пользоваталя
    // Права для зарег. п-лей
    public function __construct(){
    	parent::__construct();
    	$this->cabinet=new Cabinet($this->_user);//нужен для правильного создания формы
    }
    public function Method(){
        $fc=AppController::getInstance();
        $this->title='Личный кабинет';
        $this->cabinet->form->init($this->_user);
        $fc->setContent($fc->render('cabinet/default.twig.html',array('this'=>$this,)));
    }
}
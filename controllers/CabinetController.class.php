<?php
class CabinetController extends BaseController{
    // Контроллер Кабинета Пользоваталя
    // Права для зарег. п-лей
    public function Method(){
        $fc=AppController::getInstance();
        $this->title='Личный кабинет';

        $fc->setContent($fc->render('cabinet/default.twig.html',array('this'=>$this,)));
    }
}
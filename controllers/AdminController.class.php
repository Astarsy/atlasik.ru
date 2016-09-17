<?php
class AdminController extends BaseController{
    // Контроллер Админки
    // Права для админов
    public function Method(){
        $fc=AppController::getInstance();
        $this->title='Админка';

        $fc->setContent($fc->render('admin/default.twig.html',array('this'=>$this,)));
    }
}
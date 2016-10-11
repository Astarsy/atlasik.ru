<?php
class DefaultController extends AbstractController{
    // Контроллер поумолчанию, выводит основной контент.
    // Не наследует BaseController, т.к. не нужна проверка прав.
    // Использует собственный провайдер БД- ShopDB
    public function __construct(){
        parent::__construct();
        $this->_db=ShopDB::getInstance();
    }
    public function Method(){
        // Главная Витрина
        $fc=AppController::getInstance();
        $this->title='Ткани '.$_SERVER['HTTP_HOST'];
        $this->lenta=new Lenta();
        $fc->setContent($fc->render('default/index.twig.html',array('this'=>$this,)));
    }
    public function headersMethod(){
        // Главная Витрина
        $fc=AppController::getInstance();
        $this->title='Ткани '.$_SERVER['HTTP_HOST'];

        $headers=getallheaders();
        header('content-type: text/plain;');
        echo var_dump($headers);exit;

        $fc->setContent($fc->render('default/index.twig.html',array('this'=>$this,)));
    }
}
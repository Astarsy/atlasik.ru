<?php
abstract class BaseController extends AbstractController{
    // Базовый класс реализует проверку прав доступа на уровне контроллера
    // В данной реализации права хранятся в массивe $this->_perms 
    // Алгоритм проверки:
    // - (NULL) если class_name нет в limits- пустить;
    // - (0) если ограничение по регистрации- пустить;
    // - (1) если ограничение по админам- пустить;
    // - (>1) не пускать.
    // Т.е. 'SomeController'=>0 - доступ для зарег. п-лей
    protected $_perms=array(
            'CabinetController'=>0,
            'AdminController'=>1,
        );

    public function __construct(){
        //проверить права для Всего Контроллера
        $this->_logger=new Logger();
        $this->_user=$this->_logger->getUser();
        if(!$this->getPermitions($this->_user->id,get_class($this)))die('access denied');
        echo('Name: '.$this->_user->name.' ,mail: '.$this->_user->email.' ,access allow');
    }

    protected function getPermitions($uid,$cn){
        // Проверяет наличие прав, возвращяет true/false
        if(!isset($this->_perms[$cn]))return true;
        if(NULL===$this->_user->id||NULL===$this->_user->activated_date)return false;
        if($this->_perms[$cn]===0)return true;
        if(NULL===$this->_user->admin)return false;
        if($this->_perms[$cn]===1)return true;
        return false;
    }
}
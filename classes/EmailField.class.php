<?php
class EmailField extends TextField{
    // Поле с валидатором для Email
    // Проверить, нет ли такого email в базе
    public function validator(){
        parent::validator();//проверит наличие поля и значения, установит $this->_value
        $db=UserDB::getInstance();
        if($db->emailExists($this->_value)){
            $this->_err_msg='эл. адрес уже занят';
        }
    }
}
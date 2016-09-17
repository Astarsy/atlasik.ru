<?php
class PhoneField extends TextField{
    // Поле с валидатором для Строки
    public function validator(){
        parent::validator();//проверит наличие поля и значения
        if($this->_err_msg)return;
        // Phone validator
        $val=Utils::clearPhone($this->_value);
        if($val!=$this->_value){
            $this->_err_msg='Таких телефонов не бывает...';
            return;
        }
        $this->_value=$val;
    }
}
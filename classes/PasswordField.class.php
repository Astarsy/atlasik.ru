<?php
class PasswordField extends TextField{
    // Поле с валидатором для Пароля
    // ВНИМАНИЕ! Валидатор настраивается на конкретные
    // имена полей! (имена полей определяются в forms.ini)
    public function validator(){
        parent::validator();//проверит наличие поля и значения
        $val1=$_POST['password1'];
        $val2=$_POST['password2'];
        if($val1!==$val2){
            $this->_err_msg='пароли не совпадают';
            return;
        }
        $this->_value=$val1;
    }
}
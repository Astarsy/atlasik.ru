<?php
class CabinetForm extends ValidableForm{
	// Нужен для правильного создания полей формы
    public function init($user){
        // Инициализация полей:
        // по всем полям формы взять одноимённое свойство п-ля
        // и установить значение поля

        //header('content-type:text/plain');echo var_dump($user);exit;
        
        foreach($this->_fields as $field){
            $field->setValue($user->{$field->getName()});
        }
    }
}
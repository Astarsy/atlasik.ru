<?php
class ValidableForm{
	// Базовый класс формы

    protected $_fields=array();// объекты Field
    protected $_err_msg;// текст сообщения об ошибке

    public function addField($f){
    	// Добавляет новое поле в список полей
    	if(!$f instanceof ValidableField)return;
    	$this->_fields[]=$f;
    }
    public function validate(){
        foreach($this->_fields as $field){
            $field->validator();
            if($field->getErrMsg()){
                $this->_err_msg='Пожалуйста, правильно заполните форму.';
            }
        }
    }
    public function save(){
        foreach($this->_fields as $field){
            $field->save();
            if(NULL!==$err=$field->getErrMsg()){
                $this->_err_msg=$err;
                return;
            }
        }
    }
    public function getErrMsg(){
        return $this->_err_msg;
    }
    public function getFieldValue($name){
        // Returns a value of the field by name
        foreach($this->_fields as $f){
            if($f->getName()==$name)return $f->getValue();
        }
        return NULL;
    }
}
<?php
class FormFactory{
	// Фабрика классов Форм и Полей

    public function createForm($class_name){
    	// Создать Форму по имени Класса
    	// Возвращяет ValidableForm/NULL
        if(!class_exists($class_name))return;
        $rc=new ReflectionClass($class_name);
        $form=$rc->newInstance();
        if(!$form instanceof ValidableForm)return;
        $field_templates=$this->getFieldsOfForm($class_name);
        foreach($field_templates as $t){
            $form->addField($this->createField($t));
        }
        return $form;
    }
    protected function createField($t){
    	// Создать поле по шаблону
    	// Возвращает экз-р класса ValidableField/false
    	$cn=ucfirst($t->type).'Field';
    	if(!class_exists($cn))return;
        $rc=new ReflectionClass($cn);
        $field=$rc->newInstance($t);
    	return $field;
    }
    protected function getFieldsOfForm($class_name){
    	// Получить из хранилища список Полей
    	// Вернуть массив объектов
    	$strs=parse_ini_file(Globals\FORMS_INI_FILE,true);
    	$fields=$strs[$class_name]??array();
    	$objs=array();
    	foreach($fields as $k=>$v){
	    	$template=new stdClass();
	    	$template->name=$k;
	    	$strs=explode(',',$v);
	    	$template->type=$strs[0];
	    	$template->title=$strs[1];
	    	$template->required=$strs[2];
	    	$objs[]=$template;
    	}
    	return $objs;
    }
}
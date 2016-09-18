<?php
class Register{
	// Регистратор п-ля. Этот класс нужен для правильного создания формы по имени класса.
	public function __construct(){
		$factory=new FormFactory();
		$this->form=$factory->createForm(get_class($this).'Form');
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$this->form->validate();
			if(!$this->form->getErrMsg()){
				//TODO: saving data HERE
				$this->form->save();
				if(!$this->form->getErrMsg()){
					$db=UserDB::getInstance();
					if(!$db->saveRegister($this->form))exit(header('Location:/error/3'));
					exit(header('Location:/register/sended'));
				}
			}
		}
	}
}
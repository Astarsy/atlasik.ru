<?php
class Cabinet{
	// Кабинет п-ля. Этот класс нужен для правильного создания формы по имени класса.
	public function __construct(){
		$factory=new FormFactory();
		$this->form=$factory->createForm(get_class($this).'Form');
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$this->form->validate();
		}
	}
}
<?php
class Cabinet{
	// Кабинет п-ля
	public function __construct(){
		$factory=new FormFactory();
		$this->_form=$factory->createForm((get_class($this).'Form'));
	}
}
<?php
class ShopDB extends DB{
	// Провайдер данных для приложения Магазина
    static protected $_instance;

    public static function getInstance(){
        if(!(self::$_instance instanceof self))self::$_instance=new self();
        return self::$_instance;
    }
    
	public function getGoodById($mail){

	}
}
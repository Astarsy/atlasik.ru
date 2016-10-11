<?php
class Lenta{
    public  function __construct()
    {
        $this->_headers=ShopDB::getInstance()->getLentaHeaders();
    }

    public function getHeaders(){
        return $this->_headers;
    }

    public function  __toString()
    {
        return 'lenta/headers.twig.html';
    }
}
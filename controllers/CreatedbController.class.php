<?php
class CreatedbController{
    public function Method(){
        // !!! ОТЛАДКА создаёт НОВУЮ БД по запосам из файла create.sql
        //die('->'.time());
        header('Content-Type:text/plain;');
        echo'Создание НОВОЙ БД '.Globals\DB_NAME;
        $db=new DB();
        if($db->createTestDB())echo"\r\n->Ok";
        exit;
    }
}
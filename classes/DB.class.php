<?php
class DB{
// Базовый класс ддя всех Провайдеров данных приложения
	protected $_pdo;
    public function __construct(){
    $this->_pdo=new PDO(
        'mysql:host=localhost;dbname='.Globals\DB_NAME,
        Globals\DB_USER,
        Globals\DB_PASS);
    if(Globals\DEBUG)$this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    public function getErrorById($eid){
        // Возвращает объект ошибки или false
        try{
            $stmt=$this->_pdo->prepare(
            "SELECT id,title,text FROM errors WHERE id=:id");
            $stmt->bindParam(':id',$eid,PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // TODO: убрать из продакшн!
    public function createTestDB(){
        // Creates a test database
        $file=file_get_contents('create.sql');
        $sqlarr=explode(";",$file);
        foreach($sqlarr as $sql){
            if(empty($sql))continue;
            try{
                echo $sql;
                $this->_pdo->query($sql);
            }catch(PDOException $e){
                echo $e;
                exit;
            }
        }
        return true;
    }
}
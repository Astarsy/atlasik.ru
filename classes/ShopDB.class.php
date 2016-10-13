<?php
class ShopDB extends DB{
	// Провайдер данных для приложения Магазина
    static protected $_instance;

    public static function getInstance(){
        if(!(self::$_instance instanceof self))self::$_instance=new self();
        return self::$_instance;
    }

    public function getLastMsgHeaders(){
        // returns messages headers as array of objects
        try{
            $stmt=$this->_pdo->prepare("SELECT t1.* FROM (SELECT DISTINCT messages.id,title,text,user_id,users.name as user_name,time FROM messages LEFT JOIN users ON users.id=messages.user_id ORDER BY time DESC)as t1 GROUP BY user_id");
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserMsgHeaders($uid){
        // returns messages headers as array of objects, where first is a last for the user or NULL
        try{
            $stmt=$this->_pdo->prepare("SELECT t1.* FROM (SELECT messages.id,title,text,user_id,users.name as user_name,time FROM messages LEFT JOIN users ON users.id=messages.user_id WHERE user_id=:uid ORDER BY time DESC LIMIT 1)as t1 UNION SELECT t2.* FROM (SELECT DISTINCT messages.id,title,text,user_id,users.name as user_name,time FROM messages LEFT JOIN users ON users.id=messages.user_id WHERE user_id!=:uid ORDER BY time DESC)as t2 GROUP BY user_id LIMIT 9;");
            $stmt->bindParam(':uid',$uid,PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e){return null;}
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMessages($uid){
        // returns messages by user id as array of arrays
	    try{
            $stmt=$this->_pdo->prepare("
SELECT id,time,title,text FROM messages WHERE user_id=:uid ORDER BY time DESC LIMIT 10");
            $stmt->bindParam(':uid',$uid,PDO::PARAM_INT);
            $stmt->execute();
        }catch(PDOException $e){return $e;}
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

	public function getGoodById($mail){

	}

	public function getLentaHeaders(){
	    // returns last message for each user(theme) as array fo objects
	    try{
            $stmt=$this->_pdo->prepare("
    SELECT t1.* FROM (
      SELECT DISTINCT messages.id,title,text,user_id,users.name as user_name,time 
        FROM messages LEFT JOIN users ON users.id=messages.user_id ORDER BY time DESC 
    )as t1 GROUP BY user_id");
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
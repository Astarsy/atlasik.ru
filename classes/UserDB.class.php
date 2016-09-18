<?php
class UserDB extends DB{
	// Провайдер данных для приложения Пользователей
    static protected $_instance;

    public static function getInstance(){
        if(!(self::$_instance instanceof self))self::$_instance=new self();
        return self::$_instance;
    }
    
    public function activateUser($hesh){
        // Активировать п-ля по хешу
        // Возвращает true/false

        // 1. Обновить users.activated_date=time() по hesh
        // 2. Удалить запись из user_reg_heshes
        // 3. Если удаления небыло- вернуть false
        // 4. return true
        try{
            $this->_pdo->beginTransaction();
            $stmt=$this->_pdo->prepare(
            "UPDATE users SET activated_date=:a WHERE id=(SELECT uid FROM user_reg_heshes WHERE hesh=:h);");
            $t=time();
            $stmt->bindParam(':a',$t,PDO::PARAM_INT);
            $stmt->bindParam(':h',$hesh,PDO::PARAM_STR);
            $stmt->execute();
            if($r=$stmt->rowCount()==0){
                $this->_pdo->rollBack();
                return false;
            };
            $stmt=$this->_pdo->prepare(
            "DELETE FROM user_reg_heshes WHERE hesh=:h;");
            $stmt->bindParam(':h',$hesh,PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()==0){
                $this->_pdo->rollBack();
                return false;
            }
            $this->_pdo->commit();
        }catch(PDOException $e){
            $this->_pdo->rollBack();
            die($e);
            return false;
        }//TODO: убрать die
        return true;
    }
    public function emailExists($email){
        // Проверить, есть ли такой email в users
        // Возворащает true/false
        try{
            $stmt=$this->_pdo->prepare(
            "SELECT COUNT(id) FROM users WHERE email=:e");
            $stmt->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return (bool)$stmt->fetch(PDO::FETCH_NUM)[0];
    }

    public function saveRegister($form){
        // Сохраняет:
        // - нового неактивного поль-ля;
        // - хеш активации;
        // - учётные данные (логин,пароль,соль,итерации).
        // Возвращает reg_hesh/false
        $reg_hesh=RegistrationDataStorage::getHesh(rand(3,9),rand(3,9),rand(3,9));
        try{
            $this->_pdo->beginTransaction();

            $stmt=$this->_pdo->prepare(
            "INSERT INTO users(slug,email,name,phone,address) VALUES(:s,:e,:n,:p,:a);");
            $t=time();
            $slug='u_'.$t;
            $stmt->bindParam(':s',$slug,PDO::PARAM_STR);
            $e=$form->getFieldValue('email');
            $stmt->bindParam(':e',$e,PDO::PARAM_STR);
            $n=$form->getFieldValue('name');
            $stmt->bindParam(':n',$n,PDO::PARAM_STR);
            $p=$form->getFieldValue('phone');
            $stmt->bindParam(':p',$p,PDO::PARAM_STR);
            $a=$form->getFieldValue('address');
            $stmt->bindParam(':a',$a,PDO::PARAM_STR);
            $stmt->execute();

            $pass=$form->getFieldValue('password1');
            $solt=rand(1000,9999);
            $iter=rand(3,9);
            $pass_hesh=RegistrationDataStorage::getHesh($pass,$solt,$iter);

            $stmt=$this->_pdo->prepare(
            "INSERT INTO user_reg_heshes(uid,hesh,time) VALUES((SELECT id FROM users WHERE slug=:s),:h,:t);");
            $stmt->bindParam(':s',$slug,PDO::PARAM_STR);
            $stmt->bindParam(':h',$reg_hesh,PDO::PARAM_STR);
            $stmt->bindParam(':t',$t,PDO::PARAM_INT);
            $stmt->execute();

            $stmt=$this->_pdo->prepare(
            "INSERT INTO user_reg_data(uid,pass_hash,solt,iters) VALUES((SELECT id FROM users WHERE slug=:s),:h,:so,:i);");
            $stmt->bindParam(':s',$slug,PDO::PARAM_STR);
            $stmt->bindParam(':h',$pass_hesh,PDO::PARAM_STR);
            $stmt->bindParam(':so',$solt,PDO::PARAM_STR);
            $stmt->bindParam(':i',$iter,PDO::PARAM_INT);
            $stmt->execute();

            $this->_pdo->commit();
        }catch(PDOException $e){
            $this->_pdo->rollBack();
            die($e);
            return false;
        }//TODO: убрать die
        return $reg_hesh;
    }
    
    public function saveCabinet($uid,$form){
        // Сохраняет состояние Кабинета поль-ля
        // Возвращает true(Ok)/false
        try{
            $stmt=$this->_pdo->prepare(
            "UPDATE users SET name=:n,phone=:p,address=:a WHERE id=:i;");
            $stmt->bindParam(':i',$uid,PDO::PARAM_INT);
            $n=$form->getFieldValue('name');
            $stmt->bindParam(':n',$n,PDO::PARAM_STR);
            $p=$form->getFieldValue('phone');
            $stmt->bindParam(':p',$p,PDO::PARAM_STR);
            $a=$form->getFieldValue('address');
            $stmt->bindParam(':a',$a,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){die($e);return false;}//TODO: убрать die
        return true;
    }

	public function getUserRegistrationData($email){
		// Получает учётные данные поль-ля, возвращает их в виде массива строк или false
        try{
            $stmt=$this->_pdo->prepare(
            "SELECT email,pass_hash,solt,iters FROM users LEFT JOIN user_reg_data ON user_reg_data.uid=users.id WHERE email=:e");
            $stmt->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return $stmt->fetch(PDO::FETCH_NUM);
	}

	public function getUserByEmail($email){
		// Возвращает объект п-ля по e-mail или false
        try{
            $stmt=$this->_pdo->prepare(
            "SELECT id,slug,name,email,phone,address,activated_date,admin FROM users WHERE email=:e");
            $stmt->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return $stmt->fetch(PDO::FETCH_OBJ);
	}
}
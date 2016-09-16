<?php
class UserDB extends DB{
	// Провайдер данных для приложения Пользователей

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
            "SELECT id,slug,name,email,phone,activated_date FROM users WHERE email=:e");
            $stmt->bindParam(':e',$email,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){die($e);}
        return $stmt->fetch(PDO::FETCH_OBJ);
	}
}
<?php
class Utils{
	public static function clearStr($str,$len=200){
		return (string)substr(trim(strip_tags($str)),0,$len);
	}

	public static function clearInt($i){
	    return (int)$i;
	}

	public static function clearUInt($i){
	    return abs(self::clearInt($i));
	}

	public static function ucfirst($str,$coding='UTF-8'){
	    return mb_strtoupper(mb_substr($str,0,1,$coding),$coding).mb_substr($str,1,mb_strlen($str),$coding);
	}	  
	public static function clearMail($mail){
	    //Очищает и возвращает Mail или false
	    $res=self::clearStr($mail,55);
	    if(preg_match('/^.{1,30}@{1}.{1,20}\.{1}.{1,4}$/',$res))return $res;
	    else return false;
	}
    public static function clearPassword($pw){
        //Очищает и возвращает Password
        return substr(trim(strip_tags($pw)),0,100);
    }
    public static function clearPhone($p){
        //Возвращает очищенный phone или false
        $p=self::clearStr($p,20);
        //'/^\+7\(\d{3,4}\)\d{2,3}-\d{2}-\d{2}$/'
        if(preg_match('/^([\d,?\(,?\),? ,\+,-]){6,30}$/',$p))return $p;
        return false;
    }
}
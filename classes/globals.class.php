<?php
namespace Globals{
    define('IMG_MINI_PATH',$_SERVER['DOCUMENT_ROOT'].'/'.'logos/mini/');
    define('IMG_BIG_PATH',$_SERVER['DOCUMENT_ROOT'].'/'.'logos/big/');
    define('GOOD_FOTO_MINI_PATH',$_SERVER['DOCUMENT_ROOT'].'/'.'fotos/mini/');
    define('GOOD_FOTO_BIG_PATH',$_SERVER['DOCUMENT_ROOT'].'/'.'fotos/big/');
    const FILE_FIELD_NAME='user_file';
    const MINI_WIDTH=400; const MINI_HEIGHT=115;
    const MAXI_WIDTH=728; const MAXI_HEIGHT=210;
    const MAX_IMAGEFILE_SIZE=30000000;
    const GOOD_FOTO_BIG_WIDTH=800;
    const GOOD_FOTO_BIG_HEIGHT=800;
    const GOOD_FOTO_MINI_WIDTH=226;
    const GOOD_FOTO_MINI_HEIGHT=226;

	const DEBUG=true;
	define('MAIL','no-reply@'.$_SERVER['HTTP_HOST']);
	const DB_NAME='atlasikdb';
	const DB_USER='atlasik';
	const DB_PASS='nwm8gma8';
	const USER_SESNAME='user_data';
	define('USERS_FILENAME','.htpasswd');//учетные данные поль-лей
    
    const GOODS_ON_PAGE=3;
}
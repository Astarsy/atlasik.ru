<?php
class Logger{
    // Отвечает за вход и выход пользователя
    //выводит либо guest, либо имя залогиненного п-ля
    //для рендера соотв-й формы- 1 для входа, 2- для выхода
    //файлы форм:
    // templates/logger_in_form.html
    // templates/logger_out_form.html
    //которую выводить определяет шаблон *.twig.html
    //инф-ю залогиненного п-ля помещает в сессию
    //в виде строке json
    protected $_user;
    public function __construct(){
        $this->_db=UserDB::getInstance();
        if(isset($_SESSION[Globals\USER_SESNAME])){
            $mail=$_SESSION[Globals\USER_SESNAME];
            $this->_user=$this->_db->getUserByEmail($mail);
            if($this->_user==false)$this->logout();
        }else{
            $this->setGuest();
        }
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_POST['logout'])){
                // нажата кнопка Выйти
                $this->logout();
                header('Location: '.$_SERVER['REQUEST_URI']);
            }elseif(isset($_POST['login'])&&isset($_POST['mail'])&&isset($_POST['pass'])){
                // попытка войти
                $this->login($this->clearMail($_POST['mail']),$this->clearPW($_POST['pass']));
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
        }
    }
    protected function setGuest(){
        $this->_user=new stdClass();
        $this->_user->id=NULL;
        $this->_user->admin=NULL;
        $this->_user->name='гость';
    }
    public function logout(){
        session_destroy();
        unset($_SESSION[Globals\USER_SESNAME]);
        $this->setGuest();
    }
    protected function login($email,$passwd){
        // tries loging user in
        $udstrs=RegistrationDataStorage::getUserRegistrationData($email,$this->_db);
        if(false===$udstrs)return;
        list(,$s_pass_hesh,$s,$i)=$udstrs;
        if($s_pass_hesh!==RegistrationDataStorage::getHesh($passwd,$s,$i))return;
        $user=$this->_db->getUserByEmail($email);
        if($user==false)exit(header('Location: /error/2'));
        if($user->activated_date){
            $_SESSION[Globals\USER_SESNAME]=$user->email;
            return;
        }
        exit(header('Location: /error/1'));
    }
    public function getUser(){
        //Возвращает объект с данными профиля п-ля
        return $this->_user;
    }
    public function __toString(){
        //возвращает имя файла шаблона формы для подключения в шаблоне страниц
        if(NULL===$this->_user->id)return 'logger/logger_in_form.html';
        else return 'logger/logger_out_form.html';
    }
    protected function clearMail($mail){
        return Utils::clearMail($mail);
    }
    protected function clearPW($pw){
        return Utils::clearPassword($pw);
    }
}
<?php
class Usuario{
    private $email;
    private $password;
    private $repassword;
    private $filebutton;
    public function __construct($email,$password,$repassword=null,$filebutton=null){
        $this->email = $email;
        $this->password = $password;
        $this->repassword = $repassword;
        $this->filebutton = $filebutton;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getRepassword(){
        return $this->repassword;
    }
    public function setRepassword($repassword){
        $this->repassword = $repassword;
    }

    public function getAvatar(){
       return $this->filebutton;
    }
    public function setAvatar($filebutton){
        $this->filebutton = $filebutton;
    }

}
?>

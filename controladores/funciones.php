<?php
//session_start();
require_once("helpers.php");
function validar($datos,$bandera){

$errores = [];

$email = trim($datos["email"]);
if(empty($datos["email"])){
$errores["email"]="El campo no puede estar vacio";
}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errores["email"]="El email no es válido";
    }

$password = trim($datos["password"]);
if(isset($datos["password"])){
if(empty($password)){
$errores["password"] = "El password no puede estar vacio";
}elseif(strlen($password)<6){
$errores["password"]= "El password debe tener mínimo 6 caracteres";
}
}

if(isset($datos["repassword"])){
$repassword = trim($datos["repassword"]);
if(empty($repassword)){
$errores["repassword"]= "El campo no debe estar vacio";
}elseif($password != $repassword){
$errores["repassword"]= "Las contraseñas deben coincidir";
}
}
if($bandera == 'registrar'){
$filebutton = $_FILES["filebutton"]["name"];
$ext = pathinfo($filebutton,PATHINFO_EXTENSION);
if(empty($filebutton)){
  $errores["filebutton"]="No recibi la imagen";
}elseif($ext != "jpg" && $ext != "png"){
      $errores["filebutton"] ="La extensión debe ser PNG ó JPG";
    }
}

return $errores;
}


function armarFoto($imagen){
    $nombre = $imagen["filebutton"]["name"];
    $ext = pathinfo($nombre,PATHINFO_EXTENSION);
    $archivoOrigen = $imagen["filebutton"]["tmp_name"];
    $archivoDestino = dirname(__DIR__);
    $archivoDestino = $archivoDestino."/fotosPerfil/";
    $foto = uniqid();
    $archivoDestino = $archivoDestino.$foto;
    $archivoDestino = $archivoDestino.".".$ext;
    move_uploaded_file($archivoOrigen,$archivoDestino);
    $foto = $foto.".".$ext;
    return $foto;
}

function armarUsuario($datos,$foto){
    $usuario = [
        "email"=>$datos["email"],
        "password"=>password_hash($datos["password"],PASSWORD_DEFAULT),
        "filebutton"=>$foto,
    ];
    return $usuario;
}

function guardarUsuario($usuario){
    $base = json_encode($usuario);
    file_put_contents("usuarios.json",$base.PHP_EOL,FILE_APPEND);
}

function buscarPorEmail($email){
    $usuarios = abrirBaseJSON();
    if($usuarios !== null){
    foreach ($usuarios as $usuario) {

        if($email == $usuario["email"]){
            return $usuario;
        }
    }
  }
    return null;
}

function abrirBaseJSON(){
  if(file_exists("usuarios.json")){
      $base = file_get_contents("usuarios.json");
      $base = explode(PHP_EOL,$base);
      array_pop($base);
      foreach ($base as $usuarios) {
          $arrayUsuarios[]=json_decode($usuarios,true);
      }
      return $arrayUsuarios;
  }else{
  return null;
}
}


function seteoUsuario($usuario,$datos){

    $_SESSION["email"]=$usuario["email"];
    $_SESSION["filebutton"]=$usuario["filebutton"];
    if(isset($datos["recordar"])){
        setcookie("email",$datos["email"],time()+3600);
        setcookie("password",$datos["password"],time()+3600);
    }

}

function validarAcceso(){
    if(isset($_SESSION["email"])){
        return true;
    }elseif (isset($_COOKIE["email"])) {
        $_SESSION["email"]= $_COOKIE["email"];
        $_SESSION["password"]=$_COOKIE["password"];
        return true;
    }else{
        return false;
    }
}

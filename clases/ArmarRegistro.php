<?php
class ArmarRegistro{
    public function armarAvatar($imagen){
        $nombre = $imagen["filebutton"]["name"];
        $ext = pathinfo($nombre,PATHINFO_EXTENSION);
        $archivoOrigen = $imagen["filebutton"]["tmp_name"];
        $archivoDestino = dirname(__DIR__);
        $archivoDestino = $archivoDestino."/img/";
        $avatar = uniqid();
        $archivoDestino = $archivoDestino.$avatar;

        $archivoDestino = $archivoDestino.".".$ext;

        move_uploaded_file($archivoOrigen,$archivoDestino);
        $filebutton = $avatar.".".$ext;

        return $filebutton;
    }

    public function armarUsuario($registro,$filebutton){

        $usuario = [
            "email"=>$registro->getEmail(),
            "password"=> Encriptar::hashPassword($registro->getPassword()),
            "filebutton"=>$filebutton,
            "role"=>1
        ];

        return $usuario;
    }

    public function armarProducto($registro,$imagen){

        $producto = [
            "producto"=>$registro->getProducto(),
            "descripcion"=>$registro->getDescripcion(),
            "cantidad"=>$registro->getCantidad(),
            "precio"=>$registro->getPrecio(),
            "categoria_id"=>$registro->getCategoria_id(),
            "imagen"=>$imagen
        ];

        return $producto;
    }
}

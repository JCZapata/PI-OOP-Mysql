<?php

class BaseMYSQL extends BaseDatos{
    static public function conexion($host,$db_nombre,$usuario,$password,$puerto,$charset){
        try {
            $dsn = "mysql:host=".$host.";"."dbname=".$db_nombre.";"."port=".$puerto.";"."charset=".$charset;
            $baseDatos = new PDO($dsn,$usuario,$password);
            $baseDatos->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $baseDatos;
        } catch (PDOException $errores) {
            echo "No me pude conectar a la BD ". $errores->getmessage();
            exit;
        }
    }
    static public function buscarPorEmail($email,$pdo,$tabla){
        //Aquí hago la sentencia select, para buscar el email, estoy usando bindeo de parámetros por value
        $sql = "select * from $tabla where email = :email";
        // Aquí ejecuto el prepare de los datos
        $query = $pdo->prepare($sql);
        $query->bindValue(':email',$email);
        $query->execute();
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    }

    static public function guardarUsuario($pdo,$usuario,$tabla,$filebutton){
        $sql = "insert into $tabla (email,password,filebutton,role) values (:email,:password,:filebutton,:role )";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email',$usuario->getEmail());
        $query->bindValue(':password',Encriptar::hashPassword($usuario->getPassword()));
        $query->bindValue(':filebutton',$filebutton);
        $query->bindValue('role',1);
        $query->execute();

    }

    public function leer(){
        //A futuro trabajaremos en esto
    }
    public function actualizar($usuario,$pdo,$tabla){
        $sql = "UPDATE $tabla SET password= :password WHERE email= :email";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email',$usuario->getEmail());
        $query->bindValue(':password',Encriptar::hashPassword($usuario->getPassword()));
        $query->execute();

    }
    public function borrar(){
        //A futuro trabajaremos en esto
    }
    public function guardar($usuario){
        //Este fue el método usao para json
    }

   public function traerCategorias($pdo){
     $sql = "SELECT * FROM categories";
     // Aquí ejecuto el prepare de los datos
     $query = $pdo->prepare($sql);
     $query->execute();
     $categorias = $query->fetchAll(PDO::FETCH_ASSOC);
     return $categorias;
   }

   static public function guardarProducto($pdo, $producto, $tabla, $imagen){
     $sql = "insert into $tabla (producto, descripcion,cantidad, precio, filebutton, categoria_id ) values (:producto, :descripcion,:cantidad, :precio, :filebutton, :categoria_id)";
     $query = $pdo->prepare($sql);
     $query->bindValue('producto', $producto->getProducto());
     $query->bindValue('descripcion', $producto->getDescripcion());
     $query->bindValue('cantidad', $producto->getCantidad());
     $query->bindValue('precio', $producto->getPrecio());
     $query->bindValue('filebutton', $imagen);
     $query->bindValue('categoria_id', $producto->getCategoriaId());
     $query->execute();
   }

}

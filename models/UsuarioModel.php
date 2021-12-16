<?php
require_once "mainModel.php";

class UsuarioModel extends mainModel{
    //agregar usuario
    protected static function agregarUsuarioModel($datos){
        try {
            $mbd = MainModel::conectarDb();
            $sql = $mbd->prepare("INSERT INTO usuarios(usuario_nombre,usuario_apellido,
            usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,
            usuario_clave,usuario_estado,usuario_privilegio) 
            values(:Nombre,:Apellido,:Telefono,:Direccion,:Email,:Usuario,
            :Clave,:Estado,:Privilegio)");
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Apellido",$datos['Apellido']);
            $sql->bindParam(":Telefono",$datos['Telefono']); 
            $sql->bindParam(":Direccion",$datos['Direccion']);
            $sql->bindParam(":Email",$datos['Email']);
            $sql->bindParam(":Usuario",$datos['Usuario']); 
            $sql->bindParam(":Clave",$datos['Clave']);
            $sql->bindParam(":Estado",$datos['Estado']);
            $sql->bindParam(":Privilegio",$datos['Privilegio']);
            
            if(!$sql->execute()){
                error_log(json_encode($sql->errorInfo()));
                return false;
            }
            return true;
        } catch (PDOException $e) {
            error_log( $e->getMessage());
            die();
            return false;
        }
    }

    protected static function eliminarUsuarioModel($id){
        $sql = MainModel::conectarDb()->prepare("DELETE FROM usuarios WHERE usuario_id = :id");
        $sql->bindParam(":id", $id);
        if($sql->execute()){
            error_log('No se puede eliminar');
        }
        return $sql;
    }

    protected static function datosUsuarioModel($tipo, $id){
        if($tipo == "unico"){
            $sql = MainModel::conectarDb()->prepare("SELECT * FROM usuarios 
                          WHERE usuario_id = :Id");
            $sql->bindParam(":Id", $id);

        }else if($tipo == "conteo"){
            $sql = MainModel::conectarDb()->prepare("SELECT usuario_id FROM usuarios 
            WHERE usuario_id != '1'");
        }
        if(!$sql->execute()){
            error_log('Error en consulta datosUsuario::');
        }
       
        return $sql;
    }

    protected static function updateUsuarioModel($data){
        error_log('Recibiendo de controller::'.json_encode($data));
        $sql = MainModel::conectarDb()->prepare("UPDATE usuarios SET 
            usuario_nombre = :nombre ,
            usuario_apellido = :apellido,
            usuario_telefono = :telefono,
            usuario_direccion = :direccion,
            usuario_email = :email,
            usuario_usuario = :usuario,
            usuario_clave = :clave,
            usuario_estado = :estado,
            usuario_privilegio = :privilegio 
            WHERE usuario_id = :id");
        $sql->bindParam(":nombre", $data['nombre']);
        $sql->bindParam(":apellido", $data['apellido']);
        $sql->bindParam(":telefono", $data['telefono']);
        $sql->bindParam(":direccion", $data['direccion']);
        $sql->bindParam(":email", $data['email']);
        $sql->bindParam(":usuario", $data['usuario']);
        $sql->bindParam(":clave", $data['clave']);
        $sql->bindParam(":estado", $data['estado']);
        $sql->bindParam(":privilegio", $data['privilegio']);
        $sql->bindParam(":id", $data['id']);
        if(!$sql->execute()){
            error_log('Error en sql:No se puede actualizar usuario.');
            return false;
        }
        return $sql;       

    }
}
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
            $sql->execute();
            $lastInsertId = $mbd->lastInsertId();
            if($lastInsertId <= 0){
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
}
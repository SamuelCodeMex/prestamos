<?php
require_once "mainModel.php";

class LoginModel extends mainModel{
    public static function iniciarSessionModel($datos){
        try {
            $mbd = MainModel::conectarDb();
            $sql = $mbd->prepare("SELECT * FROM usuarios 
            WHERE usuario_usuario = :Usuario AND 
            usuario_clave = :Clave AND usuario_estado = 0");
            $sql->bindParam(":Usuario",$datos['Usuario']);
            $sql->bindParam(":Clave",$datos['Clave']);
            $sql->execute();
            $lastInsertId = $mbd->lastInsertId();
            if($lastInsertId <= 0){
                error_log(json_encode($sql->errorInfo()));
                return $sql;
            }
            return $sql;
        } catch (PDOException $e) {
            error_log( $e->getMessage());
            die();
            return false;
        }
    }
}
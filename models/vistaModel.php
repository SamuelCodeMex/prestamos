<?php
class vistaModel{
    protected static function getVistasModel($vistas){
        //list white of words in views, only access of url;
        $listaBlanca = ["home","cliente-list"];
        if(in_array($vistas,$listaBlanca)){
            if(is_file("./view/contenidos/".$vistas."-view.php")){
                $contenido = "./view/contenidos/".$vistas."-view.php";
            }else{
                $contenido = "404";
            }
        }elseif($vistas=="login" || $vistas=="index"){
            $contenido="login";
        }else{
            $contenido="404";
        }
        return $contenido;
    }

}
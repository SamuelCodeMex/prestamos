<?php
require_once "./models/vistaModel.php";
class vistaController extends vistaModel{
    public function getPlantillaController(){
        return require_once "./view/plantilla.php";
    }
    public function getVistasController(){
        if(isset($_GET['views'])){
            $ruta = explode("/",$_GET['views']);
            $respuesta = vistaModel::getVistasModel($ruta[0]);
        }else{
            $respuesta = 'login';
        }
        return $respuesta;
    }
}
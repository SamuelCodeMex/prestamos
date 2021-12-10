<?php
error_log('En LoginAjax.php');
$peticionAjax = true; 
require_once "../config/app.php";
if (isset($_POST['token']) && isset($_POST['usuario'])) { //creadas en view/inc/logOut.php linea 21
    require_once "../controllers/LoginController.php";
    $ins_log = new LoginController();
    echo $ins_log->CierreSessionController();
} else { //intentan ingresar sin session
    error_log('No definido');
    session_start(['name' => 'HMN']); //iniciamos sesion
    session_unset(); //vaciamos la session
    session_destroy();//eliminamos la session
    header("Location".SERVERURL."login/");  //redireccionamos
    exit();  //para continuar ejecutando codigo php
}
<?php
error_log('En usuarioAjax.php');
$peticionAjax = true; 
require_once "../config/app.php";
if (isset($_POST['usuario_nombre_reg'])) { //tiene session
    error_log('deifinido::'.$_POST['usuario_nombre_reg']);
    require_once "../controllers/UsuarioController.php";
    $ins_usuario = new UsuarioController();
    if(isset($_POST['usuario_nombre_reg']) && isset($_POST['usuario_apellido_reg'])){
        echo $ins_usuario->agregarUsuarioController();
    }
} else { //intentan ingresar sin session
    error_log('No definido');
    session_start(['name' => 'HMN']); //iniciamos sesion
    session_unset(); //vaciamos la session
    session_destroy();//eliminamos la session
    header("Location".SERVERURL."login/");  //redireccionamos
    exit();  //para continuar ejecutando codigo php
}
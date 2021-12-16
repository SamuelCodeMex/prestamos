<?php
error_log('En usuarioAjax.php');
$peticionAjax = true; 
require_once "../config/app.php";
if (isset($_POST['usuario_nombre_reg']) || isset($_POST['usuario_id']) ||
    isset($_POST['usuario_id_up'])) { //tiene session
    require_once "../controllers/UsuarioController.php";
    $ins_usuario = new UsuarioController();
    if(isset($_POST['usuario_nombre_reg']) && isset($_POST['usuario_apellido_reg'])){
        echo $ins_usuario->agregarUsuarioController();
    }
    if(isset($_POST['usuario_id'])){
        echo $ins_usuario->eliminarUsuarioController();
    }
    if(isset($_POST['usuario_id_up'])){
        echo $ins_usuario->updateUsuarioController();
    }
} else { //intentan ingresar sin session
    error_log('No definido');
    session_start(['name' => 'HMN']); //iniciamos sesion
    session_unset(); //vaciamos la session
    session_destroy();//eliminamos la session
    header("Location".SERVERURL."login/");  //redireccionamos
    exit();  //para continuar ejecutando codigo php
}
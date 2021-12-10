<?php
if ($peticionAjax) {
    require_once "../models/LoginModel.php";
} else {
    require_once "./models/LoginModel.php";
}

class LoginController extends LoginModel{
    public function iniciarSessionController(){
       //recibir datos del formulario
       $usuario = MainModel::cleanString($_POST['usuario_log']);
       $clave = MainModel::cleanString($_POST['clave_log']);
       if($usuario == '' || $clave == ''){
            echo "<script>
            Swal.fire({
                title: 'Ócurrio un error inesperado.',
                text: 'Revise los campos',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
            </script>";
            exit();
       }

       if (MainModel::checkDat('[a-zA-Z0-9]{1,35}',$usuario)) {
            echo "<script>
            Swal.fire({
                title: 'Ócurrio un error inesperado.',
                text: 'Revise el campo USUARIO',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
            </script>";
            exit();
        }

        if (MainModel::checkDat('[a-zA-Z0-9$@.-]{7,100}',$clave)) {
            echo "<script>
            Swal.fire({
                title: 'Ócurrio un error inesperado.',
                text: 'Revise el campo CONTRASEÑA',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
            </script>";
            exit();
        }
        $clave = MainModel::encryption($clave);
        $data_log  = [
            'Usuario' => $usuario,
            'Clave'   => $clave
            ];
        $data_cuenta = LoginModel::iniciarSessionModel($data_log); 
        if ($data_cuenta->rowCount() == 1) {
           $row = $data_cuenta->fetch();
           session_start(['name' => 'HMN']);
           $_SESSION['hmn_id'] = $row['usuario_id'];
           $_SESSION['hmn_nombre'] = $row['usuario_nombre'];
           $_SESSION['hmn_apellido'] = $row['usuario_apellido'];
           $_SESSION['hmn_usuario'] = $row['usuario_usuario'];
           $_SESSION['hmn_privilegio'] = $row['usuario_privilegio'];
           $_SESSION['hmn_token'] = md5(uniqid(mt_rand(),true));
           return header("Location: ".SERVERURL."home/");
        }else{
            echo "<script>
            Swal.fire({
                title: 'Ócurrio un error inesperado.',
                text: 'USUARIO O CLAVE son incorrectos.',
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
            </script>";
            exit();
        }  

    }
    public function fCierreSessionController(){
        session_unset(); //vaciamos la session
        session_destroy();//eliminamos la session
        if(headers_sent()){
            return "<script>window.location.href='".SERVERURL."login/';</script>";
           //return "<script>console.log('Error')</script>";
        }else{
            return header("Location:".SERVERURL."login/");  //redireccionamos
        }
        
    }
    public function CierreSessionController(){
        session_start(['name' => 'HMN']);
        $token = MainModel::decryption($_POST['token']); //DUDA DONDE VIENE $_POST['token']?
        $usuario = MainModel::decryption($_POST['usuario']);
        if ($token == $_SESSION['hmn_token'] && $usuario == $_SESSION['hmn_usuario'] ) {
            session_unset(); //vaciamos la session
            session_destroy();//eliminamos la session
            $alerta = [
                "Alerta" => "redireccionar",
                "URL"  => SERVERURL."login/"
            ];
            echo json_encode($alerta);
        } else {
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Ocurrio un error inesperado.',
                "Texto" => 'No se pudo cerrar sesión en el sistema.'
            ];

            echo json_encode($alerta);
            exit();
        }

        
    }
}
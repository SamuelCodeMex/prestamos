<?php
if ($peticionAjax) {
    require_once "../models/UsuarioModel.php";
} else {
    require_once "./models/UsuarioModel.php";
}
class UsuarioController extends UsuarioModel{
    
    public function agregarUsuarioController(){
        //los datos post los obtenemos gracias que hacemos 
        //include en ajax/usuarioAjax.php
        error_log('agregarUsuarioController metodo');
        $nombre = MainModel::cleanString($_POST['usuario_nombre_reg']);
        $apellido = MainModel::cleanString($_POST['usuario_apellido_reg']);
        $telefono = MainModel::cleanString($_POST['usuario_telefono_reg']);
        $direccion = MainModel::cleanString($_POST['usuario_direccion_reg']);
        $usuario = MainModel::cleanString($_POST['usuario_usuario_reg']);
        $email = MainModel::cleanString($_POST['usuario_email_reg']);
        $clave_1 = MainModel::cleanString($_POST['usuario_clave_1_reg']);
        $clave_2 = MainModel::cleanString($_POST['usuario_clave_2_reg']);
        $privilegio = MainModel::cleanString($_POST['usuario_privilegio_reg']);
                                                     
        error_log('$nombre::'.$nombre);
        error_log('$apellido::'.$apellido);
        error_log('$telefono::'.$telefono);
        error_log('$usuario::'.$usuario);
        error_log('$clave_1::'.$clave_1);
        error_log('$clave_2::'.$clave_2);
        error_log('$privilegio::'.$privilegio);
        error_log('vamos por el if');
        //comprobar que tengan texto
        if($nombre == '' ||  $apellido== '' ||  $usuario == '' ||  $clave_1== '' ||  $clave_2== ''){
            error_log('enviando alerta');
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Ocurrio un error inesperado.',
                "Texto" => 'No has llenado todos los campos requeridos.'
            ];

            echo json_encode($alerta);
            exit();
        }
        //verificar datos obtenidos del formulario usuarios
        if (MainModel::checkDat('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}',$nombre)) {
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'El campo APELLIDO no coincide con el formato solicitado.',
                "Texto" => 'No has llenado todos los campos requeridos.'
            ];

            echo json_encode($alerta);
            exit();
        }
        if (MainModel::checkDat('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}',$apellido)) {
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'El campo APELLIDO no coincide con el formato solicitado.',
                "Texto" => 'No has llenado todos los campos requeridos.'
            ];

            echo json_encode($alerta);
            exit();
        }
        if($telefono != ""){
            error_log('si hay teléfono');
            if (MainModel::checkDat('[0-9]{8,20}',$telefono)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo TELÉFONO no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
        }
        
        if($direccion != ""){
            if (MainModel::checkDat('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}',$direccion)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo DIRECCIÓN no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
        }
        
        if($usuario != ""){
            if (MainModel::checkDat('[a-zA-Z0-9]{1,35}',$usuario)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo NOMBRE DE USUARIO no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }else{
                $checkUsuario = MainModel::querySimple("SELECT usuario_usuario from usuarios WHERE usuario_usuario = '$usuario'");
                if($checkUsuario->rowcount()>1){
                    $alerta = [
                        "Alerta" => 'simple',
                        "Tipo" => 'error',
                        "Titulo" => 'El campo NOMBRE DE USUARIO ingresado ya se encuentra.',
                        "Texto" => 'Cambie en NOMBRE DE USUARIO por otro.'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            
        }
        
        if($email != ""){
            if (MainModel::checkDat('^[^@]+@[^@]+\.[a-zA-Z]{2,}$',$email)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo EMAIL no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }else{
                $checkUsuario = MainModel::querySimple("SELECT usuario_email from usuarios WHERE usuario_email = '$email'");
                if($checkUsuario->rowcount()>1){
                    $alerta = [
                        "Alerta" => 'simple',
                        "Tipo" => 'error',
                        "Titulo" => 'El campo Email ingresado ya se encuentra.',
                        "Texto" => 'Cambie en Email por otro.'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
        }
       
        if($clave_1 != ""){
            if (MainModel::checkDat('[a-zA-Z0-9$@.-]{7,100}', $clave_1)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo CONTRASEÑA no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
        }

        
        if($clave_2 != ""){
            if (MainModel::checkDat('[a-zA-Z0-9$@.-]{7,100}',$clave_2)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo CONTRASEÑA no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
        }
        if($clave_1 != $clave_2){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Las CONTRASEÑAS no coinciden.',
                "Texto" => 'Por favor vuelvalo a intentar.'
            ];

            echo json_encode($alerta);
            exit();
        }else{
            $clave = MainModel::encryption($clave_1);
        }
       
        if ($privilegio < 0 || $privilegio > 3){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'El campo PRIVILEGIO no coincide con el formato solicitado.',
                "Texto" => $privilegio
            ];

            echo json_encode($alerta);
            exit();
        }

        $dataUsu = [
        'Nombre'   => $nombre,
        'Apellido' => $apellido,
        'Telefono' => $telefono,
        'Direccion'=> $direccion,
        'Email'    => $email,
        'Usuario'  => $usuario,
        'Clave'    => $clave,
        'Estado'   => 0,
        'Privilegio'=> $privilegio
        ];

        $agregarUsu = UsuarioModel::agregarUsuarioModel($dataUsu);
        if ($agregarUsu) {
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'success',
                "Titulo" => 'Usuario Registrado.',
                "Texto" => 'Datos del usuario ingresados correctamente.'
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Error en registro',
                "Texto" => 'No es posible registrar al Usuario en este momento intente de nuevo'
            ];

            echo json_encode($alerta);
            exit();
        }
        

        
    }
}
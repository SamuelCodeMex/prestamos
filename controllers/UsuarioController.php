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
        $nombre = MainModel::cleanString($_POST['usuario_nombre_reg']);
        $apellido = MainModel::cleanString($_POST['usuario_apellido_reg']);
        $telefono = MainModel::cleanString($_POST['usuario_telefono_reg']);
        $direccion = MainModel::cleanString($_POST['usuario_direccion_reg']);
        $usuario = MainModel::cleanString($_POST['usuario_usuario_reg']);
        $email = MainModel::cleanString($_POST['usuario_email_reg']);
        $clave_1 = MainModel::cleanString($_POST['usuario_clave_1_reg']);
        $clave_2 = MainModel::cleanString($_POST['usuario_clave_2_reg']);
        $privilegio = MainModel::cleanString($_POST['usuario_privilegio_reg']);
                                                
        //comprobar que tengan texto
        if($nombre == '' ||  $apellido== '' ||  $usuario == '' ||  $clave_1== '' ||  $clave_2== ''){
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

    public function paginadorUsuarioController($pagina,$regis,$privil,$id,$url,$busqueda){
        $pagina = MainModel::cleanString($pagina);
        $regis = MainModel::cleanString($regis);
        $privil = MainModel::cleanString($privil);
        $url = MainModel::cleanString($url);
        $url = SERVERURL.$url."/";
        $busqueda = MainModel::cleanString($busqueda);
        error_log('$busqueda::'.$busqueda);
        error_log('$regis::'.$busqueda);error_log('$privil::'.$privil);error_log('$url::'.$url);
        
        $tabla = "";
        $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina: 1;
        $inicio = ($pagina>0)? (($pagina*$regis)-$regis) : 0;
        error_log('$pagina::'.$pagina);
        error_log('$inicio::'.$inicio);
        error_log("--------------------");
        if (isset($busqueda) && $busqueda != "") {
           // if(false){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE ((usuario_id != '$id'
                         AND usuario_id != '1') AND  (usuario_nombre LIKE '%$busqueda%' 
                         OR usuario_apellido LIKE '%$busqueda%' 
                         OR usuario_usuario LIKE '%$busqueda%')) 
                         ORDER BY usuario_nombre ASC LIMIT $inicio,$regis";
        } else {      //cuenta la cantidad de registros de los usuarios
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE usuario_id != '$id'
                         AND usuario_id != '1' ORDER BY usuario_nombre ASC LIMIT $inicio,$regis";
            //$consulta = "SELECT * FROM usuarios";
        }
        $conexion = MainModel::conectarDb();
        $datos = $conexion->query($consulta);
        error_log(json_encode($datos));
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total/$regis);
        $tabla .= '
        <div class="table-responsive">
        <table class="table table-dark table-sm">
            <thead>
                <tr class="text-center roboto-medium">
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>TELÉFONO</th>
                    <th>USUARIO</th>
                    <th>EMAIL</th>
                    <th>ACTUALIZAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>';
        if ($total>=1 && $pagina < $Npaginas) {
            $contador = $inicio+1;
            foreach($datos as $fila){
                $tabla .='
            <tr class="text-center" >
                <td>'.$contador.'</td>
                <td>'.$fila['usuario_nombre'].' '.$fila['usuario_apellido'].'</td>
                <td>'.$fila['usuario_telefono'].'</td>
                <td>'.$fila['usuario_usuario'].'</td>
                <td>'.$fila['usuario_email'].'</td>
                <td>
                    <a href="<?php echo SERVERURL;?>user-update/" class="btn btn-success">
                        <i class="fas fa-sync-alt"></i>	
                    </a>
                </td>
                <td>
                    <form action="">
                        <button type="button" class="btn btn-warning">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>';
            $contador++;
            }
           
        } else {
            if ($total>=1) {
                $tabla .='<tr class="text-center" >
                <td colspan=8>
                <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aquí para recargar el registro></a>
                </td>
                </tr>';
            } else {
                $tabla .='<tr class="text-center" >
                <td colspan=8>No hay registros en el sistema</td>
                </tr>';
            }
        }
        $tabla .='
            </tbody>
            </table>
        </div>'; 
        if ($total>=1 && $pagina < $Npaginas) {
            $tabla .= MainModel::paginarTabla($pagina,$Npaginas,$url,7); 
        }
        return $tabla;   
    }
}
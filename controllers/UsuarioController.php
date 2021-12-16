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
                "Texto" => 'Faltan campos por llenar.'
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
                if($checkUsuario->rowCount()>1){
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
                if($checkUsuario->rowCount()>1){
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
    //muestra la tabla con la lista de usuarios con paginacion
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
        if ($total>=1 && $pagina <= $Npaginas) {
            $contador = $inicio+1;
            $regInicio = $inicio+1;
            foreach($datos as $fila){
                $tabla .='
            <tr class="text-center" >
                <td>'.$contador.'</td>
                <td>'.$fila['usuario_nombre'].' '.$fila['usuario_apellido'].'</td>
                <td>'.$fila['usuario_telefono'].'</td>
                <td>'.$fila['usuario_usuario'].'</td>
                <td>'.$fila['usuario_email'].'</td>
                <td>
                    <a href="'.SERVERURL.'user-update/'.MainModel::encryption($fila['usuario_id']).'/" class="btn btn-success">
                        <i class="fas fa-sync-alt"></i>	
                    </a>
                </td>
                <td>
                    <form class="formularioAjax" action="'.SERVERURL.'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="usuario_id" value="'.MainModel::encryption($fila['usuario_id']).'">
                        <button type="submit" class="btn btn-warning">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>';
            $contador++;
            }
            $regFinal= $contador-1;
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
        if($total>=1 && $pagina <= $Npaginas){
            $tabla .= '<p class="text-right">Mostrando usuario '.$regInicio.' al '.$regFinal.' de un total de '.$total.' </p>';
        
            $tabla .= MainModel::paginarTabla($pagina,$Npaginas,$url,7); 
        }
        return $tabla;   
    }

    public function eliminarUsuarioController(){
        $id = MainModel::decryption($_POST['usuario_id']);
        $id = MainModel::cleanString($id); 
        if($id == 1 ){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Error al tratar de eliminar.',
                "Texto" => 'No podemos eliminar el USUARIO.'
            ];

            echo json_encode($alerta);
            exit();
        }
        //comprobar usuario en bd
        $checkUsua = MainModel::querySimple("SELECT usuario_id FROM 
                     usuarios WHERE usuario_id ='$id'");
         if($checkUsua->rowCount()<=0){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Error al tratar de eliminar.',
                "Texto" => 'El USUARIO no existe en el sistema.'
            ];

            echo json_encode($alerta);
            exit();
         } 
         //comprobando que no tenga prestamos 
         $checkPres = MainModel::querySimple("SELECT usuario_id FROM 
         prestamo WHERE usuario_id ='$id' LIMIT 1");
            if($checkPres->rowCount()>0){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Error al tratar de eliminar.',
                "Texto" => 'El USUARIO presenta registro de prestamo.'
            ];

            echo json_encode($alerta);
            exit();
            } 
            //comprobando privilegios
            session_start(['name' => 'HMN']);
            if($_SESSION['hmn_privilegio'] != 1){
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'Error al tratar de eliminar.',
                    "Texto" => 'No posees privilegios para realizar esta operación.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
            $elimiUsu = UsuarioModel::eliminarUsuarioModel($id); 
            if($elimiUsu->rowCount() == 1){
                $alerta = [
                    "Alerta" => 'recargar',
                    "Tipo" => 'success',
                    "Titulo" => 'Realizado.',
                    "Texto" => 'El USUARIO a sido eliminado el sistema.'
                ];
    
                echo json_encode($alerta);
                exit();
            }else{
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'Error al tratar de eliminar.',
                    "Texto" => 'Porfavor intente nuevamente.'
                ];
    
                echo json_encode($alerta);
                exit();

            }        
    }

    public function datosUsuarioController($tipo, $id){
        $tipo = MainModel::cleanString($tipo);
        $id = MainModel::decryption($id);
        $id = MainModel::cleanString($id);
        
        return UsuarioModel::datosUsuarioModel($tipo,$id);
    }

    public function updateUsuarioController(){
       //Recibiendo id archivo ajax/usuarioAjax.php //formularioUpdate
       $id = MainModel::decryption($_POST['usuario_id_up']);
       $id = MainModel::cleanString($id);
       //comprobamos usuario en bd
       $checkUsua = MainModel::querySimple("SELECT * FROM usuarios 
       WHERE usuario_id = '$id'");
       if($checkUsua->rowCount() <= 0){
        $alerta = [
            "Alerta" => 'simple',
            "Tipo" => 'error',
            "Titulo" => 'Ocurrió un error inesperado.',
            "Texto" => 'El usuario no existe en el sistema.'
        ];

        echo json_encode($alerta);
        exit();
       }else{
        $campos = $checkUsua->fetch();
        $nombre = MainModel::cleanString($_POST['usuario_nombre_up']);
        $apellido = MainModel::cleanString($_POST['usuario_apellido_up']);
        $telefono = MainModel::cleanString($_POST['usuario_telefono_up']);
        $direccion = MainModel::cleanString($_POST['usuario_direccion_up']);
        $usuario = MainModel::cleanString($_POST['usuario_usuario_up']);
        $email = MainModel::cleanString($_POST['usuario_email_up']);
        if(isset($_POST['usuario_estado_up'])){
            $estado = MainModel::cleanString($_POST['usuario_estado_up']);
        }else{
            $estado = $campos['usuario_estado'];  //obtenido de user-update-view.php
        }

        if(isset($_POST['usuario_privilegio_up'])){
            $privilegio = MainModel::cleanString($_POST['usuario_privilegio_up']);
        }else{
            $privilegio = $campos['usuario_privilegio'];  //obtenido de user-update-view.php
        }

        $adminUsu = MainModel::cleanString($_POST['usuario_admin']);
        $adminClave = MainModel::cleanString($_POST['clave_admin']);
        $tipoCuenta = MainModel::cleanString($_POST['cuenta']);
        //solo dos valores 'propio' o 'impropia'
        if($nombre == '' ||  $apellido== '' ||  $usuario == '' ||  $adminUsu == '' ||
          $adminClave== ''){
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
                "Titulo" => 'El campo nombre no coincide con el formato solicitado.',
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
        
       
        if($adminUsu != ""){
            if (MainModel::checkDat('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}', $adminUsu)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'Error en campo nombre de usuario en administrador',
                    "Texto" => 'El formato de campo nombre de usuario no conincide con el formato solicitado.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
        }
        if($adminClave != ""){
            if (MainModel::checkDat('[a-zA-Z0-9$@.-]{7,100}', $adminClave)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'Error en campo nombre de usuario en administrador',
                    "Texto" => 'El formato de campo nombre de usuario no no conincide con el formato solicitado.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
        }
        $adminClave = MainModel::encryption($adminClave);

        if($privilegio <0 || $privilegio >3){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Error en campo Privilegio',
                "Texto" => 'El formato de campo Privilegio no conincide con el formato solicitado.'
            ];

            echo json_encode($alerta);
            exit();
        }
        
        if($estado != 0 && $estado != 1){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Error en campo Estado de la cuenta',
                "Texto" => 'El formato de Estado de la cuenta no conincide con el formato solicitado.'
            ];

            echo json_encode($alerta);
            exit();
        }
        //usuario_usuario
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
                if($checkUsuario->rowCount()>1){
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
        //usuario_mail
        //hay actualizacion
        $actualizaEmail = true;
        if($email != ""){ //no está vacio
            if($email == $campos['usuario_mail']){
                $actualizaEmail = false;
            }
            if (MainModel::checkDat('^[^@]+@[^@]+\.[a-zA-Z]{2,}$',$email)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo EMAIL no coincide con el formato solicitado.',
                    "Texto" => 'No has llenado todos los campos requeridos.'
                ];
    
                echo json_encode($alerta);
                exit();
            }else if( $actualizaEmail){
                $checkUsuario = MainModel::querySimple("SELECT usuario_email from usuarios 
                WHERE usuario_email = '$email'");
                if($checkUsuario->rowCount()>1){
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
       
        //contraseñas
        if(($_POST['usuario_clave_nueva_1'] != "") && 
           ($_POST['usuario_clave_nueva_2'] != "")){
           
            if($_POST['usuario_clave_nueva_1'] != $_POST['usuario_clave_nueva_2']){
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'Ocurrió un error inesperado.',
                    "Texto" => 'Las contraseñas no coinciden.'
                ];
        
                echo json_encode($alerta);
                exit();
            }
            $clave1 = MainModel::cleanString($_POST['usuario_clave_nueva_1']);
            //verificamos datos
            if (MainModel::checkDat('[a-zA-Z0-9$@.-]{7,100}',$clave1)) {
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo Contraseña no coincide con el formato solicitado.',
                    "Texto" => 'El campo es la contraseña que se va a actualizar.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
            $clave = MainModel::encryption($clave1);
        }else{
            $clave = $campos['usuario_clave'];  //obtenido de user-update-view.php
        }

        //comprobar credenciales para actualizar datos
        error_log('$adminUsu::'.$adminUsu);
        error_log('$adminClave::'.$adminClave);
        error_log('$id::'.$id);
        error_log('$tipoCuenta::'.$tipoCuenta);
        if($tipoCuenta == 'propia'){
            $checkUsuario = MainModel::querySimple("SELECT usuario_id from usuarios 
            WHERE usuario_usuario = '$adminUsu' AND usuario_clave = '$adminClave'
            AND usuario_id = '$id'");
        }else{
            session_start(['name' => 'HMN']);
            if ($_SESSION['hmn_privilegio'] != 1){
                $alerta = [
                    "Alerta" => 'simple',
                    "Tipo" => 'error',
                    "Titulo" => 'El campo Contraseña no coincide con el formato solicitado.',
                    "Texto" => 'No tienes los permisos necesario para realizar esta operación.'
                ];
    
                echo json_encode($alerta);
                exit();
            }
            $checkUsuario = MainModel::querySimple("SELECT usuario_id from usuarios 
            WHERE usuario_usuario = '$adminUsu' AND usuario_clave = '$adminClave'");
            error_log(json_encode($checkUsuario->fetchAll()));
        }
        if($checkUsuario->rowCount()<=0){
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Ocurrió un error inesperado.',
                "Texto" => 'Nombre y clave de administrador no válidos.'
            ];
            echo json_encode($alerta);
            exit();
        }
        //Preparando datos para enviarlos al modelo
        $datos = [
        'nombre'    => $nombre,
        'apellido'  => $apellido,
        'telefono'  => $telefono,
        'direccion' => $direccion,
        'email'     => $email,
        'usuario'   => $usuario,
        'clave'     => $clave,
        'estado'    => $estado,
        'privilegio'=> $privilegio,
        'id'        => $id
        ];

        if(UsuarioModel::updateUsuarioModel($datos)){
            $alerta = [
                "Alerta" => 'recargar',
                "Tipo" => 'success',
                "Titulo" => 'Datos Actualizados.',
                "Texto" => 'Los datos han sido actualizados con éxito.'
            ];
            echo json_encode($alerta);
            exit();

        }else{
            $alerta = [
                "Alerta" => 'simple',
                "Tipo" => 'error',
                "Titulo" => 'Ocurrió un error inesperado.',
                "Texto" => 'No hemos podido actualizar los datos porfavor intente nuevamente.'
            ];
            echo json_encode($alerta);
            exit();
        }
        
       } 
    }
}
<?php
if($peticionAjax){//una carpeta arriba si es petición ajax
    require_once "../config/SEERVER.php";  //desde la carpeta ajax
}else{
    require_once "./config/SEERVER.php"; //desde index.php
}
class mainModel{
    protected static function conectarDb(){
        $conexion = new PDO(SGBD, USER, PASS);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    } 
    protected static function querySimple($consulta){
        $sql =self::conectarDb()->prepare($consulta);
        $sql->execute();
        return $sql;
    }
    public function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }
    public function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    
    protected static function generarCodAlea($letra,$longitud,$num){
        for($i=1;$i<=$longitud;$i++){
            $aleatorio = rand(0,9);
            $letra.=$aleatorio;
        }
        return $letra."-".$num;
    }

    protected static function cleanString($cade){
        $cade = str_ireplace("<script>"," ",$cade);
        $cade = str_ireplace("</script>"," ",$cade);
        $cade = str_ireplace("</script>"," ",$cade);
        $cade = str_ireplace("SELECT"," ",$cade);
        $cade = str_ireplace("DELETE"," ",$cade);
        $cade = str_ireplace("UPDATE"," ",$cade);
        $cade = str_ireplace("FROM"," ",$cade);
        $cade = str_ireplace("INSERT"," ",$cade);
        $cade = str_ireplace("DROP"," ",$cade);
        $cade = str_ireplace("TABLE"," ",$cade);
        $cade = str_ireplace("SHOW"," ",$cade);
        $cade = str_ireplace("<"," ",$cade);
        $cade = str_ireplace(">"," ",$cade);
        $cade = str_ireplace("{"," ",$cade);
        $cade = str_ireplace("["," ",$cade);
        $cade = str_ireplace(":"," ",$cade);
        $cade = str_ireplace(";"," ",$cade);
        $cade = str_ireplace("php"," ",$cade);
        $cade = trim($cade);
        $cade = stripslashes($cade);
        return $cade;
    }

    protected static function checkDat($filtro, $cade){
        if(preg_match("/^".$filtro."$/",$cade)){
            return false; //sin error
        }else{
            return true;
        }
    }

    protected static function checkFecha($fecha){
        $val = explode("-",$fecha);
        if(count($val) == 3 && checkdate($val[1],$val[2],$val[0])){
            return false; //sin error
        }else{
            return true;
        }
    }
    
    protected static function paginarTabla($pagina,$Npaginas,$url,$botones){
        $tabla = "<nav aria-label='Page navigation example'>
        <ul class='pagination justify-content-center'>";
        if($pagina == 1){
            $tabla .= '<li class="page-item disabled">
                     <a class="page-link"><i class="fas fa-angle-double-left"></i></a>
                    </li>';
        }else{
            $tabla .= '<li class="page-item">
                     <a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a>
                    </li>
                    <li class="page-item">
                     <a class="page-link" href="'.$url.($pagina-1).'/">Anterior</a>
                    </li>';
        }
        //Creacion de botones
        $al = 0;
        for($i=$pagina;$i<=$Npaginas;$i++){
            if($al >= $botones){//
                break;
            }
            if($pagina == $i){//sombrear boton del boton actual//estamos en la pagina
                $tabla .= '<li class="page-item">
                <a class="page-link active" href="'.$url.$i.'/">'.$i.'</a>
                   </li>';
            }else{
                $tabla .= '<li class="page-item">
                <a class="page-link" href="'.$url.$i.'/">'.$i.'</a>
                   </li>';
            }
            $al++;
        }

        if($pagina == $Npaginas){ //estamos en la última pagina
            $tabla .= '<li class="page-item disabled">
                     <a class="page-link"><i class="fas fa-angle-double-right"></i></a>
                    </li>';
        }else{
            $tabla .= '
                    <li class="page-item">
                     <a class="page-link" href="'.$url.($pagina+1).'/">Siguiente</a>
                    </li>
                    <li class="page-item">
                     <a class="page-link" href="'.$url.$Npaginas.'/"><i class="fas fa-angle-double-right"></i></a>
                    </li>
                    ';
        }
        $tabla .= ' </ul></nav>';
        return $tabla;
    }
    
}
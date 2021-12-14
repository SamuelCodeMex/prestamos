    <!-- Page header -->
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
        </h3>
        <p class="text-justify">
            Lorem ipsum .
        </p>
    </div>
    
    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a href="<?php echo SERVERURL;?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
            </li>
            <li>
                <a class="active" href="<?php echo SERVERURL;?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
            </li>
            <li>
                <a href="<?php echo SERVERURL;?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
            </li>
        </ul>	
    </div>
    
    <!-- Content -->
    <div class="container-fluid">
    <?php 
    require_once "./controllers/UsuarioController.php";
    $ins_usu = new UsuarioController();
    //$pagina[1] en view/plantilla.php $pagina = explode("/",$_GET['views']);
    //$_SESSION['hmn_privilegio'] obtenida de LoginController
    echo $ins_usu->paginadorUsuarioController($pagina[1],5,$_SESSION['hmn_privilegio'],$_SESSION['hmn_id'],$pagina[0],"");
    ?>
    </div>

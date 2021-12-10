<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY;?></title>
    <?php include './view/inc/links.php';?>
</head>
<body>
	<?php
    error_log('preparando plantilla');
	$peticionAjax=false;
	require_once './controllers/VistaController.php';
	$vi = new vistaController();
	$plant = $vi->getVistasController();
	if($plant == "login" || $plant == "404"){
		require_once "./view/contenidos/".$plant."-view.php";
	}else{
		session_start(['name' => 'HMN']);
		require_once './controllers/LoginController.php';
		$lo = new LoginController();
		if(!isset($_SESSION['hmn_token']) || !isset($_SESSION['hmn_id']) ||
		   !isset($_SESSION['hmn_privilegio']) || !isset($_SESSION['hmn_usuario'])){
			echo $lo->fCierreSessionController();
			exit();
		}
		
	?>
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<?php 
		include './view/inc/navlateral.php';?>

		<!-- Page content -->
		<section class="full-box page-content">
            <?php include './view/inc/navbar.php';
			      include $plant;
			?>
			<!-- Page header -->
			<!-- Content -->
		</section>
	</main>
	
	
	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
    <?php 
	   include './view/inc/outLog.php';
    }
	 include './view/inc/script.php';?>
</body>
</html>
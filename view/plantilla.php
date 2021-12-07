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
	$peticionAjax=false;
	require_once './controllers/vistaController.php';
	$vi = new vistaController();
	$plant = $vi->getVistasController();
	if($plant == "login" || $plant == "404"){
		require_once "./view/contenidos/".$plant."-view.php";
	}else{
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
    <?php } include './view/inc/script.php';?>
</body>
</html>
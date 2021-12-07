<?php
require_once "./config/app.php";
require_once "./controllers/vistaController.php";
$plantilla = new vistaController();
$plantilla->getPlantillaController();
?>
<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

echo $baseDatos->listarEgresosPorRangoDeFechaHistorico($_POST['fechaDesde'],$_POST['fechaHasta']);


 ?>
<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

echo $baseDatos->listarEgresosPorRangoDeFecha($_POST['fechaDesde'],$_POST['fechaHasta']);


 ?>
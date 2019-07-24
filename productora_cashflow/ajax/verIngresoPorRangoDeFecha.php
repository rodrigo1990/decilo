<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

echo $baseDatos->listarIngresosPorRangoDeFecha($_POST['fechaDesde'],$_POST['fechaHasta']);


 ?>
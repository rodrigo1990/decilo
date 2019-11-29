<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

echo $baseDatos->listarIngresosPorRangoDeFechaHistorico($_POST['fechaDesde'],$_POST['fechaHasta']);


 ?>
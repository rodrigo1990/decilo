<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();


$baseDatos->eliminarIngresoPorRangoDeFecha($_POST['fechaDesde'],$_POST['fechaHasta']);

$baseDatos->listarIngresos();


 ?>
<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

$baseDatos->eliminarIngreso($_POST['id']);

$baseDatos->listarIngresos();


 ?>
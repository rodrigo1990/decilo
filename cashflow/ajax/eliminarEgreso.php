<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

$msj=$baseDatos->eliminarEgreso($_POST['id']);

$baseDatos->listarEgresos();



 ?>
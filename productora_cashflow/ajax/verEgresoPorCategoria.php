<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

echo $baseDatos->listarEgresosPorCategoria($_POST['categoria']);

 ?>
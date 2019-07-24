<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

$msj = $baseDatos->insertarIngreso($_POST['concepto'],$_POST['fecha'],$_POST['monto'],$_POST['categoria'],$_POST['observacion']);

echo $msj;

 ?>
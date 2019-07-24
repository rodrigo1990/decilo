<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

$baseDatos->insertarEgreso($_POST['concepto'],$_POST['fecha'],$_POST['monto'],$_POST['categoria'],$_POST['observacion']);


 ?>
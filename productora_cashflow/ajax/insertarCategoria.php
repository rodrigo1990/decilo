<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

$baseDatos->insertarCategoria($_POST['categoria']);


 ?>
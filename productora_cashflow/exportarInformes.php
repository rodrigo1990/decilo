<?php 
include("../includes/verificarSesion.php");
require('fpdf/fpdf.php');
require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();


echo $baseDatos->exportarInformes($_POST['fechaDesde'],$_POST['fechaHasta']);






 ?>
<?php 
include("../../includes/verificarSesion.php");
require_once("../inc/conexion.php");

$idAlumna = $_POST['idAlumna'];

$sql = "UPDATE alumna
		SET eliminada=0
		WHERE id_alumna  = $idAlumna ";

$consulta=mysqli_query($conexion, $sql);


$sql = "UPDATE cuota_alumna
		SET eliminada=0
		WHERE id_alumna  = $idAlumna ";

$consulta=mysqli_query($conexion, $sql);



 ?>
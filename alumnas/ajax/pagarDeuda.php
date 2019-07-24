<?php 
include("../../includes/verificarSesion.php");
require_once("../inc/conexion.php");

$idAlumna = $_POST['idAlumna'];

$sql = "UPDATE cuota_alumna
		SET adeuda=0,esta_paga=1,eliminada=1
		WHERE id_alumna  = $idAlumna AND adeuda=1 AND esta_paga=0 ";

$consulta=mysqli_query($conexion, $sql);

$sql = "UPDATE alumna
			SET eliminada=1
			WHERE id_alumna  = $idAlumna ";

	$consulta=mysqli_query($conexion, $sql);


	




 ?>
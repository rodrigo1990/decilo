<?php 
include("../../includes/verificarSesion.php");
require_once("../inc/conexion.php");

$idAlumna = $_POST['idAlumna'];


$sql = "SELECT *
		FROM cuota_alumna
		WHERE id_alumna  = $idAlumna AND adeuda=1 ";

$consulta=mysqli_query($conexion, $sql);


$fila=mysqli_fetch_assoc($consulta);

if(!$fila){

	$sql = "UPDATE alumna
			SET eliminada=1
			WHERE id_alumna  = $idAlumna ";

	$consulta=mysqli_query($conexion, $sql);


	$sql = "UPDATE cuota_alumna
			SET eliminada=1
			WHERE id_alumna  = $idAlumna ";

	$consulta=mysqli_query($conexion, $sql);


	return true;

}else{
	return false;
}

 ?>
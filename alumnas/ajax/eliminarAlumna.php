<?php 
include("../../includes/verificarSesion.php");
require_once("../inc/conexion.php");

$idAlumna = $_POST['idAlumna'];

$sql = "SELECT *
		FROM cuota_alumna
		WHERE id_alumna  = $idAlumna AND adeuda=1 ";

$consulta=mysqli_query($conexion, $sql);


$fila=mysqli_fetch_assoc($consulta);


if($fila['id_cuota']==null){

	$sql = "UPDATE alumna
			SET eliminada=1
			WHERE id_alumna  = $idAlumna ";

	$consulta=mysqli_query($conexion, $sql);


	$sql = "UPDATE cuota_alumna
			SET eliminada=1
			WHERE id_alumna  = $idAlumna ";

	$consulta=mysqli_query($conexion, $sql);


	$sql = "UPDATE inscripcion
			SET eliminada=1
			WHERE id_alumna  = $idAlumna ";

	$consulta=mysqli_query($conexion, $sql);


	echo "1";

}else{
	echo "0";
}


//return var_dump($fila['id_cuota']);

 ?>
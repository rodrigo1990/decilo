<?php
include("../../includes/verificarSesion.php");

require_once("../inc/conexion.php");

$idAlumna = $_POST['idAlumna'];

$idGrupo = $_POST['idGrupo'];


$sql = "SELECT *
		FROM cuota_alumna
		WHERE id_alumna  = $idAlumna AND adeuda=1 AND id_grupo = $idGrupo";

$consulta=mysqli_query($conexion, $sql);

$fila=mysqli_fetch_assoc($consulta);


//return var_dump($fila);

if(!$fila){

	
	$sql="UPDATE cuota_alumna SET eliminada=1 WHERE id_alumna=$idAlumna AND id_grupo=$idGrupo";
	$consulta=mysqli_query($conexion, $sql);


	return true;
//header("location:index.php?id_alumna=".$_GET['id_alumna']."&elim=ok");

}else{

	return false;

}
?>


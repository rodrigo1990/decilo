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



if($fila['id_cuota']==null){

	
	$sql="UPDATE cuota_alumna SET eliminada=1 WHERE id_alumna=$idAlumna AND id_grupo=$idGrupo";
	$consulta=mysqli_query($conexion, $sql);


	$sql="UPDATE inscripcion SET eliminada=1 WHERE id_alumna=$idAlumna AND id_grupo=$idGrupo";
	$consulta=mysqli_query($conexion, $sql);


	echo "1";
//header("location:index.php?id_alumna=".$_GET['id_alumna']."&elim=ok");

}else{

	echo  "0";

}
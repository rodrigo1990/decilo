<?php 
include("../../includes/verificarSesion.php");

require_once("../inc/conexion.php");

	$sql = " SELECT id_grupo
			FROM inscripcion
			WHERE id_alumna = ".$_POST['id_alumna']." AND id_grupo = ".$_POST['id_grupo']." ";

	$consulta = mysqli_query($conexion, $sql);

	$fila=mysqli_fetch_assoc($consulta);


	if(isset($fila['id_grupo'])){
		echo  "true";
	}else{
		echo "false";
	}




 ?>
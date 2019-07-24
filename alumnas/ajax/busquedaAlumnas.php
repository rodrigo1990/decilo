<?php 
include("../../includes/verificarSesion.php");

require_once("../inc/conexion.php");
	$bus="%".$_GET['busqueda']."%";
	
	$sql="SELECT * FROM alumna 
	WHERE  (nombre like '$bus' OR mail LIKE '$bus') AND eliminada=0";
	$consulta=mysqli_query($conexion, $sql);
	
	echo "<ul>";
	while($fila=mysqli_fetch_assoc($consulta)){
		
		echo "<li><a href='index.php?id_alumna=".$fila['id_alumna']."'>".$fila['nombre']." - ".$fila['mail']."</a></li>";	
	}
	
	echo "</ul>";


 ?>
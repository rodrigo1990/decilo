<?php
include("../../includes/verificarSesion.php");
require_once("../inc/conexion.php");
require_once("../inc/funciones.php");

$sede = $_GET['id_sede'];

$sql = "SELECT id_grupo,grupo
		 FROM grupo
		 WHERE id_sede = $sede ";

$consulta=mysqli_query($conexion, $sql);

	while($fila=mysqli_fetch_assoc($consulta)){
		
		echo "<option value=".$fila['id_grupo'].">
				".$fila['grupo']."
				</option>";
	}










/*echo '<label>Sede</label>
    <select name="id_sede" id="id_sede" onChange="recargarGrupos()">
    	';
    	generarSedes($conexion, $_GET['id_sede']);
 echo   '</select>
   <br />
     <label>Actividad</label>
    <select name="actividad" id="actividad">';
       generarGrupos($conexion, $_GET['id_sede']);
 echo   '</select>';*/


?>

<!-- <script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="../js/funciones.js"></script> -->
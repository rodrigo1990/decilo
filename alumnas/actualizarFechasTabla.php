<?php 
require_once("inc/conexion.php");
require_once("inc/funciones.php");

//actualizarFechasTabla($conexion);

echo date('Y-m-d H:i:s');
echo "<br>";

	$mesActual = date('m') -1;
	$anioActual = date('Y');

	for($i=0; $i<=12;$i++){

		$mesActual+=1;

		echo $mesActual."/".$anioActual;
		echo "<br>";

		if($mesActual>=12){

			$anioActual+=1;
			$mesActual=00;
			echo "Cambio de año";
			echo "<br>";
		}
		

	}	





 ?>
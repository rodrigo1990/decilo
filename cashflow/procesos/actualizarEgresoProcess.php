<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();



 ?>

<!DOCTYPE html>
<html lang="en">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
	<title>Home - Cashflow</title>
	<link rel="stylesheet" href="../../materialize/css/materialize.min.css">
	<link rel="stylesheet" href="../../estilos/fuentes.css">
	<link rel="stylesheet" href="../../estilos/estilos.css">
</head>
<body>
 	<header>
		<div class="row row1">
		<div class="col l2 m2">
				
			</div>
			<div class="col l8 m8">
				
			</div>
			<div class="col l2 m2">
				<div class="center-align"style="float:right">
						<a href="../index.php"><p style="">Cerrar Sesion</p></a>
				</div>
			</div>
	</div>
	<div class="row no-margin-bottom">
			<div class="col l2 m2">
				<a href="../index.php" style="text-decoration:none;color:white"><img src="../../img/logo.png" alt=""></a>
			</div>
			<div class="col l10 m10">
				<div class="center-align"style="float:right">
					<h2>CASHFLOW</h2>
				</div>
			</div>
	</div>


</header>
	<div class="row">
		
		<div class="container">

 	<?php 
 	if(isset($_POST['concepto'])){
 	$msj=$baseDatos->actualizarEgreso($_POST['concepto'],$_POST['fecha'],$_POST['monto'],$_POST['id'],$_POST['categoria']);
 	echo $msj;
 }else{
 	echo "<h1>Enhorabuena!</h1><br>
					<h2>Se ha actualizado el egreso correctamente</h2><br>
					<a href='../listarIngresos.php'>Volver a ingresos</a>
					<a href='../index.php'>Volver a home</a>";
 }
 	 ?>
 	
 	 </div>
 	</div>
 </body>
 </html>
<?php
include("../includes/verificarSesion.php"); 

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=reporteCashflow.xls");

require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php 

		$baseDatos->exportarInformeXLS($_GET['fd'],$_GET['fh']);

	 ?>
</body>
</html>
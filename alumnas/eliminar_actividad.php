<?php
include("../includes/verificarSesion.php");

require_once("inc/conexion.php");



$sql="UPDATE cuota_alumna SET eliminada=1 WHERE id_alumna=".$_GET['id_alumna']." AND id_grupo=".$_GET['id_grupo'];
$consulta=mysqli_query($conexion, $sql);

header("location:index.php?id_alumna=".$_GET['id_alumna']."&elim=ok");
?>


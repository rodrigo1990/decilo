<?php 
include("../../includes/verificarSesion.php");
require_once("../clases/BaseDatos.php");

$baseDatos = new BaseDatos();

$baseDatos->eliminarCategoria($_POST['id']);



echo $baseDatos->listarCategorias('ingresar categorias');


 ?>
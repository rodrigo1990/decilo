<?php 
session_start();
require_once("../clases/Validator.php");

$v = new Validator();

$return=$v->validarAdminDeciloCash($_POST['usuario'],md5($_POST['pass']));

if($return==TRUE){
	$_SESSION['pass']=md5($_POST['pass']);
	$_SESSION['usuario']=$_POST['usuario'];
	echo "true";

}else{
	echo "false";
}

 ?>
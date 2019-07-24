<?php 
session_start();
if(!isset($_SESSION["pass"]) AND !isset($_SESSION['usuario'])){
    header("Location:../index.php");
}
?>
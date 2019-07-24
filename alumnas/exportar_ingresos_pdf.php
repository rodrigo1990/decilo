<?php
include("../includes/verificarSesion.php");

require('fpdf/fpdf.php');
require('inc/funciones.php');
require('inc/conexion.php');

if(isset($_GET['id_grupo'])){
	
	$sql="SELECT * FROM grupo WHERE id_grupo=".$_GET['id_grupo'];
	$consulta=mysqli_query($conexion, $sql);
	$fila=mysqli_fetch_assoc($consulta);
	
	$texto="El ingreso total en ".$meses_nombre[$_GET['mes']]." de ".$_GET['anio']." para el grupo ".$fila['grupo']." es: $".$_GET['total'];	
	
}else{

	$texto="El ingreso total en ".$meses_nombre[$_GET['mes']]." de ".$_GET['anio']." es: $".$_GET['total'];	

}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10, $texto,0,1);
$pdf->SetFont('Arial','',10);

if(isset($_GET['id_grupo'])){
	
$sql="SELECT cuota_alumna.*, alumna.nombre, grupo.grupo, sede.sede, concepto.concepto
FROM cuota_alumna INNER JOIN alumna ON cuota_alumna.id_alumna=alumna.id_alumna
INNER JOIN grupo on cuota_alumna.id_grupo=grupo.id_grupo
INNER JOIN sede on grupo.id_sede=sede.id_sede
INNER JOIN concepto ON  cuota_alumna.id_concepto=concepto.id_concepto 
WHERE cuota_alumna.mes=".$_GET['mes']." AND cuota_alumna.anio=".$_GET['anio'].
" AND esta_paga = 1 AND cuota_alumna.id_grupo=".$_GET['id_grupo']." ORDER BY cuota_alumna.fecha_pago";
	
}else{
 $sql="SELECT cuota_alumna.*, alumna.nombre, grupo.grupo, sede.sede, concepto.concepto
FROM cuota_alumna INNER JOIN alumna ON cuota_alumna.id_alumna=alumna.id_alumna
INNER JOIN grupo on cuota_alumna.id_grupo=grupo.id_grupo
INNER JOIN sede on grupo.id_sede=sede.id_sede 
INNER JOIN concepto ON cuota_alumna.id_concepto=concepto.id_concepto 
WHERE cuota_alumna.mes=".$_GET['mes']." AND esta_paga = 1 AND cuota_alumna.anio=".$_GET['anio'].
" ORDER BY cuota_alumna.fecha_pago";
}
$consulta=mysqli_query($conexion, $sql);

while($fila=mysqli_fetch_assoc($consulta)){
	
	$texto='Fecha pago: '.date("d-m-Y", strtotime($fila['fecha_pago'])).' | Concepto: '.$fila['concepto'].' | '.$fila['nombre'].' - $ '.$fila['monto'].' - '.$fila['grupo'].' / '.$fila['sede'].' | '.$fila['mes'].'/'.$fila['anio'];
	
	$pdf->Cell(0,4, $texto,0,1);
	
}

$pdf->Output();
?>
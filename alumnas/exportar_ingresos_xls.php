<?php
include("../includes/verificarSesion.php");

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=reporteAlumnas.xls");
require('fpdf/fpdf.php');
require('inc/funciones.php');
require('inc/conexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
	
	<title>Document</title>
</head>
<body>
	<?php 
		if(isset($_GET['id_grupo'])){
	
	$sql="SELECT * FROM grupo WHERE id_grupo=".$_GET['id_grupo'];
	$consulta=mysqli_query($conexion, $sql);
	$fila=mysqli_fetch_assoc($consulta);
	
	$texto="El ingreso total en ".$meses_nombre[$_GET['mes']]." de ".$_GET['anio']." para el grupo ".$fila['grupo']." es: $".$_GET['total'];	
	
}else{

	$texto="El ingreso total en ".$meses_nombre[$_GET['mes']]." de ".$_GET['anio']." es: $".$_GET['total'];	

}



if(isset($_GET['id_grupo'])){

$sqlTot="SELECT sum(cuota_alumna.monto) as TOTAL
FROM cuota_alumna
WHERE cuota_alumna.mes=".$_GET['mes']." AND cuota_alumna.anio=".$_GET['anio'].
" AND cuota_alumna.id_grupo=".$_GET['id_grupo']." ORDER BY cuota_alumna.fecha_pago";

$sql="SELECT cuota_alumna.id_cuota,cuota_alumna.id_alumna,cuota_alumna.mes,cuota_alumna.anio,cuota_alumna.monto,cuota_alumna.id_concepto,cuota_alumna.id_grupo,cuota_alumna.fecha_pago,cuota_alumna.eliminada, alumna.nombre, grupo.grupo, sede.sede, concepto.concepto
FROM cuota_alumna INNER JOIN alumna ON cuota_alumna.id_alumna=alumna.id_alumna
INNER JOIN grupo on cuota_alumna.id_grupo=grupo.id_grupo
INNER JOIN sede on grupo.id_sede=sede.id_sede
INNER JOIN concepto ON  cuota_alumna.id_concepto=concepto.id_concepto 
WHERE cuota_alumna.mes=".$_GET['mes']." AND cuota_alumna.anio=".$_GET['anio'].
" AND cuota_alumna.id_grupo=".$_GET['id_grupo']." ORDER BY cuota_alumna.fecha_pago";
	
}else{

$sqlTot="SELECT sum(cuota_alumna.monto) as TOTAL
FROM cuota_alumna
WHERE cuota_alumna.mes=".$_GET['mes']." AND cuota_alumna.anio=".$_GET['anio'].
"  ORDER BY cuota_alumna.fecha_pago";


 $sql="SELECT cuota_alumna.id_cuota,cuota_alumna.id_alumna,cuota_alumna.mes,cuota_alumna.anio,cuota_alumna.monto,cuota_alumna.id_concepto,cuota_alumna.id_grupo,cuota_alumna.fecha_pago,cuota_alumna.eliminada, alumna.nombre, grupo.grupo, sede.sede, concepto.concepto
FROM cuota_alumna INNER JOIN alumna ON cuota_alumna.id_alumna=alumna.id_alumna
INNER JOIN grupo on cuota_alumna.id_grupo=grupo.id_grupo
INNER JOIN sede on grupo.id_sede=sede.id_sede 
INNER JOIN concepto ON cuota_alumna.id_concepto=concepto.id_concepto 
WHERE cuota_alumna.mes=".$_GET['mes']." AND cuota_alumna.anio=".$_GET['anio'].
" ORDER BY cuota_alumna.fecha_pago";
}
$consulta=mysqli_query($conexion, $sql);

$consulta2=mysqli_query($conexion, $sqlTot);

?>
<table>


<tr>
<th>Fecha pago</th>
<th>Concepto</th>
<th>Nombre alumna</th>
<th>Grupo</th>
<th>Sede</th>
<th>Mes</th>
<th>Año</th>
<th>Monto</th>
</tr>

<tbody>

<?PHP

$fila=0;

while($fila=mysqli_fetch_assoc($consulta)){
	echo
	'
	<tr>
		<td>'.utf8_encode(date("d-m-Y", $fila['fecha_pago'])).'</td>
		<td>'.utf8_encode($fila['concepto']).'</td>
		<td>'.utf8_encode($fila['nombre']).'</td>
		
		<td>'.utf8_encode($fila['grupo']).'</td>
		<td>'.utf8_encode($fila['sede']).'</td>
		<td>'.utf8_encode($fila['mes']).'</td>
		<td>'.utf8_encode($fila['anio']).'</td>
		<td>$'.utf8_encode($fila['monto']).'</td>
	</tr>
	';

	
	
}
while($fila2=mysqli_fetch_assoc($consulta2)){
	echo '
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>TOTAL:</td>
			<td>'.utf8_encode($fila2['TOTAL']).'</td>

		</tr>
		';
}
?>
	
</tbody>
</table>


</body>
</html>




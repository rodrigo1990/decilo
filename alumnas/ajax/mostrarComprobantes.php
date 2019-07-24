<?php
include("../../includes/verificarSesion.php");
require_once("../inc/conexion.php");
require_once("../inc/funciones.php");

$id_grupo=$_GET['id'];
$id_alumna=$_GET['id_alumna'];


$meses_pagos=array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

$sql="SELECT grupo.*, sede.sede 
FROM grupo INNER JOIN sede ON grupo.id_sede=sede.id_sede
WHERE grupo.id_grupo=$id_grupo";
$consulta=mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($consulta);
$grupo=$fila['grupo'];
$sede=$fila['sede'];

$sql="SELECT * FROM cuota_alumna WHERE id_alumna=$id_alumna
AND id_grupo=$id_grupo 
AND id_concepto = 1
AND anio=".date("Y")." ORDER BY mes";
$consulta=mysqli_query($conexion, $sql);
while($fila=mysqli_fetch_assoc($consulta)){
$meses_pagos[$fila['mes']]=$fila['monto'];	
}

 echo  '<h2>Cuotas '.$grupo.' / '.$sede.'</h2>';
for($i=1; $i<=12; $i++){
	
   
echo '<div class="col l2">
    <div class="mes">
        <div class="mes_titulo">
            '.$meses_nombre[$i].'
        </div>
        <div class="mes_monto">
        $'.$meses_pagos[$i].'
        </div>
       </div>   
    </div>
</div> ';
	
	
}

$sql="SELECT cuota_alumna.*, concepto.concepto 
FROM cuota_alumna INNER JOIN concepto ON cuota_alumna.id_concepto=concepto.id_concepto
 WHERE cuota_alumna.id_alumna=$id_alumna
AND cuota_alumna.id_grupo=$id_grupo ORDER BY cuota_alumna.fecha_pago DESC";

echo  '<h2>Otros conceptos: '.$grupo.' / '.$sede.'</h2>';

echo '<div class="row">
			<div class="col l3">Fecha
			</div>
			<div class="col l3">Monto
			</div>
			<div class="col l3">Concepto
			</div>
			<div class="col l3">Período
			</div>
		</div>';

$consulta=mysqli_query($conexion, $sql);
while($fila=mysqli_fetch_assoc($consulta)){
	
	echo '<div class="row">
			<div class="col l3">'.date("d-m-Y",$fila['fecha_pago']).'
			</div>
			<div class="col l3">$'.$fila['monto'].'
			</div>
			<div class="col l3">'.utf8_encode($fila['concepto']).'
			</div>
			<div class="col l3">'.$fila['mes'].'-'.$fila['anio'].'
			</div>
		</div>';
	
}

?>
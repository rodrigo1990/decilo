<?php

$meses_nombre=array("Seleccione","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");


function generarSedes($conexion, $option_sel=0){

	echo '<option value="0">Todas</option>';
    $sql="SELECT * FROM sede";
	$consulta=mysqli_query($conexion, $sql);
	while($fila=mysqli_fetch_assoc($consulta)){
    	
		//agregamos selected si corresponde
		if($option_sel!=0 && $option_sel==$fila['id_sede'] ){
			$sel='selected ';		
		}else{
			
			$sel=' ';	
		}
		
		echo '<option '.$sel.' value="'.$fila['id_sede'].'" >'.$fila['sede'].'</option>';
		
	
	}//fin while
	
}//fin function


function agregarAlumna( $conexion, $nombre, $fecha_ingreso, $fecha_nacimiento, $mail, $celular, $aclaraciones){	    

	$fecha_i=strtotime($fecha_ingreso);
	$fecha_nac=strtotime($fecha_nacimiento);
		
	$sql="INSERT INTO alumna(nombre, fecha_ingreso, fecha_nacimiento, mail, celular,  aclaraciones)
		VALUES('$nombre', '$fecha_i', '$fecha_nac', '$mail', '$celular',  '$aclaraciones')";
	$consulta=mysqli_query($conexion, $sql);		
		
	$id_alumna=mysqli_insert_id($conexion);
	return $id_alumna;

				
}

function modificarAlumna( $conexion, $id_alumna, $nombre, $fecha_ingreso, $fecha_nacimiento, $mail, $celular, $aclaraciones){	    

	$fecha_i=strtotime($fecha_ingreso);
	$fecha_nac=strtotime($fecha_nacimiento);
		
	$sql="UPDATE alumna
	SET nombre='$nombre', 
	fecha_ingreso='$fecha_i', 
	fecha_nacimiento='$fecha_nac', 
	mail='$mail', 
	celular='$celular', 
	
	aclaraciones='$aclaraciones'
	WHERE id_alumna=$id_alumna";
	$consulta=mysqli_query($conexion, $sql);		
			
}

function mostrarResultadosBusqueda($conexion, $busqueda){
	
	$bus="%".$busqueda."%";
	
	$sql="SELECT * FROM alumna 
	WHERE nombre like '$bus' OR mail LIKE '$bus'";
	$consulta=mysqli_query($conexion, $sql);
	
	echo "<ul>";
	while($fila=mysqli_fetch_assoc($consulta)){
		
		echo "<li><a href='alumnas.php?id_alumna=".$fila['id_alumna']."'>".$fila['nombre']." - ".$fila['mail']."</a></li>";	
	}
	
	echo "</ul>";
		
}

function generarComprobante($conexion,$conexion2, $id_alumna, $mes, $anio, $monto, $id_concepto, $id_grupo, $fecha_pago ){
	$fp=strtotime($fecha_pago);

	if($id_concepto!=4){
	
		$sql="INSERT INTO cuota_alumna(id_alumna, mes, anio, monto, id_concepto, id_grupo, fecha_pago)
		VALUES($id_alumna, '$mes', '$anio', '$monto', '$id_concepto', '$id_grupo', '$fp')";
		$consulta=mysqli_query($conexion, $sql);
		$id_cuota=mysqli_insert_id($conexion);

	}else{

		$monto=-$monto;

		$sql="INSERT INTO cuota_alumna(id_alumna, mes, anio, monto, id_concepto, id_grupo, fecha_pago)
		VALUES($id_alumna, '$mes', '$anio', '$monto', '$id_concepto', '$id_grupo', '$fp')";
		$consulta=mysqli_query($conexion, $sql);
		$id_cuota=mysqli_insert_id($conexion);

	}

	if($id_concepto!=4){

		$sql = "SELECT nombre,mail
				FROM alumna 
				WHERE id_alumna=$id_alumna";

		$consulta=mysqli_query($conexion, $sql);
		$fila=mysqli_fetch_assoc($consulta);

		$observacion = "Pago realizado por la alumna: ".$fila['nombre']." mail:".$fila['mail']."";

		$sql="INSERT INTO ingreso(concepto,fecha,monto,id_categoria,observacion)
			  VALUES('Mensualidad Alumna','$fecha_pago',$monto,8,'$observacion')";

		$consulta=mysqli_query($conexion2,$sql);


	}else{
		$monto= abs($monto);

		$sql = "SELECT nombre,mail
				FROM alumna 
				WHERE id_alumna=$id_alumna";

		$consulta=mysqli_query($conexion, $sql);
		$fila=mysqli_fetch_assoc($consulta);

		$observacion = "Devolucion realizada por la alumna: ".$fila['nombre']." mail:".$fila['mail']."";

		$sql="INSERT INTO egreso(concepto,fecha,monto,id_categoria,observacion)
			  VALUES('Devolucion Mensualidad Alumna','$fecha_pago',$monto,8,'$observacion')";

		$consulta=mysqli_query($conexion2,$sql);

	}




return $id_cuota;	
}


function generarActividades($conexion, $id_alumna, $option_sel=0){

	echo "<option value='0'>Seleccione</option>";
    $sql="SELECT cuota_alumna.*, grupo.grupo 
	FROM cuota_alumna INNER JOIN grupo  ON cuota_alumna.id_grupo=grupo.id_grupo
	WHERE cuota_alumna.id_alumna=$id_alumna
	AND cuota_alumna.eliminada=0
	GROUP BY cuota_alumna.id_grupo";
	$consulta=mysqli_query($conexion, $sql);
	$i=1;
	while($fila=mysqli_fetch_assoc($consulta)){
    	
		//agregamos selected si corresponde
		if($option_sel!=0 && $option_sel==$fila['id_grupo'] ){
			$sel=' selected ';		
		}else{
			
			$sel=' ';	
		}
		
		echo '<option '.$sel.' value="'.$fila['id_grupo'].'" >'.$fila['grupo'].'</option>';
		
		if($i=1){
			if($option_sel==0){
				$seleccionado=$fila['id_grupo'];	
			}else{
				$seleccionado=$option_sel;	
			}
		}
		
	$i++;
	}//fin while
	return $seleccionado;	
}


function generarGrupos($conexion, $sede=0, $option_sel=0){
	
	if($sede==0){
		
		$sql="SELECT grupo.*, sede.sede 
		FROM grupo INNER JOIN sede ON grupo.id_sede=sede.id_sede";				
	}else{
		$sql="SELECT grupo.*, sede.sede 
		FROM grupo INNER JOIN sede ON grupo.id_sede=sede.id_sede
		WHERE grupo.id_sede=$sede";			
	}
	$consulta=mysqli_query($conexion, $sql);
	
	while($fila=mysqli_fetch_assoc($consulta)){
		
		if($option_sel!=0 && $option_sel==$fila['id_grupo'] ){
			$sel=' "selected" ';		
		}else{
			
			$sel=' ';	
		}
		
		echo '<option '.$sel.' value="'.$fila['id_grupo'].'" >'.utf8_encode($fila['grupo']).' / '.utf8_encode($fila['sede']).'</option>';
			
	}
}


function generarConceptos($conexion, $option_sel=0){
	
	
	$sql="SELECT * FROM concepto WHERE id_concepto!=0";		

	$consulta=mysqli_query($conexion, $sql);
	
	while($fila=mysqli_fetch_assoc($consulta)){
		
		if($option_sel!=0 && $option_sel==$fila['id_concepto'] ){
			$sel=' "selected" ';		
		}else{
			
			$sel=' ';	
		}
		
		echo '<option '.$sel.' value="'.$fila['id_concepto'].'" >'.utf8_encode($fila['concepto']).'</option>';
			
	}
}

function mostrarComprobantes($conexion, $id_alumna, $id_grupo){
	

                $meses_pagos=array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
				
				$meses_nombre=array("Seleccione","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                if($id_grupo==0){
					
				$sql="SELECT * FROM cuota_alumna 
				WHERE id_alumna=$id_alumna
				AND eliminada=0
				ORDER BY fecha_pago DESC limit 1";
				$consulta=mysqli_query($conexion, $sql);
                $fila=mysqli_fetch_assoc($consulta);
				$id_grupo=$fila['id_grupo'];	
				}
				
				if($id_grupo!=0){
				
				$sql="SELECT grupo.*, sede.sede 
                FROM grupo INNER JOIN sede ON grupo.id_sede=sede.id_sede
                WHERE grupo.id_grupo=$id_grupo";
                $consulta=mysqli_query($conexion, $sql);
                $fila=mysqli_fetch_assoc($consulta);
                $grupo=$fila['grupo'];
                $sede=$fila['sede'];

                $sql="SELECT * FROM cuota_alumna WHERE id_alumna=$id_alumna
                AND id_grupo=$id_grupo
				AND eliminada=0
                AND anio=".date("Y")." ORDER BY mes";
                $consulta=mysqli_query($conexion, $sql);
                while($fila=mysqli_fetch_assoc($consulta)){
                $meses_pagos[$fila['mes']]=$fila['monto'];  
                }

                 echo  '<h2>'.$grupo.' / '.$sede.' <a href="eliminar_actividad.php?id_grupo='.$id_grupo.'&id_alumna='.$id_alumna.'"class="eliminarActividad">Eliminar Actividad</a></h2>';
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
                        </div> ';
                    
                }
				
				$sql="SELECT cuota_alumna.*, concepto.concepto 
FROM cuota_alumna INNER JOIN concepto ON cuota_alumna.id_concepto=concepto.id_concepto
 WHERE cuota_alumna.id_alumna=$id_alumna
AND cuota_alumna.id_grupo=$id_grupo 
AND cuota_alumna.eliminada=0
AND cuota_alumna.id_concepto <> 1 ORDER BY cuota_alumna.fecha_pago DESC";
$consulta=mysqli_query($conexion, $sql);

if(mysqli_num_rows($consulta)!=0){
echo  '<h2>Otros conceptos: '.$grupo.' / '.$sede.'<a href="eliminar_actividad.php?id_grupo='.$id_grupo.'&id_alumna='.$id_alumna.'" class="eliminarActividad">Eliminar Actividad</a></h2>';

echo '<table>
		<tr>
			<th>Fecha</th>
			<th>Monto</th>
			<th>Concepto</th>
			<th>Período</th>
		</tr>
		<tbody>';


while($fila=mysqli_fetch_assoc($consulta)){
	
	echo '<tr>
			<td>'.date("d-m-Y",$fila['fecha_pago']).'</td>
			<td>$'.$fila['monto'].'</td>
			<td>'.utf8_encode($fila['concepto']).'</td>
			<td>'.$fila['mes'].'-'.$fila['anio'].'</td>
		</tr>';
	
}
echo "</tbody>";
echo "</table>";
}
				}//fin de si grupo!=0
	
}

?>
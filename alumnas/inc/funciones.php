<?php

$meses_nombre=array("Seleccione","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");



function generarDeudas($conexion){

	$mesActual = date('m');
	$anioActual = date('Y');

	$sql = "UPDATE cuota_alumna
				SET adeuda = 1
				WHERE mes  = '$mesActual' AND anio = '$anioActual' AND esta_paga=0 ";

	$consulta=mysqli_query($conexion, $sql);

	


}

function listarDeudores($conexion){

    $sql="SELECT AL.nombre as nombre_alumna, GRU.grupo AS nombre_grupo, CA.mes, CA.anio
    	  FROM cuota_alumna CA JOIN alumna AL ON CA.id_alumna = AL.id_alumna 
    	  						JOIN grupo GRU ON CA.id_grupo = GRU.id_grupo


    	  WHERE adeuda=1";
	$consulta=mysqli_query($conexion, $sql);

	

	return mysqli_fetch_array($consulta);
	
}//fin function


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
	

				
}//function

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

function generarComprobante($conexion,$conexion2, $id_alumna, $mes, $anio, $monto, $id_concepto, $id_grupo, $fecha_pago,$deuda ){

	/*GENERAR COMPROBANTES QUE DEBERAN PAGARSE*/
	$mesActual = (int)$mes;
	$anioActual = (int)$anio;

	$fp=$fecha_pago;

	//SI ES MATRICULA O CLASE DE PRUEBA
	if($id_concepto == "2" OR $id_concepto == "3"){

		$mesActual = date('m');

		$anioActual = date('Y');

		if($deuda=="deuda"){
			$esta_paga = 0;
			$adeuda = 1;	
		}else{
			$esta_paga = 1;
			$adeuda = 0;
		}

			$sql="INSERT INTO cuota_alumna(id_alumna, mes, anio, monto, id_concepto,  id_grupo, fecha_pago, eliminada, adeuda, esta_paga)
						VALUES($id_alumna, $mesActual, $anioActual, $monto,  $id_concepto,$id_grupo,null,0,$adeuda,$esta_paga)";

			$consulta=mysqli_query($conexion, $sql);
		

	}


	if($id_concepto==1){	

			//BUSCO QUE EXISTAN COMPROBANTES QUE HAGAN REFERENCIA A AL ACTIVIDAD/GRUPO ESCOGIDA
			$sql="SELECT * 
				FROM cuota_alumna
				WHERE id_alumna=$id_alumna AND id_grupo=$id_grupo AND id_concepto = 1";

				$consulta=mysqli_query($conexion, $sql);

				$fila = mysqli_fetch_assoc($consulta);

				//CUENTO LA CANTIDAD DE REGISTROS QUE CORRESPONDAN A LA ACTIVIDAD Y AL ALUMNO, SI LA CANTIDAD ES 13
				//SIGNIFICA QUE EL ALUMNO A COMPLETADO EL PRIMER Aﾃ前 Y ES NECESARIO CREAR 13 REGISTROS MAS.
				$sql2="SELECT COUNT(*) as cantidad
				FROM cuota_alumna
				WHERE id_alumna=$id_alumna AND id_grupo=$id_grupo AND esta_paga=1 AND id_concepto = 1";

				$consulta2=mysqli_query($conexion, $sql2);

				$fila2 = mysqli_fetch_assoc($consulta2);


				//SOLAMENTE SI NO EXISTE, VOY A GENERAR TODOS LOS COMPROBANTES QUE DEBEN PAGARSE
				//O SI EL ALUMNO HA CURSADO LOS 13 MESES DE CURSO
				if(!$fila OR $fila2['cantidad']==13){

					for($i=0; $i<=12;$i++){

						if($mesActual==0){
							$mesActual=1;
						}



						$sql="INSERT INTO cuota_alumna(id_alumna, mes, anio, monto, id_concepto,  id_grupo, fecha_pago, eliminada, adeuda, esta_paga)
							VALUES($id_alumna, $mesActual, $anioActual, 0,  $id_concepto,$id_grupo,null,0,0,0)";

						$consulta=mysqli_query($conexion, $sql);

						$mesActual+=1;

						if($mesActual>=13){

							$anioActual+=1;
							$mesActual=00;
						}

				}//FOR

			}

	}


	if($id_concepto!=4){

		if($deuda!="deuda"){
			
			if($id_concepto == "2" OR $id_concepto == "3"  ){
				$mes = $mesActual;
				$anio = $anioActual;
			}

			//$sql="INSERT INTO cuota_alumna(id_alumna, mes, anio, monto, id_concepto, id_grupo, fecha_pago)
			//VALUES($id_alumna, '$mes', '$anio', '$monto', '$id_concepto', '$id_grupo', '$fp')";
			//ACTUALIZAR COMPROBANTE PAGADO
			$sql = "UPDATE cuota_alumna
					SET   monto = $monto, fecha_pago = '$fp',esta_paga=1, adeuda=0
					WHERE id_alumna = $id_alumna AND mes = $mes AND anio = $anio AND id_concepto = 1 AND id_grupo = $id_grupo";

			$consulta=mysqli_query($conexion, $sql);
			//$id_cuota=mysqli_insert_id($conexion);
		}
			$sql = "SELECT id_cuota
					FROM cuota_alumna
					WHERE id_alumna = $id_alumna AND mes = $mes AND anio = $anio AND id_concepto = $id_concepto AND id_grupo = $id_grupo  ";

			$consulta=mysqli_query($conexion, $sql);

			$fila=mysqli_fetch_assoc($consulta);

			$id_cuota = $fila['id_cuota'];

		

	}else{

		$monto=-$monto;

		$sql="INSERT INTO cuota_alumna(id_alumna, mes, anio, monto, id_concepto, id_grupo, fecha_pago)
		VALUES($id_alumna, '$mes', '$anio', '$monto', '$id_concepto', '$id_grupo', '$fp')";
		$consulta=mysqli_query($conexion, $sql);
		$id_cuota=mysqli_insert_id($conexion);

	}

	if($id_concepto!=4){

		//DEVOLVER INFORMACION DEL ALUMNO PARA GENERAR COMPROBANTE
/*		$sql = "SELECT nombre,mail
				FROM alumna 
				WHERE id_alumna=$id_alumna";

		$consulta=mysqli_query($conexion, $sql);
		$fila=mysqli_fetch_assoc($consulta);

		$observacion = "Pago realizado por la alumna: ".$fila['nombre']." mail:".$fila['mail']."";

		$sql="INSERT INTO ingreso(concepto,fecha,monto,id_categoria,observacion)
			  VALUES('Mensualidad Alumna','$fecha_pago',$monto,8,'$observacion')";

		$consulta=mysqli_query($conexion2,$sql);*/


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

	/*echo "<option value='0'>Seleccione</option>";
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
	return $seleccionado;*/


	$sql = "SELECT INS.id_grupo as id_grupo, GRUP.grupo as descripcion
			FROM inscripcion INS JOIN grupo GRUP ON INS.id_grupo = GRUP.id_grupo
			WHERE id_alumna = $id_alumna AND INS.eliminada=0 ";

	$consulta=mysqli_query($conexion, $sql);



	echo "<ul>";
	while($fila=mysqli_fetch_assoc($consulta)){

		echo "
		
		<li>
		
			<a style='cursor:pointer' onClick=
			
			window.open('generar_comprobante.php?id_alumna=".$id_alumna."&id_grupo=".$fila['id_grupo']."','Comprobante','width=400,height=800')

			>
			".$fila['descripcion']."


			</a>	
		
		</li>

		";

	}

	echo "</ul>";



}


function listarActividades($conexion, $id_alumna, $option_sel=0){

	echo "<option value='0'>Seleccione</option>";
    $sql="

	SELECT INS.id_grupo as id_grupo, GRUP.grupo as descripcion
	FROM inscripcion INS JOIN grupo GRUP ON INS.id_grupo  = GRUP.id_grupo
	WHERE id_alumna = $id_alumna AND eliminada=0


    ";
	$consulta=mysqli_query($conexion, $sql);

	while($fila=mysqli_fetch_assoc($consulta)){
    	
		echo "<option value='".$fila['id_grupo']."'>".$fila['descripcion']."</option>";
	}//fin while


	


}


function generarGrupos($conexion, $sede=0, $option_sel=0){
	
	if($sede==0){
		
		$sql="SELECT grupo.*, sede.sede 
		FROM grupo INNER JOIN sede ON grupo.id_sede=sede.id_sede
		WHERE grupo.id_grupo != 0";				
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
				AND id_concepto=1
				AND esta_paga = 1
                AND anio=".date("Y")." ORDER BY mes";
                $consulta=mysqli_query($conexion, $sql);
                while($fila=mysqli_fetch_assoc($consulta)){
                $meses_pagos[$fila['mes']]=$fila['monto'];  
                }

                 echo  '<h4>'.$grupo.' / '.$sede.' <a style="cursor:pointer" onClick="eliminarActividad('.$id_grupo.','.$id_alumna.')" class="eliminarActividad">Eliminar Actividad</a></h4>';
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
echo  '<h4>Otros conceptos: '.$grupo.' / '.$sede.'</h4>';

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
			<td>'.date("d-m-Y",strtotime($fila['fecha_pago'])).'</td>
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




function actualizarFechasTabla($conexion){
						
				$sql="SELECT * FROM cuota_alumna";

				$consulta=mysqli_query($conexion, $sql);
				$i = 0 ;
                while($fila=mysqli_fetch_assoc($consulta)){
					$i++;
					$nuevaFecha = date('Y-m-d',$fila['fecha_pago']);
					

					echo $nuevaFecha;
                	

                	echo "<br>";


				
					
				}

	
}



?>
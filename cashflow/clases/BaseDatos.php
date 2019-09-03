<?php 
class BaseDatos{

	public $base='edbplata_cashflow';
	public $servidor='localhost';
	public $conexion;
	public $mysqli;


	public function __construct(){
		
		$this->conexion=mysqli_connect($this->servidor,'root','',$this->base) or die ("No se ha podido establecer conexion con la base de datos");
	

		$this->mysqli=new mysqli($this->servidor, 'root','', $this->base);

		$this->mysqli->set_charset("utf8");
	}


	public function listarCategorias($seccion){

		if($seccion=='Ingresar ingresos' ||$seccion=='Ingresar egresos' || $seccion=='ver ingresos')
		{
			$sql="SELECT *
				  FROM categoria
				  ORDER BY id ASC";



			$consulta=mysqli_query($this->conexion,$sql);


			echo "<option value=0>Seleccione una categoria </option>";

		if($seccion=='ver ingresos')
		{
			echo "<option value='todas'>TODAS</option>";
		}
			while($fila=mysqli_fetch_assoc($consulta)){

				echo "<option value=".$fila['id'].">".$fila['descripcion']."</option>";


			}
		}else if($seccion=='ingresar categorias'){

			$sql="SELECT *
				  FROM categoria
				  ORDER BY id ASC";



			$consulta=mysqli_query($this->conexion,$sql);

			while($fila=mysqli_fetch_assoc($consulta)){

				echo "
						<tr>
							<td>
								".$fila['id']."
							</td>
							<td>
								".$fila['descripcion']."
							</td>
							<td>
								<a style='cursor:pointer;' onClick='eliminarCategoria(".$fila['id'].")'>Eliminar</a>
							</td>
						</tr>
					";


			}

		}


	}

	public function insertarIngreso($concepto,$fecha,$monto,$categoria,$observacion){

		if($monto<0){
			$monto = $monto*-1;
		}


		$stmt=$this->mysqli->prepare("INSERT INTO ingreso(concepto,fecha,monto,id_categoria,observacion)
	  		  							VALUES (?,?,?,?,?)");

		$stmt->bind_param("ssdis",$concepto,$fecha,$monto,$categoria,$observacion);

		$stmt->execute();
		
		$stmt->close();



	}

	public function insertarEgreso($concepto,$fecha,$monto,$categoria,$observacion){

		if($monto<0){
			$monto = $monto*-1;
		}

		$stmt=$this->mysqli->prepare("INSERT INTO egreso(concepto,fecha,monto,id_categoria,observacion)
	  		  							VALUES (?,?,?,?,?)");

		$stmt->bind_param("ssdis",$concepto,$fecha,$monto,$categoria,$observacion);

		$stmt->execute();

		$stmt->close();


	}


	public function insertarCategoria($categoria){

		$stmt=$this->mysqli->prepare("INSERT INTO categoria(descripcion)
	  		  							VALUES (?)");

		$stmt->bind_param("s",$categoria);

		$stmt->execute();

		$stmt->close();


	}


	public function eliminarCategoria($id){

		$stmt=$this->mysqli->prepare("DELETE 
										   FROM categoria
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();


	}

	public function listarDetalle($id,$tabla){

		if($tabla=='ingreso'){

			$stmt=$this->mysqli->prepare("SELECT * 
											   FROM ingreso  ING LEFT JOIN categoria CAT ON ING.id_categoria = CAT.id
											   WHERE ING.id=(?)");

			$stmt->bind_param("i",$id);

			$stmt->execute();

			$resultado=$stmt->get_result();

			while($fila=$resultado->fetch_assoc()){

					echo
					 "
							<div class='col l6 left-align'>
								
									<h5 style='color:grey'>Concepto: </h5>
									<h5>".ucfirst($fila['concepto'])."</h5>
									<br>
									<h5 style='color:grey'>Fecha: </h5>
									<h5>".$fila['fecha']."</h5>
									<br>
									<h5 style='color:grey'>Monto: </h5>
									<h5>".$fila['monto']."</h5>
									<br>
									<h5 style='color:grey'>Categoria: </h5>
									<h5>".$fila['descripcion']."</h5>
									<br>
									
								
							</div>

							<div class='col l6 left-align scroll'>
								<h5 style='color:grey'>Observaciones: </h5>
									<p>".ucfirst($fila['observacion'])."</p>
							</div

					 ";


				

				}//while

			}else if($tabla == 'egreso'){
				$stmt=$this->mysqli->prepare("SELECT * 
											   FROM egreso EGR LEFT JOIN categoria CAT ON EGR.id_categoria = CAT.id
											   WHERE EGR.id=(?)");

			$stmt->bind_param("i",$id);

			$stmt->execute();

			$resultado=$stmt->get_result();

			while($fila=$resultado->fetch_assoc()){

					echo
					 "
							<div class='col l6 left-align'>
								
									<h5 style='color:grey'>Concepto: </h5>
									<h5>".ucfirst($fila['concepto'])."</h5>
									<br>
									<h5 style='color:grey'>Fecha: </h5>
									<h5>".$fila['fecha']."</h5>
									<br>
									<h5 style='color:grey'>Monto: </h5>
									<h5>".$fila['monto']."</h5>
									<br>
									<h5 style='color:grey'>Categoria: </h5>
									<h5>".$fila['descripcion']."</h5>
									<br>
									
								
							</div>

							<div class='col l6 left-align scroll'>
								<h5 style='color:grey'>Observaciones: </h5>
									<p>".ucfirst($fila['observacion'])."</p>
							</div

					 ";


				

				}//while



			}


	}//function


	public function calcularTotal($fecha_desde,$fecha_hasta){
/**********************TABLA INGRESOS*************************************/
		$stmt=$this->mysqli->prepare("SELECT fecha,concepto,monto
									  FROM ingreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();
            echo "<h3>INGRESOS</h3>";
			echo
			 "
			 <table>
				<tr>
					<th>
						Fecha
					</th>
					<th>
						Concepto
					</th>
					<th>
						Monto
					</th>
				</tr>";

			while($fila=$resultado->fetch_assoc()){

				echo
				 "
				<tr>
					<td>
					".$fila['fecha']."
					</td>
					<td>
					".$fila['concepto']."
					</td>
					<td>
					".$fila['monto']."
					</td>

				</tr>

				 ";


			

			}//while

			


		$stmt=$this->mysqli->prepare("SELECT SUM(monto) AS total
									  FROM ingreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$totalIngresos=$resultado->fetch_assoc();


		echo "

		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<b>TOTAL:$ ".$totalIngresos['total']."</b>
			</td>


		</tr>

		";

		echo "</table>";






/**************************TABLA EGRESOS********************************************/
		$stmt=$this->mysqli->prepare("SELECT fecha,concepto,monto
									  FROM egreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();
            echo "<h3>EGRESOS</h3>";
			echo
			 "
			 <table>
				<tr>
					<th>
						Fecha
					</th>
					<th>
						Concepto
					</th>
					<th>
						Monto
					</th>
				</tr>";

			while($fila=$resultado->fetch_assoc()){

				echo
				 "
				<tr>
					<td>
					".$fila['fecha']."
					</td>
					<td>
					".$fila['concepto']."
					</td>
					<td>
					".$fila['monto']."
					</td>

				</tr>

				 ";
			}//while


		$stmt=$this->mysqli->prepare("SELECT SUM(monto) AS total
									  FROM egreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$totalEgresos=$resultado->fetch_assoc();


		echo "

		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<b>TOTAL: $-".$totalEgresos['total']."</b>
			</td>


		</tr>

		";

		echo "</table>";

		echo "<br>";
		$total = 0;
		$total = $totalIngresos['total']-$totalEgresos['total'];
		echo "<div class='row'style='padding-bottom:5%'>"; 
		echo "<h1>Total Diferencial : ".$total."</h1>";
		echo "<button class='waves-effect waves-light btn' target='_blank'>Exportar informe pdf</button>";

		echo
		 "
		 	<a class='waves-effect waves-light btn' href='exportarInformeXLS.php?fd=".$fecha_desde."&fh=".$fecha_hasta."' target='_blank'>Exportar informe a .xls</A>";
        echo "</div>";


		$stmt->close();

	}//function


	public function listarIngresos(){

		$sql="SELECT id,concepto,fecha,monto,observacion
			  FROM ingreso";



		$consulta=mysqli_query($this->conexion,$sql);
		$observacion='';
		while($fila=mysqli_fetch_assoc($consulta)){

			if(strlen($fila['observacion'])<=50)
			  {
			    $observacion= $fila['observacion'];
			  }
			  else
			  {
			    $observacion='<a href="verDetalleIngreso.php?id='.$fila['id'].'" target="_blank">'.substr($fila['observacion'],0,50) . '...</a>';
			  }

			echo "<tr>
					  <td>
						".$fila['id']."
					  </td>
					  <td>
						".$fila['concepto']."
					  </td>
					  <td>
						".$observacion."
					  </td>
					  <td>
						".date("d/m/Y", strtotime($fila['fecha']))."
					  </td>
					  <td>
					  	".$fila['monto']."
					  </td>
					  <td>
						<a href='actualizarIngreso.php?id=".$fila['id']."'>Actualizar</a>
					  </td>
					  <td>
						<a  style='cursor:pointer;' onClick='eliminarIngreso(".$fila['id'].");'>Eliminar</a>
					  </td>
				  </tr>";


		}

	}

	public function listarIngresosPorRangoDeFecha($fechaDesde,$fechaHasta){

		$stmt=$this->mysqli->prepare("SELECT id,concepto,fecha,monto,observacion
										  FROM ingreso
										  WHERE fecha BETWEEN (?) AND (?)");

		$stmt->bind_param("ss",$fechaDesde,$fechaHasta);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$observacion='';

		while($fila=$resultado->fetch_assoc()){

			if(strlen($fila['observacion'])<=50)
			  {
			    echo $fila['observacion'];
			  }
			  else
			  {
			    $observacion='<a href="verDetalleIngreso.php?id='.$fila['id'].'" target="_blank">'.substr($fila['observacion'],0,50) . '...</a>';
			  }

			echo "<tr>
					  <td>
						".$fila['id']."
					  </td>
					  <td>
						".$fila['concepto']."
					  </td>
					  <td>
						".$observacion."
					  </td>
					  <td>
						".date("d/m/Y", strtotime($fila['fecha']))."
					  </td>
					  <td>
					  	".$fila['monto']."
					  </td>
					  <td>
						<a href='actualizarIngreso.php?id=".$fila['id']."'>Actualizar</a>
					  </td>
					  <td>
						<a  style='cursor:pointer;' onClick='eliminarIngreso(".$fila['id'].");'>Eliminar</a>
					  </td>
				  </tr>";


		}

	}//function

		public function listarEgresosPorRangoDeFecha($fechaDesde,$fechaHasta){

		$stmt=$this->mysqli->prepare("SELECT id,concepto,fecha,monto,observacion
										  FROM egreso
										  WHERE fecha BETWEEN (?) AND (?)");

		$stmt->bind_param("ss",$fechaDesde,$fechaHasta);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$observacion='';

		while($fila=$resultado->fetch_assoc()){

			if(strlen($fila['observacion'])<=50)
			  {
			    echo $fila['observacion'];
			  }
			  else
			  {
			    $observacion='<a href="verDetalleEgreso.php?id='.$fila['id'].'" target="_blank">'.substr($fila['observacion'],0,50) . '...</a>';
			  }

			echo "<tr>
					  <td>
						".$fila['id']."
					  </td>
					  <td>
						".$fila['concepto']."
					  </td>
					  <td>
						".$observacion."
					  </td>
					  <td>
						".date("d/m/Y", strtotime($fila['fecha']))."
					  </td>
					  <td>
					  	".$fila['monto']."
					  </td>
					  <td>
						<a href='actualizarEgreso.php?id=".$fila['id']."'>Actualizar</a>
					  </td>
					  <td>
						<a  style='cursor:pointer;' onClick='eliminarEgreso(".$fila['id'].");'>Eliminar</a>
					  </td>
				  </tr>";


		}

	}//function

		public function listarIngresosPorCategoria($categoria){

		$stmt=$this->mysqli->prepare("SELECT id,concepto,fecha,monto,observacion
										  FROM ingreso 
										  WHERE id_categoria=(?)");

		$stmt->bind_param("i",$categoria);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$observacion='';

		while($fila=$resultado->fetch_assoc()){

			if(strlen($fila['observacion'])<=50)
			  {
			    echo $fila['observacion'];
			  }
			  else
			  {
			    $observacion='<a href="verDetalleIngreso.php?id='.$fila['id'].'" target="_blank">'.substr($fila['observacion'],0,50) . '...</a>';
			  }

			echo "<tr>
					  <td>
						".$fila['id']."
					  </td>
					  <td>
						".$fila['concepto']."
					  </td>
					  <td>
						".$observacion."
					  </td>
					  <td>
						".date("d/m/Y", strtotime($fila['fecha']))."
					  </td>
					  <td>
					  	".$fila['monto']."
					  </td>
					  <td>
						<a href='actualizarIngreso.php?id=".$fila['id']."'>Actualizar</a>
					  </td>
					  <td>
						<a  style='cursor:pointer;' onClick='eliminarIngreso(".$fila['id'].");'>Eliminar</a>
					  </td>
				  </tr>";


		}

	}//function


			public function listarEgresosPorCategoria($categoria){

		$stmt=$this->mysqli->prepare("SELECT id,concepto,fecha,monto,observacion
										  FROM egreso 
										  WHERE id_categoria=(?)");

		$stmt->bind_param("i",$categoria);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$observacion='';

		while($fila=$resultado->fetch_assoc()){

			if(strlen($fila['observacion'])<=50)
			  {
			    echo $fila['observacion'];
			  }
			  else
			  {
			    $observacion='<a href="verDetalleEgreso.php?id='.$fila['id'].'" target="_blank">'.substr($fila['observacion'],0,50) . '...</a>';
			  }

			echo "<tr>
					  <td>
						".$fila['id']."
					  </td>
					  <td>
						".$fila['concepto']."
					  </td>
					  <td>
						".$observacion."
					  </td>
					  <td>
						".date("d/m/Y", strtotime($fila['fecha']))."
					  </td>
					  <td>
					  	".$fila['monto']."
					  </td>
					  <td>
						<a href='actualizarEgreso.php?id=".$fila['id']."'>Actualizar</a>
					  </td>
					  <td>
						<a  style='cursor:pointer;' onClick='eliminarEgreso(".$fila['id'].");'>Eliminar</a>
					  </td>
				  </tr>";


		}

	}//function

	public function listarEgresos(){

		$sql="SELECT id,concepto,fecha,monto,observacion
			  FROM egreso";



		$consulta=mysqli_query($this->conexion,$sql);

		$observacion='';

		while($fila=mysqli_fetch_assoc($consulta)){

			if(strlen($fila['observacion'])<=50)
			  {
			    $observacion =  $fila['observacion'];
			  }
			  else
			  {
			    $observacion='<a href="verDetalleEgreso.php?id='.$fila['id'].'" target="_blank">'.substr($fila['observacion'],0,50) . '...</a>';
			  }

			echo "<tr>
					  <td>
						".$fila['id']."
					  </td>
					  <td>
						".$fila['concepto']."
					  </td>
					   <td>
						".$observacion."
					  </td>
					  <td>
						".date("d/m/Y", strtotime($fila['fecha']))."
					  </td>
					  <td>
					  	".$fila['monto']."
					  </td>
					  <td>
						<a href='actualizarEgreso.php?id=".$fila['id']."'>Actualizar</a>
					  </td>
					  <td>
						<a  style='cursor:pointer;' onClick='eliminarEgreso(".$fila['id'].");'>Eliminar</a>
					  </td>
				  </tr>";


		}

	}

	public function actualizarIngreso($concepto,$fecha,$monto,$id,$categoria){

		try{
			$stmt=$this->mysqli->prepare("UPDATE ingreso 
										   SET concepto=(?),fecha=(?),monto=(?),id_categoria=(?)
										   WHERE id=(?)");

			$stmt->bind_param("ssdii",$concepto,$fecha,$monto,$categoria,$id);

			$stmt->execute();

			echo "<h1>Enhorabuena!</h1><br>
					<h2>Se ha actualizado el ingreso correctamente</h2><br>
					<a href='../listarIngresos.php'>Volver a ingresos</a>
					<a href='../index.php'>Volver a home</a>";

		}catch(Exception $e){
			echo "¡Ups! Ha ocurrido un error, intentelo nuevamente";

		}

	}

	public function actualizarEgreso($concepto,$fecha,$monto,$id,$categoria){


		try{
			$stmt=$this->mysqli->prepare("UPDATE egreso 
										   SET concepto=(?),fecha=(?),monto=(?),id_categoria=(?)
										   WHERE id=(?)");

			$stmt->bind_param("ssdii",$concepto,$fecha,$monto,$categoria,$id);

			$stmt->execute();

			echo "<h1>Enhorabuena!</h1><br>
					<h2>Se ha actualizado el egreso correctamente</h2><br>
					<a href='../listarEgresos.php'>Volver a egresos</a>
					<a href='../home.php'>Volver a home</a>";

		}catch(Exception $e){

			echo "¡Ups! Ha ocurrido un error, intentelo nuevamente";

		}


	}//function


	public function eliminarIngreso($id){


		$stmt=$this->mysqli->prepare("DELETE 
										   FROM ingreso
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

	}


	public function eliminarEgreso($id){

		$stmt=$this->mysqli->prepare("DELETE 
									   FROM egreso
									   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();


	}


	public function listarConcepto($id,$tabla){

		$stmt=$this->mysqli->prepare("SELECT concepto
									  FROM $tabla
									  WHERE id=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();


		echo  $fila['concepto'];


	}

	public function listarMonto($id,$tabla){

		$stmt=$this->mysqli->prepare("SELECT monto
									  FROM $tabla
									  WHERE id=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();


		echo  $fila['monto'];


	}

	public function listarFecha($id,$tabla){

		$stmt=$this->mysqli->prepare("SELECT fecha
									  FROM $tabla
									  WHERE id=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		$stmt->close();


		echo  $fila['fecha'];


	}


	public function listarCategoria($id,$tabla){

		$stmt=$this->mysqli->prepare("SELECT TAB.id_categoria AS id_categoria, CAT.descripcion as descripcion
									  FROM $tabla TAB JOIN categoria CAT ON TAB.id_categoria=CAT.id
									  WHERE TAB.id=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();


		echo
		 "
 			<option value='0'>seleccione una categoria</option>
		";

		while($fila=$resultado->fetch_assoc()){

			echo "
				<option value='".$fila['id_categoria']."'selected>".$fila['descripcion']."</option>";
		}

		//vuelvo a buscar categoria
		$stmt=$this->mysqli->prepare("SELECT TAB.id_categoria AS id_categoria, CAT.descripcion as descripcion
									  FROM $tabla TAB JOIN categoria CAT ON TAB.id_categoria=CAT.id
									  WHERE TAB.id=(?)");
		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		//listo todas las categorias menos la del ingreso/egreso
		$stmt=$this->mysqli->prepare("SELECT *
									  FROM  categoria
									  WHERE id!=(?)");

		$stmt->bind_param("i",$fila['id_categoria']);

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila2=$resultado->fetch_assoc()){

			echo "
				<option value=".$fila2['id'].">".$fila2['descripcion']."</option>";
		}


		$stmt->close();




	}//function


	public function eliminarIngresoPorRangoDeFecha($fechaDesde,$fechaHasta){
		try{
			$stmt=$this->mysqli->prepare("DELETE 
										  FROM ingreso
										  WHERE fecha BETWEEN (?) AND (?)");

			$stmt->bind_param("ss",$fechaDesde,$fechaHasta);

			$stmt->execute();

		}catch(exception $e){

		}


	}//function



	public function eliminarEgresoPorRangoDeFecha($fechaDesde,$fechaHasta){
		try{
			$stmt=$this->mysqli->prepare("DELETE 
										  FROM egreso
										  WHERE fecha BETWEEN (?) AND (?)");

			$stmt->bind_param("ss",$fechaDesde,$fechaHasta);

			$stmt->execute();

		}catch(exception $e){

		}


	}//function



	public function buscarIngresos($busqueda){


	$bus="%".$_POST['busqueda']."%";
	
	$stmt=$this->mysqli->prepare("SELECT *
									  FROM  ingreso
									  WHERE concepto LIKE (?)");

	$stmt->bind_param("s",$bus);

	$stmt->execute();

	$resultado=$stmt->get_result();

	
	echo "<ul>";

	while($fila=$resultado->fetch_assoc()){
		
		echo "<li><a href='verDetalleIngreso.php?id=".$fila['id']."'>".$fila['concepto']." - Fecha : ".$fila['fecha']."</a></li>";	
	}
	
	echo "</ul>";



	}

	public function buscarEgresos($busqueda){


	$bus="%".$_POST['busqueda']."%";
	
	$stmt=$this->mysqli->prepare("SELECT *
									  FROM  egreso
									  WHERE concepto LIKE (?)");

		$stmt->bind_param("s",$bus);

		$stmt->execute();

		$resultado=$stmt->get_result();

	
	echo "<ul>";

		while($fila=$resultado->fetch_assoc()){
		
		echo "<li><a href='verDetalleEgreso.php?id=".$fila['id']."'>".$fila['concepto']." - Fecha : ".$fila['fecha']."</a></li>";	
		}
	
	echo "</ul>";



	}

	public function exportarInformes($fechaDesde,$fechaHasta){


			$pdf = new FPDF();
			/****************************INGRESOS*///////////////////////
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);

			$texto='INGRESOS';

			$pdf->Cell(40,10, $texto,0,1);


			$sql="SELECT SUM(monto) AS total
				  FROM ingreso
				  WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta'";


			$consulta=mysqli_query($this->conexion, $sql);
			$fila=mysqli_fetch_assoc($consulta);
			
			
			$ingresoTotal=$fila['total'];
			

			$texto="Entre ".$fechaDesde."  y ".$fechaHasta." el ingreso total fue de : $".$fila['total'];	

			$pdf->Cell(40,10, $texto,0,1);
			$pdf->SetFont('Arial','',10);

			$sql=
				"SELECT concepto,monto,fecha
				 FROM ingreso
				 where fecha BETWEEN '$fechaDesde' AND '$fechaHasta'";
		
	

			$consulta=mysqli_query($this->conexion, $sql);

			while($fila=mysqli_fetch_assoc($consulta)){
				
				$texto='Fecha pago: '.$fila['fecha'].' | Concepto: '.$fila['concepto'].' | - $ '.$fila['monto'].'';
				
				$pdf->Cell(0,4, $texto,0,1);
				
			}


			/********************************EGRESOS*///////////////////////

			//$pdf->AddPage();
			$pdf->SetFont('Arial','B',16);

			$texto='EGRESOS';

			$pdf->Cell(40,10, $texto,0,1);

			$sql="SELECT SUM(monto) AS total
				  FROM egreso
				  WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta'";

			

			$consulta=mysqli_query($this->conexion, $sql);
			$fila=mysqli_fetch_assoc($consulta);
			
			$texto="Entre ".$fechaDesde."  y ".$fechaHasta." el egreso total fue de : $ - ".$fila['total'];	

			$egresoTotal=$fila['total'];

			$pdf->Cell(40,10, $texto,0,1);
			$pdf->SetFont('Arial','',10);

			$sql=
				"SELECT concepto,monto,fecha
				 FROM egreso
				 where fecha BETWEEN '$fechaDesde' AND '$fechaHasta'";
		
	

			$consulta=mysqli_query($this->conexion, $sql);

			while($fila=mysqli_fetch_assoc($consulta)){
				
				$texto='Fecha pago: '.$fila['fecha'].' | Concepto: '.$fila['concepto'].' | - $ - '.$fila['monto'].'';
				
				$pdf->Cell(0,4, $texto,0,1);
				
			}
			

			/****************TOTAL DIFERENCIAL***************************/

			$pdf->SetFont('Arial','B',16);


			$totalDif=$ingresoTotal-$egresoTotal;

			$texto="TOTAL DIFERENCIAL:".$totalDif."";

			$pdf->Cell(40,10, $texto,0,1);
	
			$pdf->Output();


	}//function


	public function exportarInformeXLS($fecha_desde,$fecha_hasta){

		$stmt=$this->mysqli->prepare("SELECT fecha,concepto,monto
									  FROM ingreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();

			echo
			 "
			 <table>
			 <tr><th>INGRESOS</th></tr>
				<tr>
					<th>
						Fecha
					</th>
					<th>
						Concepto
					</th>
					<th>
						Monto
					</th>
				</tr>";

			while($fila=$resultado->fetch_assoc()){

				echo
				 "
				<tr>
					<td>
					".$fila['fecha']."
					</td>
					<td>
					".$fila['concepto']."
					</td>
					<td>
					".$fila['monto']."
					</td>

				</tr>

				 ";


			

			}//while

			


		$stmt=$this->mysqli->prepare("SELECT SUM(monto) AS total
									  FROM ingreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$totalIngresos=$resultado->fetch_assoc();


		echo "

		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<b>TOTAL: ".$totalIngresos['total']."</b>
			</td>


		</tr>

		";

		echo "</table>";






/**************************TABLA EGRESOS********************************************/
		$stmt=$this->mysqli->prepare("SELECT fecha,concepto,monto
									  FROM egreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();

			echo
			 "
			 <table>
			 <tr><th>EGRESOS</th></tr>
				<tr>
					<th>
						Fecha
					</th>
					<th>
						Concepto
					</th>
					<th>
						Monto
					</th>
				</tr>";

			while($fila=$resultado->fetch_assoc()){

				echo
				 "
				<tr>
					<td>
					".$fila['fecha']."
					</td>
					<td>
					".$fila['concepto']."
					</td>
					<td>
					".$fila['monto']."
					</td>

				</tr>

				 ";
			}//while


		$stmt=$this->mysqli->prepare("SELECT SUM(monto) AS total
									  FROM egreso
									  WHERE fecha BETWEEN (?) AND (?)");
		$stmt->bind_param("ss",$fecha_desde,$fecha_hasta);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$totalEgresos=$resultado->fetch_assoc();


		echo "

		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<b>TOTAL: ".$totalEgresos['total']."</b>
			</td>


		</tr>

		";

		echo "</table>";

		echo "<br>";
		$total = 0;
		$total = $totalIngresos['total']-$totalEgresos['total'];
		echo "<h1>Total Diferencial : ".$total."</h1>";

	}


	public function calcularCaja(){

		$stmt=$this->mysqli->prepare("SELECT SUM(monto) as ingresos
										  FROM  ingreso");


		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaIngresos=$resultado->fetch_assoc();




		$stmt=$this->mysqli->prepare("SELECT SUM(monto) as egresos
										  FROM  egreso");


		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaEgresos=$resultado->fetch_assoc();








		$total = $filaIngresos['ingresos'] - $filaEgresos['egresos'];
		


		echo round($total,2);	
		


	}//function






}//class


 ?>
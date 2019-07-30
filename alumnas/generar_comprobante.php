<?php
include("../includes/verificarSesion.php");

require_once("inc/conexion.php");
require_once("inc/funciones.php");

/********LISTAR MESES COMPROBANTES *********/

$sqlMeses = "
	SELECT mes,anio
	FROM cuota_alumna
	WHERE id_alumna = ".$_GET['id_alumna']." AND id_grupo = ".$_GET['id_grupo']." AND esta_paga = 0 AND id_concepto = 1
	ORDER BY  id_cuota ASC
	
";


$sqlContarMeses = "
	
	SELECT COUNT(*) as total
	FROM cuota_alumna
	WHERE id_alumna = ".$_GET['id_alumna']." AND id_grupo = ".$_GET['id_grupo']." AND esta_paga = 1 AND id_concepto = 1
	ORDER BY  id_cuota ASC

";


$sqlUltimoAnio  ="SELECT * FROM cuota_alumna WHERE id_alumna = ".$_GET['id_alumna']." AND id_grupo = ".$_GET['id_grupo']." AND esta_paga = 1 AND id_concepto = 1 ORDER BY id_cuota DESC LIMIT 1";


/**NO BORRAR !!! **********************************/

$consultaContarMeses  = mysqli_query($conexion, $sqlContarMeses); 

$consultaMeses = mysqli_query($conexion, $sqlMeses);

$consultaMeses2 = mysqli_query($conexion, $sqlMeses);

$consultaUltimoAnio = mysqli_query($conexion,$sqlUltimoAnio);
/*************************************************/




/****BUSCAR EXISTENCIAS DE GRUPO*****/
$id_grupo = $_GET['id_grupo'];

$sqlGrupo = "SELECT grupo 
			 FROM grupo
			 WHERE id_grupo = $id_grupo";


$consultaGrupo = mysqli_query($conexion, $sqlGrupo);

$filaGrupo=mysqli_fetch_assoc($consultaGrupo); 




$sql="SELECT * FROM alumna WHERE id_alumna=".$_GET['id_alumna'];
$consulta=mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($consulta);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if($_POST['id_concepto'] == "2" OR $_POST['id_concepto'] == "3" ){
		if(isset($_POST['deuda'])){
			$_POST['monto'] = 0.00;
		}
	}

	if(isset($_POST['deuda'])){
		$deuda = $_POST['deuda'];
	}else{
		$deuda = "paga";
	}


	$fechaComprobante = explode("/",$_POST['comprobante']);

	$mes = $fechaComprobante[0];
	$anio = $fechaComprobante[1];


	$conexion2= 0 ;
	
	$id_cuota=generarComprobante($conexion,$conexion2, $_POST['id_alumna'], $mes, $anio, $_POST['monto'], $_POST['id_concepto'], $_POST['actividad'], $_POST['fecha_pago'], $deuda );

	/*echo $id_cuota;
	echo "<br>";
	echo  $_POST['id_alumna'];
	echo "<br>";
	echo $_POST['monto'];
	echo "<br>";
	echo $_POST['id_concepto'];
	echo "<br>";
	echo $_POST['actividad'];
	echo "<br>";
	echo $_POST['fecha_pago'];
	echo "<br>";
	echo $deuda;*/


	
	if(isset($_POST['enviar']) && $_POST['email']!=""){
	
					$destinatario=$_POST['email'];
					$cabeceras="MIME-Version: 1.0\r\n";
					$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$cabeceras .="From: info@decilo.com.ar\r\n";
					$cabeceras.="Reply-To: {$_POST['email']}\r\n";
					$asunto="DECILO ALUMNAS || Comprobante de pago";
					$cuerpo='

					<html>

					<head></head>

					<body>

					Puede Imprimir su comprobante desde el siguiente link:<a href="http://www.edbplataforma.com.ar/alumnas/imprimir_comprobante.php?id_cuota='.$id_cuota.'">    
				   link/alumnas/imprimir_comprobante.php?id_cuota='.$id_cuota.'</a>
					
					</body>

				   </html>
					';
				
				 
				
				   
					
					//ini_set(sendmail_from,'info@danwor.com');
						 if(mail($destinatario, $asunto, $cuerpo,$cabeceras)){
							$mensaje= '¡Muchas gracias por contactarnos!<br />El mensaje fue enviado con éxito';	 
						 }else{
							$mensaje= 'El mensaje no pudo ser enviado, intente nuevamente más tarde';
						 } 
						 
	}//fin isset enviar
	if($deuda!="deuda"){
		echo "<script>document.location.href='imprimir_comprobante.php?id_cuota=".$id_cuota."'</script>";	
	}else{
		echo "<script>alert('Deuda generada ' ) </script>";
	}
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Comprobante</title>
<link rel="stylesheet" href="../estilos/estilos.css">
<!--  <link rel="stylesheet" href="../materialize/css/materialize.min.css">-->
</head>

<body class="genComprobante">
  <div class="container">
<h1>Alumna: <?php echo $fila['nombre']; ?></h1>
<h1>GRUPO : <?php echo $filaGrupo['grupo'] ?></h1>
<form method="post">
	<label>Fecha de pago</label><br>
    <input type="date" name="fecha_pago" value="<?php echo date("Y-m-d") ?>" /><br>
    <div id="comprobante-cont">
	    <label>Comprobante</label><br>
	    <?php 

	    	$filaUltimoAnio = mysqli_fetch_assoc($consultaUltimoAnio);


	     ?>
	    <select name="comprobante" id="comprobante">
	    	<?php

	    	$filaMeses2=mysqli_fetch_assoc($consultaMeses2);

	    	$totalMeses=mysqli_fetch_assoc($consultaContarMeses);


	    	if($filaMeses2['mes']  ){


				while($filaMeses=mysqli_fetch_assoc($consultaMeses)){

					echo "<option value=".$filaMeses['mes']."/".$filaMeses['anio'].">".$filaMeses['mes']." / ".$filaMeses['anio']." </option>";



				}

			}else{

				//si tiene doce meses pagos
				$y = 1;
				if($totalMeses['total']==13){

					$anioActual = date('Y') +1;

					if($filaUltimoAnio['mes']==12){
						//$anioActual += 1;
					}

						
						//se crearan doce registros mas, a partir del ultimo pagado
						for($i=$filaUltimoAnio['mes']+1; $i<=12; $i++){

							$y++;
								if($i==date("n")){
									echo '<option selected value="'.$i.' / '.$anioActual.'">'.$i.'/ '.$anioActual.'</option>';	
								}else{
									echo '<option value="'.$i.' / '.$anioActual.'">'.$i.'/ '.$anioActual.'</option>';	
								}


						}
						//una vez que se llegue a diciembre se crearan contemplando el mismo orden pero con un año
						//adelantado.
						if($y!=12){

							for($i=1; $i<=$y+2; $i++){

								if($i==date("n")){
									echo '<option selected value="'.$i.' / '.((int)$anioActual + 1).'">'.$i.'/ '.((int)$anioActual + 1).'</option>';	
								}else{
									echo '<option value="'.$i.' / '.((int)$anioActual + 1).'">'.$i.'/ '.((int)$anioActual + 1).'</option>';	
								}


						}//sino se mostraran doce meses correspondientes al año actual	
						}else{
							for($i=1; $i<=12; $i++){
							if($i==date("n")){
								echo '<option selected value="'.$i.' / '.date('Y').'">'.$i.'/ '.date(Y).'</option>';	
							}else{
								echo '<option value="'.$i.' / '.date('Y').'">'.$i.'/ '.date(Y).'</option>';	
							}

						}
							
						}

					}else{

						for($i=1; $i<=12; $i++){
							if($i==date("n")){
								echo '<option selected value="'.$i.' / '.date('Y').'">'.$i.'/ '.date(Y).'</option>';	
							}else{
								echo '<option value="'.$i.' / '.date('Y').'">'.$i.'/ '.date(Y).'</option>';	
							}

						}
												
					}

				}


				
			
			
			?>
	    </select>
    </div><br>
    <!--  <label>Año</label><br>
    <input type="text" name="anio" value="<?php echo date("Y"); ?>" /><br />-->
    
      <label>Sede</label><br>
        <select name="id_sede" id="id_sede" onChange="recargarGrupos()">
        	
        	<?php generarSedes($conexion); ?>
        </select>
         <br />


         <input type="hidden" name="actividad" id="actividad" value="<?php echo $id_grupo ?>">
          



   <label>Concepto</label><br/>
   <select name="id_concepto" id="id_concepto">
   	<?php generarConceptos($conexion); ?>
   </select><br/>

	<label for=""></label>



   <div id="deuda-cont" style="display:none;">
   	<input type="checkbox" name="deuda" id="deuda-check" value="deuda" > ¿Generar deuda ? 
   </div>
    <label>Monto</label><br>
    <input type="number" id="monto" name="monto" min="1" placeholder="$0.00" step="any" />
    <br>

    <input type="hidden" name="id_alumna" value="<?php echo $fila['id_alumna'] ?>" /><br />

    <label for="enviar">Enviar por e-mail a:</label>
    <input type="checkbox" value="si" name="enviar" />
    <br />
    <input type="text" name="email" value="<?php echo $fila['mail']; ?>" /><br>
    <p style="font-size:10px">Ingrese multiples direcciones anteponiendo la coma, por ejemplo: info@decilo.com.ar,mailen@gmail.com</p>
    <button class="waves-effect waves-light btn">CONFIRMAR</button>
</form>
</div>
<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<!--  <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>-->
<script>
   $(document).ready(function(){
    $('select').formSelect();
  });

   $("#id_concepto").change(function(){

   		var concepto = $("#id_concepto").val();

   		if(concepto==2 || concepto==3 || concepto==4 ){
   			$("#deuda-cont").show();
   			$("#comprobante-cont").hide();
   		}else{
   			$("#deuda-cont").hide();
   			$("#comprobante-cont").show();
   		}

   });

   $('#deuda-check').change(function() {
        if($(this).is(":checked")) {
            $("#monto").prop('disabled',true);
        }else{
        	$("#monto").prop('disabled',false);
        }
    });


</script>
</body>
</html>
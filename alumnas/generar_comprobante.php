<?php
include("../includes/verificarSesion.php");

require_once("inc/conexion.php");
require_once("inc/funciones.php");

$sql="SELECT * FROM alumna WHERE id_alumna=".$_GET['id_alumna'];
$consulta=mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($consulta);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$id_cuota=generarComprobante($conexion,$conexion2, $_POST['id_alumna'], $_POST['mes'], $_POST['anio'], $_POST['monto'], $_POST['id_concepto'], $_POST['actividad'], $_POST['fecha_pago'], $_POST['deuda'] );

	echo $id_cuota;
	echo "<br>";
	echo  $_POST['id_alumna'];
	echo "<br>";
	echo $_POST['mes'];
	echo "<br>";
	echo $_POST['anio'];
	echo "<br>";
	echo $_POST['monto'];
	echo "<br>";
	echo $_POST['id_concepto'];
	echo "<br>";
	echo $_POST['actividad'];
	echo "<br>";
	echo $_POST['fecha_pago'];
	echo "<br>";
	echo $_POST['deuda'];


	
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
	if($_POST['deuda']!="deuda"){
		echo "<script>document.location.href='imprimir_comprobante.php?id_cuota=".$id_cuota."'</script>";	
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
<form method="post">
	<label>Fecha de pago</label><br>
    <input type="date" name="fecha_pago" value="<?php echo date("Y-m-d") ?>" /><br>
    <label>Mes</label><br>
    <select name="mes">
    	<?php
		for($i=1; $i<=12; $i++){
			if($i==date("n")){
				echo '<option selected value="'.$i.'">'.$meses_nombre[$i].'</option>';	
			}else{
				echo '<option value="'.$i.'">'.$meses_nombre[$i].'</option>';	
			}
		}
		?>
    </select><br>
    <label>Año</label><br>
    <input type="text" name="anio" value="<?php echo date("Y"); ?>" /><br />
    
      <label>Sede</label><br>
        <select name="id_sede" id="id_sede" onChange="recargarGrupos()">
        	
        	<?php generarSedes($conexion); ?>
        </select>
         <br />
         <label>Actividad</label><br>
          <select name="actividad" id="actividad">
    
          <?php generarGrupos($conexion); ?>
    
          </select><br>



   <label>Concepto</label><br/>
   <select name="id_concepto" id="id_concepto">
   	<?php generarConceptos($conexion); ?>
   </select><br/>
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

   		if(concepto==2 || concepto==3){
   			$("#deuda-cont").show();
   		}else{
   			$("#deuda-cont").hide();
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
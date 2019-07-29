<?php 
include("../includes/verificarSesion.php");
require_once("inc/conexion.php");
require_once("inc/funciones.php");

$sql="SELECT * FROM alumna WHERE id_alumna=".$_GET['id_alumna'];
$consulta=mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($consulta);



if($_SERVER['REQUEST_METHOD'] == 'POST'){
 	
 	$monto = $_POST['monto'];

 	$id_cuota = $_GET['id_cuota'];

 	$fecha_pago = $_POST['fecha_pago'];

	$sql  = "UPDATE cuota_alumna
			SET adeuda = 0, esta_paga = 1, monto = $monto,fecha_pago = '$fecha_pago' 
			WHERE id_cuota = $id_cuota 
			";

	$consulta_grupos=mysqli_query($conexion, $sql);

	echo "<script>opener.document.location.href='listado_deudores.php';</script>";
	echo "<script>alert('Deuda cancelada')</script>";

  



	echo "<script>window.close();</script>";

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
  	<h1>Pagar deuda de:</h1>
	<h1>Alumna: <?php echo $fila['nombre']; ?></h1>
<form method="post" id="inscripcion">
	<label>Fecha</label><br>
	<input type="date" name="fecha_pago" value="<?php echo date("Y-m-d") ?>" /><br>
    <label>Monto</label><br>
     <input type="number" id="monto" name="monto" min="1" placeholder="$0.00" step="any" />
    	
 <button style="cursor:pointer" class="waves-effect waves-light btn">CONFIRMAR</button>
   
</form>
 





</div>
<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<!--  <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>-->
<script>
	
   $(document).ready(function(){
    $('select').formSelect();
  });

 
</script>
</body>
</html>
<?php
require_once("inc/conexion.php");
require_once("inc/funciones.php");

$sql="SELECT cuota_alumna.*, alumna.nombre, alumna.mail, grupo.grupo
FROM cuota_alumna INNER JOIN alumna ON cuota_alumna.id_alumna = alumna.id_alumna
INNER JOIN grupo ON grupo.id_grupo=cuota_alumna.id_grupo
WHERE cuota_alumna.id_cuota=".$_GET['id_cuota'];
$consulta=mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($consulta);

	
?>

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  <link rel="stylesheet" href="../estilos/fuentes.css">
  <link rel="stylesheet" href="../estilos/estilos.css">
	
	<title> -.- </title>

</head>
<body id="imprimir" style="text-align:left !important;">


	<div style="width:19cm;">
  <h1 style="font-family:bebas; font-size: 40pt;">DECILO</h1>

  <br><br>


    <h4>Alumna: <?php echo $fila['nombre'] ?></h4><br />
    <h4>Mail:  <?php echo $fila['mail'] ?></h4><br />
    <h4>Fecha pago: <?php echo date("d-m-Y", strtotime($fila['fecha_pago'])) ?></h4>  <br />
    <h4>Mes: <?php echo $fila['mes'] ?>/ A&#241;o: <?php echo $fila['anio'] ?></h4> <br />
    <h4>Grupo: <?php echo $fila['grupo'] ?></h4><br />
    <h4>Monto: $<?php echo $fila['monto'] ?></h4><br />
    <br />
    <br />
    <h4>Firma:...............................................</h4>
    <br />
    <br />
    <h4>Aclaraci&#243;n:..........................................</h4>
    
    
    
      
     
    </div> 
   <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>  
  <script>
   $( document ).ready(function() {
    window.print();
	opener.document.location.href='index.php?id_alumna=<?php echo $fila['id_alumna'];  ?>&id_grupo=<?php echo $fila['id_grupo'];  ?>';
	});
	
  </script>
	</body>
</html>
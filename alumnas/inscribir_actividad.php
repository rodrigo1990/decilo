<?php 

include("../includes/verificarSesion.php");

require_once("inc/conexion.php");
require_once("inc/funciones.php");
$sql="SELECT * FROM alumna WHERE id_alumna=".$_GET['id_alumna'];
$consulta=mysqli_query($conexion, $sql);
$fila=mysqli_fetch_assoc($consulta);


$sql="SELECT * FROM grupo WHERE id_grupo != 0 ";
$consulta_grupos=mysqli_query($conexion, $sql);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
 


  $sql = "SELECT *
          FROM inscripcion
          WHERE id_alumna = ".$_GET['id_alumna']." AND id_grupo = ".$_POST['grupo']." AND eliminada = 1";

$consulta_grupos=mysqli_query($conexion, $sql);


$fila=mysqli_fetch_assoc($consulta_grupos);


if($fila['id']==null){

  $sql  = "INSERT INTO inscripcion(id_alumna,id_grupo)
      VALUES(".$_GET['id_alumna'].",".$_POST['grupo'].");
      ";

  $consulta_grupos=mysqli_query($conexion, $sql);



  echo "<script>alert('Inscripcion realizada')</script>";

  echo "<script>window.close();</script>";

}else{
  
  $sql = "UPDATE inscripcion
          SET eliminada=0
          WHERE id_alumna = ".$_GET['id_alumna']." AND id_grupo = ".$_POST['grupo']."";

  $consulta_grupos=mysqli_query($conexion, $sql);

  $sql = "UPDATE cuota_alumna
          SET eliminada=0
          WHERE id_alumna = ".$_GET['id_alumna']." AND id_grupo = ".$_POST['grupo']."";

  $consulta_grupos=mysqli_query($conexion, $sql);

   echo "<script>alert('Inscripcion realizada')</script>";

  echo "<script>window.close();</script>";

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
<form method="post" id="inscripcion">
    <label>Actividad</label><br>
    <select name="grupo" id="grupo">
    	<?php
		while($grupos=mysqli_fetch_assoc($consulta_grupos)){
			echo "<option value=".$grupos['id_grupo'].">".$grupos['grupo']."</option>";
		}
		?>
    </select>

   
</form>
 

 <a style="cursor:pointer" class="waves-effect waves-light btn" onClick="consultarInscripcion(<?php echo $_GET['id_alumna'] ?>)">CONFIRMAR</a>



</div>
<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<!--  <script type="text/javascript" src="../materialize/js/materialize.min.js"></script>-->
<script>
	
	function consultarInscripcion(id_alumna){

		var id_grupo = $("#grupo").val();

		$.ajax({
            data:{id_alumna:id_alumna,id_grupo:id_grupo},
            url:'ajax/consulta_inscripcion.php',
            type:'POST',
            success:function(response){
            	
            	if(response == "true"){
            		alert("La alumna ya se encuentra inscripta.")
            	}else{
            		$("#inscripcion").submit();
                opener.document.location.href='index.php?id_alumna=<?php echo $fila['id_alumna'];?>';

            	}

            }
            });



	}



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
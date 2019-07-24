<?php
include("../includes/verificarSesion.php"); 
require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();
 ?>

<?php
include("../includes/header.php");
include("../includes/menu-top-productora.php");
?>
<div class="row" style="height:100vh;">
	<div class="col l2" style="background-color: rgb(81,83,177);height:100vh">
		  <div id="slide-out" class="side-nav">
			<!--  <h3 class="center-align">Panel de administracion</h3>-->
			<h4 class="left-align">MENU</h4>
				<?php include("includes/links.php") ?>

		  </div>
	  </div>
	  <div class="col l10 m10">
		 	<div class="row cont-gral">
		  		<div class="container container-esp">
		  			
					<h1>Actualizar egresos</h1>

									
					<form action="procesos/actualizarEgresoProcess.php" method="POST">

						<label for="concepto">Concepto</label><br>

						<input type="text" name="concepto" id="concepto" value="<?php $baseDatos->listarConcepto($_GET["id"],'egreso')  ?>"><br>

						<label for="monto">Monto</label><br>

						<input type="text" name="monto" id="monto" value=<?php $baseDatos->listarMonto($_GET["id"],"egreso")  ?>><br>

						<label for="fecha">Fecha</label><br>

						<input type="date" name="fecha" id="fecha" value=<?php $baseDatos->listarFecha($_GET["id"],"egreso")  ?>><br><br><br>

						<input type="hidden" name="id" id="id" value=<?php echo $_GET['id'] ?>>

						<select name="categoria" id="categoria">
							
							<?php $baseDatos->listarCategoria($_GET['id'],'egreso') ?>

						</select>


						<button class="waves-effect waves-light btn ">Actualizar</button>
					</form>

		  		</div>
		  </div>

	  </div>
	 
</div>



<?php include("../includes/scripts.php") ?>

<script>
	 $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>
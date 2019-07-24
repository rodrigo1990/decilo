<?php 
include("../includes/verificarSesion.php"); 

require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();
 ?>

<?php
include("../includes/header.php");
include("../includes/menu-top-cashflow.php");
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
		  		<h1>Calcular total</h1>

					<form action="exportarInformes.php" method='POST' target='_blank'>

						<label for="fechaDesde">Desde</label>
						<input type="date" name="fechaDesde" id="fechaDesde">

						<label for="fechaHasta">Hasta</label>
						<input type="date" name="fechaHasta" id="fechaHasta">

						<a class="waves-effect waves-light btn" onClick="calcularTotal();">Calcular</a>

						<div id="total">
						</div>
					</form>
					
		  		</div>
		  </div>

	  </div>
	 
</div>



<?php include("../includes/scripts.php") ?>

<script>
	
	function calcularTotal(){

		var fechaDesde = $("#fechaDesde").val();
		var fechaHasta = $("#fechaHasta").val();


		$.ajax({
				data:{fechaDesde:fechaDesde,fechaHasta:fechaHasta},
				url:'ajax/calcularTotal.php',
				type:'post',
				success:function(response){
					$("#total").html(response);
					
					
			
				}
			});

	}


</script>
<script>
	 $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>

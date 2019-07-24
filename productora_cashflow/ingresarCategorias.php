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
		  		<h1>Ingresar categoria</h1>

					<form action="">
						<div class="input-field">
							<input type="text" name="categoria" id="categoria">
							<label for="fechaDesde">Categoria</label>
						</div>
						
						<a class="waves-effect waves-light btn" onClick="insertarCategoria();">Ingresar</a>
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
<script>

	function insertarCategoria(){
		var categoria = $("#categoria").val().toUpperCase();;
		$.ajax({
				data:{categoria:categoria},
				url:'ajax/insertarCategoria.php',
				type:'post',
				success:function(response){

					alert("La categoria ha sido insertada correctamente");
					$('#categoria').val('');
				}
					
		});
	}
</script>
</body>
</html>
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
		  			<h1>Insertar ingresos</h1>

					<form action="" style="padding-bottom: 100px;">
						<div class="input-field">
							<input type="text" name="concepto" id="concepto">
							<label for="concepto">Concepto</label>
						</div>
						<div class="input-field">
							<input type="number" name="monto" id="monto" min="0">
							<label for="monto">Monto</label>
						</div>
						<div class="input-field">
							<input type="date" name="fecha" id="fecha">
							<label for="fecha">Fecha</label>
						</div>
							<label for="categoria">Categoria</label>
							<select name="categoria" id="categoria">
								<?php $baseDatos->listarCategorias('Ingresar ingresos'); ?>
							</select>


						<div class="input-field ">
				          <textarea name="observacion" id="observacion" class="materialize-textarea"></textarea>
				          <label for="observacion">Observaciones</label>
				        </div>
					
			
						
						<a class="waves-effect waves-light btn" onClick="insertarIngreso();" style="cursor:pointer;">Ingresar</a>
					</form>

		  		</div>
		  </div>

	  </div>
	 
</div>



<?php include("../includes/scripts.php") ?>

<script>
	function insertarIngreso(){
		var concepto = $("#concepto").val();
		var monto = $("#monto").val();
		var fecha = $("#fecha").val();
		var categoria = $("#categoria").val();
		var observacion = $("#observacion").val();

		$.ajax({
				data:{concepto:concepto,monto:monto,fecha:fecha,categoria:categoria,observacion:observacion},
				url:'ajax/insertarIngreso.php',
				type:'post',
				success:function(response){

					alert("El ingreso ha sido insertado correctamente");

					$("#concepto").val('');
					$("#monto").val('');
					$("#fecha").val('');
					$('#categoria').prop('selectedIndex',0);
					$("#observacion").val('');
					
			
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


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
		  		<div class="container container-esp" style="padding-bottom:150px">
		  		<h1>Eliminar categoria</h1>
					<table >
						<tr>
							<th>ID</th>
							<th>Categoria</th>
							<th>Eliminar</th>
						</tr>
					<tbody id='categoriaTabla'>
						<?php $baseDatos->listarCategorias('ingresar categorias'); ?>
					</tbody>
					</table>
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

	function eliminarCategoria(id){
		$.ajax({
				data:{id:id},
				url:'ajax/eliminarCategoria.php',
				type:'post',
				success:function(response){

					alert("La categoria ha sido eliminada correctamente");

					$("#categoriaTabla").html(response);
				}
					
		});
	}
</script>
</body>
</html>
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
	  <div class="col l10 m10">
		 	<div class="row cont-gral">
		  		<div class="container">
		  			<div class="row">
		  				<div class="col l12">
							<h3>Detalle de egreso</h3>
						</div>
					</div>
					<div class="row detalle" style="">		  			
						<?php $baseDatos->listarDetalle($_GET['id'],'egreso'); ?>
					</div>
				</div>
					

		  		</div>
		  </div>

</div>
	 

<?php include("../includes/scripts.php") ?>
</body>
</html>
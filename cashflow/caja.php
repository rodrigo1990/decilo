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
		  		<h1>Caja</h1>
				<br>
					<h3>Total en caja : $<?php $baseDatos->calcularCaja(); ?></h3>
					<br><br>
					<a onClick="location.reload()" class="waves-effect waves-light btn">Actualizar</a>
					<br><br>
					<a href="cierreDeCajaPDF.php" class='waves-effect waves-light btn' target='_blank'>Exportar informe pdf</a>
					<br><br>
					<a class='waves-effect waves-light btn' href="cierreDeCajaXLS.php" target='_blank'>Exportar informe a .xls</a>
					
		  		</div>
		  </div>

	  </div>
	 
</div>



<?php include("../includes/scripts.php") ?>

</body>
</html>

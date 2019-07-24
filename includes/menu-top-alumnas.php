<header>
		<div class="row row1">
		<div class="col l2 m2">
				
			</div>
			<div class="col l8 m8">
				
			</div>
			<div class="col l2 m2">
				<div class="center-align"style="float:right">
						<a href="../index.php"><p style="">Cerrar Sesion</p></a>
				</div>
			</div>
	</div>
	<div class="row no-margin-bottom">
			<div class="col l2 m2">
				<a href="index.php" style="text-decoration:none;color:white">
					<img src="../img/logo.png" alt=""></a>
			</div>
			<div class="col l8 m8">
				<form id="buscador">
					<input type="text" id="busqueda" name="busqueda" placeholder="Buscar por nombre o email" style="color:white" onKeyUp="buscarAlumnas();" autocomplete="off">				 
				</form>
				<div id="resultadoBuscador">
					<?php 
						if(isset($_GET['busqueda'])){
							
							mostrarResultadosBusqueda($conexion, $_GET['busqueda']);	
						
						}
					?>
				</div>
			</div>
			<div class="col l2 m2">
				<div class="center-align"style="float:right">
						<h2 style="">ALUMNOS</h2>
				</div>
			</div>
	</div>


</header>
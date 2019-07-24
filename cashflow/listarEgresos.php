<?php 
include("../includes/verificarSesion.php"); 

require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();
 ?>

<?php
include("../includes/header.php");
include("../includes/menu-top-cashflow-buscadorEgresos.php");
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
		  			<div class="row">
						<h3>Lista de egresos</h3>
					</div>
					<div class="row" style="padding-bottom:5%;">		  			
						<table>
							<tr>
								<th>ID</th>
								<th>Concepto</th>
								<th>Observaciones</th>
								<th>Fecha</th>
								<th>Monto</th>
								<th>Actualizar</th>
								<th>Eliminar</th>
							</tr>
							<tbody id="listarEgresos">
								<?php
									$baseDatos->listarEgresos();
								  ?>
						  	</tbody>
						</table>
					</div>



					<!-- ver ingresos -->
					<div class="row">
						<h4>Ver egresos por categoria</h4>
					</div>
					<div class="row">
						<form action="" method="POST">
							<div class="col l6">
								<label for="categorias">Categoria:</label><br>
								<select name="categorias" id="categorias" onChange="listarEgresosPorCategoria();">
									<?php
										$baseDatos->listarCategorias('ver ingresos');
							 		?>
								</select>
							</div>
						</form>
					</div>

								<!-- ver ingresos -->
					<div class="row">
						<h4>Ver egresos por rango de fecha</h4>
					</div>
					<div class="row">
						<form action="" method="POST">
							<div class="col l6">
								<label for="fechaDesde">Fecha desde:</label><br>
								<input type="date" name="fechaDesde" id="fechaDesde" style="width:80%;">
							</div>
							<div class="col l6">
								<label for="fechaHasta">Fecha hasta:</label><br>
								<input type="date" name="fechaHasta" id="fechaHasta" style="width:80%"><br>
							</div>
							
						</form>
					</div>
					<div class="row">
						<a class="waves-effect waves-light btn float-right" onClick="verEgresoPorRangoDeFecha();" style="cursor:pointer">Ver</a>

						<a class="waves-effect waves-light btn float-right" onClick="listarEgresos();" style="cursor:pointer">Todas</a>
					</div>











					<div class="row">
						<h4>Eliminar egresos por rango de fecha</h4>
					</div>
					<div class="row">
						<form action="" method="POST">
							<div class="col l6">
								<label for="fechaDesde">Fecha desde:</label><br>
								<input type="date" name="fechaDesde" id="fechaDesde" style="width:80%;">
							</div>
							<div class="col l6">
								<label for="fechaHasta">Fecha hasta:</label><br>
								<input type="date" name="fechaHasta" id="fechaHasta" style="width:80%">
							</div>
							
						</form>
					</div>
					<div class="row last-row">
						<a class="waves-effect waves-light btn float-right" onClick="eliminarEgresoPorRangoDeFecha();" style="cursor:pointer;">Eliminar</a>
					</div>

		  		</div>
		  </div>

	  </div>
	 
</div>



<?php include("../includes/scripts.php") ?>

<script>

function listarEgresos(){

				$.ajax({
					url:'ajax/verEgresos.php',
					type:'post',
					success:function(response){
						$("#listarEgresos").html(response);
						
					}
				});
}


function eliminarEgreso(id){

		var confirmar=confirm("¿Desea eliminar este egreso?"); 

		if(confirmar==true){

			$.ajax({
					data:{id:id},
					url:'ajax/eliminarEgreso.php',
					type:'post',
					success:function(response){
						$("#listarEgresos").html(response);
					}
			});
		}

	}//function


		function eliminarEgresoPorRangoDeFecha(){

		var confirmar = confirm("¿Desea realizar esta operacion?");


		var fechaDesde = $("#fechaDesde").val();

		var fechaHasta = $("#fechaHasta").val();

		if(confirmar==true){

			$.ajax({
					data:{fechaDesde:fechaDesde,fechaHasta:fechaHasta},
					url:'ajax/eliminarEgresoPorRangoDeFecha.php',
					type:'post',
					success:function(response){
						$("#listarEgresos").html(response);
					}
			});



		}


	}//function


	function buscarEgresos(){

		var ingreso = $("#busqueda").val();

        if(ingreso != ''){

            $.ajax({
            data:"busqueda="+ ingreso,
            url:'ajax/buscarEgresos.php',
            type:'POST',
            success:function(response){
            document.getElementById("resultadoBuscador").style.display = "block";
            $("#resultadoBuscador").html(response);

            }
            });

        }else{
            document.getElementById("resultadoBuscador").style.display = "none";

        }

	}

	function listarEgresosPorCategoria(){

		var categoria = $("#categorias").val();

		if(categoria!='todas'){

				$.ajax({
					data:{categoria:categoria},
					url:'ajax/verEgresoPorCategoria.php',
					type:'post',
					success:function(response){
						$("#listarEgresos").html(response);
						
						
				
					}
				});
		}else{

				listarEgresos();

		}//listarIngresosPorCategoria

		
	}//function

	function verEgresoPorRangoDeFecha(){

		var fechaDesde = $("#fechaDesde").val();

		var fechaHasta = $("#fechaHasta").val();

			$.ajax({
					data:{fechaDesde:fechaDesde,fechaHasta:fechaHasta},
					url:'ajax/verEgresoPorRangoDeFecha.php',
					type:'post',
					success:function(response){
						$("#listarEgresos").html(response);
						
						
				
					}
			});

	}//fcuntion


		 $(document).ready(function(){
    		$('select').formSelect();
  		});
</script>

</body>
</html>
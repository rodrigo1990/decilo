<?php 
include("../includes/verificarSesion.php"); 
require_once("clases/BaseDatos.php");

$baseDatos = new BaseDatos();
 ?>
<?php
include("../includes/header.php");
include("../includes/menu-top-cashflow-buscadorIngresos.php");
?>
<div class="row" style="height:100vh;">
	<div class="col l2 m2 s2" style="background-color: rgb(81,83,177);height:100vh">
		  <div id="slide-out" class="side-nav">
			<!--  <h3 class="center-align">Panel de administracion</h3>-->
			<h4 class="left-align">MENU</h4>
			<?php include("includes/links.php") ?>

		  </div>
	  </div>
	  <div class="col l10 m10 s10">
		 	<div class="row cont-gral">
		  		<div class="container container-esp">
		  			<div class="row">
						<h3>Lista de ingresos</h3>
					</div>
					<div class="row table-cont" style="padding-bottom:5%;">		  			
						<table>
							<tr>
								<th>ID</th>
								<th>Concepto</th>
								<th>Observacion</th>
								<th>Fecha</th>
								<th>Monto</th>
							</tr>
							<tbody id="listarIngresos">
							<?php
								$baseDatos->listarIngresosHistoricos();
							  ?>
							  </tbody>
						</table>
					</div>
					
					<!-- ver ingresos -->
					<div class="row">
						<h4>Ver ingresos por categoria</h4>
					</div>
					<div class="row">
						<form action="" method="POST">
							<div class="col l6">
								<label for="categorias">Categoria:</label><br>
								<select name="categorias" id="categorias" onChange="listarIngresosPorCategoriaHistorico();">
									<?php
										$baseDatos->listarCategorias('ver ingresos');
							 		?>
								</select>
							</div>
						</form>
					</div>
				



					
					<!-- ver ingresos -->
					<div class="row">
						<h4>Ver ingresos por rango de fecha</h4>
					</div>
					<div class="row">
						<form action="" method="POST">
							<div class="col l6">
								<label for="fechaDesde">Fecha desde:</label><br>
								<input type="date" name="fechaDesde" id="fechaDesde" style="width:80%;">
							</div>
							<div class="col l6">
								<label for="fechaHasta">Fecha hasta:</label><br>
								<input type="date" name="fechaHasta" id="fechaHasta" style="width:80%"><br><br><br>
							</div>
							
						</form>
					</div>
					<div class="row">
						<a class="waves-effect waves-light btn float-right" onClick="verIngresoPorRangoDeFecha();" style="cursor:pointer">Ver</a>

						<a class="waves-effect waves-light btn float-right" onClick="listarIngresos();" style="cursor:pointer">Todas</a>
					</div>




					<!-- Eliminar ingresos -->
					<div class="row">
						<h4>Eliminar ingresos por rango de fecha</h4>
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
						<a class="waves-effect waves-light btn float-right" onClick="eliminarIngresoPorRangoDeFecha();" style="cursor:pointer">Eliminar</a>
					</div>
					
					
					




		  		</div>
		  </div>

	  </div>
	 
</div>



<?php include("../includes/scripts.php") ?>

<script>

	function listarIngresos(){

		$.ajax({
			url:'ajax/verIngresos.php',
			type:'post',
			success:function(response){
				$("#listarIngresos").html(response);
				
			}
		});

	}


	function eliminarIngreso(id){

		var confirmar=confirm("¿Desea eliminar este ingreso?"); 

		if(confirmar==true){

			$.ajax({
					data:{id:id},
					url:'ajax/eliminarIngreso.php',
					type:'post',
					success:function(response){
						$("#listarIngresos").html(response);
						
						
				
					}
			});

		}





	}


	function eliminarIngresoPorRangoDeFecha(){

		var confirmar = confirm("¿Desea realizar esta operacion?");


		var fechaDesde = $("#fechaDesde").val();

		var fechaHasta = $("#fechaHasta").val();

		if(confirmar==true){

			$.ajax({
					data:{fechaDesde:fechaDesde,fechaHasta:fechaHasta},
					url:'ajax/eliminarIngresoPorRangoDeFecha.php',
					type:'post',
					success:function(response){
						$("#listarIngresos").html(response);
						
						
				
					}
			});



		}


	}//fcuntion

	


	function listarIngresosPorCategoriaHistorico(){

		var categoria = $("#categorias").val();

		if(categoria!='todas'){

				$.ajax({
					data:{categoria:categoria},
					url:'ajax/verIngresoPorCategoriaHistorico.php',
					type:'post',
					success:function(response){
						$("#listarIngresos").html(response);
						
						
				
					}
				});
		}else{

				listarIngresos();

		}//listarIngresosPorCategoria

		
	}//function

	function verIngresoPorRangoDeFecha(){

		var fechaDesde = $("#fechaDesde").val();

		var fechaHasta = $("#fechaHasta").val();

			$.ajax({
					data:{fechaDesde:fechaDesde,fechaHasta:fechaHasta},
					url:'ajax/verIngresoPorRangoDeFecha.php',
					type:'post',
					success:function(response){
						$("#listarIngresos").html(response);
						
						
				
					}
			});

	}//fcuntion


	function buscarIngresos(){

		var ingreso = $("#busqueda").val();

        if(ingreso != ''){

            $.ajax({
            data:"busqueda="+ ingreso,
            url:'ajax/buscarIngresos.php',
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

	 $(document).ready(function(){
    		$('select').formSelect();
  		});

</script>

</body>
</html>























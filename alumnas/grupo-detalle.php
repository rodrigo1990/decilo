<?php
include("../includes/verificarSesion.php");
require_once("inc/conexion.php");
require_once("inc/funciones.php");
include("../includes/header.php");
include("../includes/menu-top-alumnas.php");

  ?>
<div class="row" style="height:100vh;">
    <div class="col l2" style="background-color: rgb(81,83,177);height:100vh">
          <div id="slide-out" class="side-nav">
            <!--  <h3 class="center-align">Panel de administracion</h3>-->
            <h4 class="left-align">MENU</h4>
            <ul class="left-align no-margin">
            <li><h5><a href="index.php">Alta alumno</a></h5></li>
                <li><h5><a href="visualizar_ingresos.php">Generar reportes</a></h5></li>
                <li><h5><a href="listado_deudores.php">Deudores</a></h5></li>
                <li><h5><a href="alumnas_eliminadas.php">Alumn@as eliminadas</a></h5></li>
                <li><h5><a href="grupos.php">Grupos</a></h5></li>
            </ul>
          </div>
      </div>
      <div class="col l10 cont-gral">
        <div class="row">
            <div class="container container-esp"style="padding-bottom:150px">
            <div class="row">
          	<h1><?php echo $_GET['grupo'] ?></h1>


			
				<?php 
        $id_grupo = $_GET['id'];
				  $sql="SELECT DISTINCT AL.id_alumna,AL.nombre 
          FROM `cuota_alumna` CA JOIN alumna AL ON CA.id_alumna = AL.id_alumna WHERE id_grupo = $id_grupo";
				$consulta=mysqli_query($conexion, $sql);

			
					
				?>			
					




          	<table>
          		<thead>
          			<tr>
          				<th>
          					Alumno
          				</th>
                  <th>
                    Detalle alumno
                  </th>
          			</tr>
          		</thead>
          		<tbody>
					

					<?php 
					while ($fila = mysqli_fetch_assoc($consulta)):
					 ?>
          			
          			<tr>
						<td><?php  echo $fila['nombre']?></td>
            <td>
							<a href="index.php?id_alumna=<?php echo $fila['id_alumna'] ?>">
								Detalle
							</a>
              </td>
							
								
							</td>
					   </tr>	
				
				<?php
					endwhile;
				?>	         
          		</tbody>
          	</table>
				

            </div>
        </div>
      </div>
</div>





















<?php include("../includes/scripts.php") ?>
<script type="text/javascript" src="js/funciones.js"></script>
<script>
    
    function buscarAlumnas(){

    var alumnaBuscada = $("#busqueda").val();

        if(alumnaBuscada != ''){

            $.ajax({
            data:"busqueda="+ alumnaBuscada,
            url:'ajax/busquedaAlumnas.php',
            type:'get',
            success:function(response){
            document.getElementById("resultadoBuscador").style.display = "block";
            $("#resultadoBuscador").html(response);

            }
            });

        }else{
            document.getElementById("resultadoBuscador").style.display = "none";

        }
}


 function eliminarAlumna(idAlumno){


    alert(idAlumno);

    

            $.ajax({
            data:"idAlumna="+ idAlumno,
            url:'ajax/eliminarAlumna.php',
            type:'post',
            success:function(response){
                if(response==true){
                    alert("¡Alumn@ eliminado con exito!");
                }else{
                    var c = confirm('Est@ alumn@ tiene cuotas adeudadas, si prosigue, las deudas se tomaran como pagadas.');

                    if(c ==true){

                         $.ajax({
                            data:"idAlumna="+ idAlumno,
                            url:'ajax/pagarDeuda.php',
                            type:'post',
                            success:function(response){
                                alert("¡Alumn@ eliminado con exito!");         

                            }
                            });


                    }else{

                    }
                }

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

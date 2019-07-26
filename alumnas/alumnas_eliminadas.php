<?php
include("../includes/verificarSesion.php");

require_once("inc/conexion.php");

require_once("inc/funciones.php");

include("../includes/header.php");

include("../includes/menu-top-alumnas.php");


generarDeudas($conexion);

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
                <h1>Listado de deudores</h1>

             	<table class="stripped">
			        <thead>
			          <tr>
			              <th>Nombre</th>
			              <th>Fecha Nac</th>
			              <th>Mail</th>
			              <th>Celular</th>
			              <th>Colegio</th>
			              <th>Reincorporar</th>
			              
			          </tr>
			        </thead>

			        <tbody>
						<?php 
						  $sql="SELECT id_alumna,nombre,fecha_nacimiento,mail,celular,colegio
				    	  FROM alumna
				    	  WHERE eliminada=1";
						$consulta=mysqli_query($conexion, $sql);

					
							while ($fila = mysqli_fetch_assoc($consulta)):
						?>			
							<tr>
								<td><?php  echo $fila['nombre']?></td>
								<td><?php  echo date("Y-m-d",$fila['fecha_nacimiento'])?></td>
								<td><?php  echo $fila['mail']?></td>
								<td><?php  echo $fila['celular'] ?></td>
								<td><?php  echo $fila['colegio'] ?></td>
								<td><button class="waves-effect waves-light btn" onClick="reincorporarAlumno(<?php echo $fila['id_alumna'] ?>)">Reincorporar</button></td>
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

 function reincorporarAlumno(idAlumno){



    

            $.ajax({
            data:"idAlumna="+ idAlumno,
            url:'ajax/reincorporar_alumna.php',
            type:'post',
            success:function(response){
            alert("¡Alumn@ reincorporado con exito!")
            location.reload();

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
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

                <?php 

                        $sql="SELECT AL.id_alumna as id_alumna,CA.id_concepto as id_concepto,CA.id_cuota as id_cuota,AL.nombre as nombre_alumna, GRU.grupo AS nombre_grupo, CA.mes, CA.anio, CON.concepto
                FROM cuota_alumna CA JOIN alumna AL ON CA.id_alumna = AL.id_alumna 
                            JOIN grupo GRU ON CA.id_grupo = GRU.id_grupo
                            JOIN concepto CON ON CON.id_concepto = CA.id_concepto
                WHERE CA.adeuda=1 and CA.eliminada=0";

                        $consulta2=mysqli_query($conexion, $sql);

                        $fila2 = mysqli_fetch_assoc($consulta2);


                        if(!$fila2){
                 ?>
                             <h2 style="color:lightGray;text-align: center;">NO HAY ALUMN@S CON PAGOS PENDIENTES</h2>

                  <?php  }else{ ?>  

             	<table class="stripped">
			        <thead>
			          <tr>
			              <th>Nombre</th>
			              <th>Actividad</th>
			              <th>Concepto</th>
			              <th>Mes adeudado</th>
                    <th>Pagar</th>
			              
			          </tr>
			        </thead>

			        <tbody>
						<?php 
						  $sql="SELECT AL.id_alumna as id_alumna,CA.id_concepto as id_concepto,CA.id_cuota as id_cuota,AL.nombre as nombre_alumna, GRU.grupo AS nombre_grupo, CA.mes, CA.anio, CON.concepto
				    	  FROM cuota_alumna CA JOIN alumna AL ON CA.id_alumna = AL.id_alumna 
				    	  						JOIN grupo GRU ON CA.id_grupo = GRU.id_grupo
				    	  						JOIN concepto CON ON CON.id_concepto = CA.id_concepto
				    	  WHERE CA.adeuda=1 and CA.eliminada=0";
						$consulta=mysqli_query($conexion, $sql);

					
							while ($fila = mysqli_fetch_assoc($consulta)):
						?>			
							<tr>
								<td><?php  echo $fila['nombre_alumna']?></td>
								<td><?php  echo $fila['nombre_grupo']?></td>
								<td><?php  echo $fila['concepto']?></td>
								<td><?php  echo $fila['mes']."/".$fila['anio']?></td>
                <?php if($fila['id_concepto']=="2" OR $fila['id_concepto']=="3" ){ ?>
                  <td><a onClick=" window.open('pagar_deuda.php?id_alumna=<?php echo $fila['id_alumna'] ?>&id_cuota=<?php echo $fila['id_cuota'] ?>','Comprobante','width=400,height=800')">Pagar</a></td>

                <?php }else{ ?>
                        
                        <td>-</td>
                
                <?php } ?>
							</tr>	
						<?php
							endwhile;
						?>	         
			        </tbody>
		      	</table>
	            <?php } ?>
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
</script>
<script>
	 $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>
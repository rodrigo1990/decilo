<?php
include("../includes/verificarSesion.php");
require_once("inc/conexion.php");
require_once("inc/funciones.php");

                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
                            if(isset($_POST['id_alumna'])){
                                
                                modificarAlumna($conexion, $_POST['id_alumna'], $_POST['nombre'], $_POST['fecha_ingreso'], $_POST['fecha_nacimiento'], $_POST['mail'], $_POST['celular'], $_POST['aclaraciones']);
                                echo "<script>alert('¡Alumna Editada!')</script>";
                            }else{
                            
                            $id_a=agregarAlumna($conexion, $_POST['nombre'], $_POST['fecha_ingreso'], $_POST['fecha_nacimiento'], $_POST['mail'], $_POST['celular'], $_POST['aclaraciones']);
                            
                            echo "¡Alumna agregada!";
                            echo "<script>document.location.href='index.php?id_alumna=".$id_a."&ra=ok'</script>";
                            
                            }
                        }


                     

if(isset($_GET['rc'])){ ?> <script>document.window.open('generar_comprobante.php?id_alumna=<?php echo $_GET['id_alumna'] ?>','Comprobante','width=400,height=500')</script>

<?php
}

?>
<?php
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
                <li><h5><a href="alumnas_eliminadas.php">Alumn@s eliminadas</a></h5></li>
                <li><h5><a href="grupos.php">Grupos</a></h5></li>
            </ul>
          </div>
      </div>
      <div class="col l10 cont-gral">
        <div class="row">
            <div class="container container-esp"style="padding-bottom:150px">
            <div class="row">
                <h1>Alta de alumno</h1>
            </div>

  
                <?php
                if(isset($_GET['id_alumna'])){
                $sql="SELECT * FROM alumna WHERE id_alumna=".$_GET['id_alumna'];
                $consulta=mysqli_query($conexion, $sql);
                $fila=mysqli_fetch_assoc($consulta);
				
				if(isset($_GET['elim'])){
				
				echo "<h3>¡La actividad se eliminó con éxito!</h3>"	;
				}

                    ?>
                    
                <form id="alta_alumna" method="post">   
                    <label>Nombre y Apellido</label>
                    <input type="text" name="nombre" value="<?php echo $fila['nombre'] ?>" /><br />
                    <label>Fecha ingreso</label>
                    <input type="date" name="fecha_ingreso" value="<?php echo date("Y-m-d", $fila['fecha_ingreso']) ?>" /><br />
                    <label>Fecha Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="<?php echo date("Y-m-d", $fila['fecha_nacimiento']) ?>" /><br />
                    <label>Mail</label>
                    <input type="email" name="mail" value="<?php echo $fila['mail'] ?>"  /><br />
                    <label>Celular</label>
                    <input type="text" name="celular" value="<?php echo $fila['celular'] ?>"  /><br />   
                   
                     
                   <br />
                    <label>Aclaraciones</label>
                    <input type="text" name="aclaraciones"  value="<?php echo $fila['aclaraciones'] ?>"  /><br />
                    <input type="hidden" name="id_alumna" value="<?php echo $fila['id_alumna'] ?>"  />
                    <input type="submit" value="Modificar"class="waves-effect waves-light btn" />

                </form>
                <br />
                <button  class="waves-effect waves-light btn" style="color:white !important;" id="generar_comprobante" onClick="window.open('inscribir_actividad.php?id_alumna=<?php echo $_GET['id_alumna'] ?>','Comprobante','width=400,height=400')">Inscribir actividad</button>
                    <br><br>
                 
                  <button class="waves-effect waves-light btn" onClick="eliminarAlumna(<?php echo $_GET['id_alumna'] ?>)"> Eliminar alumn@</button>
                 

                  <div class="row actividades">
                  

                      <h4>Generar comprobantes</h4>
                        <div id="list">
                            <?php generarActividades($conexion, $_GET['id_alumna']) ?>          
                        </div>
        
                    <br><br>
                     <!-- <button  class="waves-effect waves-light btn" style="color:white !important;" id="generar_comprobante" onClick="window.open('generar_comprobante.php?id_alumna=<?php echo $_GET['id_alumna'] ?>','Comprobante','width=400,height=800')">Generar Comprobante</button>
                     -->
                    

                    <h4>Actividades</h4>

                    <select name="actividad" id="actividad" onChange="mostrarComprobantes(<?php echo $_GET['id_alumna'] ?>)">
                        <?php listarActividades($conexion, $fila['id_alumna']); ?>
                    </select>

                    <br><br>
                  

                  </div>


                <div id="comprobantes" class='last-row'>
                <?php
				
				
                if(isset($_GET['id_grupo'])){
					
					mostrarComprobantes($conexion, $_GET['id_alumna'], $_GET['id_grupo']);
       
                    
                }else{
					//mostrarComprobantes($conexion, $_GET['id_alumna'], 0);
					
				}// fin isset id_grupo
                ?>
                </div>
                   
                   
                    
                    <?php
                }else{// si no hay id_alumna
                ?>
                <form id="alta_alumna" method="post" >  
                    <label>Nombre y Apellido</label>
                    <input type="text" name="nombre" /><br />
                    <label>Fecha ingreso</label>
                    <input type="date" name="fecha_ingreso" value="<?php echo date("Y-m-d") ?>" /><br />
                    <label>Fecha Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" /><br />
                    <label>Mail</label>
                    <input type="text" name="mail" /><br />
                    <label>Celular</label>
                    <input type="text" name="celular" /><br />
                   
                   
                    <label>Aclaraciones</label>
                    <input type="text" name="aclaraciones" /><br />
                    <input type="submit" value="Agregar" class="waves-effect waves-light btn"/>

                </form>
                <?php
                }
                ?>


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

    
            $.ajax({
            data:"idAlumna="+ idAlumno,
            url:'ajax/eliminarAlumna.php',
            type:'post',
            success:function(response){
                console.log(response);
                if(response==1){

                    alert("¡Alumn@ eliminado con exito!");
                    window.location.href = "index.php";

                }else if(response==0){

                    var c = confirm('Est@ alumn@ tiene cuotas adeudadas, si prosigue, las deudas se tomaran como pagadas.');

                    if(c ==true){

                         $.ajax({
                            data:"idAlumna="+ idAlumno,
                            url:'ajax/pagarDeuda.php',
                            type:'post',
                            success:function(response){
                                alert("¡Alumn@ eliminado con exito!"); 
                                window.location.href = "index.php";
        

                            }
                            });


                    }else{
                    }
                }else{
                }

            }
            });

        
}

function eliminarActividad(grupo,alumna){
     $.ajax({
            data:{idAlumna:alumna,idGrupo:grupo},
            url:'ajax/eliminar_actividad.php',
            type:'post',
            success:function(resp){
                console.log(resp);
                
                if(resp==1){

                    console.log("alumno eliminado");
                    alert("¡Alumn@ eliminado con exito!");
                    location.reload();

                }else if(resp==0){

                    var c = confirm('Est@ alumn@ tiene cuotas adeudadas, si prosigue, las deudas se tomaran como pagadas.');

                    if(c ==true){

                         $.ajax({
                            data:{idAlumna: alumna,grupo:grupo},
                            url:'ajax/pagarDeuda.php',
                            type:'post',
                            success:function(response){
                                alert("¡Alumn@ eliminado con exito!");
                                 window.location.href = "index.php?id_alumna="+alumna+""; 

                            }
                            });


                    }else{

                    }
                }else{
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

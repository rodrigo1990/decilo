<?php
include("../includes/verificarSesion.php");

require_once("inc/conexion.php");
require_once("inc/funciones.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(isset($_POST['id_alumna'])){
		
		modificarAlumna($conexion, $_POST['id_alumna'], $_POST['nombre'], $_POST['fecha_ingreso'], $_POST['fecha_nacimiento'], $_POST['mail'], $_POST['celular'], $_POST['aclaraciones']);
		echo "¡Alumna Editada!";
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
include("../includes/menu-top-alumnas-sin-buscador.php");

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
            </ul>
          </div>
      </div>
      <div class="col l10">
        <div class="row">
            <div class="container container-esp">
            <div class="row">
                <h1>Generar reportes</h1>
            </div>

                <form>
					<label>Mes</label>
				    <select name="mes">
				    	<?php
						for($i=1; $i<=12; $i++){
							if($i==date("n")){
								echo '<option selected value="'.$i.'">'.$meses_nombre[$i].'</option>';	
							}else{
								echo '<option value="'.$i.'">'.$meses_nombre[$i].'</option>';	
							}
						}
						?>
				    </select><br />
				    <label>Año</label>
				    <input type="text" name="anio" value="<?php echo date("Y"); ?>" /><br />
                    <label>Grupo</label><br/>
                    <select name="id_grupo">
                    <option value="0">Todos</option>
                 
						<?php	  generarGrupos($conexion); ?>
                    </select>
				    <button class="waves-effect waves-light btn">Visualizar ingresos</button>
				</form>
				<?php

					if(isset($_GET['mes'])){
						if($_GET['id_grupo']!=0){
					$sql="SELECT SUM(cuota_alumna.monto) total, grupo.grupo 
					FROM cuota_alumna INNER JOIN grupo ON cuota_alumna.id_grupo=grupo.id_grupo
					WHERE cuota_alumna.mes=".$_GET['mes']." 
					AND cuota_alumna.anio=".$_GET['anio']." 
					AND cuota_alumna.id_grupo=".$_GET['id_grupo'];		
							
						}else{
					$sql="SELECT SUM(monto) total FROM cuota_alumna
					WHERE cuota_alumna.mes=".$_GET['mes']." 
					AND cuota_alumna.anio=".$_GET['anio'];
						}
					$consulta=mysqli_query($conexion, $sql);
					$fila=mysqli_fetch_assoc($consulta);
					
					if($_GET['id_grupo']==0){

					echo "La ingreso total en ".$meses_nombre[$_GET['mes']]." de ".$_GET['anio']." es: $".$fila['total'];	

					echo '<br/><a href="exportar_ingresos_pdf.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&total='.$fila['total'].'">Exportar a PDF</a>';

					echo '<br/><a href="exportar_ingresos_xls.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&total='.$fila['total'].'">Exportar a XLS</a>';
					
					}else{
						
						
					echo "La ingreso total en ".$meses_nombre[$_GET['mes']]." de ".$_GET['anio']." para el grupo ".$fila['grupo']." es: $".$fila['total'];	

					echo '<br/><a href="exportar_ingresos_pdf.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&total='.$fila['total'].'&id_grupo='.$_GET['id_grupo'].'">Exportar a PDF</a>';	
					
					echo '<br/><a href="exportar_ingresos_xls.php?mes='.$_GET['mes'].'&anio='.$_GET['anio'].'&total='.$fila['total'].'&id_grupo='.$_GET['id_grupo'].'">Exportar a XLS</a>';
					}
					
					}
				?>


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
</body>
</html>
<?php 
session_start();
session_destroy();
 ?>
<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    

	<title>DECILO || PANEL DE ADMINISTRACION</title>
	<link rel="stylesheet" href="materialize/css/materialize.min.css">
	<link rel="stylesheet" href="estilos/estilos.css">
</head>
<body>

<div class="row row-indes" style="margin-top:10%">
	<div class="container">
		<div class="col l6 col-index">
			<a class="home-btn" href="HomeDecilo.php" >
				<div class="cuadrado center-align button-index" class="">
					<h1>Escuela</h1>
					<h1>Decilo</h1>
				</div>
			</a>
		</div>
		<div class="col l6 col-index">
			<a class="home-btn"  onClick="abrirModalProductora()"  >
				<div class="cuadrado center-align button-index" class="">
					<h1>Productora</h1>
				</div>
			</a>
			
		</div>
	</div>
</div>



<!-- Modal Structure -->
<div id="modal2" class="modal">

  <div class="modal-content">
  	<div class="input-field">
  		<input type="text" name="usuarioProd" id="usuarioProd">
  		<label for="user">Usuario</label>

  	</div>
  	<div class="input-field">
  		<input type="password" name="passProd" id="passProd">
  		<label for="pass">Password</label>
      <div class="error" id="error" style="display: none;color:red;text-align: center;">
        <p >Usuario y/o contraseña incorrectos</p>
      </div>
  	</div>
  	<a class='waves-effect waves-light btn' onClick="validarAdminProductora();" style="margin-left:auto;margin-right:auto;display:block;">Ingresar</a>
  </div>
</div>  

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="materialize/js/materialize.min.js"></script>
<script>


(function ($) {
    $(function () {

        //initialize all modals           
        $('.modal').modal();


    }); // end of document ready
})(jQuery); // end of jQuery name space

function abrirModalProductora(){
	//now you can open modal from code
        $('#modal2').modal('open');

}

function validarAdminProductora(){
  var usuario = $("#usuarioProd").val();
  var pass = $("#passProd").val();

  $.ajax({
        data:{usuario:usuario,pass:pass},
        url:'ajax/validarAdminProductora.php',
        type:'post',
        success:function(response){
         // alert(response);
          if(response=="true"){
            window.location ="productora_cashflow/";
          }else{
            $("#error").show();
          }
    
        }
    });


}//function
</script>
</body>
</html>
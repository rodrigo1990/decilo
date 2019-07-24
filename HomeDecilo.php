<?php 
session_start();
session_destroy();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DECILO || PANEL DE ADMINISTRACION</title>
	<link rel="stylesheet" href="materialize/css/materialize.min.css">
	<link rel="stylesheet" href="estilos/estilos.css">
</head>
<body>

<div class="row" style="margin-top:10%">
	<div class="container">
		<div class="col l6">
			<a class="home-btn" onClick="abrirModalAlumnas();">
				<div class="cuadrado center-align">
					<h1>Modulo</h1>
					<h1>Alumn@s</h1>
				</div>
			</a>
		</div>
		<div class="col l6">
			<a class="home-btn" onClick="abrirModalCashflow();">
				<div class="cuadrado center-align">
					<h1>Modulo</h1>
				<h1>Cashflow</h1>	

				</div>
			</a>
			
		</div>
	</div>
</div>

<!-- Modal Structure -->
<!-- Modal Structure -->
<div id="modal1" class="modal">

  <div class="modal-content">
  	<div class="input-field">
  		<input type="text" name="usuarioAlum" id="usuarioAlum">
  		<label for="user">Usuario</label>

  	</div>
  	<div class="input-field">
  		<input type="password" name="passAlum" id="passAlum">
  		<label for="pass">Password</label>
      <div class="error" id="error" style="display: none;color:red;text-align: center;">
        <p >Usuario y/o contraseña incorrectos</p>
      </div>
  	</div>
  	<a class='waves-effect waves-light btn' onClick="validarAdminAlumnas();" style="margin-left:auto;margin-right:auto;display:block;">Ingresar</a>
  </div>
</div> 

<!-- Modal Structure -->
<div id="modal2" class="modal">

  <div class="modal-content">
  	<div class="input-field">
  		<input type="text" name="user" id="userCash">
  		<label for="user">Usuario</label>

  	</div>
  	<div class="input-field">
  		<input type="password" name="pass" id="passCash">
  		<label for="pass">Password</label>
  	</div>
  	<a class='waves-effect waves-light btn' onClick="validarAdminCash();"  style="margin-left:auto;margin-right:auto;display:block;">Ingresar</a>
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
	function abrirModalAlumnas(){
	//now you can open modal from code
        $('#modal1').modal('open');

	}

	function abrirModalCashflow(){
	//now you can open modal from code
        $('#modal2').modal('open');

	}


	function validarAdminAlumnas(){
	  var usuario = $("#usuarioAlum").val();
	  var pass = $("#passAlum").val();

	  $.ajax({
	        data:{usuario:usuario,pass:pass},
	        url:'ajax/validarAdminAlumnas.php',
	        type:'post',
	        success:function(response){
	          //alert(response);
	          if(response=="true"){
	            window.location ="alumnas/";
	          }else{
	            $("#error").show();
	          }
	    
	        }
    });


}//function


	function validarAdminCash(){
	  var usuario = $("#userCash").val();
	  var pass = $("#passCash").val();

	  $.ajax({
	        data:{usuario:usuario,pass:pass},
	        url:'ajax/validarAdminCashflow.php',
	        type:'post',
	        success:function(response){
	          //alert(response);
	          if(response=="true"){
	            window.location ="cashflow/";
	          }else{
	            $("#error").show();
	          }
	    
	        }
    });


}//function
</script>

</body>
</html>
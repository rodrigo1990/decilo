<?php 
class Validator{

	public $mysqli;

	
	public function validarAdminProductora($usuario,$pass){

		$this->mysqli=new mysqli("162.255.162.75", 'edbplata_rodrigo','Javierjavier1990', "edbplata_productora");

		$this->mysqli->set_charset("utf8");


		$stmt=$this->mysqli->prepare("SELECT pass
									  FROM admin
									  WHERE usuario=(?)");

		$stmt->bind_param("s",$usuario);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila["pass"]==$pass){
			return TRUE;
			//header("Location: home.php");

		}else{
			return FALSE;
		}

		$stmt->close();


}
public function validarAdminDeciloAlumnas($usuario,$pass){

	$this->mysqli=new mysqli("localhost", 'root','', "edbplata_alumnas");

	$this->mysqli->set_charset("utf8");


	$stmt=$this->mysqli->prepare("SELECT pass
								  FROM admin
								  WHERE usuario=(?)");

	$stmt->bind_param("s",$usuario);

	$stmt->execute();

	$resultado=$stmt->get_result();

	$fila=$resultado->fetch_assoc();

	if($fila["pass"]==$pass){
		return TRUE;
		//header("Location: home.php");

	}else{
		return FALSE;
	}

	$stmt->close();


}

public function validarAdminDeciloCash($usuario,$pass){

	$this->mysqli=new mysqli("localhost", 'root','', "edbplata_cashflow");

	$this->mysqli->set_charset("utf8");


	$stmt=$this->mysqli->prepare("SELECT pass
								  FROM admin
								  WHERE usuario=(?)");

	$stmt->bind_param("s",$usuario);

	$stmt->execute();

	$resultado=$stmt->get_result();

	$fila=$resultado->fetch_assoc();

	if($fila["pass"]==$pass){
		return TRUE;
		//header("Location: home.php");

	}else{
		return FALSE;
	}

	$stmt->close();


}



}


 ?>
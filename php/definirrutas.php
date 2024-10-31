<?php 
	
	session_start();

	if(isset($_SESSION['rol'])){
		switch ($_SESSION['rol']) {
			case 1:
				header('location: ../noticias.php');
				break;
			case 2:
				header('location: ../becarioKiosco/ventaBK.php');
				break;
			case 3:
				//header('location: ../becarioKiosco/ventaBK.php');
				break;
			case 4:
				header('location: ../vendedorEntradas/venderEntradas.php');
				break;
			default:
				# code...
				break;
		}	
	}else{
		$errorLogin= "Debe registrarse <br>";
		header('location: ../login.php?errorLogin='.$errorLogin);
	}


?>
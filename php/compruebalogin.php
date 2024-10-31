<?php 

	include_once 'conexion.php';

	if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != "" && $_POST['password'] != ""){
		$bd= new BD();
		$conexion = $bd->connect();
		$query= $conexion->prepare('select * from bdunertest.t_usuarios where username = :user and password = :pass');
		
		$user= htmlentities(addslashes($_POST['username']));
		$pass= htmlentities(addslashes($_POST['password']));

		$query->execute(['user' => $user, 'pass' => $pass]);

		$numeroRegistro= $query->rowCount();
		if($numeroRegistro != 0){

			session_start();
			 
			foreach ($query as $currentUser) {
				$_SESSION['nombre']= $currentUser['nombre'];
				$_SESSION['username']= $currentUser ['username'];
				$_SESSION['rol']= $currentUser ['rol_id'];
				$_SESSION['horarioDeEntrada'] = date("Y-m-d H:i:s");
				//Prueba de calcular horas trabajadas
					//$_SESSION['horasTrabajadas'] = date("H:i:s");
				//Prueba de calcular horas trabajadas
			}
			switch ($_SESSION['rol']) {
				case 1:
					header('location: ../noticias.php');
					break;
				case 2:
					cajaInicialCantina();
					header('location: ../becarioKiosco/ventaBK.php');
					break;
				case 3:
					//header('location: ../noticias.php');
					//break;
				case 4:
					header('location: ../vendedorEntradas/venderEntradas.php');
					break;
				default:
					# code...
					break;
			}
		}else{
			$errorLogin= "Usuario y/o password incorrecto<br>";
			header('location: ../login.php?errorLogin='.$errorLogin);
		}
	}else{
		$errorLogin= "Complete todos los campos<br>";
		header('location: ../login.php?errorLogin='.$errorLogin);
	}
	
	function cajaInicialCantina(){

		include_once 'conexion.php';
        $bd= new BD();
        $conexion = $bd->connect();
		$query= $conexion->prepare('SELECT SUM(precio) as precio FROM bdunertest.t_productosv WHERE categoria = "Cantina"');
		$query->execute();

		foreach ($query as $currentUser) {
			$_SESSION['cajaInicial']= $currentUser['precio'];
		}

	}

?>
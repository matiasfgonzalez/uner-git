<?php 

	session_start();
	/* aca utiliar las variables antes de destruir todo */

	$horarioDeEntrada = $_SESSION['horarioDeEntrada'];
	$horarioDeSalida = date("Y-m-d H:i:s");
	$usuario = $_SESSION['nombre'];
	$cajainicial = isset($_SESSION['cajaInicial']) ? $_SESSION['cajaInicial'] : 0;

	if ($_SESSION['rol'] == 2) {
		agregarUsuarioAPlanillaDeAsistenciaCantina($horarioDeEntrada, $horarioDeSalida, $usuario, $cajainicial);
	} else if ($_SESSION['rol'] == 1) {
		agregarAdministradorEnPlanilla($horarioDeEntrada, $horarioDeSalida, $usuario);
	}
	
	session_unset();

	session_destroy();

	header('location: ../login.php');

	function agregarAdministradorEnPlanilla($horarioDeEntrada, $horarioDeSalida, $usuario) {
		include_once 'conexion.php';
        $bd= new BD();
        $conexion = $bd->connect();

        $query= $conexion->prepare('INSERT INTO bdunertest.t_planilladeasistencias VALUES 
							(null ,:nomyape, :horariodeentrada, :horariodesalida, :cajainicial, :cajafinal, :recaudado)');
        
        // Definir variables para los valores literales
		$cajainicial = 0;
		$cajafinal = 0;
		$recaudado = 0;

		// Vincular parámetros
		$query->bindParam(':nomyape', $usuario);
		$query->bindParam(':horariodeentrada', $horarioDeEntrada);
		$query->bindParam(':horariodesalida', $horarioDeSalida);
		$query->bindParam(':cajainicial', $cajainicial);
		$query->bindParam(':cajafinal', $cajafinal);
		$query->bindParam(':recaudado', $recaudado);

        $query->execute();
		
		// Liberar la consulta y cerrar la conexión
		$query->closeCursor();

        $query = NULL;
        $conexion = NULL;
	}

	function agregarUsuarioAPlanillaDeAsistenciaCantina($horarioDeEntrada,$horarioDeSalida,$usuario,$cajainicial){
		include_once 'conexion.php';
        $bd= new BD();
        $conexion = $bd->connect();
        $query= $conexion->prepare('INSERT INTO bdunertest.t_planilladeasistencias VALUES 
							(null ,:nomyape, :horariodeentrada, :horariodesalida, :cajainicial, :cajafinal, :recaudado)');
		
		$query2= $conexion->prepare('SELECT SUM(precio) as precio FROM bdunertest.t_productosv WHERE categoria = "Cantina"');
		$query2->execute();

		foreach ($query2 as $currentUser) {
			$cajafinal = $currentUser['precio'];
		}
		if(is_null($cajafinal)){
			$cajafinal=0;
		}

		$recaudado = $cajafinal-$cajainicial;
        
        $query->bindParam(':nomyape', $usuario);
        $query->bindParam(':horariodeentrada', $horarioDeEntrada);
        $query->bindParam(':horariodesalida', $horarioDeSalida);
        $query->bindParam(':cajainicial', $cajainicial);
        $query->bindParam(':cajafinal', $cajafinal);
        $query->bindParam(':recaudado', $recaudado);

        $query->execute();

        $query = NULL;
        $conexion = NULL;
	}
?>
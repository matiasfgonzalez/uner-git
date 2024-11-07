<?php

session_start();
/* aca utiliar las variables antes de destruir todo */

$horarioDeEntrada = $_SESSION['horarioDeEntrada'];
$horarioDeSalida = date("Y-m-d H:i:s");
$usuario = $_SESSION['username'];
$cajainicial = isset($_SESSION['cajaInicial']) ? $_SESSION['cajaInicial'] : 0;

if ($_SESSION['rol'] == 2) {
	agregarUsuarioAPlanillaDeAsistenciaCantina($horarioDeEntrada, $horarioDeSalida, $usuario, $cajainicial);
} else if ($_SESSION['rol'] == 1) {
	agregarAdministradorEnPlanilla($horarioDeEntrada, $horarioDeSalida, $usuario);
}

// Destruir sesión al final
session_unset();
session_destroy();

header('location: ../login.php');

function agregarAdministradorEnPlanilla($horarioDeEntrada, $horarioDeSalida, $usuario)
{
	include_once 'conexion.php';
	$bd = new BD();
	$conexion = $bd->connect();

	// Consulta de inserción
	$query = $conexion->prepare('INSERT INTO bdunertest.t_planilladeasistencias 
                                 (nomyape, horariodeentrada, horariodesalida, cajainicial, cajafinal, recaudado) 
                                 VALUES (:nomyape, :horariodeentrada, :horariodesalida, :cajainicial, :cajafinal, :recaudado)');

	// Definir valores predeterminados
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
	$query = NULL;
	$conexion = NULL;
}

function agregarUsuarioAPlanillaDeAsistenciaCantina($horarioDeEntrada, $horarioDeSalida, $usuario, $cajainicial)
{
	include_once 'conexion.php';
	$bd = new BD();
	$conexion = $bd->connect();

	// Consulta de inserción
	$query = $conexion->prepare('INSERT INTO bdunertest.t_planilladeasistencias 
                                 (nomyape, horariodeentrada, horariodesalida, cajainicial, cajafinal, recaudado) 
                                 VALUES (:nomyape, :horariodeentrada, :horariodesalida, :cajainicial, :cajafinal, :recaudado)');

	$query2 = $conexion->prepare('SELECT SUM(total) as total FROM bdunertest.t_ventas WHERE lugar_venta = "Cantina" AND DATE(fecha) = CURDATE()');
	$query2->execute();

	// Obtener el resultado de la consulta
	$result = $query2->fetch(PDO::FETCH_ASSOC);
	$cajafinal = isset($result['total']) ? $result['total'] : 0;

	// Calcular el recaudado
	$recaudado = $cajafinal - $cajainicial;

	$query->bindParam(':nomyape', $usuario);
	$query->bindParam(':horariodeentrada', $horarioDeEntrada);
	$query->bindParam(':horariodesalida', $horarioDeSalida);
	$query->bindParam(':cajainicial', $cajainicial);
	$query->bindParam(':cajafinal', $cajafinal);
	$query->bindParam(':recaudado', $recaudado);

	$query->execute();

	// Liberar la consulta y cerrar la conexión
	$query = NULL;
	$conexion = NULL;
}

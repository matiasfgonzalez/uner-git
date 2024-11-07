<?php
include_once 'conexion.php';
session_start();

if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
	$bd = new BD();
	$conexion = $bd->connect();

	// Consulta para obtener los datos del usuario
	$query = $conexion->prepare('SELECT * FROM bdunertest.t_usuarios WHERE username = :user');
	$user = $_POST['username'];
	$query->bindParam(':user', $user);
	$query->execute();

	$currentUser = $query->fetch(PDO::FETCH_ASSOC);

	// Verificar si el usuario existe y si la contraseña es correcta
	if ($currentUser && password_verify($_POST['password'], $currentUser['password'])) {
		$_SESSION['nombre'] = $currentUser['nombre'];
		$_SESSION['username'] = $currentUser['username'];
		$_SESSION['rol'] = $currentUser['rol_id'];
		$_SESSION['horarioDeEntrada'] = date("Y-m-d H:i:s");

		// Redirigir basado en el rol del usuario
		switch ($_SESSION['rol']) {
			case 1:
				header('location: ../noticias.php');
				break;
			case 2:
				cajaInicialCantina();
				header('location: ../becarioKiosco/ventaBK.php');
				break;
			case 3:
				header('location: ../noticias.php'); // No hay ruta definida para el rol 3 en el código original
				break;
			case 4:
				header('location: ../vendedorEntradas/venderEntradas.php');
				break;
			default:
				$errorLogin = "Rol de usuario no válido.";
				header('location: ../login.php?errorLogin=' . urlencode($errorLogin));
				break;
		}
		exit;
	} else {
		$errorLogin = "Usuario y/o contraseña incorrecto.";
		header('location: ../login.php?errorLogin=' . urlencode($errorLogin));
		exit;
	}
} else {
	$errorLogin = "Complete todos los campos.";
	header('location: ../login.php?errorLogin=' . urlencode($errorLogin));
	exit;
}

function cajaInicialCantina()
{
	include_once 'conexion.php';
	$bd = new BD();
	$conexion = $bd->connect();

	// Filtrar por la fecha actual (utilizando CURDATE() que devuelve la fecha sin la hora)
	$query = $conexion->prepare('SELECT SUM(total) as total FROM bdunertest.t_ventas WHERE lugar_venta = "Cantina" AND DATE(fecha) = CURDATE()');
	$query->execute();

	foreach ($query as $currentUser) {
		$_SESSION['cajaInicial'] = $currentUser['total'];
	}
}

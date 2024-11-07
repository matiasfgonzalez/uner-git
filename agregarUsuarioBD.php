<?php

// Inicia sesión y maneja el archivo de conexión
session_start();
include_once 'php/conexion.php';

$nombredelusuario = trim(isset($_POST['nombreCompletoDelUsuario']) ? $_POST['nombreCompletoDelUsuario'] : '');
$nombreenelsistema = trim(isset($_POST['nombreEnElSistema']) ? $_POST['nombreEnElSistema'] : '');
$identificador = trim(isset($_POST['identificador']) ? $_POST['identificador'] : '');
$telefono = trim(isset($_POST['telefono']) ? $_POST['telefono'] : '');
$contrasenia = trim(isset($_POST['contrasenia']) ? $_POST['contrasenia'] : '');
$rolusuario = trim(isset($_POST['rolUsuario']) ? $_POST['rolUsuario'] : '');
$correo = trim(isset($_POST['correo']) ? $_POST['correo'] : '');

// Validaciones básicas de entrada
if (empty($nombredelusuario) || empty($nombreenelsistema) || empty($identificador) || empty($telefono) || empty($rolusuario) || empty($correo) || empty($contrasenia)) {
	$mensaje = "Por favor, complete todos los campos.";
	header('location: agregarUsuario.php?error=' . urlencode($mensaje));
	exit;
}

if (!is_numeric($telefono) || $telefono == 0) {
	$mensaje = "Por favor, en el campo de teléfono no puede ser el valor 0 (cero).";
	header('location: agregarUsuario.php?error=' . urlencode($mensaje));
	exit;
}

if ($rolusuario == "so") {
	$mensaje = "Por favor, elija un rol para el usuario.";
	header('location: agregarUsuario.php?error=' . urlencode($mensaje));
	exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
	$mensaje = "Por favor, ingrese un correo electrónico válido.";
	header('location: agregarUsuario.php?error=' . urlencode($mensaje));
	exit;
}

// Encriptar la contraseña
$hashed_password = password_hash($contrasenia, PASSWORD_BCRYPT);

try {
	$bd = new BD();
	$conexion = $bd->connect();
	$query = $conexion->prepare('INSERT INTO bdunertest.t_usuarios (id, username, password, nombre, dnicuil, telefono, correo, rol_id) 
                                  VALUES (:id, :username, :password, :nombre, :dnicuil, :telefono, :correo, :rol_id)');

	$id = NULL;
	$query->bindParam(':id', $id);
	$query->bindParam(':username', $nombreenelsistema);
	$query->bindParam(':password', $hashed_password);
	$query->bindParam(':nombre', $nombredelusuario);
	$query->bindParam(':dnicuil', $identificador);
	$query->bindParam(':telefono', $telefono);
	$query->bindParam(':correo', $correo);
	$query->bindParam(':rol_id', $rolusuario);

	// Ejecutar la consulta y cerrar la conexión
	$query->execute();

	// Definir el rol de usuario para el mensaje de éxito
	$roles = [
		'1' => "Administrador",
		'2' => "Becario Cantina",
		'3' => "Becario Fotocopiadora",
		'4' => "Vendedor de Entradas"
	];
	$rolusuariotexto = isset($roles[$rolusuario]) ? $roles[$rolusuario] : "Rol desconocido";

	$mensaje = "Se cargó exitosamente el usuario " . htmlspecialchars($nombredelusuario) . " con el rol " . htmlspecialchars($rolusuariotexto);
	header('location: agregarUsuario.php?info=' . urlencode($mensaje));
	exit;
} catch (PDOException $e) {
	// Error en la conexión o ejecución de la consulta
	$mensaje = "Error al cargar el usuario. Por favor, inténtelo más tarde.";
	header('location: agregarUsuario.php?error=' . urlencode($mensaje));
	exit;
} finally {
	$query = null;
	$conexion = null;
}

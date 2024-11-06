<?php
require_once "conexion.php";
$conexion = conexion();

$codigodebarra = $_POST['codigodebarra'];

// Usar consulta preparada para mayor seguridad
$stmt = $conexion->prepare("SELECT nombre, precio, categoria, codigodebarra FROM t_productos WHERE codigodebarra = ?");
$stmt->bind_param("s", $codigodebarra);
$stmt->execute();
$resultado = $stmt->get_result();

if ($producto = $resultado->fetch_assoc()) {
    echo json_encode($producto);
} else {
    echo json_encode(["error" => "Producto no encontrado"]);
}

$stmt->close();
$conexion->close();

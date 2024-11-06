<?php
require_once "conexion.php";

$conexion = conexion();

if (isset($_GET['id_venta'])) {
    $idVenta = intval($_GET['id_venta']); // Asegurarse de que sea un entero

    $sql = "SELECT * FROM t_detalle_ventas WHERE id_venta = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idVenta);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $productos = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Calcular el total de la venta sumando los subtotales
        $totalVenta = 0;
        foreach ($productos as $producto) {
            $totalVenta += $producto['subtotal'];
        }

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode([
            "productos" => $productos,
            "totalVenta" => $totalVenta
        ]);
    } else {
        // En caso de error en la consulta
        http_response_code(500);
        echo json_encode(["error" => "Error en la consulta de la base de datos"]);
    }

    mysqli_stmt_close($stmt);
} else {
    http_response_code(400);
    echo json_encode(["error" => "No se proporcionó un ID de venta"]);
}

mysqli_close($conexion);

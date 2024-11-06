<?php
require_once "conexion.php";
$conexion = conexion();

$data = json_decode(file_get_contents("php://input"), true);
$productos = $data['productosVendidos'];
$total = $data['total'];
$metodo_pago = $data['metodoPago'];

session_start();

$usuario_alta = $_SESSION['nombre']; // Usuario que realiza la venta

// Iniciar una transacción para asegurar la consistencia de los datos
mysqli_begin_transaction($conexion);

try {
    // Insertar en la tabla t_ventas
    $sqlVenta = "INSERT INTO t_ventas (total, metodo_pago, fecha_alta, usuario_alta) VALUES (?, ?, NOW(), ?)";
    $stmtVenta = mysqli_prepare($conexion, $sqlVenta);
    mysqli_stmt_bind_param($stmtVenta, 'dss', $total, $metodo_pago, $usuario_alta);
    mysqli_stmt_execute($stmtVenta);

    // Obtener el ID de la venta insertada
    $id_venta = mysqli_insert_id($conexion);

    // Insertar cada producto en t_detalle_ventas y actualizar el stock en t_productos
    $sqlDetalle = "INSERT INTO t_detalle_ventas (id_venta, codigodebarra, cantidad, precio_unitario, subtotal, fecha_alta, usuario_alta) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmtDetalle = mysqli_prepare($conexion, $sqlDetalle);

    $sqlActualizarStock = "UPDATE t_productos SET stock = stock - ? WHERE codigodebarra = ?";
    $stmtActualizarStock = mysqli_prepare($conexion, $sqlActualizarStock);

    foreach ($productos as $producto) {
        $codigodebarra = $producto['codigodebarra'];
        $cantidad = $producto['cantidad'];
        $precio_unitario = $producto['precio'];
        $subtotal = $producto['subtotal'];

        // Insertar en t_detalle_ventas
        mysqli_stmt_bind_param($stmtDetalle, 'isidds', $id_venta, $codigodebarra, $cantidad, $precio_unitario, $subtotal, $usuario_alta);
        mysqli_stmt_execute($stmtDetalle);

        // Actualizar el stock en t_productos
        mysqli_stmt_bind_param($stmtActualizarStock, 'is', $cantidad, $codigodebarra);
        mysqli_stmt_execute($stmtActualizarStock);
    }

    // Confirmar la transacción
    mysqli_commit($conexion);
    echo json_encode(['success' => true, 'message' => 'Venta registrada exitosamente y stock actualizado']);
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => 'Error al registrar la venta: ' . $e->getMessage()]);
}

mysqli_close($conexion);

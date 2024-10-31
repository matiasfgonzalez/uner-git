<?php 
	require_once "conexion.php";
	$conexion=conexion();
	session_start();
	$vendedor=$_SESSION['nombre']; 
	$sql="insert into t_productosv (nombre, precio, categoria, codigodebarra, vendedor) (select nombre, precio, categoria, codigodebarra, '$vendedor' from t_productosvt)";
	$sql2="DELETE FROM t_productosvt";

	$resultado = mysqli_query($conexion,$sql);
	echo $resultado = mysqli_query($conexion,$sql2);
?>
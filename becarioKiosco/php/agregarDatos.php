<?php 
	
	require_once "conexion.php";
	$conexion=conexion();

	$codigodebarra = $_POST['codigodebarra'];

	$sql="insert into t_productosvt (nombre, precio, categoria, codigodebarra) (select nombre, precio, categoria, codigodebarra from t_productos where codigodebarra= '$codigodebarra'  )";

	echo $resultado = mysqli_query($conexion,$sql);
?>

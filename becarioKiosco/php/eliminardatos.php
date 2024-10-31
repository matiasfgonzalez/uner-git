<?php 

	require_once "conexion.php";
	$conexion=conexion();

	$id = $_POST['id'];

	$sql="delete from t_productosvt where id='$id'";

	echo $resultado = mysqli_query($conexion,$sql);
?>
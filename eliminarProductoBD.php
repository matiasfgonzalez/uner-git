<?php 

	$codigodebarra = $_POST['codigoDelProductoAE'];

	if($codigodebarra == ""){
		
		$mensaje="Por favor, complete todos los campos.";
        header('location: listadoDeProductos.php?error='.$mensaje);
        exit;

	}else{
		include_once 'php/conexion.php';
	    $bd= new BD();
	    $conexion = $bd->connect();
	    $query= $conexion->prepare('DELETE FROM bdunertest.t_productos WHERE id = :codigodebarra');
	    $query->bindParam(':codigodebarra', $codigodebarra);
            
        $query->execute();
        $query = NULL;
        $conexion = NULL;

		$mensaje="Se elimino exitosamente el producto " . $nombre . " con el codigo " . $codigodebarra;
		header('location: listadoDeProductos.php?info='.$mensaje);
        exit;
	}
?>
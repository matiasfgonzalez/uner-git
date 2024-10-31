<?php 

	$idUserAE = $_POST['idDelUsuarioAE'];

	if($idUserAE == ""){
		
		$mensaje="Por favor, complete todos los campos.";
        header('location: listadoDeUsuarios.php?error='.$mensaje);
        exit;

	}else{
		include_once 'php/conexion.php';
	    $bd= new BD();
	    $conexion = $bd->connect();
	    $query= $conexion->prepare('DELETE FROM bdunertest.t_usuarios WHERE id = :idUserAE');
	    $query->bindParam(':idUserAE', $idUserAE);
            
        $query->execute();
        $query = NULL;
        $conexion = NULL;

		$mensaje="Se elimino exitosamente el usuario";
		header('location: listadoDeUsuarios.php?info='.$mensaje);
        exit;
	}
?>
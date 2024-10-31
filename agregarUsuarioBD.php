<?php 
	
	$nombredelusuario = $_POST['nombredelusuario'];
	$nombreenelsistema = $_POST['nombreenelsistema'];
	$identificador = $_POST['identificador'];
	$telefono = $_POST['telefono'];
	$contrasenia = $_POST['contrasenia'];
	$rolusuario = $_POST['rolusuario'];
	$correo = $_POST['correo'];

	echo $nombredelusuario . "<br>";
	echo $nombreenelsistema . "<br>";
	echo $identificador . "<br>";
	echo $telefono . "<br>";
	echo $contrasenia . "<br>";
	echo $rolusuario . "<br>";
	echo $correo . "<br>";

	if($nombredelusuario == "" || $nombreenelsistema == "" || $identificador == "" || $telefono == "" || $rolusuario == "" || $correo == "" || $contrasenia == ""){
		
		$mensaje="Por favor, complete todos los campos.";
        header('location: agregarUsuario.php?error='.$mensaje);
        exit;

	}else if($telefono == 0){

		$mensaje="Por favor, en campos de telefono no puede ser el valor 0(cero).";
        header('location: agregarUsuario.php?error='.$mensaje);
        exit;

	}else if($rolusuario == "so"){

		$mensaje="Por favor, elija un rol para el usuario.";
        header('location: agregarUsuario.php?error='.$mensaje);
        exit;

	}else{
		include_once 'php/conexion.php';
	    $bd= new BD();
	    $conexion = $bd->connect();
	    $query= $conexion->prepare('INSERT INTO bdunertest.t_usuarios VALUES 
                                (:id ,:username , :password, :nombre, :dnicuil, :telefono, :correo, :rol_id)');

	    $id= NULL;

	    $query->bindParam(':id', $id);
	    $query->bindParam(':username', $nombreenelsistema);
	    $query->bindParam(':password', $contrasenia);
	    $query->bindParam(':nombre', $nombredelusuario);
	    $query->bindParam(':dnicuil', $identificador);
	    $query->bindParam(':telefono', $telefono);
	    $query->bindParam(':correo', $correo);
	    $query->bindParam(':rol_id', $rolusuario);
            
        $query->execute();
        $query = NULL;
        $conexion = NULL;

        $rolusuariotexto = "";
        switch ($rolusuario) {
        	case '1':
        		$rolusuariotexto = "Administrador";
        		break;
        	case '2':
        		$rolusuariotexto = "Becario Cantina";
        		break;
        	case '3':
        		$rolusuariotexto = "Becario Fotocopiadora";
        		break;
        	case '4':
        		$rolusuariotexto = "Vendedor de Entradas";
        		break;
        }

		$mensaje="Se cargo exitosamente el usuario " . $nombredelusuario . " con el rol " . $rolusuariotexto;
		header('location: agregarUsuario.php?info='.$mensaje);
        exit;
	}
?>
<?php 
	
	try{
		$idDelUsuarioAM = $_POST['idDelUsuarioAM'];
		$dnicuil = $_POST['dnicuil'];
		$nombre = $_POST['nombre'];
		$username = $_POST['username'];
		$rol_id = $_POST['rol_id'];
		$telefono = $_POST['telefono'];
		$password = $_POST['password'];
		$correo = $_POST['correo'];


		echo $idDelUsuarioAM . "<br>";
		echo $dnicuil . "<br>";
		echo $nombre . "<br>";
		echo $username . "<br>";
		echo $rol_id . "<br>";
		echo $telefono . "<br>";
		echo $password . "<br>";
		echo $correo . "<br>";

		if($idDelUsuarioAM == "" || $dnicuil == "" || $nombre == "" || $username == "" || $rol_id == "" || $telefono == "" || $password == "" || $correo == ""){
			
			$mensaje="Por favor, complete todos los campos.";
	        header('location: listadoDeUsuarios.php?error='.$mensaje);
	        exit;

		}else if($rol_id == 0 ){

			$mensaje="Por favor, en el campos de rol no puede ir el valor 0(cero).";
	        header('location: listadoDeUsuarios.php?error='.$mensaje);
	        exit;

		}else{
			include_once 'php/conexion.php';
		    $bd= new BD();
		    $conexion = $bd->connect();
		    $query= $conexion->prepare('UPDATE bdunertest.t_usuarios SET username = :username, password = :password, nombre = :nombre, dnicuil = :dnicuil, telefono = :telefono, correo = :correo, rol_id = :rol_id where id = :id');

		    $query->bindParam(':id', $idDelUsuarioAM);
		    $query->bindParam(':username', $username);
		    $query->bindParam(':password', $password);
		    $query->bindParam(':nombre', $nombre);
		    $query->bindParam(':dnicuil', $dnicuil);
		    $query->bindParam(':telefono', $telefono);
		    $query->bindParam(':correo', $correo);
		    $query->bindParam(':rol_id', $rol_id);
	            
	        $query->execute();
	        $query = NULL;
	        $conexion = NULL;

			$mensaje="Se actualizaron exitosamente los datos del usuario " . $nombre . " con el identificador " . $dnicuil;
			header('location: listadoDeUsuarios.php?info='.$mensaje);
	        exit;
		}
	}catch (Exception $e){
		
        $query = NULL;
        $conexion = NULL;
        switch ($e->getCode()) {
            case '23000':
                    $error="El codigo del producto que ingreso ya existe.";
                    header('Location: listadoDeUsuarios.php?error='.$error);
                    exit;
                break;
            default:
                    $error=$e->getMessage();
                    header('Location: listadoDeUsuarios.php?error='.$error);
                    exit;
                break;
        }
    }
?>
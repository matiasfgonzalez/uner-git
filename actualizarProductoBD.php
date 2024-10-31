<?php 
	
	try{
		$codigodebarra = $_POST['codigoDelProducto'];
		$nombre = $_POST['nombre'];
		$precio = $_POST['precio'];
		$stock = $_POST['stock'];
		$categoria = $_POST['categoria'];

		settype($precio, 'double');
		settype($stock, 'integer');

		echo $codigodebarra . " - " . gettype($codigodebarra) . "<br>";
		echo $nombre . " - " . gettype($nombre)  . "<br>";
		echo $precio . " - " . gettype($precio)  . "<br>";
		echo $stock . " - " . gettype($stock)  . "<br>";
		echo $categoria . " - " . gettype($categoria)  . "<br>";

		if($codigodebarra == "" || $nombre == "" || $precio == "" || $stock == "" || $categoria == ""){
			
			$mensaje="Por favor, complete todos los campos.";
	        header('location: listadoDeProductos.php?error='.$mensaje);
	        exit;

		}else if($precio == 0 || $stock == 0){

			$mensaje="Por favor, en los campos de precio y stock no puede ir el valor 0(cero).";
	        header('location: listadoDeProductos.php?error='.$mensaje);
	        exit;

		}else{
			include_once 'php/conexion.php';
		    $bd= new BD();
		    $conexion = $bd->connect();
		    $query= $conexion->prepare('UPDATE bdunertest.t_productos SET id = :id, nombre = :nombre, precio = :precio, stock = :stock, categoria = :categoria, codigodebarra = :codigodebarra where id = :id2');

		    $query->bindParam(':id', $codigodebarra);
		    $query->bindParam(':id2', $codigodebarra);
		    $query->bindParam(':nombre', $nombre);
		    $query->bindParam(':precio', $precio);
		    $query->bindParam(':stock', $stock);
		    $query->bindParam(':categoria', $categoria);
		    $query->bindParam(':codigodebarra', $codigodebarra);
	            
	        $query->execute();
	        $query = NULL;
	        $conexion = NULL;

			$mensaje="Se actualizaron exitosamente los datos del producto " . $nombre . " con el codigo " . $codigodebarra;
			header('location: listadoDeProductos.php?info='.$mensaje);
	        exit;
		}
	}catch (Exception $e){
		
	        $query = NULL;
	        $conexion = NULL;
            switch ($e->getCode()) {
                case '23000':
                        $error="El codigo del producto que ingreso ya existe.";
                        header('Location: listadoDeProductos.php?error='.$error);
                        exit;
                    break;
                default:
                        $error=$e->getMessage();
                        header('Location: listadoDeProductos.php?error='.$error);
                        exit;
                    break;
            }
    }
?>
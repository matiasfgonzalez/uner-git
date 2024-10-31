<?php 
	
	try{
		require_once "conexion.php";
		$conexion=conexion();

		$stock = $_POST['cantidadDeProductos'];
		$codigodebarra = $_POST['codigoDelProducto'];
		$precio= $_POST['precioDeProductos'];

		echo "<br>EMPTY<br>";

		if(empty($_POST['codigoDelProducto'])){
			$error="Si va a realizar una actualizacion debe de cargar el codigo de barra del producto";
			header('Location: ../actualizarStockBK.php?error='.$error);
		}else if(empty($_POST['cantidadDeProductos']) && empty($_POST['precioDeProductos'])){
			$error="Si va a realizar una actualizacion debe de cargar uno de los campos \"Cantidad entera a sumar\" o \"Nuevo precio del producto\".";
			header('Location: ../actualizarStockBK.php?error='.$error);
		}

		/*Vienen datos en las variables*/


		if(!empty($_POST['cantidadDeProductos']) && !empty($_POST['precioDeProductos'])){
			$correcto= "Se actualizaron ambos campos";
			$sql="update t_productos set stock=('$stock'+ stock), precio= '$precio'
								where codigodebarra='$codigodebarra'";
		}else if(empty($_POST['cantidadDeProductos']) && !empty($_POST['precioDeProductos'])){
			$correcto= "Se actualizo el precio del producto";
			$sql="update t_productos set precio= '$precio'
								where codigodebarra='$codigodebarra'";
		}else if (!empty($_POST['cantidadDeProductos']) && empty($_POST['precioDeProductos'])){
			$correcto= "Se actualizo el stock del producto";
			$sql="update t_productos set stock=('$stock'+ stock)
								where codigodebarra='$codigodebarra'";
		}

		if(!empty($correcto)){
		$resultado = mysqli_query($conexion,$sql);
		$correcto= "ACCION REALIZADA CORRECTAMENTE, ".$correcto;
		header('Location: ../actualizarStockBK.php?correcto='.$correcto);
		}
	}catch (Exception $e){

            switch ($e->getCode()) {
                case '23000':
                        $error="El codigo que ingreso ya existe.";
                        header('Location: ../actualizarStockBK.php?error='.$error);
                        exit;
                    break;
                default:
                        $error=$e->getMessage();
                        header('Location: ../actualizarStockBK.php?error='.$error);
                        exit;
                    break;
            }
    }
?>


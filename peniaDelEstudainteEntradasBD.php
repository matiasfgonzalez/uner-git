<?php 
	try{
		include_once 'php/conexion.php';
        $bd= new BD();
        //header('location: peniaDelEstudianteEntradas.php');

        if(isset($_POST['codigoDeLaEntrada']) && isset($_POST['precioDeLaEntradaHidden'])){
            $codigoDeLaEntrada= $_POST['codigoDeLaEntrada'];
            if($codigoDeLaEntrada == ""){
        		$mensaje="Por favor ingrese un codigo de entrada si desea registrar una venta.";
                header('location: peniaDelEstudianteEntradas.php?errore='.$mensaje);
                exit;
            }else{
                $precioDeLaEntradaHidden= $_POST['precioDeLaEntradaHidden'];
                session_start();
                $vendedor= $_SESSION['nombre'];
                $diaVendida= date("Y-m-d H:i:s");

                echo $codigoDeLaEntrada . "<br>";
                echo $precioDeLaEntradaHidden . "<br>";
                echo $vendedor . "<br>";
                echo $diaVendida . "<br>";

        		$conexion = $bd->connect();
                $query= $conexion->prepare('INSERT INTO bdunertest.t_penia_del_estudiante_entradasv VALUES 
                                (:codigoDeLaEntrada, :precioDeLaEntradaHidden, :vendedor, :diaVendida)');
            
                $query->bindParam(':codigoDeLaEntrada', $codigoDeLaEntrada);
                $query->bindParam(':precioDeLaEntradaHidden', $precioDeLaEntradaHidden);
                $query->bindParam(':vendedor', $vendedor);
                $query->bindParam(':diaVendida', $diaVendida);

                $query->execute();
        		$mensaje="Venta de la entrada registrada correctamente.";
		        
		        $query = NULL;
		        $conexion = NULL;
               
                header('location: peniaDelEstudianteEntradas.php?infoe='.$mensaje);
                exit;
            	}
	        }else if(isset($_POST['cantDeLaEntrada']) && isset($_POST['precioDeLaEntradaU'])){
	            $cantDeLaEntrada = $_POST['cantDeLaEntrada'];
	            $precioDeLaEntradaU = $_POST['precioDeLaEntradaU'];

	            if(($cantDeLaEntrada == "") && ($precioDeLaEntradaU == "")){
	        		$mensaje="Por favor ingrese una cantidad o un precio de entradas para actualizar los datos.";
	                header('location: peniaDelEstudianteEntradas.php?errorv='.$mensaje);
	                exit;
	            }else if(!($cantDeLaEntrada == "") && ($precioDeLaEntradaU == "")){
        			
        			$conexion = $bd->connect();
	                $query= $conexion->prepare('UPDATE bdunertest.t_penia_del_estudiante SET cantidadDeEntradas = :cantDeLaEntrada + cantidadDeEntradas');
	        
	                $query->bindParam(':cantDeLaEntrada', $cantDeLaEntrada);

	        		$mensaje="Se actualizaron exitosamente el stock de entradas.";
	            }else if (($cantDeLaEntrada == "") && !($precioDeLaEntradaU == "")){
	                
        			$conexion = $bd->connect();
	                $query= $conexion->prepare('UPDATE bdunertest.t_penia_del_estudiante SET precio = :precioDeLaEntradaU');
	        
	                $query->bindParam(':precioDeLaEntradaU', $precioDeLaEntradaU);

	        		$mensaje="Se actualizo exitosamente el precio de las entradas.";
	            }else{
	                
        			$conexion = $bd->connect();
	                $query= $conexion->prepare('UPDATE bdunertest.t_penia_del_estudiante SET cantidadDeEntradas = :cantDeLaEntrada + cantidadDeEntradas, precio = :precioDeLaEntradaU');
	        
	                $query->bindParam(':cantDeLaEntrada', $cantDeLaEntrada);
	                $query->bindParam(':precioDeLaEntradaU', $precioDeLaEntradaU);

	        		$mensaje="Se actualizo exitosamente el precio y el stock de las entradas.";
	            }

	            $query->execute();
	            echo "Nueva cantidad sumada: " . $cantDeLaEntrada . "<br>";
	            echo "Nuevo precio $" . $precioDeLaEntradaU . "<br>";
		        
		        $query = NULL;
		        $conexion = NULL;
		        header('Location: peniaDelEstudianteEntradas.php?infov='.$mensaje);
	        }
		}catch (Exception $e){

            switch ($e->getCode()) {
                case '23000':
                        $error="El codigo de la entrada que ingreso ya fue registrada como vendida.";
                        header('Location: peniaDelEstudianteEntradas.php?errore=' . $error);
                        exit;
                    break;
                default:
                        $error=$e->getMessage();
                        header('Location: peniaDelEstudianteEntradas.php?errore=' . $error);
                        exit;
                    break;
            }
    }
?>
<?php 
	try{
        if(isset($_POST['codigoDeLaEntrada']) && isset($_POST['precioDeLaEntradaHidden'])){
            $codigoDeLaEntrada= $_POST['codigoDeLaEntrada'];
            if($codigoDeLaEntrada == ""){
        		$mensaje="Por favor ingrese un codigo de entrada si desea registrar una venta.";
                header('location: peniaDelEstudianteEntradasCantina.php?errore='.$mensaje);
                exit;
            }else{

                include_once '../php/conexion.php';
                $bd= new BD();
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
               
                header('location: peniaDelEstudianteEntradasCantina.php?infoe='.$mensaje);
                exit;
            	}
	        }
		}catch (Exception $e){

            switch ($e->getCode()) {
                case '23000':
                        $query = NULL;
                        $conexion = NULL;
                        $error="El codigo de la entrada que ingreso ya fue registrada como vendida.";
                        header('Location: peniaDelEstudianteEntradasCantina.php?errore=' . $error);
                        exit;
                    break;
                default:
                        $query = NULL;
                        $conexion = NULL;
                        $error=$e->getMessage();
                        header('Location: peniaDelEstudianteEntradasCantina.php?errore=' . $error);
                        exit;
                    break;
            }
    }
?>
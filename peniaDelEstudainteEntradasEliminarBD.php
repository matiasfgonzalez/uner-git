<?php 
	
	try{
		if(isset($_POST['idDeLaEntradaAEliminar'])){
			$idDeLaEntradaAEliminar= $_POST['idDeLaEntradaAEliminar'];
            if($idDeLaEntradaAEliminar == ""){
        		$mensaje="Por favor ingrese un codigo de entrada si desea eliminar una.";
                header('location: peniaDelEstudianteEntradas.php?errord='.$mensaje);
                exit;
			}else{
				include_once 'php/conexion.php';
        		$bd= new BD();
        		$conexion = $bd->connect();

                $query= $conexion->prepare('DELETE FROM bdunertest.t_penia_del_estudiante_entradasv 
                								WHERE t_penia_del_estudiante_entradasv.codigo = :idDeLaEntradaAEliminar');

                $query->bindParam(':idDeLaEntradaAEliminar', $idDeLaEntradaAEliminar);

                $query->execute();
        		$mensaje="La entrada con codigo ". $idDeLaEntradaAEliminar ." eliminada correctamente.";
		        
		        $query = NULL;
		        $conexion = NULL;
               
                header('location: peniaDelEstudianteEntradas.php?infod='.$mensaje);
                exit;
			}
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
                        header('Location: peniaDelEstudianteEntradas.php?errord=' . $error);
                        exit;
                    break;
            }

	}

?>
DELETE FROM bdunertest.t_penia_del_estudiante_entradasv WHERE t_penia_del_estudiante_entradasv.codigo = :idDeLaEntradaAEliminar
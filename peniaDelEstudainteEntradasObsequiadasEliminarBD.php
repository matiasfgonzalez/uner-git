<?php 
	
	try{
		if(isset($_POST['idDeLaEntradaObsequiadaAEliminar'])){
			$idDeLaEntradaObsequiadaAEliminar= $_POST['idDeLaEntradaObsequiadaAEliminar'];
            if($idDeLaEntradaObsequiadaAEliminar == ""){
        		$mensaje="Por favor ingrese un codigo de entrada si desea eliminar una.";
                header('location: peniaDelEstudianteEntradasObsequiadas.php?errord='.$mensaje);
                exit;
			}else{
				include_once 'php/conexion.php';
        		$bd= new BD();
        		$conexion = $bd->connect();

                $query= $conexion->prepare('DELETE FROM bdunertest.t_penia_del_estudiante_entradaso 
                								WHERE t_penia_del_estudiante_entradaso.codigo = :idDeLaEntradaObsequiadaAEliminar');

                $query->bindParam(':idDeLaEntradaObsequiadaAEliminar', $idDeLaEntradaObsequiadaAEliminar);

                $query->execute();
        		$mensaje="La entrada con codigo ". $idDeLaEntradaObsequiadaAEliminar ." eliminada correctamente.";
		        
		        $query = NULL;
		        $conexion = NULL;
               
                header('location: peniaDelEstudianteEntradasObsequiadas.php?infod='.$mensaje);
                exit;
			}
		}

	}catch (Exception $e){

		switch ($e->getCode()) {
                case '23000':
                        $error="El codigo de la entrada que ingreso ya fue registrada como vendida.";
                        header('Location: peniaDelEstudianteEntradasObsequiadas.php?errore=' . $error);
                        exit;
                    break;
                default:
                        $error=$e->getMessage();
                        header('Location: peniaDelEstudianteEntradasObsequiadas.php?errord=' . $error);
                        exit;
                    break;
            }

	}

?>
DELETE FROM bdunertest.t_penia_del_estudiante_entradasv WHERE t_penia_del_estudiante_entradasv.codigo = :idDeLaEntradaObsequiadaAEliminar
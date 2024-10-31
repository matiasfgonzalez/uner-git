<?php 

	try{
		if(isset($_POST['codigoDelIncidenteHidden'])){
			$codigoDelIncidenteHidden= $_POST['codigoDelIncidenteHidden'];
            if($codigoDelIncidenteHidden == ""){
        		$mensaje="Por favor ingrese un codigo de entrada si desea eliminar una.";
                header('location: peniaFondosYMovimientos.php?errore='.$mensaje);
                exit;
			}else{
				include_once 'php/conexion.php';
        		$bd= new BD();
        		$conexion = $bd->connect();

                $query= $conexion->prepare('DELETE FROM bdunertest.t_fondosymovimientos_penia_del_estudiante 
                								WHERE t_fondosymovimientos_penia_del_estudiante.id = :codigoDelIncidenteHidden');

                $query->bindParam(':codigoDelIncidenteHidden', $codigoDelIncidenteHidden);

                $query->execute();
        		$mensaje="La entrada con codigo ". $codigoDelIncidenteHidden ." eliminada correctamente.";
		        
		        $query = NULL;
		        $conexion = NULL;
               
                header('location: peniaFondosYMovimientos.php?infoe='.$mensaje);
                exit;
			}
		}

	}catch (Exception $e){

		switch ($e->getCode()) {
                case '23000':
                        $error="Error de primary key. " . $e->getMessage();
                        header('Location: peniaFondosYMovimientos.php?errore=' . $error);
                        exit;
                    break;
                default:
                        $error=$e->getMessage();
                        header('Location: peniaFondosYMovimientos.php?errore=' . $error);
                        exit;
                    break;
            }

	}

?>
<!--DELETE FROM bdunertest.t_fondosymovimientos_penia_del_estudiante WHERE t_fondosymovimientos_penia_del_estudiante.id = :codigoDelIncidenteHidden-->
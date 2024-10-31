<?php 
	try{

        if(isset($_POST['codigoDeLaEntradaObsequiada'])){
            $codigoDeLaEntradaObsequiada= $_POST['codigoDeLaEntradaObsequiada'];
            if($codigoDeLaEntradaObsequiada == ""){
        		$mensaje="Por favor ingrese un codigo de entrada si desea registrarla.";
                header('location: peniaDelEstudianteEntradasObsequiadas.php?errore='.$mensaje);
                exit;
            }else{
                session_start();
                $obsequiador= $_SESSION['nombre'];
                $diaObsequiada= date("Y-m-d H:i:s");

                echo $codigoDeLaEntradaObsequiada . "<br>";
                echo $obsequiador . "<br>";
                echo $diaObsequiada . "<br>";
                
                include_once 'php/conexion.php';
                $bd= new BD();

        		$conexion = $bd->connect();
                $query= $conexion->prepare('INSERT INTO bdunertest.t_penia_del_estudiante_entradaso VALUES 
                                (:codigoDeLaEntradaObsequiada, :obsequiador, :diaObsequiada)');
            
                $query->bindParam(':codigoDeLaEntradaObsequiada', $codigoDeLaEntradaObsequiada);
                $query->bindParam(':obsequiador', $obsequiador);
                $query->bindParam(':diaObsequiada', $diaObsequiada);

                $query->execute();
        		$mensaje="Carga de la entrada registrada correctamente.";
		        
		        $query = NULL;
		        $conexion = NULL;
               
                header('location: peniaDelEstudianteEntradasObsequiadas.php?infoe='.$mensaje);
                exit;
            	}
	        }
		}catch (Exception $e){

            switch ($e->getCode()) {
                case '23000':
                        $error="El codigo de la entrada que ingreso ya fue registrada.";
                        header('Location: peniaDelEstudianteEntradasObsequiadas.php?errore=' . $error);
                        exit;
                    break;
                default:
                        $error=$e->getMessage();
                        header('Location: peniaDelEstudianteEntradasObsequiadas.php?errore=' . $error);
                        exit;
                    break;
            }
    }
?>
<?php

    try
    {
        $fecha= $_POST['fechai'];
        $saldo= $_POST['saldoi'];
        $tipoincidente= $_POST['tipoincidente'];     
        $desc= $_POST['desc'];

        if($fecha == "" || $saldo == "" || $tipoincidente == "so" || $desc == "")
        {   
            $error="Complete todos los campos.";
            header('Location: agregarNuevoIncidenteCEFCA.php?error='.$error);
            exit;
        }else{
            

            if($tipoincidente=='salida'){
                $saldo=$saldo*-1;
            }

            session_start();
            $usuario= $_SESSION['nombre'];
            echo $fecha . "<br>";
            echo $saldo . "<br>";
            echo $tipoincidente . "<br>";
            echo $desc . "<br>";
            echo $usuario . "<br>";
            $id= null;
            include_once 'php/conexion.php';
                $bd= new BD();
                $conexion = $bd->connect();
                $query= $conexion->prepare('INSERT INTO bdunertest.t_fondosymovimientos_cefca VALUES 
                                    (:id ,:fecha , :descripcion, :tipo, :saldo, :usuario)');
                
                $query->bindParam(':id', $id);
                $query->bindParam(':fecha', $fecha);
                $query->bindParam(':descripcion', $desc);
                $query->bindParam(':tipo', $tipoincidente);
                $query->bindParam(':saldo', $saldo);
                $query->bindParam(':usuario', $usuario);
                $query->execute();
                $query = NULL;
                $conexion = NULL;
                $error="Carga exitosa del incidente.";
                header('Location: agregarNuevoIncidenteCEFCA.php?info='.$error);
                exit;
        }
    }catch (Exception $e){
        
        $query = NULL;
        $conexion = NULL;
        switch ($e->getCode()) {
            case '23000':
                    $error="El codigo del producto que ingreso ya existe.";
                    header('Location: agregarNuevoIncidenteCEFCA.php?error='.$error);
                    exit;
                break;
            default:
                    $error=$e->getMessage();
                    header('Location: agregarNuevoIncidenteCEFCA.php?error='.$error);
                    exit;
                break;
        }
    }
?>
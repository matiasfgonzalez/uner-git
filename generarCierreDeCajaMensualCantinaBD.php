<?php 
  $mesi = $_POST['mesi'];
  $añoi = $_POST['añoi'];
// Verificar que no vengan vacios
  if($mesi == "" || $añoi == "")
    {   
        $error="Complete todos los campos.";
        header('Location: agregarNuevoIncidenteCantina.php?error='.$error);
    }else{
        switch ($mesi) {
                case '1':
                    $variableMes = "Enero";
                    break;
                case '2':
                    $variableMes = "Febrero";
                    break;
                case '3':
                    $variableMes = "Marzo";
                    break;
                case '4':
                    $variableMes = "Abril";
                    break;
                case '5':
                    $variableMes = "Mayo";
                    break;
                case '6':
                    $variableMes = "Junio";
                    break;
                case '7':
                    $variableMes = "Julio";
                    break;
                case '8':
                    $variableMes = "Agosto";
                    break;
                case '9':
                    $variableMes = "Septiembre";
                    break;
                case '10':
                    $variableMes = "Octubre";
                    break;
                case '11':
                    $variableMes = "Noviembre";
                    break;
                case '12':
                    $variableMes = "Diciembre";
                    break;
            }
        $id= null;
        $desc="Recaudacion total del mes de " . $variableMes . " del año " . $añoi;
        $tipoincidente = "entrada";
        session_start();
        $usuario= $_SESSION['nombre'];
        $fecha = date("Y-m-d");


        include_once 'php/conexion.php';
        $bd= new BD();
        $conexion = $bd->connect();
        
        //Total del mes
        $query1= $conexion->prepare("select sum(precio) as totalmes from bdunertest.t_productosv 
                  where month(fechaDeVendido) = '$mesi' and year(fechaDeVendido) = '$añoi' and categoria = 'Cantina'  ");
                  $query1->execute();
                  foreach ($query1 as $sumatotal) {
                    $saldo= $sumatotal['totalmes'];
                  }
        if(is_null($saldo)){
            $error="No hay saldo para la fecha que ingreso.";
            header('Location: agregarNuevoIncidenteCantina.php?error='.$error);
        }else{
            $query1->execute();

            $query= $conexion->prepare('INSERT INTO bdunertest.t_fondosymovimientos_cantina VALUES 
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
                    
            echo "Mes que llega: " . $mesi . "<br>";
            echo "Año que llega: " . $añoi . "<br>";
            echo "Id: " . $id . "<br>";
            echo "Descripcion: " . $desc . "<br>";
            echo "Tipo de incidente: " . $tipoincidente . "<br>";
            echo "Usuario: " . $usuario . "<br>";
            echo "Saldo $: " . $saldo . "<br>";
            echo "Fecha : " . $fecha . "<br>";

            $error="Cierre de caja generado con exito.";
            header('Location: agregarNuevoIncidenteCantina.php?info='.$error);
        }
    }
?>
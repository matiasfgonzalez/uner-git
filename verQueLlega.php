<?php

    /* 
    incidentes
    $fechaincidente= $_POST['fechai'];
    $saldoincidente= $_POST['saldoi'];
    $tipo= $_POST['tipoincidente'];
    $desc= $_POST['desc'];

    if($tipo=='salida') 
        $saldoincidente=$saldoincidente*-1;
    
    print_r(date_parse($fechaincidente));
    echo "<br>";
    print_r(date_parse(date("Y-m-d")));

    if(date_parse(date("Y-m-d"))['day']==date_parse($fechaincidente)['day'] ){
        echo "<br> Dias iguales <br>";
    }else{
        echo "<br> Dias Distintos <br>";
    }
    if(date_parse(date("Y-m-d"))['month']==date_parse($fechaincidente)['month'] ){
        echo "<br> Meses iguales <br>";
    }else{
        echo "<br> Meses Distintos <br>";
    }
    if(date_parse(date("Y-m-d"))['year']==date_parse($fechaincidente)['year'] ){
        echo "<br> Años iguales <br>";
    }else{
        echo "<br> Años Distintos <br>";
    }



    //echo $nuevaFecha=date_parse($fechaincidente)['year']."-". date_parse($fechaincidente)['month']."-". date_parse($fechaincidente)['day'];
    

    echo "<br>";
    echo $fechaincidente . "<br>";
    echo $saldoincidente . "<br>";
    echo $tipo . "<br>";
    echo $desc. "<br>";
    echo $_POST['precio'] . "<br>";
    echo $_POST['stock'] . "<br>";
    echo $_POST['categoria'] . "<br>";
    



   

        include_once 'php/conexion.php';
        $bd= new BD();
        $conexion = $bd->connect();
        //header('location: peniaDelEstudianteEntradas.php');

        if(isset($_POST['codigoDeLaEntrada']) && isset($_POST['precioDeLaEntradaHidden'])){
            $codigoDeLaEntrada= $_POST['codigoDeLaEntrada'];
            if($codigoDeLaEntrada == ""){
                header('location: peniaDelEstudianteEntradas.php');
            }else{
                $precioDeLaEntradaHidden= $_POST['precioDeLaEntradaHidden'];
                session_start();
                $vendedor= $_SESSION['nombre'];
                $diaVendida= date("Y-m-d H:i:s");

                echo $codigoDeLaEntrada . "<br>";
                echo $precioDeLaEntradaHidden . "<br>";
                echo $vendedor . "<br>";
                echo $diaVendida . "<br>";

                $query= $conexion->prepare('INSERT INTO bdunertest.t_penia_del_estudiante_entradasv VALUES 
                                (:codigoDeLaEntrada, :precioDeLaEntradaHidden, :vendedor, :diaVendida)');
            
                $query->bindParam(':codigoDeLaEntrada', $codigoDeLaEntrada);
                $query->bindParam(':precioDeLaEntradaHidden', $precioDeLaEntradaHidden);
                $query->bindParam(':vendedor', $vendedor);
                $query->bindParam(':diaVendida', $diaVendida);

                $query->execute();
            }

        }else if(isset($_POST['cantDeLaEntrada']) && isset($_POST['precioDeLaEntradaU'])){
            $cantDeLaEntrada = $_POST['cantDeLaEntrada'];
            $precioDeLaEntradaU = $_POST['precioDeLaEntradaU'];

            if(($cantDeLaEntrada == "") && ($precioDeLaEntradaU == "")){
                header('location: peniaDelEstudianteEntradas.php');
            }else if(!($cantDeLaEntrada == "") && ($precioDeLaEntradaU == "")){
                $query= $conexion->prepare('UPDATE bdunertest.t_penia_del_estudiante SET cantidadDeEntradas = :cantDeLaEntrada + cantidadDeEntradas');
        
                $query->bindParam(':cantDeLaEntrada', $cantDeLaEntrada);
            }else if (($cantDeLaEntrada == "") && !($precioDeLaEntradaU == "")){
                $query= $conexion->prepare('UPDATE bdunertest.t_penia_del_estudiante SET precio = :precioDeLaEntradaU');
        
                $query->bindParam(':precioDeLaEntradaU', $precioDeLaEntradaU);
            }else{
                $query= $conexion->prepare('UPDATE bdunertest.t_penia_del_estudiante SET cantidadDeEntradas = :cantDeLaEntrada + cantidadDeEntradas, precio = :precioDeLaEntradaU');
        
                $query->bindParam(':cantDeLaEntrada', $cantDeLaEntrada);
                $query->bindParam(':precioDeLaEntradaU', $precioDeLaEntradaU);
            }

            $query->execute();
            echo "Nueva cantidad sumada: " . $cantDeLaEntrada . "<br>";
            echo "Nuevo precio $" . $precioDeLaEntradaU . "<br>";
        }
        
        $query = NULL;
        $conexion = NULL;
        */

        echo $_POST['usuarioReporteEntradas'];
?>
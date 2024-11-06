<?php

try {
    $nombre = $_POST['nombreDelProducto'];
    $categoria = $_POST['categoriaDelProducto'];
    $precio = $_POST['precioDelProducto'];
    $stock = $_POST['stockDelProducto'];
    $codigo = $_POST['codigoDeBarraDelProducto'];

    if ($nombre == "" || $categoria == "so" || $precio == "" || $stock == "" || $codigo == "") {
        $error = "Complete todos los campos.";
        header('Location: agregarProducto.php?error=' . $error);
        exit;
    } else {

        echo $nombre . "<br>";
        echo $categoria . "<br>";
        echo $precio . "<br>";
        echo $stock . "<br>";
        echo $codigo . "<br>";

        include_once 'php/conexion.php';
        $bd = new BD();
        $conexion = $bd->connect();
        $query = $conexion->prepare('INSERT INTO bdunertest.t_productos VALUES 
                                (:id ,:nombre, :precio, :stock, :categoria, :codigodebarra)');

        $query->bindParam(':id', $codigo);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':precio', $precio);
        $query->bindParam(':stock', $stock);
        $query->bindParam(':categoria', $categoria);
        $query->bindParam(':codigodebarra', $codigo);


        $query->execute();
        $query = NULL;
        $conexion = NULL;

        $info = "Se agrego el producto correctamente";
        header('Location: agregarProducto.php?info=' . $info);
        exit;
    }
} catch (Exception $e) {

    $query = NULL;
    $conexion = NULL;
    switch ($e->getCode()) {
        case '23000':
            $error = "El codigo del producto que ingreso ya existe.";
            header('Location: agregarProducto.php?error=' . $error);
            exit;
            break;
        default:
            $error = $e->getMessage();
            header('Location: agregarProducto.php?error=' . $error);
            exit;
            break;
    }
}

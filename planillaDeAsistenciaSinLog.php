<?php 
  
  session_start();
  if (isset($_SESSION['rol'])){
    header('location: php/definirRutas.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema CEFCA - Planilla de asistencia</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body class="bg-gradient-primary">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <a type="button" role="button" class="btn btn-dark" href="index.php">Volver al inicio</a>
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!--Cantina y fotocopiadora-->
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" style="text-align: center;">
                        <thead style= "background: black;">
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Entrada</th>
                            <th scope="col">Salida</th>
                            <th scope="col">Caja Entrada</th>
                            <th scope="col">Caja Salida</th>
                            <th scope="col">Recaudacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                include_once 'php/conexion.php';
                                $bd= new BD();
                                $conexion = $bd->connect();
                                $query= $conexion->prepare('select * from bdunertest.t_planilladeasistencias order by horariodesalida desc limit 1');

                                $query->execute();
                                foreach ($query as $currentUser) { ?>
                                <tr>
                                <td><?php echo $currentUser['nomyape']; ?></td>
                                <td>Cantina</td>
                                <td><?php echo $currentUser['horariodeentrada']; ?></td>
                                <td><?php echo $currentUser['horariodesalida']; ?></td>
                                <td>$ <?php echo $currentUser['cajainicial']; ?></td>
                                <td>$ <?php echo $currentUser['cajafinal']; ?></td>
                                <td>$ <?php echo $currentUser['recaudado']; ?></td>
                                </tr>
                            <?php }
                            ?>
                            <?php
                                $query= $conexion->prepare('select * from bdunertest.t_planilladeasistencias order by horariodesalida desc limit 1');

                                $query->execute();
                                foreach ($query as $currentUser) { ?>
                                <tr>
                                <td><?php echo $currentUser['nomyape']; ?></td>
                                <td>Fotocopiadora</td>
                                <td><?php echo $currentUser['horariodeentrada']; ?></td>
                                <td><?php echo $currentUser['horariodesalida']; ?></td>
                                <td>$ <?php echo $currentUser['cajainicial']; ?></td>
                                <td>$ <?php echo $currentUser['cajafinal']; ?></td>
                                <td>$ <?php echo $currentUser['recaudado']; ?></td>
                                </tr>
                            <?php }
                            $query=null;
                            $conexion=null;
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

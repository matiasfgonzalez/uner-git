<?php 

  session_start();

  if(!isset($_SESSION['username'])){
    $errorLogin= "Debe registrarse primero<br>";
    header('location: ../login.php?errorLogin='.$errorLogin);
  }{
    if($_SESSION['rol'] != 1){
    header('location: php/definirRutas.php');  
    }
  }
  include_once 'php/conexion.php';
  $bd= new BD();
  $conexion = $bd->connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Administrador - Peña del estudiante - Fondos y movimientos</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php 
      include 'navegacionLateral.php'; 
    ?>

     <!--Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include 'topbar.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Fondos y movimientos de la Peña</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Productos</h6>
              <?php if(isset($_GET['infoe'])){ ?>
                <div class="alert alert-success" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['infoe'])){
                        echo $_GET['infoe'];
                      }
                  ?>
                </div>
              <?php } ?>
              <?php if(isset($_GET['errore'])){ ?>
                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['errore'])){
                        echo $_GET['errore'];
                      }
                  ?>
                </div>
              <?php } ?>
              <div style="display: grid;">
                <a class="btn btn-success" href="agregarNuevoIncidentePenia.php" role="button">
                  <i class="fas fa-plus-circle"></i> Agregar nuevo incidente
                </a>
              </div>
              <hr>
              <div class="container">
                <?php

                  // queryT para traet el total de entradas vendidas hasta el momento y se guarda lo recaudado en la variable $totalVendido
                    $queryT= $conexion->prepare("SELECT sum(precio) as totalVendido FROM bdunertest.t_penia_del_estudiante_entradasv");
                    $queryT->execute();
                    foreach ($queryT as $ver) {
                      $totalVendido = $ver['totalVendido']; 
                    }
                    $queryT = NULL;

                  // queryU para actualizar la fila de el monto de entradas vendida hasta el momento 
                    $fechaU = date("Y-m-d");
                    $queryU= $conexion->prepare("UPDATE bdunertest.t_fondosymovimientos_penia_del_estudiante SET fecha = '$fechaU' , saldo = '$totalVendido'  
                      WHERE t_fondosymovimientos_penia_del_estudiante.id = '6'");
                    $queryU->execute();
                    $queryU = NULL;


                  $query1= $conexion->prepare("select sum(saldo) as totalEntrada from bdunertest.t_fondosymovimientos_penia_del_estudiante where tipo = 'entrada'");
                  $query2= $conexion->prepare("select sum(saldo) as totalSalida from bdunertest.t_fondosymovimientos_penia_del_estudiante where tipo = 'salida'");
                  $query3= $conexion->prepare("select sum(saldo) as totalES from bdunertest.t_fondosymovimientos_penia_del_estudiante");
                  $query1->execute();
                  $query2->execute();
                  $query3->execute();
                ?>
                <div class="row" style="display: flex;">
                  <div class="col-sm">
                    <h5>Fondos: $ <?php foreach ($query3 as $ver) { echo number_format($ver['totalES'],2,",","."); } ?></h5>
                  </div>
                  <div class="col-sm">
                    <h6>Total entradas: $ <?php foreach ($query1 as $ver) { echo number_format($ver['totalEntrada'],2,",","."); } ?></h6>
                  </div>
                  <div class="col-sm">
                    <h6>Total salidas: $ <?php foreach ($query2 as $ver) { echo number_format($ver['totalSalida'],2,",","."); } ?></h6>
                  </div>
              </div>
            </div>
            <hr>
            <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Descripcion</th>
                      <th>Tipo (E/S)</th>
                      <th>Saldo</th>
                      <th style="text-align: center;">Eliminar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Fecha</th>
                      <th>Descripcion</th>
                      <th>Tipo (E/S)</th>
                      <th>Saldo</th>
                      <th style="text-align: center;">Eliminar</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      $query= $conexion->prepare("select * from bdunertest.t_fondosymovimientos_penia_del_estudiante order by id desc");
                      $query->execute();
                      foreach ($query as $ver) { ?>
                    <tr>
                      <td><?php echo $ver['fecha'];?></td>
                      <td><?php echo $ver['descripcion']; ?></td>
                      <td><?php echo $ver['tipo']; ?></td>
                      <td>$<?php echo number_format($ver['saldo'],2,",","."); ?></td>
                      <td style="text-align: center;">
                        <?php if($ver['id'] != 6) 
                          { 
                        ?>
                            <form action="peniaFondosYMovimientosEliminarBD.php" method="post">
                              <input type="number" name="codigoDelIncidenteHidden" hidden value="<?php echo $ver['id'] ?>">
                              <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        <?php 
                          }else{
                        ?>
                            <h6>
                              No se puede eliminar
                            </h6>
                        <?php  
                          } 
                        ?>
                      </td>
                    </tr>
                  <?php 
                    }
                    $query1 = NULL;
                    $query2 = NULL;
                    $query3 = NULL;
                    $query = NULL;
                    $conexion = NULL;
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
	       </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Desarrollo 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="php/logout.php">Cerrar sesión</a>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>

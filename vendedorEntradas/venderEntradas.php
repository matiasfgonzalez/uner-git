<?php 

  session_start();

  if(!isset($_SESSION['username'])){
    $errorLogin= "Debe registrarse primero<br>";
    header('location: ../login.php?errorLogin='.$errorLogin);
  }{
    if($_SESSION['rol'] != 4){
    header('location: ../php/definirrutas.php');  
    }
  }
  include_once '../php/conexion.php';
    $bd= new BD();
    $conexion = $bd->connect();

  // Total de entradas y precio actual
    $queryp= $conexion->prepare("select cantidadDeEntradas, precio from bdunertest.t_penia_del_estudiante");
    $queryp->execute();
    foreach ($queryp as $penia) {

      $cantidadDeEntradas = $penia['cantidadDeEntradas'];
      $precio = $penia['precio'];
    }
?>
<!DOCTYPE html>
<html lang="en" style="background-image: url(img/entradas.jpg);">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Vendedor de entradas</title>

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

     <!--Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column"
    style="background-image: url(img/entradas.jpg);">

      <!-- Main Content -->
      <div id="content">

        <?php include 'topbarVE.php' ?>

        <!-- Begin Page Content -->
        <div class="container" style=" background-color: white; padding-bottom: 1.0rem; padding-top: 1.5rem;">
          
          <!-- Page Heading -->
          <div class="row">
            <div class="col-sm-12">
              <h1 class="h3 mb-2 text-gray-800">Realizar venta de entrada</h1>
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
              <form method="POST" action="venderEntradasBD.php">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Codigo de la entrada</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-ticket-alt"></i></div>
                      </div>
                    <input type="number" class="form-control" id="inputEmail4" placeholder="" name="codigoDeLaEntrada" autofocus>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputCity">Precio</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">$</div>
                      </div>
                      <input type="number" disabled class="form-control" id="inputCity" name="precioDeLaEntrada" 
                      value="<?php echo $precio ?>">
                      <input type="hidden" id="" name="precioDeLaEntradaHidden" value="<?php echo $precio ?>">
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-success">Vender</button>
              </form>
            </div>
          </div>
          
          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listado de entradas vendidas</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Entradas
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Precio</th>
                      <th>Vendedor</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Codigo</th>
                      <th>Precio</th>
                      <th>Vendedor</th>
                      <th>Fecha</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                      $vendedorS = $_SESSION['nombre'];
                      $conexion = $bd->connect();
                      $query= $conexion->prepare("select * from bdunertest.t_penia_del_estudiante_entradasv 
                        where vendedor = '$vendedorS'
                        ORDER BY t_penia_del_estudiante_entradasv.diaVendida desc");
                      $query->execute();

                      foreach ($query as $ver){
                    ?>
                    <tr>
                      <td><?php echo $ver['codigo']; ?></td>
                      <td>$ <?php echo $ver['precio']; ?></td>
                      <td><?php echo $ver['vendedor']; ?></td>
                      <td><?php echo $ver['diaVendida']; ?></td>
                    </tr>
                    <?php
                      }
                      $conexion = NULL;
                      $query = NULL;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <br>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white" style="position: absolute; bottom: 0; width: 100%; height: 0%;">
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
          <a class="btn btn-primary" href="../php/logout.php">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/datatables-demo.js"></script>

</body>

</html>

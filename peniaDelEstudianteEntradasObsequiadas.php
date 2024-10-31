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
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Administrador - Peña del estudiante - Entradas obsequiadas</title>

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
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
              <h1 class="h3 mb-2 text-gray-800">Codigo de entrada</h1>
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
              <form method="POST" action="peniaDelEstudainteEntradasObsequiadasBD.php">
                <div class="form-row">
                  <div class="form-group col-md">
                    <label for="inputEmail4">Codigo de la entrada</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-ticket-alt"></i></div>
                      </div>
                    <input type="number" class="form-control" id="inputEmail4" placeholder="" name="codigoDeLaEntradaObsequiada" autofocus>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
              </form>
            </div>

            <!-- Eliminar entradas mal vendidas-->
            <div class="col-sm-12 col-md-12 col-lg-6">
              <h1 class="h3 mb-2 text-gray-800">Eliminar entradas mal cargadas</h1>
              <?php if(isset($_GET['infod'])){ ?>
                <div class="alert alert-success" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['infod'])){
                        echo $_GET['infod'];
                      }
                  ?>
                </div>
              <?php } ?>
              <?php if(isset($_GET['errord'])){ ?>
                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['errord'])){
                        echo $_GET['errord'];
                      }
                  ?>
                </div>
              <?php } ?>
              <form method="POST" action="peniaDelEstudainteEntradasObsequiadasEliminarBD.php">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Codigo de la entrada</label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-ticket-alt"></i></div>
                      </div>
                      <input type="number" class="form-control" id="inputEmail4" placeholder="" name="idDeLaEntradaObsequiadaAEliminar">
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-danger">Eliminar</button>
              </form>
            </div>
            <!-- Eliminar entradas mal vendidas-->
          </div>
          
          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Listado de entradas Obsequiadas</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Entradas 
                <a target="_Blank" href="vendor/fpdf/scripts/reporteTipoObsequiadasX.php" role="button">
                  <i class="far fa-file-pdf"></i>
                </a>
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Obsequiador</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Codigo</th>
                      <th>Obsequiador</th>
                      <th>Fecha</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php  
                      include_once 'php/conexion.php';
                      $bd= new BD();
                      $conexion = $bd->connect();

                      $query= $conexion->prepare('select * from bdunertest.t_penia_del_estudiante_entradaso');
                      $query->execute();
                      foreach ($query as $ver){
                    ?>
                    <tr>
                      <td><?php echo $ver['codigo']; ?></td>
                      <td><?php echo $ver['obsequiador']; ?></td>
                      <td><?php echo $ver['diaObsequiada']; ?></td>
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

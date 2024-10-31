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

  <title>Administrador - Peña del estudiante - Reporte de entradas</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
          <h1 class="h3 mb-4 text-gray-800">Reporte de entradas</h1>
              <?php if(isset($_GET['info'])){ ?>
                <div class="alert alert-success" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['info'])){
                        echo $_GET['info'];
                      }
                  ?>
                </div>
              <?php } ?>
              <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['error'])){
                        echo $_GET['error'];
                      }
                  ?>
                </div>
              <?php } ?>

          <form method="POST" action="vendor/fpdf/scripts/reporteEntradasPorUsuario.php" target="blank">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputCity">Vendedor</label>
                <select class="form-control" id="exampleFormControlSelect1" name="usuarioReporteEntradas"> 
                    <option value="so">Elija una opcion</option>
                    <?php 
                      include_once 'php/conexion.php';
                      $bd= new BD();
                      $conexion = $bd->connect();
                      
                      //Total del mes
                      $query= $conexion->prepare("SELECT vendedor FROM bdunertest.t_penia_del_estudiante_entradasv GROUP BY vendedor");
                      $query->execute();
                       foreach ($query as $usuarios) {
                    ?>
                    <option value="<?php echo $usuarios['vendedor']; ?>"><?php echo $usuarios['vendedor']; ?></option>
                    <?php 
                      }
                      $query = NULL;
                      $conexion = NULL; 
                    ?>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Generar</button>
          </form>
      <!-- Divider -->
      <hr class="sidebar-divider">

          <form method="POST" action="vendor/fpdf/scripts/reporteEntradasPorDPV.php" target="blank">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputCity">Por dia, precio y vendedor</label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Generar</button>
          </form>

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

</body>

</html>

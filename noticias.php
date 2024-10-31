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

  <title>Administrador - Noticias</title>

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
          <h1 class="h3 mb-4 text-gray-800">Recaudaciones</h1>
          <!-- Content Row -->
          <div class="row">
            
            <?php 
              include_once 'php/conexion.php';
              $bd= new BD();
              $conexion = $bd->connect();
              
              //Total del mes
              $query1= $conexion->prepare("select sum(precio) as totalmes from bdunertest.t_productosv 
              where month(fechaDeVendido) = month(NOW()) and year(fechaDeVendido) = year(NOW())");
              $query1->execute();
              foreach ($query1 as $sumatotal) {
                $totalmes= $sumatotal['totalmes'];
              }
              
              //Total del dia anterior cantina
              $query2= $conexion->prepare("select sum(precio) as totaldiaanteriorcantina from bdunertest.t_productosv 
              where categoria = 'Cantina' and 
                    year(fechaDeVendido) = year(NOW()) and
                    month(fechaDeVendido) = month(NOW()) and 
                    day(fechaDeVendido) = day(NOW() - INTERVAL 1 DAY)" );
              $query2->execute();
              foreach ($query2 as $sumatotal) {
                $totaldiaanteriorcantina= $sumatotal['totaldiaanteriorcantina'];
              }

              //Total del dia anterior fotocopiadora
              $query3= $conexion->prepare("select sum(precio) as totaldiaanteriorfotocopiadora from bdunertest.t_productosv 
              where categoria = 'Fotocopiadora' and 
                    year(fechaDeVendido) = year(NOW()) and
                    month(fechaDeVendido) = month(NOW()) and 
                    day(fechaDeVendido) = day(NOW() - INTERVAL 1 DAY)" );
              $query3->execute();
              foreach ($query3 as $sumatotal) {
                $totaldiaanteriorfotocopiadora= $sumatotal['totaldiaanteriorfotocopiadora'];
              }
              
            $query1= NULL;
            $query2= NULL;
            $query3= NULL;

            ?>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recaudacion del mes hasta el dia de la fecha</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$
                        <?php
                        if(is_null($totalmes)){ 
                          echo "0";
                        }else{
                            echo $totalmes;
                          }
                        ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recaudacion del dia de ayer</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo ($totaldiaanteriorcantina + $totaldiaanteriorfotocopiadora);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recaudacion del dia de ayer del Cantina</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$
                          <?php
                          if(is_null($totaldiaanteriorcantina)){ 
                            echo "0";
                          }else{
                              echo $totaldiaanteriorcantina;
                            }
                          ?>
                        </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Recaudacion del dia de ayer de fotocopiadora</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$
                            <?php
                            if(is_null($totaldiaanteriorfotocopiadora)){ 
                              echo "0";
                            }else{
                                echo $totaldiaanteriorcantina;
                              }
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Productos de bajo stock</h1>
          <!-- Content Row -->
          <div class="row">
          <?php
            $query= $conexion->prepare('select * from bdunertest.t_productos where stock < 11');

            $query->execute();
            //echo $numeroRegistro= $query->rowCount();
          ?>
            <!-- Earnings (Monthly) Card Example -->
            <?php foreach ($query as $currentUser) { ?>
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                          <?php
                            echo $currentUser['nombre'];
                          ?>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php
                            echo $currentUser['stock'];
                          ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php }
            $query= NULL;
            $conexion= NULL; ?>
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

</body>

</html>

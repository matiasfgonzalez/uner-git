<?php
  session_start();

  if(!isset($_SESSION['username'])){
    $errorLogin= "Debe registrarse primero<br>";
    header('location: ../login.php?errorLogin='.$errorLogin);
  }{
    if($_SESSION['rol'] != 2){
    header('location: ../php/definirRutas.php');  
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

  <title>Cantina - Actualizar productos</title>

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

    <?php 
      include 'navegacionLateralBK.php';
    ?>

     <!--Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include 'topbarBK.php' ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Actualizar stock</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Productos</h6>
              <?php if(isset($_GET['error'])){ ?>
                <div class="alert alert-danger" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['error'])){
                        echo $_GET['error'];
                      }
                  ?>
                </div>
              <?php } ?>
              <?php if(isset($_GET['correcto'])){ ?>
                <div class="alert alert-success" role="alert" style="text-align: center;">
                  <?php 
                    if(isset($_GET['correcto'])){
                        echo $_GET['correcto'];
                      }
                  ?>
                </div>
              <?php } ?>
              <form class="col-md" action="php/actualizardatos.php" method="POST">
                    <div class="form-row">
                      <div class="form-group col-md">
                        <label for="inputEmail4">Codigo del producto a modificar</label>
                        <input type="number" autofocus class="form-control" id="inputEmail4" placeholder="" name="codigoDelProducto">
                      </div>
                      <div class="form-group col-md">
                        <label for="inputEmail4">Cantidad entera a sumar</label>
                        <input type="number" class="form-control" id="inputEmail4" placeholder="" name="cantidadDeProductos">
                      </div>
                      <div class="form-group col-md">
                        <label for="inputEmail4">Nuevo precio del producto</label>
                        <input type="number" step="any" class="form-control" id="inputEmail4" placeholder="" name="precioDeProductos">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-warning">Modificar</button>
                  </form>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Precio</th>
                      <th>Stock</th>
                      <th>Categoria</th>
                      <th>Codigo de barra</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nombre</th>
                      <th>Precio</th>
                      <th>Stock</th>
                      <th>Categoria</th>
                      <th>Codigo de barra</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      include_once '../php/conexion.php';
                      $bd= new BD();
                      $conexion = $bd->connect();
                      $query= $conexion->prepare('select * from bdunertest.t_productos');
                      $query->execute();
                      foreach ($query as $ver) {                    ?>
                    <tr>
                      <td><?php echo $ver['nombre']; ?></td>
                      <td>$ <?php echo $ver['precio']; ?></td>                      
                      <td><?php echo $ver['stock'];?> </td>
                      <td><?php echo $ver['categoria']; ?></td>
                      <td><?php echo $ver['codigodebarra']; ?></td>
                    </tr>
                  <?php 
                    }
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
          <a class="btn btn-primary" href="../login.php">Cerrar sesión</a>
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

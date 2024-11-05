<?php

session_start();

if (!isset($_SESSION['username'])) {
  $errorLogin = "Debe registrarse primero<br>";
  header('location: ../login.php?errorLogin=' . $errorLogin);
} {
  if ($_SESSION['rol'] != 2) {
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

  <title>Cantina - Vender</title>
  <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- js mios -->
  <script type="text/javascript" src="js/funciones.js"></script>
  <script type="text/javascript" src="librerias/bootstrap/js/bootstrap.js"></script>
  <script type="text/javascript" src="librerias/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="librerias/alertifyjs/alertify.js"></script>

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

          <!-- Page Heading 
          <h1 class="h3 mb-4 text-gray-800">Ventas</h1>-->

          <div class="modal-body">
            <label>Codigo de barra</label>
            <form>
              <div style="display: flex;">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-barcode"></i></div>
                  </div>
                  <input type="number" name="" class="form-control input-sm" id="codigodebarra" autofocus>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="agregarnuevo">Agregar</button>
              </div>
            </form>
          </div>
          <div id="tabla">
          </div>
          <!-- Modal para nuevos -->
          <!-- Modal -->
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

</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabla').load('componentes/tabla.php');
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#agregarnuevo').click(function() {
      codigodebarra = $('#codigodebarra').val();
      agregardatos(codigodebarra);
      $('#codigodebarra').val('');
      $('#codigodebarra').focus();
    });

    $('#actualizardatos').click(function() {
      actualizadatos();
    });

  });
</script>
<!-- Captura los eventos del teclado el enter y la q-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#codigodebarra").keypress(function(e) {
      if (e.which == 13) {
        codigodebarra = $('#codigodebarra').val();
        agregardatos(codigodebarra);
        $('#codigodebarra').val('');
        $('#codigodebarra').focus();
      }
      if (e.which == 113) {
        confirmarventa();
      }
    });
  });
</script>
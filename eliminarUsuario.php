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

    if($_POST['codigoDelUsuarioe'] != "")
    {
      include_once 'php/conexion.php';
      $bd= new BD();
      $conexion = $bd->connect();
      $codigoDelUsuarioe = $_POST['codigoDelUsuarioe'];
      $query= $conexion->prepare("select * from bdunertest.t_usuarios where dnicuil = ?");
      $query->bindParam(1, $codigoDelUsuarioe, PDO::PARAM_INT);
      $query->execute();
      if($query->rowCount() > 0) 
        {
          foreach ($query as $ver) 
            {
              $id = $ver['id'];
              $username = $ver['username'];
              $password = $ver['password'];
              $nombre = $ver['nombre'];
              $dnicuil = $ver['dnicuil'];
              $telefono = $ver['telefono'];
              $correo = $ver['correo'];
              $rol_id = $ver['rol_id'];
            }
        }else{
          $error="Ingrese un DNI/Cuil de usuario valido.";
          header('Location: listadoDeUsuarios.php?error='.$error);
          exit;
        }
    }else{

      $error="Ingrese un DNI/Cuil de usuario.";
      header('Location: listadoDeUsuarios.php?error='.$error);
      exit;
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

  <title>Administrador - Usuarios - Eliminar</title>

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
          <h1 class="h3 mb-4 text-gray-800">Eliminar usuario del sistema</h1>
          <form action="eliminarUsuarioBD.php" method="post">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputCity">Identificador del usuario</label>
                <input type="text" disabled class="form-control" id="inputCity" name="dnicuil" value="<?php echo $dnicuil?>">
                <input type="hidden" id="custId" name="idDelUsuarioAE" value="<?php echo $id?>">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Nombre del usuario</label>
                <input type="text" disabled class="form-control" id="inputEmail4" name="nombre" value="<?php echo $nombre?>">
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Nombre en el sitema</label>
                <input type="text" disabled class="form-control" id="inputEmail4" name="username" value="<?php echo $username?>">
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">rol</label>
                <input type="text" disabled class="form-control" id="inputPassword4" name="rol_id" value="<?php echo $rol_id?>">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputCity">Telefono</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                  </div>
                  <input type="number" disabled class="form-control" id="inputCity" name="telefono" value="<?php echo $telefono?>">
              </div>
              </div>
              <div class="form-group col-md-4">
                <label for="inputCity">Contraseña</label>
                <input type="text" disabled class="form-control" id="inputCity" name="password" value="<?php echo $password?>">
              </div>
              <div class="form-group col-md-4">
                <label for="inputCity">Correo</label>
                <input type="text" disabled class="form-control" id="inputCity" name="correo" value="<?php echo $correo?>">
              </div>
            </div>
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a class="btn btn-success" href="listadoDeUsuarios.php" role="button">Volver</a>
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
          <a class="btn btn-primary" href="login.html">Cerrar sesión</a>
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

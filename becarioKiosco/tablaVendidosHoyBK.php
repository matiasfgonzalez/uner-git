<?php
session_start();

if (!isset($_SESSION['username'])) {
  $errorLogin = "Debe registrarse primero";
  header('Location: ../login.php?errorLogin=' . urlencode($errorLogin));
  exit;
}

if ($_SESSION['rol'] != 2) {
  header('Location: ../php/definirRutas.php');
  exit;
}

require_once "php/conexion.php";
$conexion = conexion();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Cantina - Tabla de vendidos hoy</title>

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
          <h1 class="h3 mb-2 text-gray-800">Ventas realizadas hoy</h1>
          <p class="mb-4">Aqui se va a mosrtar las ventas realizadas en el dia por usted. De los cuales se va a mostrar las siguientes caracteristicas:</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Ventas</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>TOTAL</th>
                      <th>METODO DE PAGO</th>
                      <th>VENDEDOR</th>
                      <th>FECHA</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>TOTAL</th>
                      <th>METODO DE PAGO</th>
                      <th>VENDEDOR</th>
                      <th>FECHA</th>
                      <th>ACCIONES</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM t_ventas WHERE YEAR(NOW()) = YEAR(fecha) AND MONTH(NOW()) = MONTH(fecha) AND DAY(NOW()) = DAY(fecha)";
                    $resultado = mysqli_query($conexion, $sql);

                    if ($resultado) {
                      while ($ver = mysqli_fetch_assoc($resultado)) {
                    ?>
                        <tr>
                          <td><?php echo htmlspecialchars($ver['id_venta']); ?></td>
                          <td>$ <?php echo htmlspecialchars($ver['total']); ?></td>
                          <td><?php echo htmlspecialchars($ver['metodo_pago']); ?></td>
                          <td><?php echo htmlspecialchars($ver['usuario_alta']); ?></td>
                          <td><?php echo htmlspecialchars($ver['fecha']); ?></td>
                          <td class="text-center">
                            <button type="button" class="btn btn-info" id="ver-venta" onclick="modalVerVenta(<?php echo $ver['id_venta']; ?>)">
                              <i class="fa fa-eye" aria-hidden="true"></i> Ver
                            </button>
                          </td>
                        </tr>
                    <?php
                      }
                    } else {
                      echo "<tr><td colspan='6' class='text-center'>No se encontraron resultados para el dia de la fecha.</td></tr>";
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
          <a class="btn btn-primary" href="../php/logout.php">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para mostrar los detalles de la venta -->
  <div class="modal fade" id="detalleVentaModal" tabindex="-1" role="dialog" aria-labelledby="detalleVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detalleVentaModalLabel">Detalles de la Venta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Código de Barra</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Fecha Alta</th>
                <th>Usuario Alta</th>
              </tr>
            </thead>
            <tbody id="detalleVentaBody">
              <!-- Aquí se insertarán los detalles de la venta -->
            </tbody>
          </table>
          <!-- Total de la venta -->
          <div class="text-right font-weight-bold">
            Total de la Venta: $<span id="totalVenta"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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

  <script type="text/javascript">
    const modalVerVenta = async (idVenta) => {
      try {
        const response = await fetch(`php/obtenerDatosDeVenta.php?id_venta=${idVenta}`);
        const data = await response.json();

        if (response.ok) {
          const productos = data.productos;
          const totalVenta = data.totalVenta;

          // Limpiar el contenido del cuerpo del modal
          const detalleVentaBody = document.getElementById("detalleVentaBody");
          detalleVentaBody.innerHTML = "";

          // Insertar cada producto en una fila de la tabla
          productos.forEach(producto => {
            const row = document.createElement("tr");
            row.innerHTML = `
          <td>${producto.codigodebarra}</td>
          <td>${producto.cantidad}</td>
          <td>$ ${producto.precio_unitario}</td>
          <td>$ ${producto.subtotal}</td>
          <td>${producto.fecha_alta}</td>
          <td>${producto.usuario_alta}</td>
        `;
            detalleVentaBody.appendChild(row);
          });

          // Mostrar el total de la venta en el modal
          document.getElementById("totalVenta").textContent = totalVenta.toFixed(2);

          // Mostrar el modal
          $('#detalleVentaModal').modal('show');
        } else {
          alert("Error al obtener los datos de la venta: " + (data.error || "Error desconocido"));
        }
      } catch (error) {
        console.error("Error al obtener los detalles de la venta:", error);
        alert("Ocurrió un error al obtener los detalles de la venta.");
      }
    };
  </script>

</body>

</html>
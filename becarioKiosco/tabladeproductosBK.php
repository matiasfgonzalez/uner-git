<?php 
	require_once "php/conexion.php";
	$conexion=conexion();
?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Productos</h6>
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
                      <th>Editar</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nombre</th>
                      <th>Precio</th>
                      <th>Stock</th>
                      <th>Categoria</th>
                      <th>Codigo de barra</th>
                      <th>Editar</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      $sql="select * from t_productos";
                      $resultado=mysqli_query($conexion,$sql);
                      while ($ver = mysqli_fetch_assoc($resultado)) {
                        $datos = $ver['id']. "││" . 
                                $ver['nombre'] . "││" . 
                                $ver['precio']. "││".
                                $ver['stock']. "││" .
                                $ver['categoria']. "││" .
                                $ver['codigodebarra'];
                    ?>
                    <tr>
                      <td><?php echo $ver['nombre']; ?></td>
                      <td>$ <?php echo $ver['precio']; ?></td>                      
                      <td><?php echo $ver['stock'];?> </td>
                      <td><?php echo $ver['categoria']; ?></td>
                      <td><?php echo $ver['codigodebarra']; ?></td>
                      <td> <button class="btn btn-warning" data-toggle="modal" data-target="#modalModificar" onclick="agregaform('<?php echo $datos ?>')">Editar</button> </td>
                    </tr>
                  <?php 
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
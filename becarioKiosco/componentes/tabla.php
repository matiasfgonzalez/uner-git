<?php 
	require_once "../php/conexion.php";
	$conexion=conexion();
?>


		<div class="card shadow mb-4">
			<div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Productos a vender</h6>
            </div>
		<div class="card-body">
		<div class="table-responsive">
		<table class="table table-bordered table-hover" style="text-align: center;"> <!--table-hover table-condensed table-bordered-->
			<thead class="thead-dark">
			<tr>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Categoria</th>
				<th>Codigo de barra</th>
				<th>Eliminar</th>
			</tr>
			</thead>
			<?php 
				$sql="select * from t_productosvt";
				$resultado=mysqli_query($conexion,$sql);
				while ($ver = mysqli_fetch_assoc($resultado)) {
					$datos = $ver['id']. "││" . 
						$ver['nombre'] . "││" . 
						$ver['precio']. "││".
						$ver['categoria']. "││" .
						$ver['codigodebarra'];
			?>
			<tbody>
			<tr>
				<td><?php echo $ver['nombre']; ?></td>
				<td>$ <?php echo $ver['precio']; ?></td>
				<td><?php echo $ver['categoria']; ?></td>
				<td><?php echo $ver['codigodebarra']; ?></td>
				<td>
					<button class="btn btn-danger" 
					onclick="preguntarSiNo('<?php echo $ver['id'] ?>')"><i class="fas fa-times-circle"></i> Eliminar</button>
				</td>
			</tr>
			</tbody>
			<?php 
			}
			?>
		</table>
		<h3>Total: $ 
		<?php 
		$sql2 = "select sum(precio) as suma from t_productosvt";
		$resultado2= mysqli_query($conexion,$sql2);
		while ($ver = mysqli_fetch_assoc($resultado2)) {
				echo $ver['suma'];
		}
		?>	
		</h3>
		<button class="btn btn-success" onclick="confirmarventa()">Confirmar</button>
		</div>
		</div>
		</div>
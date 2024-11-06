<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Productos a vender</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover" style="text-align: center;" id="table-venta-productos"> <!--table-hover table-condensed table-bordered-->
				<thead class="thead-dark">
					<tr>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Categoria</th>
						<th>Codigo de barra</th>
						<th>Cantidad</th>
						<th>Total</th>
						<th>Eliminar</th>
					</tr>
				</thead>
				<tbody id="table-tbody-venta-productos">
				</tbody>
			</table>
			<h3 id="total-de-venta">Total: $ </h3>
			<div class="form-group col-md-5 d-flex">
				<select class="form-select form-control mr-3" aria-label="Metodo de pago" id="metodo-pago">
					<option value="Efectivo" selected>Efectivo</option>
					<option value="Transferencia">Transferencia</option>
				</select>
				<button class="btn btn-success" onclick="registrarVenta()">Confirmar</button>
			</div>
		</div>
	</div>
</div>
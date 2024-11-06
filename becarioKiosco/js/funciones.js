function limpiarTabla() {
  // Limpiar el tbody de la tabla
  const tbody = document.getElementById("table-tbody-venta-productos");
  tbody.innerHTML = ""; // Elimina todas las filas del tbody

  // Restablecer el total a cero
  const totalVenta = document.getElementById("total-de-venta");
  totalVenta.textContent = "Total: $0.00"; // Restablecer el total
}

const registrarVenta = async () => {
  // Obtener los datos de los productos de la tabla
  const filas = document.querySelectorAll("#table-tbody-venta-productos tr");
  const productosVendidos = [];

  if (!filas.length) {
    alertify.error("Debe de cargar al menos un producto.");
    return;
  }

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");
    const producto = {
      nombre: celdas[0].textContent,
      precio: parseFloat(celdas[1].textContent.replace("$", "")),
      categoria: celdas[2].textContent,
      codigodebarra: celdas[3].textContent,
      cantidad: parseInt(celdas[4].textContent),
      subtotal: parseFloat(celdas[5].textContent.replace("$", "")),
    };
    productosVendidos.push(producto);
  });

  // Obtener el total y el método de pago
  const total = parseFloat(
    document
      .getElementById("total-de-venta")
      .textContent.replace("Total: $", "")
  );
  const metodoPago = document.getElementById("metodo-pago").value; // Elemento de selección de método de pago

  // Enviar la información de la venta al servidor
  const resp = await fetch("php/registrarVenta.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ productosVendidos, total, metodoPago }),
  });

  const data = await resp.json();
  if (data.success) {
    alertify.success("Venta registrada exitosamente.");
    limpiarTabla();
  } else {
    alertify.error("Error al registrar la venta: " + data.message);
  }
};

const actualizarTotalVenta = () => {
  // Obtener todas las celdas de subtotal en la tabla
  const celdasSubtotal = document.querySelectorAll(
    "#table-tbody-venta-productos td:nth-child(6)"
  );

  // Sumar los valores de las celdas de subtotal
  let total = 0;
  celdasSubtotal.forEach((celda) => {
    const subtotal = parseFloat(celda.textContent.replace("$", "")) || 0;
    total += subtotal;
  });

  // Actualizar el <h3> con el total de venta
  const totalVenta = document.getElementById("total-de-venta");
  totalVenta.textContent = `Total: $${total.toFixed(2)}`;
};

const actualizarTablaDeProductos = (producto, cantidad) => {
  const tbody = document.getElementById("table-tbody-venta-productos");

  const fila = document.createElement("tr");

  const celdaNombre = document.createElement("td");
  celdaNombre.textContent = producto.nombre;

  const celdaPrecio = document.createElement("td");
  celdaPrecio.textContent = `$${producto.precio.toFixed(2)}`;

  const celdaCategoria = document.createElement("td");
  celdaCategoria.textContent = producto.categoria;

  const celdaCodigoDeBarra = document.createElement("td");
  celdaCodigoDeBarra.textContent = producto.codigodebarra;

  const celdaCantidad = document.createElement("td");
  celdaCantidad.textContent = cantidad;

  const celdaSubtotal = document.createElement("td");
  const subtotal = producto.precio * cantidad;
  celdaSubtotal.textContent = `$${subtotal.toFixed(2)}`;

  const celdaEliminar = document.createElement("td");
  const botonEliminar = document.createElement("button");
  botonEliminar.className = "btn btn-danger";
  botonEliminar.innerHTML = '<i class="fas fa-times-circle"></i> Eliminar';

  botonEliminar.onclick = () => {
    tbody.removeChild(fila);
    actualizarTotalVenta(); // Actualizar el total después de eliminar una fila
  };

  celdaEliminar.appendChild(botonEliminar);

  fila.appendChild(celdaNombre);
  fila.appendChild(celdaPrecio);
  fila.appendChild(celdaCategoria);
  fila.appendChild(celdaCodigoDeBarra);
  fila.appendChild(celdaCantidad);
  fila.appendChild(celdaSubtotal);
  fila.appendChild(celdaEliminar);

  tbody.appendChild(fila);

  actualizarTotalVenta(); // Actualizar el total después de agregar una fila
};

const buscarProducto = async (codigoDeBarra, cant = 1) => {
  try {
    const resp = await fetch(`php/buscarProductoProCodigoDeBarra.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `codigodebarra=${encodeURIComponent(codigoDeBarra)}`,
    });

    if (!resp.ok) throw new Error("Error en la solicitud");

    const json = await resp.json();
    actualizarTablaDeProductos(json, cant);
  } catch (error) {
    console.error("Error al buscar el producto:", error);
  }
};

function agregardatos(codigodebarra) {
  cadena = "codigodebarra=" + codigodebarra;

  $.ajax({
    type: "POST",
    url: "php/agregarDatos.php",
    data: cadena,
    success: function (r) {
      if (r == 1) {
        $("#tabla").load("componentes/tabla.php");
        alertify.success("Agregado con exito :)");
      } else {
        alertify.error("Fallo el servidor :(");
      }
    },
  });
}

function agregaform(datos) {
  d = datos.split("││");

  $("#idproducto").val(d[0]);
  $("#nombreu").val(d[1]);
  $("#preciou").val(d[2]);
  $("#stocku").val(d[3]);
  $("#categoriau").val(d[4]);
  $("#codigodebarrau").val(d[5]);
}

function actualizadatos() {
  id = $("#idproducto").val();
  nombre = $("#nombreu").val();
  precio = $("#preciou").val();
  stock = $("#stocku").val();
  categoria = $("#categoriau").val();
  codigodebarra = $("#codigodebarrau").val();

  cadena =
    "id=" +
    id +
    "&nombre=" +
    nombre +
    "&precio=" +
    precio +
    "&stock=" +
    stock +
    "&categoria=" +
    categoria +
    "&codigodebarra=" +
    codigodebarra;

  $.ajax({
    type: "POST",
    url: "php/actualizardatos.php",
    data: cadena,
    success: function (r) {
      if (r == 1) {
        $("#tabla").load("tabladeproductosBK.php");
        alertify.success("Actualizado con exito :)");
      } else {
        alertify.error("Fallo el servidor :(");
      }
    },
  });
}

function preguntarSiNo(id) {
  alertify.confirm(
    "Eliminar Datos",
    "¿Esta seguro de eliminar?",
    function () {
      eliminardatos(id);
    },
    function () {
      alertify.error("Cancelado");
    }
  );
}

function eliminardatos(id) {
  cadena = "id=" + id;

  $.ajax({
    type: "POST",
    url: "php/eliminardatos.php",
    data: cadena,
    success: function (r) {
      if (r == 1) {
        $("#tabla").load("componentes/tabla.php");
        $("#codigodebarra").focus();
        alertify.success("Eliminado con exito :)");
      } else {
        alertify.error("Fallo el servidor :(");
      }
    },
  });
}

function confirmarventa() {
  $.ajax({
    type: "POST",
    url: "php/confirmarventa.php",
    success: function (r) {
      if (r == 1) {
        $("#tabla").load("componentes/tabla.php");
        $("#codigodebarra").focus();
        alertify.success("Venta exitosa :)");
      } else {
        alertify.error("Fallo el servidor :(");
      }
    },
  });
}

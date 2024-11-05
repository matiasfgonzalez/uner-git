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

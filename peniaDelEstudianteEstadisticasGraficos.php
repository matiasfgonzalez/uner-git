<?php
	include_once 'php/conexion.php';
  	$bd= new BD();
  	$conexion = $bd->connect();

  // Total de entradas y precio actual
    $queryp= $conexion->prepare("select cantidadDeEntradas, precio from bdunertest.t_penia_del_estudiante");
    $queryp->execute();
    foreach ($queryp as $penia) {

      $cantidadDeEntradas = $penia['cantidadDeEntradas'];
      $precio = $penia['precio'];
    }

  //Total entradas vendidas
    $querye= $conexion->prepare("select count(*) as cantidadVendidas, sum(precio) as totalPrecio from bdunertest.t_penia_del_estudiante_entradasv");
    $querye->execute();
    foreach ($querye as $penia) {

      $cantidadVendidas = $penia['cantidadVendidas'];
      $totalPrecio = $penia['totalPrecio'];
    }

 	//Total del mes
  	$query= $conexion->prepare("select count(*) as totaldia, diaVendida from bdunertest.t_penia_del_estudiante_entradasv group by day(diaVendida), month(diaVendida), year(diaVendida) order by t_penia_del_estudiante_entradasv.diaVendida asc");
  	$query->execute();
  	$x="";
  	$y="";
  	$band=1;
  	foreach ($query as $sumatotal) {
  		if($band===0){
  			$x.= ", " . "'" . date("Y-m-d", strtotime($sumatotal['diaVendida'])) . "'";
  			$y.= ", " . $sumatotal['totaldia'];
  		}else{
	  		$x= "'" . date("Y-m-d", strtotime($sumatotal['diaVendida'])) . "'";
	  		$y= $sumatotal['totaldia'];
  			$band=0;
  		}
 	}
 	$query=NULL;
 	$conexion=NULL;
?>
  	<div class="card">
        <div class="card-body">
          	<div class="row">
	            <div class="col-xl-4 col-md-12 mb-12">
	              Total de entradas: <?php echo $cantidadDeEntradas; ?>
	            </div>
              <div class="col-xl-4 col-md-12 mb-12">
                Total recaudado: $ <?php echo $totalPrecio; ?>
              </div>
              <div class="col-xl-4 col-md-12 mb-12">
                Precio actual: $ <?php echo $precio; ?>
              </div>
	            <div class="col-xl-4 col-md-12 mb-12">
	              Vendidas: <?php echo $cantidadVendidas; ?>
	            </div>
	            <div class="col-xl-4 col-md-12 mb-12">
	              No Vendidas: <?php echo ($cantidadDeEntradas - $cantidadVendidas); ?>
	            </div>
          	</div>
        </div>
  	</div>
  <!-- Divider -->
  <hr class="sidebar-divider">

  	<div class="row">
		<div class="col-xl-6 col-md-12 mb-12">
	      <div id="graficoLineal">
	      </div>
	    </div>
	    <div class="col-xl-6 col-md-12 mb-12">
	      <div id="graficoRedondo">
	      </div>
	    </div>
	</div>

<script>
    var data = [{
      values: [<?php echo ($cantidadDeEntradas - $cantidadVendidas); ?>, <?php echo $cantidadVendidas; ?>],
      labels: ['No Vendidas', 'Vendidas'],
      type: 'pie'
    }];

  Plotly.newPlot('graficoRedondo', data, {}, {showSendToCloud:true}, {responsive: true});
</script>
<script>
    var trace1 = {
     	x: [<?php echo $x ?>],
     	y: [<?php echo $y ?>],
     	//x: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
     	//y: [10, 15, 13, 17, 16, 2, 41, 32, 15, 21, 11, 22, 51, 36, 12, 1, 21, 24, 12, 15, 16],
  		//mode: 'lines+markers',
      	type: 'scatter',
    };

  	var data = [trace1];
  	
  	var layout = {
	  title:'Entradas vendidas por día',
	  xaxis: {
	    title: 'Días'
	  },
	  yaxis: {
	    title: 'Cantidad'
	  }
	};

  Plotly.newPlot('graficoLineal', data, layout, {}, {showSendToCloud: true}, {responsive: true});
</script>

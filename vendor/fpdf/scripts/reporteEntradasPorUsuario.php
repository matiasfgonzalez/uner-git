<?php
require('../fpdf/fpdf.php');
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logofinal2.png',2,7,40,25);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        //$this->Cell(90);
        // Título
        $this->SetY(17);
        //$this->SetX(52);
        $this->SetDrawColor(33, 41, 103);
        $this->SetFillColor(230,230,0); //
        $this->SetTextColor(33, 41, 103); //Color del texto
        $this->SetLineWidth(0); // ancho del borde
        $w = $this->GetStringWidth('Listado de entradas vendidas en la peña por Vendedor')+6; // definir el tamaño del rectangulo
        $this->Cell(0,0,utf8_decode('Listado de entradas vendidas en la peña por Vendedor'),0,1,'C');
        // Salto de línea
        $this->Ln(20);
        /*
        // Titulo
        $this->Write(0,'Listado de Archivos Tipo A procesados');
        // Salto de línea
        $this->Ln(20);
        */
    }
// Tabla coloreada
function FancyTable($header, $vendedorEntradas)
{
    include_once '../../../php/conexion.php';
    $bd= new BD();
    $conexion = $bd->connect();

    $query2= $conexion->prepare("select count(*) as cantidad, sum(precio) as totalRecaudado from bdunertest.t_penia_del_estudiante_entradasv where vendedor = '$vendedorEntradas' ORDER BY t_penia_del_estudiante_entradasv.codigo asc");
    $query2->execute();
    foreach ($query2 as $ver){
        $cantidad = $ver['cantidad'];
        $totalRecaudado = $ver['totalRecaudado'];
    }


    //fin de la base de datos
        $this->Cell(190,6,utf8_decode('Cantidad de entradas vendidas por ' . $vendedorEntradas . ' es un TOTAL de: ' . $cantidad),0,1,'L');
        $this->Cell(190,6,utf8_decode('Recaudado por el vendedor en TOTAL: $ ' . $totalRecaudado),0,1,'L');
        
        
        $queryEntradas= $conexion->prepare("SELECT COUNT(*) AS CantidadDeEntradas, precio, vendedor, SUM(precio) as Recaudado FROM bdunertest.t_penia_del_estudiante_entradasv WHERE t_penia_del_estudiante_entradasv.vendedor = '$vendedorEntradas' GROUP BY t_penia_del_estudiante_entradasv.vendedor, t_penia_del_estudiante_entradasv.precio");
        $queryEntradas->execute();

        $banderaDePrimeraEntrada = 0;

        foreach ($queryEntradas as $qEntradas){
            if($banderaDePrimeraEntrada == 1){
                $this->AddPage();
            }
                $this->Cell(190,6,utf8_decode('Cantidad de entradas vendidas al precio $' . $qEntradas['precio'] . ' es de: ' . $qEntradas['CantidadDeEntradas']),0,1,'L');
                $this->Cell(190,6,utf8_decode('Recaudado por el vendedor al precio ' . $qEntradas['precio'] . ' es de: $ ' . $qEntradas['Recaudado']),0,1,'L');

            // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(33, 41, 103);
        $this->SetTextColor(255);
        //$this->SetDrawColor(128,0,0);
        //$this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(47, 47, 47, 48); //acostada ->280 -- portrait 190
            //$this->SetY(43);
            //$this->SetX(10);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Datos
        $fill = false;

        $numDePagina = $this->PageNo();
        $queryEntradasPrecio = $qEntradas['precio'];
        $query= $conexion->prepare("select * from bdunertest.t_penia_del_estudiante_entradasv where vendedor = '$vendedorEntradas' and precio = '$queryEntradasPrecio' ORDER BY t_penia_del_estudiante_entradasv.codigo asc");
        $query->execute();
        
        foreach ($query as $ver)
        {
                if($numDePagina != $this->PageNo()){
                }
                $this->Cell($w[0],6,$ver['codigo'],'LR',0,'C',$fill);
                $this->Cell($w[1],6,"$ " . $ver['precio'],'LR',0,'C',$fill);
                $this->Cell($w[2],6,utf8_decode($ver['vendedor']),'LR',0,'C',$fill);
                $this->Cell($w[3],6,$ver['diaVendida'],'LR',0,'C',$fill);
                $this->Ln();
                $fill = !$fill;
        }
        /* Agregar thead al final de la tabla
            $this->SetFillColor(33, 41, 103);
            $this->SetTextColor(255);
            //$this->SetDrawColor(128,0,0);
            //$this->SetLineWidth(.3);
            $this->SetFont('','B');
            // Cabecera
            $w = array(47, 47, 47, 48); //acostada ->280 -- portrait 190
                $this->SetX(10);
            for($i=0;$i<count($header);$i++)
                $this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',true);
            $this->Ln();
            // Restauración de colores y fuentes
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');
            $numDePagina = $this->PageNo();
        // Agregar thead al final de la tabla*/

        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
        // Fecha de generacion del reporte
        $this->Ln();
        $banderaDePrimeraEntrada = 1;
        }
            //$fechar=date("d/m/y");
            //$this->Cell(279,10,utf8_decode('Fecha de emisión: ') . $fechar,0,0,'R');
}
// Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
    }
}
$vendedorEntradas = $_POST['usuarioReporteEntradas'];
//$vendedorEntradas = 'CEFCA UNER';  
if($vendedorEntradas == "" || $vendedorEntradas == "so")
{
    $mensaje="Por favor, seleccione un vendedor del listado desplegable.";
    header('location: ../../../peniaDelEstudainteReporteDeEntradas.php?error='.$mensaje);
    exit;
}else{

$pdf = new PDF();
// Títulos de las columnas
$header = array('Codigo', 'Precio', 'Vendedor', 'Fecha');
// Carga de datos
//$data = $pdf->LoadData('paises.txt');
$pdf->SetFont('Arial','',10);
//$pdf->AddPage();
//$pdf->BasicTable($header,$data);
//$pdf->AddPage();
//$pdf->ImprovedTable($header,$data);
$pdf->AddPage('portrait','A4');
$pdf->FancyTable($header, $vendedorEntradas);
$año = 2019;
$mes = 8;
$cadena= "Reporte_Archivo_Tipo_A_Mes_". $mes. "_Anio_" . $año . ".pdf";
$pdf->Output('I',$cadena);
}
?>
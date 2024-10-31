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
        $w = $this->GetStringWidth('Listado de entradas vendidas para la peña')+6; // definir el tamaño del rectangulo
        $this->Cell(0,0,utf8_decode('Listado de entradas vendidas para la peña'),0,1,'C');
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
function FancyTable($header)
{
    include_once '../../../php/conexion.php';
    $bd= new BD();
    $conexion = $bd->connect();

    $query2= $conexion->prepare("select count(*) as cantidad, sum(precio) as totalRecaudado from bdunertest.t_penia_del_estudiante_entradasv");
    $query2->execute();
    foreach ($query2 as $ver){
        $cantidad = $ver['cantidad'];
        $totalRecaudado = $ver['totalRecaudado'];
    }


    //fin de la base de datos
        $this->Cell(190,6,utf8_decode('Cantidad de entradas vendidas: ' . $cantidad),0,1,'L');
        $this->Cell(190,6,utf8_decode('Total de recaudado: $ ' . $totalRecaudado),0,1,'L');
        
        
        $queryEntradasDPV= $conexion->prepare("SELECT vendedor, precio, count(*) as CantidadVendida, SUM(precio) as TotalRecaudado, day(diaVendida) as Dia, month(diaVendida) as Mes , year(diaVendida) as Año FROM bdunertest.t_penia_del_estudiante_entradasv GROUP BY vendedor, day(diaVendida), precio ORDER BY diaVendida");
        $queryEntradasDPV->execute();

        

        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(33, 41, 103);
        $this->SetTextColor(255);
        //$this->SetDrawColor(128,0,0);
        //$this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(50, 33, 37, 35, 35); //acostada ->280 -- portrait 190
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Datos
        $fill = false;

        $banderaDia;
        $banderaPrimeraEndrada=0;
        
        foreach ($queryEntradasDPV as $qEntradas)
        {
            /*if($banderaPrimeraEndrada == 0){
                $banderaDia = $qEntradas['Dia'];
                $banderaPrimeraEndrada = 1;
            }
            if($banderaDia != $qEntradas['Dia']){
                $banderaDia = $qEntradas['Dia'];
                $this->Ln();               
            }*/
                $this->Cell($w[0],6,utf8_decode($qEntradas['vendedor']),'LR',0,'L',$fill);
                $this->Cell($w[1],6,"$ " . $qEntradas['precio'],'LR',0,'C',$fill);
                $this->Cell($w[2],6,utf8_decode($qEntradas['CantidadVendida']),'LR',0,'C',$fill);
                $this->Cell($w[3],6,"$ " . $qEntradas['TotalRecaudado'],'LR',0,'C',$fill);
                $this->Cell($w[4],6,$qEntradas['Dia'].'/'.$qEntradas['Mes'].'/'.$qEntradas['Año'],'LR',0,'C',$fill);
                $this->Ln();
                $fill = !$fill;

        }

        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
        // Fecha de generacion del reporte
        $this->Ln();
        $banderaDePrimeraEntrada = 1;
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

$pdf = new PDF();
// Títulos de las columnas
$header = array('Vendedor', 'Precio', 'Cantidad vendidas', 'Recaudado', 'Fecha');
$pdf->SetFont('Arial','',10);
$pdf->AddPage('portrait','A4');
$pdf->FancyTable($header);
$cadena= "Reporte_De_Entradas_Por_Dia_Precio_Vendedor.pdf";
$pdf->Output('I',$cadena);
?>
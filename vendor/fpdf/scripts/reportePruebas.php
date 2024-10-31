<?php
if($_POST['mesr'] == "" || $año= $_POST['añor'] == "" ){

    header('location: ../../../reportes.php');
}
$mes= $_POST['mesr'];
$año= $_POST['añor'];
require('../fpdf/fpdfBis.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logofinal2.png',165,8,45,25);
        // Arial bold 15
        $this->SetFont('Arial','',10);
        switch (date("m")) {
                case '1':
                    $variableMes = "Enero";
                    break;
                case '2':
                    $variableMes = "Febrero";
                    break;
                case '3':
                    $variableMes = "Marzo";
                    break;
                case '4':
                    $variableMes = "Abril";
                    break;
                case '5':
                    $variableMes = "Mayo";
                    break;
                case '6':
                    $variableMes = "Junio";
                    break;
                case '7':
                    $variableMes = "Julio";
                    break;
                case '8':
                    $variableMes = "Agosto";
                    break;
                case '9':
                    $variableMes = "Septiembre";
                    break;
                case '10':
                    $variableMes = "Octubre";
                    break;
                case '11':
                    $variableMes = "Noviembre";
                    break;
                case '12':
                    $variableMes = "Diciembre";
                    break;
            }
        // Título
        $this->SetY(30);
        $this->Cell(0,7,utf8_decode('Oro Verde, ') . date("d") . " de " . $variableMes . " de " . date("Y") ,0,1,'R');
    }

    function FancyTable($año,$mes)
    {
        include_once '../../../php/conexion.php';
        $bd= new BD();
        $conexion = $bd->connect();
        
        $query= $conexion->prepare("select sum(saldo) as saldoNetoCantina from bdunertest.t_fondosymovimientos_cantina
            where year(fecha) <= ? and month(fecha) <= ? ");
        $query->bindParam(1, $año, PDO::PARAM_INT);
        $query->bindParam(2, $mes, PDO::PARAM_INT);

        $query->execute();

        foreach ($query as $ver){
            $saldoNetoCantina = number_format($ver['saldoNetoCantina'],0,",",".");
        }

        $query2= $conexion->prepare('select count(*) as cantidad, sum(precio) as totalRecaudado from bdunertest.t_penia_del_estudiante_entradasv ORDER BY t_penia_del_estudiante_entradasv.codigo asc');
        $query2->execute();
        foreach ($query2 as $ver){
            $cantidad = $ver['cantidad'];
            $totalRecaudado = $ver['totalRecaudado'];
        }
        switch ($mes) {
                    case '1':
                        $variableMes = "Enero";
                        break;
                    case '2':
                        $variableMes = "Febrero";
                        break;
                    case '3':
                        $variableMes = "Marzo";
                        break;
                    case '4':
                        $variableMes = "Abril";
                        break;
                    case '5':
                        $variableMes = "Mayo";
                        break;
                    case '6':
                        $variableMes = "Junio";
                        break;
                    case '7':
                        $variableMes = "Julio";
                        break;
                    case '8':
                        $variableMes = "Agosto";
                        break;
                    case '9':
                        $variableMes = "Septiembre";
                        break;
                    case '10':
                        $variableMes = "Octubre";
                        break;
                    case '11':
                        $variableMes = "Noviembre";
                        break;
                    case '12':
                        $variableMes = "Diciembre";
                        break;
                }


        //fin de la base de datos
           /**/
            $this->SetFont('Arial','B',12);
            $this->SetY(40);
            $this->SetX(10);
            
            $this->Cell(0,7,utf8_decode('BALANCES CEFCA MES AÑO' ) ,0,1,'C');
            // Salto de línea
            $this->Ln(20);

           $this->SetFont('Arial','',11);
            $this->SetY(50);
            $this->SetX(10);

            $textoLorem = "    La secretaria de Finanzas del Centro de Estudiandes de la Facultad de Ciencias Agropecuarias hace presente el balance mes " . $variableMes . " del año " . $año . " correspondiente a cantina, fotocopiadora y fondo CEFCA.
        En cuanto a cantina se finalizo el mes " . $variableMes . " con un saldo neto de $" . $saldoNetoCantina . "; habiendo cumplido con todos sus haberes y pagos correspondientes.
        Respecto a fotocopiadora, el mes de " . $variableMes . " finalizo con un saldo neto de $" . "VARIABLE" . "; quedando saldadas las cuentas por servicio de alquiler de fotocopiadoras, proveedores y pagos de becarios.
        Por último, en cuanto a fondo CEFCA, el mismo finalizo " . $variableMes . " con un saldo de $" . "VARIABLE" . "; cumpliendo con todos los gastos correspondientes incluyendo becas, sueldos, inversiones, compras de equipamiento, eventos festivos y mejoras a los servicios que el CEFCA brinda a los estudiantes.";
            
            //$this->Cell(280,7,utf8_decode($textoLorem) ,0,1,'L');
            $this->SetFillColor(255,255,255);
            $this->MultiCell(190,8,utf8_decode($textoLorem),0,1,'FJ',0);
            $this->Ln(20);
            $this->SetY(225);
            $this->Cell(0,7,utf8_decode('Volker Scharton Maximiliano') ,0,1,'C');
            $this->Cell(0,7,utf8_decode('Sec. De Finanzas CEFCA-UNER') ,0,1,'C');
            $this->Cell(0,7,utf8_decode('"Conducción Resiliar"') ,0,1,'C');
    }
}

$pdf = new PDF();
// Títulos de las columnas
$header = array('Codigo', 'Precio', 'Vendedor', 'Fecha');
$pdf->SetFont('Arial','',10);
//$pdf->AddPage();
//$pdf->BasicTable($header,$data);
//$pdf->AddPage();
//$pdf->ImprovedTable($header,$data);
$pdf->AddPage('portrait','A4');
$pdf->FancyTable($año,$mes);
$cadena= "Reporte_Archivo_Tipo_A_Mes_". $mes. "_Anio_" . $año . ".pdf";
$pdf->Output('I',$cadena);
?>
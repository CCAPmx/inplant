<?php
session_start();
require('../vistas/fpdf/fpdf.php');
date_default_timezone_set('America/Mexico_City');
$tabla = json_decode($_POST['tabla'], true);

$ren=0;
// Verificar si la decodificación fue exitosa

$imagenCodificadaLinea = $_POST["pots"];
$imagenCodificadaLineaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificadaLinea);
$imagenDecodificadaLinea = base64_decode($imagenCodificadaLineaLimpia);
$carpetaLinea = '../vistas/recursos/img/pots/';
$nombreArchivo = 'pots.png';
$rutaCompletaLinea = $carpetaLinea . $nombreArchivo;
file_put_contents($rutaCompletaLinea, $imagenDecodificadaLinea);

$imagenCodificadaLectura= $_POST["lectura"];
$imagenCodificadaLineaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificadaLectura);
$imagenDecodificadaLectura = base64_decode($imagenCodificadaLineaLimpia);
$carpetaLectura = '../vistas/recursos/img/lectura/';
$nombreArchivo = 'lectura.png';
$rutaCompletaLectura = $carpetaLectura . $nombreArchivo;
file_put_contents($rutaCompletaLectura, $imagenDecodificadaLectura);


$imagenCodificadaDona= $_POST["dona"];
$imagenCodificadaDonaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificadaDona);
$imagenDecodificadaDona = base64_decode($imagenCodificadaDonaLimpia);
$carpetaDona = '../vistas/recursos/img/dona/';
$nombreArchivo = 'dona.png';
$rutaCompletaDona = $carpetaDona . $nombreArchivo;
file_put_contents($rutaCompletaDona, $imagenDecodificadaDona);


$cliente=$_POST["cliente"];
$descripcion=$_POST["descripcion"];
$vagonuno=$_POST["vagonuno"] . " Vag.";
$vagondos=$_POST["vagondos"] . " Vag.";
$vagontres=$_POST["vagontres"] . " Vag.";

$pot1=$_POST["pot1"];
$pot2=$_POST["pot2"];
$pot3=$_POST["pot3"];
$pot4=$_POST["pot4"];
$pot5=$_POST["pot5"];
$pot6=$_POST["pot6"];
$pot7=$_POST["pot7"];
$pot8=$_POST["pot8"];

$presioprom=$_POST["presioprom"];
$mingranillado=$_POST["mingranillado"];
$granallodia=$_POST["granallodia"];
$maquina=$_POST["maquina"];

$hruno=$_POST["hruno"];
$hrdos=$_POST["hrdos"];
$hrtres=$_POST["hrtres"];
$hrtot=$_POST["hrtot"];

$vaghruno=$_POST["vaghruno"];
$vaghrdos=$_POST["vaghrdos"];
$vaghrtres=$_POST["vaghrtres"];
$vaghrtot=$_POST["vaghrtot"];


$tiporeporte=$_POST["tiporeporte"];
$fechareporte=$_POST["fechareporte"];
$fechareporte = date('d-m-Y', strtotime($fechareporte));


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');

$fecha_actual = date("d/m/Y h:i:s");
$pdf->Image('../vistas/recursos/img/avatars/lersan.png',10,5,50,16);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(144, 142, 141);
$nombreuser = strtoupper( $_SESSION["nombre"]);
$pdf->Cell( 0, 11,'GENERADO POR : '.  $nombreuser , 0, 0, 'R' );
$pdf->Ln(4);
$pdf->SetFont('Arial','B',7);
$pdf->Cell( 0, 11,'FECHA ELABORACION: '. $fecha_actual, 0, 0, 'R' );
// $pdf->Ln(4);
// $pdf->SetFont('Arial','B',7);
// $pdf->Cell( 0, 11,'FECHA DEL REPORTE: '. $fechareporte, 0, 0, 'R' );
$pdf->Ln(4);
$pdf->SetTextColor(6, 6, 6);
$pdf->SetFont('Arial','B',12);
$pdf-> Cell(0,6, utf8_decode('REPORTE DIARIO DE GRANALLADOS - ' . $fechareporte),0,0,'C');
$pdf->SetXY(5, 30);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(80, 8, utf8_decode($cliente), 1, "C");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(5, 38);
$pdf->MultiCell(40, 8, utf8_decode('Maquina de granallado'), 1, "C");
$pdf->SetXY(45, 38);
$pdf->MultiCell(40, 8, utf8_decode($descripcion), 1, "C");


$pdf->SetXY(90, 30);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(50, 8, utf8_decode('Produccion del dia'), 1, "C");

// $pdf->MultiCell(115, 8, utf8_decode('Vagones por hora'), 1, "C");

$pdf->SetXY(90, 38);
$pdf->MultiCell(25, 8, utf8_decode('Turno 1:'), 1, "C");
$pdf->SetXY(115, 38);
$pdf->MultiCell(25, 8, utf8_decode($vagonuno), 1, "C");

$pdf->SetXY(90, 46);
$pdf->MultiCell(25, 8, utf8_decode('Turno 2:'), 1, "C");
$pdf->SetXY(115, 46);
$pdf->MultiCell(25, 8, utf8_decode($vagondos), 1, "C");


$pdf->SetXY(90, 54);
$pdf->MultiCell(25, 8, utf8_decode('Turno 3:'), 1, "C");
$pdf->SetXY(115, 54);
$pdf->MultiCell(25, 8, utf8_decode($vagontres), 1, "C");

$pdf->SetXY(90, 62);
$pdf->MultiCell(25, 8, utf8_decode('Total:'), 1, "C");
$pdf->SetXY(115, 62);
$pdf->MultiCell(25, 8, utf8_decode(($vagonuno + $vagondos +$vagontres) . " Vag."), 1, "C");

$pdf->SetXY(140, 30);
$pdf->MultiCell(30, 8, utf8_decode('Horas totales'), 1, "C");
$pdf->SetXY(140, 38);
$pdf->MultiCell(30, 8, utf8_decode($hruno). " Hrs", 1, "C");
$pdf->SetXY(140, 46);
$pdf->MultiCell(30, 8, utf8_decode($hrdos). " Hrs", 1, "C");
$pdf->SetXY(140, 54);
$pdf->MultiCell(30, 8, utf8_decode($hrtres). " Hrs", 1, "C");
$pdf->SetXY(140, 62);
$pdf->MultiCell(30, 8, utf8_decode($hrtot). " Hrs", 1, "C");

$pdf->SetXY(170, 30);
$pdf->MultiCell(30, 8, utf8_decode('Vagones por hra'), 1, "C");
$pdf->SetXY(170, 38);
$pdf->MultiCell(30, 8, utf8_decode($vaghruno). " Va/h", 1, "C");
$pdf->SetXY(170, 46);
$pdf->MultiCell(30, 8, utf8_decode($vaghrdos). " Va/h", 1, "C");
$pdf->SetXY(170, 54);
$pdf->MultiCell(30, 8, utf8_decode($vaghrtres). " Va/h", 1, "C");
$pdf->SetXY(170, 62);
$pdf->MultiCell(30, 8, utf8_decode($vaghrtot). " Va/h", 1, "C");

$pdf->Ln(10);
$pdf-> Cell(0,6, utf8_decode('Activacion de Pots'),0,0,'C');
$pdf->Image('../vistas/recursos/img/pots/pots.png',5,80,200,80);

$pdf->Ln(100);
$pdf-> Cell(0,6, utf8_decode('Lecturas de presion y Nivel de granalla en silo'),0,0,'C');

$pdf->Image('../vistas/recursos/img/lectura/lectura.png',5,180,200,80);



$pdf->AddPage();
$pdf-> Cell(300,0, utf8_decode('Tiempo productivo'),0,0,'C');
$pdf->SetXY(5, 5);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(50, 8, utf8_decode('Horas Activas del día'), 1, "C");
$pdf->SetFont('Arial','',10);
$pdf->SetXY(5, 13);
$pdf->MultiCell(25, 8, utf8_decode('Pot 1:'), 1, "C");
$pdf->SetXY(30, 13);
$pdf->MultiCell(25, 8, utf8_decode($pot1), 1, "C");

$pdf->SetXY(5, 21);
$pdf->MultiCell(25, 8, utf8_decode('Pot 2:'), 1, "C");
$pdf->SetXY(30, 21);
$pdf->MultiCell(25, 8, utf8_decode($pot2), 1, "C");

$pdf->SetXY(5, 29);
$pdf->MultiCell(25, 8, utf8_decode('Pot 3:'), 1, "C");
$pdf->SetXY(30, 29);
$pdf->MultiCell(25, 8, utf8_decode($pot3), 1, "C");

$pdf->SetXY(5, 37);
$pdf->MultiCell(25, 8, utf8_decode('Pot 4:'), 1, "C");
$pdf->SetXY(30, 37);
$pdf->MultiCell(25, 8, utf8_decode($pot4), 1, "C");

$pdf->SetXY(5, 45);
$pdf->MultiCell(25, 8, utf8_decode('Pot 5:'), 1, "C");
$pdf->SetXY(30, 45);
$pdf->MultiCell(25, 8, utf8_decode($pot5), 1, "C");

$pdf->SetXY(5, 53);
$pdf->MultiCell(25, 8, utf8_decode('Pot 6:'), 1, "C");
$pdf->SetXY(30, 53);
$pdf->MultiCell(25, 8, utf8_decode($pot6), 1, "C");

$pdf->SetXY(5, 61);
$pdf->MultiCell(25, 8, utf8_decode('Pot 7:'), 1, "C");
$pdf->SetXY(30, 61);
$pdf->MultiCell(25, 8, utf8_decode($pot7), 1, "C");

$pdf->SetXY(5, 69);
$pdf->MultiCell(25, 8, utf8_decode('Pot 8:'), 1, "C");
$pdf->SetXY(30, 69);
$pdf->MultiCell(25, 8, utf8_decode($pot8), 1, "C");

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(55, 5);
$pdf->MultiCell(50, 8, utf8_decode('Valores Diarios'), 1, "C");

$pdf->SetFont('Arial','',8);
$pdf->SetXY(55, 13);
$pdf->MultiCell(25, 8, utf8_decode('Presion Prom'), 1, "C");
$pdf->SetXY(80, 13);
$pdf->MultiCell(25, 8, utf8_decode($presioprom), 1, "C");

$pdf->SetXY(55, 21);
$pdf->MultiCell(25, 8, utf8_decode('Min Granallado'), 1, "C");
$pdf->SetXY(80, 21);
$pdf->MultiCell(25, 8, utf8_decode($mingranillado), 1, "C");

$pdf->SetXY(55, 29);
$pdf->MultiCell(25, 8, utf8_decode('Granalla/Día'), 1, "C");
$pdf->SetXY(80, 29);
$pdf->MultiCell(25, 8, utf8_decode($granallodia), 1, "C");

$pdf->SetFont('Arial','',6);
$pdf->SetXY(55, 37);
$pdf->MultiCell(25, 8, utf8_decode('Prom Granalla Maquina'), 1, "C");
$pdf->SetFont('Arial','',8);
$pdf->SetXY(80, 37);
$pdf->MultiCell(25, 8, utf8_decode($maquina), 1, "C");



$pdf->Image('../vistas/recursos/img/dona/dona.png',80,15,160,80);
$ren=100;

$pdf->SetXY(5, 102);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(205, 8, utf8_decode('Uso de Cabina'), 1, "C");

$ren+=10;

$pdf->SetXY(5, $ren);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(20, 8, utf8_decode('Turno'), 1, "C");

$pdf->SetXY(25, $ren);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(30, 8, utf8_decode('Inicio'), 1, "C");

$pdf->SetXY(55, $ren);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(30, 8, utf8_decode('Fin'), 1, "C");

$pdf->SetXY(85, $ren);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(25, 8, utf8_decode('Tpo uso de cabina'), 1, "C");

$pdf->SetXY(110, $ren);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(25, 8, utf8_decode('Tpo de chorreo'), 1, "C");

$pdf->SetXY(135, $ren);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(25, 8, utf8_decode('Tpo perdido'), 1, "C");

$pdf->SetXY(160, $ren);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(25, 8, utf8_decode('Tpo total'), 1, "C");

$pdf->SetXY(185, $ren);
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(25, 8, utf8_decode('Tpo inactivo'), 1, "C");

 if ($tabla === null) {
     echo "Error al decodificar el JSON.";
 } else {
     
     foreach ($tabla as $key => $value) {
        $ren+=8;
        
        if ($tabla[$key]["turno"]=="Turno 1"){
            $pdf->SetFillColor(7, 181, 232);
        }else if ($tabla[$key]["turno"]=="Turno 2"){
            $pdf->SetFillColor(236, 144, 13);
        }else if ($tabla[$key]["turno"]=="Turno 3"){
            $pdf->SetFillColor(218, 144, 164);
        }
        $pdf->SetXY(5, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(20, 8, utf8_decode($tabla[$key]["turno"]), 1, "C",true);

        $pdf->SetXY(25, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(30, 8, utf8_decode($tabla[$key]["inicio"]), 1, "C",true);

        $pdf->SetXY(55, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(30, 8, utf8_decode($tabla[$key]["fin"]), 1, "C",true);

        $pdf->SetXY(85, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(25, 8, utf8_decode($tabla[$key]["tiempocabina"]), 1, "C",true);

        $pdf->SetXY(110, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(25, 8, utf8_decode($tabla[$key]["tiempochorreo"]), 1, "C",true);

        $pdf->SetXY(135, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(25, 8, utf8_decode($tabla[$key]["tiempoperdido"]), 1, "C",true);

        $pdf->SetXY(160, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(25, 8, utf8_decode($tabla[$key]["tiemporeal"]), 1, "C",true);

        $pdf->SetXY(185, $ren);
        $pdf->SetFont('Arial','',8);
        $pdf->MultiCell(25, 8, utf8_decode($tabla[$key]["tiempoincativo"]), 1, "C",true);
        
        // $pdf->SetFillColor('150','125','255');
      
        //  echo "Nombre: " . $tabla[$key]["turno"]  . "<br>";
     }
 }

$pdf->Output('../pdf/'.$tiporeporte.'_'.$descripcion.'_'.$fechareporte.'.pdf','F');
// $pdf->Output('F','../pdf/ejemplo.pdf');





// dirname(__FILE__).'/Views/


// $nombrePDF =  $tiporeporte.'_'.$descripcion.'_'.$fechareporte.'.pdf';



// $pdf->Output('F',$nombrePDF );

// $pdf->Output('F',$nombrePDF );
?>
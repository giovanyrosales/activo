<?php

require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';   
require_once '../modelo/Select_modelo.php';   
require_once '../modelo/Sustitucion_modelo.php';

$datos = new Selects();
   if( isset($_POST["fechaini"])){
  $fechainicio = $_POST["fechaini"];   
 }
 if( isset($_POST["fechafin"])){
  $fechafin = $_POST["fechafin"];   
 }
  

class PDF extends PDF_MC_Table
{


    // Cabecera de página
    public function Header()
    {
        $this->SetFont('Arial','B',14);
        $this->Ln(0.5); 
        $this->Cell(5,0.5,'',0,0,'L');
        $this->MultiCell(15,0.5,utf8_decode('ALCALDIA MUNICIPAL DE METAPAN'),0,'C');
        $this->Cell(9.5,0.5,'',0,0,'L');
        $this->Cell(6,0.5,'REPORTE DE CUENTAS CONTABLES',0,0,'C'); $this->Image('../images/Logo2.png' , 24 ,1.5, 1.2 , 1.8,'PNG', '');    
        $this->Ln(0.2);
        $this->Cell(8.5,0.5,'',0,0,'L');
        $this->Cell(8,0.5,'___________________________________',0,0,'C');
        $this->Ln(0.7);
        $this->SetFont('Arial','',12);
        $this->Cell(5.5,0.5,'',0,0,'L');
        $this->Cell(14,0.5,'fecha desde:'.date('d-m-Y', strtotime($_POST["fechaini"])).' hasta: '.date('d-m-Y', strtotime($_POST["fechafin"])),0,0,'C');
        $this->Cell(1, 0.5, '', 0, 0, 'L');
        $this->Ln(1);
    }

    public function Footer()
    {
        $this->SetY(-1.5);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 1, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

        $this->Ln();
    }
}
    
  $cods = $datos->getCodigosCont();
  $sustituciones = new Sustitucion();

    

    $pdf = new PDF('L', 'cm', 'letter');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 5, 5);
    $pdf->SetAutoPageBreak(true, 4.9);
    $pdf->AliasNbPages();
    $pdf->SetTitle('Reporte de Cod. Presupuestarios');
    $pdf->AddPage();
    $alto = 0.55;

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(1);

        //Encabezados de la tablar de resumente de reporte de salidas
        $pdf->SetWidths(array(3, 2.5, 16, 3));
        //Definiendo el alto de las filas
        $pdf->DefinirAlto(0.55);
        $pdf->SetAligns(array('C', 'C', 'L', 'C'));


        $altoCabecera = 0.7;
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(237, 237, 237);
        $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
        $pdf->Cell(3, $altoCabecera, utf8_decode("Código"), 1, 0, 'C', 1);
        $pdf->Cell(2.5, $altoCabecera, "Fecha", 1, 0, 'C', 1);
        $pdf->Cell(16, $altoCabecera, "Nombre", 1, 0, 'C', 1);
        $pdf->Cell(3, $altoCabecera, "valor", 1, 1, 'C', 1);


        //Filas de los datos de la tabla de Resumen de reporte de salidas
        $total = 00.00;
        
        foreach ($cods as $codigos) {
            $subsaldo = 0.0;
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(1, 0.55, '', 0, 0, 'L');
            $pdf->Cell(3, 0.55,utf8_decode($codigos["codconta"]), 1, 0, 'C', 1);
            $pdf->Cell(21.5, 0.55,utf8_decode($codigos["nombre"]), 1, 0, 'C', 1);
            $pdf->Ln(0.55);
          $bienes = $datos->getBienByCodCont($codigos["idcodcontable"]);
        if($bienes){
        foreach ($bienes as $bien){ 
            $susti = $sustituciones->getSustitucionById($bien["idbien"]);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(1, 0.55, '', 0, 0, 'L');
              if(count($susti) >= 1){
                    $valorsus = floatval($bien["valor"]);
                    foreach($susti as $dat){
                        $piezanueva = $dat["piezanueva"];
                        $piezasus = $dat["piezasustituida"];
                        $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                    }
                    $pdf->Row(array(utf8_decode($bien["codigo"]), date('d-m-Y', strtotime($bien["fechacompra"])), utf8_decode(substr($bien["descripcion"],0,80)) ,"$ ".$valorsus));
                    }else{
                    $valorsus = floatval($bien["valor"]);
                    $pdf->Row(array(utf8_decode($bien["codigo"]), date('d-m-Y', strtotime($bien["fechacompra"])), utf8_decode(substr($bien["descripcion"],0,80)) ,"$ ".$valorsus));
                    }
                    $subsaldo = floatval($subsaldo) + floatval($valorsus);
                    
           
                 }
            }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(1, 0.55, '', 0, 0, 'L');
        $pdf->Cell(21.5, 0.55, 'TOTAL DE '.utf8_decode($codigos["nombre"]).':', 1, 0, 'C');
        $pdf->Cell(3, 0.55,'$'. $subsaldo, 1, 0, 'C');
        $pdf->Ln(0.80);  
        
    }
        
    $pdf->Ln(2);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(1.35, 0.75, '', 0, 0, 'L');
    $pdf->Cell(1, 0.75, utf8_decode("_________________________________"), 0, 0, 'L');
    $pdf->Ln(0.5);
    $pdf->Cell(1.5, 0.75, '', 0, 0, 'L');
    $pdf->Cell(1, 0.75, utf8_decode("Lic. Esmeralda de Contreras"), 0, 0, 'L');
    $pdf->Ln(0.4);
    $pdf->Cell(1.65, 0.75, '', 0, 0, 'L');
    $pdf->Cell(1, 0.75, utf8_decode("Activo fijo"), 0, 0, 'L');
    // Posición: a 1,5 cm del final
    $pdf->SetY(-1.5);
    // Arial italic 8
    $pdf->SetFont('Arial', 'I', 8);





    $pdf->Output('I', 'Inventario_Codigo_Presupuestario'.'.PDF', true);

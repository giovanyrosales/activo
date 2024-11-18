<?php
error_reporting(0);
session_start();

require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';   
require_once '../modelo/Select_modelo.php';   
require_once '../modelo/Sustitucion_modelo.php';

$datos = new Selects();


class PDF extends PDF_MC_Table
{    
     
  // Cabecera de página
  function Header()
  {        
      $this->SetFont('Arial','B',16);
      $this->Ln(1); 
      $this->Cell(5,0.5,'',0,0,'L');
      $this->MultiCell(15,0.5,utf8_decode('ALCALDIA MUNICIPAL DE SANTA ANA NORTE'),0,'C');
      $this->Cell(9.5,0.5,'',0,0,'L');
      $this->Cell(6,0.5,'REPORTE DE CUENTAS CONTABLES',0,0,'C'); $this->Image('../images/LOGO.png' , 24 ,2, 1.2 , 1.8,'PNG', '');    
      $this->Ln(0.2);
      $this->Cell(8.5,0.5,'',0,0,'L');
      $this->Cell(8,0.5,'___________________________________',0,0,'C');
      $this->Ln(0.7);
      $this->SetFont('Arial','',12);
      $this->Cell(5.5,0.5,'',0,0,'L');
      $this->Cell(14,0.5,'fecha desde:'.date('d-m-Y', strtotime($_POST["fechaini"])).' hasta: '.date('d-m-Y', strtotime($_POST["fechafin"])),0,0,'C');
      $this->Ln(2.5);
      

  }

  function Footer()
  {
      $this->SetY(-4);
      $this->SetFont('Arial','',10);
      $this->Cell(1.6,0.75,'',0,0,'L');
      $this->Cell(1,0.75,utf8_decode("________________________"),0,0,'L');
      $this->Ln(0.5); 
      $this->Cell(1.6,0.75,'',0,0,'L');
      $this->Cell(1,0.75,utf8_decode("Lic. Esmeralda de Contreras "),0,0,'L');
      $this->Ln(0.4);  
      $this->Cell(3,0.75,'',0,0,'L');
      $this->Cell(1.5,0.75,utf8_decode("Activo Fijo"),0,0,'L');
      // Posición: a 1,5 cm del final
      $this->SetY(-1.5);
      // Arial italic 8
      $this->SetFont('Arial','I',8);
      // Número de página
      $this->Cell(0,1,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }
} 

    $pdf=new PDF('L', 'cm', 'letter');     
  
    $pdf->SetAutoPageBreak(true, 4.9);
    $pdf->AliasNbPages();
    $pdf->AddPage();  

    // verificar tipo de reporte

   if( isset($_POST["fechaini"])){
  $fechainicio = $_POST["fechaini"];   
 }
 if( isset($_POST["fechafin"])){
  $fechafin = $_POST["fechafin"];   
 }
  
  $cods = $datos->getCodigosCont();
  $sustituciones = new Sustitucion();

    $pdf->SetFont('Arial','B',11);
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(1,0.5,'',0,0,'L');
    $pdf->Cell(2.5,0.5,"CODIGO", 1, 0, 'C', 1);
    $pdf->Cell(3,0.5,"FECHA", 1, 0, 'C', 1);
    $pdf->Cell(16,0.5,"NOMBRE", 1, 0, 'C', 1);
    $pdf->Cell(3,0.5,"VALOR", 1, 0, 'C', 1);
    $pdf->Ln(0.5);
    
 foreach ($cods as $codigos){
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(1,0.75,'',0,0,'L');
    $pdf->Cell(5.5,0.75,$codigos["codconta"], 1, 0, 'C', 1);
    $pdf->Cell(16,0.75,$codigos["nombre"], 1, 0, 'C', 1); 
    //$saldos = $datos->getSaldoCodConta($codigos["idcodcontable"]);
    $pdf->Cell(3,0.75,"", 1, 0, 'R', 1); 
    
    //Variable que almacenara el valor de cada bien
    $subsaldo = 0.0;
    
    $pdf->Ln(0.75); 
    
    $bienes = $datos->getBienByCodCont($codigos["idcodcontable"]);
    if($bienes){
    foreach ($bienes as $bien){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(1,0.5,'',0,0,'L');
    $pdf->Cell(2.5,0.5,$bien["codigo"], 1, 0, 'C', 0);
    $pdf->Cell(3,0.5,date('d-m-Y', strtotime($bien["fechacompra"])), 1, 0, 'C', 0);
    $pdf->Cell(16,0.5, utf8_decode(substr($bien["descripcion"],0,80)), 1, 0, 'L', 0); 
            $susti = $sustituciones->getSustitucionById($bien["idbien"]);
              if(count($susti) >= 1){
                    $valorsus = floatval($bien["valor"]);
                    foreach($susti as $dat){
                        $piezanueva = $dat["piezanueva"];
                        $piezasus = $dat["piezasustituida"];
                        $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                    }
                    $pdf->Cell(3,0.5,"$ ".$valorsus, 1, 0, 'R', 0); 
                    }else{
                    $valorsus = floatval($bien["valor"]);
                    $pdf->Cell(3,0.5,"$ ".floatval($valorsus), 1, 0, 'R', 0); 
                    }
                    $subsaldo = floatval($subsaldo) + floatval($valorsus);
            $pdf->Ln(0.5);

         }
            
    }
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(1,0.75,'',0,0,'L');
            $pdf->Cell(21.5,0.75,'TOTAL DE '.$codigos["nombre"].': ', 1, 0, 'C', 1);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(3,0.75,'$ '.$subsaldo, 1, 0, 'C', 1); 
            $pdf->Ln(1);
 }
           
  
   $pdf->Output();



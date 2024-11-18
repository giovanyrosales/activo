<?php
error_reporting(0);
session_start();


    require_once('../pdf/pdf_mc_table.php');  
    require_once '../modelo/Diesel_modelo.php';     
  
class PDF extends PDF_MC_Table
{    
  // Cabecera de página
  function Header()
  {        
      $this->SetFont('Arial','B',16);
      $this->Ln(1);
      $this->Image('../images/elsalvador.png' , 2 ,1, 2 , 2,'PNG', '');   
      $this->Cell(4,0.5,'',0,0,'L');
      $this->MultiCell(17,0.5,utf8_decode('PLANTA DE ASFALTO Y TRITURACIÓN'),0,'C');
      $this->Cell(9,0.5,'',0,0,'L');
      $this->Cell(7,0.5,'REPORTE SALIDA DE DIESEL',0,0,'C'); $this->Image('../images/LOGO.png' , 24 ,1, 2.4 , 1.7,'PNG', '');    
      $this->Ln(0.2);
      $this->Cell(8,0.5,'',0,0,'L');
      $this->Cell(8,0.5,'_____________________________________',0,0,'C');
      $this->Ln(1.5);
      $this->Cell(2,0.5,'',0,0,'L');

  }

  function Footer()
  {
      $this->SetY(-4);
      $this->SetFont('Arial','',10);
      $this->Cell(1.6,0.75,'',0,0,'L');
      $this->Cell(1,0.75,utf8_decode("________________________"),0,0,'L');
      $this->Ln(0.5); 
      $this->Cell(2,0.75,'',0,0,'L');
      $this->Cell(1,0.75,utf8_decode("Ing. Antonio Magaña "),0,0,'L');
      $this->Ln(0.4);  
      $this->Cell(1.7,0.75,'',0,0,'L');
      $this->Cell(1,0.75,utf8_decode("Jefe de Planta de Asfalto"),0,0,'L');
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
    // 1- reporte por maquina
    // 2- reporte por tiempo

    $tipo = $_POST["intervencion"]; 
    $codigo = $_POST["codigo"];
    $disel = new Diesel();

    //$datos = $disel->getMaquina($codigo); // envio codigo de maquina, obtengo id de maquina
    $gasolina;
    
    $fechainicio = $_POST["fechainicio"];
    $fechafinal = $_POST["fechafinal"];

    $galonaje = $disel->getTotalGalonajeProyecto($codigo);  

    if($tipo == 'proyecto'){      
      
        $gasolina = $disel->getReportePorProyecto($codigo); 
        $galonaje = $disel->getTotalGalonajeProyecto($codigo);   
        $informacion = $disel->getInfoProyecto($codigo);    

        $pdf->SetFont('Arial','B',12);

        $pdf->Cell(-0.0001,0.5,'',0,0,'L');
        $pdf->MultiCell(16,0.5,utf8_decode("Código de Proyecto: ".$informacion["codigo"]),0,'L'); 
        $pdf->Cell(2,0.5,'',0,0,'L');
        $pdf->MultiCell(21,0.5,utf8_decode("Nombre del Proyecto: ".$informacion["nombre"]),0,'L'); 
        $pdf->Ln();
        $pdf->Cell(2,2.0,'',0,0,'L');
        $pdf->MultiCell(16,0.5,utf8_decode("Total Galonaje: ".$galonaje["totalgalonaje"]),0,'L'); 
        $pdf->Cell(2,0.5,'',0,0,'L');

    }
    else if($tipo == 'fecha'){
    

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(-0.0001,0.5,'',0,0,'L');        
        $pdf->MultiCell(16,0.5,utf8_decode("Período Desde: $fechainicio hasta $fechafinal "),0,'L');
        
         
        $gasolina = $disel->getReporteFecha($fechainicio, $fechafinal);
    }
    
    $pdf->Ln(1); 
   
    //Encabezados de la tablar de resumente de reporte de salidas
    $pdf->SetWidths(Array(3,8,8,3));

    $pdf->SetLineHeight(0.5);

    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(2,0.5,'',0,0,'L');
    $pdf->Cell(3,0.5,"Fecha", 1, 0, 'C', 1);
    $pdf->Cell(8,0.5,"Uso", 1, 0, 'C', 1);
    $pdf->Cell(8,0.5,"Informacion", 1, 0, 'C', 1);
    $pdf->Cell(3,0.5,"Galonaje", 1, 0, 'C', 1);
    $pdf->Ln(0.5);

    //Filas de los datos de la tabla de Resumen de reporte de salidas
   foreach ($gasolina as $value) {
        $pdf->Cell(2,0.5,'',0,0,'L');
        $pdf->SetFont('Arial','',12);
        $pdf->Row(Array($value['fecha'], $value['uso'],$value['informacion'],$value['galonaje']));      
    }
  
  
   $pdf->Output();



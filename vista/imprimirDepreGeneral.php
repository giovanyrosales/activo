<?php
//error_reporting(0);
session_start();

require('../fpdf/fpdf.php');
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->SetFont('Arial','B',14);
    $this->Ln(1);
    $this->Cell(10,0.5,'',0,0,'L');
    $this->Cell(5,0.5,utf8_decode('ALCALDIA MUNICIPAL DE METAPÁN'),0,0,'C'); $this->Image('../images/Logo2.png' , 23 ,1, 1.5 , 2,'PNG', '');  
    $this->Ln(0.6);
    $this->Cell(10,0.5,'',0,0,'L');
    $this->Cell(5,0.5,utf8_decode('ACTIVO FIJO'),0,0,'C'); 
    $this->Ln(0.6);
    $this->Cell(9,0.5,'',0,0,'C');
    $this->MultiCell(16,0.5,utf8_decode("DEPRECIACION ANUAL ".$_POST["anio"]),0,'L');
    $this->Ln(0.5);
    //Creamos las celdas para los titulo de cada columna y le asignamos un fondo gris y el tipo de letra
}
//hasta aqui termina el metodo con el que creo el header del documento de la bitacora
// Pie de página
function Footer()
{
    $this->SetY(-4);
    $this->SetFont('Arial','',10);
    $this->Cell(1.6,0.75,'',0,0,'L');
    $this->Cell(1,0.75,utf8_decode("________________________"),0,0,'L');
    $this->Ln(0.5); 
    $this->Cell(2,0.75,'',0,0,'L');
    $this->Cell(1,0.75,utf8_decode("Lic. Esmeralda Rodriguez"),0,0,'L');
    $this->Ln(0.4);  
    $this->Cell(1.5,0.75,'',0,0,'L');
    $this->Cell(1,0.75,utf8_decode("Encargada de Inventario y Activo Fijo"),0,0,'L');

    // Posición: a 1,5 cm del final
    $this->SetY(-1.5);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,1,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
//Instanciamos la clase para generar el documento pdf
    $pdf=new PDF('L', 'cm', 'letter');
    $pdf->SetAutoPageBreak(true, 4.5);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    $coddepre = new Selects();
    $historiales = new Bienes();
    $anio = $_POST["anio"];
    setlocale(LC_MONETARY, 'en_US');

    $pdf->SetFillColor(211,211,211);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(0.5,0.5,'',0,0,'L');
    $pdf->Cell(3.5,0.5,utf8_decode('CODIGO'),1,0,'C',1);
    $pdf->Cell(12,0.5,utf8_decode('DESCRIPCION'),1,0,'C',1);
    $pdf->Cell(2,0.5,utf8_decode('RUBRO'),1,0,'C',1);
    //$pdf->Cell(1,0.5,utf8_decode('AÑO'),1,0,'C',1);
    $pdf->Cell(2,0.5,utf8_decode('DEP. ANUAL'),1,0,'C',1);
    $pdf->Cell(2,0.5,utf8_decode('24199017'),1,0,'C',1);
    $pdf->Cell(2,0.5,utf8_decode('24199019'),1,0,'C',1);
    $pdf->Cell(2,0.5,utf8_decode('24199023'),1,0,'C',1);
    $pdf->Ln(0.5);
    
    $historial = $historiales->getHistorialDa($anio);
    $total17 = 0.00;
    $total19 = 0.00;
    $totaldep = 0.00;
    foreach ($historial as $data){
    $datosbien = $historiales->getBien($data["bien"]);
    $espropio = $coddepre->getOrigen($data["bien"]);
    if($espropio["origen"] == 'propio'){  
        $estado = $historiales->estadoDescargo($data["bien"]);
        if($estado["estado"] != 2){
            $datoscoddepre = $coddepre->getCodDep($datosbien["coddepreciacion"]);
        
                $pdf->SetFillColor(255,255,255);
                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(0.5,0.5,'',0,0,'L');
                $pdf->Cell(3.5,0.5,utf8_decode($datosbien["codigo"]),1,0,'C',1);
                $pdf->Cell(12,0.5,substr(utf8_decode($datosbien["descripcion"]),0,58)."...",1,0,'L',1);
                $pdf->Cell(2,0.5,utf8_decode($datoscoddepre["coddepre"]),1,0,'C',1);
                //$pdf->Cell(1,0.5,utf8_decode($datosbien["anio"]),1,0,'C',1);
                $pdf->Cell(2,0.5,utf8_decode("$ ".$data["depanual"]),1,0,'R',1);
                $totaldep = $totaldep + floatval($data["depanual"]);
                
                if($datoscoddepre["coddepre"] == "24199017"){
                    $total17 = $total17 + floatval($data["depanual"]);
                    $pdf->Cell(2,0.5,utf8_decode("$ ".$data["depanual"]),1,0,'R',1);
                    $pdf->Cell(2,0.5,utf8_decode('$ 0.00'),1,0,'R',1);  
                    $pdf->Cell(2,0.5,utf8_decode('$ 0.00'),1,0,'R',1);  
                }elseif($datoscoddepre["coddepre"] == "24199019"){
                    $total19 = $total19 + floatval($data["depanual"]);
                    $pdf->Cell(2,0.5,utf8_decode('$ 0.00'),1,0,'R',1);
                    $pdf->Cell(2,0.5,utf8_decode("$ ".$data["depanual"]),1,0,'R',1);  
                    $pdf->Cell(2,0.5,utf8_decode('$ 0.00'),1,0,'R',1);  
                }elseif($datoscoddepre["coddepre"] == "24199023"){
                    $total23 = $total23 + floatval($data["depanual"]);
                    $pdf->Cell(2,0.5,utf8_decode('$ 0.00'),1,0,'R',1);
                    $pdf->Cell(2,0.5,utf8_decode('$ 0.00'),1,0,'R',1);  
                    $pdf->Cell(2,0.5,utf8_decode("$ ".$data["depanual"]),1,0,'R',1);  
                }
            $pdf->Ln(0.5); 
            }
        } else {
            continue;
        }
    }
        //Totales
        $pdf->Cell(18,0.5,'',0,0,'L');
        $pdf->Cell(2,0.5, "$ ".round($totaldep,2),1,0,'R',1);
        $pdf->Cell(2,0.5, "$ ".round($total17,2),1,0,'R',1);
        $pdf->Cell(2,0.5, "$ ".round($total19,2),1,0,'R',1);
	    $pdf->Cell(2,0.5, "$ ".round($total23,2),1,0,'R',1);
    
//Mostramos el documento pdf
    $pdf->Output();


<?php

require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Config_modelo.php';
require_once '../modelo/Sustitucion_modelo.php';

class PDF extends PDF_MC_Table
{
public $contado=0;

    // Cabecera de página
    public function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Ln(1);
        $this->Image('../images/elsalvador.png', 1, 1, 2, 2, 'PNG', '');
        $this->Cell(3.5, 0.5, '', 0, 0, 'L');
        $this->MultiCell(12, 0.5, utf8_decode('UNIDAD DE INVENTARIO Y ACTIVO FIJO'), 0, 'C');
        $this->Cell(6, 0.5, '', 0, 0, 'L');
        $this->Cell(7, 0.5, 'REPORTE DE INVENTARIO', 0, 0, 'C');
        $this->Image('../images/LOGO.png', 18, 1, 2.4, 1.7, 'PNG', '');
        $this->Ln(0.2);
        $this->Cell(5.5, 0.5, '', 0, 0, 'L');
        $this->Cell(8, 0.5, '___________________________________________', 0, 0, 'C');
        $this->Ln(1.5);
        $this->Cell(1, 0.5, '', 0, 0, 'L');
    }

    public function Footer()
    {
        $this->SetY(-1.4);
        $this->SetFont('Arial', 'I', 8);
        if ($this->getIsFinished()) {
            $this->SetY(-3);
            $this->SetFont('Arial', '', 10);
            $this->Cell(1.35, 0.75, '', 0, 0, 'L');
            $this->Cell(1, 0.75, utf8_decode("_________________________________"), 0, 0, 'L');
            $this->Ln(0.5);
            $this->Cell(1.5, 0.75, '', 0, 0, 'L');
            $this->Cell(1, 0.75, utf8_decode("Lic Esmeralda Rodriguez de Contreras "), 0, 0, 'L');
            $this->Ln(0.4);
            $this->Cell(1.65, 0.75, '', 0, 0, 'L');
            $this->Cell(1, 0.75, utf8_decode("Encargada  de Inventario y Activo fijo"), 0, 0, 'L');
            // Posición: a 1,5 cm del final
        }
        $this->SetY(-1.4);
        $this->SetFont('Arial', 'I', 8);

        // Número de página
        $this->Cell(0, 1, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    
    }
}
if (isset($_POST["descriptor"])) {
    setcookie("descriptor", $_POST['descriptor']);
    Header('location: Descriptor.php');
} else {
    $config = new Config();
    $descriptor = $config->getDescriptor($_COOKIE['descriptor']);
    $bienes = new Bienes();
    $datosbienes = $bienes->getMueblesByDescriptor($_COOKIE['descriptor']);
    $sustituciones = new Sustitucion();
    

    $pdf = new PDF('P', 'cm', 'A4');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 5, 5);
    $pdf->SetAutoPageBreak(true, 4.9);
    $pdf->AliasNbPages();
    $pdf->SetTitle(utf8_decode($descriptor['descripcion']));
    $pdf->AddPage();
    $alto = 0.55;
    $pdf->Cell(2, 0.8, '', 0, 0, 'L');
    $pdf->Cell(13, 0.8, utf8_decode("DESCRIPTOR: " . $descriptor['descripcion']), 0, 0, 'C', 0);
    $pdf->Ln();

    $pdf->Cell(2, 0.8, '', 0, 0, 'L');
    $pdf->Cell(13, 0.8, "TOTAL BIENES: " . count($datosbienes), 0, 0, 'C', 0);
    $pdf->Ln();

    if ($datosbienes != null) {
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Ln(1);

        //Encabezados de la tablar de resumente de reporte de salidas
        $pdf->SetWidths(array(3, 8, 3.5, 2.5));
        //Definiendo el alto de las filas
        $pdf->DefinirAlto(0.55);
        $pdf->SetAligns(array('C', 'L', 'C', 'C'));


        $altoCabecera = 0.7;
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(237, 237, 237);
        $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
        $pdf->Cell(3, $altoCabecera, utf8_decode("Código"), 1, 0, 'C', 1);
        $pdf->Cell(8, $altoCabecera, "Descripcion", 1, 0, 'C', 1);
        $pdf->Cell(3.5, $altoCabecera, "Fecha Compra", 1, 0, 'C', 1);
        $pdf->Cell(2.5, $altoCabecera, "valor", 1, 1, 'C', 1);


        //Filas de los datos de la tabla de Resumen de reporte de salidas
        
        
        foreach ($datosbienes as $bien) {
            
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(1, 0.55, '', 0, 0, 'L');
            $susti = $sustituciones->getSustitucionById($bien["idbien"]);
              if(count($susti) >= 1){
                    $valorsus = floatval($bien["valor"]);
                    foreach($susti as $dat){
                        $piezanueva = $dat["piezanueva"];
                        $piezasus = $dat["piezasustituida"];
                        $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                    }
                     $pdf->Row(array(utf8_decode($bien['codigo']), utf8_decode($bien['descripcion']), $bien['fechacompra'], '$ '.$valorsus));
                    }else{
                     $pdf->Row(array(utf8_decode($bien['codigo']), utf8_decode($bien['descripcion']), $bien['fechacompra'], '$ '.$bien['valor']));
                    }
           
        }
       
        
        

    } else {
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(1, 0.8, '', 0, 0, 'L');
        $pdf->Cell(13, 0.8, utf8_decode('No hay Registros para este departamento'), 0, 0, 'C', 0);
    }
    $pdf->setIsFinished(true);



    $pdf->Output('I', 'Bienes_' . $descriptor['descripcion'].'.PDF', true);
}



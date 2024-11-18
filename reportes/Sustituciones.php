<?php

require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';

class PDF extends PDF_MC_Table {

    // Cabecera de página
    public function Header() {
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

    public function Footer() {
        $this->SetY(-1.5);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 1, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

        $this->Ln();
    }
}

if (isset($_POST["fechainicial"]) && isset($_POST["fechafinal"]) ) {
    setcookie("fechainicial", $_POST["fechainicial"]);
    setcookie("fechafinal", $_POST["fechafinal"]);
    header("location:Sustituciones.php");
} else {
    $select = new Selects();
    $reposiciones = $select->getRepVitalByDate($_COOKIE["fechainicial"], $_COOKIE["fechafinal"]);
    $fechaini = date_create($_COOKIE["fechainicial"]);
    $fechafin = date_create($_COOKIE["fechafinal"]);
    
    $title = utf8_decode("Reposicion Vital realizadas desde ") . date_format($fechaini, 'd-m-Y') . " hasta " . date_format($fechafin, 'd-m-Y');

 $pdf = new PDF('P', 'cm', 'A4');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 5, 5);
    $pdf->SetAutoPageBreak(true, 4.9);
    $pdf->AliasNbPages();
    $pdf->SetTitle(utf8_decode($title));
    $pdf->AddPage();
    $alto = 0.55;
    $pdf->Cell(2, 0.8, '', 0, 0, 'L');
    $pdf->Cell(13, 0.8, utf8_decode($title), 0, 0, 'C', 0);
    $pdf->Ln();


    if (isset($reposiciones) && $reposiciones != null) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(1);

        //Encabezados de la tablar de resumente de reporte de salidas
        $pdf->SetWidths(array(4, 3, 3, 3, 3));
        //Definiendo alineacion de las filas
        $pdf->SetAligns(array('C', 'R', 'R', 'C', 'C'));
        //Definiendo el alto de las filas
        $pdf->DefinirAlto(0.55);

        $altoCabecera = 0.7;
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetFillColor(237, 237, 237);
        $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
        $pdf->Cell(4, $altoCabecera, utf8_decode("Código del bien"), 1, 0, 'C', 1);
        $pdf->Cell(3, $altoCabecera, "Pieza Sust.", 1, 0, 'C', 1);
        $pdf->Cell(3, $altoCabecera, "Pieza Nueva", 1, 0, 'C', 1);
        $pdf->Cell(3, $altoCabecera, "Vida Util Ag.", 1, 0, 'C', 1);
        $pdf->Cell(3, $altoCabecera, "Fecha", 1, 1, 'C', 1);

        //Filas de los datos de la tabla de Resumen de reporte de salidas
        foreach ($reposiciones as $sus) {
            $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
            $pdf->SetFont('Arial', '', 9);
            $datosbien = $select->getCodBien($sus['bien']);
            $pdf->Row(array(utf8_decode($datosbien["codigo"]), "$ ".number_format($sus['piezasustituida'],2,'.',','), "$ ".number_format($sus['piezanueva'],2,'.',','), $sus['vidautil'], $sus['fecha']));
        }
    } else {
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(2, 0.8, '', 0, 0, 'L');
        $pdf->Cell(14, 0.8, utf8_decode('No hay Registros '), 0, 0, 'C', 0);
    }

    $pdf->Ln(2);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(1.35, 0.75, '', 0, 0, 'L');
    $pdf->Cell(1, 0.75, utf8_decode("_________________________________"), 0, 0, 'L');
    $pdf->Ln(0.5);
    $pdf->Cell(1.5, 0.75, '', 0, 0, 'L');
    $pdf->Cell(1, 0.75, utf8_decode("Lic Esmeralda Rodriguez de Contreras "), 0, 0, 'L');
    $pdf->Ln(0.4);
    $pdf->Cell(1.65, 0.75, '', 0, 0, 'L');
    $pdf->Cell(1, 0.75, utf8_decode("Encargada  de Inventario y Activo fijo"), 0, 0, 'L');
    // Posición: a 1,5 cm del final
    $pdf->SetY(-1.5);
    // Arial italic 8
    $pdf->SetFont('Arial', 'I', 8);




    $pdf->Output('I', $title.'.PDF', true);
}

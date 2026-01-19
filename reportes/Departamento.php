<?php

require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Config_modelo.php';
require_once '../modelo/Sustitucion_modelo.php';

class PDF extends PDF_MC_Table
{


    // Cabecera de página
    public function Header()
    {
        // Posición inicial
    $this->SetY(1);
    $this->SetFont('Arial', '', 10);

    // ===== CONTENEDOR GENERAL =====
    $this->Rect(1, 1, 19, 3);

    // ===== DIVISIÓN VERTICAL GENERAL (IZQ / DER) =====
    $this->Line(13, 1, 13, 4);

    // ===============================
    // BLOQUE IZQUIERDO
    // ===============================

    // División logo / título
    $this->Line(4, 1, 4, 4);

    // Logo
    $this->Image('../images/LOGO.png', 1.4, 1.3, 2.2);

    // Título central
    $this->SetFont('Arial', 'B', 14);
    $this->SetXY(4, 1.6);
    $this->MultiCell(
        9,
        0.8,
        utf8_decode("REPORTE DE INVENTARIO DE\nBIENES MUEBLES"),
        0,
        'C'
    );

    // ===============================
    // BLOQUE DERECHO
    // ===============================

    // Líneas horizontales
    $this->Line(13, 2, 20, 2);
    $this->Line(13, 3, 20, 3);

    // División columna etiqueta / valor
    $this->Line(16.2, 1, 16.2, 4);
    $this->SetFont('Arial', 'B', 10);

    // Código
    $this->SetXY(13.2, 1.25);
    $this->Cell(3.6, 0.6, utf8_decode('Código:'), 0, 0, 'L');
    $this->Cell(3, 0.6, 'INVE-006-REPO', 0, 0, 'C');

    // Versión
    $this->SetXY(13.2, 2.25);
    $this->Cell(3.6, 0.6, utf8_decode('Versión:'), 0, 0, 'L');
    $this->Cell(3, 0.6, '000', 0, 0, 'C');

    // Fecha
    $this->SetXY(13.2, 3.25);
    $this->Cell(3.6, 0.6, utf8_decode("Fecha de\nvigencia:"), 0, 0, 'L');
    $this->Cell(3, 0.6, '22/10/2025', 0, 0, 'C');

    // Espacio para el contenido
    $this->Ln(2);
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
if (isset($_POST["departamento"])) {
    setcookie("departamento", $_POST['departamento']);
    Header('location: Departamento.php');
} else {
    
    $sustituciones = new Sustitucion();
    $config = new Config();
    $departamento = $config->getDepto($_COOKIE['departamento']);
    $bienes = new Bienes();
    $datosbienes = $bienes->getMueblesByDepartamento($_COOKIE['departamento']);

    

    $pdf = new PDF('P', 'cm', 'A4');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(5, 5, 5);
    $pdf->SetAutoPageBreak(true, 4.9);
    $pdf->AliasNbPages();
    $pdf->SetTitle(utf8_decode($departamento['nombre']));
    $pdf->AddPage();
    $alto = 0.55;
    $pdf->Cell(2, 0.8, '', 0, 0, 'L');
    $pdf->Cell(13, 0.8, utf8_decode("DEPARTAMENTO: " . $departamento['nombre']), 0, 0, 'C', 0);
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
        $total = 00.00;
        
        foreach ($datosbienes as $bien) {
            $total += $bien['valor'];
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
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
        $pdf->Cell(14.5, $altoCabecera, 'TOTAL', 1, 0, 'C');
        $pdf->Cell(2.5, $altoCabecera,'$'. $total, 1, 0, 'C');
    } else {
        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(1, 0.8, '', 0, 0, 'L');
        $pdf->Cell(13, 0.8, utf8_decode('No hay Registros para este departamento'), 0, 0, 'C', 0);
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





    $pdf->Output('I', 'Bienes_' . $departamento['nombre'].'.PDF', true);
}

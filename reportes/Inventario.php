<?php
//error_reporting(0);
require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Sustitucion_modelo.php';

class PDF extends PDF_MC_Table
{


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
    $this->Image('../images/LOGO.png', 17, 1.5, 2.4, 1.7, 'PNG', '');
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

$bienes = new Bienes();
$sustituciones = new Sustitucion();

if (isset($_POST["tipoBien"])) {
  if (isset($_POST['mueblesfiltro'])) {
    setcookie("filtro", $_POST['mueblesfiltro']);
  }
  setcookie("tipoBien", $_POST['tipoBien']);
  setcookie("filtro", $_POST['mueblesfiltro']);
  header("location:Inventario.php");
} else {
  switch ($_COOKIE["tipoBien"]) {
    case "1":
      switch ($_COOKIE["filtro"]) {
        case "1":
          $datosbienes = $bienes->getMueblesMay900();
          $title = "Bienes Muebles Municipales mayores a $900";
          $cabeceras = ['Nº de Mueble', 'Descripción', 'Fecha de Compra', 'Valor compra'];
          break;
        case "2":
          $datosbienes = $bienes->getMueblesMen900();
          $title = "Bienes Muebles Municipales menores a $900";
          $cabeceras = ['Nº de Mueble', 'Descripción', 'Fecha de Compra', 'Valor compra'];
          break;
        case "3":
          $datosbienes = $bienes->getMuebles();
          $title = "Bienes Muebles Municipales";
          $cabeceras = ['Nº de Mueble', 'Descripción', 'Fecha de Compra', 'Valor compra'];
          break;
      }
      break;
    case "2":
      $datosbienes = $bienes->getInmuebles();
      $title = "Bienes Inmuebles Municipales";
      $cabeceras = ['Nº', 'Descripción','#CNR', 'Fecha de Compra', 'Edificaciones', 'Valor de escritura'];
      break;
    case "3":
      $datosbienes = $bienes->getVehiculos();
      $title = "Vehiculos Municipales Livianos y Pesados";
      $cabeceras = ['Nº de Mueble', 'Descripción', 'Fecha de Compra', 'Valor'];
      break;
  }
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

  if (isset($datosbienes) && $datosbienes != null) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(1);

    //Encabezados de la tablar de resumente de reporte de salidas

    //Definiendo alineacion de las filas
    $pdf->SetAligns(array('C', 'C', 'C', 'C'));
    //Definiendo el alto de las filas
    $pdf->DefinirAlto(0.55);

    $altoCabecera = 0.7;
    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
    switch ($_COOKIE["tipoBien"]) {
      case "1":
        $pdf->SetFont('Arial', 'B', 11);
      
        $pdf->SetWidths(array(2, 9.5, 3, 2.5));
        $pdf->Row(array(utf8_decode($cabeceras[0]), utf8_decode($cabeceras[1]), utf8_decode($cabeceras[2]), utf8_decode($cabeceras[3])));
        break;
      case "2":
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->SetWidths(array(1, 6.5,2, 2, 3, 2.5));
        $pdf->Row(array(utf8_decode($cabeceras[0]), utf8_decode($cabeceras[1]), utf8_decode($cabeceras[2]), utf8_decode($cabeceras[3]), utf8_decode($cabeceras[4]),utf8_decode($cabeceras[5])));
        break;
      case "3":
        $pdf->SetFont('Arial', 'B', 11); 
        $pdf->SetWidths(array(2, 9.5, 3, 2.5));
        $pdf->Row(array(utf8_decode($cabeceras[0]), utf8_decode($cabeceras[1]), utf8_decode($cabeceras[2]), utf8_decode($cabeceras[3])));
        break;
    }
    switch ($_COOKIE["tipoBien"]) {
      case "1":
        $pdf->SetAligns(array('C', 'L', 'C', 'C'));
        break;
      case "2":
        $pdf->SetAligns(array('C', 'L','C', 'C', 'C', 'C'));
        break;
      case "3":
        $pdf->SetAligns(array('C', 'L', 'C', 'C'));
        break;
    }



    $pdf->SetAligns(array('C', 'L', 'C', 'C'));
    //Filas de los datos de la tabla de Resumen de reporte de salidas
    $total = 00.00;
    foreach ($datosbienes as $bien) {

      $total += $bien['valor'];
      switch ($_COOKIE["tipoBien"]) {
        case "1":
          $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
          $pdf->SetFont('Arial', '', 8.5);
            $susti = $sustituciones->getSustitucionById($bien["idbien"]);
                  if(count($susti) >= 1){
                        $valorsus = floatval($bien["valor"]);
                        foreach($susti as $dat){
                            $piezanueva = $dat["piezanueva"];
                            $piezasus = $dat["piezasustituida"];
                            $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                        }
          $pdf->Row(array(utf8_decode($bien['codigo']), utf8_decode($bien["descripcion"]), $bien['fechacompra'], '$' . $valorsus));
           }else{
            $pdf->Row(array(utf8_decode($bien['codigo']), utf8_decode($bien["descripcion"]), $bien['fechacompra'], '$' . $bien['valor']));   
           }
          break;
        case "2":
          $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
          $pdf->SetFont('Arial', '', 9);
          $pdf->Row(array(utf8_decode($bien['codigo']),utf8_decode($bien["descripcion"]), utf8_decode($bien['inscrito']), $bien['fechacompra'], '$' . $bien['edificaciones'], '$' . $bien['valor']));
          break;
        case "3":
          $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
          $pdf->SetFont('Arial', '', 9);
          
             $susti = $sustituciones->getSustitucionById($bien["idbien"]);
                  if(count($susti) >= 1){
                        $valorsus = floatval($bien["valor"]);
                        foreach($susti as $dat){
                            $piezanueva = $dat["piezanueva"];
                            $piezasus = $dat["piezasustituida"];
                            $valorsus = floatval($valorsus) + floatval($piezanueva) - floatval($piezasus);
                        }
          $pdf->Row(array(utf8_decode($bien['codigo']), utf8_decode($bien["descripcion"]), $bien['fechacompra'], '$' . number_format((float)$valorsus, 2, '.', '')));
          }else{
          $pdf->Row(array(utf8_decode($bien['codigo']), utf8_decode($bien["descripcion"]), $bien['fechacompra'], '$' . $bien['valor']));   
          }
          break;
      }
    }
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
    $pdf->Cell(14.5, $altoCabecera, 'TOTAL', 1, 0, 'C');
    $pdf->Cell(2.5, $altoCabecera, '$' . number_format((float)$total,2,'.',''), 1, 0, 'C');
  } else {
    $pdf->SetFont('Arial', '', 11);

    $pdf->Cell(1, 0.8, '', 0, 0, 'L');
    $pdf->Cell(13, 0.8, utf8_decode('No hay Registros '), 0, 0, 'C', 0);
  }
  $pdf->setIsFinished(true);




  $pdf->Output('I', $title.'.PDF', true);
}

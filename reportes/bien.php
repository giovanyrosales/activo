<?php

require_once '../fpdf/mc_table.php';
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Config_modelo.php';

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
        $this->Image('../images/LOGO.png', 17, 1, 2.4, 1.7, 'PNG', '');
        $this->Ln(0.2);
        $this->Cell(5.5, 0.5, '', 0, 0, 'L');
        $this->Cell(8, 0.5, '___________________________________________', 0, 0, 'C');
        $this->Ln(1.5);

        $this->Cell(1, 0.5, '', 0, 0, 'L');
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

if (isset($_POST['codigo']) && isset($_POST['tipoBienReporte'])) {
    setcookie("codigoBien", $_POST["codigo"]);
    setcookie("tipoBienReporte", $_POST['tipoBienReporte']);
    header("location:bien.php");
} else {
    $bienes = new Bienes();
    $config = new Config();
    $bienBuscado  = $bienes->getBienByCod($_COOKIE['codigoBien'], $_COOKIE['tipoBienReporte']);
    if (isset($bienBuscado) && $bienBuscado != null) {
        switch ($bienBuscado['tipo']) {
            case 1:
                $subtitulo = "Biene Mueble";
                break;
            case 2:
                $subtitulo = "Biene Inmueble";
                break;
            case 3:
                $subtitulo = "  Maquinaria y Equipo";
                break;
        }
    } else {
        $subtitulo = " Rubro no encontrado";
    }
    $title = "Reporte para el bien con el código: " . $_COOKIE['codigoBien'];


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
    $pdf->Cell(3, 0.8, '', 0, 0, 'L');
    $pdf->Cell(13, 0.8, utf8_decode($subtitulo), 0, 0, 'C', 0);
    $pdf->Ln();

    if (isset($bienBuscado) && $bienBuscado != null) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(0.5);

        switch ($bienBuscado['tipo']) {
            case 1:
                $altoCabecera = 0.7;
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(4.3, $altoCabecera, utf8_decode("Número de inventario: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['codigo']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);


                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(2.5, $altoCabecera, "Descripcion: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['descripcion']), 0, 'J');
                $pdf->Ln(0.1);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(2.8, $altoCabecera, "Valor del bien: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode("$" . $bienBuscado['valor']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(3.5, $altoCabecera, utf8_decode("Fecha de compra: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['fechacompra']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);



                $departamento = $config->getDepto($bienBuscado['departamento']);
                $descriptor = $config->getDescriptor($bienBuscado['descriptor']);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(3, $altoCabecera, utf8_decode("Departamento: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($departamento['nombre']), 0, 'J');
                $pdf->Ln(0.1);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(2.6, $altoCabecera, utf8_decode("Tipo de bien: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($descriptor['descripcion']), 0, 'L');
                $pdf->Ln(0.1);

                if( $bienBuscado['valor']>900){

                    $codContable =  $config-> getCodConta($bienBuscado['codcontable']);
                    $codDepre = $config->getCodDepre($bienBuscado['codcontable']);

                    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(3.4, $altoCabecera, "Codigo contable: ", 0, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(8, $altoCabecera, utf8_decode($codContable['codconta'].' - '.$codContable['nombre']), 0, 0, 'L', 0);
                    $pdf->Ln(0.8);
    
                    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(4.2, $altoCabecera, "Codigo depreciacion: ", 0, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(8, $altoCabecera, utf8_decode($codDepre['coddepre'].' - '.$codDepre['nombre']), 0, 0, 'L', 0);
                    $pdf->Ln(0.8);

                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                    $pdf->Cell(1.8, $altoCabecera, utf8_decode("Vida util: "), 0, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['vidautil']), 0, 'L');
                    $pdf->Ln(0.1);

                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                    $pdf->Cell(2.6, $altoCabecera, utf8_decode("Valor residual: "), 0, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['valresidual']), 0, 'L');
                    $pdf->Ln(0.1);
    
                }
                if ($bienBuscado['estado'] != null) {
                    switch ($bienBuscado['estado']) {
                        case 1:
                            $estado = 'Activo';
                            break;
                        case 2:
                            $estado = 'Descargado';
                            break;
                        case 3:
                            $estado = 'Vendido';
                            break;
                        case 4:
                            $estado = 'Comodato';
                            break;
                        case 5:
                            $estado = 'Donado';
                            break;
                        default:
                            $estado = 'Activo';
                            break;
                    }
                }

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1.6, $altoCabecera, "Estado: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(2, $altoCabecera, utf8_decode($estado), 0, 0, 'L', 0);


                break;
            case 2:
                $altoCabecera = 0.7;
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(4.3, $altoCabecera, utf8_decode("Número de inventario: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['codigo']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);


                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(2.5, $altoCabecera, "Descripcion: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['descripcion']), 0, 'J');
                $pdf->Ln(0.1);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(4.3, $altoCabecera, utf8_decode("Fecha de adquisición: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['fechacompra']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(2, $altoCabecera, utf8_decode("Contiene: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['contiene']), 0, 'J');
                $pdf->Ln(0.1);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(2.2, $altoCabecera, utf8_decode("Ubicación: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['ubicacion']), 0, 'L');
                $pdf->Ln(0.1);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(3.6, $altoCabecera, "Valor de escritura: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode("$" . $bienBuscado['valor']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(2.8, $altoCabecera, "En comodato: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                if ($bienBuscado['estado'] == 4) {
                    $pdf->Cell(8, $altoCabecera, utf8_decode('SI'), 0, 0, 'L', 0);
                } else {
                    $pdf->Cell(8, $altoCabecera, utf8_decode('NO'), 0, 0, 'L', 0);
                }
                $pdf->Ln(0.8);

                $valuo = $bienes->getReevaluobyBien($bienBuscado['idbien'], $bienBuscado['tipo']);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(3.8, $altoCabecera, "Valor con reevaluo: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                if ($valuo != null) {
                    $pdf->Cell(8, $altoCabecera, utf8_decode("$" . $valuo['valornuevo']), 0, 0, 'L', 0);
                } else {
                    $pdf->Cell(8, $altoCabecera, "Sin Reevaluos", 0, 0, 'L', 0);
                }
                $pdf->Ln(0.8);

                $calculos = $bienes->getCalculosReevaluo($bienBuscado['valor'], $valuo['valornuevo'], $bienBuscado['valorregistrado'], $bienBuscado['edificaciones']);

                if ($calculos['ReevaluoMenos'] !=null ) {
                    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(4, $altoCabecera, "Reevaluo de menos: ", 0, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(8, $altoCabecera, utf8_decode($calculos['ReevaluoMenos']), 0, 0, 'L', 0);
                    $pdf->Ln(0.8);
                }

                if ($calculos['Superarios'] !=null ) {
                    
                    $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(5, $altoCabecera, "Superarios por reevaluos: ", 0, 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(2, $altoCabecera, utf8_decode($calculos['Superarios']), 0, 0, 'L', 0);
                    $pdf->Ln(0.8);
                }

               

               

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(3.3, $altoCabecera, "Valor registrado: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode('$' . $calculos['Vregistrado']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(2.8, $altoCabecera, "Edificaciones: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                if ($bienBuscado['edificaciones'] != null) {
                    $pdf->Cell(8, $altoCabecera, utf8_decode('$' . $bienBuscado['edificaciones']), 0, 0, 'L', 0);
                } else {
                    $pdf->Cell(8, $altoCabecera, utf8_decode('No registrado'), 0, 0, 'L', 0);
                }

                $pdf->Ln(0.8);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(9.1, $altoCabecera, "Valor registrado + Edificaciones e Instalaciones: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(3, $altoCabecera, utf8_decode('$' . $calculos['sumatoria']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(3, $altoCabecera, utf8_decode("Observaciones: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(13, $altoCabecera, utf8_decode($bienBuscado['observaciones']), 0, 'J');
                $pdf->Ln(0.1);

                if ($bienBuscado['estado'] != null) {
                    switch ($bienBuscado['estado']) {
                        case 1:
                            $estado = 'Activo';
                            break;
                        case 2:
                            $estado = 'Descargado';
                            break;
                        case 3:
                            $estado = 'Vendido';
                            break;
                        case 4:
                            $estado = 'Comodato';
                            break;
                        case 5:
                            $estado = 'Donado';
                            break;
                        default:
                            $estado = 'Activo';
                            break;
                    }
                }

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1.6, $altoCabecera, "Estado: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(2, $altoCabecera, utf8_decode($estado), 0, 0, 'L', 0);

                break;
            case 3:
                $altoCabecera = 0.7;
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(3.7, $altoCabecera, utf8_decode("Número de equipo: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['codigo']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);


                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(2.5, $altoCabecera, "Descripcion: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(14, $altoCabecera, utf8_decode($bienBuscado['descripcion']), 0, 'J');
                $pdf->Ln(0.1);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(3.5, $altoCabecera, utf8_decode("Fecha de compra: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['fechacompra']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);



                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(4.3, $altoCabecera, "Valor total de compra: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode("$" . $bienBuscado['valor']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                /*  $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
            $pdf->Cell(2, $altoCabecera, utf8_decode("Compra de motor: "), 0, 0, 'L', 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->MultiCell(14, $altoCabecera, utf8_decode("Sin compras"), 0, 'J');
            $pdf->Ln(0.1);

            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
            $pdf->Cell(2.2, $altoCabecera, utf8_decode("Valor de pieza sustituido: "), 0, 0, 'L', 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->MultiCell(14, $altoCabecera, utf8_decode(""), 0, 'L');
            $pdf->Ln(0.1); */

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(3.2, $altoCabecera, "Valor de equipo: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode("$" . $bienBuscado['valor']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(3.4, $altoCabecera, "Numero de placa: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(8, $altoCabecera, utf8_decode($bienBuscado['placa']), 0, 0, 'L', 0);
                $pdf->Ln(0.8);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->Cell(3, $altoCabecera, utf8_decode("Observaciones: "), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                if ($bienBuscado['observaciones'] != " " && $bienBuscado['observaciones'] != null && $bienBuscado['observaciones'] != "") {
                    $pdf->MultiCell(13, $altoCabecera, utf8_decode($bienBuscado['observaciones']), 0, 'J');
                } else {
                    $pdf->MultiCell(13, $altoCabecera, utf8_decode('Sin observaciones'), 0, 'J');
                }

                $pdf->Ln(0.1);

                if ($bienBuscado['estado'] != null) {
                    switch ($bienBuscado['estado']) {
                        case 1:
                            $estado = 'Activo';
                            break;
                        case 2:
                            $estado = 'Descargado';
                            break;
                        case 3:
                            $estado = 'Vendido';
                            break;
                        case 4:
                            $estado = 'Comodato';
                            break;
                        case 5:
                            $estado = 'Donado';
                            break;
                        default:
                            $estado = 'Activo';
                            break;
                    }
                }

                $pdf->Cell(1, $altoCabecera, '', 0, 0, 'L');
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(1.6, $altoCabecera, "Estado: ", 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(2, $altoCabecera, utf8_decode($estado), 0, 0, 'L', 0);
                break;
        }
    } else {
        $pdf->SetFont('Arial', '', 11);

        $pdf->Cell(1, 0.8, '', 0, 0, 'L');
        $pdf->Cell(13, 0.8, utf8_decode('No hay Registros '), 0, 0, 'C', 0);
    }

    $pdf->Ln(1);
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

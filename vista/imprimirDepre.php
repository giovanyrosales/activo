<?php
error_reporting(0);
session_start();

require('../fpdf/fpdf.php');
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Muebles_modelo.php';
require_once '../modelo/Select_modelo.php';

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->SetFont('Arial','B',12);
    $this->Ln(1);
    $this->Cell(7.5,0.5,'',0,0,'L');
    $this->Cell(5,0.5,utf8_decode('ALCALDIA MUNICIPAL DE SANTA ANA NORTE'),0,0,'C'); $this->Image('../images/LOGO.png' , 18 ,1, 2.1 , 1.5,'PNG', '');  
    $this->Ln(0.6);
    $this->Cell(7.5,0.5,'',0,0,'L');
    $this->Cell(5,0.5,utf8_decode('ACTIVO FIJO'),0,0,'C'); 
    $this->Ln(0.6);
    $this->Cell(4.5,0.5,'',0,0,'C');
    $this->MultiCell(16,0.5,utf8_decode("ANALISIS DE DEPRECIACIÓN DE BIENES MUEBLES"),0,'L');
    $this->Ln(0.6);
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
    $pdf=new PDF('P', 'cm', 'letter');
    $pdf->SetAutoPageBreak(true, 4.5);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    setlocale(LC_MONETARY, 'en_US');
    $bienes = new Bienes();
    $select = new Selects();
    $bien = $_POST["bien"];
    
    $datosbien = $select->getBienByCod($bien);
    
    $array["bien"] = $datosbien["idbien"];
    
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $pdf->Cell(1,0.75,utf8_decode("Código del bien:")." ".utf8_decode($datosbien["codigo"]),0,0,'L');
    $pdf->Ln(1);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $pdf->MultiCell(16,0.5,utf8_decode("Descripción:")." ".utf8_decode($datosbien["descripcion"]),0,'L');
    $pdf->Ln(0.5);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $selcodcont = $select->getNombreCodContable($datosbien["codcontable"]);
    $codigocontable = $selcodcont["nombre"];
    $selcoddepre = $select->getNombreCodDepre($datosbien["coddepreciacion"]);
    $codigodepre = $selcoddepre["nombre"];
    $coddepre = $selcoddepre["coddepre"];
    $codconta = $selcodcont["codconta"];
    $pdf->Cell(8,0.75,utf8_decode("Cód. Contable:")." ".$codigocontable,0,0,'L'); 
    $pdf->Cell(1,0.75,utf8_decode("Cód. de Depreciación:")." ".$codigodepre,0,0,'L');
    $pdf->Ln(0.5);
    $pdf->Cell(5,0.75,'',0,0,'L');
    $pdf->Cell(4,0.75,"( ".$codconta." )",0,0,'L'); 
    $pdf->Cell(7,0.75,"( ".$coddepre." )",0,0,'R');
    $pdf->Ln(0.5);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $deptoinfo = $select->getDepto($datosbien["departamento"]);
    $pdf->Cell(8,0.75,utf8_decode("Unidad Asignada:")." ".utf8_decode($deptoinfo["nombre"]),0,0,'L'); $pdf->Cell(1,0.75,utf8_decode("Año del bien:")." ".$datosbien["anio"],0,0,'L');
    $pdf->Ln(0.5);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $pdf->Cell(8,0.75,utf8_decode("Valor del bien:")." $".number_format($datosbien["valor"],2),0,0,'L'); $pdf->Cell(1,0.75,utf8_decode("Fecha de compra:")." ".date("d/m/Y", strtotime($datosbien["fechacompra"])),0,0,'L');
    $pdf->Ln(0.5);
    
    
    
    
     //******************************** calculos***********************//

     //tiempo util
     $fechacompra = new DateTime($datosbien["fechacompra"]);
     $fechafab = new DateTime($datosbien["anio"].'-12-31');
     $interval = $fechacompra->diff($fechafab);
     $tiempoutil = $interval->format('%a')/365;
     $tiempoutil = round($tiempoutil,2);
        
     //anios pendientes
     if($datosbien["tcompra"] == "nuevo" ){
         $aniospen = $datosbien["vidautil"];
     }else{
         $aniospen = $datosbien["vidautil"] - $tiempoutil;
     }
     //valor residual
     $valorres = round($datosbien["valor"]*($datosbien["valresidual"]/100),2);
    
     //valor a depreciar
     $valordepre = $datosbien["valor"] - $valorres;
     
     //depreciacion anual
     if($aniospen>0){
         $depanual = $valordepre / $aniospen;
     }else {
         $depanual = 0;
     }
    if($aniospen < 0){
    $aniospen = 0;
    }
    
    $aniospenrounded = round($aniospen,2);
     
    $pdf->Cell(2,0.75,'',0,0,'L');
    $pdf->Cell(8,0.75,utf8_decode("Valor residual:")." $".number_format($valorres,2),0,0,'L'); $pdf->Cell(1,0.75,utf8_decode("% Valor Residual:")." ".$datosbien["valresidual"] ,0,0,'L');
    $pdf->Ln(0.5);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $pdf->Cell(8,0.75,utf8_decode("Valor a depreciar:")." $".number_format($valordepre,2),0,0,'L'); $pdf->Cell(1,0.75,utf8_decode("Vida Util(años):")." ".$datosbien["vidautil"],0,0,'L');
    $pdf->Ln(0.5);
    $pdf->Cell(2,0.75,'',0,0,'L');
    $pdf->Cell(8,0.75,utf8_decode("Años pendientes:")." ".$aniospenrounded,0,0,'L');    
    $pdf->Cell(8,0.75,utf8_decode("Depreciación anual(prom):")." $".number_format($depanual,2,'.',','),0,0,'L'); 
    
    /*********************************** SI HAY REPOSICION VITAL ********************************/////
    $repvit = $select->getRepVitalAll($datosbien["idbien"]);
    if(isset($repvit)){
        foreach($repvit as $datorep){
            $nuevoval = floatval($datorep["piezanueva"])+floatval($datorep["valorajustado"]);
            $nvalresidual = $nuevoval*($datosbien["valresidual"]/100);
            $newvaldepre = $nuevoval - $nvalresidual;
            $newdepreanual = $newvaldepre / $datorep["vidautil"];
            $newvalbien = $datosbien["valor"] + floatval($datorep["piezanueva"]) - floatval($datorep["piezasustituida"]);
            
            $pdf->SetFillColor(190,190,190);
            $pdf->Ln(1);
            $pdf->Cell(2,0.75,'',0,0,'L');
            $pdf->Cell(8,0.75,utf8_decode("Fecha Modificación: ").date("d/m/Y", strtotime($datorep["fecha"])),0,0,'L',true);$pdf->Cell(8,0.75,utf8_decode("Nuevo Valor: ")."$ ".number_format($nuevoval,2,'.',','),0,0,'L',true);
            $pdf->Ln(0.7);
            $pdf->Cell(2,0.75,'',0,0,'L');
            $pdf->Cell(8,0.75,utf8_decode("Pieza Sustituida: ")."$ ".number_format($datorep["piezasustituida"],2,'.',','),0,0,'L',true);$pdf->Cell(8,0.75,utf8_decode("Valor Residual: ")."$ ".number_format($nvalresidual,2,'.',','),0,0,'L',true);
            $pdf->Ln(0.7);
            $pdf->Cell(2,0.75,'',0,0,'L');
            $pdf->Cell(8,0.75,utf8_decode("Pieza Nueva: ")."$ ".number_format($datorep["piezanueva"],2,'.',','),0,0,'L',true);$pdf->Cell(8,0.75,utf8_decode("Valor a Depreciar: ")."$ ".number_format($newvaldepre,2,'.',','),0,0,'L',true);
            $pdf->Ln(0.7);
            $pdf->Cell(2,0.75,'',0,0,'L');
            $pdf->Cell(8,0.75,utf8_decode("Nuevo Valor del Bien: ")."$ ".number_format($newvalbien,2,'.',','),0,0,'L',true);$pdf->Cell(8,0.75,utf8_decode("Vida Util: ").$datorep["vidautil"],0,0,'L',true);
            $pdf->Ln(0.7);
            $pdf->Cell(2,0.75,'',0,0,'L');
            $pdf->Cell(8,0.75,utf8_decode("Valor Ajustado: ")."$ ".number_format($datorep["valorajustado"],2,'.',','),0,0,'L',true);$pdf->Cell(8,0.75,utf8_decode("Depreciación Anual: ")."$ ".number_format($newdepreanual,2,'.',','),0,0,'L',true);
        }
    
    }
    
    /***************************************  CALCULOS GENERALES DE DEPRECIACION NORMAL  ****************************************/
    
    $pdf->Ln(1.3);
    $aniocompra = substr($datosbien["fechacompra"], 0, 4);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(2,0.5,'',0,0,'L');
    $pdf->Cell(2,0.5,utf8_decode('AÑO'),1,0,'C',1);
    $pdf->Cell(5,0.5,utf8_decode('DEPRECIACIÓN ANUAL'),1,0,'C',1);
    $pdf->Cell(6,0.5,utf8_decode('DEPRECIACIÓN ACUMULADA'),1,0,'C',1);
    $pdf->Cell(4,0.5,utf8_decode('VALOR EN LIBROS'),1,0,'C',1);
    $pdf->Ln(0.5);
    
    $contador = $aniospen+7;
    
     //por si la reposicion fue cuando ya se habia depreciado por completo el bien
    $vidaextra = $select->getVidaExtra($datosbien["idbien"]);
    if(isset($vidaextra) && $vidaextra > 0) {
        $contador = $contador + floatval($vidaextra["vidaextra"]);
    }
    
    //calculo
    $numdias = $aniospen * 365;
    //dias del año UNO
    $fechafin = new DateTime($aniocompra.'-12-31');
    $interval2 = $fechafin->diff($fechacompra);
    $diasaniouno = $interval2->format('%a');
    //dias restantes / anios restantes
    $diasrestantes = $numdias - $diasaniouno;
    $aniosrestantes = $diasrestantes/365;
    //depreciacion por dia
    $deppordia = number_format(($valordepre / $aniospen) / 365,7);
    
    $i = 0; 
    $depacumulada = 0;
    $depanualuno = $diasaniouno*$deppordia;
    
    while($contador > 0){   
    $array["anio"] = $aniocompra;
    $fechaini = $array['anio'].'-01-01';
    $fechafin = $array['anio'].'-12-31';
   
    $valorbien = $datosbien['valor'];
    
  /******************************  CALCULO DE DEPRECIACION SI HAY REPOSICION VITAL ****************************/
    $repvitanio = $select->getRepVital($datosbien["idbien"], $fechaini, $fechafin);
    if($repvitanio){
            
            $nuevoval = floatval($repvitanio["piezanueva"])+floatval($repvitanio["valorajustado"]);
            $nvalresidual = $nuevoval*($datosbien["valresidual"]/100);
            $newvaldepre = $nuevoval - $nvalresidual;
            $newdepreanual = $newvaldepre / $repvitanio["vidautil"];
            $newvalbien = $datosbien["valor"] + floatval($repvitanio["piezanueva"]) - floatval($repvitanio["piezasustituida"]);
            
            //datos para calculos
            $numdiasrep = floatval($repvitanio["vidautil"]) * 365;
            $fechafin2 = new DateTime($fechafin);
            $fecharep = new DateTime($repvitanio["fecha"]);
            $interval22 = $fechafin2->diff($fecharep);
            $diasaniounorep = $interval22->format('%a');
            
            //dias de depreciacion antes de la reposicion
            if($depanualfin > 0){
            $diasantes = 365 - $diasaniounorep;
            $depanterior = $diasantes * $deppordia;
            $new2 = $valorbien - $depacumulada - $depanterior; 
            $intaniocompra = intval($aniocompra)-1;
            $datoshistorialda = $select->getHistorialdaporanio($array['bien'], $intaniocompra);
                    if( floatval($datoshistorialda["vallibros"]) == floatval($valorres)){
                        $pdf->SetFillColor(195,195,195);
                        $pdf->Cell(2,0.5,'',0,0,'L');
                        $pdf->Cell(2,0.5,utf8_decode($aniocompra),0,0,'C',true);
                        $pdf->Cell(6,0.5,"$0.00",0,0,'C',true);  
                        $pdf->Cell(5,0.5,"$0.00",0,0,'C',true);
                        $pdf->Cell(4,0.5,"$0.00",0,0,'C',true);
                        $pdf->Ln(0.7);  
                        $array["depanterior"] = 00.00;
                    }else {
                        $pdf->SetFillColor(195,195,195);
                        $pdf->Cell(2,0.5,'',0,0,'L');
                        $pdf->Cell(2,0.5,utf8_decode($aniocompra),0,0,'C',true);
                        $pdf->Cell(6,0.5,'$ '.number_format($depanterior,2,'.',','),0,0,'C',true);  
                        $pdf->Cell(5,0.5,'$ '.number_format(($depacumulada+$depanterior),2,'.',','),0,0,'C',true);
                        $pdf->Cell(4,0.5,'$ '.number_format($new2,2,'.',','),0,0,'C',true);
                        $pdf->Ln(0.7);   
                        $array["depanterior"] = $depanterior;    
                    }
            
             }
            
            //dias restantes / anios restantes
            $diasrestantes = $numdiasrep - $diasaniounorep;
            $aniosrestantes = $diasrestantes/365;
            
            $contador = floatval($repvitanio["vidautil"]) + 1;
            $deppordia =($newdepreanual) / 365;
            //reinicio datos 
            $depanualuno = $diasaniounorep * $deppordia;
            
            
            $depacumulada = 0;
            $i = 0;
            $valorbien = floatval($nuevoval);
            $nuevovalporrep = $valorbien;
            
           // Borrar historial de depreciacion de los annios restantes
        $aniob = intval($aniocompra);
        $bandera = $contador + 1;
        while($bandera >= 0){
        $delhistorialda = $select->eliminarDAByanio($aniob, $array["bien"]);
        $bandera --;
        $aniob ++;
        }
    }
    
    //Primera columna anio
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(2,0.5,'',0,0,'L');
    $pdf->Cell(2,0.5,utf8_decode($aniocompra),0,0,'C',1);
    
    
    
    // PARA EL CALCULO DE LA DEPRECIACION ANUAL DE LA TABLA
    if($i == 0 ){
        $depanualfin = $depanualuno;
         } else {
             if ($diasrestantes >= 365){
                $depanualfin = $deppordia*365;
                $diasrestantes = $diasrestantes - 365;
                } else {
                    $depanualfin = $deppordia*$diasrestantes;
                    if($depanualfin <= 0 ){ 
                        $depanualfin = 0 ;
                    }
                    $diasrestantes = $diasrestantes - 365;
                }              
         }
    
		$pdf->Cell(6,0.5,'$ '.number_format($depanualfin,2,'.',','),0,0,'C',1);  
    if(isset($array["depanterior"]) && $array["depanterior"] != 0){
        $array["depanual"] = $depanualfin + floatval($array["depanterior"]);
    }else{
        $array["depanual"] = $depanualfin;
    }
    
    
    //GUARDAR DEPRECIACION ACUMULADA EN EL ARRAY TABLA
    if($i == 0){
    $depacumulada += $depanualuno; 
    }else{
        if($depanualfin <= 0 ){
           $depacumulada = 0; 
        }
        $depacumulada += $depanualfin;
    }
	$pdf->Cell(5,0.5,'$ '.number_format($depacumulada,2,'.',','),0,0,'C',1);
    $array["depacumulada"] = $depacumulada;
    
    //GUARDAR VALOR EN LIBROS EN EL ARREGLO Y TABLA
    if ($depanualfin<=0){
        $pdf->Cell(4,0.5,'$ '.number_format(0,2,'.',','),0,0,'C',1);
    } else{
        if($i==0){
            $new = $valorbien - $depanualfin;
          }else{
              if(isset($nuevovalporrep) && $nuevovalporrep != NULL){
                  $new = floatval($nuevovalporrep) - $depacumulada; 
              }else{
                  $new = $valorbien - $depacumulada; 
              }
          }
		$pdf->Cell(4,0.5,'$ '.number_format($new,2,'.',','),0,0,'C',1);
            
            $array["vallibros"] = $new;
        }    
        
        
    //GUARDAR LOS DATOS EN EL HISTORIAL DE DEPRECIACION ACUMULADA
    if(!$select->getHistorialda($array['bien'], $array['anio'])){
    $bienes->addhistorialda($array);
    }
     $pdf->Ln(0.7);   
        $contador--;
        $aniocompra++;
        $i++;
        $array["depanterior"] = 0;
    }
    
    $pdf->Output();


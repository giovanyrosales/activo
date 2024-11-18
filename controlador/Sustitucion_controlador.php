<?php

error_reporting (0);
require_once '../modelo/Sustitucion_modelo.php';
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';
session_start();
ob_start();

//AGREGAR VENTA DE BIENES**********************************************************************************************  
if (isset($_POST['agregarsustitucion'])) {
    $array = [
        "bien" => $_POST['bien'],
        "piezasustituida" => $_POST['piezasustituida'],
        "piezanueva" => $_POST['piezanueva'],
        "observaciones" => $_POST['observaciones'],
        "vidautil" => $_POST['vidautil'],
        "documento" => "",
        "fecha" => $_POST['fecha']
    ];
    $sustitucion = new Sustitucion();
    if (isset($_FILES["documento"])) {
        if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
            if ($_FILES['documento']['size'] > 6512000) {
                echo "<header>";
                echo "<script language='javascript'>window.location='../vista/Sustitucion.php?add=3'</script>;";
                echo "</header>";
            } else {
                $nombrepdf1 = "documento" . "_" . $_POST['bien'];
                $ruta1 = "../documentos/sustituciones/" . $nombrepdf1 . ".pdf";
                move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
                $array["documento"] = $ruta1;
            }
        }
    }
    
    $bien = new Bienes();
    $select = new Selects();
    $datosbien = $bien->getBien($array["bien"]);
    
    //$fechaanterior = intval(substr($array['fecha'],0,4))-1;
    $fechaanterior = intval(substr($array['fecha'],0,4));
    $depacum = $select->getDepAcum($array['bien'], $fechaanterior);
    $repanteriores = $select->getRepVitalAll($array["bien"]);
    $pnueva = 0;
    $psus = 0;
    if(isset($repanteriores) && count($repanteriores) > 0 ){
        foreach($repanteriores as $v){
            $pnueva = $pnueva + floatval($v["piezanueva"]);
            $psus = $psus + floatval($v["piezasustituida"]);
        } 
        $valorbien = $datosbien["valor"] + $pnueva - $psus;
    }
    else{
        $valorbien = $datosbien["valor"]; 
    }
    $valorajustado = round(floatval($valorbien) - floatval($depacum['depacumulada']) - floatval($array['piezasustituida']),2);
    $array["valorajustado"] = $valorajustado;

    if (!$sustitucion->agregarSustitucion($array)) {
        echo "<header>";
        echo "<<script language='javascript'>window.location='../vista/Sustitucion.php?add=2'</script>;";
        echo "</header>";
    } else {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/Sustitucion.php?add=1'</script>;";
        echo "</header>";
    }
} else if (isset($_POST['actualizarsusti'])) {
    $array = [
        "idventa" => $_POST["idventa"],
        "bien_idbien" => $_POST['bien_idbien'],
        "precio" => $_POST['precio'],
        "observaciones" => $_POST['observaciones'],        
        "fecha" => $_POST['fecha']
    ];
    $bienmueble = new Bienes();
    $doc = $bienmueble->ComprobarDocVenta($array["idventa"]);

    if (isset($_FILES["documento"])) {
        if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
            $nombrepdf1 = "documento" . "_" . $_POST['codigo'];
            $ruta1 = "../documentos/ventas/" . $nombrepdf1 . ".pdf";
            if (!empty($doc["documento"])) {
                unlink($doc["documento"]);
            }
            move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
            $array["documento"] = $ruta1;
        }
    }

    if (!$bienmueble->actualizarVenta($array)) {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarVentas.php?act=2'</script>;";
        echo "</header>";
    } else {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarVentas.php?act=1'</script>;";
        echo "</header>";
    }
}


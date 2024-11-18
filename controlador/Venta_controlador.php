<?php

//error_reporting (0);
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Muebles_modelo.php';
session_start();
ob_start();

//AGREGAR VENTA DE BIENES**********************************************************************************************  
if (isset($_POST['agregarventa'])) {
    $array = [
        "bien_idbien" => $_POST['bien'],
        "precio" => $_POST['precio'],
        "observaciones" => $_POST['observaciones'],
        "documento" => "",
        "fecha" => $_POST['fecha']
    ];
    $bienmueble = new Bienes();
    $mueble = new Muebles();
    if (isset($_FILES["documento"])) {
        if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
            if ($_FILES['documento']['size'] > 6512000) {
                echo "<header>";
                echo "<script language='javascript'>window.location='../vista/IngresarVenta.php?add=3'</script>;";
                echo "</header>";
            } else {
                $nombrepdf1 = "documento" . "_" . $_POST['bien'];
                $ruta1 = "../documentos/ventas/" . $nombrepdf1 . ".pdf";
                move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
                $array["documento"] = $ruta1;
            }
        }
    }


    if (!$bienmueble->agregarVenta($array)) {
        echo "<header>";
        echo "<<script language='javascript'>window.location='../vista/ListarVentas.php?add=2'</script>;";
        echo "</header>";
    } else {
        $mueble->actualizarEstado($array['bien_idbien'], 3);
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarVentas.php?add=1'</script>;";
        echo "</header>";
    }
} else if (isset($_POST['actualizarventa'])) {
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


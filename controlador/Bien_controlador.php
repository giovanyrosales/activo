<?php //error_reporting (0);
require_once '../modelo/Bien_modelo.php';
require_once '../modelo/Select_modelo.php';
require_once '../modelo/Replace_modelo.php';
require_once '../modelo/Muebles_modelo.php';
session_start();
ob_start();
$mueble = new Muebles();

//ACTUALIZAR bien EXISTENTE COMODATO *************************************************************************************
if (isset($_POST['actualizarcomodato'])) {
  $array = [
    "idcomodato" => $_POST['idcomodato'],
    "institucion" => $_POST['institucion'],
    "observaciones" => $_POST['observaciones'],
    "bien" => $_POST['bien'],
    "fecha" => $_POST['fecha']
  ];
  $bienmueble = new Bienes();
  if (!$bienmueble->actualizarComodato($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarComodato.php?act=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarComodato.php?act=1'</script>;";
    echo "</header>";
  }
}
//ACTUALIZAR bien EXISTENTE DONACION *************************************************************************************
if (isset($_POST['actualizardonacion'])) {
  $array = [
    "iddonacion" => $_POST['iddonacion'],
    "institucion" => $_POST['institucion'],
    "observaciones" => $_POST['observaciones'],
    "bien" => $_POST['bien'],
    "fecha" => $_POST['fecha']
  ];
  $bienmueble = new Bienes();
  if (!$bienmueble->actualizarDonacion($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?act=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?act=1'</script>;";
    echo "</header>";
  }
}
//ACTUALIZAR bien EXISTENTE MUEBLE *************************************************************************************
if (isset($_POST['actualizarmueble'])) {
  if($_POST["valor"] >= 600){
      $array = [
    "idbien" => $_POST['idbien'],
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "codigo" => $_POST['codigo'],
    "fechacompra" => $_POST['fechacompra'],
       "codcontable" => $_POST['codcontable'],
      "coddepreciacion" => $_POST['coddepreciacion'],
      "vidautil" => $_POST['vidautil'],
      "valresidual" => $_POST['valresidual'],
      "tcompra" => $_POST['tcompra'],
      "origen" => $_POST['origen'],
          "anio" => $_POST['anio']
  ];
  }else {
      $array = [
    "idbien" => $_POST['idbien'],
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "codigo" => $_POST['codigo'],
    "fechacompra" => $_POST['fechacompra']
        ];
  }
  $bienmueble = new Bienes();
  $doc = $bienmueble->ComprobarDoc($array["idbien"]);
  $fac = $bienmueble->ComprobarFac($array["idbien"]);

  if (isset($_FILES["orden"])) {
    if (is_uploaded_file($_FILES['orden']['tmp_name'])) {
      $nombrepdf1 = "orden" . "_" . $_POST['codigo'];
      $ruta1 = "../documentos/muebles/" . $nombrepdf1 . ".pdf";
      if (!empty($doc["documento"])) {
        unlink($doc["documento"]);
      }
      move_uploaded_file($_FILES['orden']['tmp_name'], $ruta1);
      $array["documento"] = $ruta1;
    }
  }
  if (isset($_FILES["factura"])) {
    if (is_uploaded_file($_FILES['factura']['tmp_name'])) {
      $nombrepdf2 = "factura" . "_" . $_POST['codigo'];
      $ruta2 = "../documentos/muebles/" . $nombrepdf2 . ".pdf";
      if (!empty($fac["factura"])) {
        unlink($fac["factura"]);
      }
      move_uploaded_file($_FILES['factura']['tmp_name'], $ruta2);
      $array["factura"] = $ruta2;
    }
  }
  if (!$bienmueble->actualizarMueble($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?act=2&tipo=1'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?act=1&tipo=1'</script>;";
    echo "</header>";
  }
}

//ACTUALIZAR bien inmueble EXISTENTE *************************************************************************************
if (isset($_POST['actualizarinmueble'])) {
  $array = [
    "idbien" => $_POST['idbien'],
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "observaciones" => $_POST['observaciones'],
    "edificaciones" => $_POST['edificaciones'],
    "permuta" => $_POST['permuta'],
     "fechacompra" => $_POST['fechacompra'],
    "inscrito" => $_POST['inscrito']
  ];

  $bienmueble = new Bienes();
  $doc = $bienmueble->ComprobarDoc($array["idbien"]);

  if (isset($_FILES["documento"])) {
    if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
      $nombrepdf1 = "documento" . "_" . $_POST['codigo'];
      $ruta1 = "../documentos/inmuebles/" . $nombrepdf1 . ".pdf";
      if (!empty($doc["documento"])) {
        unlink($doc["documento"]);
      }
      move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
      $array["documento"] = $ruta1;
    }
  }


  if (!$bienmueble->actualizarInmueble($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?act=2&tipo=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?act=1&tipo=2'</script>;";
    echo "</header>";
  }
}
//ACTUALIZAR bien EXISTENTE VEHICULO Y MAQUINARIA *************************************************************************************
if (isset($_POST['actualizarvehimaq'])) {
  $array = [
    "idbien" => $_POST['idbien'],
    "descripcion" => $_POST['descripcion'],
    "motorista" => $_POST['motorista'],
    "encargado" => $_POST['encargado'],
    "fechacompra" => $_POST['fechacompra'],
    "placa" => $_POST['placa'],
      "anio" => $_POST['anio'],
    "valor" => $_POST['valor'],
      "codcontable" => $_POST['codcontable'],
      "coddepreciacion" => $_POST['coddepreciacion'],
      "vidautil" => $_POST['vidautil'],
      "valresidual" => $_POST['valresidual'],
      "origen" => $_POST['origen'],
      "tcompra" => $_POST['tcompra'],
      "estadoeq" => $_POST['estadoeq']
  ];

  $bienmueble = new Bienes();
  $doc = $bienmueble->ComprobarDoc($array["idbien"]);
  $fac = $bienmueble->ComprobarFac($array["idbien"]); 
  $fot = $bienmueble->ComprobarFot($array["idbien"]);

  if (isset($_FILES["orden"])) {
    if (is_uploaded_file($_FILES['orden']['tmp_name'])) {
      $nombrepdf1 = "documento" . "_" . $_POST['codigo'];
      $ruta1 = "../documentos/muebles/" . $nombrepdf1 . ".pdf";
      if (!empty($doc["documento"])) {
        unlink($doc["documento"]);
      }
      move_uploaded_file($_FILES['orden']['tmp_name'], $ruta1);
      $array["documento"] = $ruta1;
      $bienmueble->actualizarDoc($array["documento"], $array['idbien']);
    }
  }
  if (isset($_FILES["factura"])) {
    if (is_uploaded_file($_FILES['factura']['tmp_name'])) {
      $nombrepdf2 = "factura" . "_" . $_POST['codigo'];
      $ruta2 = "../documentos/muebles/" . $nombrepdf2 . ".pdf";
      if (!empty($fac["factura"])) {
        unlink($fac["factura"]);
      }
      move_uploaded_file($_FILES['factura']['tmp_name'], $ruta2);
      $array["factura"] = $ruta2;
      $bienmueble->actualizarFac($array["factura"], $array['idbien']);
    }
  }
  if (isset($_FILES["foto"])) {
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
      $nombrefoto = "foto" . "_" . $_POST['codigo'];
      $ruta3 = "../documentos/muebles/" . $nombrefoto . ".jpg";
      if (!empty($fot["foto"])) {
        unlink($fot["foto"]);
      }
      move_uploaded_file($_FILES['foto']['tmp_name'], $ruta3);
      $array["foto"] = $ruta3;
      $bienmueble->actualizarFot($array["foto"], $array['idbien']);
    }
  }
  if (!$bienmueble->actualizarVehimaq($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?act=2&tipo=3'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?act=1&tipo=3'</script>;";
    echo "</header>";
  }
}
//AGREGAR BIENES MUEBLE **********************************************************************************************  
else if (isset($_POST['agregarbienmueble'])) {
  $array = [
    "codigo" => "",
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "fechacompra" => $_POST['fechacompra'],
    "departamento" => $_POST['departamento'],
    "tipo" => $_POST['tipo'],
    "descriptor" => $_POST['descriptor'],
    "documento" => "",
    "factura" => ""
  ];
  $select = new Selects();
  $codigodes = $select->getCodigoDescriptor($_POST["descriptor"]);
  $codigodepto = $select->getCodigoDepartamento($_POST["departamento"]);
  $codigo = $select->getCorrelativo($array["descriptor"]);
  $porciones = explode("-", $codigo["codigo"]);
  
  $correlativo = intval($porciones[count($porciones)-1])+1;
  $array["codigo"] = $codigodepto["codigo"]."-".$codigodes["codigodes"]."-".$correlativo;
  $bienmueble = new Bienes();
  if (isset($_FILES["documento"])) {
      if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
          if ($_FILES['documento']['size'] > 6512000) {
              echo "<header>";
              echo "<script language='javascript'>window.location='../vista/IngresarBien.php?add=3&tipo=1'</script>;";
              echo "</header>";
          } else {
              $nombrepdf1 = "documento" . "_" . $array['codigo'];
              $ruta1 = "../documentos/muebles/" . $nombrepdf1 . ".pdf";
              move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
              $array["documento"] = $ruta1;
          }
      }
  }

  if (isset($_FILES["factura"])) {
    if (is_uploaded_file($_FILES['factura']['tmp_name'])) {
      if ($_FILES['factura']['size'] > 6512000) {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/IngresarBien.php?add=3&tipo=1'</script>;";
        echo "</header>";
      } else {
        $nombrepdf2 = "factura" . "_" . $array['codigo'];
        $ruta2 = "../documentos/muebles/" . $nombrepdf2 . ".pdf";
        move_uploaded_file($_FILES['factura']['tmp_name'], $ruta2);
        $array["factura"] = $ruta2;
      }
    }
  }
  if (!$bienmueble->agregarBMuebles($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?add=2&tipo=1'</script>;";
    echo "</header>";
  } else {

    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?add=1&tipo=1'</script>;";
    echo "</header>";
  }
}
//AGREGAR COMODATO **********************************************************************************************  
else if (isset($_POST['agregarcomodato'])) {
  $array = [
    "institucion" => $_POST['institucion'],
    "observaciones" => $_POST['observaciones'],
    "bien" => $_POST['bien'],
    "fecha" => $_POST['fecha'],
    "documento" => ""
  ];
  $bienmueble = new Bienes();
  if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
    if ($_FILES['documento']['size'] > 4512000) {
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/IngresarComodato.php'</script>;";
      echo "</header>";
    } else {
      $misc = new Replace();
      $nombrepdf = $misc->replace_specials_characters(strval($_POST['institucion'] . '_' . $_POST['fecha']));
      $ruta = "../documentos/comodatos/" . $nombrepdf . ".pdf";
      move_uploaded_file($_FILES['documento']['tmp_name'], $ruta);
      $array["documento"] = $ruta;
      if (!$bienmueble->agregarComodato($array)) {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarComodato.php?add=2'</script>;";
        echo "</header>";
      } else {
        $mueble->actualizarEstado($array['bien'], 4);
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarComodato.php?add=1'</script>;";
        echo "</header>";
      }
    }
  } else {
    if (!$bienmueble->agregarComodato($array)) {
      
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarComodato.php?add=2'</script>;";
      echo "</header>";
    } else {
      $mueble->actualizarEstado($array['bien'], 4);
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarComodato.php?add=1'</script>;";
      echo "</header>";
    }
  }
}
//AGREGAR DONACION **********************************************************************************************  
else if (isset($_POST['agregardonacion'])) {
    echo '<script>console.log("'.$_POST['institucion'].'")</script>';
    echo '<script>console.log("'.$_POST['observaciones'].'")</script>';
    echo '<script>console.log("'.$_POST['bien'].'")</script>';
    echo '<script>console.log("'.$_POST['fecha'].'")</script>';
  $array = [
    "institucion" => $_POST['institucion'],
    "observaciones" => $_POST['observaciones'],
    "bien" => $_POST['bien'],
    "documento" => "",
    "fecha" => $_POST['fecha']
  ];
  $bienmueble = new Bienes();
  if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
    if ($_FILES['documento']['size'] > 4512000) {
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/IngresarComodato.php'</script>;";
      echo "</header>";
    } else {
      $misc = new Replace();
      $nombrepdf = $misc->replace_specials_characters(strval($_POST['institucion'] . '_' . $_POST['fecha']));
      $ruta = "../documentos/donaciones/" . $nombrepdf . ".pdf";
      move_uploaded_file($_FILES['documento']['tmp_name'], $ruta);
      $array["documento"] = $ruta;
      if (!$bienmueble->agregarDonacion($array)) {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?add=2'</script>;";
        echo "</header>";
      } else {
        $mueble->actualizarEstado($array['bien'], 5);
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?add=1'</script>;";
        echo "</header>";
      }
    }
  } else {
    if (!$bienmueble->agregarDonacion($array)) {
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?add=2'</script>;";
      echo "</header>";
    } else {
      $mueble->actualizarEstado($array['bien'], 5);
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?add=1'</script>;";
      echo "</header>";
    }
  }
}
//AGREGAR BIENES MUEBLES MAYORES A 900**********************************************************************************************  
else if (isset($_POST['agregarbienmueble900'])) {
  $array = [
    "codigo" => "",
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "fechacompra" => $_POST['fechacompra'],
    "departamento" => $_POST['departamento'],
    "tipo" => $_POST['tipo'],
    "descriptor" => $_POST['descriptor'],
    "codcontable" => $_POST['codcontable'],
    "coddepreciacion" => $_POST['coddepreciacion'],
    "vidautil" => $_POST['vidautil'],
    "valresidual" => $_POST['valresidual'],
      "tcompra" => $_POST['tcompra']
  ];
  $select = new Selects();
  $codigodes = $select->getCodigoDescriptor($_POST["descriptor"]);
  $codigodepto = $select->getCodigoDepartamento($_POST["departamento"]);
  $codigo = $select->getCorrelativo($array["descriptor"]);
  $porciones = explode("-", $codigo["codigo"]);
  
  $correlativo = intval($porciones[count($porciones)-1])+1;
  $array["codigo"] = $codigodepto["codigo"]."-".$codigodes["codigodes"]."-".$correlativo;
  $bienmueble = new Bienes();
  if (!$bienmueble->agregarBMueblesMayor900($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?add=2&tipo=1'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?add=1&tipo=1'</script>;";
    echo "</header>";
  }
}
//AGREGAR BIENES INMUEBLES**********************************************************************************************  
else if (isset($_POST['agregarbieninmueble'])) {
  $array = [
    "codigo" => $_POST['codigo'],
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "fechacompra" => $_POST['fechacompra'],
    "inscrito" => $_POST['inscrito'],
    "observaciones" => $_POST['observaciones'],
    "contiene" => $_POST['contiene'],
    "ubicacion" => $_POST['ubicacion'],
    "tipo" => $_POST['tipo'],
    "valorregistrado" => $_POST['valorregistrado'],
    "documento" => ""
  ];
  $select = new Selects();
  $lastcodigo = $select->getLastInmueble("2");
  $array["codigo"] = $lastcodigo["codigo"] + 1;
  $bienmueble = new Bienes();
  if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
    if ($_FILES['documento']['size'] > 6512000) {
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/IngresarBien.php?add=3'</script>;";
      echo "</header>";
    } else {
      $misc = new Replace();
      $nombrepdf = $misc->replace_specials_characters(strval($array['codigo'] . '_' . $_POST['fechacompra']));
      $ruta = "../documentos/inmuebles/" . $nombrepdf . ".pdf";
      move_uploaded_file($_FILES['documento']['tmp_name'], $ruta);
      $array["documento"] = $ruta;
      if (!$bienmueble->agregarBInmuebles($array)) {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=2&add=2'</script>;";
        echo "</header>";
      } else {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=2&add=1'</script>;";
        echo "</header>";
      }
    }
  } else {
    if (!$bienmueble->agregarBInmuebles($array)) {
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=2&add=2'</script>;";
      echo "</header>";
    } else {
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=2&add=1'</script>;";
      echo "</header>";
    }
  }
}
//AGREGAR BIENES VEHICULOS Y MAQUINARIA**********************************************************************************************  
else if (isset($_POST['agregarvehymaq'])) {
  $array = [
    //"codigo" => $_POST['codigo'], //numero de equipo
    "descripcion" => $_POST['descripcion'],
    "valor" => $_POST['valor'],
    "fechacompra" => $_POST['fechacompra'],
    "anio" => $_POST['anio'],
    "fechavectar" => $_POST['fechavectar'],
    "placa" => $_POST['placa'],
    "observaciones" => $_POST['observaciones'],
    "codcontable" => $_POST['codcontable'],
    "coddepreciacion" => $_POST['coddepreciacion'],
    "vidautil" => $_POST['vidautil'],
    "valresidual" => $_POST['valresidual'],
    "tipo" => $_POST['tipo'],
    "departamento" => $_POST['departamento'],
    "motorista" => $_POST['motorista'],
    "encargado" => $_POST['encargado'],
    "documento" => "",
    "factura" => "",
      "tcompra" => $_POST['tcompra']
  ];

  $select = new Selects();
  $lastcodigo = $select->getLastVehiculo("3");
  $array["codigo"] = $lastcodigo["codigo"] + 1;

  $bienmueble = new Bienes();
  if (isset($_FILES["documento"])) {
      if (is_uploaded_file($_FILES['documento']['tmp_name'])) {
          if ($_FILES['documento']['size'] > 6512000) {
              echo "<header>";
              echo "<script language='javascript'>window.location='../vista/IngresarBien.php?add=3&tipo=3'</script>;";
              echo "</header>";
          } else {
              $nombrepdf1 = "documento" . "_" . $array["codigo"];
              $ruta1 = "../documentos/muebles/" . $nombrepdf1 . ".pdf";
              move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
              $array["documento"] = $ruta1;
          }
      }
  }

  if (isset($_FILES["factura"])) {
    if (is_uploaded_file($_FILES['factura']['tmp_name'])) {
      if ($_FILES['factura']['size'] > 6512000) {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/IngresarBien.php?add=3&tipo=3'</script>;";
        echo "</header>";
      } else {
        $nombrepdf2 = "factura" . "_" . $_POST['codigo'];
        $ruta2 = "../documentos/muebles/" . $nombrepdf2 . ".pdf";
        move_uploaded_file($_FILES['factura']['tmp_name'], $ruta2);
        $array["factura"] = $ruta2;
      }
    }
  }

  if (!$bienmueble->agregarVehyMaq($array)) {
    echo "<header>";
    echo "<<script language='javascript'>window.location='../vista/ListarBienes.php?add=2&tipo=3'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarBienes.php?add=1&tipo=3'</script>;";
    echo "</header>";
  }
}

//ELIMINAR BIEN **********************************************************************************************  
else if (isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  $bienes = new Bienes();
  $tipo = $_GET["tipo"];
  if (!$bienes->eliminarBien($id)) {
    echo "<header>";
    switch ($tipo) {
      case "1":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=1&del=2'</script>;";
        break;
      case "2":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=2&del=2'</script>;";
        break;
      case "3":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=3&del=2'</script>;";
        break;
      case "4":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=4&del=2'</script>;";
        break;
    }
    echo "</header>";
  } else {
    echo "<header>";
    switch ($tipo) {
      case "1":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=1&del=1'</script>;";
        break;
      case "2":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=2&del=1'</script>;";
        break;
      case "3":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=3&del=1'</script>;";
        break;
      case "4":
        echo "<script language='javascript'>window.location='../vista/ListarBienes.php?tipo=4&del=1'</script>;";
        break;
    }
    echo "</header>";
  }
}
//ELIMINAR COMODATO **********************************************************************************************  
else if (isset($_GET['delcomodato'])) {
  $id = $_GET['delcomodato'];
  $bienes = new Bienes();
  if (!$bienes->eliminarComodato($id)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarComodato.php?del=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarComodato.php?del=1'</script>;";
    echo "</header>";
  }
}
//ELIMINAR DONACION **********************************************************************************************  
else if (isset($_GET['deldonacion'])) {
  $id = $_GET['deldonacion'];
  $bienes = new Bienes();
  if (!$bienes->eliminarDonacion($id)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?del=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/ListarDonacion.php?del=1'</script>;";
    echo "</header>";
  }
}


//AGREGAR REEVALUO **********************************************************************************************
if (isset($_POST['agregarReevaluo'])) {
    $array = [
      "bien" => $_POST['bien'],
      "valornuevo" => $_POST['reevaluo'],
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
                echo "<script language='javascript'>window.location='../vista/IngresarReevaluo.php?add=3'</script>;";
                echo "</header>";
            } else {
                $nombrepdf1 = "documento" . "_" . $_POST['bien'];
                $ruta1 = "../documentos/reevaluos/" . $nombrepdf1 . ".pdf";
                move_uploaded_file($_FILES['documento']['tmp_name'], $ruta1);
                $array["documento"] = $ruta1;
            }
        }
    }


    if (!$bienmueble->agregarReevaluo($array)) {
        echo "<header>";
        echo "<<script language='javascript'>window.location='../vista/inicio.php'</script>;";
        echo "</header>";
    } else {
        echo "<header>";
        echo "<script language='javascript'>window.location='../vista/inicio.php'</script>;";
        echo "</header>";
    }
}
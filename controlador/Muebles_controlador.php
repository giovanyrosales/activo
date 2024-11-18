<?php //error_reporting (0);
require_once '../modelo/Muebles_modelo.php';
session_start();
ob_start();

//ACTUALIZAR TRASLADO EXISTENTE *************************************************************************************
if (isset($_POST['actualizartraslado'])) {
  $array = [
    "bien" => $_POST['bien'],
    "fechatraslado" => $_POST['fechatraslado'],
    "deptoenvia" => $_POST['deptoenvia']
  ];
  $muebles = new Muebles();
  if(!$muebles->actualizarTraslado($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarTraslados.php?act=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarTraslados.php?act=1'</script>;";
     echo "</header>";
  }
}
//ACTUALIZAR traslado EXISTENTE *************************************************************************************
if (isset($_POST['actualizardescargo'])) {
  $array = [
    "bien" => $_POST['bien'],
    "fechadescargo" => $_POST['fechadescargo'],
    "observaciones" => $_POST['observaciones']
  ];
  $muebles = new Muebles();
  if(!$muebles->actualizarDescargo($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescargos.php?act=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescargos.php?act=1'</script>;";
     echo "</header>";
  }
}
//AGREGAR translado **********************************************************************************************  
else if (isset($_POST['agregartraslado'])) {
    $array = [
    "bien" => $_POST['bien'],
    "fechatraslado" => $_POST['fechatraslado'],
    "deptoenvia" => $_POST['deptoenvia'],
    "deptorecibe" => $_POST['deptorecibe']
];
    $muebles = new Muebles();
if(!$muebles->agregarTraslado($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/inicio.php?add=2'</script>;";
     echo "</header>";
     } else {
     //Actualizar departamento en bien, luego de guardar el historico en el traslado.
//Los vehiculos y maquinaria no se pueden actualizar porque modifican el codigo del bien en el proceso de abajo
//y los vehiculos y maquinaria solo con un numero, si se quiere trasladar del tipo 3 habria que agre4gar un IF
//en el que se condicione qe si es tipo 3 que la variable $code sea lo mismo que la variable $codigo actual.
     $muebles->actualizarDepto($array["bien"], $array["deptorecibe"]);//actualiza el id del departamento
     $codigo = $muebles->getCodigoanterior($array["bien"]);//saca el codigo anterior
     $nuevocodigo = $muebles->getCodigonuevo($array["deptorecibe"]);//saca el codigo del nuevo departamento
     $codigoanterior = explode("-", $codigo["codigo"]);//parte el codigo anterior
     $code = $nuevocodigo["codigo"]."-".$codigoanterior[2]."-".$codigoanterior[3];//vuelve a unir pero con el codigo del nuevo departamento
     $muebles->actualizarCodigo($array["bien"], $code);//ingresa el nuevo codigo
     
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/inicio.php?add=1'</script>;";
     echo "</header>";
  }
}
//AGREGAR descargo **********************************************************************************************  
else if (isset($_POST['agregardescargo'])) {
    $array = [
    "bien" => $_POST['bien'],
    "fechadescargo" => $_POST['fechadescargo'],
    "historyvalor" => $_POST['historyvalor'],
    "observaciones" => $_POST['observaciones']
];
    $muebles = new Muebles();
if(!$muebles->agregarDescargo($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescargos.php?add=2'</script>;";
     echo "</header>";
     } else {
         $muebles->actualizarEstado($array["bien"],2);
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/inicio.php?des=1'</script>;";
     echo "</header>";
  }
}
//ELIMINAR traslado**********************************************************************************************  
else if (isset($_GET['deltraslado'])) {
    $id = $_GET['deltraslado'];
    $muebles = new Muebles();
    if(!$muebles->eliminarTraslado($id)){
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarTraslados.php?del=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarTraslados.php?del=1'</script>;";
     echo "</header>";
  }
  }
  //ELIMINAR descargo**********************************************************************************************  
else if (isset($_GET['deldescargo'])) {
    $id = $_GET['deldescargo'];
    $muebles = new Muebles();
    if(!$muebles->eliminarDescargo($id)){
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescargos.php?del=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescargos.php?del=1'</script>;";
     echo "</header>";
  }
  }
 

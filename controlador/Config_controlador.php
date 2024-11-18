<?php //error_reporting (0);
require_once '../modelo/Config_modelo.php';
session_start();
ob_start();

//ACTUALIZAR departamento EXISTENTE *************************************************************************************
if (isset($_POST['actualizardepto'])) {
  $array = [
    "codigo" => $_POST['codigo'],
    "nombre" => $_POST['nombre']
  ];
  $config = new Config();
  if(!$config->actualizarDepto($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDepto.php?act=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDepto.php?act=1'</script>;";
     echo "</header>";
  }
}
//ACTUALIZAR descriptor EXISTENTE *************************************************************************************
if (isset($_POST['actualizardescriptor'])) {
  $array = [
    "codigodes" => $_POST['codigodes'],
    "descripcion" => $_POST['descripcion'],
      "iddescriptor" => $_POST['iddescriptor']
  ];
  $config = new Config();
  if(!$config->actualizarDescriptor($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescriptor.php?act=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescriptor.php?act=1'</script>;";
     echo "</header>";
  }
}
//ACTUALIZAR codigo contable EXISTENTE *************************************************************************************
if (isset($_POST['actualizarcodconta'])) {
  $array = [
    "codconta" => $_POST['codconta'],
    "nombre" => $_POST['nombre']
  ];
  $config = new Config();
  if(!$config->actualizarCodContable($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoContable.php?act=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoContable.php?act=1'</script>;";
     echo "</header>";
  }
}
//ACTUALIZAR codigo depreciacion EXISTENTE *************************************************************************************
if (isset($_POST['actualizarcoddepre'])) {
  $array = [
    "coddepre" => $_POST['coddepre'],
    "nombre" => $_POST['nombre']
  ];
  $config = new Config();
  if(!$config->actualizarCoddepre($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoDepre.php?act=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoDepre.php?act=1'</script>;";
     echo "</header>";
  }
}
//AGREGAR departamento **********************************************************************************************  
else if (isset($_POST['agregardepartamento'])) {
    $array = [
    "codigo" => $_POST['codigo'],
    "nombre" => $_POST['nombre']
];
    $config = new Config();
if(!$config->agregarDepto($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDepto.php?add=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDepto.php?add=1'</script>;";
     echo "</header>";
  }
}
//AGREGAR descriptor **********************************************************************************************  
else if (isset($_POST['agregardescriptor'])) {
    $array = [
    "codigodes" => $_POST['codigodes'],
    "descripcion" => $_POST['descripcion']
];
    $config = new Config();
if(!$config->agregarDescriptor($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescriptor.php?add=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescriptor.php?add=1'</script>;";
     echo "</header>";
  }
}
//AGREGAR departamento **********************************************************************************************  
else if (isset($_POST['agregarcodconta'])) {
    $array = [
    "codconta" => $_POST['codconta'],
    "nombre" => $_POST['nombre']
];
    $config = new Config();
if(!$config->agregarCodConta($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoContable.php?add=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoContable.php?add=1'</script>;";
     echo "</header>";
  }
}
//AGREGAR departamento **********************************************************************************************  
else if (isset($_POST['agregarcoddepre'])) {
    $array = [
    "coddepre" => $_POST['coddepre'],
    "nombre" => $_POST['nombre']
];
    $config = new Config();
if(!$config->agregarCodDepre($array)) {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoDepre.php?add=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoDepre.php?add=1'</script>;";
     echo "</header>";
  }
}
//ELIMINAR departamento**********************************************************************************************  
else if (isset($_GET['deldepto'])) {
    $id = $_GET['deldepto'];
    $config = new Config();
    if(!$config->eliminarDepto($id)){
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDepto.php?del=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDepto.php?del=1'</script>;";
     echo "</header>";
  }
  }
  //ELIMINAR descriptor**********************************************************************************************  
else if (isset($_GET['deldescriptor'])) {
    $id = $_GET['deldescriptor'];
    $config = new Config();
    if(!$config->eliminarDescriptor($id)){
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescriptor.php?del=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarDescriptor.php?del=1'</script>;";
     echo "</header>";
  }
  }
  //ELIMINAR codigo contable**********************************************************************************************  
else if (isset($_GET['delcodconta'])) {
    $id = $_GET['delcodconta'];
    $config = new Config();
    if(!$config->eliminarCodConta($id)){
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoContable.php?del=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoContable.php?del=1'</script>;";
     echo "</header>";
  }
  }
  //ELIMINAR codigo depreciacion**********************************************************************************************  
else if (isset($_GET['delcoddepre'])) {
    $id = $_GET['delcoddepre'];
    $config = new Config();
    if(!$config->eliminarDepre($id)){
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoDepre.php?del=2'</script>;";
     echo "</header>";
     } else {
     echo "<header>";
     echo "<script language='javascript'>window.location='../vista/ListarCodigoDepre.php?del=1'</script>;";
     echo "</header>";
  }
  }
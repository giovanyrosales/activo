<?php //error_reporting (0);?>
<?php
require_once '../modelo/Usuarios_modelo.php';
require_once '../modelo/Historial_modelo.php';
require_once "../firephp/lib/FirePHPCore/fb.php";
session_start();
ob_start();
//ACTUALIZAR REGISTRO EXISTENTE DE USUARIO*************************************************************************************
if (isset($_POST['actualizar'])) {
    if(is_uploaded_file($_FILES['fichero']['tmp_name'])) {
    
     if($_FILES['fichero']['size'] > 300000) {
      echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=3'</script>;";
    echo "</header>";
  } else {
       if ($_FILES["fichero"]["type"] =="image/jpeg" OR $_FILES["fichero"]["type"] =="image/jpg" ) {
    $ruta = "../images/perfil/perfil_usuario_".$_POST['idusuario'].".jpg";
    move_uploaded_file($_FILES['fichero']['tmp_name'],$ruta);
     $usuario = new Usuarios();
    if(!isset($_POST["actpass"])) {
  $array = [
      "foto" => $ruta,
    "idusuario" => $_POST['idusuario'],
    "usuario" => $_POST['usuario'],
    "nombre" => $_POST['nombre'],
    "apellido" => $_POST['apellido'],
    "tel" => $_POST['tel'],
     ];}else {
         $user_input =  crypt(trim($_POST['clave']));
         $usuariouser = $_POST['idusuario'];
         if(!$usuario->editarClave($user_input, $usuariouser)) {
      echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=2'</script>;";
    echo "</header>";
    } else {
        $array = [
   "foto" => $ruta,
    "idusuario" => $_POST['idusuario'],
    "usuario" => $_POST['usuario'],
    "nombre" => $_POST['nombre'],
    "apellido" => $_POST['apellido'],
    "tel" => $_POST['tel'],
     ];
         }
     }
  if(!$usuario->actualizarUsuarioConFoto($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=1'</script>;";
    echo "</header>";
  }

        }else {
         echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=4'</script>;";
    echo "</header>";
          }
     } 
    
} else {
          $usuario = new Usuarios();
    if(!isset($_POST["actpass"])) {
  $array = [
    "idusuario" => $_POST['idusuario'],
    "usuario" => $_POST['usuario'],
    "nombre" => $_POST['nombre'],
    "apellido" => $_POST['apellido'],
    "tel" => $_POST['tel'],
     ];}else {
         $user_input =  crypt(trim($_POST['clave']));
         $usuariouser = $_POST['idusuario'];
         if(!$usuario->editarClave($user_input, $usuariouser)) {
      echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=2'</script>;";
    echo "</header>";
    } else {
        $array = [
    "idusuario" => $_POST['idusuario'],
    "usuario" => $_POST['usuario'],
    "nombre" => $_POST['nombre'],
    "apellido" => $_POST['apellido'],
    "tel" => $_POST['tel'],
     ];
        }
         
     }
 
  if(!$usuario->actualizarUsuario($array)) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=2'</script>;";
    echo "</header>";
  } else {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/EditarUsuario.php?usact=1'</script>;";
    echo "</header>";
            } 
        }
}
//AGREGAR UN NUEVO REGISTRO DE USUARIO**********************************************************************************************  
    else if (isset($_POST['agregar'])) {
    
    
    if($_POST["tipousuario"]==3 OR $_POST["tipousuario"]==5){
       $array = [
      "tipousuario" => trim($_POST['tipousuario']),
      "nombre" => trim($_POST['nombre']),
      "apellido" => trim($_POST['apellido']),
      "tel" => trim($_POST['tel']),
    ]; 
       $type = $_POST["tipousuario"];
       $usuario = new Usuarios();
       if(!$usuario->agregarUsr($array)) {
 echo "<header>";
      echo "<script language='javascript'>window.location='../vista/IngresarUsuario.php?usadd=2'</script>;";
      echo "</header>";
    } else {
    //INGRESO DEL REGISTRO A LA BITACORA**********************************************************************************************
      $log = new Historial();
      $array = [
      "idusuario" => $_SESSION["sesion4"]["usuario"],
      "detalle" => "El usuario: " .$_SESSION["sesion4"]["usuario"]. " agrego un registro de Regidor o Formulador: " .$_POST['nombre']." ".$_POST['apellido']."",
      ];
      $log1 = $log->agregarLog($array);
    //**********************************************************************************************************************************  
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarUsuarios.php?usadd=1&type=".$type."'</script>;";
      echo "</header>";
    }
    } else {
        $hashedPass = crypt(trim($_POST['clave']));
    $array = [
      "tipousuario" => trim($_POST['tipousuario']),
      "usuario" => trim($_POST['usuario']),
      "nombre" => trim($_POST['nombre']),
      "apellido" => trim($_POST['apellido']),
     "clave" => $hashedPass,
      "tel" => trim($_POST['tel']),
    ];
    $usuario = new Usuarios();
  if($usuario->comprobarUsuario($array["usuario"])) {
    echo "<header>";
    echo "<script language='javascript'>window.location='../vista/IngresarUsuario.php?usuario=" .$array['tipousuario']."&existe=1'</script>;";
    echo "</header>";
  } else {
    if(!$usuario->agregarUsuario($array)) {
 echo "<header>";
      echo "<script language='javascript'>window.location='../vista/IngresarUsuario.php?usadd=2'</script>;";
      echo "</header>";
    } else {
    //INGRESO DEL REGISTRO A LA BITACORA**********************************************************************************************
      $log = new Historial();
      $array2 = [
      "idusuario" => $_SESSION["sesion4"]["usuario"],
      "detalle" => "El usuario: " .$_SESSION["sesion4"]["usuario"]. " agrego el nuevo usuario: " .$_POST['usuario']. "",
      ];
      $log1 = $log->agregarLog($array2);
    //**********************************************************************************************************************************  
      echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarUsuarios.php?usadd=1&type=".$array["tipousuario"]."'</script>;";
      echo "</header>";
    }
  }
  }
}
  //ELIMINAR REGISTRO DE  UN USUARIO*****************************************************************************************************************
else if(isset($_GET['delete_id'])) {
    $idusuario = $_GET['delete_id'];
    $usuario = new Usuarios();
    $nombre = $usuario->getDatosUsuarioID($idusuario);
    
        if(!$usuario->borrarUsuario($idusuario)) {
   echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarUsuarios.php?usr=3&type=".$nombre["tipousuario"]."'</script>;";
      echo "</header>";
    } else {
        //FUNCION DE BORRAR REGISTRAR A LA BITACORA**********************************************************************************************
      $log = new Historial();
      $array = [
      "idusuario" => $_SESSION["sesion4"]["idusuario"],
      "detalle" => "El usuario: " .$_SESSION["sesion4"]["usuario"]. " ha eliminado al usuario: ".$nombre['usuario']. "",
      ];
      $log1 = $log->agregarLog($array);
    //**********************************************************************************************************************************  
     echo "<header>";
      echo "<script language='javascript'>window.location='../vista/ListarUsuarios.php?usr=2&type=".$nombre["tipousuario"]."'</script>;";
      echo "</header>";
    }
        
    }
?>
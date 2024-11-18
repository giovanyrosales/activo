<?php
/*
* CLASE PARA EL MANEJO DE DATOS DESDE/HACIA LA TABLA USUARIOS
*/
require_once "../firephp/lib/FirePHPCore/fb.php";
require_once "../modelo/conexiondb.php";
ob_start();
class Usuarios extends conexion {
  private static $conn = null;

/*
*   Contructor de la clase
*/
  public function __construct() {
    self::$conn = parent::getInstance();
  }
    
/*
*   Consigue los datos de la tabla de usuarios 
*   relacionados con la columna usuario
*   
*   @param 
*/
  public function getDatosUsuario( $usuario ) {
    $stmt = self::$conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
  
/*
*   Consigue los datos de la tabla de usuarios asociados a un id
*   para rellenar el formulario de editar usuarios 
*   
*   @param $carnet El codigo del carnet del estudiante
*/
  public function getDatosUsuarioID( $idusuario ) {
    $stmt = self::$conn->prepare("SELECT * FROM usuario WHERE idusuario = ?");
    $stmt->bind_param('s', $idusuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
/*
* Actualiza una tupla de usuario de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarUsuario( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, tel = ?, usuario = ?
    WHERE idusuario = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssssi', $array["nombre"], $array["apellido"], $array["tel"], $array["usuario"], $array["idusuario"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla;
  }
  /*
* Actualiza una tupla de usuario de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarUsuarioConFoto( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE usuario SET nombre = ?, apellido = ?, tel = ?, usuario = ?, foto = ?
    WHERE idusuario = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('sssssi', $array["nombre"], $array["apellido"], $array["tel"], $array["usuario"], $array["foto"], $array["idusuario"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla;
  }
  /*
  * Agrega un nuevo usuario a la base de datos
  *
  * @param $array Los datos a ingresar a la base de datos
  */
  public function agregarUsuario( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO usuario(tipousuario, usuario, nombre, apellido, clave, tel) 
    VALUES (?, ?, ?, ?, ?, ?)");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
  $query->bind_param('isssss', $array["tipousuario"], $array["usuario"], $array["nombre"], $array["apellido"], $array["clave"], $array["tel"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla;
  }
  /*
  * Agrega un nuevo usuario a la base de datos
  *
  * @param $array Los datos a ingresar a la base de datos
  */
  public function agregarUsr( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO usuario(tipousuario, nombre, apellido, tel) 
    VALUES (?, ?, ?, ?)");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
  $query->bind_param('isss', $array["tipousuario"], $array["nombre"], $array["apellido"],  $array["tel"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla;
  }
      /*
  * Actualiza claves de usuarios
  *
  * @param $clave Los datos del usuario a actualizar
  */
  public function editarClave( $user_input, $idusuario) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE usuario SET  clave = ?
    WHERE idusuario = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $user_input, $idusuario);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    return $tupla;
  }
  /*
  * Comprueba si el campo usuario ya existe en la tabla usuario
  *
  * @param $usuario El valor del campo a comprobar
  */
  public function comprobarUsuario( $usuario ) {
    $query = "SELECT usuario FROM usuario WHERE usuario = '". $usuario ."'";
    $result = self::$conn->query($query);
    if($result->num_rows >0 ) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /*
  * Funcion para obtener todos los usuarios de la tabla a excepcion de jefatura
  */
  public function getAll() {
    $result = self::$conn->query("SELECT * FROM usuario");
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
    return $rows;
  }

     /*
  * Elimina un estudiante de la base de datos que aun no haya actualizados datos
  *
  * @param $idusuario El identificador del estudiante a eliminar
  */
 public function borrarUsuario( $idusuario ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM usuario WHERE idusuario = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('s', $idusuario);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla;
  }


}
?>
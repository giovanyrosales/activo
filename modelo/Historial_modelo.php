<?php
/*
* CLASE PARA EL MANEJO DE INGRESOS DE LOG A LA TABLA BITACORA DE LA DB
*/
require_once "../firephp/lib/FirePHPCore/fb.php";
require_once "../modelo/conexiondb.php";
ob_start();
class Historial extends conexion {
  private static $conn = null;
  
  /*
  * constructor de la clase
  */
  public function __construct() {
    self::$conn = parent::getInstance();
  }
  
  /*
  * Funcion para agregar un registro a la bitacora
  * @param $array Los datos a ingresar a la tabla bitacora
  */
  public function agregarLog( $array ) {
    //PREPARA LA FECHA DEL REGISTRO
    date_default_timezone_set('America/El_Salvador'); 
    $fecha = date("Y-m-d H:i:s");
    //INGRESA EL REGISTRO
    $query = self::$conn->prepare("INSERT INTO historial(idusuario, detalle, fecha) VALUES ( ?, ?, ?)");
    $query->bind_param('iss', $array["idusuario"], $array["detalle"], $fecha);
    $tupla = $query->execute();
    if($tupla) {
      return TRUE;
    } else {
         $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
      return FALSE;
    }
  }
  
  /*
  * Funcion para obtener todos los registros de la tabla bitacora
  */
  public function getLog() {
    $result = self::$conn->query("SELECT * FROM historial");
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
    return $rows;
  }
  
  /*
  * Funcion para obtener los registros de una fecha especifica
  * @param $fecha La fecha a consultar en la tabla bitacora
  */
  public function getLogFecha( $fecha ) {
    $result = self::$conn->query("SELECT * FROM historial WHERE fecha = '" .$fecha. "'");
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
    return $rows;
  }
}
?>

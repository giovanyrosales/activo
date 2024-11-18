<?php
/*
* CLASE PARA EL MANEJO DE DATOS DESDE/HACIA LA TABLA de configuraciones
*/
require_once "../firephp/lib/FirePHPCore/fb.php";
require_once "../modelo/conexiondb.php";
ob_start();

class Sustitucion extends conexion {
  private static $conn = null;

/*
*   Contructor de la clase
*/
  public function __construct() {
    self::$conn = parent::getInstance();
  }
  public function getAllSustituciones() {
    $query = "SELECT * FROM sustitucion";
    $result = self::$conn->query($query);
    /* array asociativo */
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
      }
      return $rows;
  }

/*
* Actualiza una tupla de proyecto de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarSustitucion( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE sustitucion SET piezasustituida = ?, piezanueva = ?, observaciones = ?"
            . " WHERE idsustitucion = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssss', $array["piezasustituida"], $array["piezanueva"], $array["observaciones"], $array["idsustitucion"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    } 
    return $tupla;  
  }
 
  /*
  * Agrega un nuevo proyecto a la base de datos
  *
  * @param $array Los datos a ingresar a la base de datos
  */ 
   public function agregarSustitucion( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO sustitucion (bien, piezasustituida, valorajustado, piezanueva, observaciones, vidautil, fecha, documento) VALUES (?,?,?,?,?,?,?,?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssssssss', $array["bien"], $array["piezasustituida"], $array["valorajustado"], $array["piezanueva"], $array["observaciones"], $array["vidautil"], $array["fecha"],$array["documento"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
      return $tupla;
    } else {
        return $query;  
    }    
  } 


    /*
  * Elimina un proyecto de la base de datos
  *
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarSustitucion($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM sustitucion WHERE idsustitucion = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('s', $id);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla;
  }
          /*
 * Obtiene el nombre de un codigo
 */
  /*AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII*/
  
  public function getSustitucionById($idbien) {
    $rows=null;
    $query = "SELECT * FROM sustitucion  WHERE bien = '".$idbien."' ORDER BY fecha ASC";
    $result = self::$conn->query($query);
    /* array asociativo */
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
      }
      return $rows;
  } 
  
}




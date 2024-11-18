<?php
/*
* CLASE PARA EL MANEJO DE DATOS DESDE/HACIA LA TABLA de configuraciones
*/
require_once "../firephp/lib/FirePHPCore/fb.php";
require_once "../modelo/conexiondb.php";
ob_start();
class Muebles extends conexion {
  private static $conn = null;

/*
*   Contructor de la clase
*/
  public function __construct() {
    self::$conn = parent::getInstance();
  }
  /*
*  extrae todo los traslados
*/
  public function getAllTraslados() {
    $query = "SELECT * FROM traslado";
    $result = self::$conn->query($query);
    /* array asociativo */
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
      }
      return $rows;
  }
  /*
*  Lista todos los descargos
*/
  public function getAllDescargos() {
    $query = "SELECT * FROM descargo";
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
  public function actualizarTraslado( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE traslado SET bien = ?, fechatraslado = ?, deptorecibe = ?"
            . " WHERE idtraslado = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssss', $array["bien"], $array["fechatraslado"], $array["deptorecibe"], $array["idtraslado"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    } 
    return $tupla;  
  }
  /*
* Actualiza una tupla de proyecto de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarDepto( $idbien, $deptoenvia ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE bien SET departamento = ? WHERE idbien = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $deptoenvia, $idbien);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    } 
    return $tupla;  
  }
    /*
* Actualiza una tupla de proyecto de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarCodigo( $idbien, $codigo ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE bien SET codigo = ? WHERE idbien = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $codigo, $idbien);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    } 
    return $tupla;  
  }
  /*
* Actualiza una tupla de proyecto de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarDescargo( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE descargo SET bien = ?, fechadescargo = ?, observaciones = ?"
            . " WHERE iddescargo = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssss', $array["bien"], $array["fechadescargo"], $array["observaciones"], $array["iddescargo"]);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $tupla = $query->execute(); 
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    } 
    return $tupla;  
  }
  /*
* Actualiza una tupla de proyecto de la base de datos
*
* @param $array El arreglo que contiene todas las variables a ingresar a la db
*/
  public function actualizarEstado( $idbien ,$idestado) {
    //PREPARA LA SENTENCIA SQL
      
    $query = self::$conn->prepare("UPDATE bien SET estado = ? WHERE idbien = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $idestado, $idbien);
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
   public function agregarDescargo( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO descargo (bien, fechadescargo, historyvalor, observaciones) VALUES (?, ?, ?, ?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssss', $array["bien"], $array["fechadescargo"], $array["historyvalor"], $array["observaciones"]);
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
  * Agrega un nuevo proyecto a la base de datos
  *
  * @param $array Los datos a ingresar a la base de datos
  */ 
   public function agregarTraslado( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO traslado (bien, fechatraslado, deptoenvia, deptorecibe) VALUES (?, ?, ?, ?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ssss', $array["bien"], $array["fechatraslado"], $array["deptoenvia"], $array["deptorecibe"]);
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
  * Obtiene los proyectos por el codigo
  *
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getTraslado( $id ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT * FROM traslado WHERE idtraslado = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('s', $id);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $query->execute(); 
    $tupla = $query->get_result();
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla->fetch_array(MYSQLI_ASSOC);
  }
   /*
  * Obtiene los proyectos por el codigo
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getDescargo( $id ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT * FROM descargo WHERE iddescargo = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('s', $id);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $query->execute(); 
    $tupla = $query->get_result();
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla->fetch_array(MYSQLI_ASSOC);
  }
    /*
  * Elimina un proyecto de la base de datos
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarTraslado($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM traslado WHERE idtraslado = ?");
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
  * Elimina un proyecto de la base de datos
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarDescargo($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM descargo WHERE iddescargo = ?");
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
  * Obtiene los proyectos por el codigo
  *
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getCodigoanterior( $idbien ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT codigo FROM bien WHERE idbien = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('s', $idbien);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $query->execute(); 
    $tupla = $query->get_result();
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla->fetch_array(MYSQLI_ASSOC);
  }
    /*
  * Obtiene los proyectos por el codigo
  *
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getCodigonuevo( $iddpto ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT codigo FROM departamento WHERE iddepartamento = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('s', $iddpto);
    //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
    $query->execute(); 
    $tupla = $query->get_result();
    if(!$tupla) {
      $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
      fb($msj,FirePHP::TRACE); //mensaje a enviar a consola en caso de error
    }
    return $tupla->fetch_array(MYSQLI_ASSOC);
  }
}


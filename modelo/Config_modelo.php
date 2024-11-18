<?php
/*
* CLASE PARA EL MANEJO DE DATOS DESDE/HACIA LA TABLA de configuraciones
*/
require_once "../firephp/lib/FirePHPCore/fb.php";
require_once "../modelo/conexiondb.php";
ob_start();
class Config extends conexion {
  private static $conn = null;

/*
*   Contructor de la clase
*/
  public function __construct() {
    self::$conn = parent::getInstance();
  }
  public function getAllDepto() {
    $query = "SELECT * FROM departamento";
    $result = self::$conn->query($query);
    /* array asociativo */
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
      }
      return $rows;
  }
  public function getAllDescriptor() {
    $query = "SELECT * FROM descriptor";
    $result = self::$conn->query($query);
    /* array asociativo */
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
      }
      return $rows;
  }
  /*
*   Recupera todas los ingresos de la tabla de ingresos
*   
*/
  public function getAllCodigoContable() {
    $query = "SELECT * FROM codcontable";
    $result = self::$conn->query($query);
    /* array asociativo */
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
      }
      return $rows;
  }
  /*
*   Recupera todas los ingresos de la tabla de ingresos
*   
*/
  public function getAllCodDepre() {
    $query = "SELECT * FROM coddepreciacion";
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
  public function actualizarDepto( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE departamento SET codigo = ?, nombre = ?"
            . " WHERE iddepartamento = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('sss', $array["codigo"], $array["nombre"], $array["iddepartamento"]);
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
  public function actualizarDescriptor( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE descriptor SET codigodes = ?, descripcion = ?"
            . " WHERE iddescriptor = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('sss', $array["codigodes"], $array["descripcion"], $array["iddescriptor"]);
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
  public function actualizarCodContable( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE departamento SET codconta = ?, nombre = ?"
            . " WHERE idcodcontable = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('sss', $array["codconta"], $array["nombre"], $array["idcodcontable"]);
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
  public function actualizarCoddepre( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("UPDATE coddepreciacion SET coddepre = ?, nombre = ?"
            . " WHERE idcoddepreciacion = ?");
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('sss', $array["coddepre"], $array["nombre"], $array["idcoddepreciacion"]);
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
   public function agregarDepto( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO departamento (codigo, nombre) VALUES (?, ?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $array["codigo"], $array["nombre"]);
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
  public function agregarDescriptor( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO descriptor(codigodes, descripcion) VALUES (?, ?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $array["codigodes"], $array["descripcion"]);
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
  public function agregarCodConta( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO codcontable(codconta, nombre) VALUES (?, ?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $array["codconta"], $array["nombre"]);
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
  public function agregarCodDepre( $array ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("INSERT INTO coddepreciacion(coddepre, nombre) VALUES (?, ?)");    
    //RELACIONA LOS PARAMETROS CON LA SENTENCIA
    $query->bind_param('ss', $array["coddepre"], $array["nombre"]);
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
  public function getDepto( $id ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT * FROM departamento WHERE iddepartamento = ?");
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
  *
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getDescriptor( $id ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT * FROM descriptor WHERE iddescriptor = ?");
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
  *
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getCodConta( $id ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT * FROM codcontable WHERE idcodcontable = ?");
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
  *
  * @param $cod El identificador de los ingresos a obtener
  */
  public function getCodDepre( $id ) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("SELECT * FROM coddepreciacion WHERE idcoddepreciacion = ?");
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
  *
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarDepto($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM departamento WHERE iddepartamento = ?");
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
  *
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarDescriptor($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM descriptor WHERE iddescriptor = ?");
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
  *
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarCodConta($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM codcontable WHERE idcodcontable = ?");
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
  *
  * @param $codigo El identificador del proyecto a eliminar
  */
  public function eliminarDepre($id) {
    //PREPARA LA SENTENCIA SQL
    $query = self::$conn->prepare("DELETE FROM coddepreciacion WHERE idcoddepreciacion = ?");
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

}




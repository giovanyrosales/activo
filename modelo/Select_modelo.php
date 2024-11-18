<?php

/*
 * 2016 Hecho por Giovany Rosales.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Select_modelo
 *
 * @author MauricioG
 */
/*
* CLASE PARA EL MANEJO DE TABLAS NO ESPECIFICAS
*/
require_once "../modelo/conexiondb.php";

class Selects extends conexion {
 private static $conn = null;
 
 /*
 *   Contructor de la clase
 */
 public function __construct() {
   self::$conn = parent::getInstance();
 }
 
 /*
 * Obtiene la lista de tipoingreso
 */
 public function getTipo() {
  $result = self::$conn->query("SELECT * FROM tipo");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
 }
 
 /*
 * Obtiene la lista de proveedores
 */
 public function getEstado() {
  $result = self::$conn->query("SELECT * FROM estado");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
 }
 
 /*
 * Obtiene todas las Unidades de Medida
 */
 public function getDescriptor() {
  $result = self::$conn->query("SELECT * FROM descriptor");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
 /*
 * Obtiene todas las Unidades de Medida
 */
 public function getCodigosCont() {
  $result = self::$conn->query("SELECT * FROM codcontable");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
   /*
 * Obtiene todas los tipos de material
 */
 public function getDepartamento() {
  $result = self::$conn->query("SELECT * FROM departamento");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
    /*
 * Obtiene el nombre de un tipo de material especifico
 */
 public function getCodigoDescriptor($iddescriptor) {
   $stmt = self::$conn->prepare("SELECT codigodes FROM descriptor WHERE iddescriptor = ?");
    $stmt->bind_param('s', $iddescriptor);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
    /*
 * Obtiene el nombre de un tipo de material especifico
 */
 public function getCodigoDepartamento($iddepartamento) {
   $stmt = self::$conn->prepare("SELECT codigo FROM departamento WHERE iddepartamento = ?");
    $stmt->bind_param('s', $iddepartamento);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
      /*
 * Obtiene el nombre de un tipo de material especifico
 */
 public function getLastInmueble($tipo) {
   $stmt = self::$conn->prepare("SELECT codigo FROM bien where tipo = ? ORDER BY codigo DESC LIMIT 1");
    $stmt->bind_param('s', $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
     /*
 * Obtiene el nombre de un tipo de material especifico
 */
 public function getLastVehiculo($tipo) {
   $stmt = self::$conn->prepare("SELECT codigo FROM bien where tipo = ?  ORDER BY `bien`.`idbien` DESC LIMIT 1");
    $stmt->bind_param('s', $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
   /*
 * Obtiene los usuarios presupuestarios
 */
 public function getCodcontable() {
  $result = self::$conn->query("SELECT * FROM codcontable");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
    /*
 * Obtiene los usuarios presupuestarios
 */
 public function getCoddepreciacion() {
  $result = self::$conn->query("SELECT * FROM coddepreciacion");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
   public function replace_specials_characters($s) {
		
		$s = preg_replace("/á|à|â|ã|ª/","a",$s);
		$s = preg_replace("/Á|À|Â|Ã/","A",$s);
		$s = preg_replace("/é|è|ê/","e",$s);
		$s = preg_replace("/É|È|Ê/","E",$s);
		$s = preg_replace("/í|ì|î/","i",$s);
		$s = preg_replace("/Í|Ì|Î/","I",$s);
		$s = preg_replace("/ó|ò|ô|õ|º/","o",$s);
		$s = preg_replace("/Ó|Ò|Ô|Õ/","O",$s);
		$s = preg_replace("/ú|ù|û/","u",$s);
		$s = preg_replace("/Ú|Ù|Û/","U",$s);
		$s = str_replace(" ","_",$s);
		$s = str_replace("ñ","n",$s);
		$s = str_replace("Ñ","N",$s);
		$s = iconv("utf-8", "us-ascii//TRANSLIT", $s);
		$s = preg_replace('/[^a-zA-Z0-9_.-]/', '', $s);
		return $s;
	}
        
         /*
 * Obtiene la lista de proyectos
 */
 public function getProyectos() {
  $result = self::$conn->query("SELECT * FROM proyecto");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
 }
 
 /*
 * Obtiene el numero de filas de la tabla de presupuesto
 *
 * @param $proyecto El ID DEL PROYECTO
 */
 public function getCorrelativo($codigo)
    {
        $stmt = self::$conn->prepare("SELECT codigo FROM bien where descriptor = ? order by idbien desc   limit 1 ");
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }
 
    /*
 * Obtiene LAS ORDENES INCOMPLETAS REGISTRAS EN LA TABLA ORDEN
 */
 public function getOrdenes() {
  $result = self::$conn->query("SELECT * FROM orden where completo = 'no'");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
      /*
 * Obtiene LOS TIPOS DE MEZCLA REGISTRADOS EN LA TABLA TIPOMEZCLA
 */
 public function getMezclas() {
  $result = self::$conn->query("SELECT * FROM tipomezcla");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
       /*
 * Obtiene el nombre de un codigo
 */
 public function getNombreCodContable($codigo) {
   $stmt = self::$conn->prepare("SELECT * FROM codcontable where idcodcontable = ?  ");
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
        /*
 * Obtiene el nombre de un codigo
 */
 public function getNombreCodDepre($codigo) {
   $stmt = self::$conn->prepare("SELECT * FROM coddepreciacion where idcoddepreciacion = ?  ");
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
         /*
 * Obtiene el nombre de un codigo
 */
 public function getDepto($id) {
   $stmt = self::$conn->prepare("SELECT * FROM departamento where iddepartamento = ?  ");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
          /*
 * Obtiene el nombre de un codigo
 */
 public function getSaldoCodConta($cod) {
   $stmt = self::$conn->prepare("SELECT SUM(valor) as saldo FROM bien where codcontable = ? and estado = '1' group by codcontable");
    $stmt->bind_param('s', $cod);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
      /*
 * Obtiene LAS ORDENES INCOMPLETAS REGISTRAS EN LA TABLA ORDEN
 */
 public function getBienByCodCont($cod) {
  $result = self::$conn->query("SELECT * FROM bien where codcontable = '".$cod."' and estado = '1' and origen = 'propio'");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
       /*
 * Obtiene LAS ORDENES INCOMPLETAS REGISTRAS EN LA TABLA ORDEN
 */
 public function getRepVitalByDate($fechainicial, $fechafinal) {
  $result = self::$conn->query("SELECT * FROM sustitucion where fecha between '".$fechainicial."' and '".$fechafinal."' order by fecha ASC");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
  public function getBienByCod($codigo)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT * FROM bien  WHERE codigo = ? and tipo != '2' ");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $codigo);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $query->execute();
        $tupla = $query->get_result();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla->fetch_array(MYSQLI_ASSOC);
    }
            /*
 * Obtiene el nombre de un codigo
 */
 public function getCodBien($idbien) {
   $stmt = self::$conn->prepare("SELECT codigo FROM bien where idbien = ?  ");
    $stmt->bind_param('s', $idbien);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
          /*
 * Obtiene el nombre de un codigo
 */
 public function getTcompra($idbien) {
   $stmt = self::$conn->prepare("SELECT tcompra FROM bien where idbien = ?  ");
    $stmt->bind_param('s', $idbien);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
           /*
 * Obtiene el nombre de un codigo
 */
 public function getOrigen($idbien) {
  $stmt = self::$conn->prepare("SELECT origen FROM bien where idbien = ?  ");
   $stmt->bind_param('s', $idbien);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_array(MYSQLI_ASSOC);
   return $row;
 }
            /*
 * obtiene el historial de depreciacion de un año especifico
 */
public function getHistorialdaporanio($bien, $anio) {
  $stmt = self::$conn->prepare("SELECT vallibros FROM historialda where bien =  ?  and anio = ? and depacumulada != 0 order by idhistorialda  DESC LIMIT 1");
  $stmt->bind_param('ss', $bien, $anio );
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_array(MYSQLI_ASSOC);
  return $row;
} 
  /*
 * comprueba q no tenga registrado el anio en el historial de depreciacion
 */
  public function getHistorialda( $bien , $anio ) {
    $query = "SELECT * FROM historialda WHERE bien = '". $bien."' AND anio = '".$anio."' ";
    $result = self::$conn->query($query);
    if($result->num_rows >0 ) {
      return TRUE;
    } else { 
      return FALSE;
    }
  }
  /*
  * Extrae el Valor actual de cantidad
  *
  * @param  
  */
   public function getDepAcum($bien, $anio) {
    $stmt = self::$conn->prepare("SELECT depacumulada FROM historialda where bien =  ?  and anio < ? and depacumulada != 0 order by idhistorialda  DESC LIMIT 1");
    $stmt->bind_param('ss', $bien, $anio );
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  } 
    /*
  * Extrae el Valor actual de cantidad
  *
  * @param 
  */
  public function getVidaExtra($bien) {
    $stmt = self::$conn->prepare("SELECT  SUM(vidautil) as vidaextra from sustitucion where bien = ?");
    $stmt->bind_param('s', $bien );
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  } 
  
  /*
  * Extrae el Valor actual de cantidad
  *
  * @param 
  */
  public function getRepVital( $bien, $fechaini, $fechafin) {
    $stmt = self::$conn->prepare("SELECT * FROM sustitucion where bien = ? and fecha between ? and ?");
    $stmt->bind_param('sss', $bien, $fechaini, $fechafin);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  } 
       /*
 * Obtiene LAS reposiciones
 */
 public function getRepVitalAll($bien) {
  $result = self::$conn->query("SELECT * FROM sustitucion where bien =  '".$bien."' ");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }
   /*
     * Elimina un proyecto de la base de datos
     *
     * @param $codigo El identificador del proyecto a eliminar
     */

    public function eliminarDAByanio($anio, $bien)
    {
        $query = self::$conn->prepare("DELETE FROM historialda WHERE bien = ? and anio  = ?");
        $query->bind_param('ss', $bien, $anio);
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }
             /*
 * Obtiene datos de los codigos de depreciacion
 */
 public function getCodDep($id) {
   $stmt = self::$conn->prepare("SELECT * FROM coddepreciacion where idcoddepreciacion = ?  ");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row;
  }
}
?>

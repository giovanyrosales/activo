<?php

/*
 * CLASE PARA EL MANEJO DE DATOS DESDE/HACIA LA TABLA Ingresos
 */
require_once "../firephp/lib/FirePHPCore/fb.php";
require_once "../modelo/conexiondb.php";
ob_start();

class Bienes extends conexion
{
    private static $conn = null;

    /*
     *   Contructor de la clase
     */

    public function __construct()
    {
        self::$conn = parent::getInstance();
    }

    /*
     *   Recupera todas los ingresos de la tabla de ingresos
     *
     */

    public function getAll()
    {
        $query = "SELECT * FROM bien WHERE estado=1";
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

    public function getMuebles()
    {
        $query = "SELECT * FROM bien where (tipo =1) AND (estado=1) order by fechacompra DESC";
        $result = self::$conn->query($query);
        /* array asociativo */
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getMueblesByDepartamento($depa)
    {
        $query = "SELECT * FROM bien where departamento =  '" . $depa . "' and estado = '1'  order by fechacompra DESC";
        $result = self::$conn->query($query);
        /* array asociativo */
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getMueblesByDescriptor($descri)
    {
        $query = "SELECT * FROM bien where descriptor =  '" . $descri . "' order by fechacompra DESC";
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

    public function getInmuebles()
    {
        $query = "SELECT * FROM bien where (tipo = 2) AND (estado=1 OR estado=4)";
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

    public function getComodatos()
    {
        $query = "SELECT * FROM comodato";
        $result = self::$conn->query($query);
        /* array asociativo */
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /*

      /*************************************************************************************************************************************************************
     *   Recupera todas los ingresos de la tabla de ingresos
     *
     */

    public function getDonaciones()
    {
        $query = "SELECT * FROM donacion";
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

    public function getVehiculos()
    {
        $query = "SELECT * FROM bien where (tipo =3) AND (estado = 1)";
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

    public function actualizarMueble($array)
    {
        if ($array["valor"] >= 600) {
         if (isset($array["documento"]) and isset($array["factura"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, documento = ?, factura = ?, fechacompra=?, codcontable = ?, coddepreciacion = ?, vidautil = ?, valresidual = ?, tcompra = ?, anio = ?, origen = ? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('sssssssssssss', $array["descripcion"], $array["valor"], $array["documento"], $array["factura"], $array['fechacompra'],$array["codcontable"], $array["coddepreciacion"],$array["vidautil"], $array["valresidual"], $array["tcompra"], $array["anio"], $array["origen"], $array["idbien"]);
        }
        if (isset($array["documento"]) and !isset($array["factura"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, documento = ?, fechacompra=?, codcontable = ?, coddepreciacion = ?, vidautil = ?, valresidual = ?, tcompra = ?, anio = ?, origen = ? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('ssssssssssss', $array["descripcion"], $array["valor"], $array["documento"], $array['fechacompra'],$array["codcontable"], $array["coddepreciacion"],$array["vidautil"], $array["valresidual"], $array["tcompra"], $array["anio"], $array["origen"], $array["idbien"]);
        }
        if (isset($array["factura"]) and !isset($array["documento"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, factura = ?, fechacompra=?, codcontable = ?, coddepreciacion = ?, vidautil = ?, valresidual = ?, tcompra = ? , anio = ?, origen = ? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('ssssssssssss', $array["descripcion"], $array["valor"], $array["factura"], $array['fechacompra'],$array["codcontable"], $array["coddepreciacion"],$array["vidautil"], $array["valresidual"], $array["tcompra"], $array["anio"], $array["origen"], $array["idbien"]);
        }
        if (!isset($array["factura"]) and !isset($array["documento"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, fechacompra=?, codcontable = ?, coddepreciacion = ?, vidautil = ?, valresidual = ?, tcompra = ?, anio = ?, origen = ? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('sssssssssss', $array["descripcion"], $array["valor"],$array['fechacompra'],$array["codcontable"], $array["coddepreciacion"],$array["vidautil"], $array["valresidual"], $array["tcompra"], $array["anio"], $array["origen"], $array["idbien"]);
            }
        }else{
        if (isset($array["documento"]) and isset($array["factura"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, documento = ?, factura = ?, fechacompra=? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('ssssss', $array["descripcion"], $array["valor"], $array["documento"], $array["factura"], $array['fechacompra'], $array["idbien"]);
        }
        if (isset($array["documento"]) and !isset($array["factura"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, documento = ?, fechacompra=? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('sssss', $array["descripcion"], $array["valor"], $array["documento"], $array['fechacompra'], $array["idbien"]);
        }
        if (isset($array["factura"]) and !isset($array["documento"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, factura = ?, fechacompra=? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('sssss', $array["descripcion"], $array["valor"], $array["factura"], $array['fechacompra'], $array["idbien"]);
        }
        if (!isset($array["factura"]) and !isset($array["documento"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, fechacompra=? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('ssss', $array["descripcion"], $array["valor"],$array['fechacompra'], $array["idbien"]);
            }
        }
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*
     * Actualiza una tupla de proyecto de la base de datos
     *
     * @param $array El arreglo que contiene todas las variables a ingresar a la db
     */

    public function actualizarComodato($array)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("UPDATE comodato SET institucion  = ?, observaciones = ?, bien = ?, documento = ?, fecha = ? WHERE idcomodato = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('ssssss', $array["institucion"], $array["observaciones"], $array["bien"], $array["documento"], $array["fecha"], $array["idcomodato"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*
     * Actualiza una tupla de proyecto de la base de datos
     *
     * @param $array El arreglo que contiene todas las variables a ingresar a la db
     */

    public function actualizarDonacion($array)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("UPDATE donacion SET institucion  = ?, observaciones = ?, bien = ?, documento = ?, fecha = ? WHERE iddonacion = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('ssssss', $array["institucion"], $array["observaciones"], $array["bien"], $array["documento"], $array["fecha"], $array["iddonacion"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*
     * Actualiza una tupla de proyecto de la base de datos
     *
     * @param $array El arreglo que contiene todas las variables a ingresar a la db
     */

    public function actualizarInmueble($array)
    {
        if (isset($array["documento"]) ) {
           //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, observaciones = ?, edificaciones = ?, permuta = ?, documento= ?, fechacompra =?, inscrito=? WHERE idbien = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssssssss', $array["descripcion"], $array["valor"], $array["observaciones"], $array["edificaciones"], $array["permuta"],$array['documento'], $array['fechacompra'],$array['inscrito'], $array["idbien"]);
        }else{
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, valor = ?, observaciones = ?, edificaciones = ?, permuta = ?, fechacompra =?, inscrito =? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('ssssssss', $array["descripcion"], $array["valor"], $array["observaciones"], $array["edificaciones"], $array["permuta"], $array['fechacompra'],$array['inscrito'], $array["idbien"]);
            //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        }
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*
     * Actualiza una tupla de proyecto de la base de datos
     *
     * @param $array El arreglo que contiene todas las variables a ingresar a la db
     */

    public function actualizarVehimaq($array)
    {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE bien SET descripcion  = ?, motorista = ?, encargado = ?, valor=?, fechacompra =?, placa = ?, anio = ?, codcontable = ?, coddepreciacion = ?, vidautil = ?, valresidual = ?, tcompra = ?, origen = ?, estadoeq = ? WHERE idbien = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('sssssssssssssss', $array["descripcion"], $array["motorista"], $array["encargado"], $array['valor'], $array['fechacompra'],$array['placa'], $array['anio'], $array["codcontable"], $array["coddepreciacion"],$array["vidautil"], $array["valresidual"], $array["tcompra"], $array["origen"], $array["estadoeq"], $array["idbien"]);
        
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }
    public function actualizarDoc($doc, $idbien)
    {
            $query = self::$conn->prepare("UPDATE bien SET  documento = ? WHERE idbien = ?");
            $query->bind_param('ss', $doc, $idbien);
            $tupla = $query->execute(); 
            return $tupla;
    }
    public function actualizarFac($fac, $idbien)
    {
            $query = self::$conn->prepare("UPDATE bien SET  factura = ? WHERE idbien = ?");
            $query->bind_param('ss', $fac, $idbien);
            $tupla = $query->execute(); 
            return $tupla;
    }
    public function actualizarFot($fot, $idbien)
    {
            $query = self::$conn->prepare("UPDATE bien SET  foto = ? WHERE idbien = ?");
            $query->bind_param('ss', $fot, $idbien);
            $tupla = $query->execute(); 
            return $tupla;
    }

    /*
     * Agrega un nuevo proyecto a la base de datos
     *
     * @param $array Los datos a ingresar a la base de datos
     */

    public function agregarBMuebles($array)
    {
        //PREPARA LA SENTENCIA SQL
        $estado = "1";
        $query = self::$conn->prepare("INSERT INTO bien(codigo, descripcion, valor, fechacompra, departamento, tipo, descriptor, estado,documento,factura) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('ssssssssss', $array["codigo"], $array["descripcion"], $array["valor"], $array["fechacompra"], $array["departamento"], $array["tipo"], $array["descriptor"], $estado, $array["documento"], $array["factura"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
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

    public function agregarComodato($array)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("INSERT INTO comodato(institucion, observaciones, bien, documento, fecha) VALUES (?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssss', $array["institucion"], $array["observaciones"], $array["bien"], $array["documento"], $array["fecha"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
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

    public function agregarDonacion($array)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("INSERT INTO donacion(institucion, observaciones, bien, documento, fecha) VALUES (?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssss', $array["institucion"], $array["observaciones"], $array["bien"], $array["documento"], $array["fecha"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
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

    public function agregarBMueblesMayor900($array)
    {
        //PREPARA LA SENTENCIA SQL
        $estado = "1";
        $query = self::$conn->prepare("INSERT INTO bien(codigo, descripcion, valor, fechacompra, departamento, tipo, codcontable, descriptor, coddepreciacion, vidautil, valresidual, estado, tcompra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssssssssssss', $array["codigo"], $array["descripcion"], $array["valor"], $array["fechacompra"], $array["departamento"], $array["tipo"], $array["codcontable"], $array["descriptor"], $array["coddepreciacion"], $array["vidautil"], $array["valresidual"], $estado, $array["tcompra"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
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

    public function agregarVehyMaq($array)
    {
        //PREPARA LA SENTENCIA SQL
        $estado = "1";
        $query = self::$conn->prepare("INSERT INTO bien(codigo, descripcion, valor, fechacompra, anio, fechavectar, placa, observaciones, codcontable, coddepreciacion, vidautil, valresidual, departamento, motorista, encargado, tipo, estado, documento, factura, tcompra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('ssssssssssssssssssss', $array["codigo"], $array["descripcion"], $array["valor"], $array["fechacompra"], $array["anio"], $array["fechavectar"], $array["placa"], $array["observaciones"], $array["codcontable"], $array["coddepreciacion"], $array["vidautil"], $array["valresidual"], $array["departamento"], $array["motorista"], $array["encargado"], $array["tipo"], $estado, $array["documento"], $array["factura"], $array["tcompra"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
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

    public function agregarBInmuebles($array)
    {
        //PREPARA LA SENTENCIA SQL
        $estado = "1";
        $query = self::$conn->prepare("INSERT INTO bien(codigo, descripcion, valor, fechacompra, documento, inscrito, observaciones, contiene, ubicacion, valorregistrado, estado, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('ssssssssssss', $array["codigo"], $array["descripcion"], $array["valor"], $array["fechacompra"], $array["documento"], $array["inscrito"], $array["observaciones"], $array["contiene"], $array["ubicacion"], $array["valorregistrado"], $estado, $array["tipo"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
            return $tupla;
        } else {
            return $query;
        }
    }

    /*
     * Obtiene lso bienes por el id
     *
     * @param $cod El identificador de los ingresos a obtener
     */

    public function getBien($idbien)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT * FROM bien WHERE idbien = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $idbien);
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
     * Obtiene los proyectos por el codigo
     *
     * @param $cod El identificador de los ingresos a obtener
     */

    public function getBienByCod($codigo)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT * FROM bien  WHERE codigo = ?");
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
     * Obtiene los proyectos por el codigo
     *
     * @param $cod El identificador de los ingresos a obtener
     */

    public function getComodato($idcomodato)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT * FROM comodato WHERE idcomodato = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $idcomodato);
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
     * Obtiene los proyectos por el codigo
     *
     * @param $cod El identificador de los ingresos a obtener
     */

    public function getDonacion($iddonacion)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT * FROM donacion WHERE iddonacion = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $iddonacion);
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
     * Elimina un proyecto de la base de datos
     *
     * @param $codigo El identificador del proyecto a eliminar
     */

    public function eliminarBien($id)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("DELETE FROM bien WHERE idbien = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $id);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*
     * Elimina un proyecto de la base de datos
     *
     * @param $codigo El identificador del proyecto a eliminar
     */

    public function eliminarComodato($idcomodato)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("DELETE FROM comodato WHERE idcomodato = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $idcomodato);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*
     * Elimina un proyecto de la base de datos
     *
     * @param $codigo El identificador del proyecto a eliminar
     */

    public function eliminarDonacion($iddonacion)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("DELETE FROM donacion WHERE iddonacion = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $iddonacion);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*     * ***********************************************************************************************************************************************************
     * Extrae el Valor actual de la cantidad de la especie
     *
     * @param
     */

    public function getDescargoTotal($idespecie, $fechaini, $fechafin)
    {
        $stmt = self::$conn->prepare("SELECT sum(cantidad) as descargo from descargo where especie = ? AND fecha between ? and ?");
        $stmt->bind_param('sss', $idespecie, $fechaini, $fechafin);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }

    /*     * ***********************************************************************************************************************************************************
     * comprobar si ya hay documento
     *
     * @param
     */

    public function ComprobarDoc($idbien)
    {
        $stmt = self::$conn->prepare("SELECT documento from bien where idbien = ?");
        $stmt->bind_param('s', $idbien);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }
    /*     * ***********************************************************************************************************************************************************
     * comprobar si ya hay foto del bien
     *
     * @param
     */

     public function ComprobarFot($idbien)
     {
         $stmt = self::$conn->prepare("SELECT foto from bien where idbien = ?");
         $stmt->bind_param('s', $idbien);
         $stmt->execute();
         $result = $stmt->get_result();
         $row = $result->fetch_array(MYSQLI_ASSOC);
         return $row;
     }

    /*     * ***********************************************************************************************************************************************************
     * comprobar si ya hay facura
     *
     * @param
     */

    public function ComprobarFac($idbien)
    {
        $stmt = self::$conn->prepare("SELECT factura from bien where idbien = ?");
        $stmt->bind_param('s', $idbien);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }

    /*
     * Comprueba si el proyecto ya esta registrado
     *
     * @param $usuario El valor del campo a comprobar
     */

    public function comprobarDescargo($especie)
    {
        $query = "SELECT * FROM descargo WHERE especie = '" . $especie . "'";
        $result = self::$conn->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

     public function estadoDescargo($idbien)
    {
        $stmt = self::$conn->prepare("SELECT estado from bien where idbien = ?");
        $stmt->bind_param('s', $idbien);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }

    /*
     * Cantidad de series en existencia
     *
     * @param $usuario El valor del campo a comprobar
     */

    public function contarSeries($idespecie)
    {
        $query = "SELECT * FROM serie WHERE estado = 1 and especie = '" . $idespecie . "'"; // solo aqui
        $result = self::$conn->query($query);
        $contarserie = $result->num_rows;
        return $contarserie;
    }

    /*
     * Lista todas las ventas muebles
     *
     * @AMonzon
     */

    public function getVentas($tipo)
    {
        $query = "SELECT venta.* FROM venta INNER JOIN bien ON venta.bien_idbien= bien.idbien WHERE bien.tipo=" . $tipo;
        $result = self::$conn->query($query);
        /* array asociativo */
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /*
     * Obtiene una venta buscada por id
     *
     * @AMonzon
     */

    public function getVenta($id)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT * FROM venta WHERE idventa = ?");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('s', $id);
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
     * Agregar una nueva venta
     *
     * @AMonzon
     */

    public function agregarVenta($array)
    {
        //PREPARA LA SENTENCIA SQL

        $query = self::$conn->prepare("INSERT INTO venta( observaciones,precio,bien_idbien,documento,fecha) VALUES ( ?, ?, ?, ?,?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssss', $array["observaciones"], $array["precio"], $array["bien_idbien"], $array["documento"], $array["fecha"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
            return $tupla;
        } else {
            return $query;
        }
    }

    /*     * ***********************************************************************************************************************************************************
     * comprobar si ya hay documento en una venta
     *
     * @AMonzon
     */

    public function ComprobarDocVenta($idventa)
    {
        $stmt = self::$conn->prepare("SELECT documento from venta where idventa = ?");
        $stmt->bind_param('s', $idventa);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }

    /*     * ***********************************************************************************************************************************************************
     * Actualizar una venta
     *
     * @AMonzon
     */

    public function actualizarVenta($array)
    {
        if (isset($array["documento"]) && !empty($array["documento"])) {
            //PREPARA LA SENTENCIA SQL
            $query = self::$conn->prepare("UPDATE venta SET observaciones = ?, precio = ?, bien_idbien = ?, documento = ?, fecha = ? WHERE idventa = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('ssssss', $array["observaciones"], $array["precio"], $array["bien_idbien"], $array["documento"], $array["fecha"], $array["idventa"]);
            //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        } else {
            $query = self::$conn->prepare("UPDATE venta SET observaciones = ?, precio = ?, bien_idbien = ?, fecha = ? WHERE idventa = ?");
            //RELACIONA LOS PARAMETROS CON LA SENTENCIA
            $query->bind_param('sssss', $array["observaciones"], $array["precio"], $array["bien_idbien"], $array["fecha"], $array["idventa"]);
            //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        }
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
        }
        return $tupla;
    }

    /*

      /*************************************************************************************************************************************************************
     * Obteniene las ventas realizados en un periodo de tiempo
     * @Amonzon
     *
     * @param
     */

    public function getVentasByDates($fechaini, $fechafin, $tipoBien)
    {
        //PREPARA LA SENTENCIA SQL
        $query = " SELECT venta.*, bien.descripcion, bien.codigo FROM venta INNER JOIN bien ON venta.bien_idbien= bien.idbien WHERE bien.tipo=" . $tipoBien . " AND venta.fecha between '" . $fechaini . "' and '" . $fechafin . "'";
        $result = self::$conn->query($query);
        /* array asociativo */
        $rows = null;
        if ($result != null) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        } else {
            $rows = null;
        }

        return $rows;
    }

    /*

      /*************************************************************************************************************************************************************
     * Obteniene los descargo realizados en un periodo de tiempo
     * @Amonzon
     *
     * @param
     */

    public function getComodatosByDates($fechaini, $fechafin, $tipoBien)
    {
        //PREPARA LA SENTENCIA SQL
        $query = " SELECT comodato.*, bien.descripcion, bien.codigo,bien.valor FROM comodato INNER JOIN bien ON comodato.bien= bien.idbien WHERE bien.tipo=" . $tipoBien . " AND comodato.fecha between '" . $fechaini . "' and '" . $fechafin . "'";
        $result = self::$conn->query($query);
        /* array asociativo */
        $rows = null;
        if ($result != null) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        } else {
            $rows = null;
        }

        return $rows;
    }

    /*     * ***********************************************************************************************************************************************************
     * Obteniene los descargo realizados en un periodo de tiempo
     *
     *
     * @Amonzon
     */

    public function getDescargosByDates($fechaini, $fechafin, $tipoBien)
    {
        //PREPARA LA SENTENCIA SQL
        $query = " SELECT descargo.*, bien.descripcion, bien.codigo FROM descargo INNER JOIN bien ON descargo.bien= bien.idbien WHERE bien.tipo=" . $tipoBien . " AND descargo.fechadescargo between '" . $fechaini . "' and '" . $fechafin . "'";
        $result = self::$conn->query($query);
        $rows = null;
        /* array asociativo */
        if ($result != null) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        } else {
            $rows = null;
        }

        return $rows;
    }

    
    /*     * ***********************************************************************************************************************************************************
     * Obteniene las donaciones realizados en un periodo de tiempo
     *
     *
     * @Amonzon
     */

    public function getDonacionesByDates($fechaini, $fechafin, $tipoBien)
    {
        //PREPARA LA SENTENCIA SQL
        $query = " SELECT donacion.*, bien.descripcion, bien.codigo FROM donacion INNER JOIN bien ON donacion.bien= bien.idbien WHERE bien.tipo=" . $tipoBien . " AND donacion.fecha between '" . $fechaini . "' and '" . $fechafin . "'";
        $result = self::$conn->query($query);
        /* array asociativo */
        $rows = null;
        if ($result != null) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        } else {
            $rows = null;
        }

        return $rows;
    }
    public function getReevaluosByDates($fechaini, $fechafin, $tipoBien)
    {
        //PREPARA LA SENTENCIA SQL
        $query = " SELECT valuos.*, bien.valor, bien.descripcion, bien.codigo FROM valuos INNER JOIN bien ON valuos.bien= bien.idbien WHERE bien.tipo=" . $tipoBien . " AND valuos.fecha between '" . $fechaini . "' and '" . $fechafin . "'";
        $result = self::$conn->query($query);
        $rows = null;
        /* array asociativo */
        if ($result != null) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        } else {
            $rows = null;
        }

        return $rows;
    }


    /*
     * Agregar  un nuevo reevaluo
     *
     * @AMonzon
     */

    public function agregarReevaluo($array)
    {
        //PREPARA LA SENTENCIA SQL

        $query = self::$conn->prepare("INSERT INTO valuos( observaciones,valornuevo,bien,documento,fecha) VALUES ( ?, ?, ?, ?,?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssss', $array["observaciones"], $array["valornuevo"], $array["bien"], $array["documento"], $array["fecha"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
            return $tupla;
        } else {
            return $query;
        }
    }

    /*
     * Obtiene los reevaluos para un bien
     *
     * @Amonzon
     */

    public function getReevaluobyBien($idBien, $tipo)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("SELECT valuos.* FROM `valuos` INNER JOIN bien ON bien.idbien = valuos.bien WHERE (valuos.bien=?) AND (bien.tipo=?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('ss', $idBien, $tipo);

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
     * Obtiene los valores calculados para el reporte por bien de inventario
     *
     * @Amonzon
     */


    public function getCalculosReevaluo($ValorEscritura, $ValorReevaluo, $ValorRegistrado, $ValorEdificaciones)
    {

        $ReevaluoMenos = "";
        $Superarios = "";
        $Vregistrado="";
        if ($ValorEscritura != 0 && $ValorReevaluo != 0 && $ValorEscritura != null && $ValorReevaluo != null) {
            $Resultado = $ValorEscritura - $ValorReevaluo;
           
          
            if ($Resultado > $ValorEscritura) {
                $ReevaluoMenos = '$'.$Resultado;
                $Superarios =null;
            } else {
                $ReevaluoMenos = null;
                $Superarios = '$'.($ValorReevaluo - $ValorEscritura);
            }
        } else {
            $ReevaluoMenos = null;
            $Superarios = null;
        }
        //Obteniendo el valor de Valor registrado
        if ($ValorRegistrado != 0  && $ValorRegistrado != null) {
            if ($ValorReevaluo != 0  && $ValorReevaluo != null) {
            
            if ($ValorRegistrado >$ValorReevaluo) {
                $Vregistrado= $ValorRegistrado;
            } else {
                $Vregistrado = $ValorReevaluo;
            }
        }else {
            $Vregistrado= $ValorRegistrado;
        }
        }  else{
            $Vregistrado = 0.00;
        }

        if($ValorEdificaciones !=0 && $ValorEdificaciones !=null){

            $sumatoria = $ValorEdificaciones +$Vregistrado;
        }else{
            $sumatoria = $Vregistrado;
        }



        $array = [
            "ReevaluoMenos" => $ReevaluoMenos,
            "Superarios" => $Superarios,
            "Vregistrado" => $Vregistrado,
            "sumatoria" => $sumatoria
        ];

        return $array;
    }

        /*
     *   Recupera todos los muebles mayores a 900
     *
     */

    public function getMueblesMay900()
    {
        $query = "SELECT * FROM bien where (tipo =1) AND (estado=1) AND (valor >=600) order by fechacompra DESC";
        $result = self::$conn->query($query);
        /* array asociativo */
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

       /*
     *   Recupera todos los muebles menores a 900
     *
     */

    public function getMueblesMen900()
    {
        $query = "SELECT * FROM bien where (tipo =1) AND (estado=1) AND (valor < 600)  order by fechacompra DESC";
        $result = self::$conn->query($query);
        /* array asociativo */
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }
     /*
     * Agrega el historial de la depreciacion cada vez q se genera el reporte!
     */

    public function addhistorialda($array)
    {
        //PREPARA LA SENTENCIA SQL
        $query = self::$conn->prepare("INSERT INTO historialda(bien, vallibros, depanual, depacumulada, anio) VALUES (?, ?, ?, ?, ?)");
        //RELACIONA LOS PARAMETROS CON LA SENTENCIA
        $query->bind_param('sssss', $array["bien"], $array["vallibros"], $array["depanual"], $array["depacumulada"], $array["anio"]);
        //EJECUTA LA SENTENCIA Y DEVUELVE EL RESULTADO, FALSE SI FALLA
        $tupla = $query->execute();
        if (!$tupla) {
            $msj = 'Execute failed: (' . $query->errno . ') ' . $query->error;
            fb($msj, FirePHP::TRACE); //mensaje a enviar a consola en caso de error
            return $tupla;
        } else {
            return $query;
        }
    }
    
      /*
 * Obtiene las sustituciones
 */
 public function getHistorialDa($anio) {
  $result = self::$conn->query("SELECT * FROM historialda where anio =  '".$anio."' and depanual > 0 order by bien asc");
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
  }
  return $rows;
  }

}

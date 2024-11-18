<?php
/**
 * Clase para la conexion a la DB por medio de mysqli
 * se realiza por medio de variables estaticas y protegidas para mayor seguridad 
 */
class conexion extends mysqli {
    protected static $instance;
    protected static $options = array();


    private function __construct() {
        $o = self::$options;
        parent::__construct(isset($o['host'])   ? $o['host']   : '127.0.0.1',
                             isset($o['user'])   ? $o['user']   : 'root',
                             isset($o['pass'])   ? $o['pass']   : 'giovax',
                             isset($o['dbname']) ? $o['dbname'] : 'activo' );

        // Verifica que se haya establecido la conexion
        if( mysqli_connect_errno() ) {
            throw new exception(mysqli_connect_error(), mysqli_connect_errno()); 
        }
    }

    //devolver la instancia de conexion   
    public static function getInstance() {
        if( !self::$instance ) {
            self::$instance = new self(); 
            self::$instance->set_charset("utf8");
        }
        return self::$instance;
    }

    //cambiar las opciones de la conexion
    public static function setOptions( array $opt ) {
        self::$options = array_merge(self::$options, $opt);
    }
    
    //cerrar la conexion
    public function close() {
      self::$instance->close();
    }
    
    //evitar clonacion de la instancia
    public function __clone() {
      throw new Exception("Can't clone a singleton");
      getConfigData();
    }
}

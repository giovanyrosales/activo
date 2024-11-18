<?php

/*
 * 2016 Hecho por Giovany Rosales.
 */

/**
 * Description of Replace_modelo
 *
 * @author MauricioG
 */
/*
* CLASE PARA EL MANEJO DE FUNCIONES ESPECIFICAS
*/
require_once "../modelo/conexiondb.php";

class Replace extends conexion {
    private static $conn = null;
 
 /*
 *   Contructor de la clase
 */
public function __construct() {
   self::$conn = parent::getInstance();
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
}
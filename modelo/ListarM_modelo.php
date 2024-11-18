<?php //error_reporting (0);
?>
<?php
/* 
 * 2016 Hecho por Giovany Rosales.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. */

// PDO connect *********
function connect()
{
	return new PDO('mysql:host=localhost;dbname=activo', 'root', 'giovax', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
if (isset($_GET["traslado"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	$tipo = $_POST['tipo'];
	$sql = "SELECT * FROM bien WHERE descripcion LIKE (:keyword) AND tipo = '" . $tipo . "' ORDER BY idbien ASC LIMIT 0, 20";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		$deptoenvia = $rs["departamento"];
		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'' . ',' . $deptoenvia . '); ">' . $descripcion . '</li>';
	}
}
if (isset($_GET["comodato"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	$sql = "SELECT * FROM bien WHERE  (estado = 1) AND (descripcion LIKE (:keyword) OR codigo LIKE (:keyword)) ORDER BY idbien ASC LIMIT 0, 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'); ">' . $descripcion . '</li>';
	}
}
if (isset($_GET["sustitucion"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	$sql = "SELECT * FROM bien WHERE  (estado = 1) AND (descripcion LIKE (:keyword) OR codigo LIKE (:keyword)) ORDER BY idbien ASC LIMIT 0, 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'); ">' . $descripcion . '</li>';
	}
}
if (isset($_GET["descargo"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	$sql = "SELECT * FROM bien WHERE (estado = 1) AND (descripcion LIKE (:keyword) OR codigo LIKE (:keyword)) ORDER BY idbien ASC LIMIT 0, 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		$valor = $rs["valor"];

		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'' . ',' . $valor . '); ">' . $descripcion . '</li>';
	}
}
if (isset($_GET["venta"]) == 1 && isset($_GET["tipo"])) {
	$pdo = connect();
	$tipo = $_GET["tipo"];
	$keyword = '%' . $_POST['keyword'] . '%';
	$sql = "SELECT * FROM bien WHERE  (tipo=".$tipo." ) AND (estado = 2) AND (descripcion LIKE (:keyword) OR codigo LIKE (:keyword))  ORDER BY idbien ASC LIMIT 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	
	foreach ($list as $rs) {
		// put in bold the written text 
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		$valor = $rs["valor"];

		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'' . ',' . $valor . '); ">' . $descripcion . '</li>';
	}
} else if (isset($_GET["retiros"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	$tipomaterial = $_POST['tipo'];
	$trid = $_POST['id'];
	$sql = "SELECT * FROM materiales WHERE nombre LIKE (:keyword) AND tipomaterial = '" . $tipomaterial . "' ORDER BY idmateriales ASC LIMIT 0, 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$country_name = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['nombre']);
		// add new option
		echo '<li onclick="set_item(' . $trid . ',' . '\'' . str_replace("'", "\'", $rs['nombre']) . '\'); change(' . $trid . ',' . $rs['idmateriales'] . ',' . $rs['cantidad'] . ');">' . $country_name . '</li>';
	}
}
if (isset($_GET["donacion"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	
	$sql = "SELECT * FROM bien WHERE  (estado = 2) AND (descripcion LIKE (:keyword) OR codigo LIKE (:keyword)) ORDER BY idbien ASC LIMIT 0, 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'); ">' . $descripcion . '</li>';
	}
}
if (isset($_GET["reevaluo"]) == 1) {
	$pdo = connect();
	$keyword = '%' . $_POST['keyword'] . '%';
	$sql = "SELECT * FROM bien WHERE   (estado = 1) AND (descripcion LIKE (:keyword) OR codigo LIKE (:keyword)) ORDER BY idbien ASC LIMIT 0, 10";
	$query = $pdo->prepare($sql);
	$query->bindParam(':keyword', $keyword,  PDO::PARAM_STR);
	$query->execute();
	$list = $query->fetchAll();
	foreach ($list as $rs) {
		// put in bold the written text
		$descripcion = str_replace($_POST['keyword'], '<b>' . $_POST['keyword'] . '</b>', $rs['descripcion']);
		$valor = $rs["valor"];
		

		// add new option
		echo '<li onclick="set_item(' . str_replace("'", "\'", $rs['idbien']) . ',' . '\'' . str_replace("'", "\'", $rs['descripcion']) . '\'' . ',' . $valor .  ',' . $valor . '); ">' . $descripcion . '</li>';
	}
}

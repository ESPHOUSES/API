<?php
/**
 *
 * @author    Lukas Lazauskas <lukas@esphouses.com>
 * @copyright 2021 ESPHOUSES
 * @license   All rights reserved
 * @version   1.0
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//header('Content-type: text/html; charset=utf-8');
setlocale(LC_ALL, "es_ES");
date_default_timezone_set('Europe/Madrid');
ini_set('max_execution_time', 0);


require_once '/home/esphouse/crmesphouses.com/src/configuration.php';
include_once '/home/esphouse/crmesphouses.com/src/Property/Property.php';

try {

	//Creamos la clase Usuario
	$User = new Users;

	//Comprobamos que nos hayan pasado el nombre de usuario
	if (isset($_POST['userId'])) {
		//Lo asignamos a la clase
		$User->__set('id', $_POST['userId']);
	} else {
		//Devolvemos excepcion
		throw new Exception('userId not recieved');
	}


	//Comprobamos que nos hayan pasado el accessKey
	if (isset($_POST['sessionId'])) {
		//Probamos a recoger los datos del Usuario con la sessionId
		if (!$User->retrieveViaId($_POST['sessionId'])) {
			//Devolvemos excepcion
			throw new Exception('sessionId not works');
		}
	} else {
		//Devolvemos excepcion
		throw new Exception('sessionId not recieved');
	}


} catch (Exception $error) {
	$result = [
		'success' => FALSE,
		'message' => $error->getMessage(),
		'data' => NULL,
	];
} finally {
	header("HTTP/1.1 " . ($result['success'] ? '200' : '500') . " " . $result['message']);
	echo json_encode($result);
}
?>
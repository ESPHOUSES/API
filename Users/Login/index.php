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
setlocale(LC_ALL, "es_ES");
date_default_timezone_set('Europe/Madrid');
ini_set('max_execution_time', 0);
header('Content-type: text/json; charset=utf-8');

require_once '/home/esphouse/crmesphouses.com/src/configuration.php';
require_once '/home/esphouse/crmesphouses.com/src/Users/Users.php';

try {

	//Creamos la clase Usuario
	$User = new Users;

	//Comprobamos que nos hayan pasado el accessKey
	if (isset($_GET['accessKey'])) {
		//Lo asignamos a la clase
		$User->__set('accesskey', $_GET['accessKey']);
	} else {
		//Devolvemos excepcion
		throw new Exception('accessKey not recieved');
	}

	//Comprobamos que nos hayan pasado el nombre de usuario
	if (isset($_GET['userName'])) {
		//Lo asignamos a la clase
		$User->__set('user_name', $_GET['userName']);
	} else {
		//Devolvemos excepcion
		throw new Exception('userName not recieved');
	}

	//Probamos a hacer login
	if (!$User->login(FALSE)) {
		//Devolvemos excepcion
		throw new Exception('Cannot login');
	} else {
		//Recogemos los datos del usuario para comprobar que el sessionId funcione
		if ($User->retrieveViaId($User->__get('sessionId'))) {
			$result = [
				'success' => TRUE,
				'message' => 'Logged',
				'data' => [
					'id' => $User->__get('id'),
					'sessionId' => $User->__get('sessionId'),
				],
			];
		} else {
			//Devolvemos excepcion
			throw new Exception('SessionId not works');
		}
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

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

	if (isset($_POST['sessionId'])) {
		//Lo asignamos
		$sessionId = $_POST['sessionId'];
	} else {
		//Devolvemos excepcion
		throw new Exception('sessionId not recieved');
	}

	if (isset($_POST['propertyData'])) {
		//Lo asignamos
		$propertyData = json_decode($_POST['propertyData'], TRUE);
	} else {
		//Devolvemos excepcion
		throw new Exception('propertyData not recieved');
	}

	$Property = new Property;

	foreach ($propertyData as $key => $value) {
		$Property->__set($key, $value);
	}

	if ($Property->save($sessionId)) {
		$result = [
			'success' => TRUE,
			'message' => 'Saved',
			'result' => $Property->data,
		];
	} else {
		throw new Exception('Property not saved');
	}

} catch (Exception $error) {
	$result = [
		'success' => FALSE,
		'message' => $error->getMessage(),
		'result' => NULL,
	];
} finally {
	header("HTTP/1.1 " . ($result['success'] ? '200' : '500') . " " . $result['message']);
	echo json_encode($result);
}
?>
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
include_once '/home/esphouse/crmesphouses.com/src/Contacts/Contacts.php';

try {

	if (isset($_POST['sessionId'])) {
		//Lo asignamos
		$sessionId = $_POST['sessionId'];
	} else {
		//Devolvemos excepcion
		throw new Exception('sessionId not recieved');
	}

	if (isset($_POST['contactData'])) {
		//Lo asignamos
		$contactData = json_decode($_POST['contactData'], TRUE);
	} else {
		//Devolvemos excepcion
		throw new Exception('contactData not recieved');
	}

	$Contact = new Contacts;

	foreach ($contactData as $key => $value) {
		$Contact->__set($key, $value);
	}

	if ($Contact->save($sessionId)) {
		$result = [
			'success' => TRUE,
			'message' => 'Saved',
			'result' => $Contact->data,
		];
	} else {
		throw new Exception('Contact not saved');
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
}?>
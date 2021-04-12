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
//header('Content-type: text/html; charset=utf-8');


require_once '/home/esphouse/crmesphouses.com/src/configuration.php';
require_once '/home/esphouse/crmesphouses.com/src/Users/Users.php';

$User = new Users;

if (isset($_GET['accessKey'])){
	$User->__set('accesskey', $_GET['accessKey']);
}else{
	die();
}

if (isset($_GET['user_name'])){
	$User->__set('user_name', $_GET['user_name']);
}else{
	die();
}

//Get Challenge

//LOGIN

if (!$User->login(false))
	exit('Invalid AUTH BOT');

$User->retrieveViaId($User->__get('sessionId'));
echo $User;
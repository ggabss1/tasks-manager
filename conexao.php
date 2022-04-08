<?php
$host = "host=localhost";
	$port = "port=5432";
	$dbname = "dbname=task-manager";
	$user = "user=postgres";
	$password = "password=Nucleo@2021";
$connect = pg_connect("$host $port $dbname $user $password");
// function exception_error_handler($errno, $errstr, $errfile, $errline ) {
//     throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
// }
// set_error_handler("exception_error_handler");

// try {
// 	$connect = pg_connect("$host $port $dbname $user $password");
// } Catch (Exception $e) {
//     Echo 'ERRO:'.$e->getMessage();
// }
?>
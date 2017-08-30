<?php
require_once '..\vendor\autoload.php';
require_once 'database_config.php';


$loader = new Twig_Loader_Filesystem('..\html');
$twig = new Twig_Environment($loader);
$myErrors = new \exceptions\ExceptionHandler();

set_exception_handler(array($myErrors, 'handle'));

$conn = \database\DbConnection::getInstance();

if (DATABASE_IN_USE == 'mysql') {
	$base = $conn->connectMySql();
	$crud = new \database\ServiceMySql($base);
} elseif (DATABASE_IN_USE == 'mongodb') {
	$base = $conn->connectMongoDb();
	$crud = new \database\ServiceMongoDb($base);
} else {
	die("Not valid database is set!!!");
}

$klein = new \Klein\Klein();



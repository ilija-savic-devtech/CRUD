<?php
require_once '..\vendor\autoload.php';
require_once 'database_config.php';

$logger = new Katzgrau\KLogger\Logger('../logs');

$loader = new Twig_Loader_Filesystem('..\public\views');
$twig = new Twig_Environment($loader);

$conn = 

if (DATABASE_IN_USE == 'mysql') {
	$logger->info("MySQL database in use");
	$base = $conn->connectMySql($logger);
	$crud = new \database\ServiceMySql($base, $logger);
} elseif (DATABASE_IN_USE == 'mongodb') {
	$logger->info("MongoDB database in use");
	$base = $conn->connectMongoDb($logger);
	$crud = new \database\ServiceMongoDb($base, $logger);
} else {
	$logger->warning("Not valid database is set, check database_config.php in bootstrap folder");
	die("Not valid database is set!!!");
}

$klein = new \Klein\Klein();



<?php
require_once '..\vendor\autoload.php';
require_once 'database_config.php';

$loader = new Twig_Loader_Filesystem('..\html');
$twig = new Twig_Environment($loader);

$conn = \database\DbConnection::getInstance();
$base = null;
$crud = null;
if (DATABASE_IN_USE == 'mysql') {
	$base = $conn->connectMySql();
	$crud = new \database\CrudDatabaseMySql($base, new \src\Student());
} elseif (DATABASE_IN_USE == 'mongodb') {
	$base = $conn->connectMongoDb();
	$crud = new \database\CrudDatabaseMongoDb($base, new \src\Student());
} else {
	die("Not valid database is set!!!");
}

$klein = new \Klein\Klein();



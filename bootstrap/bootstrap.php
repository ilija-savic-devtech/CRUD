<?php
require_once '..\vendor\autoload.php';
require_once 'database_config.php';

$loader = new Twig_Loader_Filesystem('..\html');
$twig = new Twig_Environment($loader);

$conn = \database\DbConnection::getInstance();
$base = $conn->connect(new \src\Student());

$klein = new \Klein\Klein();



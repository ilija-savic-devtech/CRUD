<?php
require_once '..\vendor\autoload.php';
require_once 'database_config.php';

$conn = \database\DbConnection::getInstance();
$base = $conn->connect();
$klein = new \Klein\Klein();



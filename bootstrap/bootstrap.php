<?php
require_once '..\vendor\autoload.php';
require_once 'database_config.php';

$base = \database\DbConnection::connect();
$klein = new \Klein\Klein();



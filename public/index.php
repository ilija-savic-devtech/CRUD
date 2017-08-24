<?php
require_once '..\bootstrap\bootstrap.php';
$database = new \database\DbConnection();
$klein = new \Klein\Klein();
$base = $database->connect();

$klein->respond('/', function() use ($base){
	$var = $base->getAll();
	foreach ($var as $student){
		echo "<pre>";
		var_dump($student);
		echo "<br>";
	}

});

$klein->dispatch();


